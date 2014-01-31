<?php

    if (php_sapi_name() == 'cli-server') {
        if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
            return false;    // serve the requested resource as-is.
        }
    }

    require '../app/App.php';
    
    $app = new App();
    
    $app->get('/', function() use ($app){
        echo $app->render('index.html');
    });
    
    $app->get('/hello/(:name)', function($name = 'world') use ($app){
        echo $app->render('world.html', array('name' => $name));
    });
    
    $app->run();