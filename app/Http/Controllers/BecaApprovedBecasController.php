<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BecaApprovedView;
use Illuminate\Http\Request;

class BecaApprovedBecasController extends Controller
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
}