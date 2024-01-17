<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Beca2FamilyData;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Beca2FamilyDataController extends Controller
{
    /**
     * Crear o Actualizar familiar desde formulario beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function createOrUpdateByBeca(Request $request, Response $response, Int $id = null)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $famility_data = Beca2FamilyData::find($id);
            if (!$famility_data) $famility_data = new Beca2FamilyData();

            $famility_data->beca_id = $request->beca_id;
            $famility_data->relationship = $request->relationship;
            $famility_data->age = $request->age;
            $famility_data->occupation = $request->occupation;
            $famility_data->monthly_income = $request->monthly_income;

            $famility_data->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $id > 0 ? 'peticion satisfactoria | familiar editado.' : 'satisfactoria | familiar registrado.';
            $response->data["alert_text"] = $id > 0 ? 'Familiar editado' : 'Familiar registrado';
            $response->data["result"] = $famility_data;
            // return $famility_data;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar familiar por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
            // return $msg;
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar lista de familiares por beca activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function getIndexByBeca(Int $beca_id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Beca2FamilyData::where('beca_2_family_data.active', true)->where('beca_2_family_data.beca_id', $beca_id)
                ->orderBy('beca_2_family_data.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de familiares por beca.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $msg =  "Error en getIndexByBeca: " . $ex->getMessage();
            error_log("$msg");
            $response->data = ObjResponse::CatchResponse($msg);
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar lista de familiares por folio activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function getIndexByFolio(Int $folio, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $becaController = new BecaController();
            $beca = $becaController->_getBecaByFolio($folio);

            $this->getIndexByBeca($beca->id, $response);

            // $list = Beca2FamilyData::where('beca_2_family_data.active', true)->where('beca_2_family_data.beca_id', $beca_id)
            //     ->orderBy('beca_2_family_data.id', 'desc')->get();
            // $response->data = ObjResponse::CorrectResponse();
            // $response->data["message"] = 'Peticion satisfactoria | Lista de familiares por beca.';
            // $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $msg =  "Error en getIndexByFolio: " . $ex->getMessage();
            error_log("$msg");
            $response->data = ObjResponse::CatchResponse($msg);
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar familiar o familiares.
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
            Beca2FamilyData::whereIn('id', $request->ids)->delete();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $countDeleted == 1 ? 'peticion satisfactoria | familiar eliminado.' : "peticion satisfactoria | familiares eliminados ($countDeleted).";
            $response->data["alert_text"] = $countDeleted == 1 ? 'Familiar eliminado' : "Familiares eliminados  ($countDeleted)";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }






    /**
     * Mostrar lista de familiares activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Beca2FamilyData::where('beca_2_family_data.active', true)
                ->orderBy('beca_2_family_data.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de familiares.';
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
            $list = Beca2FamilyData::where('beca_2_family_data.active', true)
                ->select('beca_2_family_data.id as id', 'beca_2_family_data.relationship as label')
                ->orderBy('beca_2_family_data.relationship', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de familiares';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Mostrar familiar.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            // $field = 'beca_2_family_data.id';
            // $value = $request->id;
            // if ($request->curp) {
            //     $field = 'beca_2_family_data.curp';
            //     $value = $request->curp;
            // }

            $student_data = Beca2FamilyData::find($request->id);
            // $student_data = Beca2FamilyData::where("$field", "$value")
            //     ->join('disabilities', 'beca_2_family_data.disability_id', '=', 'disabilities.id')
            //     ->select('beca_2_family_data.*', 'disabilities.disability', 'disabilities.description')
            //     ->first();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | familiar encontrada.';
            $response->data["result"] = $student_data;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    /**
     * Eliminar (cambiar estado activo=false) familiar.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Beca2FamilyData::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | familiar eliminado.';
            $response->data["alert_text"] = 'Familiar eliminado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
