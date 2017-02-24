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
        $result = $this->Users->findById('arojunior@gmail.com');

        return ['list' => $this->Helper->toJson($result)];
    }

    public function add()
    {
        $data = ['email' => 'arojunior@gmail.com'];
        $this->Users->store($data);
    }

}
