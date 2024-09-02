<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Beca7DocumentData;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Beca7DocumentDataController extends Controller
{
    /**
     * Guardar o Finalizar Revision de documentos de Becas desde formulario beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function saveOrFinishReview(Request $request, Response $response, Int $folio = null)
    {
        try {
            $response->data = ObjResponse::DefaultResponse();
            $becaController = new BecaController();
            $beca = $becaController->_getBecaByFolio($folio);
            // return $beca;
            $document_data = Beca7DocumentData::where('b7_beca_id', $beca->id)->first();
            if (!$document_data) {
                $response->data["alert_text"] = "La documentación no ha sido ligada a niguna beca";
                return response()->json($response, $response->data["status_code"]);
            }
            // return $document_data;

            // $document_data->b7_beca_id = $id;
            $document_data->b7_approved_tutor_ine = (bool)$request->b7_approved_tutor_ine;
            $document_data->b7_comments_tutor_ine = $request->b7_comments_tutor_ine;

            $document_data->b7_approved_tutor_ine_back = (bool)$request->b7_approved_tutor_ine_back;
            $document_data->b7_comments_tutor_ine_back = $request->b7_comments_tutor_ine_back;

            $document_data->b7_approved_tutor_power_letter = (bool)$request->b7_approved_tutor_power_letter;
            $document_data->b7_comments_tutor_power_letter = $request->b7_comments_tutor_power_letter;

            $document_data->b7_approved_second_ref = (bool)$request->b7_approved_second_ref;
            $document_data->b7_comments_second_ref = $request->b7_comments_second_ref;

            $document_data->b7_approved_second_ref_back = (bool)$request->b7_approved_second_ref_back;
            $document_data->b7_comments_second_ref_back = $request->b7_comments_second_ref_back;

            $document_data->b7_approved_proof_address = (bool)$request->b7_approved_proof_address;
            $document_data->b7_comments_proof_address = $request->b7_comments_proof_address;

            $document_data->b7_approved_curp = (bool)$request->b7_approved_curp;
            $document_data->b7_comments_curp = $request->b7_comments_curp;

            $document_data->b7_approved_birth_certificate = (bool)$request->b7_approved_birth_certificate;
            $document_data->b7_comments_birth_certificate = $request->b7_comments_birth_certificate;

            $document_data->b7_approved_academic_transcript = (bool)$request->b7_approved_academic_transcript;
            $document_data->b7_comments_academic_transcript = $request->b7_comments_academic_transcript;

            $document_data->save();

            $approvedDocs = [];
            array_push($approvedDocs, $document_data->b7_approved_tutor_ine);
            array_push($approvedDocs, $document_data->b7_approved_tutor_ine_back);
            if ($request->tutor_relationship_id > 2) array_push($approvedDocs, $document_data->b7_approved_tutor_power_letter);
            if ($request->second_ref != "NULL") {
                array_push($approvedDocs, $document_data->b7_approved_second_ref);
                array_push($approvedDocs, $document_data->b7_approved_second_ref_back);
            }
            array_push($approvedDocs, $document_data->b7_approved_proof_address);
            array_push($approvedDocs, $document_data->b7_approved_curp);
            array_push($approvedDocs, $document_data->b7_approved_birth_certificate);
            array_push($approvedDocs, $document_data->b7_approved_academic_transcript);
            // var_dump($approvedDocs);
            $beca->correction_permission = in_array(0, $approvedDocs);
            $beca->save();


            if ($request->action == "finish") {
                $beca->status = "EN EVALUACIÓN";
                $beca->correction_permission = 0;
                // $beca->correction_completed = $beca->correction_completed == 0 ? 1 : null;
                $beca->save();
                $becaController->calculateRequest($request, $response, $folio, true);
            }

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $request->action == "save" ? 'peticion satisfactoria | documentos de Becas guardados.' : 'satisfactoria | documentos de Becas registrados.';
            $response->data["alert_text"] = $request->action == "save" ? 'Revisión guardada' : 'Revisión finalizada';
            $response->data["result"] = $document_data;
            return response()->json($response, $response->data["status_code"]);
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar documentos de Becas por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
            return response()->json($response, $response->data["status_code"]);
        }
    }

    // /**
    //  * Crear o Actualizar documentos de Becas desde formulario beca.
    //  *
    //  * @param  \Illuminate\Http\Request $request
    //  * @return \Illuminate\Http\Response $response
    //  */
    // public function uploadDocument(Request $request, Response $response, Int $id = null, Int $folio = null, bool $internal = false)
    // {
    //     try {
    //         $response->data = ObjResponse::DefaultResponse();

    //         if ($folio > 0) {
    //             $becaController = new BecaController();
    //             $beca = $becaController->_getBecaByFolio($folio);
    //             $document_data = Beca7DocumentData::where('b7_beca_id', $beca->id)->first();
    //         } else {
    //             if ($internal) $document_data = Beca7DocumentData::where('b7_beca_id', $id)->first(); #si es internal el id es el id de la beca
    //             else $document_data = Beca7DocumentData::find($id);
    //         }
    //         if (!$document_data) $document_data = new Beca7DocumentData();
    //         // return $document_data;

    //         $document_data->b7_beca_id = $id;

    //         // $document_data->b7_img_tutor_ine = $request->b7_img_tutor_ine;
    //         $document_data->b7_approved_tutor_ine = $request->b7_approved_tutor_ine;
    //         $document_data->b7_comments_tutor_ine = $request->b7_comments_tutor_ine;

    //         // $document_data->b7_img_tutor_ine_back = $request->b7_img_tutor_ine_back;
    //         $document_data->b7_approved_tutor_ine_back = $request->b7_approved_tutor_ine_back;
    //         $document_data->b7_comments_tutor_ine_back = $request->b7_comments_tutor_ine_back;

    //         // $document_data->b7_img_tutor_power_letter = $request->b7_img_tutor_power_letter;
    //         $document_data->b7_approved_tutor_power_letter = $request->b7_approved_tutor_power_letter;
    //         $document_data->b7_comments_tutor_power_letter = $request->b7_comments_tutor_power_letter;

    //         // $document_data->b7_img_second_ref = $request->b7_img_second_ref;
    //         $document_data->b7_approved_second_ref = $request->b7_approved_second_ref;
    //         $document_data->b7_comments_second_ref = $request->b7_comments_second_ref;

    //         // $document_data->b7_img_second_ref = $request->b7_img_second_ref;
    //         $document_data->b7_approved_second_ref_back = $request->b7_approved_second_ref_back;
    //         $document_data->b7_comments_second_ref_back = $request->b7_comments_second_ref_back;

    //         // $document_data->b7_img_proof_address = $request->b7_img_proof_address;
    //         $document_data->b7_approved_proof_address = $request->b7_approved_proof_address;
    //         $document_data->b7_comments_proof_address = $request->b7_comments_proof_address;

    //         // $document_data->b7_img_curp = $request->b7_img_curp;
    //         $document_data->b7_approved_curp = $request->b7_approved_curp;
    //         $document_data->b7_comments_curp = $request->b7_comments_curp;

    //         // $document_data->b7_img_birth_certificate = $request->b7_img_birth_certificate;
    //         $document_data->b7_approved_birth_certificate = $request->b7_approved_birth_certificate;
    //         $document_data->b7_comments_birth_certificate = $request->b7_comments_birth_certificate;

    //         // $document_data->b7_img_academic_transcript = $request->b7_img_academic_transcript;
    //         $document_data->b7_approved_academic_transcript = $request->b7_approved_academic_transcript;
    //         $document_data->b7_comments_academic_transcript = $request->b7_comments_academic_transcript;

    //         $document_data->b7_finished = (bool)$request->b7_finished;

    //         $document_data->save();

    //         $b7_img_tutor_ine = $this->ImageUp($request, 'b7_img_tutor_ine', $request->id, 'INE-Tutor', false, "noImage.png");
    //         if ($request->hasFile('b7_img_tutor_ine') || $request->b7_img_tutor_ine == "") $document_data->b7_img_tutor_ine = $b7_img_tutor_ine;
    //         $b7_img_tutor_ine_back = $this->ImageUp($request, 'b7_img_tutor_ine_back', $request->id, 'INE-Tutor-Atras', false, "noImage.png");
    //         if ($request->hasFile('b7_img_tutor_ine_back') || $request->b7_img_tutor_ine_back == "") $document_data->b7_img_tutor_ine_back = $b7_img_tutor_ine_back;
    //         $b7_img_second_ref = $this->ImageUp($request, 'b7_img_second_ref', $request->id, 'Referencia-2', false, "noImage.png");
    //         if ($request->hasFile('b7_img_second_ref') || $request->b7_img_second_ref == "") $document_data->b7_img_second_ref = $b7_img_second_ref;
    //         $b7_img_second_ref_back = $this->ImageUp($request, 'b7_img_second_ref_back', $request->id, 'Referencia-2-Atras', false, "noImage.png");
    //         if ($request->hasFile('b7_img_second_ref_back') || $request->b7_img_second_ref_back == "") $document_data->b7_img_second_ref_back = $b7_img_second_ref_back;
    //         $b7_img_tutor_power_letter = $this->ImageUp($request, 'b7_img_tutor_power_letter', $request->id, 'Carta-Poder', false, "noImage.png");
    //         if ($request->hasFile('b7_img_tutor_power_letter') || $request->b7_img_tutor_power_letter == "") $document_data->b7_img_tutor_power_letter = $b7_img_tutor_power_letter;
    //         $b7_img_proof_address = $this->ImageUp($request, 'b7_img_proof_address', $request->id, 'Comprobante-De-Domicilio', false, "noImage.png");
    //         if ($request->hasFile('b7_img_proof_address') || $request->b7_img_proof_address == "") $document_data->b7_img_proof_address = $b7_img_proof_address;
    //         $b7_img_curp = $this->ImageUp($request, 'b7_img_curp', $request->id, 'CURP', false, "noImage.png");
    //         if ($request->hasFile('b7_img_curp') || $request->b7_img_curp == "") $document_data->b7_img_curp = $b7_img_curp;
    //         $b7_img_birth_certificate = $this->ImageUp($request, 'b7_img_birth_certificate', $request->id, 'Acta-De-Nacimineto', false, "noImage.png");
    //         if ($request->hasFile('b7_img_birth_certificate') || $request->b7_img_birth_certificate == "") $document_data->b7_img_birth_certificate = $b7_img_birth_certificate;
    //         $b7_img_academic_transcript = $this->ImageUp($request, 'b7_img_academic_transcript', $request->id, 'Constancia-De-Estudios-Y-Calificaciones', false, "noImage.png");
    //         if ($request->hasFile('b7_img_academic_transcript') || $request->b7_img_academic_transcript == "") $document_data->b7_img_academic_transcript = $b7_img_academic_transcript;

    //         $document_data->save();

    //         $response->data = ObjResponse::CorrectResponse();
    //         $response->data["message"] = $id > 0 ? 'peticion satisfactoria | documentos de Becas editados.' : 'satisfactoria | documentos de Becas registrados.';
    //         $response->data["alert_text"] = $id > 0 ? "Documento: $request->name cargado" : "Documento: $request->name cargado";
    //         $response->data["result"] = $document_data;
    //         if (!$internal) return response()->json($response, $response->data["status_code"]);
    //         else return $document_data;
    //     } catch (\Exception $ex) {
    //         $msg =  "Error al crear o actualizar documentos de Becas por medio de la beca: " . $ex->getMessage();
    //         error_log("$msg");
    //         $response->data = ObjResponse::CatchResponse($ex->getMessage());
    //         if (!$internal) return response()->json($response, $response->data["status_code"]);
    //         else return "$msg";
    //     }
    // }


    /**
     * Crear o Actualizar documentos de Becas desde formulario beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function createOrUpdateByBeca(Request $request, Response $response, Int $folio = null, bool $internal = false)
    {
        try {
            $response->data = ObjResponse::DefaultResponse();

            // if ($folio > 0) {
            $becaController = new BecaController();
            $beca = $becaController->_getBecaByFolio($folio);
            $document_data = Beca7DocumentData::where('b7_beca_id', $beca->id)->first();
            // }
            // else {
            //     if ($internal) $document_data = Beca7DocumentData::where('b7_beca_id', $id)->first(); #si es internal el id es el id de la beca
            //     else $document_data = Beca7DocumentData::find($id);
            // }
            if (!$document_data) $document_data = new Beca7DocumentData();
            // return $document_data;

            $document_data->b7_beca_id = $beca->id;

            // // $document_data->b7_img_tutor_ine = $request->b7_img_tutor_ine;
            // $document_data->b7_approved_tutor_ine = $request->b7_approved_tutor_ine;
            // $document_data->b7_comments_tutor_ine = $request->b7_comments_tutor_ine;

            // // $document_data->b7_img_tutor_ine_back = $request->b7_img_tutor_ine_back;
            // $document_data->b7_approved_tutor_ine_back = $request->b7_approved_tutor_ine_back;
            // $document_data->b7_comments_tutor_ine_back = $request->b7_comments_tutor_ine_back;

            // // $document_data->b7_img_tutor_power_letter = $request->b7_img_tutor_power_letter;
            // $document_data->b7_approved_tutor_power_letter = $request->b7_approved_tutor_power_letter;
            // $document_data->b7_comments_tutor_power_letter = $request->b7_comments_tutor_power_letter;

            // // $document_data->b7_img_second_ref = $request->b7_img_second_ref;
            // $document_data->b7_approved_second_ref = $request->b7_approved_second_ref;
            // $document_data->b7_comments_second_ref = $request->b7_comments_second_ref;

            // // $document_data->b7_img_second_ref = $request->b7_img_second_ref;
            // $document_data->b7_approved_second_ref_back = $request->b7_approved_second_ref_back;
            // $document_data->b7_comments_second_ref_back = $request->b7_comments_second_ref_back;

            // // $document_data->b7_img_proof_address = $request->b7_img_proof_address;
            // $document_data->b7_approved_proof_address = $request->b7_approved_proof_address;
            // $document_data->b7_comments_proof_address = $request->b7_comments_proof_address;

            // // $document_data->b7_img_curp = $request->b7_img_curp;
            // $document_data->b7_approved_curp = $request->b7_approved_curp;
            // $document_data->b7_comments_curp = $request->b7_comments_curp;

            // // $document_data->b7_img_birth_certificate = $request->b7_img_birth_certificate;
            // $document_data->b7_approved_birth_certificate = $request->b7_approved_birth_certificate;
            // $document_data->b7_comments_birth_certificate = $request->b7_comments_birth_certificate;

            // // $document_data->b7_img_academic_transcript = $request->b7_img_academic_transcript;
            // $document_data->b7_approved_academic_transcript = $request->b7_approved_academic_transcript;
            // $document_data->b7_comments_academic_transcript = $request->b7_comments_academic_transcript;

            // $document_data->b7_finished = (bool)$request->b7_finished;

            $document_data->save();

            $b7_img_tutor_ine = $this->ImageUp($request, 'b7_img_tutor_ine', $beca->id, 'INE-Tutor', false, "noImage.png");
            if ($request->hasFile('b7_img_tutor_ine')) $document_data->b7_img_tutor_ine = $b7_img_tutor_ine;
            $b7_img_tutor_ine_back = $this->ImageUp($request, 'b7_img_tutor_ine_back', $beca->id, 'INE-Tutor-Atras', false, "noImage.png");
            if ($request->hasFile('b7_img_tutor_ine_back')) $document_data->b7_img_tutor_ine_back = $b7_img_tutor_ine_back;
            $b7_img_second_ref = $this->ImageUp($request, 'b7_img_second_ref', $beca->id, 'Referencia-2', false, "noImage.png");
            if ($request->hasFile('b7_img_second_ref')) $document_data->b7_img_second_ref = $b7_img_second_ref;
            $b7_img_second_ref_back = $this->ImageUp($request, 'b7_img_second_ref_back', $beca->id, 'Referencia-2-Atras', false, "noImage.png");
            if ($request->hasFile('b7_img_second_ref_back')) $document_data->b7_img_second_ref_back = $b7_img_second_ref_back;
            $b7_img_tutor_power_letter = $this->ImageUp($request, 'b7_img_tutor_power_letter', $beca->id, 'Carta-Poder', false, "noImage.png");
            if ($request->hasFile('b7_img_tutor_power_letter')) $document_data->b7_img_tutor_power_letter = $b7_img_tutor_power_letter;
            $b7_img_proof_address = $this->ImageUp($request, 'b7_img_proof_address', $beca->id, 'Comprobante-De-Domicilio', false, "noImage.png");
            if ($request->hasFile('b7_img_proof_address')) $document_data->b7_img_proof_address = $b7_img_proof_address;
            $b7_img_curp = $this->ImageUp($request, 'b7_img_curp', $beca->id, 'CURP', false, "noImage.png");
            if ($request->hasFile('b7_img_curp')) $document_data->b7_img_curp = $b7_img_curp;
            $b7_img_birth_certificate = $this->ImageUp($request, 'b7_img_birth_certificate', $beca->id, 'Acta-De-Nacimineto', false, "noImage.png");
            if ($request->hasFile('b7_img_birth_certificate')) $document_data->b7_img_birth_certificate = $b7_img_birth_certificate;
            $b7_img_academic_transcript = $this->ImageUp($request, 'b7_img_academic_transcript', $beca->id, 'Constancia-De-Estudios-Y-Calificaciones', false, "noImage.png");
            if ($request->hasFile('b7_img_academic_transcript')) $document_data->b7_img_academic_transcript = $b7_img_academic_transcript;

            $document_data->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'satisfactoria | documentos de Becas registrados.';
            $response->data["alert_text"] = "Documento: $request->name cargado";
            $response->data["result"] = $document_data;
            if (!$internal) return response()->json($response, $response->data["status_code"]);
            else return $document_data;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar documentos de Becas por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
            if (!$internal) return response()->json($response, $response->data["status_code"]);
            else return "$msg";
        }
    }

    /**
     * Eliminar documentos de Becas o documentos de Becas.
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
            Beca7DocumentData::whereIn('id', $request->ids)->delete();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | documentos de Becas eliminados ($countDeleted).";
            $response->data["alert_text"] = "Documentos de Becas eliminados  ($countDeleted)";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Mostrar lista de documentos de Becas activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Beca7DocumentData::where('beca_7_document_data.active', true)
                ->orderBy('beca_7_document_data.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de documentos de Becas.';
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
            $list = Beca7DocumentData::where('beca_7_document_data.active', true)
                ->select('beca_7_document_data.id as id', 'beca_7_document_data.b7_beca_id as label')
                ->orderBy('beca_7_document_data.b7_beca_id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de documentos de Becas';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Mostrar documentos de Becas.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $student_data = Beca7DocumentData::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | documentos de Becas encontrados.';
            $response->data["result"] = $student_data;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    /**
     * Eliminar (cambiar estado activo=false) documentos de Becas.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Beca7DocumentData::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | documentos de Becas eliminados.';
            $response->data["alert_text"] = 'Documentos de Becas eliminados';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    private function ImageUp($request, $requestFile, $id, $posFix, $create, $nameFake)
    {
        try {
            $dir_path = "Becas/documents-by-beca";
            $dir = public_path($dir_path);
            $img_name = "";
            if ($request->hasFile($requestFile)) {
                // return "ImageUp->aqui todo bien 3";
                $img_file = $request->file($requestFile);
                $instance = new UserController();
                $dir_path = "$dir_path/$id";
                $dir = "$dir/$id";
                $img_name = $instance->ImgUpload($img_file, $dir, $dir_path, "$id-$posFix");
            } else {
                if ($create) $img_name = "$dir_path/$nameFake";
            }
            return $img_name;
        } catch (\Exception $ex) {
            $msg =  "Error al cargar imagen de documentos data: " . $ex->getMessage();
            error_log("$msg");
            return "$msg";
        }
    }
}