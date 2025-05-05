<?php
// database/setup.php

// Establecer el entorno de ejecución para Laravel
define('LARAVEL_START', microtime(true));

// Cargar el autoloader de Composer
require __DIR__.'/../vendor/autoload.php';

// Cargar el framework Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Obtener el kernel de consola
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Ejecutar comandos de Artisan
$status = $kernel->call('migrate:fresh');
echo "Migraciones ejecutadas con estado: " . ($status === 0 ? "éxito" : "error") . PHP_EOL;

$status = $kernel->call('db:seed');
echo "Base de datos sembrada con estado: " . ($status === 0 ? "éxito" : "error") . PHP_EOL;

// Terminar la ejecución
$kernel->terminate(null, $status);