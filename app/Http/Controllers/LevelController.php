<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ObjResponse;
use App\Models\Level;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    /**
     * Mostrar lista de niveles activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Level::where('active', true)
                ->orderBy('levels.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de niveles.';
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
            $list = Level::where('active', true)
                ->select('levels.id as id', 'levels.level as label')
                ->orderBy('levels.level', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de niveles';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear nivel.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $duplicate = $this->validateAvailableData($request->level, null);
            if ($duplicate["result"] == true) {
                $response->data = $duplicate;
                return response()->json($response);
            }

            $new_level = Level::create([
                'level' => $request->level,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | nivel registrado.';
            $response->data["alert_text"] = 'Nivel registrado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar nivel.
     *
     * @param   int $id
     * @return \Illuminate\Http\Response $response
     */
    public function show(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $level = Level::where('id', $id)
                ->select('levels.id', 'levels.level')
                ->first();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | nivel encontrado.';
            $response->data["result"] = $level;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar nivel.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $duplicate = $this->validateAvailableData($request->level, $request->id);
            if ($duplicate["result"] == true) {
                $response->data = $duplicate;
                return response()->json($response);
            }

            $level = Level::where('id', $request->id)
                ->update([
                    'level' => $request->level,
                ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | nivel actualizado.';
            $response->data["alert_text"] = 'Nivel actualizado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) nivel.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Level::where('id', $id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | nivel eliminado.';
            $response->data["alert_text"] = 'Nivel eliminado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    private function validateAvailableData($level, $id)
    {
        #este codigo se pone en las funciones de registro y edicion
        // $duplicate = $this->validateAvailableData($request->username, $request->email, $request->id);
        // if ($duplicate["result"] == true) {
        //     $response->data = $duplicate;
        //     return response()->json($response);
        // }
        $checkAvailable = new UserController();
        // #VALIDACION DE DATOS REPETIDOS
        $duplicate = $checkAvailable->checkAvailableData('levels', 'level', $level, 'El nivel', 'level', $id, null);
        if ($duplicate["result"] == true) return $duplicate;
        return array("result" => false);
    }
}
