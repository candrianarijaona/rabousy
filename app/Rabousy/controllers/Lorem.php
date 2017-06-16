<?php

namespace Rabousy\Controllers;

use Core\Controller;

/**
 * Class Lorem
 * @package Rabousy\Controllers
 * @author crazafimahatratra
 */
class Lorem extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_lorems()
    {
        $db = new \core\DbFile("lorem.db");
        $lorems = $db->get();
        $this->json_response(array('lorems' => $lorems));
    }
}
