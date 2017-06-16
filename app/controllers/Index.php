<?php
namespace app\controllers;

/**
 * Description of Index
 *
 * @author fanambinantsoa
 */
class Index extends \core\Controller {
    public function index() {
        $username = $this->session_get("username");
        if(empty($username)) {
            $this->redirect("login");
        }
        $this->render();
    }
}
