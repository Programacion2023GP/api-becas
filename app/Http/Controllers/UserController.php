<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ObjResponse;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    /**
     * Metodo para validar credenciales e
     * inicar sesión
     * @param Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function login(Request $request, Response $response)
    {
        $field = 'username';
        $value = $request->username;
        if ($request->email) {
            $field = 'email';
            $value = $request->email;
        }

        $request->validate([
            $field => 'required',
            'password' => 'required'
        ]);
        $user = User::where("users.$field", "$value")->where('users.active', 1)
            ->join("roles", "users.role_id", "=", "roles.id")
            ->select("users.*", "roles.role", "roles.read", "roles.create", "roles.update", "roles.delete", "roles.more_permissions")
            ->orderBy('users.id', 'desc')
            ->first();


        if (!$user || !Hash::check($request->password, $user->password)) {

            throw ValidationException::withMessages([
                'message' => 'Credenciales incorrectas',
                'alert_title' => 'Credenciales incorrectas',
                'alert_text' => 'Credenciales incorrectas',
                'alert_icon' => 'error',
            ]);
        }
        $token = $user->createToken($user->email, ['user'])->plainTextToken;
        // dd();
        $response->data = ObjResponse::CorrectResponse();
        $response->data["message"] = "peticion satisfactoria | usuario logeado. " . Auth::user();
        $response->data["result"]["token"] = $token;
        $response->data["result"]["user"] = $user;
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Metodo para cerrar sesión.
     * @param int $id
     * @return \Illuminate\Http\Response $response
     */
    public function logout(Response $response)
    {
        try {
            // DB::connection('mysql_becas')->table('personal_access_tokens')->where('tokenable_id', $id)->delete();
            // Auth::user()->currentAccessToken()->delete(); #Elimina solo el token activo

            auth()->user()->tokens()->delete(); #Utilizar este en caso de que el usuario desee cerrar sesión en todos lados o cambie informacion de su usuario / contraseña

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | sesión cerrada.';
            $response->data["alert_title"] = "Bye!";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Reegistrarse como jugador.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function signup(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $duplicate = $this->validateAvailableData($request->username, $request->email, null);
            if ($duplicate["result"] == true) {
                $response->data = $duplicate;
                return response()->json($response);
            }

            $new_user = User::create([
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role_id' => 3,  //usuario normal
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario registrado.';
            $response->data["alert_text"] = "REGISTRO EXITOSO! <br>Bienvenido $request->username!";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Mostrar lista de usuarios activos del
     * uniendo con roles.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Int $role_id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            // $list = DB::select('SELECT * FROM users where active = 1');
            // User::on('mysql_gp_center')->get();
            //  $list = User::where('users.active', true)->where("role_id", ">=", $role_id)
            $list = User::where("role_id", ">=", $role_id)
                ->join('roles', 'users.role_id', '=', 'roles.id')
                // ->join('departments', 'users.department_id', '=', 'departments.id')
                ->select('users.*', 'roles.role')
                // ->select('users.*', 'roles.role', 'departments.department', 'departments.description as department_description')
                ->orderBy('users.id', 'desc')
                ->get();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | lista de usuarios.';
            $response->data["alert_text"] = "usuarios encontrados";
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar lista de usuarios activos por role
     * uniendo con roles.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function indexByrole(Int $role_id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            // $list = DB::select('SELECT * FROM users where active = 1');
            // User::on('mysql_gp_center')->get();
            $roleAuth = Auth::user()->role_id;
            $signo = "=";
            $signo = $role_id == 2 && $roleAuth == 1 ? "<=" : "=";


            $list = User::where('users.active', true)->where("role_id", $signo, $role_id)
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->select('users.*', 'roles.role')
                ->orderBy('users.id', 'desc')
                ->get();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | lista de usuarios.';
            $response->data["alert_text"] = "usuarios encontrados";
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
            $list = User::where('active', true)
                ->select('users.id as id', 'users.username as label')
                ->orderBy('users.username', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | lista de usuarios.';
            $response->data["alert_text"] = "usuarios encontrados";
            $response->data["result"] = $list;
            $response->data["toast"] = false;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear usuario.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            // $token = $request->bearerToken();

            $duplicate = $this->validateAvailableData($request->username, $request->email, null);
            if ($duplicate["result"] == true) {
                $response->data = $duplicate;
                return response()->json($response);
            }

            $new_user = User::create([
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario registrado.';
            $response->data["alert_text"] = "Usuario registrado";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar usuario.
     *
     * @param   int $id
     * @return \Illuminate\Http\Response $response
     */
    public function show(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $user = User::where('users.id', $id)
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->select('users.*', 'roles.role')
                ->first();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario encontrado.';
            $response->data["alert_text"] = "Usuario encontrado";
            $response->data["result"] = $user;
        } catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar usuario.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $duplicate = $this->validateAvailableData($request->username, $request->email, $request->id);
            if ($duplicate["result"] == true) {
                $response->data = $duplicate;
                return response()->json($response);
            }

            $user = User::where('id', $request->id)
                ->update([
                    // 'name' => $request->name,
                    // 'last_name' => $request->last_name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    // 'phone' => $request->phone,
                    'role_id' => $request->role_id,
                ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario actualizado.';
            $response->data["alert_text"] = "Usuario actualizado";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * "Eliminar" (cambiar estado activo=false) usuario.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            User::where('id', $id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario eliminado.';
            $response->data["alert_text"] = "Usuario eliminado";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * "Activar o Desactivar" (cambiar estado activo) usuario.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response $response
     */
    public function DisEnableUser(Int $id, Int $active, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            User::where('id', $id)
                ->update([
                    'active' => (bool)$active
                ]);

            $description = $active == "0" ? 'desactivado' : 'reactivado';
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = "peticion satisfactoria | usuario $description.";
            $response->data["alert_text"] = "Usuario $description";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar usuario o usuarios.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroyMultiple(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            // echo "$request->ids";
            // $deleteIds = explode(',', $ids);
            $countDeleted = sizeof($request->ids);
            User::whereIn('id', $request->ids)->update([
                'active' => false,
                'deleted_at' => date('Y-m-d H:i:s'),
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $countDeleted == 1 ? 'peticion satisfactoria | usuario eliminado.' : "peticion satisfactoria | usuarios eliminados ($countDeleted).";
            $response->data["alert_text"] = $countDeleted == 1 ? 'Usuario eliminado' : "Usuarios eliminados  ($countDeleted)";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    /**
     * Funcion para guardar una imagen en directorio fisico, elimina y guarda la nueva al editar la imagen para no guardar muchas
     * imagenes y genera el path que se guardara en la BD
     * 
     * @param $image File es el archivo de la imagen
     * @param $destination String ruta donde se guardara fisicamente el archivo
     * @param $dir String ruta que mandara a la BD
     * @param $imgName String Nombre de como se guardará el archivo fisica y en la BD
     */
    public function ImgUpload($image, $destination, $dir, $imgName)
    {
        try {
            // return "ImgUpload->aqui todo bien";
            $type = "JPG";
            $permissions = 0777;

            if (file_exists("$dir/$imgName.PNG")) {
                // Establecer permisos
                if (chmod("$dir/$imgName.PNG", $permissions)) {
                    @unlink("$dir/$imgName.PNG");
                }
                $type = "JPG";
            } elseif (file_exists("$dir/$imgName.JPG")) {
                // Establecer permisos
                if (chmod("$dir/$imgName.JPG", $permissions)) {
                    @unlink("$dir/$imgName.JPG");
                }
                $type = "PNG";
            }
            $imgName = "$imgName.$type";
            $image->move($destination, $imgName);
            return "$dir/$imgName";
        } catch (\Error $err) {
            $msg = "error en imgUpload(): " . $err->getMessage();
            error_log($msg);
            return "$msg";
        }
    }

    private function validateAvailableData($username, $email, $id)
    {
        // #VALIDACION DE DATOS REPETIDOS
        $duplicate = $this->checkAvailableData('users', 'username', $username, 'El nombre de usuario', 'username', $id, null);
        if ($duplicate["result"] == true) return $duplicate;
        $duplicate = $this->checkAvailableData('users', 'email', $email, 'El correo electrónico', 'email', $id, null);
        if ($duplicate["result"] == true) return $duplicate;
        return array("result" => false);
    }

    public function checkAvailableData($table, $column, $value, $propTitle, $input, $id, $secondTable = null)
    {
        if ($secondTable) {
            $query = "SELECT count(*) as duplicate FROM $table INNER JOIN $secondTable ON user_id=users.id WHERE $column='$value' AND active=1;";
            if ($id != null) $query = "SELECT count(*) as duplicate FROM $table t INNER JOIN $secondTable ON t.user_id=users.id WHERE t.$column='$value' AND active=1 AND t.id!=$id";
        } else {
            $query = "SELECT count(*) as duplicate FROM $table WHERE $column='$value' AND active=1";
            if ($id != null) $query = "SELECT count(*) as duplicate FROM $table WHERE $column='$value' AND active=1 AND id!=$id";
        }
        //   echo $query;
        $result = DB::select($query)[0];
        //   var_dump($result->duplicate);
        if ((int)$result->duplicate > 0) {
            // echo "entro al duplicate";
            $response = array(
                "result" => true,
                "status_code" => 409,
                "alert_icon" => 'warning',
                "alert_title" => "$propTitle no esta disponible!",
                "alert_text" => "$propTitle no esta disponible! - $value ya existe, intenta con uno diferente.",
                "message" => "duplicate",
                "input" => $input,
                "toast" => false
            );
        } else {
            $response = array(
                "result" => false,
            );
        }
        return $response;
    }
}
