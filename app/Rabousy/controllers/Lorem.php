<?php

namespace Rabousy\Controllers;

use Core\Controller;
use Core\DbFile;

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
        $this->json_response([
            'lorems' => (new DbFile("lorem.db"))->get()
        ]);
    }
}
