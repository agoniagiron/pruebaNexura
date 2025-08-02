<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Carga variables de entorno desde la raíz del proyecto
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

return [
    'host'    => $_ENV['DB_HOST']    ?? '127.0.0.1',
    'port'    => $_ENV['DB_PORT']    ?? '3306',
    'dbname'  => $_ENV['DB_NAME']    ?? 'nexura',
    'user'    => $_ENV['DB_USER']    ?? 'root',
    'pass'    => $_ENV['DB_PASS']    ?? '',
    'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
];
