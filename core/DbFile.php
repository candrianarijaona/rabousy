<?php

namespace core;

define('DBFILE_ERROR_FNOTFOUND', -1);

/**
 * Description of DbFile
 *
 * @author fanambinantsoa
 */
class DbFile {

    /**
     * Filename
     * @var string
     */
    var $filename;

    /**
     * File for writing
     * @var ressource 
     */
    var $wfile;

    /**
     * Headers
     * @var array
     */
    var $headers;

    /**
     * Constructor
     * @param string $filename
     */
    public function __construct($filename) {
        $this->filename = $filename;
        $this->getHeader();
    }

    /**
     * Filter rows
     * @param array $rows
     * @param array $where
     * @return array
     */
    private function filter($rows, $where) {
        $newrows = array();
        foreach ($rows as $row) {
            if ($this->checkCondition($row, $where)) {
                $newrows[] = $row;
            }
        }
        return $newrows;
    }

    /**
     * Check if a row verifies the condition
     * @param array $row
     * @param array $where
     * @return bool
     */
    private function checkCondition($row, $where) {
        $keep = true;
        foreach ($where as $key => $value) {
            $keep &= ($row[$key] == $value);
        }
        return $keep;
    }

    /**
     * Get all lines
     * @return type
     */
    public function get($where = array()) {
        $file = fopen($this->filename, "r");
        $r = array();
        $i = 0;
        while ($line = fgets($file)) {
            if ($i++ == 0)
                continue;
            $tab = explode(";", $line, -1);
            $row = array();
            foreach ($this->headers as $index => $h) {
                $row[$h] = $tab[$index];
            }
            $r[] = $row;
        }
        fclose($file);
        if (!empty($where))
            return $this->filter($r, $where);
        return $r;
    }

    /**
     * replace all content by $rows
     * @param array $rows
     */
    private function replace($rows) {
        $file = fopen($this->filename, "r");
        $tmpfile = $this->filename . time() . ".tmp";
        $wfile = fopen($tmpfile, "w");
        $header = implode(";", $this->headers) . ";\n";
        fwrite($wfile, $header);
        foreach ($rows as $row) {
            $arr = array();
            foreach ($this->headers as $header) {
                $arr[] = $row[$header];
            }
            $line = implode(";", $arr) . ";\n";
            fwrite($wfile, $line);
        }
        fclose($file);
        fclose($wfile);
        rename($tmpfile, $this->filename);
    }

    /**
     * Get the next id
     * @return int
     */
    private function next_id() {
        $rows = $this->get();
        $count = count($rows);
        if ($count === 0)
            return 1;
        return $rows[$count - 1]['id'] + 1;
    }

    /**
     * Array copy
     * @param type $data
     * @param type $row
     */
    private function array_copy($data, &$row) {
        foreach ($data as $index => $value) {
            $row[$index] = $value;
        }
    }

    /**
     * Insert data
     * @param array $data
     */
    public function insert($data) {
        $next_id = $this->next_id();
        $rows = $this->get();
        $data['id'] = $next_id;
        $rows[] = $data;
        $this->replace($rows);
        return $next_id;
    }

    /**
     * Updates a row
     * @param array $data
     * @param array $where
     */
    public function update($data, $where) {
        $rows = $this->get();
        $newrows = array();
        foreach ($rows as $row) {
            if ($this->checkCondition($row, $where)) {
                $this->array_copy($data, $row);
            }
            $newrows[] = $row;
        }
        $this->replace($newrows);
    }

    /**
     * Deletes a row
     * @param type $where
     */
    public function delete($where) {
        $rows = $this->get();
        $newrows = array();
        foreach ($rows as $row) {
            $keep = true;
            foreach ($where as $key => $value) {
                $keep &= ($row[$key] != $value);
            }
            if ($keep) {
                $newrows[] = $row;
            }
        }
        $this->replace($newrows);
        return $newrows;
    }

    /**
     * Gets the header metadata
     */
    public function getHeader() {
        $file = fopen($this->filename, "r");
        $line = fgets($file);
        $this->headers = explode(";", $line, -1);
        fclose($file);
    }

}
