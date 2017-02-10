<?php

namespace SimpleORM\app\controller;

use SimpleORM\core\controller\Controller;

class UsersController extends Controller
{

    public function index()
    {
        return ['texto'  => 'teste'];
    }

    public function get()
    {
        $result = $this->Users->find();

        return ['list' => $this->Helper->toJson($result)];
    }
}
