<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentosDigitales extends Model
{
    protected $connection = 'sql_content';

    protected $table = 'DocumentContent';
}
