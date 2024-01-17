<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Beca6ScholarshipProgramData;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Beca6ScholarshipProgramDataController extends Controller
{
    /**
     * Crear o Actualizar datos de Programas de Becas desde formulario beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function createOrUpdateByBeca(Request $request, Response $response, Int $id = null)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $scholariship_program_data = Beca6ScholarshipProgramData::find($id);
            if (!$scholariship_program_data) $scholariship_program_data = new Beca6ScholarshipProgramData();

            $scholariship_program_data->b6_beca_id = $request->b6_beca_id;
            $scholariship_program_data->b6_beca_transport = $request->b6_beca_transport;
            $scholariship_program_data->b6_beca_benito_juarez = $request->b6_beca_benito_juarez;
            $scholariship_program_data->b6_beca_jovenes = $request->b6_beca_jovenes;
            $scholariship_program_data->b6_other = $request->b6_other;
            $scholariship_program_data->b6_finished = $request->b6_finished;

            $scholariship_program_data->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $id > 0 ? 'peticion satisfactoria | datos de Programas de Becas editados.' : 'satisfactoria | datos de Programas de Becas registrados.';
            $response->data["alert_text"] = $id > 0 ? 'Datos de Programas de Becas editados' : 'Datos de Programas de Becas registrados';
            $response->data["result"] = $scholariship_program_data;
            // return $scholariship_program_data;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar datos de Programas de Becas por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
            // return $msg;
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function _createOrUpdateByBeca($request, $beca_id = null)
    {
        try {
            $scholariship_program_data = Beca6ScholarshipProgramData::where("b6_beca_id", $beca_id)->first();
            if (!$scholariship_program_data) $scholariship_program_data = new Beca6ScholarshipProgramData();
            // return $scholariship_program_data;

            $scholariship_program_data->b6_beca_id = $beca_id;
            $scholariship_program_data->b6_beca_transport = $request->b6_beca_transport;
            $scholariship_program_data->b6_beca_benito_juarez = $request->b6_beca_benito_juarez;
            $scholariship_program_data->b6_beca_jovenes = $request->b6_beca_jovenes;
            $scholariship_program_data->b6_other = $request->b6_other;
            $scholariship_program_data->b6_finished = $request->b6_finished;

            $scholariship_program_data->save();

            // return $scholariship_program_data;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar datos de Programas de Becas por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            return $msg;
        }
    }


    /**
     * Eliminar datos de Programas de Becas o datos de Programas de Becas.
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
            Beca6ScholarshipProgramData::whereIn('id', $request->ids)->delete();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | datos de Programas de Becas eliminados ($countDeleted).";
            $response->data["alert_text"] = "Datos de Programas de Becas eliminados  ($countDeleted)";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }






    /**
     * Mostrar lista de datos de Programas de Becas activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Beca6ScholarshipProgramData::where('beca_6_scholariship_program_data.active', true)
                ->orderBy('beca_6_scholariship_program_data.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de datos de Programas de Becas.';
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
            $list = Beca6ScholarshipProgramData::where('beca_6_scholariship_program_data.active', true)
                ->select('beca_6_scholariship_program_data.id as id', 'beca_6_scholariship_program_data.b6_beca_id as label')
                ->orderBy('beca_6_scholariship_program_data.b6_beca_id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de datos de Programas de Becas';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Mostrar datos de Programas de Becas.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $student_data = Beca6ScholarshipProgramData::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | datos de Programas de Becas encontrados.';
            $response->data["result"] = $student_data;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    /**
     * Eliminar (cambiar estado activo=false) datos de Programas de Becas.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Beca6ScholarshipProgramData::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | datos de Programas de Becas eliminados.';
            $response->data["alert_text"] = 'Datos de Programas de Becas eliminados';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}