<?php

namespace Larasquad\Filter;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Filter
{
    /**
     * Whitelisted request filterable attributes
     *
     * @return array
     */
    protected $filterable = [];

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The query builder.
     *
     * @var
     */
    protected $query;

    /**
     * Filter constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply query scopes
     *
     * @param $query
     */
    public function apply($query)
    {
        $this->query = $query;

        foreach ($this->getFilterables() as $scope => $value) {

            if(!is_null($value)){

                if (method_exists($this, $scope)) {
                    $this->$scope($value);
                }elseif(method_exists($this, Str::camel($scope))){
                    $scope = Str::camel($scope);
                    $this->$scope($value);
                }elseif(method_exists($this, Str::snake($scope))){
                    $scope = Str::snake($scope);
                    $this->$scope($value);
                }else{
                    $this->query->where($scope, $value);
                }
            }
        }
        return $this->query;
    }

    /**
     * Remove any request queries that's not whitelisted.
     *
     * @return array
     */
    protected function getFilterables()
    {
        return $this->request->only($this->filterable);
    }
}
