<?php

class Controller
{
    protected $model;

    public function __construct()
    {
        $class = str_replace('Controller', '', get_class($this));
        $this->model = new $class();
    }

    private function loadModels()
    {
        if (isset($this->use)) {
            foreach ($this->use as $model) {
                require './model/'.$model.'.php';
                $this->{$model} = new $model();
            }
        }
    }
}
