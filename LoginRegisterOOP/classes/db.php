<?php

class DB
{
    private static $_instance = null;
    private $_pdo,
    $_query,
    $_error = false,
    $_results,
    $_count = 0;
    private function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get("mysql/username"), Config::get('mysql/password'));
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    public function query($sql, $params = array())
    {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    public function action($action, $table, $where = array())
    {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action}  FROM {$table}  WHERE {$field} {$operator} ?";
                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    public function get($table, $where)
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function results()
    {
        return $this->_results;
    }

    public function first()
    {
        return $this->results()[0];
    }

    public function delete($table, $where)
    {
        return $this->action('DELETE ', $table, $where);
    }

    public function insert($table, $field = array())
    {

        $keys = array_keys($field);
        $values = '';
        $x = 1;

        foreach ($field as $fields) {
            $values .= '?';
            if ($x < count($field)) {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`)VALUES ({$values}) ";

        if ($this->query($sql, $field)->error()) {
            return true;
        }
        return false;
    }

    public function update($table, $id, $field)
    {
        $set = '';
        $x = 1;



        foreach($field as $name => $value)
        {
            $set .= "`$name` = ?";
            if($x < count($field))
            {
                $set .= ', ';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set}  WHERE id = {$id}";
        if(!$this->query($sql, $field)->error())
        {
            return true;
        }
        return false;
    }

    public function error()
    {
        return $this->_error;
    }

    public function count()
    {
        return $this->_count;
    }
}