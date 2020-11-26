<?php

namespace Azuos\Database;

class SchemaColumn
{
    private $name;
    private $type;
    private $length;
    private $default;
    private $enum;
    private $primaryKey = false;
    private $foreignKey = false;
    private $acceptNull = true;
    private $autoIncrement = false;

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    public function length($length)
    {
        $this->length = $length;
        return $this;
    }

    public function acceptNull(bool $acceptNull = true)
    {
        $this->acceptNull = $acceptNull;
        return $this;
    }

    public function primaryKey()
    {
        $this->primaryKey = true;
        return $this;
    }

    public function autoIncrement()
    {
        $this->autoIncrement = true;
        return $this;
    }

    public function default($value)
    {
        $this->default = $value;
        return $this;
    }

    public function defaultCurrent()
    {
        $this->default = '(keyword)current_timestamp';
        return $this;
    }

    public function foreignKey(string $table, string $column = 'id', string $options = '')
    {
        $this->foreignKey['table'] = $table;
        $this->foreignKey['column'] = $column;
        $this->foreignKey['options'] = $options;
        return $this;
    }

    public function onDeleteCascade()
    {
        $this->foreignKey['options'] = 'on delete cascade';
        return $this;
    }

    public function onUpdateCascade()
    {
        $this->foreignKey['options'] = 'on update cascade';
        return $this;
    }

    public function onDeleteSetNull()
    {
        $this->foreignKey['options'] = 'on delete set null';
        return $this;
    }

    public function notNull()
    {
        return $this->acceptNull(false);
    }

    public function __toString()
    {
        $stringColumn = " {$this->name} {$this->type} ";
        if($this->length){
            $stringColumn .= "({$this->length})";
        }
        if($this->enum){
            $stringColumn .= $this->enum;
        }
        if($this->default){
            $stringColumn .= " default ";
            $stringColumn .= is_string($this->default) && strpos($this->default, '(keyword)') === false ? " '{$this->default}' " : str_replace('(keyword)', '', $this->default);
            $this->acceptNull(true);
        }
        if(!$this->acceptNull){
            $stringColumn .= " not null ";
        }
        if($this->autoIncrement){
            $stringColumn .= " auto_increment ";
        }
        if($this->primaryKey){
            $stringColumn .= " primary key ";
        }
        if($this->foreignKey){
            $nameFk = "fk_{$this->name}_{$this->foreignKey['table']}_{$this->foreignKey['column']}";
            $stringColumn .= " , constraint foreign key {$nameFk} ({$this->name}) references {$this->foreignKey['table']} ({$this->foreignKey['column']}) ";
            if($this->foreignKey['options']){
                $stringColumn .= $this->foreignKey['options'];
            }
        }
        return $stringColumn;
    }
    

}