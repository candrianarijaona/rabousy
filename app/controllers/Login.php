<?php
namespace app\controllers;

/**
 * Description of Login
 *
 * @author fanambinantsoa
 */
class Login extends \core\Controller {
    public function index() {
        if($this->isPost()) {
            $server     = $this->post("server");
            $username   = $this->post("username");
            $password   = $this->post("password");
            $db = new \core\Db($server, $username, $password);
            if(!$db->link) {
                $this->set_viewdata("error", true);
            } else {
                $this->session_set("server", $server);
                $this->session_set("username", $username);
                $this->session_set("password", $password);
                $this->redirect("index");
            }
        }
        $this->set_layout("login");
        $this->render();
    }
    
    public function logout() {
        session_destroy();
        $this->redirect("");
    }
}
