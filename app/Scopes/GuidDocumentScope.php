<?php


namespace App\Scopes;


use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class GuidDocumentScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
        $builder->select(['*', DB::raw('CAST(GuidDocument AS VARCHAR(36)) AS GuidDocument')]);
    }
}
