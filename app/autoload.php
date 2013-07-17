<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var $loader ClassLoader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

//$loader-> add(array('Sonata' => __DIR__));
$loader->add('PHPExcel',__DIR__ . '/../vendor/phpexcel/Classes');
$loader->add('EasyCSV',__DIR__ . '/../vendor/easy-csv/lib');
AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
