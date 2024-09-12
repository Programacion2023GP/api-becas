<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BecaPaymentDetail extends Model
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
        'beca_id',
        'paid_by',
        'paid_to_tutor',
        'amount_paid',
        'img_evidence',
        'paid_feedback',
        'active',
        'deleted_at'
    ];

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'becas_payment_details';

    /**
     * LlavePrimaria asociada a la tabla.
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * Obtener usuario asociada con la beca aprovada.
     */
    public function user()
    {   //primero se declara FK y despues la PK del modelo asociado
        return $this->belongsTo(User::class, 'paid_by', 'id');
    }

    /**
     * Obtener beca asociada con la beca aprovada.
     */
    public function beca()
    {   //primero se declara FK y despues la PK del modelo asociado
        return $this->belongsTo(Beca::class, 'beca_paid_id', 'id');
    }


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
