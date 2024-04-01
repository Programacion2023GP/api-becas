<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BecaApproved;
use App\Models\BecaApprovedView;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class BecaApprovedController extends Controller
{
    //#region CRUD
    /**
     * Mostrar lista de becas aprobadas activas.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = BecaApprovedView::all();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de becas aprobadas.';
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
    public function createOrUpdate(Int $id = null, bool $internal = false)
    {
        // return "checkPoint 3 - todo ok hasta aqui";
        // $response->data = ObjResponse::DefaultResponse();
        try {
            $beca_approved = BecaApproved::find($id);
            if (!$beca_approved) $beca_approved = new BecaApproved();
            $beca_approved->user_id = $request->user_id;
            $beca_approved->beca_id = $request->beca_id;
            $beca_approved->feedback = $request->feedback;

            $beca_approved->save();
            if ($internal) return $beca_approved;

            // $response->data = ObjResponse::CorrectResponse();
            // $response->data["message"] = $id > 0 ? 'peticion satisfactoria | beca aprobada editada.' : 'peticion satisfactoria | beca aprobada registrada.';
            // $response->data["alert_text"] = $id > 0 ? "Beca Aprobada editada" : "Beca Aprobada registrada";
            // $response->data["result"] = $beca_approved;
        } catch (\Exception $ex) {
            $msg = "Hubo un error al crear o actualizar el beca aprobada -> " . $ex->getMessage();
            error_log($msg);
            // $response->data = ObjResponse::CatchResponse($ex->getMessage());;
            if ($internal) return 0;
        }
        // return response()->json($response, $response->data["status_code"]);
    }
}
