<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnswerScore;
use App\Models\Beca;
use App\Models\Beca6ScholarshipProgramData;
use App\Models\BecaView;
use App\Models\ObjResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\ModelsView;
use DateTime;
use Illuminate\Support\Facades\Date;

use function PHPUnit\Framework\countOf;

class BecaController extends Controller
{
    /**
     * Actualizar beca por pagina o guardado temporal.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function saveBeca(Request $request, Response $response, Int $folio, Int $page)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $beca = Beca::where('folio', $folio)->first();
            if (!$beca) {
                // $response->data["message"] = 'peticion satisfactoria | Avance guardado.';
                $response->data["alert_text"] = 'Beca no encontrada';
                return response()->json($response, $response->data["status_code"]);
            }

            // if ($request->folio) $beca->folio = $request->folio;
            if ((int)$page === 3) {
                // error_log("PAGINA - 1 === $page");
                // if ($request->tutor_id) $beca->user_id = $request->user_id;
                if ($request->tutor_data_id) $beca->tutor_data_id = $request->tutor_data_id;
                // }
                // if ((int)$page === 2) {
                // error_log("PAGINA - 2 === $page");
                if ($request->student_data_id) $beca->student_data_id = $request->student_data_id;
                // }
                // if ((int)$page === 3) {
                // error_log("PAGINA - 3 === $page");
                if ($request->school_id) $beca->school_id = $request->school_id;
                if ($request->grade) $beca->grade = $request->grade;
                if ($request->average) $beca->average = $request->average;
                if ($request->comments) $beca->comments = $request->comments;
                if ((int)$beca->current < 4) $beca->current_page = 4;
            }
            if ((int)$page === 4) {
                // return ("PAGINA - 4 === $page");
                if ($request->extra_income) $beca->extra_income = $request->extra_income;
                if ($request->monthly_income) $beca->monthly_income = $request->monthly_income;
                if ((bool)$request->finished && (int)$beca->current < 5) $beca->current_page = 5;
            }
            if ((int)$page === 5) {
                // return ("PAGINA - 5 === $page");
                $b3Controller = new Beca3EconomicDataController();
                $b3Controller->_createOrUpdateByBeca($request, $beca->id);
                if ($request->total_expenses) $beca->total_expenses = $request->total_expenses;
                if ((bool)$request->b3_finished && (int)$beca->current < 6) $beca->current_page = 6;
            }
            if ((int)$page === 6) {
                // return ("PAGINA - 6 === $page");
                $b4Controller = new Beca4HouseDataController();
                $b4Controller->_createOrUpdateByBeca($request, $beca->id);
                if ((bool)$request->b4_finished && (int)$beca->current < 7) $beca->current_page = 7;
            }
            if ((int)$page === 7) {
                // return ("PAGINA - 7 === $page");
                $b5Controller = new Beca5HouseholdEquipmentDataController();
                $b5Controller->_createOrUpdateByBeca($request, $beca->id);
                if ((bool)$request->b5_finished && (int)$beca->current < 8) $beca->current_page = 8;
            }
            if ((int)$page === 8) {

                // return ("PAGINA - 7 === $page");
                $b6Controller = new Beca6ScholarshipProgramDataController();
                $b6Controller->_createOrUpdateByBeca($request, $beca->id);
                if ((bool)$request->under_protest) {
                    $beca->under_protest = (bool)$request->under_protest;
                    if ((bool)$request->b6_finished && (int)$beca->current < 9) $beca->current_page = 9;
                } else {
                    $response->data = ObjResponse::CorrectResponse();
                    $response->data["status_code"] = 202;
                    $response->data["message"] = 'peticion satisfactoria | Avance guardado.';
                    $response->data["alert_text"] = "Avance guardado (pagina $page)";
                    $response->data["alert_title"] = "Es necesario marcar la casilla de bajo protesta para terminar el proceso.";
                    return response()->json($response, $response->data["status_code"]);
                }
            }
            if ((int)$page === 9) {
                // error_log("PAGINA - 8 === $page");
                $b7Controller = new Beca7DocumentDataController();
                $object = $b7Controller->createOrUpdateByBeca($request, $response, $beca->id, true);
                // return $object;
                if ((bool)$object->b7_finished && (int)$beca->current < 10) {
                    // $beca->current_page = 10;
                    $beca->status = "TERMINADA";
                    $beca->end_date = $request->end_date;
                }
            }
            // if ($request->socioeconomic_study) $beca->socioeconomic_study = $request->socioeconomic_study;

            $beca->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | Avance guardado.';
            $response->data["alert_text"] = $beca->status == "TERMINADA" ? "Solicitud Terminada" : "Avance guardado (pagina $page)";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar estatus de la beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function updateStatus(Response $response, Request $request, Int $folio, String $status = "ALTA", bool $internal = false)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {

            $beca = Beca::where('folio', $folio)->first();
            if (!$beca) {
                $response->data["alert_text"] = "La Beca buscada no fue encontrada";
                return response()->json($response, $response->data["status_code"]);
            }
            $beca->status = $status;
            if ($status == "RECHAZADA") {
                $userAuth = Auth::user();
                $beca->rejected_by = $userAuth->id;
                $beca->rejected_feedback = $request->rejected_feedback;
                $beca->rejected_at = $request->rejected_at;
            } elseif ($status == "APROBADA") {
                $becaApprovedController = new BecaApprovedController();
                $beca_approved =  $becaApprovedController->createOrUpdate($response, $request, null, $beca->id, true);
                // return $beca_approved;
                // return "checkPoint 2 - $status";
            }
            $beca->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | estatus de beca cambiado.';
            $response->data["alert_text"] = "Solicitud $folio paso al estatus: $status";
            $response->data["result"] = $beca;
            if (!$internal) return response()->json($response, $response->data["status_code"]);
            else return 1;
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            if (!$internal) return response()->json($response, $response->data["status_code"]);
            else return 0;
        }
    }

    //#region CRUD
    /**
     * Mostrar lista de becas activas.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response, string $status = null)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $userAuth = Auth::user();

            $values = explode(',', $status);
            if (!$status) $list = $userAuth->role_id == 3 ? BecaView::where('user_id', $userAuth->id)->get() : BecaView::all();
            else $list = $userAuth->role_id == 3 ? BecaView::where('user_id', $userAuth->id)->whereIn('status', $values)->get() : BecaView::whereIn('status', $values)->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de becas.';
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
            $list = Beca::where('active', true)
                ->select('becas.id as id', 'becas.folio as label')
                ->orderBy('becas.folio', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de becas';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $tutorDataController = new Beca1TutorDataController();
            $studentDataController = new Beca1StudentDataController();
            $tutor_data = $tutorDataController->createOrUpdateByBeca($request);
            $student_data = $studentDataController->createOrUpdateByBeca($request);

            $folio = $this->getLastFolio($response);

            $new_beca = Beca::create([
                'folio' => (int)$folio + 1,
                'user_id' => $request->user_id,
                // 'single_mother' => $request->single_mother,
                'tutor_data_id' => $tutor_data->id,
                'student_data_id' => $student_data->id,
                'school_id' => $request->school_id,
                'grade' => $request->grade,
                'average' => $request->average,
                'extra_income' => $request->extra_income,
                'monthly_income' => $request->monthly_income,
                'total_expenses' => $request->total_expenses,
                'under_protest' => $request->under_protest,
                'comments' => $request->comments,
                // 'socioeconomic_study' => $request->socioeconomic_study,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | beca registrada.';
            $response->data["alert_text"] = 'Beca registrada';
            $response->data["result"] = $new_beca;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar beca.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $beca = Beca::where('id', $request->id)->first();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | beca encontrada.';
            $response->data["result"] = $beca;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $beca = Beca::find($request->id)
                ->update([
                    'folio' => $request->folio,
                    'user_id' => $request->user_id,
                    // 'single_mother' => $request->single_mother,
                    'tutor_data_id' => $request->tutor_data_id,
                    'student_data_id' => $request->student_data_id,
                    'school_id' => $request->school_id,
                    'grade' => $request->grade,
                    'average' => $request->average,
                    'extra_income' => $request->extra_income,
                    'monthly_income' => $request->monthly_income,
                    'total_expenses' => $request->total_expenses,
                    'under_protest' => $request->under_protest,
                    'comments' => $request->comments,
                    'comments' => $request->comments,
                    'socioeconomic_study' => $request->socioeconomic_study,
                ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | beca actualizada.';
            $response->data["alert_text"] = 'Beca actualizada';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) beca.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Beca::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | beca eliminada.';
            $response->data["alert_text"] = 'Beca eliminada';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    //#endregion CRUD

    /**
     * Mostrar reporte de beca por folio.
     * Propiedades en español
     *
     * @param   Int $folio
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function getReportRequestByFolio(Response $response, Int $folio)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $beca = BecaView::where('folio', $folio)->first();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | beca encontrada.';
            $response->data["result"] = $beca;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar beca por folio.
     *
     * @param   Int $folio
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function getBecaByFolio(Response $response, Int $folio)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $beca = BecaView::where('folio', $folio)->first();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | beca encontrada.';
            $response->data["result"] = $beca;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    /**
     * Mostrar beca por folio.
     *
     * @param   Int $folio
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function _getBecaByFolio(Int $folio)
    {
        try {
            $beca = Beca::where('folio', $folio)->first();
            return $beca;
        } catch (\Exception $ex) {
            $msg =  "Error al obtener beca por folio: " . $ex->getMessage();
            error_log("$msg");
            return null;
        }
    }


    /**
     * Mostrar beca por folio.
     * Mostrar solo si el usuario logeado es el correspondiente a la beca o eres admin
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function getBecasByUser(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $role_id = Auth::user()->role_id;
            // return "que tengo aqui? -> $role_id";
            $beca = BecaView::where('folio', $request->folio)->get();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | beca encontrada.';
            $response->data["result"] = $beca;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Obtener el ultimo folio.
     *
     * @return \Illuminate\Http\Int $folio
     */
    private function getLastFolio()
    {
        try {
            $folio = Beca::max('folio');
            if ($folio == null) return 0;
            return $folio;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar estudiante por medio de la beca: " . $ex->getMessage();
            echo "$msg";
            return $msg;
        }
    }


    /**
     * Obtener el ultimo folio.
     *
     * @return \Illuminate\Http\Int $folio
     */
    public function calculateRequest(Request $request, Response $response, int $folio, bool $internal = false)
    {
        try {
            //#region OBTENIENDO DATAS
            $beca_view = BecaView::where('folio', $folio)->first();
            $instancefamily = new Beca2FamilyDataController();
            $members_family = $instancefamily->getIndexByFolio($folio, $response, true);
            $instanceAnswerScore = new AnswerScoreController();
            $answer_score_active = $instanceAnswerScore->getAnswerScoreActive($request, $response, true);
            $answerScoreTemp = [];
            $answerScore = array(
                'id' => 0,
                'low_score' => 0,
                'medium_low_score' => 0,
                'medium_score' => 0,
                'score_total' => 0,
                'socioeconomic_study' => 'SIN EVALUAR'
            );
            // return $beca_view;
            $familys = [];
            $familysResponse = [];
            #CUANTOS MIEMBROS DE LA FAMILIA SON?
            array_push($familys, explode(",", $answer_score_active->family_1));
            array_push($familysResponse, count($members_family));
            array_push($answerScoreTemp, $this->mappingQuestions($familys, "family", "range", $familysResponse));

            $economics = [];
            $economicsResponse = [];
            #INGRESOS MENSUALES
            array_push($economics, explode(",", $answer_score_active->economic_1));
            array_push($economicsResponse, (int)$beca_view->monthly_income);
            #EGRESOS MENSUALES
            array_push($economics, explode(",", $answer_score_active->economic_2));
            array_push($economicsResponse, (int)$beca_view->total_expenses);
            array_push($answerScoreTemp, $this->mappingQuestions($economics, "economic", "range", $economicsResponse));

            $houses = [];
            $housesResponse = [];
            array_push($houses, explode(",", $answer_score_active->house_1));
            array_push($housesResponse, (int)explode("@", $beca_view->b4_house_is)[0]);
            array_push($houses, explode(",", $answer_score_active->house_2));
            array_push($housesResponse, (int)explode("@", $beca_view->b4_roof_material)[0]);
            array_push($houses, explode(",", $answer_score_active->house_3));
            array_push($housesResponse, (int)explode("@", $beca_view->b4_floor_material)[0]);
            array_push($answerScoreTemp, $this->mappingQuestions($houses, "house", "multiple", $housesResponse));

            $household_equipments = [];
            $household_equipmentsResponse = [];
            array_push($household_equipments, explode(",", $answer_score_active->household_equipment_1));
            array_push($household_equipmentsResponse, (int)$beca_view->b5_beds);
            array_push($household_equipments, explode(",", $answer_score_active->household_equipment_2));
            array_push($household_equipmentsResponse, (int)$beca_view->b5_washing_machines);
            array_push($household_equipments, explode(",", $answer_score_active->household_equipment_3));
            array_push($household_equipmentsResponse, (int)$beca_view->b5_boilers);
            array_push($household_equipments, explode(",", $answer_score_active->household_equipment_4));
            array_push($household_equipmentsResponse, (int)$beca_view->b5_tvs);
            array_push($household_equipments, explode(",", $answer_score_active->household_equipment_5));
            array_push($household_equipmentsResponse, (int)$beca_view->b5_pcs);
            array_push($household_equipments, explode(",", $answer_score_active->household_equipment_6));
            array_push($household_equipmentsResponse, (int)$beca_view->b5_phones);
            array_push($household_equipments, explode(",", $answer_score_active->household_equipment_7));
            array_push($household_equipmentsResponse, (int)$beca_view->b5_music_player);
            array_push($household_equipments, explode(",", $answer_score_active->household_equipment_8));
            array_push($household_equipmentsResponse, (int)$beca_view->b5_stoves);
            array_push($household_equipments, explode(",", $answer_score_active->household_equipment_9));
            array_push($household_equipmentsResponse, (int)$beca_view->b5_refrigerators);
            array_push($answerScoreTemp, $this->mappingQuestions($household_equipments, "household_equipment", "range", $household_equipmentsResponse));

            $services = [];
            $servicesResponse = [];
            array_push($services, $answer_score_active->service_1);
            array_push($servicesResponse, (bool)$beca_view->b5_drinking_water);
            array_push($services, $answer_score_active->service_2);
            array_push($servicesResponse, (bool)$beca_view->b5_electric_light);
            array_push($services, $answer_score_active->service_3);
            array_push($servicesResponse, (bool)$beca_view->b5_sewer_system);
            array_push($services, $answer_score_active->service_4);
            array_push($servicesResponse, (bool)$beca_view->b5_pavement);
            array_push($services, $answer_score_active->service_5);
            array_push($servicesResponse, (bool)$beca_view->b5_automobile);
            array_push($services, $answer_score_active->service_6);
            array_push($servicesResponse, (bool)$beca_view->b5_phone_line);
            array_push($services, $answer_score_active->service_7);
            array_push($servicesResponse, (bool)$beca_view->b5_internet);
            array_push($answerScoreTemp, $this->mappingQuestions($services, "service", "check", $servicesResponse, true));

            $scholarships = [];
            $scholarshipsResponse = [];
            array_push($scholarships, $answer_score_active->scholarship_1);
            array_push($scholarshipsResponse, (bool)$beca_view->b6_beca_transport);
            array_push($scholarships, $answer_score_active->scholarship_2);
            array_push($scholarshipsResponse, (bool)$beca_view->b6_beca_benito_juarez);
            array_push($scholarships, $answer_score_active->scholarship_3);
            array_push($scholarshipsResponse, (bool)$beca_view->b6_beca_jovenes);
            array_push($scholarships, $answer_score_active->scholarship_4);
            array_push($scholarshipsResponse, (bool)$beca_view->b6_other);
            array_push($answerScoreTemp, $this->mappingQuestions($scholarships, "scholarship", "check", $scholarshipsResponse, true));

            var_dump($answerScoreTemp[4], $answerScoreTemp[5]);

            $answerScore = array_merge($answerScoreTemp[0], $answerScoreTemp[1], $answerScoreTemp[2], $answerScoreTemp[3], $answerScoreTemp[4], $answerScoreTemp[5]);
            $answerScore['id'] = $answer_score_active->id;
            $answerScore['low_score'] = (int)$answer_score_active->low_score;
            $answerScore['medium_low_score'] = (int)$answer_score_active->medium_low_score;
            $answerScore['medium_score'] = (int)$answer_score_active->medium_score;
            //#endregion OBTENIENDO DATAS
            // return $answerScoreTemp;

            //#region EMPAREJANDO RESULTADOS
            $scoreTotal = 0;
            foreach ($answerScore as $value) {
                $scoreTotal += $value;
            }
            if ($scoreTotal >= $answerScore['low_score'] && $scoreTotal < $answerScore['medium_low_score']) $answerScore['socioeconomic_study'] = 'BAJO';
            elseif ($scoreTotal >= $answerScore['medium_low_score'] && $scoreTotal < $answerScore['medium_score']) $answerScore['socioeconomic_study'] = 'MEDIO-BAJO';
            elseif ($scoreTotal >= $answerScore['medium_score']) $answerScore['socioeconomic_study'] = 'MEDIO';
            $answerScore['score_total'] = $scoreTotal;
            //#endregion EMPAREJANDO RESULTADOS

            $beca = Beca::find($beca_view->id);
            $beca->socioeconomic_study = $answerScore['socioeconomic_study'];
            $beca->save();

            if ((bool)$internal) return $answerScore;


            return $answerScore;
        } catch (\Exception $ex) {
            $msg =  "Error al calcular la solicitud de beca: " . $ex->getMessage();
            echo "$msg";
            return $msg;
        }
    }

    private function mappingQuestions($arrayQuestions, $questionName, $optionType, $responses, $flipValue = false)
    {
        $obj = [];
        // echo ("mappingQuestions" . $obj);
        $qi = 0;
        foreach ($arrayQuestions as $questions) {
            if ($optionType === "range") {
                // echo "aqui bien";
                foreach ($questions as $r) {
                    $q = $qi + 1;
                    // echo ("reg" . $r);
                    $reg = trim($r);
                    // console.log("reg", reg);
                    $op = explode(":", $reg)[0];
                    // console.log("op", op);
                    $data = explode(":", $reg)[1];
                    // console.log("data", data);
                    $min = explode("-", $data)[0];
                    $max = explode("-", $data)[1];
                    $max = explode("=", $max)[0];
                    $pts = explode("=", $data)[1];
                    // console.log("dataReal: ", `${questionName}_${q}_${op}: ${min}-${max}=${pts}`);
                    // $obj[$questionName . "_" . $q . "_" . $op . "_min"] = (int)$min;
                    // $obj[$questionName . "_" . $q . "_" . $op . "_max"] = (int)$max;
                    // $obj[$questionName . "_" . $q . "_" . $op] = (int)$pts;

                    // EVALUAR RESPUSTA DEL ESTUDIO SOCIO-ECONOMICO
                    if ((int)$responses[$qi] >= (int)$min && (int)$responses[$qi] <= (int)$max) $obj[$questionName . "_" . $q . "_" . $op] = (int)$pts;
                    // EVALUAR RESPUSTA DEL ESTUDIO SOCIO-ECONOMICO

                    // console.log(`${questionName}_${q}_${op}`);
                    // console.log(obj);
                };
            } elseif ($optionType === "multiple") {
                foreach ($questions as $r) {
                    $q = $qi + 1;
                    // console.log("reg", r);
                    $reg = trim($r);
                    // console.log("reg", reg);
                    $op = explode(":", $reg)[0];
                    // console.log("op", op);
                    $pts = explode(":", $reg)[1];
                    // console.log("data", pts);
                    // console.log("dataReal: ", `${questionName}_${q}_${op}= ${pts}`);
                    // $obj[$questionName . "_" . $q . "_" . $op] = (int)$pts;

                    // EVALUAR RESPUSTA DEL ESTUDIO SOCIO-ECONOMICO
                    if ((int)$responses[$qi] == (int)$op) $obj[$questionName . "_" . $q . "_" . $op] = (int)$pts;
                    // EVALUAR RESPUSTA DEL ESTUDIO SOCIO-ECONOMICO

                };
            } elseif ($optionType === "check") {
                // console.log(questions);
                $q = $qi + 1;
                $pts = $questions;
                // console.log("pts", pts);
                // console.log("dataReal: ", `${questionName}_${q}= ${pts}`);
                // $obj[$questionName . "_" . $q] = (int)$pts;

                // EVALUAR RESPUSTA DEL ESTUDIO SOCIO-ECONOMICO
                if ((bool)$flipValue) { // Invertir Valores; seleccionado|check vale 0
                    $obj[$questionName . "_" . $q] = (bool)$responses[$qi] ? 0 : (int)$pts;
                } else {
                    $obj[$questionName . "_" . $q] = (bool)$responses[$qi] ? (int)$pts : 0;
                }
                // EVALUAR RESPUSTA DEL ESTUDIO SOCIO-ECONOMICO
            }
            $qi += 1;
        }
        return $obj;
    }
}
