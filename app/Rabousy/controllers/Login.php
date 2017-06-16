<?php

namespace Rabousy\Controllers;
use Core\Controller;
use Core\Db;

/**
 * Class Login
 * @package Rabousy\Controllers
 * @author crazafimahatratra
 */
class Login extends Controller
{
    public function index()
    {
        if ($this->isPost()) {
            $server = $this->post("server");
            $username = $this->post("username");
            $password = $this->post("password");
            $db = new Db($server, $username, $password);

            if (!$db->link) {
                $error = true;
            } else {
                $this->session_set("server", $server);
                $this->session_set("username", $username);
                $this->session_set("password", $password);
                $this->redirect("index");
            }
        }

        $this->render('layouts/login', [
            'error' => isset($error) ? $error : false,
        ]);
    }

    public function logout()
    {
        session_destroy();
        $this->redirect("");
    }
}
