<?php

/*
* Project Name: Ortholog Finder Tool
* Project Version: 1.1 (Unified)
*
* PHP FILE: Research Tool — Dynamic Query Results
* (Lekeres engine from v1-draft prototype)
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

// DETECT & VALIDATE PARAMETERS

	// Dataset mode: one species or overview
	$values_array_c = array("one", "all");
	if (!isset($_POST["c"]) || !in_array(strtolower(trim($_POST["c"])), $values_array_c))
		$value_ov = "one";
	else
		$value_ov = strtolower(trim($_POST["c"]));

	// Species
	if (!isset($_POST["q"]) || !array_key_exists(strtolower(trim($_POST["q"])), $faj))
		$value_fajnev = "sc";
	else
		$value_fajnev = strtolower(trim($_POST["q"]));

	// Query type / filter level
	$values_array_p = array("all", "orth", "path", "size_mut1", "size_mut2", "size_mut3", "size_mut4", "size_mut5", "size_mut6", "same");
	if (!isset($_POST["p"]) || !in_array(strtolower(trim($_POST["p"])), $values_array_p))
		$value_lines = "all";
	else
		$value_lines = strtolower(trim($_POST["p"]));

// DATA FILES

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

// LOGGING

	$log->logging('QUERY (Research)', $faj[$value_fajnev]["mid"], "Details: type:" . $value_ov . ", spec:" . $value_fajnev . ", q-t:" . $value_lines);

// DYNAMIC QUERY

	$lekeres = new Lekeres($fajl, $values);

// QUERY INFO

	$query_labels = array(
		"all" => "(1) All rows",
		"orth" => "(2) All fields have orthologs",
		"path" => "(3) Above + pathway annotation",
		"size_mut1" => "(4a) Size mutant + one hit",
		"size_mut2" => "(4b) Size mutant + two hits",
		"size_mut3" => "(4c) Ortholog + one hit",
		"size_mut4" => "(4d) Ortholog + two hits",
		"size_mut5" => "(4e) All in same",
		"size_mut6" => "(4f) Experiment filter",
		"same" => "(5) Same pathway across species",
	);

?>

<div class="infobox" style="margin-bottom: 15px;">
	<b>Query:</b>
	<?php echo $faj[$value_fajnev]["long"]; ?>
	(<?php echo strtoupper($value_fajnev); ?>) &middot;
	<?php echo ($value_ov == "all") ? "Overview (all species)" : "Single species focus"; ?> &middot;
	Filter: <?php echo $query_labels[$value_lines]; ?>
</div>

<?php

// PRINT TABLE

	echo $lekeres->print_table;

?>

<!--  DATATABLE JAVASCRIPT - START //-->
	<script type="text/javascript">

		$(document).ready(function() {
		    $('#research').dataTable( {
		        "bProcessing": true,
		   		"bJQueryUI": true,
				"sPaginationType": "full_numbers",
		        "aLengthMenu": [[5, 10, 20, 50, 100, 200, 300, 400, 3000], [5, 10, 20, 50, 100, 200, 300, 400, 3000]],
		        "sAjaxSource": '<?php print $lekeres->jsonfile; ?>'
		    } );
		} );

	</script>
<!--  DATATABLE JAVASCRIPT - END //-->

<div class="exec-time" style="margin-top: 10px;">
	Execution time: <?php echo round(microtime(true) - $time_start, 2); ?> seconds
</div>
