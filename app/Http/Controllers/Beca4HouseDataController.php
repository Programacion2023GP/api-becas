<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Beca4HouseData;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Beca4HouseDataController extends Controller
{
    /**
     * Crear o Actualizar datos de la casa desde formulario beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function createOrUpdateByBeca(Request $request, Response $response, Int $id = null)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $house_data = Beca4HouseData::find($id);
            if (!$house_data) $house_data = new Beca4HouseData();

            $house_data->b4_beca_id = $request->b4_beca_id;
            $house_data->b4_house_is = $request->b4_house_is;
            $house_data->b4_roof_material = $request->b4_roof_material;
            $house_data->b4_floor_material = $request->b4_floor_material;
            $house_data->b4_score = $request->b4_score;
            $house_data->b4_finished = $request->b4_finished;

            $house_data->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $id > 0 ? 'peticion satisfactoria | datos de la casa editados.' : 'satisfactoria | datos de la casa registrados.';
            $response->data["alert_text"] = $id > 0 ? 'Datos de la Casa editados' : 'Datos de la Casa registrados';
            $response->data["result"] = $house_data;
            // return $house_data;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar datos de la casa por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
            // return $msg;
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function _createOrUpdateByBeca($request, $beca_id = null)
    {
        try {
            $house_data = Beca4HouseData::where("b4_beca_id", $beca_id)->first();
            if (!$house_data) $house_data = new Beca4HouseData();

            $house_data->b4_beca_id = $beca_id;
            $house_data->b4_house_is = $request->b4_house_is;
            $house_data->b4_roof_material = $request->b4_roof_material;
            $house_data->b4_floor_material = $request->b4_floor_material;
            $house_data->b4_score = $request->b4_score;
            $house_data->b4_finished = $request->b4_finished;

            $house_data->save();

            // return $house_data;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar datos de la casa por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            return $msg;
        }
    }


    /**
     * Eliminar datos de la casa o datos de la casa.
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
            Beca4HouseData::whereIn('id', $request->ids)->delete();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | datos de la casa eliminados ($countDeleted).";
            $response->data["alert_text"] = "Datos de la Casa eliminados  ($countDeleted)";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }






    /**
     * Mostrar lista de datos de la casa activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Beca4HouseData::where('beca_4_house_data.active', true)
                ->orderBy('beca_4_house_data.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de datos de la casa.';
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
            $list = Beca4HouseData::where('beca_4_house_data.active', true)
                ->select('beca_4_house_data.id as id', 'beca_4_house_data.b4_beca_id as label')
                ->orderBy('beca_4_house_data.b4_beca_id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de datos de la casa';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Mostrar datos de la casa.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $student_data = Beca4HouseData::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | datos de la casa encontrados.';
            $response->data["result"] = $student_data;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    /**
     * Eliminar (cambiar estado activo=false) datos de la casa.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Beca4HouseData::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | datos de la casa eliminados.';
            $response->data["alert_text"] = 'Datos de la Casa eliminados';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
