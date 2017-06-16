<?php
namespace core;

/**
 * It's an application
 *
 * @author fanambinantsoa
 */
class App {
    const DEFAULT_CONTROLLER = "Index";
    const DEFAULT_ACTION = "index";
    const DEFAULT_LAYOUT = "default";
    
    const CONTROLLERS_PATH = "app\\controllers";
    const VIEWS_PATH = "app/views";
    const LAYOUTS_PATH = "app/views/layouts";
    
    /**
     * The view path
     * @var string
     */
    private static $view_path;
    
    /**
     * View data
     * @var array 
     */
    private static $view_data;
    
    /**
     * The configuration
     * @var array
     */
    static $conf;
    
    /**
     * Current URL
     * @var type 
     */
    var $url;
    
    /**
     * Current controller
     * @var string
     */
    private static $controller;
    
    /**
     * Current action
     * @var string 
     */
    private static $action;
    
    /**
     * Constructor
     */
    public function __construct() {
        $config = array();
        require_once __DIR__ . '/../app/config.php';
        self::$conf  = $config;
        $this->url = filter_input(INPUT_SERVER, "PATH_INFO");
    }
    
    /**
     * Uppercase the first character
     * @param string $string
     * @return string
     */
    protected function upperFirstChar($string) {
        if (strlen($string) === 0) {
            return "";
        }
        return strtoupper($string[0]) . strtolower(substr($string, 1));
    }
    
    /**
     * Gets the controller name
     * @return string
     */
    private function getController() {
        if ($this->url == null) {
            return self::DEFAULT_CONTROLLER;
        }
        $tab = explode("/", $this->url);
        if (count($tab) === 0) {
            return self::DEFAULT_CONTROLLER;
        }
        if (empty($tab[1])) {
            return self::DEFAULT_CONTROLLER;
        }
        return $this->upperFirstChar($tab[1]);
    }
    
    /**
     * Get parameters from url
     * @return type
     */
    protected function getUrlParameters() {
        $tab = explode("/", $this->url);
        return array_slice($tab, 3);
    }
    
    /**
     * Get page
     * @return type
     */
    protected function getPage() {
        if ($this->url == null) {
            return self::DEFAULT_ACTION;
        }
        $tab = explode("/", $this->url);
        if (count($tab) < 3) {
            return self::DEFAULT_ACTION;
        }
        if (empty($tab[2])) {
            return self::DEFAULT_ACTION;
        }
        return ($tab[2]);
    }
    
    /**
     * Run that application
     */
    public function run() {
        $controller = $this->getController();
        $controllerPath = self::CONTROLLERS_PATH . "\\" . $controller;
        if (!class_exists($controllerPath)) {
            http_response_code(400);
            echo "Controller $controller not found";
            exit;
        }
        
        $class = new $controllerPath();
        $page = $this->getPage();
        if (!method_exists($class, $page)) {
            http_response_code(400);
            echo "Page  $page not found in $controller";
            return;
        }
        
        self::$controller = $controller;
        self::$action = $page;
        
        $class->set_layout(self::DEFAULT_LAYOUT);
        $urlParameters = $this->getUrlParameters();
        call_user_func_array(array($class, $page), $urlParameters);
    }
    
    /**
     * Base URL
     * @return string
     */
    public static function base_url() {
        return self::$conf['base_url'];
    }
    
    /**
     * Get current controller
     * @return string
     */
    public static function getCurrentController() {
        return self::$controller;
    }
    
    /**
     * Get current action
     * @return string
     */
    public static function getCurrentAction() {
        return self::$action;
    }
    
    /**
     * Sets view data
     * @param array $data
     */
    public static function setViewData($data) {
        self::$view_data = $data;
    }
    
    /**
     * Get view data
     * @param array $index
     * @return mixed The view data indexed by $index
     */
    public static function data($index) {
        if(isset(self::$view_data[$index])) return self::$view_data[$index];
        return null;
    }
    
    /**
     * Sets The view path
     * @param string $path
     */
    public static function setViewPath($path) {
        self::$view_path = $path;
    }
    
    /**
     * Includes a view
     */
    public static function includeView() {
        include self::$view_path;
    }
}
