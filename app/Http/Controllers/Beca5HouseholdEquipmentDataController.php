<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Beca5HouseholdEquipmentData;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Beca5HouseholdEquipmentDataController extends Controller
{
    /**
     * Crear o Actualizar datos del equipamiento de la casa desde formulario beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function createOrUpdateByBeca(Request $request, Response $response, Int $id = null)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $household_equipment_data = Beca5HouseholdEquipmentData::find($id);
            if (!$household_equipment_data) $household_equipment_data = new Beca5HouseholdEquipmentData();

            $household_equipment_data->b5_beca_id = $request->b5_beca_id;
            $household_equipment_data->b5_beds = $request->b5_beds;
            $household_equipment_data->b5_washing_machines = $request->b5_washing_machines;
            $household_equipment_data->b5_boilers = $request->b5_boilers;
            $household_equipment_data->b5_tvs = $request->b5_tvs;
            $household_equipment_data->b5_pcs = $request->b5_pcs;
            $household_equipment_data->b5_phones = $request->b5_phones;
            $household_equipment_data->b5_music_player = $request->b5_music_player;
            $household_equipment_data->b5_stoves = $request->b5_stoves;
            $household_equipment_data->b5_refrigerators = $request->b5_refrigerators;
            $household_equipment_data->b5_drinking_water = $request->b5_drinking_water;
            $household_equipment_data->b5_electric_light = $request->b5_electric_light;
            $household_equipment_data->b5_sewer_system = $request->b5_sewer_system;
            $household_equipment_data->b5_pavement = $request->b5_pavement;
            $household_equipment_data->b5_automobile = $request->b5_automobile;
            $household_equipment_data->b5_phone_line = $request->b5_phone_line;
            $household_equipment_data->b5_internet = $request->b5_internet;
            $household_equipment_data->b5_score = $request->b5_score;
            $household_equipment_data->b5_finished = $request->b5_finished;

            $household_equipment_data->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $id > 0 ? 'peticion satisfactoria | datos del equipamiento de la casa editados.' : 'satisfactoria | datos del equipamiento de la casa registrados.';
            $response->data["alert_text"] = $id > 0 ? 'Datos del Equipamiento de la Casa editados' : 'Datos del Equipamiento de la Casa registrados';
            $response->data["result"] = $household_equipment_data;
            // return $household_equipment_data;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar datos del equipamiento de la casa por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
            // return $msg;
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function _createOrUpdateByBeca($request, $beca_id = null)
    {
        try {
            $household_equipment_data = Beca5HouseholdEquipmentData::where("b5_beca_id", $beca_id)->first();
            if (!$household_equipment_data) $household_equipment_data = new Beca5HouseholdEquipmentData();
            // return $household_equipment_data;

            $household_equipment_data->b5_beca_id = $beca_id;
            $household_equipment_data->b5_beds = $request->b5_beds;
            $household_equipment_data->b5_washing_machines = $request->b5_washing_machines;
            $household_equipment_data->b5_boilers = $request->b5_boilers;
            $household_equipment_data->b5_tvs = $request->b5_tvs;
            $household_equipment_data->b5_pcs = $request->b5_pcs;
            $household_equipment_data->b5_phones = $request->b5_phones;
            $household_equipment_data->b5_music_player = $request->b5_music_player;
            $household_equipment_data->b5_stoves = $request->b5_stoves;
            $household_equipment_data->b5_refrigerators = $request->b5_refrigerators;
            $household_equipment_data->b5_drinking_water = $request->b5_drinking_water;
            $household_equipment_data->b5_electric_light = $request->b5_electric_light;
            $household_equipment_data->b5_sewer_system = $request->b5_sewer_system;
            $household_equipment_data->b5_pavement = $request->b5_pavement;
            $household_equipment_data->b5_automobile = $request->b5_automobile;
            $household_equipment_data->b5_phone_line = $request->b5_phone_line;
            $household_equipment_data->b5_internet = $request->b5_internet;
            $household_equipment_data->b5_score = $request->b5_score;
            $household_equipment_data->b5_finished = $request->b5_finished;

            $household_equipment_data->save();

            // return $household_equipment_data;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar datos del equipamiento de la casa por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            return $msg;
        }
    }


    /**
     * Eliminar datos del equipamiento de la casa o datos del equipamiento de la casa.
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
            Beca5HouseholdEquipmentData::whereIn('id', $request->ids)->delete();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | datos del equipamiento de la casa eliminados ($countDeleted).";
            $response->data["alert_text"] = "Datos del Equipamiento de la Casa eliminados  ($countDeleted)";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }






    /**
     * Mostrar lista de datos del equipamiento de la casa activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Beca5HouseholdEquipmentData::where('beca_5_household_equipment_data.active', true)
                ->orderBy('beca_5_household_equipment_data.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de datos del equipamiento de la casa.';
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
            $list = Beca5HouseholdEquipmentData::where('beca_5_household_equipment_data.active', true)
                ->select('beca_5_household_equipment_data.id as id', 'beca_5_household_equipment_data.b5_beca_id as label')
                ->orderBy('beca_5_household_equipment_data.b5_beca_id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de datos del equipamiento de la casa';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Mostrar datos del equipamiento de la casa.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $student_data = Beca5HouseholdEquipmentData::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | datos del equipamiento de la casa encontrados.';
            $response->data["result"] = $student_data;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    /**
     * Eliminar (cambiar estado activo=false) datos del equipamiento de la casa.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Beca5HouseholdEquipmentData::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | datos del equipamiento de la casa eliminados.';
            $response->data["alert_text"] = 'Datos del Equipamiento de la Casa eliminados';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
