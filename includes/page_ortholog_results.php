
<?php

/*
* Project Name: Ortholog Finder Tool
* Project Version: 1.1 (Unified)
*
* PHP FILE: Ortholog Search — Results
* (Originally page_2_analysis.php from v1-web)
*
* All code can be used under GNU General Public License version 2.
*/

// ORGANISMS NAMES & TAXID

	$faj = array();
	$faj["at"] = array("lil" => "AT", "mid" => "A.thaliana", "long" => "Arabidopsis thaliana", "taxid" => "3702");
	$faj["dm"] = array("lil" => "DM", "mid" => "D.melanogaster", "long" => "Drosophila melanogaster", "taxid" => "7227");
	$faj["sc"] = array("lil" => "SC", "mid" => "S.cerevisiae", "long" => "Saccharomyces cerevisiae", "taxid" => "559292");
	$faj["sp"] = array("lil" => "SP", "mid" => "S.pombe", "long" => "Schizosaccharomyces pombe", "taxid" => "4896");
	$faj["hs"] = array("lil" => "HS", "mid" => "H.sapiens", "long" => "Homo sapiens", "taxid" => "9606");

// DETECT ORGANISM & VALUES

	//PATHWAY ENRICHMENT :: $value_ov
	$values_array["c"] = array("zero", "one", "all");
	if(!isset($_POST["c"])) $value_ov = "one";
	elseif(! in_array( strtolower( trim($_POST["c"]) ), $values_array["c"]) OR strtolower( trim($_POST["c"]) ) == "zero") $value_ov = "one";
	else $value_ov = strtolower( trim($_POST["c"]) );

	//FAJ NEVE :: $value_fajnev
	if(!isset($_POST["q"])) $value_fajnev = "sc";
	elseif(! array_key_exists( strtolower( trim($_POST["q"]) ), $faj) ) $value_fajnev = "sc";
	else $value_fajnev = strtolower( trim($_POST["q"]) );

	//PATHWAY ENRICHMENT :: $value_lines
	$values_array["p"] = array("zero", "all", "orth", "path", "size_mut1", "size_mut2", "size_mut3", "size_mut4", "same");
	if(!isset($_POST["p"])) $value_lines = "all";
	elseif(! in_array( strtolower( trim($_POST["p"]) ), $values_array["p"]) OR strtolower( trim($_POST["p"]) ) == "zero") $value_lines = "all";
	else $value_lines = strtolower( trim($_POST["p"]) );

// INCLUDE PHP script FILES: functions, session

	#include_once("functions.php");

// INCLUDE DATA FILES

	$mappa = "_dataset/";

	$fajl = array();
	$fajl["at"] = $mappa . "AT_interact_deg2_exp.csv";
	$fajl["dm"] = $mappa . "DM_interact_deg2_exp.csv";
	$fajl["sc"] = $mappa . "SC_interact_deg2_exp.csv";
	$fajl["sp"] = $mappa . "SP_interact_deg2_exp.csv";
	$fajl["hs"] = $mappa . "HS_interact_deg2_exp.csv";

	$fajl["data"] = $mappa . "ALL_ortholog_dbs_merged.csv";
	$fajl["kegg"] = $mappa . "kegg_pathways_uniprot.tsv";
	$fajl["reac"] = $mappa . "reactome_pathways_uniprot.tsv";
	$fajl["reg"] = $mappa . "regular_names.txt";

	$values = array("faj_nev" => $value_fajnev, "lines" => $value_lines, "ov" => $value_ov);

// QUERY

	#$lekeres = new Lekeres ($fajl, $values);

// LOGGING

	$log->logging('QUERY', $faj[$value_fajnev]["mid"], "Details: type:" . $value_ov . ", spec:" . $value_fajnev . ", q-t:" . $value_lines);

// INCLUDE FILE

	include_once("page_2_analysis_" . $value_fajnev . ".php");

?>

<!--  DATATABLE JAVASCRIPT - START //-->
	<script type="text/javascript">

		$(document).ready(function() {
		    $('#research').dataTable( {
		        "bProcessing": true,
		   		"bJQueryUI": true,
				"sPaginationType": "full_numbers",
		        "aLengthMenu": [[5, 10, 20, 50, 100, 200, 300, 400, 3000], [5, 10, 20, 50, 100, 200, 300, 400, 3000]],
		        "sAjaxSource": '_query/jsonquery_<?php print $value_fajnev; ?>.txt'
		    } );
		} );

	</script>
<!--  DATATABLE JAVASCRIPT - END //-->
