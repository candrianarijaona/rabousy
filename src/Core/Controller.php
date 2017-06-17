<?php

namespace Core;

/**
 * Class Controller
 * @package Core
 * @author crazafimahatratra
 */
class Controller {

    /** @var  View */
    protected $view;

    /** @var array */
    protected $config = [];

    /**
     * Constructor
     */
    public function __construct() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        $this->view = new View();
    }

    /**
     * @param array $config
     */
    public function setConfig($config = [])
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get session data
     * @param string $index
     * @return mixed
     */
    public function session_get($index) {
        global $_SESSION;
        if (isset($_SESSION[$index])) {
            return $_SESSION[$index];
        }
        return null;
    }

    /**
     * Set session data
     * @param string $index
     * @param mixed $value
     */
    public function session_set($index, $value) {
        global $_SESSION;
        $_SESSION[$index] = $value;
    }

    /**
     * Redirect to a specific route
     * @param string $controller
     * @param string $action
     */
    public function redirect($controller, $action = "") {
        $url = App::base_url() . "/$controller/$action";
        header("Location: $url");
    }

    /**
     * @param null $template
     * @param array $data
     */
    public function render($template = null, $data = []) {
        $this->view->render($template, $this->config, $data);
    }

    /**
     * Checks if method is post
     * @return bool
     */
    protected function isPost() {
        $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
        return $method === 'POST';
    }

    /**
     * Post data
     * @param string $index
     * @return string
     */
    protected function post($index) {
        if(empty($index)) {
            return filter_input_array(INPUT_POST);
        }
        return filter_input(INPUT_POST, $index);
    }

    /**
     * Post from json input
     * @return mixed
     */
    protected function json_post() {
        $contents = file_get_contents("php://input");
        return json_decode($contents, true);
    }


    /**
     * Output a json response
     * @param array $value
     */
    protected function json_response($value) {
        header("Content-type: text/json");
        echo json_encode($value);
        exit();
    }
}
