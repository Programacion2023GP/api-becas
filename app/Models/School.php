<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
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
        'code',
        'level_id',
        'school',
        'community_id',
        'street',
        'num_ext',
        'num_int',
        // 'city_id',
        // 'colony_id',
        'phone',
        'director',
        'loc_for',
        'type',
        'zona',
        'active',
        'deleted_at'
    ];

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'schools';

    /**
     * LlavePrimaria asociada a la tabla.
     * @var string
     */
    protected $primaryKey = 'id';


    // /**
    //  * Obtener ciudad asociada con la escuela.
    //  */
    // public function city()
    // {   //primero se declara FK y despues la PK del modelo asociado
    //     return $this->belongsTo(City::class, 'city_id', 'id');
    // }

    // /**
    //  * Obtener ciudad asociada con la escuela.
    //  */
    // public function colony()
    // {   //primero se declara FK y despues la PK del modelo asociado
    //     return $this->belongsTo(Colony::class, 'colony_id', 'id');
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
