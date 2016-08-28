<?php

class UsuariosController extends Controller
{
    public function login($dados)
    {
        if (!empty($dados)) {
            $dados['nome'] = utf8_decode($dados['nome']);
            $this->model->save($dados);
        } else {
            throw new Exception('Acesso indevido');
        }
    }
}
