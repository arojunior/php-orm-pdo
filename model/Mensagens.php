<?php

class Mensagens extends Model
{
    protected $table = 'chat_mensagem_sala';
    //protected $pk = 'id';

    public function sala($evento_id)
    {
        $this->query("
        SELECT
        	Usuarios.nome as 'usuario_nome',
            Usuario.id as 'usuario_id',
        	Mensagens.mensagem,
        	Mensagens.`data`
        FROM chat_mensagem_sala as Mensagens

        INNER JOIN chat_usuarios as Usuarios ON
        	Usuarios.id = Mensagens.`chat_usuario_id`

        WHERE
        	Mensagens.`chat_evento_id` = {$evento_id}"
        );
    }
}
