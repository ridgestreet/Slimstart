<?php

    require '../app/App.php';
    
    $app = new App();
    
    $app->get('/', function() use ($app){
        echo $app->render('index');
    });
    
    $app->get('/hello/(:name)', function($name = 'world') use ($app){
        echo $app->render('world', array('name' => $name));
    });
    
    $app->run();
    
?>