<?php

$app->get('/', function() use ($app){
    echo $app->render('index.html');
})->name('home_view');