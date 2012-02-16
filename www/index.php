<?php

    require '../app/App.php';
    
    $app = new App();
    
    $app->get('/hello/(:name)', function($name = 'world') use ($app){
        echo $app->render('world', array('name' => $name));
    });
    
    $app->run();
    
?>