<?php

namespace Azous\Database;

use PDO;

class Database
{
    protected $db;
    protected $table;
    protected $where;
    protected $joins = [];
    protected $columns;
    protected $orders = [];
    protected $prepareValues = [];
    protected $prepareValuesWhere = [];
    protected $query;
    protected $whereCount = 0;
    protected $limits = [];

    public function __construct()
    {
        try {
            $this->db = new PDO(
                env('DB_DRIVER') .':host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME'), 
                env('DB_USER'), 
                env('DB_PASS')
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
    }

    public function connect()
    {
        if (!$this->db) new Database();
        return $this->db;
    }

    public function query(string $query, array $prepareValues = [])
    {
        $this->query = $query;
        $this->prepareValues = $prepareValues;
        return $this->run();
    }

    public function statements(string $statements, array $prepareValues = [])
    {
        $this->query = $statements;
        $this->prepareValues = $prepareValues;
        return $this->execute();
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function join(string $table, string $condition1, string $operator, string $condition2, string $variant = '')
    {
        $this->joins[] = " {$variant} join {$table} on {$condition1} {$operator} {$condition2} ";
        return $this;
    }

    public function leftJoin(string $table, string $condition1, string $operator, string $condition2)
    {
        return $this->oin($table, $condition1, $operator, $condition2, 'left');
    }

    public function rightJoin(string $table, string $condition1, string $operator, string $condition2)
    {
        return $this->oin($table, $condition1, $operator, $condition2, 'right');
    }

    public function columns(...$columns)
    {
        if( \is_array($columns[0]) ){
            $this->columns = $columns[0];
        } else {
            $this->columns = $columns;
        }
        return $this;
    }

    public function orderBy(string $column, string $type = 'asc')
    {
        $this->orders[] = " {$column} {$type} ";
        return $this;
    }

    public function where(string $column, string $operator, $value, $type = 'and')
    {
        $this->where[] = $this->erify_type($type) . " {$column} {$operator} ? ";
        $this->prepareValuesWhere[] = $value; 
        return $this;
    }

    public function whereOr(string $column, string $operator, string $value)
    {
        $this->here($column, $operator, $value, 'or');
        return $this;
    }

    public function between(string $column, $value1, $value2, string $type = 'and')
    {
        $this->where[] = $this->erify_type($type) . " {$column} between ? and ? ";
        $this->prepareValuesWhere[] = $value1; 
        $this->prepareValuesWhere[] = $value2; 
        return $this;
    }

    public function betweenOr(string $column, $value1, $value2)
    {
        return $this->etween($column, $value1, $value2, 'or');
    }

    public function isNull(string $column, string $type = 'and')
    {
        $this->where[] = $this->erify_type($type) . " {$column} is null ";
        return $this;
    }

    public function isNotNull(string $column, string $type = 'and')
    {
        $this->where[] = $this->erify_type($type) . " {$column} is not null ";
        return $this;
    }

    public function limit($limit)
    {
        $this->limits['limit'] = (int) $limit;
        return $this;
    }

    public function first()
    {
        return $this->limit(1);
    }

    public function offset($offset)
    {
        $this->limits['offset'] = (int) $offset;
        return $this;
    }

    public function paginated($offset, $limit = 10)
    {
        $this->limit($limit);
        return $this->offset($offset);
    }

    public function get()
    {
        $this->process_select();
        return $this->run();
    }

    public function set()
    {
        return $this->execute();
    }

    private function run()
    {
        $stmt = $this->connect()->prepare( $this->query );
        $stmt->execute( $this->prepareValues );
        $this->prepareValues = [];
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function execute()
    {
        $stmt = $this->connect()->prepare( $this->query );
        $stmt->execute( $this->prepareValues );
        $this->prepareValues = [];
    }

    private function verify_type(string $type)
    {
        return ++$this->whereCount === 1 ? '' : $type;
    }

    public function insert(...$inserts)
    {
        foreach ($inserts as $values) {
            $columns = [];
            $prepareValues = [];
            foreach ($values as $column => $value) {
                $columns[] = $column;
                $prepareValues[] = '?';
                $this->prepareValues[] = $value;
            }

            $columns = implode(',', $columns);
            $prepareValues = implode(',', $prepareValues);
            $this->query = " insert into {$this->table} ({$columns}) values ({$prepareValues}) ";
            $this->execute();
        }
    }

    public function update(array $updates = [])
    {
        $sets = [];
        foreach ($updates as $column => $value) {
            $sets[] = " {$column} = ? ";
            $this->prepareValues[] = $value;
        }
        $sets = implode(',', $sets);
        $this->query = " update {$this->table} set {$sets} ";
        $this->process_where();
        return $this;
    }

    public function delete()
    {
        $this->query = " delete from {$this->table} ";
        $this->process_where();
        return $this->execute();
    }

    public function truncate()
    {
        $this->query = " truncate table {$this->table} ";
        return $this->execute();
    }

    public function process_select()
    {
        $this->query = ' select ';
        $this->process_columns();
        $this->process_table();
        $this->process_joins();
        $this->process_where();
        $this->process_orders();
        $this->process_limits();
        return $this->query;
    }

    private function process_columns()
    {
        $this->query .= !empty($this->columns) && is_array($this->columns) ? implode(",", $this->columns) : ' * '; 
    }

    private function process_where()
    {
        !empty($this->where) ? $this->query .= ' where ' . implode(' ', $this->where) : null;
        foreach ($this->prepareValuesWhere as $value) {
            $this->prepareValues[] = $value;
        }
    }

    private function process_table()
    {
        $this->query .= " from {$this->table} ";
    }

    private function process_joins()
    {
       !empty($this->joins) ? $this->query .= implode(' ', $this->joins) : null;
    }

    private function process_orders()
    {
        !empty($this->orders) ? $this->query .= ' order by ' . implode(',', $this->orders) : null;
    }

    private function process_limits()
    {
        if(empty($this->limits)) 
            return false;

        isset($this->limits['limit'])  ? $this->query .= " limit  {$this->limits['limit']}  " : " limit 1000000 ";
        isset($this->limits['offset']) ? $this->query .= " offset {$this->limits['offset']} " : null;
    }
}