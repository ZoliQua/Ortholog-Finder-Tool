<?php

/*
* Project Name: Ortholog Finder Tool
* Project Version: 1.1 (Unified)
*
* PHP FILE: Research Tool - Query Form
* (Dynamic query engine from v1-draft prototype)
*
* All code can be used under GNU General Public License version 2.
*/

?>
<div class="text">

<p style="font-size: 12px; color: #888; margin-bottom: 20px;">
	<b>Unpublished research tool.</b> Dynamic multi-database ortholog query with progressive filtering
	across 6 databases and 10 query levels. Processing may take 30–60 seconds depending on the query type.
</p>

<FORM method="POST" name="bevitel" action="main.php?mode=research">
<input type="hidden" name="mode" value="research">
<TABLE align=center border=0 cellpadding=7 cellspacing=0>

	<TR id="k0">

		<TD align="center" width="50%"><div class=ctext>Dataset:</div></TD>
		<TD align="center" width="50%"><div class=dtext >
	    	<SELECT name="c" id="value_c">
				<OPTION value="one">One species (single focus)</OPTION>
				<OPTION value="all">Overview (all 5 species)</OPTION>
	 		</SELECT> &nbsp;</div>
	 	</TD>

	</TR>

	<TR id="k1">

		<TD align="center" width="50%"><div class=ctext>Species: </div></TD>
		<TD align="center" width="50%"><div class=dtext >
	    	<SELECT name="q" id="value_q">
				<OPTION value="zero">(choose)</OPTION>
				<OPTION value="sc">S. cerevisiae</OPTION>
				<OPTION value="sp">S. pombe</OPTION>
				<OPTION value="hs">H. sapiens</OPTION>
				<OPTION value="dm">D. melanogaster</OPTION>
				<OPTION value="at">A. thaliana</OPTION>
	 		</SELECT> &nbsp;</div>
	 	</TD>

	</TR>

	<TR id="k2">

		<TD align="center" width="50%"><div class=ctext>Query type: </div></TD>
		<TD align="center" width="50%"><div class=dtext >
	    	<SELECT name="p" id="value_p">
				<OPTION value="all">(1) All rows</OPTION>
				<OPTION value="orth">(2) All fields have an ortholog</OPTION>
				<OPTION value="path">(3) Above + has pathway annotation</OPTION>
				<OPTION value="size_mut1">(4a) Above (3) + size mutant start &amp; one size mutant in row</OPTION>
				<OPTION value="size_mut2">(4b) Above (3) + size mutant start &amp; two size mutants in row</OPTION>
				<OPTION value="size_mut3">(4c) Above (2) + size mutant start &amp; one size mutant in row</OPTION>
				<OPTION value="size_mut4">(4d) Above (2) + size mutant start &amp; two size mutants in row</OPTION>
				<OPTION value="size_mut5">(4e) Above (3) + all in the same</OPTION>
				<OPTION value="size_mut6">(4f) Experiment filter - for Result 2</OPTION>
				<OPTION value="same">(5) Above (4b) + same pathway across species</OPTION>
	 		</SELECT> &nbsp;</div>
	 	</TD>

	</TR>

    <TR>
    	<TD align="center" width="50%" colspan=2>
    		<div style="text-align: center; margin-top: 10px;"><INPUT type="submit" name="kuld" value="  RUN QUERY  "></div>
    	</TD>
    </TR>
</TABLE>
</FORM>

<script type="text/javascript">
$(document).ready(function() {
	$('#value_c').change(function() {
		if ($(this).val() == 'all') {
			$('#value_q').prop('disabled', true).css('opacity', '0.4');
			$('#k1 .ctext').css('opacity', '0.4');
		} else {
			$('#value_q').prop('disabled', false).css('opacity', '1');
			$('#k1 .ctext').css('opacity', '1');
		}
	});
});
</script>

</div>
