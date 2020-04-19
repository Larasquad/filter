<?php

namespace Larasquad\Filter\Traits;

use Larasquad\Filter\Filter;

trait Filterable
{
    /**
     * Apply filters to query scope.
     *
     * @param                     $query
     * @param \App\Filters\Filter $filter
     */
    public function scopeFilter($query, Filter $filter)
    {
        $filter->apply($query);
    }
}
