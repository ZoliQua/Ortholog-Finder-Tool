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
* Page - MAIN File
* *******************
*
* This file handles other PHP files.
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

// THIS FILE

	$this_file = "main.php";

// INCLUDING files

	include_once("_includes/mysql.php"); // MySQL kapcsolat
	include_once("_includes/mylog.php"); // MyLOG fájl

// PAGE DETECT

	if((!isset($_POST) AND !isset($_GET["mit"])) OR (isset($_GET["mit"]) AND $_GET["mit"] == "query") ) $this_page = 1;
	elseif (isset($_POST["kuld"])) $this_page = 2;
	else {
		if(!isset($_GET["mit"])) $this_page = 1;
		elseif ($_GET["mit"] == "source") $this_page = 5;
		elseif ($_GET["mit"] == "about") $this_page = 6;
		else $this_page = 1;
	}

// INCLUDING PAGES

	$inc_folder = "_includes";
	$this_page_array = array();

	$this_page_array[1] = array("QUERY","page_1_form.php");
	$this_page_array[2] = array("QUERY RESULTS","page_2_analysis.php");
	$this_page_array[5] = array("Sources","page_5_sources.php");
	$this_page_array[6] = array("About us","page_6_aboutus.php");

	$this_page_include = $inc_folder . "/" . $this_page_array[$this_page][1];
	$this_page_title = $this_page_array[$this_page][0];

// LOGGING

	$log->logging('PAGE VISIT', "page request", $this_page_array[$this_page][0] . " (".$this_page.")");

?>
<html>
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="cache-control" content="max-age=86400, public">
<meta http-equiv="content-language" content="en-US">
<title>Ortholog Finder Tool</title>
<meta name="description" content="A bioinformatics tool that collects evolutionarily conserved proteins, which have been described as a funcional regulators in genome-wide studies previously. Currently it focueses on cell size.">
<meta name="keywords" content="Orthology Finder Tool, Ortholog, Orthology, evolutionally, conserved, functional ortholgos, orthologous proteins, cell size, cell cycle, systems biology, network biology, kegg database, gene ontology" />
<meta name="copyright" content="Zoltan Dul, 2018">
<meta nmae="author" content="https://twitter.com/ZoliQa">
<meta name="googlebot" content="index, follow">
<meta name="robots" content="index, follow">
<script type="text/javascript" src="_media/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="_media/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="_media/css/ortholog.css" type="text/css" />
<link rel="stylesheet" href="_media/css/table.css" type="text/css" />
<link rel="stylesheet" href="_media/css/table_jui.css" type="text/css" />
<link rel="stylesheet" href="_media/css/jquery-ui-1.10.4.custom.min.css" type="text/css" />

</head>
<body class="background">
<div id="main">
	<div id="header-w">
    	<div id="header"></div>
	</div>

	<div id="wrapper">
	<div id="nav">
		<div id="nav-inside">
		<ul class="menu">
			<li><a href='<?php print $this_file; ?>?mit=query'>QUERY</a></li>
			<li><a href='<?php print $this_file; ?>?mit=source'>REFERENCES</a></li>
			<li><a href='http://go.orthologfindertool.com/'>LINK TO GO-TOOL</a></li>
			<li><a href='<?php print $this_file; ?>?mit=about'>ABOUT US</a></li>
		</ul>
		</div>
	</div>
	</div>

<!-- Google Analytics START //-->

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-28455960-3', 'auto');
	  ga('send', 'pageview');
	  ga(‘set’, ‘&uid’, {{USER_ID}}); // Set the user ID using signed-in user_id.

	</script>

<!-- Google Analytics END //-->

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
