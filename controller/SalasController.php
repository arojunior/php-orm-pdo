<?php

class SalasController extends Controller
{
    public function registrar($dados)
    {
        if (!empty($dados)) {
            $this->Salas->save($dados);
        } else {
            throw new Exception('Acesso indevido');
        }
    }
}
