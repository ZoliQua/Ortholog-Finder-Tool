<?php

/*
* Project Name: Ortholog Finder Tool
* Project Version: 1.1 (Unified)
*
* PHP FILE: GO Extension — Analyzer
* (Originally page_1_analyzer.php from v1-go-web)
*
* All code can be used under GNU General Public License version 2.
*/

if( isset($_POST["sent"])) {

	// This run in case of there was a query.

	// Run Script for Query GO

		$objResults = new QueryGO($files, $folderSource, $species, $given_values, $gos);

	// EXPORT results in a SVG file

		$svgFileWriter = file_put_contents($files["output"], $objResults->printelni);

	// Add Download button to under the SVG graphics

		$strInfos = "<BR>\n<A href=\"".$files["output"]."\" target=\"_blank\">Download Venn Diagram</A> in SVG file.";

	// Get the results for print

		$strOutput = PrintTheOutput($objResults->printelni, $strInfos, $objResults->strTablePrint, $objResults->infos, $objResults->species_number, $this_file . "?mode=go", $go, $gos, $species);
	// Print

		print $strOutput;

}

else {

	// in Case there were NO query taken.

	$strOutput = PrintTheOutput(false, false, false, false, false, $this_file . "?mode=go", $go, $gos, $species);

	print $strOutput;

}


// End Time Write Out

	print "<BR><BR><div class=\"exec-time\">\n";
	print TimeEnd($time_start);
	print "</div>";

?>

<!--  DATATABLE JAVASCRIPT - START //-->

	<script type="text/javascript">

		$(document).ready(function() {

		    $('#results').DataTable( {

		        "bProcessing": true,
		   		"bJQueryUI": true,
       			"order": [[ 1, "desc" ]],
       			"lengthMenu": [[10, 20, 40, 80, -1], [10, 20, 40, 80, "All"]]

    		} );

		} );


		$(document).ready(function() {

		    $('#resultsexpanded').DataTable( {

		        "bProcessing": true,
		   		"bJQueryUI": true,
       			"order": [[ 1, "desc" ]],
       			"lengthMenu": [[10, 20, 40, 80, -1], [10, 20, 40, 80, "All"]]

    		} );

		} );


		$(document).ready(function() {

		    $('#conservedcore').DataTable( {

		        "bProcessing": true,
		   		"bJQueryUI": true,
       			"order": [[ 1, "desc" ]],
       			"lengthMenu": [[10, 20, 40, 80, -1], [10, 20, 40, 80, "All"]]

    		} );

		} );



		$(document).ready(function() {

		    $('#novelannotations').DataTable( {

		        "bProcessing": true,
		   		"bJQueryUI": true,
       			"order": [[ 1, "desc" ]],
       			"lengthMenu": [[10, 20, 40, 80, -1], [10, 20, 40, 80, "All"]]

    		} );

		} );

	</script>

<!--  DATATABLE JAVASCRIPT - END //-->
