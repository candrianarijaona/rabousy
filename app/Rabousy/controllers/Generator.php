<?php

namespace Rabousy\Controllers;

use Core\Controller;
use Core\Db;
use Core\DbFile;

/**
 * Class Generator
 * @package Rabousy\Controllers
 * @author crazafimahatratra
 */
// TODO generate automatically ENUM columns
class Generator extends Controller
{

    var $dbfile;
    var $db;
    var $dblorem;
    var $row_index;

    public function __construct()
    {
        parent::__construct();
        $server = $this->session_get("host");
        $username = $this->session_get("username");
        $password = $this->session_get("password");

        $this->dbfile = new DbFile("elements.db");
        $this->dblorem = new DbFile("lorem.db");
        $this->db = new Db($server, $username, $password);
    }

    public function generate()
    {
        header("Content-type: text/json");
        $post = $this->json_post();
        $rows = array();
        $this->db->use_db($post['database']);
        for ($i = 0; $i < $post['nb_rows']; $i++) {
            $this->row_index = $i;
            $rows[] = $this->generate_row($post['columns']);
        }
        
        $sql = $this->db->insert_batch($post['table'], $rows);
        $this->json_response($sql);
    }

    private function generate_row($columns)
    {
        $newcolumns = array();
        foreach ($columns as $column) {
            if (!isset($column['mode']))
                continue;
            $value = '';
            switch ($column['mode']) {
                case 'L':
                    $value = $this->randomize_list($column);
                    break;
                case 'S':
                    $value = $column['value'];
                    break;
                case 'I':
                    $value = $this->randomize_interval($column);
                    break;
                case 'N':
                    $value = $this->increment_value($column);
                    break;
                case 'K':
                    $value = $this->randomize_table($column);
                    break;
                case 'M':
                    $value = $this->lorem($column);
                    break;
                case 'MR':
                    $value = $this->randomize_lorem();
                    break;
            }
            $newcolumns[$column['Field']] = $this->apply_post_function($column, $value);
        }
        return $newcolumns;
    }

    private function randomize_list($column)
    {
        $elements = $this->dbfile->get(array('list_id' => $column['list_id']));
        $labels = array_map(array($this, "label"), $elements);
        $label = array_rand($labels);
        return $labels[$label];
    }

    private function randomize_interval($column)
    {
        if ($column['Type'] === 'date' || $column['Type'] === 'datetime') {
            $d1 = strtotime($column['min']);
            $d2 = strtotime($column['max']);
            $d = rand($d1, $d2);
            return date("Y-m-d H:i:s", $d);
        } else {
            return rand($column['min'], $column['max']);
        }
    }

    private function increment_value($column)
    {
        $i = $column['start_value'] + $column['increment'] * $this->row_index;
        return $i;
    }

    private function randomize_table($column)
    {
        if ($column['Key'] !== 'MUL') return "";
        $this->db->use_db($column['parent']['REFERENCED_TABLE_NAME']);
        $sql = "SELECT DISTINCT {$column['parent']['REFERENCED_COLUMN_NAME']} FROM {$column['parent']['REFERENCED_TABLE_NAME']}";
        $values = $this->db->query($sql);
        $newvalues = array();
        foreach ($values as $v) {
            $newvalues[] = $v[$column['parent']['REFERENCED_COLUMN_NAME']];
        }
        return $newvalues[array_rand($newvalues)];
    }

    private function lorem($column)
    {
        if (!isset($column['lorem_id']) || empty($column['lorem_id'])) return "";
        $lorem = $this->dblorem->get(array('id' => $column['lorem_id']));
        return $lorem[0]['content'];
    }

    private function randomize_lorem()
    {
        $lorems = $this->dblorem->get();
        $contents = array_map(array($this, "content"), $lorems);
        $content = array_rand($contents);
        return $contents[$content];
    }

    private function apply_post_function($column, $value)
    {
        if (!isset($column['post_function']) || empty($column['post_function']))
            return $value;
        switch ($column['post_function']) {
            case 'str_pad':
                $pad_length = (isset($column['pad_length']) && !empty($column['pad_length'])) ? $column['pad_length'] : 1;
                $pad_string = (isset($column['pad_char']) && (strlen($column['pad_char']) > 0)) ? $column['pad_char'] : ' ';
                $pad_type = (isset($column['pad_type']) && (strlen($column['pad_type']) > 0)) ? $column['pad_type'] : STR_PAD_RIGHT;
                return str_pad($value, $pad_length, $pad_string, $pad_type);
            case 'strtoupper':
                return strtoupper($value);
            case 'strtolower':
                return strtolower($value);
            case 'substr':
                $length = (isset($column['substr_length']) && (strlen($column['substr_length']) > 0)) ? $column['substr_length'] : 0;
                return substr($value, 0, $length);
        }
    }

    private function label($array)
    {
        return $array['label'];
    }

    private function content($array)
    {
        return $array['content'];
    }

}
