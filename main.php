<?php

/*
* ** DO NOT REMOVE **
* *******************
* Project Name: Ortholog Finder Tool
* Project Website: http://orthologfindertool.com
* Project Version: 1.1 (Unified)
*
* Project Source Code: https://github.com/ZoliQua/Ortholog-Finder-Tool
*
* Author: Zoltan Dul, 2018
* Email: zoltan.dul@kcl.ac.uk and zoltan.dul@gmail.com
*
* DESCRIPTION
* ****************
* Unified tool combining Ortholog Finder Tool and GeneOntology Extension Tool.
*
* PHP FILE
* *******************
* Page - MAIN File (Unified Router)
* *******************
*
* All code can be used under GNU General Public License version 2.
*/

// COUNTING TIME (needed for GO mode)

	$time_start = microtime(true);

// THIS FILE

	$this_file = "main.php";

// INCLUDING files

	$folderIncl = "includes";

	include_once($folderIncl . "/mysql.php"); // MySQL connection
	include_once($folderIncl . "/mylog.php"); // MyLOG Logger file

// MODE DETECT: ortholog, go, or landing page

	$mode = null;
	if (isset($_GET["mode"])) $mode = strtolower(trim($_GET["mode"]));
	elseif (isset($_POST["mode"])) $mode = strtolower(trim($_POST["mode"]));

// PAGE DETECT

	$this_page = null;
	$this_page_title = "";
	$this_page_include = "";

	if ($mode == "ortholog") {

		// MODE A: Ortholog Finder Tool

		if (isset($_POST["kuld"])) $this_page = "ortholog_results";
		else $this_page = "ortholog_form";

	} elseif ($mode == "research") {

		// MODE C: Research Tool (dynamic query from v1-draft)
		include_once($folderIncl . "/functions.php");

		if (isset($_POST["kuld"])) $this_page = "research_results";
		else $this_page = "research_form";

	} elseif ($mode == "go") {

		// MODE B: GO Extension Tool
		// Load GO-specific includes
		include_once($folderIncl . "/inc_functions.php");
		include_once($folderIncl . "/inc_variables.php");
		include_once($folderIncl . "/inc_analyzer_dumper.php");

		$this_page = "go_analyzer";

	} elseif (isset($_GET["page"]) && $_GET["page"] == "data") {

		$this_page = "data_methods";

	} elseif (isset($_GET["page"]) && $_GET["page"] == "source") {

		$this_page = "sources";

	} elseif (isset($_GET["page"]) && $_GET["page"] == "about") {

		$this_page = "about";

	} elseif (isset($_GET["mit"]) && $_GET["mit"] == "source") {

		$this_page = "sources";

	} elseif (isset($_GET["mit"]) && $_GET["mit"] == "about") {

		$this_page = "about";

	} else {

		// Landing page: mode selector
		$this_page = "landing";

	}

// PAGE TITLES AND INCLUDES

	$page_map = array(
		"landing"          => array("ORTHOLOG FINDER TOOL", "page_landing.php"),
		"ortholog_form"    => array("QUERY — Ortholog Search", "page_ortholog_form.php"),
		"ortholog_results" => array("QUERY RESULTS", "page_ortholog_results.php"),
		"research_form"    => array("QUERY — Ortholog Search (Unpublished)", "page_research_form.php"),
		"research_results" => array("QUERY RESULTS (Research)", "page_research_results.php"),
		"go_analyzer"      => array("QUERY — GO Extension", "page_go_analyzer.php"),
		"data_methods"     => array("Data Methods", "page_data_methods.php"),
		"sources"          => array("References", "page_sources.php"),
		"about"            => array("About Us", "page_aboutus.php"),
	);

	$this_page_title = $page_map[$this_page][0];
	$this_page_include = $folderIncl . "/" . $page_map[$this_page][1];

// LOGGING

	$log->logging('PAGE VISIT', "page request", $this_page_title . " (" . $this_page . ")");

?>
<html>
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="cache-control" content="max-age=86400, public">
	<meta http-equiv="content-language" content="en-US">
	<title>Ortholog Finder Tool<?php if ($mode) echo " — " . ucfirst($mode) . " Mode"; ?></title>
	<meta name="description" content="A bioinformatics tool that collects evolutionarily conserved proteins and extends Gene Ontology annotations based on orthological relations across model organisms.">
	<meta name="keywords" content="Ortholog Finder Tool, GO Extension Tool, Ortholog, Orthology, Gene Ontology, conserved, functional orthologs, orthologous proteins, cell size, cell cycle, systems biology, network biology" />
	<meta name="copyright" content="Zoltan Dul, 2018">
	<meta name="author" content="Zoltan Dul">
	<meta name="googlebot" content="index, follow">
	<meta name="robots" content="index, follow">

	<script type="text/javascript" src="media/js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="media/js/jquery.hovercard.min.js"></script>
	<link rel="stylesheet" href="media/css/unified.css" type="text/css" />
	<link rel="stylesheet" href="media/css/table.css" type="text/css" />
	<link rel="stylesheet" href="media/css/table_jui.css" type="text/css" />
	<link rel="stylesheet" href="media/css/jquery-ui-1.10.4.custom.min.css" type="text/css" />

</head>
<body class="background">
<div id="main">
	<div id="header-w">
    	<div id="header"<?php
    		if ($mode == "research") echo ' style="background-image:url(media/images/ortholog_logo_EXP.png);"';
    		elseif ($mode == "go") echo ' style="background-image:url(media/images/ortholog_logo_GO.png);"';
    	?>></div>
	</div>

	<div id="wrapper">
	<div id="nav">
		<div id="nav-inside">
		<ul class="menu">
			<li><a href='<?php print $this_file; ?>'>HOME</a></li>
			<li><a href='<?php print $this_file; ?>?mode=ortholog'>ORTHOLOG SEARCH</a></li>
			<li><a href='<?php print $this_file; ?>?mode=research'>EXPERIMENTAL</a></li>
			<li><a href='<?php print $this_file; ?>?mode=go'>GO EXTENSION</a></li>
			<li><a href='<?php print $this_file; ?>?page=data'>DATA METHODS</a></li>
			<li><a href='<?php print $this_file; ?>?page=source'>REFERENCES</a></li>
			<li><a href='<?php print $this_file; ?>?page=about'>ABOUT US</a></li>
		</ul>
		</div>
	</div>
	</div>

	<div id="main-content">
		<h2><a href name='zero'></a><?php print $this_page_title; ?></h2>

		<div id="center"><?php include_once($this_page_include); ?></div>

		<div id="gototop"><a href='#zero'>Go to the top</a></div>
		<div id="netbiol">&copy; <?php echo date("Y"); ?> <a href="http://www.kcl.ac.uk/index.aspx" target="_blank" class="pagebottomlink">King's College London</a> & <a href="http://www.fmach.it/" target="_blank" class="pagebottomlink">Fondazione Edmund Mach</a></div>
		<div class="bottompage"></div>
	</div>

</div>
</body>
</html>
