<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class addConceptos extends Model
{
    protected $connection = 'sql_metadata';

    protected $table = 'Conceptos';

    protected $casts = [
        'Cantidad' => 'integer',
        'ValorUnitario' => 'double',
        'Importe' => 'double',
    ];
}
