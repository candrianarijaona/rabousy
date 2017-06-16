<?php
namespace app\controllers;
/**
 * Description of Lorem
 *
 * @author fanambinantsoa
 */
class Lorem extends \core\Controller {
    public function __construct() {
        parent::__construct();
    }
    
    public function get_lorems() {
        $db = new \core\DbFile("lorem.db");
        $lorems = $db->get();
        $this->json_response(array('lorems' => $lorems));
    }
}
