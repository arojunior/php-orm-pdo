<?php

namespace SimpleORM\app\model;

use SimpleORM\app\model\AppModel;

class Users extends AppModel
{
    protected $table    = 't_user';
    protected $pk       = 'user_id';
}
