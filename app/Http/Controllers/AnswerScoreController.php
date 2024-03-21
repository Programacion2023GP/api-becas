<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnswerScore;
use App\Models\ObjResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AnswerScoreController extends Controller
{
    /**
     * Mostrar lista de respuestas y puntajes activas
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = AnswerScore::all();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | lista de respuestas y puntajes.';
            $response->data["alert_text"] = "Respuestas y Puntajes encontrados";
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar listado para un selector.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function selectIndex(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = AnswerScore::where('answers_scores.active', true)
                ->select('answers_scores.id as id', 'answers_scores.id as label')
                ->orderBy('answers_scores.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de respuestas y puntajes';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar respuestas y puntajes.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $answer_score = AnswerScore::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | respuestas y puntajes encontrado.';
            $response->data["result"] = $answer_score;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear o Actualizar asignacion de vehiculo.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function createOrUpdate(Request $request, Response $response, Int $id = null)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {

            $answer_score = AnswerScore::find($id);
            if (!$answer_score) $answer_score = new AnswerScore();
            $answer_score->family_1 = $request->family_1;
            $answer_score->economic_1 = $request->economic_1;
            $answer_score->economic_2 = $request->economic_2;
            $answer_score->house_1 = $request->house_1;
            $answer_score->house_2 = $request->house_2;
            $answer_score->house_3 = $request->house_3;
            $answer_score->household_equipment_1 = $request->household_equipment_1;
            $answer_score->household_equipment_2 = $request->household_equipment_2;
            $answer_score->household_equipment_3 = $request->household_equipment_3;
            $answer_score->household_equipment_4 = $request->household_equipment_4;
            $answer_score->household_equipment_5 = $request->household_equipment_5;
            $answer_score->household_equipment_6 = $request->household_equipment_6;
            $answer_score->household_equipment_7 = $request->household_equipment_7;
            $answer_score->household_equipment_8 = $request->household_equipment_8;
            $answer_score->household_equipment_9 = $request->household_equipment_9;
            $answer_score->service_1 = $request->service_1;
            $answer_score->service_2 = $request->service_2;
            $answer_score->service_3 = $request->service_3;
            $answer_score->service_4 = $request->service_4;
            $answer_score->service_5 = $request->service_5;
            $answer_score->service_6 = $request->service_6;
            $answer_score->service_7 = $request->service_7;
            $answer_score->scholarship_1 = $request->scholarship_1;
            $answer_score->scholarship_2 = $request->scholarship_2;
            $answer_score->scholarship_3 = $request->scholarship_3;
            $answer_score->scholarship_4 = $request->scholarship_4;

            $answer_score->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $id > 0 ? 'peticion satisfactoria | respuestas y puntajes editado.' : 'peticion satisfactoria | respuestas y puntajes registrado.';
            $response->data["alert_text"] = $id > 0 ? "Respuestas y Puntajes editado" : "Respuestas y Puntajes registrado";
        } catch (\Exception $ex) {
            error_log("Hubo un error al crear o actualizar el respuestas y puntajes ->" . $ex->getMessage());
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) respuestas y puntajes.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            AnswerScore::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | respuestas y puntajes eliminado.';
            $response->data["alert_text"] = 'Respuestas y Puntajes eliminado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Actualizar estatus del respuestas y puntajes.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function getAnswerScoreActive(Request $request, Response $response,  bool $internal = false)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $answer_score = AnswerScore::where('active', 1)->orderBy('id', 'desc')->first();

            if ((bool)$internal) return $answer_score;

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | respuestas y puntajes activa.";
            $response->data["alert_text"] = "Respuestas y Puntajes activa";
            $response->data["result"] = $answer_score;
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            if ((bool)$internal) return false;
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}