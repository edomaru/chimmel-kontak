<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class SearchScope implements Scope
{
    protected $searchColumns = ['first_name', 'last_name', 'email', 'company.name'];

    public function apply(Builder $builder, Model $model)
    {
        if ($search = request('search')) 
        {
            foreach ($this->searchColumns as $index => $column) 
            {
                $arr = explode('.', $column);
                $method = $index === 0 ? "where" : "orWhere";

                if (count($arr) == 2) 
                {
                    $method .= "Has";

                    list($relationship, $col) = $arr;

                    $builder->$method($relationship, function($query) use ($search, $col) {
                        $query->where($col, 'LIKE', "%{$search}%");
                    });
                }
                else {
                    $builder->$method($column, 'LIKE', "%{$search}%");
                }
            }
        }
    }
}