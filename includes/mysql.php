<?php

/*
* ** DO NOT REMOVE **
* *******************
* Project Name: Ortholog Finder Tool
* Project Website: http://orthologfindertool.com
* Project Version: 1.6 (Unified)
*
* Project Source Code: https://github.com/ZoliQua/Ortholog-Finder-Tool
*
* Author: Zoltan Dul, 2018
* Email: zoltan.dul@kcl.ac.uk and zoltan.dul@gmail.com
*
* PHP FILE: MySQL Connection (with .env support)
*
* All code can be used under GNU General Public License version 2.
*/

/*
error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');
*/

/* AUTHENTICATION */

$pv = array();
$pv["user"] = "Ortholog";
$pv["pass"] = "OrthologTester2015";

function authenticate() {
    header('WWW-Authenticate: Basic realm="Enter to Zoltan Dul\'s Ortholog Project"');
    header('HTTP/1.0 401 Unauthorized');
    echo "You must enter a valid login ID and password to access this project page!\n";

	include_once("includes/mylog.php");
	$log->logging('AUTHENTICATION',"authenticate");
    exit;
}

/* PHP+MySQL connect */

header('Content-Type: text/html; charset=UTF-8');

// Load .env file
$env_file = __DIR__ . '/../.env';
if (file_exists($env_file)) {
    $env_lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($env_lines as $line) {
        if (strpos($line, '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

$config['host'] = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : 'localhost';
$config['user'] = isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : 'root';
$config['pass'] = isset($_ENV['DB_PASS']) ? $_ENV['DB_PASS'] : '';
$config['data'] = isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : 'ortholog';
$config['socket'] = isset($_ENV['DB_SOCKET']) ? $_ENV['DB_SOCKET'] : '';
$config['port'] = isset($_ENV['DB_PORT']) ? intval($_ENV['DB_PORT']) : 0;

if (!empty($config['socket'])) {
    $mysqli = new mysqli($config['host'], $config['user'], $config['pass'], $config['data'], 0, $config['socket']);
} else {
    $mysqli = new mysqli($config['host'], $config['user'], $config['pass'], $config['data']);
}

if ($mysqli->connect_errno) {
    printf("Cannot connect to the database ::  %s\n", $mysqli->connect_error);
    exit();
}

?>
