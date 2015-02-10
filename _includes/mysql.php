<?php

/*
* ** DO NOT REMOVE **
* *******************
* Project Name: Ortholog Finder Tool
* Project Website: http://orthologfindertool.com
* Project Version: Public Version 1.0
* Project Manager: Copyright (c) Zoltan Dul, 2005
*
* Project Code Source: https://github.com/ZoliQua
* Project Email: zoltan.dul@kcl.ac.uk
*
* DESCRIPTION
* ****************
* A bioinformatics tool that collects evolutionarily conserved proteins, which have been described
* as a funcional regulators in genome-wide studies previously. Currently it focueses on cell size.
*
* PHP FILE
* ****************
* MySQL connector file
* ****************
*
* All code can be used under GNU General Public License version 2.
*
*/

error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');

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

/* PHP+MySQL összekapcsolás és database select */

header('Content-Type: text/html; charset=UTF-8');

$config['host'] = 'ortholog_host'; //host name
$config['user'] = 'ortholog_user'; //database username
$config['pass'] = 'ortholog_pass'; //database password
$config['data'] = 'ortholog_data'; //selected database name

$mysqli = new mysqli($config['host'], $config['user'], $config['pass'], $config['data']);

if ($mysqli->connect_errno) {
    printf("Nem tudok az adatbázishoz kapcsolódni ::  %s\n", $mysqli->connect_error);
    exit();
}

?>
