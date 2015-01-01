<?php

$app->get('/hello/(:name)', function($name = 'world') use ($app){
    echo $app->render('world.html', ['name' => $name]);
})->name('hello_view');