<?php

require __DIR__ . '/../vendor/autoload.php';

use Slimstart\App;

$app = new App([
    'app.path' => dirname(__FILE__) . '/../application',
    'log.level' => \Slim\Log::DEBUG,
    'cookies.encrypt' => true,
    'cookies.cipher' => MCRYPT_RIJNDAEL_256,
    'cookies.cipher_mode' => MCRYPT_MODE_CBC,
    'debug' => true,
    'mode' => 'development'
]);

$app->addRoutes([
    'home',
    'hello'
]);

$app->run();