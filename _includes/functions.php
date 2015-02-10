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
* Function Include
* ****************
*
* All code can be used under GNU General Public License version 2.
*
*/

class FajlBeolvas {

	public $szetszed1 = "\n";
	public $szetszed2 = "\r";
	public $fajl_teljes;
	public $fajl_tomb;
	public $faj_info;
	public $path_info;

	public function FajlBeolvas($fajl, $type, $separator = ";") {

		$hiba = "";

		$fajl_beolvas = fopen($fajl,"r");
		if(!$fajl_beolvas) $hiba .= "Nem tudtam beolvasni a <b>". $fajl ."</b> fájlt (lekérő) hozzáadásra!";

		if($hiba != "") die($hiba);

		$fajl_tartalom = fread($fajl_beolvas, filesize($fajl));
		$ujsor = explode($this->szetszed1, $fajl_tartalom);
		if(count($ujsor) < 100 ) $ujsor = explode($this->szetszed2, $fajl_tartalom);

		$sor = 0;
		$lekeres_lista = array();
		$path_info = array();
		$fajinfo = array();

		foreach ($ujsor as $sor_id => $sor_tartalom) {

			$sor++;
			if ( empty($sor_tartalom) ) continue;
			else {
				$mezo = explode($separator, $sor_tartalom);

				$unip = trim($mezo[0]);

				if($type == "path") {

					$path_name = trim($mezo[2]);
					$more_info = trim($mezo[3]);
					if(trim($mezo[6]) == "REACTOME") $href = trim($mezo[5]);
					else $href = "http://www.genome.jp/kegg-bin/show_pathway?" . $path_name;

					$idz = $unip . rand(100,999);

					$link = "<A HREF=\"". $href ."\" target=\"_blank\" onClick=\"$(\"#".$idz."\").toggle();\">". $path_name ."</A>"; // <DIV ID=\"".$idz."\" style=\"display: none;\">$more_info</DIV>";

					if(!array_key_exists($unip, $lekeres_lista)) $lekeres_lista[$unip] = array( $link );
					else $lekeres_lista[$unip][] = $link;

					$this_path = substr( trim( strip_tags($link) ), 3);

					if(! array_key_exists($this_path, $path_info)) $path_info[$this_path] = $more_info;

				}
				elseif($type == "faj") {
					$info = trim($mezo[1]);
					$lekeres_lista[$unip] = array();

					$benne = array(1, 3, 5, 7, 9, 10, 11);

					for ($i=1; $i < count($mezo); $i++) {
						if(in_array($i, $benne)) $lekeres_lista[$unip][] = $mezo[$i];
					}

					//if($info != "FIRST")
						$fajinfo[$unip] = $info;
				}
				elseif($type == "db") {

					$faj1 = trim($mezo[0]);
					$unip1 = trim($mezo[1]);
					$faj2 = trim($mezo[2]);
					$unip2 = trim($mezo[3]);

					$dbs = "";
					for ($i=4; $i < count($mezo); $i++) {
						if( empty($mezo[$i])) continue;
						$dbs .= $mezo[$i] . ", ";
					}
					$dbs = substr($dbs, 0, -2);

					if(! array_key_exists($unip1, $lekeres_lista )) $lekeres_lista[$unip1] = array($faj2 => array($unip2 => $dbs));
					elseif(! array_key_exists($faj2, $lekeres_lista[$unip1] )) $lekeres_lista[$unip1][$faj2] = array($unip2 => $dbs);
					else $lekeres_lista[$unip1][$faj2][$unip2] = $dbs;
				}
				elseif ($type == "reg") {
					$regular = explode(" ", trim($mezo[1]));
					$regular_rovid = trim($regular[0]);
					$regular_hosszu = trim($mezo[2]);

					$lekeres_lista[$unip] = array();
					$lekeres_lista[$unip]["rovid"] = str_replace("\"", "", $regular_rovid);
					$lekeres_lista[$unip]["hosszu"] = $regular_hosszu;

				}

			}
		}

		fclose($fajl_beolvas);
		$this->fajl_tomb = $lekeres_lista;
		$this->faj_info = $fajinfo;
		$this->path_info = $path_info;

	}
}

class Lekeres {

	public $jsonfile;
	public $kegg = array();
	public $kegg_info = array();
	public $reactome = array();
	public $dbs = array();
	public $regular = array();
	public $cyjs_output = array();
	public $print_table;

	private $headers = array();
	private $files;
	private $json;
	private $actual_PathwayContainer = array();
	private $actual_return_string = "";
	private $QueryLevel;

	public function Lekeres ($fajl, $values){

		// MAIN THREAD FUNCTION

		//Read files and put in a global value
			self::Files($fajl);

		//Analyze result
			if($values["ov"] == "one") self::OneByOne($values);

			else self::Overview($values);

		//Create Table to print
			self::Table();

		//Create JSON file & write out in a file for JQuery DataTables
			self::KiirJSON();

		return true;
	}

	private function Files($fajl) {

		$files = array();

		$files["at"] =  new FajlBeolvas($fajl["at"], "faj");
		$files["dm"] =  new FajlBeolvas($fajl["dm"], "faj");
		$files["sc"] =  new FajlBeolvas($fajl["sc"], "faj");
		$files["sp"] =  new FajlBeolvas($fajl["sp"], "faj");
		$files["hs"] =  new FajlBeolvas($fajl["hs"], "faj");
		$files["kegg"] = new FajlBeolvas($fajl["kegg"], "path", "\t");
		$files["reactome"] =  new FajlBeolvas($fajl["reac"], "path", "\t");
		$files["dbs"] =  new FajlBeolvas($fajl["data"], "db");
		$files["regular"] = new FajlBeolvas($fajl["reg"], "reg", "\t");

		$this->kegg = $files["kegg"]->fajl_tomb;
		$this->kegg_info = $files["kegg"]->path_info;
		$this->reactome = $files["reactome"]->fajl_tomb;
		$this->dbs = $files["dbs"]->fajl_tomb;
		$this->regular = $files["regular"]->fajl_tomb;

		$this->files = $files;

		return true;
	}

	private function OneByOne($values) {

		$faj = array();
		$faj["at"] = array("lil" => "AT", "mid" => "A.thaliana", "long" => "Arabidopsis thaliana", "taxid" => "3702");
		$faj["dm"] = array("lil" => "DM", "mid" => "D.melanogaster", "long" => "Drosophila melanogaster", "taxid" => "7227");
		$faj["sc"] = array("lil" => "SC", "mid" => "S.cerevisiae", "long" => "Saccharomyces cerevisiae", "taxid" => "559292");
		$faj["sp"] = array("lil" => "SP", "mid" => "S.pombe", "long" => "Schizosaccharomyces pombe", "taxid" => "4896");
		$faj["hs"] = array("lil" => "HS", "mid" => "H.sapiens", "long" => "Homo sapiens", "taxid" => "9606");

		$QueryLevel = array();
		$QueryLevel["2"] = array("orth", "path", "size_mut1", "size_mut2", "size_mut3", "size_mut4", "size_mut5", "size_mut6", "same");
		$QueryLevel["3"] = array("path", "size_mut1", "size_mut2", "size_mut3", "size_mut4", "size_mut5", "size_mut6", "same");
		$QueryLevel["3b"] = array("path", "size_mut1", "size_mut2", "same");
		$QueryLevel["4"] = array("size_mut1", "size_mut2", "size_mut3", "size_mut4", "size_mut5", "size_mut6", "same");
		$QueryLevel["4a"] = array("size_mut1","same");
		$QueryLevel["4b"] = array("size_mut2", "same");
		$QueryLevel["4c"] = array("size_mut3");
		$QueryLevel["4d"] = array("size_mut4");
		$QueryLevel["4e"] = array("size_mut5");
		$QueryLevel["4f"] = array("size_mut6");
		$QueryLevel["5"] = array("same");

		$this->QueryLevel = $QueryLevel;

		$sor = 0;
		$tablazat = array();
		$tablazat_check = array();

		$value_fajnev = $values["faj_nev"]; // like sc, sp, at, dm, hs
		$value_lines = $values["lines"]; // type of the query

		/* HEADER START */

		// Header of first (comparative) species

			$this->headers = array();
			$this->headers[] = $faj[$value_fajnev]["mid"] . " <BR> (UniProt id)";
			$this->headers[] = "Paths";

		// Header of other species

			foreach ($faj as $azi => $fajom_array) {

				if($value_fajnev == $azi) continue;
				$this->headers = array_merge($this->headers, array($fajom_array["mid"] . " <BR> (UniProt id)", "Paths"));

			}

		/* HEADER END */

		foreach ($this->files[$value_fajnev]->fajl_tomb as $faj_unip => $faj_array) {

			// This SOR: Contains my sor in this foreach cycle
			$this_sor = array();

			// This SOR: (1) UniProt NEV
			$this_sor[] = self::UniProtNev($faj_unip);

			$KiindulasiPathway = self::PathWays($faj_unip);
			$PathwaysContainer = array($value_fajnev => $this->actual_PathwayContainer);

			// In case we need to have all fileds a pathway
			if( (in_array($value_lines, $QueryLevel["3b"])) AND substr_count($KiindulasiPathway, "NONE") > 1 ) continue;

			if( $value_fajnev == "sc" ) $IsInSizecontrolList = array("D.melanogaster" => false, "S.pombe" => false); // S.cerevisiae esetén
			elseif( $value_fajnev == "sp" ) $IsInSizecontrolList = array("D.melanogaster" => false, "S.cerevisiae" => false); // S.pombe esetén
			elseif( $value_fajnev == "dm" OR $value_fajnev == "at" OR $value_fajnev == "hs" ) $IsInSizecontrolList = array("S.pombe" => false, "S.cerevisiae" => false); // S.pombe esetén

			$this_sor[] = $KiindulasiPathway;

			$SizecontrolListCount = 0;
			$SizecontrolListCountSpecies = array();
			$EmptyFieldsCount = 0;
			$NoPathWay = false;

            $Numero_Orths = array();
            $Numero_MoreThanOne = false;

			foreach ($faj as $azi => $fajom_array) {

				if($value_fajnev == $azi) continue;

				$OrthologsReturn = self::Orthologs($faj_unip, $fajom_array["mid"], $this->files[$azi]->faj_info, $value_lines);
				$PathwaysContainer[$azi] = $this->actual_PathwayContainer;

				if( $OrthologsReturn["lista"] ) {
					if(array_key_exists($fajom_array["mid"], $IsInSizecontrolList)) $IsInSizecontrolList[ $fajom_array["mid"] ] = true;
					$SizecontrolListCount++;
					$SizecontrolListCountSpecies[] = $fajom_array["mid"] . ( ($OrthologsReturn["lista"] == "First") ? " (FIRST)" : "" );
				}
				if($OrthologsReturn["orths"] == "NONE") $EmptyFieldsCount++;
				if($OrthologsReturn["paths"] == "NONE" && (in_array($value_lines, $QueryLevel["3"])) ) $NoPathWay = true;

                $Numero_Orths[] = $OrthologsReturn["num"];
                $Numero_MoreThanOne = ( ($OrthologsReturn["num"] > 1 ) ? true : $Numero_MoreThanOne );

				$this_sor[] = $OrthologsReturn["orths"];
				$this_sor[] = $OrthologsReturn["paths"];
			}

			$IsSamePathway = self::PathWayAnalyzer($PathwaysContainer, $value_lines);

            //if($Numero_MoreThanOne) continue;

			//if( ($EmptyFieldsCount > 3) ) continue;

			if( (in_array($value_lines, $QueryLevel["2"])) && ($EmptyFieldsCount != 0) ) continue;

			if( (in_array($value_lines, $QueryLevel["3b"])) && ($NoPathWay) ) continue;

			if( (in_array($value_lines, $QueryLevel["4"])) && ($SizecontrolListCount == 0) ) continue;

			if( (in_array($value_lines, $QueryLevel["4b"])) OR (in_array($value_lines, $QueryLevel["4d"])) ) {

				foreach ($IsInSizecontrolList as $fajom => $value) {

					if($value == false) $SizecontrolListCount = 0;

				}

				if($SizecontrolListCount == 0) continue;
				if($SizecontrolListCount < 3) continue;
			}

			if( (in_array($value_lines, $QueryLevel["4e"])) && count($SizecontrolListCountSpecies) < 4) continue;

			if( (in_array($value_lines, $QueryLevel["5"])) && (! $IsSamePathway)) continue;

			$tablazat[] = $this_sor;

		}

		$this->json = json_encode($tablazat);

		return true;
	}

	private function PathWayAnalyzer($PathwaysContainer, $value_lines){

		$pathways = array();
		$return_string = "";
		$return_array = array();

		foreach ($PathwaysContainer as $faj_name => $arri) {

			foreach ($arri as $protein_name => $arri2) {

				if(! is_array($arri2["kegg"]) ) continue;

				foreach ($arri2["kegg"] as $num => $path) {

					$this_path = substr( trim( strip_tags($path) ), 3);

					if(! array_key_exists($this_path, $pathways)) $pathways[$this_path] = array($faj_name);
					elseif(! in_array( $faj_name, $pathways[$this_path])) $pathways[$this_path][] = $faj_name;

				}
			}
		}


		foreach ($pathways as $pathway => $arri) {

			//if(count($arri) > 4) print count($arri) . "x " . $pathway . ": " . $this->kegg_info[$pathway] . '<BR>';

			if(count($arri) > 2) $return_array[] = count($arri) . "x " . $pathway . ": " . $this->kegg_info[$pathway];

			if(count($arri) == 5 && in_array($value_lines, $this->QueryLevel["5"])) $return_string .= $pathway . ", <BR>";
		}

		asort($return_array);

		$this->actual_return_string = "<BR><BR>" . implode(", <BR>", $return_array);

		if($return_string == "") return false;
		else return true;
	}

	private function UniProtNev($unip, $csaknev = false, $csaklink = false) {

		if($csaknev) {
			if(array_key_exists($unip, $this->regular)) return $this->regular[$unip]["rovid"];
			else return $unip;
		}

		$ret = "<a href=\"http://www.uniprot.org/uniprot/" . $unip . "\" target=\"_blank\">" . $unip . "</a>";

		if(array_key_exists($unip, $this->regular)) return "<B>" . $this->regular[$unip]["rovid"] . "</B>" . " <BR>" . "(" . $ret . ")";
		else return $ret;
	}

	private function PathWays($unip) {

		$ret = "";
		$actual_PathwayContainer = array();

		// KEGG DB CHECK

			if(array_key_exists($unip, $this->kegg) ) {

				$ret .= "KEGG: " . implode(", ", $this->kegg[$unip]);
				$actual_PathwayContainer["kegg"] = $this->kegg[$unip];
			}

			else {
				$ret .= "KEGG: NONE";
				$actual_PathwayContainer["kegg"] = false;
			}

		$ret .= " <BR><BR>";

		$this->actual_PathwayContainer[$unip] = $actual_PathwayContainer;
		return $ret;
	}

	private function Orthologs($unip, $fajom, $fajinfo, $value_lines) {

		$ret_orths = ""; // Orthologs
        $ret_NumOrths = 0;
		$ret_paths = ""; // Pathways
		$ret_lista = false; // Is in an another Size Control List? true or false

		$fajinfo_array = array();

		// PW Container reset
		$this->actual_PathwayContainer = array();

		// Nulla array
		$none = array("orths" => "NONE", "paths" => "NONE", "lista" => false, "num" => 0);

		if( array_key_exists($unip, $this->dbs) ) {

			if(! array_key_exists($fajom, $this->dbs[$unip]) ) return $none;

			else {

				foreach ($this->dbs[$unip][$fajom] as $unip2 => $dbs) {

					if(substr_count($dbs, ",") == 0 && $fajom == "A.thaliana") continue;
					if(substr_count($dbs, ",") == 0 && $fajom == "H.sapiens") continue;
					//if( substr_count($dbs, ",") == 0) continue;
					//if( substr_count($dbs, ",") == 0 ) continue;

					$this_pathways = self::PathWays($unip2);

					if( (in_array($value_lines, $this->QueryLevel["3b"])) && substr_count($this_pathways, "NONE") > 1) continue;

					//if( !array_key_exists($unip2, $fajinfo)) continue;
					//if( $fajinfo[$unip2] == "FIRST") continue;

					$ret_orths .= self::UniProtNev($unip2) /*. ": " . $dbs*/ . "<BR><BR>   ";
					$ret_paths .= "<B><UL>" . self::UniProtNev($unip2, true)  . "</UL></B> <BR>" . $this_pathways . "<BR><BR>";

					if(array_key_exists($unip2, $fajinfo)) {

						$ret_lista = true;
						$ret_paths .= "<DIV style=\"background: yellow;\"><B>$fajom list:</B> " . $fajinfo[$unip2] . "</DIV><BR><BR>";

						if(array_key_exists($fajinfo[$unip2], $fajinfo_array)) $fajinfo_array[$fajinfo[$unip2]]++;
						else $fajinfo_array[$fajinfo[$unip2]] = 1;

					}

                    $ret_NumOrths++;

				}

			}

		}

		else return $none;

		if($ret_lista) {

			$IsFirst = ( (array_key_exists("FIRST", $fajinfo_array)) ? true : false );

			foreach ($fajinfo_array as $id => $number) {
				if($id != "FIRST") $IsFirst = false;
			}

			if(! $IsFirst) $ret_lista = "NotFirst";
			else $ret_lista = "First";
		}

		if($ret_orths == "") return $none;
		else return array("orths" => substr($ret_orths, 0, -11), "paths" => substr($ret_paths, 0, -8), "lista" => $ret_lista, "num" => $ret_NumOrths);
	}

	private function Table(){

		// create table string values for HEADERS

		$print_headers = "";
		$percentem = 100 / count($this->headers);

		foreach($this->headers as $num => $this_head) $print_headers .= "\t\t<th width=\"".$percentem."%\">" . $this_head . "</th>\n";

		$table = "\t<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"research\">
			<thead>
				<tr>
				". $print_headers . "
				</tr>
			</thead>
			<tbody>

			</tbody>
			<tfoot>
				<tr>
				". $print_headers . "
				</tr>
			</tfoot>\n\t</table>";

		$this->print_table = $table;

		return true;
	}

	private function KiirJSON(){

		//writes everything out to a JSON file

		$mitirjak = "{\"aaData\": " . $this->json . "}";

		$date = date("ymd_His");
 		$rand = rand(10,99);
 		$fajl = "_query/jsonquery_" . $date . "_" . $rand . ".txt";
 		$this->jsonfile = $fajl;

		$hiba = "";

		$fajl_beolvas = fopen($fajl,"w");
		if(!$fajl_beolvas) $hiba .= "Nem tudtam beolvasni a <b>". $fajl ."</b> fájlt (lekérő) hozzáadásra!";
		if($hiba != "") die($hiba);

		fwrite($fajl_beolvas, $mitirjak);
	}

}

?>
