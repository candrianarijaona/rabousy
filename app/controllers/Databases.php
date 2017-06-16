<?php
namespace app\controllers;

/**
 * Description of Databases
 *
 * @author christophe
 */
class Databases extends \core\Controller {
    /**
     *
     * @var \core\Db
     */
    var $db;
    
    public function __construct() {
        parent::__construct();
        $server = $this->session_get("server");
        $username = $this->session_get("username");
        $password = $this->session_get("password");
        $this->db = new \core\Db($server, $username, $password);
    }
    
    public function get_dbs() {
        $dbs = $this->db->get_databases();
        $this->json_response(array('databases' => $dbs));
    }
    
    public function get_tables($db_name) {
        $tables = $this->db->get_tables($db_name);
        $this->json_response(array('tables' => $tables));
    }
    
    public function get_columns($db_name, $table) {
        $columns = $this->db->get_columns($db_name, $table);
        $res = array();
        foreach($columns as $column) {
            if($column['Key'] === 'MUL') {
                $column['parent'] = $this->db->get_parent_table($db_name, $table, $column['Field']);
            }
            $res[] = $column;
        }
        $nb = $this->db->count($table);
        $this->json_response(array('columns' => $res, 'nb_rows' => $nb));
    }
}
