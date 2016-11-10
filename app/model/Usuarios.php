<?php

namespace SimpleORM\app\model;

require_once APP . 'model' . DS .'AppModel.php';
use SimpleORM\app\model\AppModel;

class Usuarios extends AppModel
{
    protected $table = 'usuarios';
    //protected $pk = 'id';
}
