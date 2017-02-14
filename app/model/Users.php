<?php

namespace SimpleORM\app\model;

use SimpleORM\app\model\AppModel;
use SimpleORM\app\model\contracts\UsersInterface;

class Users extends AppModel implements UsersInterface
{
    protected $table    = 't_user';
    protected $pk       = 'user_id';

    public function findAll()
    {
        return $this->find();
    }

    public function store($data)
    {
        return $this->save($data);
    }

    public function remove($id)
    {

    }
}
