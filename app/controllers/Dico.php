<?php
namespace app\controllers;

/**
 * Description of Dico
 *
 * @author fanambinantsoa
 */
class Dico extends \core\Controller {
    var $db;
    var $db_elts;
    public function __construct() {
        parent::__construct();
        $this->db = new \core\DbFile("list.db");
        $this->db_elts = new \core\DbFile("elements.db");
    }
    
    public function get_lists() {
        $rows = $this->db->get();
        $this->json_response(array('lists' => $rows));
    }
    
    public function remove() {
        $post = $this->json_post();
        $rows = $this->db->delete(array('id' => $post['id']));
        $this->json_response($rows);
    }
    
    public function save() {
        $post = $this->json_post();
        if(isset($post['id']) && !empty($post['id'])) {
            $this->db->update(array('label' => $post['label']), array('id' => $post['id']));
        } else {
            $this->db->insert(array('label' => $post['label']));
        }
    }
    
    public function get_elements($list_id) {
        $elements = $this->db_elts->get(array('list_id' => $list_id));
        $this->json_response(array('elements' => $elements));
    }
    
    public function save_elements() {
        $post = $this->json_post();
        $data = array('list_id' => $post['list_id'], 'label' => $post['label']);
        $this->db_elts->insert($data);
    }
    
    public function remove_element() {
        $post = $this->json_post();
        $this->db_elts->delete(array('id' => $post['id']));
    }
}
