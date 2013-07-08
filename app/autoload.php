<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var $loader ClassLoader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

//$loader-> add(array('Sonata' => __DIR__));

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
