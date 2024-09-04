<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
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
        'description',
        'monthly_income_min',
        'total_expenses_min',
        'budget',
        'total_payments',
        'payment_frequency',
        'max_approved',
        'opportunities',
        'request_enabled',
        'start_date_request',
        'closing_date_request',
        'cycle_id',
        'active',
        'deleted_at'
    ];

    /**
     * Los atributos que no se pueden llenar (se protegen).
     * @var array<int, string>
     */
    protected $guarded = ['id']; // Protege solo ciertos campos

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'settings';

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
