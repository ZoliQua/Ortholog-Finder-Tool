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
* PAGE - Query Form File
* ****************
*
* All code can be used under GNU General Public License version 2.
*
*/

?>
<div class="text">
<FORM method="POST" name="bevitel" action="main.php">
<TABLE align=center border=0 cellpadding=7 cellspacing=0>

	<TR id="k0">

		<TD align="center" width="50%"><div class=ctext>Dataset:</div></TD>
		<TD align="center" width="50%"><div class=dtext >
	    	<SELECT name="c" id="value_c">
				<OPTION value="zero">(choose)</OPTION>
				<OPTION value="one">One species orthological relation</OPTION>
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

		<TD align="center" width="50%"><div class=ctext>Function: </div></TD>
		<TD align="center" width="50%"><div class=dtext >
	    	<SELECT name="p" id="value_p">
				<OPTION value="zero">(choose)</OPTION>
				<OPTION value="orth">cell size function</OPTION>
	 		</SELECT> &nbsp;</div>
	 	</TD>

	</TR>

    <TR>
    	<TD align="center" width="50%" colspan=2>
    		<div style="text-align: center;"><INPUT type="submit" name="kuld" value="  GO  "></div>
    	</TD>
    </TR>
</TABLE>
</FORM>
</div>
