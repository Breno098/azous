<?php

namespace Azuos\Database;

class Schema
{
    private $db;
    private $table;
    private $columns = [];

    public function __construct()
    {
        $this->db = new Database;
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function column()
    {
        $column = new SchemaColumn();
        $this->columns[] = $column;
        return $column;
    }

    public function addColumn(string $name, string $type, int $length = null)
    {
        $column = $this->column()->name($name)->type($type);
        if($length){
            $column->length($length);
        }
        return $column;
    }

    public function id()
    {
        return $this->addColumn('id', 'int')->primaryKey()->autoIncrement();
    }

    public function string(string $name, int $length = 255)
    {
        return $this->addColumn($name, 'varchar', $length);
    }

    public function char(string $name, int $length = 255)
    {
        return $this->addColumn($name, 'char', $length);
    }

    public function int(string $name)
    {
        return $this->addColumn($name, 'int');
    }

    public function bigInt(string $name)
    {
        return $this->addColumn($name, 'bigInt');
    }

    public function boolean(string $name)
    {
        return $this->addColumn($name, 'boolean');
    }

    public function enum(string $name, array $range)
    {
        $values = [];
        foreach ($range as $r) {
           $values[] = is_string($r) ? "'{$r}'" : $r;
        }
        $values = implode(',', $values);
        return $this->addColumn($name, " enum ({$values}) ");
    }

    public function time(string $name)
    {
        return $this->addColumn($name, 'time');
    }

    public function float(string $name)
    {
        return $this->addColumn($name, 'float');
    }

    public function text(string $name)
    {
        return $this->addColumn($name, 'text');
    }

    public function timestamp(string $name)
    {
        return $this->addColumn($name, 'timestamp');
    }

    public function date(string $name)
    {
        return $this->addColumn($name, 'date');
    }

    public function datetime(string $name)
    {
        return $this->addColumn($name, 'datetime');
    }

    public function create()
    {
        $columns = implode(',', $this->columns);
        $this->db->statements(" create table if not exists {$this->table} ({$columns}) ");
    }

    public function drop()
    {
        $this->db->statements(" drop table if exists {$this->table} ");
    }

    public function createOrReplace()
    {
        $this->drop();
        $this->create();
    }
}