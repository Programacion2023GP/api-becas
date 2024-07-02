<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BecaPaid;
use App\Models\BecaView;
use Illuminate\Http\Request;

class BecaPaidController extends Controller
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
            $list = BecaView::all();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de becas.';
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
    public function createOrUpdate(Response $response, Request $request, Int $id = null, Int $beca_id, bool $internal = false)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $beca_paid = BecaPaid::find($id);
            if (!$beca_paid) $beca_paid = new BecaPaid();

            // # VALIDACIONES
            // # 1.- Cuantos pagos se daran en esta ocasion? (al tener la tabla de configuraciones) obtendremos si ya se pago la beca completamente
            $paid = false;
            if (!$paid) {
                $becaPaymentDetailController->createOrUpdate($response, $request, null, $beca_paid->id, true);
            }

            // # 2.- Cuantos pagos tiene registrados y su monto?
            $becaPaymentDetailController = new BecaPaymentDetailController();
            $paymentsDetail = $becaPaymentDetailController->index($response, $beca_paid->id, true);
            $payments = count($paymentsDetail);
            $total_amount = 0;
            foreach ($paymentsDetail as $payment) {
                $total_amount += $payment['amount_paid'];
            }

            $beca_paid->beca_id = $request->beca_id;
            $beca_paid->paid = $paid;
            $beca_paid->payments = $payments;
            $beca_paid->total_amount = $total_amount;

            // return $beca_paid;
            $beca_paid->save();
            if ((bool)$internal) return $beca_paid; # al regresar a la beca, si paid es true, cambiar status a "PAGADO"

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $id > 0 ? 'peticion satisfactoria | beca pagada editada.' : 'peticion satisfactoria | beca pagada registrada.';
            $response->data["alert_text"] = $id > 0 ? "Registro de Pago de Beca editado" : "Registro de Pago de Beca registrado";
            $response->data["result"] = $beca_paid;
        } catch (\Exception $ex) {
            $msg = "Hubo un error al crear o actualizar beca pagada -> " . $ex->getMessage();
            error_log($msg);
            $response->data = ObjResponse::CatchResponse($ex->getMessage());;
            if ((bool)$internal) return 0;
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
