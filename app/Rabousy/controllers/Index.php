<?php

namespace Rabousy\Controllers;

use Core\Controller;

/**
 * Class Index
 * @package Rabousy\Controllers
 * @author crazafimahatratra
 */
class Index extends Controller
{
    /**
     *
     */
    public function index()
    {
        $username = $this->session_get("username");
        if (empty($username)) {
            $this->redirect("login");
        }

        $this->render('layouts/default', [

        ]);
    }
}
