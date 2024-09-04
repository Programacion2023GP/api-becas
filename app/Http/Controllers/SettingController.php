<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Mostrar lista de ajustes activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Setting::where('settings.active', true)
                ->orderBy('settings.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de ajustes.';
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
            $list = Setting::where('settings.active', true)
                ->select('settings.id as id', 'settings.description as label')
                ->orderBy('settings.description', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de ajustes';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear o Actualizar ajustes desde formulario beca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function createOrUpdate(Request $request, Response $response, Int $id = null, bool $internal = false)
    {
        try {
            $response->data = ObjResponse::DefaultResponse();

            $setting = Setting::find($id);
            if (!$setting) $setting = new Setting();

            $setting->fill($request->all());

            $setting->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $id > 0 ? "satisfactoria | ajustes actualizados" : 'satisfactoria | ajustes registrados.';
            $response->data["alert_text"] = $id > 0 ? "Ajustes actualizados" : "Ajustes registrados";
            $response->data["result"] = $setting;
            if (!$internal) return response()->json($response, $response->data["status_code"]);
            else return $setting;
        } catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar ajustes por medio de la beca: " . $ex->getMessage();
            error_log("$msg");
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
            if (!$internal) return response()->json($response, $response->data["status_code"]);
            else return "$msg";
        }
    }

    /**
     * Eliminar ajustes o ajustes.
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
            Setting::whereIn('id', $request->ids)->delete();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | ajustes eliminados ($countDeleted).";
            $response->data["alert_text"] = "Documentos de Becas eliminados  ($countDeleted)";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    /**
     * Mostrar ajustes.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $student_data = Setting::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | ajustes encontrados.';
            $response->data["result"] = $student_data;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    /**
     * Eliminar (cambiar estado activo=false) ajustes.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Setting::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | ajustes eliminados.';
            $response->data["alert_text"] = 'Documentos de Becas eliminados';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
