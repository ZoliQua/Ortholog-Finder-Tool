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
* Download handler Script
* ****************
*
* All code can be used under GNU General Public License version 2.
*
*/

// LOGGING

	include_once("_includes/mylog.php"); // MyLOG fájl load

header('Content-type: text/csv');
header('Content-disposition: attachment;filename=ortholog_export.csv');

if(isset($_GET["file"])) {

	if(isset($_GET["name"])) $filename = "_query/static_".isset($_GET["sorsz"]).".txt";
	else $filename = $_GET["file"];

	$fajl_beolvas = fopen($filename, "r");
	$fajl_tartalom = fread($fajl_beolvas, filesize($filename));
	$fajl_tartalom = trim(substr($fajl_tartalom, 11, -1));
	$fajl_tartalom = json_decode($fajl_tartalom);

	if(!isset($_GET["name"])) $kiir = "This file is downladed from OrthologFinderTool.com, on ". date('d/m/y H:i:m') . ", query name was: ". str_replace('_query/jsonquery_', '', str_replace('.txt', '', $_GET['file'])) . "\n\n";
	else $kiir = "This file is downladed from OrthologFinderTool.com, on ". date('d/m/y H:i:m') . ", query name was: ". str_replace('../_query/jsonquery_', '', str_replace('.txt', '', $filename)) . "\n\n";

	$log->logging('DOWNLOAD', "file download", $filename);

	foreach ($fajl_tartalom as $sorid => $sortomb) {

		$a = "";
		foreach ($sortomb as $mezoid => $mezo) {
			$a .= strip_tags($mezo).";";
		}
		$kiir .= substr($a, 0, -1). "\n";
	}

	$out = fopen('php://output', 'w');
	fwrite($out, $kiir);
	fclose($out);
}
?>
