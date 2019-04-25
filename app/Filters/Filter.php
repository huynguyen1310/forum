<?php 

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filter {

    protected $request;
    protected $builder;

    protected $filters = [];

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function apply($builder) {

        $this->builder = $builder;
        foreach ($this->getFilter() as $filter => $value) {
            if(method_exists($this,$filter)){
                $this->$filter($value);
            }
        }

        return $this->builder;
        
    }

    protected function getFilter() {
        $filters = array_intersect(array_keys($this->request->all()), $this->filters);
        return $this->request->only($filters);
    }

} 