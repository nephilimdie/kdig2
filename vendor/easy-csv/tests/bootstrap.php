<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

call_user_func(function() {
    $loader = new \Composer\Autoload\ClassLoader();
    $loader->add('EasyCSV\Test', __DIR__);
    $loader->register();
});
