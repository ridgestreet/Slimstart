<?php

namespace Slimstart;

use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig_SimpleFilter;

class App extends Slim {

    private $_app_path;

    public function __construct(array $userSettings = []) {

        $view = new Twig();

        $view->parserExtensions = array(
            new TwigExtension()
        );

        if (array_key_exists('app.path', $userSettings)) {
            $this->_app_path = $userSettings['app.path'];
            $userSettings['templates.path'] = $userSettings['app.path'] . '/views';
        }

        $userSettings['view'] = $view;

        parent::__construct($userSettings);

        $twig = $this->view->getInstance();
        $twig->addFilter(
            new Twig_SimpleFilter('truncate', 'twig_truncate_filter', array('needs_environment' => true)),
            new Twig_SimpleFilter('wordwrap', 'twig_wordwrap_filter', array('needs_environment' => true))
        );

    }

    public function addRoutes (array $routes) {
        $app = $this; //$app is used in included routes
        $route_path = $this->_app_path . '/routes';
        foreach ($routes as $route) {
            include $route_path . '/' . $route . '.php';
        }
    }
}