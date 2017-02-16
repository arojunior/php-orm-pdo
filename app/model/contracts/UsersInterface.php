<?php

namespace SimpleORM\app\model\contracts;

interface UsersInterface
{
    public function store($data);

    public function remove($id);
}
