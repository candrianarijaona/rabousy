<?php

namespace Core;

/**
 * Class Db
 * @package Core
 * @author crazafimahatratra
 */
class Db
{
    var $link;

    public function __construct($server, $username, $password)
    {
        $this->link = mysqli_connect($server, $username, $password);
    }

    public function __destruct()
    {
        if ($this->link) {
            mysqli_close($this->link);
        }
    }

    /**
     * Get list of available databases
     * @return array
     */
    public function get_databases()
    {
        $dbs = $this->query("SHOW DATABASES");
        $arr = array();
        foreach ($dbs as $row) {
            if (in_array($row['Database'], array('information_schema', 'performance_schema', 'sys', 'mysql'))) {
                continue;
            }
            $arr[] = $row;
        }
        return $arr;
    }

    /**
     * Performs a query
     * @param string $query
     * @return array
     */
    public function query($query)
    {
        $result = mysqli_query($this->link, $query);
        $array = array();
        while ($row = mysqli_fetch_array($result)) {
            $array[] = $row;
        }
        return $array;
    }

    /**
     * Get tables of a database
     * @return array
     */
    public function get_tables($dbname)
    {
        $this->use_db($dbname);
        return $this->query("SHOW TABLES");
    }

    /**
     * Change current database
     * @param string $dbname
     */
    public function use_db($dbname)
    {
        mysqli_select_db($this->link, $dbname);
    }

    /**
     * Get list of columns
     * @param string $dbname
     * @param string $table
     * @return array
     */
    public function get_columns($dbname, $table)
    {
        $this->use_db($dbname);
        return $this->query("DESCRIBE $table");
    }

    /**
     * Get parent table for foreign keys
     * @param string $db_name
     * @param string $table
     * @param string $column
     * @return string
     */
    public function get_parent_table($db_name, $table, $column)
    {
        $this->use_db("information_schema");
        $query = "select * from key_column_usage where table_name = '$table' and table_schema='$db_name' and column_name='$column'";

        return $this->query_row($query);
    }

    /**
     * Query row
     * @param string $query
     * @return array
     */
    public function query_row($query)
    {
        $result = mysqli_query($this->link, $query);
        return mysqli_fetch_array($result);
    }

    /**
     * Count
     * @param string $table
     * @return int
     */
    public function count($table)
    {
        $res = $this->query_row("SELECT COUNT(*) AS N FROM $table");
        return (int)$res['N'];
    }

    /**
     * Insert into table
     * @param string $table
     * @param array $data
     * @return string
     */
    public function insert($table, array $data)
    {
        $array_columns = array_keys($data);
        $array_values = $this->values($data);
        $columns = implode(",", $array_columns);
        $values = implode(",", $array_values);
        $query = "INSERT INTO $table($columns) values($values)";
        $this->query($query);
        return $query;
    }

    /**
     * @param $data
     * @return array
     */
    private function values($data)
    {
        $array = array();
        foreach ($data as $value) {
            $array[] = "'" . mysqli_escape_string($this->link, $value) . "'";
        }
        return $array;
    }

    /**
     * @param $table
     * @param $data
     * @return string
     */
    public function insert_batch($table, $data)
    {
        $array_columns = array_keys($data[0]);
        $array_values = array();
        foreach ($data as $row) {
            $v = $this->values($row);
            $s = implode(",", $v);
            $array_values[] = "(" . $s . ")";
        }

        $columns = implode(",", $array_columns);
        $values = implode(",", $array_values);
        $query = "INSERT INTO $table($columns) values $values";
        $this->query($query);
        return $query;
    }
}
