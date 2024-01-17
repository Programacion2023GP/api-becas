<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beca5HouseholdEquipmentData extends Model
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
        'b5_beca_id',
        'b5_beds',
        'b5_washing_machines',
        'b5_boilers',
        'b5_tvs',
        'b5_pcs',
        'b5_phones',
        'b5_music_player',
        'b5_stoves',
        'b5_refrigerators',
        'b5_drinking_water',
        'b5_electric_light',
        'b5_sewer_system',
        'b5_pavement',
        'b5_automobile',
        'b5_phone_line',
        'b5_internet',
        'b5_score',
        'b5_finished',
        'active',
        'deleted_at'
    ];

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'beca_5_household_equipment_data';

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
