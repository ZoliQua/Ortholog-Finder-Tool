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
* Page - INDEX File
* *******************
*
* This file redirects user to the main.php file.
*
* *******************
*
* All code can be used under GNU General Public License version 2.
* If you have any question or find some bug please email me.
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
