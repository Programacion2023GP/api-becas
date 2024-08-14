<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BecaPaid;
use App\Models\BecaPaymentDetail;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BecaPaymentDetailController extends Controller
{
    //#region CRUD
    /**
     * Mostrar lista de becas aprobadas activas.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response, Int $beca_id = null, $internal = false)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = $beca_id > 0 ? BecaPaymentDetail::where('beca_id', $beca_id)->where('active', 1)->get() : BecaPaymentDetail::where('active', 1);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de detalle de pagos.';
            $response->data["result"] = $list;

            if ((bool)$internal) return $list;
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
    public function createOrUpdate(Response $response, Request $request, Int $id = null, Int $beca_id = null, Int $payments, bool $internal = false)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $beca_payment_detail = BecaPaymentDetail::find($id);
            if (!$beca_payment_detail) $beca_payment_detail = new BecaPaymentDetail();

            $userAuth = Auth::user();
            // $datetime = date("Y-m-d H:i:s");
            // var_dump($request);


            $beca_payment_detail->beca_id = $beca_id > 0 ? $beca_id : $request->beca_id;
            $beca_payment_detail->paid_by = $userAuth->id;
            $beca_payment_detail->relationship_id = $request->relationship_id;
            $beca_payment_detail->paid_to = $request->paid_to;
            $beca_payment_detail->amount_paid = $request->amount_paid;
            // $beca_payment_detail->img_evidence = $request->img_evidence;
            $beca_payment_detail->paid_feedback = $request->paid_feedback;

            $beca_payment_detail->save();

            $currentPayment = (int)$payments + 1;
            $img_evidence = $this->ImageUp($request, 'img_evidence', $beca_id, "Pago-$currentPayment", false, "noImage.png");
            if ($request->hasFile('img_evidence') || $request->img_evidence == "") $beca_payment_detail->img_evidence = $img_evidence;
            $beca_payment_detail->save();

            if ((bool)$internal) return $beca_payment_detail;

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $id > 0 ? 'peticion satisfactoria | detalle de pago editada.' : 'peticion satisfactoria | detalle de pago registrada.';
            $response->data["alert_text"] = $id > 0 ? "Detalle de Pago editado" : "Detalle de Pago registrado";
            $response->data["result"] = $beca_payment_detail;
        } catch (\Exception $ex) {
            $msg = "Hubo un error al crear o actualizar detalle de pago -> " . $ex->getMessage();
            error_log($msg);
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
            if ((bool)$internal) return 0;
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