<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filter
{
    /**
     * @var Request
     */
    protected $request;
    
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var Array
     */
    protected $filters = [];

    /**
     * ThreadsFilter constructor
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply filters to the given query builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {

            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function getFilters()
    {
        return $this->request->intersect($this->filters);
    }
}