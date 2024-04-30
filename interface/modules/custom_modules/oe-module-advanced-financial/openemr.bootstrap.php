<?php

/*
 *  package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  All rights reserved
 *
 */

/**
 * @global OpenEMR\Core\ModulesClassLoader $classLoader
 */

use Juggernaut\Module\AdvancedFinancial\Bootstrap;
use Symfony\Component\EventDispatcher\EventDispatcher;

$classLoader->registerNamespaceIfNotExists('Juggernaut\\Module\\AdvancedFinancial\\', __DIR__ . DIRECTORY_SEPARATOR . 'src');

/**
 * @global EventDispatcher $eventDispatcher Injected by the OpenEMR module loader;
 */
$bootstrap = new Bootstrap($eventDispatcher, $GLOBALS['kernel']);
$bootstrap->subscribeToEvents();




