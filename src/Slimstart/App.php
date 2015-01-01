<?php

namespace Slimstart;

use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig_SimpleFilter;

class App extends Slim {

    public function __construct(array $userSettings = []) {
        $view = new Twig();
        $view->parserExtensions = array(
            new TwigExtension()
        );

        $userSettings['view'] = $view;

        parent::__construct($userSettings);

        $twig = $this->view->getInstance();
        $twig->addFilter(
            new Twig_SimpleFilter('truncate', 'twig_truncate_filter', array('needs_environment' => true)),
            new Twig_SimpleFilter('wordwrap', 'twig_wordwrap_filter', array('needs_environment' => true))
        );

    }
}