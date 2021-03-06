<?php

namespace SimpleORM\core\controller;

use SimpleORM\core\helper\Helper;

abstract class Controller
{
    private $class;
    /*
    * create instance of model with same controller name
    */
    public function __construct()
    {
        $this->Helper = new Helper();

        $this->class = self::setClass();
        self::loadModels();
        self::loadHelpers();
    }

    private function setClass()
    {
        $className = (new \ReflectionClass($this))->getShortName();

        return str_replace('Controller', '', $className);
    }

    /*
    * create instances of models with different names when set $this->use = []
    */
    private function loadModels()
    {
        $this->use = ( ! isset($this->use)) ? [$this->class] : $this->use;

        if ($this->use) {
            foreach ($this->use as $model) {
                self::load('model', $model);
            }
        }
    }

    private function loadHelpers()
    {
        if (isset($this->helpers)) {
            foreach ($this->helpers as $helper) {
                self::load('helper', $helper);
            }
        }
    }

    private function load($path, $class)
    {
        $load_class = 'SimpleORM\app\\' . $path . '\\' . $class;
        $this->{$class} = new $load_class();
    }
}
