<?php

require __DIR__ . '/../vendor/autoload.php';

use Slimstart\App;

$template_path = dirname(__FILE__) . '/../templates';
    
$app = new App([
    'templates.path' => $template_path
]);

$app->get('/', function() use ($app){
    echo $app->render('index.html');
})->name('home_view');

$app->get('/hello/(:name)', function($name = 'world') use ($app){
    echo $app->render('world.html', array('name' => $name));
})->name('hello_view');

$app->run();