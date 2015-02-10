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
* Index PHP
* ****************
*
* All code can be used under GNU General Public License version 2.
*
*/

// include_once("_includes/mysql.php"); // MySQL kapcsolat

/*

if(!isset($_SERVER['PHP_AUTH_USER'])) {
    authenticate();
    }
elseif( (trim($_SERVER['PHP_AUTH_USER']) != $pv["user"]) OR (trim($_SERVER['PHP_AUTH_PW']) != $pv["pass"])) {
    authenticate();
    }
else {
    header("Location: main.php");
}

 */

header("Location: main.php");

?>
