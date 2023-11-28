<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjResponse extends Model
{
    public static function CorrectResponse() {
        $response = [
            "status_code" => 200,
            "status" => true,
            "message" => "petición satisfactoria.",
            "alert_icon" => "success",
            "alert_title" => "EXITO!",
            "alert_text" => "",
            "result" => [],
            "toast"=> true, 
        ];
        return $response;
    }

    public static function DefaultResponse() {
        $response = [
            "status_code" => 500,
            "status" => false,
            "message" => "no se logro completar la petcion.",
            "alert_icon" => "informative",
            "alert_title" => "Lo sentimos.",
            "alert_text" => "Hay un problema con el servidor. Intenete más tarde.",
            "result" => [],
            "toast"=> false, 
        ];
        return $response;
    }

    public static function CatchResponse($message) {
        $message ?? "Ocurrio un error, verifica tus datos.";
        error_log($message);
        $response = [
            "status_code" => 400,
            "status" => false,
            "message" => $message,
            "alert_icon" => "error",
            "alert_title" => "Oppss!",
            "alert_text" => "Algo salio mal, verifica tus datos.",
            "result" => [],
            "toast"=> false, 
        ];
        return $response;
    }
}