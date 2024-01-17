<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Beca3EconomicData;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Beca3EconomicDataController extends Controller
{
    /**
     * Crear o Actualizar datos economicos desde formulario beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function createOrUpdateByBeca(Request $request, Response $response, Int $id = null)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $economic_data = Beca3EconomicData::find($id);
            if (!$economic_data) $economic_data = new Beca3EconomicData();

            $economic_data->b3_beca_id = $request->b3_beca_id;
            $economic_data->b3_food = $request->b3_food;
            $economic_data->b3_transport = $request->b3_transport;
            $economic_data->b3_living_place = $request->b3_living_place;
            $economic_data->b3_services = $request->b3_services;
            $economic_data->b3_automobile = $request->b3_automobile;
            $economic_data->b3_finished = $request->b3_finished;

            $economic_data->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $id > 0 ? 'peticion satisfactoria | datos economicos editados.' : 'satisfactoria | datos economicos registrados.';
            $response->data["alert_text"] = $id > 0 ? 'Datos Económicos editados' : 'Datos Económicos registrados';
            $response->data["result"] = $economic_data;
            // return $economic_data;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar datos economicos por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
            // return $msg;
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function _createOrUpdateByBeca($request, $beca_id = null)
    {
        try {
            $economic_data = Beca3EconomicData::where("b3_beca_id", $beca_id)->first();
            if (!$economic_data) $economic_data = new Beca3EconomicData();

            $economic_data->b3_beca_id = $beca_id;
            $economic_data->b3_food = $request->b3_food;
            $economic_data->b3_transport = $request->b3_transport;
            $economic_data->b3_living_place = $request->b3_living_place;
            $economic_data->b3_services = $request->b3_services;
            $economic_data->b3_automobile = $request->b3_automobile;
            $economic_data->b3_finished = $request->b3_finished;

            $economic_data->save();

            // return $economic_data;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar datos economicos por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            return $msg;
        }
    }


    /**
     * Eliminar datos economicos o datos economicos.
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
            Beca3EconomicData::whereIn('id', $request->ids)->delete();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | datos economicos eliminados ($countDeleted).";
            $response->data["alert_text"] = "Datos Económicos eliminados  ($countDeleted)";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }






    /**
     * Mostrar lista de datos economicos activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Beca3EconomicData::where('beca_3_economic_data.active', true)
                ->orderBy('beca_3_economic_data.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de datos economicos.';
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
            $list = Beca3EconomicData::where('beca_3_economic_data.active', true)
                ->select('beca_3_economic_data.id as id', 'beca_3_economic_data.b3_beca_id as label')
                ->orderBy('beca_3_economic_data.b3_beca_id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de datos economicos';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Mostrar datos economicos.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $student_data = Beca3EconomicData::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | datos economicos encontrados.';
            $response->data["result"] = $student_data;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    /**
     * Eliminar (cambiar estado activo=false) datos economicos.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Beca3EconomicData::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | datos economicos eliminados.';
            $response->data["alert_text"] = 'Datos Económicos eliminados';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
