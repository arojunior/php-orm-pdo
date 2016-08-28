<?php

class Controller
{
    public function __construct()
    {
        $class = str_replace('Controller', '', get_class($this));
        $this->{$class} = new $class();

        self::loadModels();
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
