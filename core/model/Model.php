<?php

namespace SimpleORM\core\model;

use SimpleORM\core\model\Database;

class Model extends Database
{
    private $stmt;
    private $dados;
    private $sql;
    public $count;

    private function param($dados = null)
    {
        if (empty($dados)) {
            $dados = $this->dados['conditions'];
        }

        foreach ($dados as $k => $v) {
            $tipo = (is_int($v)) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $this->stmt->bindValue(":{$k}", $v, $tipo);
        }
    }

    private function fields($dados = null)
    {
        if (empty($dados)) {
            $fields = implode(',', $this->dados['fields']);
        } else {
            foreach ($dados as $k => $v) {
                $fields[] = $k;
            }
            $fields = implode(',', $fields);
        }

        return $fields;
    }

    private function conditions($separator)
    {
        foreach ($this->dados['conditions'] as $k => $v) {
            $where[] = "{$k} = :{$k}";
        }

        return 'WHERE '.implode($separator, $where);
    }

    private function table()
    {
        return (isset($this->table)) ? $this->table : strtolower(get_class($this));
    }

    public function find($dados = null)
    {
        $this->dados = $dados;

        $fields = (isset($this->dados['fields'])) ? self::fields() : '*';
        $table = self::table();
        $where = (isset($this->dados['conditions'])) ? self::conditions(' AND ') : '';
        $sql = "SELECT {$fields} FROM {$table} {$where}";
        $this->stmt = $this->conn->prepare($sql);

        if (!empty($where)) {
            self::param();
        }

        $this->stmt->execute();

        $result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->count = count($result);

        return $result;
    }

    public function query($sql)
    {
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->count = count($result);

        return $result;
    }

    private function values()
    {
        foreach ($this->dados as $k => $v) {
            $values[] = ":{$k}";
        }

        return implode(',', $values);
    }

    private function insert()
    {
        $fields = self::fields($this->dados);
        $values = self::values();
        $table = self::table();
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$values})";

        return $sql;
    }

    public function save($dados)
    {
        if (!isset($this->pk)) {
            $this->pk = 'id';
        }

        if (isset($dados[$this->pk])) {
            $this->find([$this->pk => $dados[$this->pk]]);
            if ($this->count > 0) {
                $this->update($dados);
            } else {
                $this->create($dados);
            }
        }
    }

    public function update($dados)
    {
        $param = $dados;
        $table = self::table();

        if (!isset($this->pk)) {
            $this->pk = 'id';
        }

        $this->dados['conditions'] = [$this->pk => $dados[$this->pk]];
        $where = self::conditions('');
        unset($dados[$this->pk]);
        $this->dados['conditions'] = $dados;
        $fields = str_replace('WHERE', '', self::conditions(','));

        $sql = "UPDATE {$table} SET {$fields} {$where}";
        $this->stmt = $this->conn->prepare($sql);
        self::param($param);
        $this->stmt->execute();
        $this->count = $this->stmt->rowCount();
    }

    public function create($dados)
    {
        $this->dados = $dados;

        $this->stmt = $this->conn->prepare(self::insert());
        self::param($dados);
        $this->stmt->execute();
        $this->count = $this->stmt->rowCount();
    }
}
