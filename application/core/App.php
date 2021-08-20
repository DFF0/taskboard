<?php

class App
{
    protected $controller = "IndexController";
    protected $method = "indexAction";
    protected $id = '';

    public function __construct()
    {
        $url = $this->parseUrl();

        if (!empty($url[0]) && file_exists(APP_PATH. 'controllers/'.ucfirst($url[0]) . 'Controller.php'))
        {
            $controller = ucfirst($url[0]) . 'Controller';
            $this->controller = $controller;
            unset($url[0]);
        }

        require_once(APP_PATH . '/controllers/'.$this->controller.'.php');
        $this->controller = new $this->controller;

        if (isset($url[1]))
        {
            $method = $url[1] . 'Action';
            if (method_exists($this->controller, $method))
            {
                $this->method = $method;
                unset($url[1]);
            }
        }

        if ( isset($url[2]) && !empty($url[2]) ) {
            $tmp = explode('?', $url[2]);
            $this->id = $tmp[0] ?? '';
        }

        call_user_func([$this->controller, $this->method], $this->id);
    }

    public function parseUrl()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = explode('/', filter_var(rtrim($_SERVER['REQUEST_URI'],'/'),FILTER_SANITIZE_URL));
            array_shift($uri);
            return $uri;
        }

        return [];
    }
}