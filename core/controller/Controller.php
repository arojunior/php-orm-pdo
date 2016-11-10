<?php

namespace SimpleORM\core\controller;

require CORE . 'helper' . DS . 'Helper.php';
use SimpleORM\core\helper\Helper;

class Controller
{
    private $class;
    /*
    * create instance of model with same controller name
    */
    public function __construct()
    {
        $namespace = 'SimpleORM\app\controller\\';
        $class = str_replace($namespace, '', get_class($this));
        $this->class = str_replace('Controller', '', $class);

        $this->Helper = new Helper();

        self::loadModels();
        self::loadHelpers();
    }

    /*
    * create instances of models with different names when set $this->use = []
    */
    private function loadModels()
    {
        $this->use = !isset($this->use) ? [$this->class] : $this->use;

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
        require APP . $path . DS . $class . '.php';
        $load_class = 'SimpleORM\app\\' . $path . '\\' . $class;
        $this->{$class} = new $load_class();
    }
}
