<?php

class MensagensController extends Controller
{
    public function registrar($dados)
    {
        if (!empty($dados)) {
            $this->model->save($dados);
        } else {
            throw new Exception('Acesso indevido');
        }
    }

    public function listar($dados)
    {
        if (!empty($dados)) {
            $result = $this->model->find([
                'conditions' => ['chat_evento_id' => $dados['evento_id']],
            ]);

            $helper = new Helper();
            echo $helper->json($result);
        } else {
            throw new Exception('Acesso indevido');
        }
    }
}
