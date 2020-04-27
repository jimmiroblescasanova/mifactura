<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class addDocumentContent extends Model
{
    protected $connection = 'sql_content';

    protected $table = 'DocumentContent';
}
