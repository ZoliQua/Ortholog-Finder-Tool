<?php

/*
* Project Name: Ortholog Finder Tool
* Project Version: 1.6 (Unified)
*
* PHP FILE: Research Tool - Dynamic Query Results
* (Lekeres engine from v1-draft prototype)
*
* All code can be used under GNU General Public License version 2.
*/

// Show errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Increase memory limit for heavy file processing
ini_set('memory_limit', '256M');
set_time_limit(120);

// Load Lekeres engine
if (!class_exists('Lekeres')) {
	include_once(dirname(__FILE__) . "/functions.php");
}

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

// QUERY LABELS

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
	(<?php echo strtoupper($value_fajnev); ?>) -
	<?php echo ($value_ov == "all") ? "Overview (all species)" : "Single species focus"; ?> -
	Filter: <?php echo $query_labels[$value_lines]; ?>
</div>

<?php

// Force output before heavy computation
flush();

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

	// Check that data files exist
	$missing_files = array();
	foreach ($fajl as $key => $filepath) {
		if (!file_exists($filepath)) {
			$missing_files[] = $key . " (" . $filepath . ")";
		}
	}

	if (count($missing_files) > 0) {
		echo '<div class="infobox" style="color: red;">Missing data files: ' . implode(", ", $missing_files) . '</div>';
	}
	else {

		// Check Lekeres class exists
		if (!class_exists('Lekeres')) {
			echo '<div class="infobox" style="color: red;">Error: Lekeres class not loaded. Check functions.php include.</div>';
		}
		else {

			// LOGGING
			$log->logging('QUERY (Research)', $faj[$value_fajnev]["mid"], "Details: type:" . $value_ov . ", spec:" . $value_fajnev . ", q-t:" . $value_lines);

			if ($value_ov == "all") {

				// OVERVIEW: use pre-computed JSON
				$overview_json = "_query/jsonquery_overview.txt";

				if (!file_exists($overview_json)) {
					echo '<div class="infobox" style="color: red;">Error: Pre-computed overview file not found (' . $overview_json . ').</div>';
				}
				else {

					// Build overview table headers
					$faj_headers = array("A.thaliana", "D.melanogaster", "S.cerevisiae", "S.pombe", "H.sapiens");
					$print_headers = "";
					foreach ($faj_headers as $fname) {
						$print_headers .= '<th width="10%">' . $fname . ' <BR> (UniProt id)</th>' . "\n";
						$print_headers .= '<th width="10%">Paths</th>' . "\n";
					}

					echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="research">
						<thead><tr>' . $print_headers . '</tr></thead>
						<tbody></tbody>
						<tfoot><tr>' . $print_headers . '</tr></tfoot>
					</table>';

?>

<!--  DATATABLE JAVASCRIPT - START //-->
	<script type="text/javascript">
		$(document).ready(function() {
		    $('#research').dataTable( {
		        "bProcessing": true,
		   		"bJQueryUI": true,
				"sPaginationType": "full_numbers",
		        "aLengthMenu": [[5, 10, 20, 50, 100, 200, 300, 400, 3000], [5, 10, 20, 50, 100, 200, 300, 400, 3000]],
		        "sAjaxSource": '<?php print $overview_json; ?>'
		    } );
		} );
	</script>
<!--  DATATABLE JAVASCRIPT - END //-->

<div class="exec-time" style="margin-top: 10px;">
	Pre-computed overview data loaded.
</div>

<?php
				} // end file_exists overview

			}
			else {

				// ONE SPECIES: dynamic Lekeres query
				$values = array("faj_nev" => $value_fajnev, "lines" => $value_lines, "ov" => $value_ov);
				$lekeres = new Lekeres($fajl, $values);

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

<?php

			} // end one/all branch

		} // end class_exists
	} // end file check

?>
