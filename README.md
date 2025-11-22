# Ortholog Finder Tool v1.1

[![License: GPL v2](https://img.shields.io/badge/License-GPL_v2-blue.svg)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)
[![Version](https://img.shields.io/badge/version-1.1-green.svg)]()
[![PHP](https://img.shields.io/badge/PHP-5.6%2B-777BB4.svg)]()
[![jQuery](https://img.shields.io/badge/jQuery-1.11.2-0769AD.svg)]()
[![DataTables](https://img.shields.io/badge/DataTables-1.10.5-336699.svg)]()

A unified bioinformatics web tool for exploring evolutionarily conserved proteins across model organisms. Combines **multi-database ortholog search** with **Gene Ontology annotation extension** via ortholog-based Venn diagram analysis.

> **Thesis:** Dul, Z. (2018). *A system-level approach to identify novel cell size regulators.* King's College London.
> [KCL Pure](https://kclpure.kcl.ac.uk/portal/en/studentTheses/a-system-level-approach-to-identify-novel-cell-size-regulators/)

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Two Modes](#-two-modes)
- [Model Organisms](#-model-organisms)
- [Live Versions](#-live-versions)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Project Structure](#-project-structure)
- [Data Sources](#-data-sources)
- [Academic References](#-academic-references)
- [History](#-history)
- [Author](#-author)
- [License](#-license)

---

## 🔬 Overview

The Ortholog Finder Tool was developed as part of a PhD project at King's College London (2013–2018) to systematically identify conserved regulators of cell size across eukaryotic model organisms. It integrates orthologous protein relationships from multiple databases and cross-references them with pathway annotations and genome-wide functional screen data.

**Version 1.1** unifies two previously separate tools into a single application:

| Previously | URL | Now |
|---|---|---|
| Ortholog Finder Tool v1.5 | [orthologfindertool.com](http://orthologfindertool.com) | **Mode A: Ortholog Search** |
| GeneOntology Extension Tool v1.0 | [go.orthologfindertool.com](http://go.orthologfindertool.com) | **Mode B: GO Extension** |

---

## 🧬 Two Modes

### Mode A — Ortholog Search

Multi-database ortholog lookup with pathway annotations and cell-size screen hit data.

- **5 species:** AT, DM, HS, SC, SP
- **6 ortholog databases:** HomoloGene, orthoMCL v5, InParanoid v8, eggNOG v4, COG/KOG, PomBase
- **Pathway data:** KEGG and Reactome annotations per protein
- **Screen data:** Published cell-size regulatory gene lists (Jorgensen, Moretto, Hayles, Björklund, Neumann)
- **Query levels:** `orth` (all orthologs), `path` (with pathways), `same` (shared pathways), `size_mut1–6` (screen hit filters)
- **Output:** Interactive sortable/searchable DataTable + CSV download
- **Data:** 225,000 ortholog pairs across 40 MB of pre-processed flat files

### Mode B — GO Extension

Gene Ontology annotation extension via eggNOG ortholog groups, visualized with Venn diagrams.

- **7 species:** AT, CE, DM, DR, HS, SC, SP
- **85 GO Slim Generic terms** (from GO Consortium)
- **Venn diagram types:** Classic Venn (2–7 sets) and Edwards-Venn (2–7 sets)
- **Configurable threshold:** Minimum species co-occurrence (2–7)
- **4 result tables:** Filtered hits, expanded list, conserved core, novel annotation suggestions
- **Data:** 75 eggNOG export CSVs + 12 SVG diagram templates
- **Backend:** MySQL queries against `orthology_databases` and `geneontology` tables

---

## 🧫 Model Organisms

| Organism | Code | Taxonomy ID | Mode A | Mode B |
|---|---|---|---|---|
| *Arabidopsis thaliana* | AT | 3702 | ✅ | ✅ |
| *Caenorhabditis elegans* | CE | 6239 | — | ✅ |
| *Drosophila melanogaster* | DM | 7227 | ✅ | ✅ |
| *Danio rerio* | DR | 7955 | — | ✅ |
| *Homo sapiens* | HS | 9606 | ✅ | ✅ |
| *Saccharomyces cerevisiae* | SC | 559292 | ✅ | ✅ |
| *Schizosaccharomyces pombe* | SP | 4896 | ✅ | ✅ |

---

## 🌐 Live Versions

| Tool | URL | Status |
|---|---|---|
| Ortholog Search (original) | [orthologfindertool.com](http://orthologfindertool.com) | Online |
| GO Extension (original) | [go.orthologfindertool.com](http://go.orthologfindertool.com) | Online |

---

## 🚀 Installation

### Requirements

- PHP 5.6 or higher
- MySQL 5.7 or higher
- Apache or compatible web server

### Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/ZoliQua/Ortholog-Finder-Tool.git
   cd Ortholog-Finder-Tool
   ```

2. **Create `.env` file** from the template:
   ```bash
   cp .env.example .env
   ```

3. **Edit `.env`** with your database credentials:
   ```env
   DB_HOST=localhost
   DB_USER=root
   DB_PASS=your_password
   DB_NAME=ortholog
   DB_SOCKET=
   DB_PORT=3306
   ```

4. **Set up MySQL database:**

   For **Mode A** (Ortholog Search): No MySQL tables required for the core query — all data is file-based (CSV/TSV). The MySQL connection is only used for GeoIP visitor logging (`ip2c` table).

   For **Mode B** (GO Extension): Requires `orthology_databases` and `geneontology` tables in the `orthology` database. These contain the ortholog mappings and GO annotation data used by the QueryGO class.

5. **Point your web server** to the project root and open `index.php` in a browser.

---

## ⚙️ Configuration

### Environment Variables (`.env`)

| Variable | Description | Default |
|---|---|---|
| `DB_HOST` | MySQL hostname | `localhost` |
| `DB_USER` | MySQL username | `root` |
| `DB_PASS` | MySQL password | *(empty)* |
| `DB_NAME` | MySQL database name | `ortholog` |
| `DB_SOCKET` | Unix socket path (optional, for MAMP/XAMPP) | *(empty)* |
| `DB_PORT` | MySQL port (0 = default) | `3306` |

---

## 📁 Project Structure

```
orthologfindertool-v1.1/
│
├── index.php                → Redirect to main.php
├── main.php                 → Unified router (mode switching)
├── download.php             → CSV export handler
├── dumper.php               → GO batch export (all 85 terms)
│
├── includes/
│   ├── mysql.php            → Database connection (.env based)
│   ├── mylog.php            → Visitor logging (CSV + GeoIP)
│   ├── ip2country.php*      → GeoIP country detection
│   │
│   ├── functions.php        → FajlBeolvas + Lekeres classes (Mode A core)
│   ├── inc_analyzer.php     → QueryGO class (Mode B core)
│   ├── inc_analyzer_dumper.php → QueryGOExport (batch CSV)
│   ├── inc_functions.php    → VennDiagram + SVG_File + helpers
│   ├── inc_variables.php    → Species, GO terms, POST handling
│   │
│   ├── page_landing.php     → Mode selector (landing page)
│   ├── page_ortholog_form.php    → Mode A: query form
│   ├── page_ortholog_results.php → Mode A: results + DataTable
│   ├── page_2_analysis_{species}.php → Mode A: per-species table templates
│   ├── page_go_analyzer.php → Mode B: GO form + results + 4 DataTables
│   ├── page_sources.php     → References page
│   └── page_aboutus.php     → About page
│
├── _dataset/                → Mode A data files (40 MB)
│   ├── ALL_ortholog_dbs_merged.csv   → 225K ortholog pairs (6 DBs)
│   ├── kegg_pathways_uniprot.tsv     → KEGG pathway annotations
│   ├── reactome_pathways_uniprot.tsv → Reactome pathway annotations
│   ├── regular_names.txt             → UniProt ID → gene name mapping
│   └── {AT,DM,HS,SC,SP}_interact_deg2_exp.csv → Cell-size screen data
│
├── source/                  → Mode B source data (15 MB)
│   ├── eggNOG-export-*-7.csv (×75) → eggNOG ortholog group exports
│   └── ortholog_*_sample.svg (×12)  → Venn diagram SVG templates
│
├── output/                  → Mode B generated output (15 MB)
│   ├── eggNOG-export-*-7.csv (×75) → Processed results
│   └── GO*-Venn-Diagram-*.svg (×49) → Generated Venn diagrams
│
├── _query/                  → Mode A pre-computed results (23 MB)
│   └── jsonquery_{species}.txt      → DataTables JSON (per species)
│
├── media/
│   ├── css/unified.css      → Merged stylesheet
│   ├── js/                  → jQuery 1.11.2 + DataTables 1.10.5
│   └── images/              → Logos, icons, organism photos
│
├── _log/                    → Visitor logs (not tracked)
├── .env.example             → Environment template
├── .gitignore
└── LICENSE.md               → GNU GPL v2
```

### URL Routing

| URL | Page |
|---|---|
| `main.php` | Landing page — mode selector |
| `main.php?mode=ortholog` | Ortholog Search form |
| `main.php?mode=go` | GO Extension form |
| `main.php?page=source` | References |
| `main.php?page=about` | About Us |

---

## 📊 Data Sources

### Ortholog Databases (Mode A)

| Database | Version | Date |
|---|---|---|
| [BioGRID](https://thebiogrid.org/) | 3.2.112 | April 2014 |
| [eggNOG](http://eggnogdb.embl.de/) | 4.0 | December 2013 |
| [InParanoid](http://inparanoid.sbc.su.se/) | 8.0 | December 2013 |
| [orthoMCL](https://orthomcl.org/) | 5 | 2013 |
| [HomoloGene](https://www.ncbi.nlm.nih.gov/homologene) | — | 2014 |
| [COG/KOG](https://www.ncbi.nlm.nih.gov/research/cog/) | — | 2014 |

### Pathway Databases (Mode A)

| Database | URL |
|---|---|
| [KEGG](https://www.genome.jp/kegg/) | genome.jp/kegg |
| [Reactome](https://reactome.org/) | reactome.org |

### Additional Databases

| Database | Version | Purpose |
|---|---|---|
| [UniProt](https://www.uniprot.org/) | 2014_04 | ID mapping & protein names |
| [PomBase](https://www.pombase.org/) | V2.19 | Pombe↔Human/Cerevisiae curated orthologs |
| [intAct](https://www.ebi.ac.uk/intact/) | 2013-11-20 | Protein interaction data |
| [MitoCheck](http://www.mitocheck.org/) | ens73 | H. sapiens phenotype data |

### GO Annotation (Mode B)

| Source | Details |
|---|---|
| [Gene Ontology](http://geneontology.org/) | 85 GO Slim Generic terms |
| [eggNOG](http://eggnogdb.embl.de/) v4 | Ortholog group → protein mapping |

---

## 📚 Academic References

### Cell-Size Screen Publications

| Species | Publication | Journal | Year |
|---|---|---|---|
| *S. cerevisiae* | Jorgensen P et al. — *Systematic identification of pathways that couple cell growth and division in yeast* | Science | 2002 |
| *S. cerevisiae* | Moretto F et al. — *A pharmaco-epistasis strategy reveals a new cell size controlling pathway in yeast* | Mol Syst Biol | 2013 |
| *S. pombe* | Hayles J et al. — *A genome-wide resource of cell cycle and cell shape genes of fission yeast* | Open Biology | 2013 |
| *S. pombe* | Graml V et al. — *A genomic multiprocess survey of machineries that control and link cell shape, microtubule organization, and cell-cycle progression* | Dev Cell | 2014 |
| *D. melanogaster* | Björklund M et al. — *Identification of pathways regulating cell size and cell-cycle progression by RNAi* | Nature | 2006 |
| *H. sapiens* | Neumann B et al. — *Phenotypic profiling of the human genome by time-lapse microscopy reveals cell division genes* | Nature | 2010 |

### Gene Ontology

Ashburner M et al. (2000). *Gene Ontology: tool for the unification of biology.* Nature Genetics, 25(1), 25–29. [doi:10.1038/75556](https://doi.org/10.1038/75556)

### External Code

| Library | Version | License |
|---|---|---|
| [jQuery](https://jquery.com/) | 1.11.2 | MIT |
| [jQuery DataTables](https://datatables.net/) | 1.10.5 | MIT |
| [ip2country](http://phpweby.com/software/ip2country) by Blagoj Janevski | — | GNU GPL v2 |

---

## 📜 History

This tool was originally published as two separate web applications during 2015–2018:

1. **Ortholog Finder Tool** ([orthologfindertool.com](http://orthologfindertool.com)) — Multi-database ortholog search with pathway and screen data integration. Source: [ZoliQua/Ortholog-Finder-Tool](https://github.com/ZoliQua/Ortholog-Finder-Tool)

2. **GeneOntology Extension Tool** ([go.orthologfindertool.com](http://go.orthologfindertool.com)) — GO annotation extension via eggNOG ortholog groups with Venn diagram visualization. Source: [ZoliQua/GO-Orthology-Tool](https://github.com/ZoliQua/GO-Orthology-Tool)

**Version 1.1** (November 2025) unifies both tools into a single application with a shared navigation and mode-selection interface. No data or backend logic was changed — only the UI was consolidated.

The git history of this repository preserves the full commit histories of both original repositories.

---

## 👤 Author

**Zoltán Dul**
PhD Student (2013–2018), King's College London

- 📧 zoltan.dul@kcl.ac.uk / zoltan.dul@gmail.com

### Supervisors & Groups

- **Cell Cycle & Epigenetics Team** — Prof. N. Shaun B. Thomas, Division of Cancer Studies, King's College London
- **Csikász-Nagy Group** — Dr. Attila Csikász-Nagy, Randall Division of Cell and Molecular Biophysics, King's College London
- **Genomics and Biology of Fruit Crop** — Dr. Azeddine Si Ammour, Fondazione Edmund Mach, San Michele all'Adige

---

## 📄 License

This project is licensed under the [GNU General Public License v2.0](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html).

---

<p align="center">
  <i>Built at King's College London & Fondazione Edmund Mach</i>
</p>
