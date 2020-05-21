<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admDocumentos extends Model
{
    protected $connection = "sqlsrv";

    protected $table = 'admDocumentos';

    protected $dates = [
        'CFECHA',
    ];

    protected $casts = [
        'CTOTAL' => 'double',
        'CPENDIENTE' => 'double',
        'CFOLIO' => 'integer',
    ];

    public function concepto()
    {
        return $this->belongsTo('App\admConceptos', 'CIDCONCEPTODOCUMENTO', 'CIDCONCEPTODOCUMENTO');
    }
}
