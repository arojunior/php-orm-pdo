<?php

namespace SimpleORM\app\model\contracts;

interface UsersInterface
{
    public function findAll();

    public function store($data);

    public function remove($id);
}
