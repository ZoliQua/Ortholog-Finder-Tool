
<?php

/*
* ** DO NOT REMOVE **
* *******************
* Project Name: Ortholog Finder Tool
* Project Website: http://orthologfindertool.com
* Project Version: Public Version 1.5
*
* Project Source Code: https://github.com/ZoliQua/Ortholog-Finder-Tool
*
* Author: Zoltan Dul, 2018
* Email: zoltan.dul@kcl.ac.uk and zoltan.dul@gmail.com
* Twitter: @ZoliQa
*
* DESCRIPTION
* ****************
* A bioinformatics tool that collects evolutionarily conserved proteins, which have been described
* as a funcional regulators in genome-wide studies previously. It focueses on cell size.
*
* PHP FILE
* *******************
* Page - MYSQL File
* *******************
*
* This file connects mysql.
*
* *******************
*
* All code can be used under GNU General Public License version 2.
* If you have any question or find some bug please email me.
*
*/ 

/*
error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');
*/

/* AUTHENTICATION */

$pv = array();
$pv["user"] = "Ortholog"; //authentitation code
$pv["pass"] = "OrthologTester2015"; // authentiation password

function authenticate() {
    header('WWW-Authenticate: Basic realm="Enter to Zoltan Dul\'s Ortholog Project"');
    header('HTTP/1.0 401 Unauthorized');
    echo "You must enter a valid login ID and password to access this project page!\n";

	include_once("_includes/mylog.php"); // MyLOG
	$log->logging('AUTHENTICATION',"authenticate");
    exit;
}

/* PHP+MySQL conncect és database select */

header('Content-Type: text/html; charset=UTF-8');

$config['host'] = 'localhost';	// host name
$config['user'] = 'root';		// database username
$config['pass'] = 'zolis';		// database password
$config['data'] = 'ortholog';	// selected database name

$mysqli = new mysqli($config['host'], $config['user'], $config['pass'], $config['data']);

if ($mysqli->connect_errno) {
    printf("Cannot connect to the database ::  %s\n", $mysqli->connect_error);
    exit();
}

?>
