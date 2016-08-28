<?php

class Controller
{
    protected $model;

    public function __construct()
    {
        $class = str_replace('Controller', '', get_class($this));
        $this->model = new $class();
    }
}
