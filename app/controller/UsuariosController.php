<?php

namespace SimpleORM\app\controller;

use SimpleORM\core\controller\Controller;

class UsuariosController extends Controller
{

    public function index()
    {
        return ['texto'  => 'teste'];
    }

    public function listar()
    {
        $result = $this->Usuarios->find();

        return ['listagem' => $this->Helper->json($result)];
    }
}
