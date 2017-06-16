<?php

namespace Core;

/**
 * Class App
 * @package core
 * @author crazafimahatratra
 */
class App
{
    /**
     * The configuration
     * @var array
     */
    static $conf;

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
     * Current URL
     * @var string
     */
    var $url;

    /**
     * App constructor.
     */
    public function __construct(array $config)
    {
        self::$conf = $config;
        $this->url = filter_input(INPUT_SERVER, "PATH_INFO");
    }

    /**
     * Base URL
     * @return string
     */
    public static function base_url()
    {
        return self::$conf['base_url'];
    }

    /**
     * Get current controller
     * @return string
     */
    public static function getCurrentController()
    {
        return self::$controller;
    }

    /**
     * Get current action
     * @return string
     */
    public static function getCurrentAction()
    {
        return self::$action;
    }

    /**
     * Sets view data
     * @param array $data
     */
    public static function setViewData($data)
    {
        self::$view_data = $data;
    }

    /**
     * Get view data
     * @param array $index
     * @return mixed The view data indexed by $index
     */
    public static function data($index)
    {
        if (isset(self::$view_data[$index])) return self::$view_data[$index];
        return null;
    }

    /**
     * Sets The view path
     * @param string $path
     */
    public static function setViewPath($path)
    {
        self::$view_path = $path;
    }

    /**
     * Includes a view
     */
    public static function includeView()
    {
        include self::$view_path;
    }

    /**
     * Run that application
     */
    public function run()
    {
        $controller = $this->getController();
        $controllerPath = self::$conf['namespace'] . "\\" . self::$conf['controller']['path'] . "\\" . $controller;

        if (!class_exists($controllerPath)) {
            http_response_code(400);
            echo "Controller $controller not found";
            exit;
        }
        /** @var Controller $class */
        $class = (new $controllerPath())->setConfig(self::$conf);
        $action = $this->getAction();

        if (!method_exists($class, $action)) {
            http_response_code(400);
            echo "Page  $action not found in $controller";
            return;
        }

        self::$controller = $controller;
        self::$action = $action;

        $urlParameters = $this->getUrlParameters();
        call_user_func_array(array($class, $action), $urlParameters);
    }

    /**
     * Gets the controller name
     * @return string
     */
    private function getController()
    {
        if ($this->url == null || !count($tab = explode("/", $this->url)) || empty($tab[1])) {
            return self::$conf['controller']['default'];
        }
        //Return the CamelCase name of the controller
        return ucfirst(strtolower($tab[1]));
    }

    /**
     * Get page
     * @return string
     */
    protected function getAction()
    {
        $tab = explode("/", $this->url);

        if ($this->url == null || count($tab) < 3 || empty($tab[2])) {
            return self::$conf['controller']['default_action'];
        }

        return ($tab[2]);
    }

    /**
     * Get parameters from url
     * @return array
     */
    protected function getUrlParameters()
    {
        $tab = explode("/", $this->url);
        return array_slice($tab, 3);
    }
}
