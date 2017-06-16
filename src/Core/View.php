<?php

namespace Core;

/**
 * Class View
 * @package Core
 * @author candrianarijaona
 */
class View
{

    /**
     * Data in the view
     *
     * @var array
     */
    protected $data = [];

    /**
     * The template name
     * @var string
     */
    protected $template;

    /**
     * View constructor.
     *
     * @param null $template
     * @param array $data
     */
    public function __construct($template = null, $data = [])
    {
        $this->template = $template;
        $this->data = $data;
    }

    /**
     * Render a view
     *
     * @param string $template
     * @param string $config
     * @param array $data
     */
    public function render($template, $config, $data = [])
    {
        ob_start();
        //Expose variables to the view
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        $templatePath = $config['view']['path'] . DIRECTORY_SEPARATOR . $template . '.php';
        if (file_exists($templatePath)) {
            require_once $templatePath;
        } else {
            echo "File not found : {$templatePath}";
        }


        $content = ob_get_contents();
        ob_end_clean();

        echo $content;//display the output
    }
}
