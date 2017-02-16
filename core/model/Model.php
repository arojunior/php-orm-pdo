<?php

namespace SimpleORM\core\model;

use SimpleORM\core\model\Database;
use \PDO;

class Model extends Database
{
    private $stmt;
    private $dados;
    private $sql;
    public  $count;

    public function __construct()
    {
        parent::__construct();
        self::setTable();
        self::setPrimaryKey();
    }

    private function setTable()
    {
        if ( ! isset($this->table)) {
            $this->table = strtolower(get_class($this));
        }
    }

    private function setPrimaryKey()
    {
        if ( ! isset($this->pk)) {
            $this->pk = 'id';
        }
    }

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
            return  implode(',', $this->dados['fields']);
        }

        foreach ($dados as $k => $v) {
            $fields[] = $k;
        }
        $fields = implode(',', $fields);

        return $fields;
    }

    private function conditions($separator)
    {
        foreach ($this->dados['conditions'] as $k => $v) {
            $where[] = "{$k} = :{$k}";
        }

        return 'WHERE '.implode($separator, $where);
    }

    private function find()
    {
        $fields = (isset($this->dados['fields'])) ? self::fields() : '*';
        $where = (isset($this->dados['conditions'])) ? self::conditions(' AND ') : '';
        $sql = "SELECT {$fields} FROM {$this->table} {$where}";
        $this->stmt = $this->conn->prepare($sql);

        if ( ! empty($where)) {
            self::param();
        }

        return $this->stmt->execute();
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
        $sql    = "INSERT INTO {$this->table} ({$fields}) VALUES ({$values})";

        return $sql;
    }

    public function findAll($dados = null)
    {
        $this->dados = $dados;
        self::find();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOne($dados = null)
    {
        $this->dados['conditions'] = $dados;
        self::find();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        return self::findOne([$this->pk => $id]);
    }

    public function query($sql)
    {
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->count = count($result);

        return $result;
    }

    public function save($dados)
    {
        if (isset($dados[$this->pk])) {
            $this->find([$this->pk => $dados[$this->pk]]);
        }

        if ($this->count > 0) {
            return $this->update($dados);
        }

        return $this->create($dados);
    }

    public function update($dados)
    {
        $param = $dados;

        $this->dados['conditions'] = [$this->pk => $dados[$this->pk]];
        $where = self::conditions('');
        unset($dados[$this->pk]);
        $this->dados['conditions'] = $dados;
        $fields = str_replace('WHERE', '', self::conditions(','));

        $sql = "UPDATE {$this->table} SET {$fields} {$where}";
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
