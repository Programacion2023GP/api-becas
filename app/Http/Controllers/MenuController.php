<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\ObjResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Mostrar lista de menus por rol activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function MenusByRole(String $pages_read, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Menu::where('menus.active', true)
                ->orderBy('menus.order', 'asc')->get();
            if ($pages_read != "todas") {
                $menus_ids = rtrim($pages_read, ",");
                $menus_ids = explode(",", $menus_ids);
                // print_r($menus_ids) ;
                $list = Menu::where('menus.active', true)
                    ->whereIn("menus.id", $menus_ids)
                    ->orderBy('menus.order', 'asc')->get();
            }
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de menus por rol.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Obtener id de la pagina por su url.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function getIdByUrl(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $menu = Menu::where('url', $request->url)->select("id")->first();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de menus.';
            $response->data["result"] = $menu;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * "Activar o Desactivar" (cambiar estado activo) menu.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response $response
     */
    public function DisEnableMenu(Int $id, Int $active, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Menu::where('id', $id)
                ->update([
                    'active' => (bool)$active
                ]);

            $description = $active == "0" ? 'desactivado' : 'reactivado';
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | menu $description.";
            $response->data["alert_text"] = "Menú $description";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    //#region CRUD

    /**
     * Mostrar lista de menus activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Menu::leftJoin('menus as patern', 'menus.belongs_to', '=', 'patern.id')
                ->select('menus.*', 'patern.menu as patern')
                ->orderBy('menus.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de menus.';
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
            $list = Menu::where('active', true)
                ->select('menus.id as id', 'menus.menu as label')
                ->orderBy('menus.menu', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de menus';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear un nuevo menu.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $new_menu = Menu::create([
                'menu' => $request->menu,
                'description' => $request->description,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | menu registrado.';
            $response->data["alert_text"] = 'Menú registrado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar menu.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $menu = Menu::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | menu encontrado.';
            $response->data["result"] = $menu;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar menu.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $menu = Menu::find($request->id)
                ->update([
                    'menu' => $request->menu,
                    'description' => $request->description,
                ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | menu actualizado.';
            $response->data["alert_text"] = 'Menú actualizado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) menu.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Menu::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | menu eliminado.';
            $response->data["alert_text"] = 'Menú eliminado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    //#endregion CRUD


}
