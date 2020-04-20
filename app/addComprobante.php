<?php

namespace App;

use App\Scopes\GuidDocumentScope;
use Illuminate\Database\Eloquent\Model;
use Str;

class addComprobante extends Model
{
    protected $connection = "sql_metadata";

    protected $table = 'Comprobante';

    protected $casts = [
        'GuidDocument' => 'string',
    ];

}
