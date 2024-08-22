<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BecaPaid;
use App\Models\BecaPaidView;
use App\Models\BecaView;
use App\Models\ObjResponse;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CounterController extends Controller
{
    /**
     * Contar elementos de menus.
     *
     * @return \Illuminate\Http\Int $folio
     */
    public function counterOfMenus(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = [];
            $requestList = BecaView::select("status as counter", DB::raw("COUNT(status) as total"), "user_id")->groupBy('status', "user_id")->get();
            $requestPayments = BecaPaidView::select(DB::raw("CONCAT('PAGO',payments) as counter"), DB::raw("COUNT(payments) as total"))->where('active', 1)->groupBy('payments')->get();
            // $requestPayments = BecaPaid::select(DB::raw("CONCAT('PAGO',payments) as counter"), DB::raw("COUNT(payments) as total"))->where('active', 1)->groupBy('payments')->get();
            $usersList = User::select("roles.role as counter", DB::raw("COUNT(role_id) as total"))
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->groupBy('role_id')->get();

            array_push($list, ...$requestList);
            // array_push($list, ...$requestPayments);
            array_push($list, ...$usersList);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | contadores de los menus';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $msg =  "Error al consultar contador de los menus: " . $ex->getMessage();
            $response->data = ObjResponse::CatchResponse($msg);
        }
        return response()->json($response, $response->data["status_code"]);
    }
}