<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ObjResponse;
use App\Models\School;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SchoolBecasController extends Controller
{
    /**
     * Mostrar lista de escuelas activas.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = School::where('schools.active', true)
                ->join('levels', 'schools.level_id', '=', 'levels.id')
                ->select('schools.*', 'levels.level')
                ->orderBy('schools.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de escuelas.';
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
            $list = School::where('schools.active', true)
                ->join('levels', 'schools.level_id', '=', 'levels.id')
                // ->select('schools.id as value', 'schools.school as text')
                ->select('schools.id as id', DB::raw("CONCAT(schools.code,' - ',levels.level,' - ', schools.school) as label"))
                ->orderBy('schools.school', 'asc')->get();
            // $list = School::select(DB::raw("CONCAT(levels.level,' - ', schools.school)"))->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de escuelas';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear escuela.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $new_school = School::create([
                'code' => $request->code,
                'level_id' => $request->level_id,
                'school' => $request->school,
                'community_id' => $request->community_id,
                'street' => $request->street,
                'num_ext' => $request->num_ext,
                'num_int' => $request->num_int,
                'phone' => $request->phone,
                'director' => $request->director,
                'loc_for' => $request->loc_for,
                'zone' => $request->zone,
                // 'type' => $request->type,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | escuela registrada.';
            $response->data["alert_text"] = 'Escuela registrada';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar escuela.
     *
     * @param   int $id
     * @return \Illuminate\Http\Response $response
     */
    public function show(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $school = School::where('schools.id', $id)
                ->join('levels', 'schools.level_id', '=', 'levels.id')
                ->select('schools.*', 'levels.level')
                ->first();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | escuela encontrada.';
            $response->data["result"] = $school;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar escuela.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $school = School::find($request->id)
                ->update([
                    'code' => $request->code,
                    'level_id' => $request->level_id,
                    'school' => $request->school,
                    'community_id' => $request->community_id,
                    'street' => $request->street,
                    'num_ext' => $request->num_ext,
                    'num_int' => $request->num_int,
                    'phone' => $request->phone,
                    'director' => $request->director,
                    'loc_for' => $request->loc_for,
                    'zone' => $request->zone,
                    // // 'type' => $request->type,
                ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | escuela actualizada.';
            $response->data["alert_text"] = 'Escuela actualizada';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) escuela.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            School::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | escuela eliminada.';
            $response->data["alert_text"] = 'Escuela eliminada';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Validar que este disponible el dato.
     *
     * @param  
     * @return \Illuminate\Http\Response $response
     */
    public function checkAvailableData(string $table, string $column, string $value, string $propTitle, string $input, int $id, string $secondTable = null)
    {

        // if ($secondTable) {
        // 	$query = "SELECT count(*) as duplicate FROM $table INNER JOIN $secondTable ON user_id=users.id WHERE $column='$value' AND active=1;";
        // 	if ($id != null) $query = "SELECT count(*) as duplicate FROM $table t INNER JOIN $secondTable ON t.user_id=users.id WHERE t.$column='$value' AND active=1 AND t.id!=$id";
        // } else {
        // 	$query = "SELECT count(*) as duplicate FROM $table WHERE $column='$value' AND active=1";


        // 	if ($id != null) $query = "SELECT count(*) as duplicate FROM $table WHERE $column='$value' AND active=1 AND id!=$id";
        // }

        // $consulta = $this->Select($query,false);
        // if ($consulta["duplicate"] > 0) {
        // 	$response = array(
        // 		"result" => true,
        // 		"alert_icon" => 'warning',
        // 		"alert_title" => "$propTitle no esta disponible!",
        // 		"alert_text" => "<b>$value</b> ya existe, intenta con uno diferente.",
        // 		"message" => "duplicado",
        // 		"input" => $input
        // 	);
        // 	// $response = $this->duplicateResponse($propTitle, $value, $input);
        // } else {
        // 	$response = array(
        // 		"result" => false,
        // 	);
        // }
        // return $response;




        // function validateAvailableData($cellphone, $id) {
        //    // #VALIDACION DE DATOS REPETIDOS
        //    $duplicate = $this->checkAvailableData('candidates', 'cellphone', $cellphone, 'El número celular', 'input_cellphone', $id, 'users');
        //    if ($duplicate["result"] == true) die(json_encode($duplicate));
        // }

        // function getIdByUserId($user_id, $private=true) {
        //    $query = "SELECT id FROM candidates WHERE user_id=$user_id;";
        //    $candidate = $this->Select($query, false);
        //    if ($private) {
        //       echo "ando privado";
        //       if (!$candidate) return 0;
        //       else return $candidate["id"]; 
        //    } else {
        //       echo "ando publico";
        //       if (!$candidate) die(json_encode(array("data" => 0)));
        //       else die(json_encode(array("data" => $candidate["id"]))); 
        //    }
        // }
    }
}
