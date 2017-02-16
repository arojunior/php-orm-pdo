<?php

namespace SimpleORM\app\model;

use SimpleORM\app\model\AppModel;
use SimpleORM\app\model\contracts\UsersInterface;

class Users extends AppModel implements UsersInterface
{
    protected $table    = 't_user';
    protected $pk       = 'email';

    public function store($data)
    {
        return $this->save($data);
    }

    public function remove($id)
    {

    }
}
