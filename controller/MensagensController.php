<?php

class MensagensController extends Controller
{
    public $use = ['Usuarios'];

    public function registrar($dados)
    {
        if (!empty($dados)) {
            $this->Mensagens->save($dados);
        } else {
            throw new Exception('Acesso indevido');
        }
    }

    public function sala($dados)
    {
        if (!empty($dados)) {
            $result = $this->Mensagens->find([
                'conditions' => ['chat_evento_id' => $dados['evento_id']],
            ]);

            $helper = new Helper();
            echo $helper->json($result);
        } else {
            throw new Exception('Acesso indevido');
        }
    }

    public function teste()
    {
        $result = $this->Usuarios->find();
        $helper = new Helper();
        echo $helper->json($result);
    }
}
