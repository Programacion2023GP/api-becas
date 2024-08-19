<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beca7DocumentData extends Model
{
    use HasFactory;

    /**
     * Especificar la conexion si no es la por default
     * @var string
     */
    //protected $connection = "mysql_becas";

    /**
     * Los atributos que se pueden solicitar.
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'b7_beca_id',
        'b7_img_tutor_ine',
        'b7_approved_tutor_ine',
        'b7_comments_tutor_ine',
        'b7_img_tutor_ine_back',
        'b7_approved_tutor_ine_back',
        'b7_comments_tutor_ine_back',
        'b7_img_tutor_power_letter',
        'b7_approved_tutor_power_letter',
        'b7_comments_tutor_power_letter',
        'b7_img_second_ref',
        'b7_approved_second_ref',
        'b7_comments_second_ref',
        'b7_img_proof_address',
        'b7_approved_proof_address',
        'b7_comments_proof_address',
        'b7_img_curp',
        'b7_approved_curp',
        'b7_comments_curp',
        'b7_img_birth_certificate',
        'b7_approved_birth_certificate',
        'b7_comments_birth_certificate',
        'b7_img_academic_transcript',
        'b7_approved_academic_transcript',
        'b7_comments_academic_transcript',
        'b7_finished',
        'active',
        'deleted_at'
    ];

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'beca_7_documents_data';

    /**
     * LlavePrimaria asociada a la tabla.
     * @var string
     */
    protected $primaryKey = 'id';


    // /**
    //  * Obtener discapacidad asociada con el alumno.
    //  */
    // public function disability()
    // {   //primero se declara FK y despues la PK del modelo asociado
    //     return $this->belongsTo(Disability::class, 'disability_id', 'id');
    // }


    /**
     * Obtener los usuarios relacionados a un rol.
     */
    // public function users()
    // {
    //     return $this->hasMany(User::class,'role_id','id'); //primero se declara FK y despues la PK
    // }

    /**
     * Valores defualt para los campos especificados.
     * @var array
     */
    // protected $attributes = [
    //     'active' => true,
    // ];
}
