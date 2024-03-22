<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerScore extends Model
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
        'family_1',
        'economic_1',
        'economic_2',
        'house_1',
        'house_2',
        'house_3',
        'household_equipment_1',
        'household_equipment_2',
        'household_equipment_3',
        'household_equipment_4',
        'household_equipment_5',
        'household_equipment_6',
        'household_equipment_7',
        'household_equipment_8',
        'household_equipment_9',
        'service_1',
        'service_2',
        'service_3',
        'service_4',
        'service_5',
        'service_6',
        'service_7',
        'scholarship_1',
        'scholarship_2',
        'scholarship_3',
        'scholarship_4',
        'total_score',
        'active',
        'deleted_at'
    ];

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'answers_scores';

    /**
     * LlavePrimaria asociada a la tabla.
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Obtener los usuarios relacionados a un rol.
     */
    // public function users()
    // {
    //     return $this->hasMany(User::class, 'role_id', 'id'); //primero se declara FK y despues la PK
    // }

    /**
     * Valores defualt para los campos especificados.
     * @var array
     */
    // protected $attributes = [
    //     'active' => true,
    // ];
}