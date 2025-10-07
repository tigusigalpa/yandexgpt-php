<?php

// Package test bootstrap to register PSR-4 for package src while using root project's Composer autoloader.

/** @var Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__ . '/../../../vendor/autoload.php';

if ($loader instanceof Composer\Autoload\ClassLoader) {
    $loader->addPsr4('Tigusigalpa\\YandexGPT\\', __DIR__ . '/../src/');
}