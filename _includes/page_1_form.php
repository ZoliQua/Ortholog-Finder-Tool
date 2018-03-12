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
* Page - FORM File
* *******************
*
* This file give input options for the user.
*
* *******************
*
* All code can be used under GNU General Public License version 2.
* If you have any question or find some bug please email me.
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
