<?php

/*
* Project Name: Ortholog Finder Tool
* Project Version: 1.6 (Unified)
*
* PHP FILE: Data Methods page
* (Originally include_4_data.php from v1-draft)
*
* All code can be used under GNU General Public License version 2.
*/

$moretto_new = array("YIL119c","YLR120C","YDR110w","YDR457w","YPR164W","YOR209c","YJR094w","YOL068c","YPR111w","YGR260w","YOR025w","YDL042c","YMR035w","YGL163c","YDL056W","YIL052C","YJL189W","YDL184C","YBR191W","YLR325C","YOR312C","YGR148C","YKR094C","YDL133C","YJL191W","YGL031C","YPL090C","YFL034C","YNL067W","YJL190C","YDR447C","YNL096C","YLR287C","YOR182C","YLR441C","YBR189W","YOR096W","YML024W","YDR025W","YKL006W","YOL121C","YGR027C","YMR142C","YIL069C");

$kipr = "";
foreach ($moretto_new as $n => $v) {
	$kipr .= '<a href="http://www.yeastgenome.org/cgi-bin/locus.fpl?locus='.$v.'" target="_blank">'.$v.'</a>, ';
}
$kipr = substr($kipr,0,-2);

?>
<div class="atext" style="margin-bottom: 20px; font-size: 13px; line-height: 1.6;">
	<p>This page describes the data collection and processing methods used in the <b>Ortholog Search</b> and <b>Experimental</b> modes of the Ortholog Finder Tool.
	The methodology and datasets reflect the state of the databases at the time of the tool's original publication in <b>2016</b>.
	Ortholog mappings, pathway annotations, and protein interaction data were retrieved from the sources listed below during 2013-2015.</p>
</div>
<div class="page"></div>
<div class="img_sc"></div>
<h3><i>S. cerevisiae</i> / Budding yeast</h3>

<div class="databox">
	We used <a href="_download/s.cerevisiae-jorgensen-original-list.csv"><b>451</b> <img src="media/images/linkout.png" border="0" /></a> <i>S. cerevisiae</i> gene strains, from <label id="jorgensen"><a href="<?php print $this_file; ?>?page=source">Jorgensen et al. (2002)</a>'s research</label>.<BR>
	We checked then we found that there are <label id="jorg_dupl"><a href="_download/s.cerevisiae-jorgensen-duplicates.csv"><b>8</b> <img src="media/images/linkout.png" border="0"/></a> duplicates</label>, and <label id="jorg_corr"><a href="_download/s.cerevisiae-jorgensen-correction.csv"><b>2</b> <img src="media/images/linkout.png" border="0"/></a> wrong mapped</label> gene strains. <BR>
	Therefore we corrected them and used a gene list, which contained <a href="_download/s.cerevisiae-jorgensen-final-list.csv"><b>445</b> <img src="media/images/linkout.png" border="0"/></a> gene strains.
</div>
<div class="databox">
	We expanded this gene list with the research performed by <label id="moretto"><a href="<?php print $this_file; ?>?page=source">Moretto et al. (2013)</a></label>. <BR>
	This research was a wide pharmaco-epistasis analysis, which mainly based on the research above. <BR>
	Finally we added <label id="moretto_more"><a href="_download/s.cerevisiae-moretto-more.csv"><b>44</b> <img src="media/images/linkout.png" border="0" /></a> ribosomal</label> protein to our gene list. <BR>
	Thus we created the final <i>S. cerevisiae</i> gene strain list, which contained <a href="_download/s.cerevisiae-moretto-final-list.csv"><b>489</b> <img src="media/images/linkout.png" border="0" /></a> probable size control genes. <BR>
	Till this point we used as primary key the <a href="http://www.yeastgenome.org/" target="_blank"><b> Yeast Genome Database's systematic ORF IDs</b></a>
</div>
<div class="databox">
	We used <label id="biogrid"><a href="http://thebiogrid.org/" target="_blank"><b>BioGRID</b> database</a></label> (version 3.2.106, December 2013) to retrieve this gene list's protein-protein network. <BR>
	Therefore we needed gene/protein mapping to use this database for research, because BioGRID used <a href="http://www.ncbi.nlm.nih.gov/gene" target="_blank"><b>NCBI Entrez Gene IDs</b></a> as primary keys. <BR>
	We mapped <a href="_download/s.cerevisiae-mapped-uniprot.txt" id="all"><b>all</b> <img src="media/images/linkout.png" border="0" /></a> but <a href="_download/s.cerevisiae-mapped-uniprot-not.txt" id="one"><b>one</b> <img src="media/images/linkout.png" border="0" /></a> YGD ORF IDs to <a href="http://www.uniprot.org/" target="_blank"><b>UniProtKB IDs</b></a>. Later <label id="all2"><b>491 (490 unique)</b></label> UniProtKB IDs were mapped to Entrez Gene IDs. <BR>
	Our query mapped <b>450</b> UniProtKB IDs to <a href="_download/s.cerevisiae-mapped-entrez.txt"><b>476</b> <img src="media/images/linkout.png" border="0"/></a> (462 unique) Entrez IDs, while <a href="_download/s.cerevisiae-mapped-entrez-not.csv"><b>40</b> <img src="media/images/linkout.png" border="0"/></a> UniProtKB IDs were not found to have an Entrez ID pair.<BR>
	During protein mapping we used the <a href="http://www.uniprot.org/" target="_blank"><b>UniProt.org's ID Mapper</b></a> API.
</div>

<div class="img_sp"></div>
<h3><i>S. pombe</i> / Fission yeast</h3>
<div class="databox">
	To find orthologs we used <a href="http://www.pombase.org/" target="_blank"><b>PomBase</b></a> manually curated one <i>S. pombe</i> to one <i>S. cerevisiae</i> ortholog list and <label id="inpara"><a href="http://inparanoid.sbc.su.se/cgi-bin/index.cgi" target="_blank"><b>inParanoid database</b></a></label>.<BR>
</div>
<div class="databox">
	First we investigated the PomBase ortholog lists. <BR>
	We found that from the <b>489</b> <i>S. cerevisiae</i> genes (YGD ORF IDs) <a href="_download/s.pombe-pombase-orthologs.csv"><b>392</b> orthologs <img src="media/images/linkout.png" border="0" /></a> had an ortholog, while <b>97</b> had no orthologs. <BR>
	These genes had <b>507</b> <i>S. cerevisiae</i> - <i>S. pombe</i> ortholog pairs, from which <a href="_download/s.pombe-unique-pombase.csv"><b>477</b> <img src="media/images/linkout.png" border="0" /></a> <i>S. pombe</i> were unique. <BR>
	In this point we used <b><a href="http://www.pombase.org/" target="_blank">PomBase Systematic ORF id</a></b> as primary key for <i>S. pombe</i> orthologs.
</div>
<div class="databox">
	Later we mapped these IDs to UniProtKB IDs to be comparable with inParanoid database, we used <a href="http://www.pombase.org/downloads/data-mappings" target="_blank"><b>PomBase's gp2swiss mappings</b></a>. <BR>
	We mapped the <a href="_download/s.pombe-pombase-orthologs-all-mapping.csv"><b>477</b> <img src="media/images/linkout.png" border="0" /></a> PomBase ORF IDs to <b>495</b> UniProt IDs, while <a href="_download/s.pombe-unique-uniprot.csv"><b>476</b> <img src="media/images/linkout.png" border="0" /></a> IDs were unique and <b>7</b> were not found.
</div>
<div class="databox">
	To retrieve connections for <i>S. pombe</i> we mapped UniProt IDs to Entrez Gene IDs with UniProt.org's ID Mapper API. <BR>
	We mapped all of the <b>476</b> UniProt IDs to <b>539</b> Entrez IDs, while <a href="_download/s.pombe-unique-entrez.csv"><b>470</b> <img src="media/images/linkout.png" border="0" /></a> IDs were unique.
</div>
<div class="databox">
	Second we made a query from inParanoid. <BR>
	We found from the <b>490</b> <i>S. cerevisiae</i> proteins (UniProtKB IDs) <b>332</b> proteins has an ortholog (<a href="_download/s.pombe-inparanoid-not-contained.csv"><b>158</b> proteins <img src="media/images/linkout.png" border="0" /></a> were not found). <BR>
	In <i>S. pombe</i> <a href="_download/s.pombe-inparanoid.csv"><b>388</b> (all percent confidence) orthologs <img src="media/images/linkout.png" border="0" /></a> were found (356 unique UniProt IDs). <BR>
	To retrieve connections for <i>S. pombe</i> we mapped all of the <b>356</b> UniProt IDs to <a href="_download/s.pombe-inparanoid-entrez-mapped.csv"><b>370</b> Entrez IDs <img src="media/images/linkout.png" border="0" /></a> (<b>368</b> unique IDs).
</div>

<div class="img_hs"></div>
<h3><i>H. sapiens</i> / Human</h3>
<div class="databox">
	To find human orthologs we could also use PomBase ortholog list and inParanoid database.<BR>
</div>
<div class="databox">
	We started the investigation with PomBase ortholog list. This is a manually curated list between <i>S. pombe</i> and <i>H. sapiens</i>.<BR>
	We used for the primary query list the <i>S. pombe</i>'s PomBase orthologs of <i>S. cerevisiae</i>'s genes. <BR>
	We found from the <b>477</b> <i>S. pombe</i> genes (PomBase ORF IDs) <a href="_download/h.sapiens-pombase-orthologs.csv"><b>397</b> orthologs <img src="media/images/linkout.png" border="0" /></a> (regular name). <BR>
	These proteins had <b>606</b> human orthologs, from which <b>469</b> were unique.
</div>
<div class="databox">
	Later we made a query from inParanoid. <BR>
	We found from the <b>490</b> <i>S. cerevisiae</i> proteins (UniProtKB IDs) <b>243</b> proteins has an orthologs (<a href="_download/h.sapiens-inparanoid-not-contained.csv"><b>247</b> proteins <img src="media/images/linkout.png" border="0" /></a> were not found). <BR>
	In <i>H. sapiens</i> <a href="_download/h.sapiens-inparanoid.csv"><b>351</b> (all percent confidence) orthologs <img src="media/images/linkout.png" border="0" /></a> were found (328 unique UniProt IDs). <BR>
	To retrieve connections for <i>H. sapiens</i> we mapped <b>321</b> of the <b>328</b> UniProt IDs to <a href="_download/h.sapiens-inparanoid-entrez-mapped.csv"><b>328</b> Entrez IDs <img src="media/images/linkout.png" border="0" /></a> (<b>326</b> unique IDs, <a href="_download/h.sapiens-inparanoid-entrez-mapped-not.csv"><b>7</b> were not found <img src="media/images/linkout.png" border="0" /></a>).
</div>

<div class="img_at"></div>
<h3><i>A. thaliana</i> / Thale cress</h3>
<div class="databox">
	For Arabidopsis we did not have a manually curated ortholog source so we retrieved our query only from inParanoid.
</div>
<div class="databox">
	We found from the <b>490</b> <i>S. cerevisiae</i> proteins (UniProtKB IDs) <b>239</b> proteins has an ortholog (<a href="_download/a.thaliana-inparanoid-not-contained.csv"><b>251</b> proteins <img src="media/images/linkout.png" border="0" /></a> were not found). <BR>
	In <i>A. thaliana</i> <a href="_download/a.thaliana-inparanoid.csv"><b>783</b> (all percent confidence) orthologs <img src="media/images/linkout.png" border="0" /></a> were found (738 unique UniProt IDs). <BR>
	To retrieve connections for <i>A. thaliana</i> we mapped all of the <b>738</b> UniProt IDs to <a href="_download/a.thaliana-inparanoid-entrez-mapped.csv"><b>759</b> Entrez IDs <img src="media/images/linkout.png" border="0" /></a> (<b>755</b> unique IDs).
</div>

<script type="text/javascript">

function link(mit, v) {
	if(v == "uni") return '<A href="http://www.uniprot.org/uniprot/?query='+mit+'&sort=score" target="_blank">'+mit+'</a>';
	if(v == "orf") return '<a href="http://www.yeastgenome.org/cgi-bin/locus.fpl?locus='+mit+'" target="_blank">'+mit+'</a>';
}

$(document).ready(function () {

	var hoverJorgensen = '<p>This article is about cell size comparison in budding yeast. '
	    + '<i>They determined cell size distributions for the complete set of 6000 Saccharomyces cerevisiae gene deletion strains '
	    + 'and identified 500 abnormally small or large mutants.</i></p>'
	    + '<p><b>Systematic Identification of Pathways That Couple Cell Growth and Division in Yeast</b></p>'
	    + '<p>Paul Jorgensen, Joy L. Nishikawa, Bobby-Joe Breitkreutz, Mike Tyers</p>'
	    + 'Published on 19 July, 2002 in <b>Science</b><BR><a href="http://dx.doi.org/10.1126/science.1070850" target="_blank">doi:10.1126/science.1070850</a>';

	var hoverMoretto = '<p>This article is about a wide performed pharmaco-epistasis analysis in budding yeast, using drugs mimicking cell size mutations.</p>'
	    + '<p>It contains <b>324</b> out of <b>445</b> Jorgensen\'s gene strains. To this list we added 44 more ribosomal gene strains.</p>'
	    + '<p><b>A pharmaco-epistasis strategy reveals a new cell size controlling pathway in yeast</b></p>'
	    + '<p>Fabien Moretto, Isabelle Sagot, Bertrand Daignan-Fornier, Benoit Pinson</p>'
	    + 'Published on 27 September, 2013 in <b>Molecular Systems Biology</b><BR><a href="http://dx.doi.org/10.1038/msb.2013.60" target="_blank">doi:10.1038/msb.2013.60</a>';

	var hoverMorettoMore = '<p>We added 44 new ribosomal proteins:</p><p><?php print $kipr; ?></p>';

	var hoverDupl = '<p><b>Duplicated ORF IDs were:</b></p>'
	    + '<ul><li><b>'+link("YBL058W","orf")+'</b> - SHP1 // RPB9'
	    + '<li><b>'+link("YBR251W","orf")+'</b> - MRPS5'
	    + '<li><b>'+link("YDR500C","orf")+'</b> - RPL37B'
	    + '<li><b>'+link("YGL218W","orf")+'</b> - (none)'
	    + '<li><b>'+link("YKL138C","orf")+'</b> - MRPL31'
	    + '<li><b>'+link("YNL255C","orf")+'</b> - GIS2'
	    + '<li><b>'+link("YNL315C","orf")+'</b> - ATP11'
	    + '<li><b>'+link("YOR309C","orf")+'</b> - (none)</ul>';

	var hoverCorr = '<p><b>Corrections were:</b></p>'
	    + '<ul><li><b>RPB9</b> - '+link("YGL070C","orf")+' - id and name don\'t matched, doubled, SHP1'
	    + '<li><b>SHP1</b> - '+link("YBL058W","orf")+' - id and name don\'t matched, doubled, RPB9'
	    + '<li><b>RPL37A</b> - '+link("YLR185W","orf")+' - id and name don\'t matched, doubled, RPL35A'
	    + '<li><b>RPL35A</b> - '+link("YDL191W","orf")+' - id and name don\'t matched, doubled, RPL37A</ul>';

	var hoverBiogrid = '<p>BioGRID database is an online interaction repository with data compiled through comprehensive curation efforts.</p>'
	    + '<p>We retrieved protein-protein connections from this database in <i>S. cerevisiae</i>, <i>S. pombe</i>, <i>H. sapiens</i> and <i>A. thaliana</i>.</p>'
	    + '<p>Used version <b>3.2.106</b>, updated on 1 December, 2013</p>';

	var hoverAll = '<p>488 id from 489 ORF IDs were mapped to 490 unique UniProtKB/Swiss-Prot id. <b>3</b> duplicated UniProt IDs, <b>1</b> duplicated ORF ID were found.</p>'
	    + '<p>Duplicated IDs were: From <b>'+link("YBR084C","orf")+'</b> To '+link("P0CX82","uni")+', '+link("P0CX83","uni")+'<BR>'
	    + 'From <b>'+link("YBR196C","orf")+'</b> To '+link("Q3E820","uni")+', '+link("Q3E778","uni")+'<BR>'
	    + 'From <b>'+link("YDL083C","orf")+'</b> To '+link("P0CX51","uni")+', '+link("P0CX52","uni")+'</p>'
	    + '<p>Duplicated IDs were: From '+link("YCR061W","orf")+', '+link("YCR062W","orf")+' To <b>'+link("P25639","uni")+'</b></p>'
	    + '<p><b>Not mapped</b> ORF ID was <b>'+link("YCL060C","orf")+'</b></p>';

	var hoverInParanoid = '<p>The Inparanoid program was developed at the Center for Genomics and Bioinformatics to address the need to identify orthologs. '
	    + 'Homologs that originate from a speciation event are called orthologs and homologs that originate from a gene duplication event are called paralogs.</p>'
	    + '<p>More information: <a href="http://inparanoid.sbc.su.se/cgi-bin/faq.cgi" target="_blank">inParanoid FAQ</a></p>';

	$("#jorgensen").hovercard({ detailsHTML: hoverJorgensen, width: 400, cardImgSrc: 'media/images/data_jorgensen.png' });
	$("#moretto").hovercard({ detailsHTML: hoverMoretto, width: 400, cardImgSrc: 'media/images/data_moretto.png' });
	$("#moretto_more").hovercard({ detailsHTML: hoverMorettoMore, width: 400 });
	$("#jorg_dupl").hovercard({ detailsHTML: hoverDupl, width: 400 });
	$("#jorg_corr").hovercard({ detailsHTML: hoverCorr, width: 400 });
	$("#biogrid").hovercard({ detailsHTML: hoverBiogrid, width: 400 });
	$("#all").hovercard({ detailsHTML: hoverAll, width: 400 });
	$("#all2").hovercard({ detailsHTML: hoverAll, width: 400 });
	$("#one").hovercard({ detailsHTML: hoverAll, width: 400 });
	$("#inpara").hovercard({ detailsHTML: hoverInParanoid, width: 400 });

});
</script>
