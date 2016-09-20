<?php

//namespace SimpleORM\core\controller\Controller;

class Controller
{
    /*
    * create instance of model with same controller name
    */
    public function __construct()
    {
        $class = str_replace('Controller', '', get_class($this));
        $this->{$class} = new $class();

        self::loadModels();
    }

    /*
    * create instances of models with different names when set $this->use = []
    */
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
