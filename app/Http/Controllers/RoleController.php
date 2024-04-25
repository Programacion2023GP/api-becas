<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\ObjResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    /**
     * Mostrar lista de roles activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Int $role_id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Role::where("id", ">=", $role_id)
                ->orderBy('roles.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria. Lista de roles:';
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
    public function selectIndex(Int $role_id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Role::where('active', true)->where("id", ">=", $role_id)
                ->select('roles.id as id', 'roles.role as label')
                ->orderBy('roles.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria. Lista de roles:';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear rol.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {

            $menuController = new MenuController();
            $menu = $menuController->show($request, $response, true);


            $new_role = Role::create([
                'role' => $request->role,
                'description' => $request->description,
                'page_index' => $menu->url,
                'read' => $request->read,
                'create' => $request->create,
                'update' => $request->update,
                'delete' => $request->delete,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | rol registrado.';
            $response->data["alert_text"] = 'rol registrado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar rol.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $role = Role::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | rol encontrado.';
            $response->data["result"] = $role;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar rol.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $role = Role::find($request->id)
                ->update([
                    'role' => $request->role,
                    'description' => $request->description,
                    'page_index' => $request->page_index,
                    'read' => $request->read,
                    'create' => $request->create,
                    'update' => $request->update,
                    'delete' => $request->delete,
                ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | rol actualizado.';
            $response->data["alert_text"] = 'Rol actualizado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) rol.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Role::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | rol eliminado.';
            $response->data["alert_text"] = 'Rol eliminado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * "Activar o Desactivar" (cambiar estado activo) rol.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response $response
     */
    public function DisEnableRole(Int $id, Int $active, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Role::where('id', $id)
                ->update([
                    'active' => (bool)$active
                ]);

            $description = $active == "0" ? 'desactivado' : 'reactivado';
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | rol $description.";
            $response->data["alert_text"] = "Rol $description";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar permisos.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function updatePermissions(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $role = Role::find($request->id);
            $role->read = $request->read;
            $role->create = $request->create;
            $role->update = $request->update;
            $role->delete = $request->delete;
            $role->more_permissions = $request->more_permissions;

            $role->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | permisos actualizado.';
            $response->data["alert_text"] = 'Permisos actualizados';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
