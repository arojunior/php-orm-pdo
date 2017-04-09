<?php

namespace SimpleORM\app\model;

use SimpleORM\app\model\App;
use SimpleORM\app\model\contracts\Users as iUsers;

class Users extends App implements iUsers
{
    protected $table    = 't_user';
    protected $pk       = 'email';

    public function store($data)
    {
        return $this->save($data);
    }
    
}
