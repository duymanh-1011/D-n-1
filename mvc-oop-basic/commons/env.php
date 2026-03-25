<?php

// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS

$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$scheme = $isHttps ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
$scriptDir = rtrim($scriptDir, '/');
if ($scriptDir === '' || $scriptDir === '.') {
	$scriptDir = '';
}

$basePath = $scriptDir;
if ($basePath !== '' && str_ends_with($basePath, '/admin')) {
	$basePath = substr($basePath, 0, -6);
}

define('BASE_URL', $scheme . '://' . $host . $basePath . '/');
// đường dẫn vào admin
define('BASE_URL_ADMIN', BASE_URL . 'admin/');

define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'orvani');  // Tên database

define('PATH_ROOT', __DIR__ . '/../');
