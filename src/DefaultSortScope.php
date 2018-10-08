<?php
namespace HeppyKarlsson\DefaultSort;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DefaultSortScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {


        if(! property_exists($model, 'defaultSort')) {
            throw new DefaultSortException('To use the DefaultSort trait you need to declare the property "defaultSort"');
        }

        $columns = $model->defaultSort;

        if(! is_array($columns)) {
            $columns = [$columns];
        }


        foreach($columns as $column => $method) {
            if(($method == 'DESC' || $method == 'ASC') && $column) {
                $builder->orderBy($column, $method);
            }
            else {
                // In this case the Method is actually the column.
                if($method) {
                    $builder->orderBy($method);
                }
            }
        }
    }

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function remove(Builder $builder, Model $model)
    {
        $column = $model->defaultSortColumn;
        $query = $builder->getQuery();

        $query->wheres = collect($query->orders)->reject(function ($where) use ($column) {
            return $this->isRemovedConstraint($where, $column);
        })->values()->all();
    }

    protected function isRemovedConstraint($where, $column)
    {
        return $where['type'] == 'Null' && $where['column'] == $column;
    }


}