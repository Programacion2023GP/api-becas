<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BecaPayment2View extends Model
{
    /**
     * Especificar la conexion si no es la por default
     * @var string
     */
    //protected $connection = "mysql_becas";

    /**
     * Nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'vw_becas_payment_2';

    /**
     * LlavePrimaria asociada a la tabla.
     * @var string
     */
    protected $primaryKey = 'id';
}
