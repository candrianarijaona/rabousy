<?php

namespace core;

/**
 * Description of Controller
 *
 * @author fanambinantsoa
 */
class Controller {
    /**
     * Current layout
     * @var string
     */
    var $layout;
    
    /**
     * View data
     * @var array
     */
    var $view_data;
    
    /**
     * Constructor
     */
    public function __construct() {
        if (session_id() === "")
            session_start();
        $this->view_data = array();
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
        $url = App::base_url() . "/index.php/$controller/$action";
        header("Location: $url");
    }
    
    /**
     * Sets layout
     * @param type $layout
     */
    public function set_layout($layout) {
        $this->layout = $layout;
    }
    
    /**
     * Renders a view
     */
    public function render() {
        $controller = strtolower(App::getCurrentController());
        $action = strtolower(App::getCurrentAction());
        
        $view_path      = __DIR__ . "/../" . App::VIEWS_PATH . "/$controller/{$action}.php";
        $layout_path    = __DIR__ . "/../" . App::LAYOUTS_PATH . "/{$this->layout}.php";
        if(!is_file($layout_path)) {
            echo "Layout {$this->layout}.php not found";
            http_response_code(400);
            exit;
        }
        App::setViewData($this->view_data);
        App::setViewPath($view_path);
        include "$layout_path";
    }
    
    /**
     * Sets view data
     * @param string $index
     * @param mixed $value
     */
    public function set_viewdata($index, $value) {
        $this->view_data[$index] = $value;
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
     * @return type
     */
    protected function json_post() {
        $contents = file_get_contents("php://input");
        return json_decode($contents, true);
    }


    /**
     * Output a json response
     * @param type $value
     */
    protected function json_response($value) {
        header("Content-type: text/json");
        echo json_encode($value);
        exit();
    }
}
