<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var $loader ClassLoader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

//$loader-> add(array('Sonata' => __DIR__));
$loader->registerPrefixes(array(
    // Swift, Twig etc.
    'PHPExcel' => __DIR__ . '/../vendor/phpexcel/Classes'
));
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
