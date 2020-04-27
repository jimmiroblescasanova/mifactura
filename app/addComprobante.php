<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class addComprobante extends Model
{
    protected $connection = "sql_metadata";

    protected $table = 'Comprobante';

    protected $dates = [
        'Fecha',
        'FechaTimbrado',
    ];

    protected $casts = [
      'Total' => 'double',
    ];

}
