<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cycle;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CycleController extends Controller
{
    /**
     * Mostrar lista de ciclos activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Cycle::where('cycles.active', true)
                ->orderBy('cycles.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de ciclos.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar listado para un selector.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function selectIndex(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Cycle::where('cycles.active', true)
                ->select('cycles.id as id', 'cycles.cycle_name as label')
                ->orderBy('cycles.cycle_name', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de ciclos';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear o Actualizar ciclos desde formulario beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function createOrUpdate(Request $request, Response $response, Int $id = null, bool $internal = false)
    {
        try {
            $response->data = ObjResponse::DefaultResponse();

            $cycle = Cycle::find($id);
            if (!$cycle) $cycle = new Cycle();

            $cycle->fill($request->all());

            $cycle->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $id > 0 ? "satisfactoria | ciclos actualizados" : 'satisfactoria | ciclos registrados.';
            $response->data["alert_text"] = $id > 0 ? "Ajustes actualizados" : "Ajustes registrados";
            $response->data["result"] = $cycle;
            if (!$internal) return response()->json($response, $response->data["status_code"]);
            else return $cycle;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar ciclos por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
            if (!$internal) return response()->json($response, $response->data["status_code"]);
            else return "$msg";
        }
    }

    /**
     * Eliminar ciclos o ciclos.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function delete(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            // echo "$request->ids";
            // $deleteIds = explode(',', $ids);
            $countDeleted = sizeof($request->ids);
            Cycle::whereIn('id', $request->ids)->delete();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | ciclos eliminados ($countDeleted).";
            $response->data["alert_text"] = "Documentos de Becas eliminados  ($countDeleted)";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    /**
     * Mostrar ciclo.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $cycle = Cycle::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | ciclo encontrado.';
            $response->data["result"] = $cycle;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    /**
     * Eliminar (cambiar estado activo=false) ciclo.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Cycle::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | ciclo eliminado.';
            $response->data["alert_text"] = 'Documentos de Becas eliminados';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar ciclo actual.
     *
     * @param   int $id
     * @return \Illuminate\Http\Response $response
     */
    public function getCurrent(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $today = date('Y-m-d');
            $cycle = Cycle::where('active', true)->where("start_date", "<=", $today)->where("closing_date", ">=", $today)->orderBy('id', 'desc')->first();
            // echo $cycle->toSql();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | ciclo actual.';
            $response->data["result"] = $cycle;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}