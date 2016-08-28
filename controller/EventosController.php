<?php

class EventosController extends Controller
{
    public function listar()
    {
        $result = $this->Eventos->find([
            'fields' => ['id', 'nome'],
            'conditions' => ['status' => 'A'],
        ]);

        $helper = new Helper();
        echo $helper->json($result);
    }
}
