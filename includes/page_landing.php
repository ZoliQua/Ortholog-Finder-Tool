<?php

/*
* Project Name: Ortholog Finder Tool
* Project Version: 1.1 (Unified)
*
* PHP FILE: Landing page — mode selector
*
* All code can be used under GNU General Public License version 2.
*/

?>
<div class="landing">

<p style="font-size: 14px; color: #555; margin-bottom: 30px;">
	A bioinformatics tool for exploring evolutionarily conserved proteins across model organisms.<BR>
	Choose a tool below to get started.
</p>

<table class="mode-selector" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td width="50%">
		<a href="main.php?mode=ortholog" class="mode-card">
			<div class="mode-card-inner">
				<h3>Ortholog Search</h3>
				<p class="mode-desc">Multi-database ortholog lookup with KEGG/Reactome pathway annotations and cell-size screen hit data.</p>
				<div class="mode-details">
					<span>5 species</span> &middot;
					<span>6 databases</span> &middot;
					<span>KEGG &amp; Reactome</span>
				</div>
			</div>
		</a>
	</td>
	<td width="50%">
		<a href="main.php?mode=go" class="mode-card">
			<div class="mode-card-inner">
				<h3>GO Extension</h3>
				<p class="mode-desc">Gene Ontology annotation extension via ortholog groups with Venn diagram visualization.</p>
				<div class="mode-details">
					<span>7 species</span> &middot;
					<span>85 GO Slim terms</span> &middot;
					<span>Venn diagrams</span>
				</div>
			</div>
		</a>
	</td>
</tr>
</table>

<div style="margin-top: 30px;">
	<p style="font-size: 12px; color: #888;">
		Originally published as two separate tools:
		orthologfindertool.com &amp;
		go.orthologfindertool.com
	</p>
</div>

<table class="mode-selector" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td width="100%">
		<a href="main.php?mode=research" class="mode-card">
			<div class="mode-card-inner" style="border-style: dashed;">
				<h3>Experimental Ortholog Search (Unpublished)</h3>
				<p class="mode-desc">Dynamic multi-database ortholog query with progressive filtering.
				Real-time computation across 6 ortholog databases with KEGG pathway cross-referencing
				and cell-size screen hit integration. Supports 10 query levels from unfiltered to shared-pathway analysis.</p>
				<div class="mode-details">
					<span>5 species</span> &middot;
					<span>6 databases</span> &middot;
					<span>10 query levels</span> &middot;
					<span>KEGG pathways</span> &middot;
					<span>cell-size screens</span>
				</div>
			</div>
		</a>
	</td>
</tr>
</table>

</div>
