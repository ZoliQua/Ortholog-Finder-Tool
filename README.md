# Ortholog Finder Tool

[![License: GPL v2](https://img.shields.io/badge/License-GPL_v2-blue.svg)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)
[![Version](https://img.shields.io/badge/version-1.5-green.svg)]()
[![PHP](https://img.shields.io/badge/PHP-5.6%2B-777BB4.svg)]()

A bioinformatics web tool that identifies evolutionarily conserved proteins described as functional regulators in genome-wide studies. The tool integrates orthologous databases and protein-protein interaction (PPI) networks across five model organisms, with a current focus on **cell size regulation**.

## Table of Contents

- [Overview](#overview)
- [Model Organisms](#model-organisms)
- [Live Demo](#live-demo)
- [Installation](#installation)
- [Configuration](#configuration)
- [Project Structure](#project-structure)
- [Data Sources](#data-sources)
- [References](#references)
- [External Code](#external-code)
- [Author](#author)
- [License](#license)

## Overview

The Ortholog Finder Tool collects and cross-references functional orthologs from multiple species, allowing researchers to:

- Query orthologous relationships across five model organisms
- Integrate data from multiple ortholog and PPI databases
- Explore KEGG and Reactome pathway annotations
- Download results for further analysis

## Model Organisms

| Organism | Abbreviation | Taxonomy ID |
|---|---|---|
| *Arabidopsis thaliana* | AT | 3702 |
| *Drosophila melanogaster* | DM | 7227 |
| *Homo sapiens* | HS | 9606 |
| *Saccharomyces cerevisiae* | SC | 559292 |
| *Schizosaccharomyces pombe* | SP | 4896 |

## Live Demo

An identical version of this tool is available at: **[orthologfindertool.com](http://www.orthologfindertool.com)**

## Installation

### Requirements

- PHP 5.6 or higher
- MySQL 5.7 or higher
- Apache or compatible web server

### Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/ZoliQua/Ortholog-Finder-Tool.git
   ```

2. Create a `.env` file in the project root (see [Configuration](#configuration)).

3. Import the `ip2c` GeoIP table into your MySQL database:
   ```sql
   CREATE DATABASE ortholog;
   USE ortholog;
   CREATE TABLE ip2c (
     id INT(10) UNSIGNED AUTO_INCREMENT,
     begin_ip VARCHAR(20),
     end_ip VARCHAR(20),
     begin_ip_num INT(11) UNSIGNED,
     end_ip_num INT(11) UNSIGNED,
     country_code VARCHAR(3),
     country_name VARCHAR(150),
     PRIMARY KEY(id),
     INDEX(begin_ip_num, end_ip_num)
   ) ENGINE=MyISAM;
   ```

4. Load GeoIP data from the included CSV:
   ```sql
   LOAD DATA LOCAL INFILE '_includes/GeoIPCountryWhois.csv'
   INTO TABLE ip2c
   FIELDS TERMINATED BY ',' ENCLOSED BY '"'
   LINES TERMINATED BY '\n'
   (begin_ip, end_ip, begin_ip_num, end_ip_num, country_code, country_name);
   ```

5. Point your web server's document root to the project directory.

## Configuration

The application uses a `.env` file for database configuration. Copy the example and edit it:

```bash
cp .env.example .env
```

### Environment Variables

| Variable | Description | Default |
|---|---|---|
| `DB_HOST` | MySQL hostname | `localhost` |
| `DB_USER` | MySQL username | `root` |
| `DB_PASS` | MySQL password | *(empty)* |
| `DB_NAME` | Database name | `ortholog` |
| `DB_SOCKET` | Unix socket path (leave empty for TCP) | *(empty)* |
| `DB_PORT` | MySQL port | `3306` |

## Project Structure

```
orthologfindertool/
├── main.php                 # Main application entry point
├── index.php                # Redirect to main.php
├── download.php             # File download handler
├── .env                     # Database configuration (not tracked)
├── .env.example             # Configuration template
├── _includes/
│   ├── mysql.php            # Database connection with .env support
│   ├── functions.php        # Core analysis logic (FajlBeolvas, Lekeres)
│   ├── mylog.php            # Visitor logging
│   ├── ip2country.php       # GeoIP module loader
│   ├── ip2country.php5.php  # GeoIP lookup (PHP 5+ version)
│   ├── page_1_form.php      # Query form page
│   ├── page_2_analysis.php  # Results page with DataTables
│   ├── page_5_sources.php   # Data sources page
│   └── page_6_aboutus.php   # About page
├── _dataset/
│   ├── ALL_ortholog_dbs_merged.csv   # Merged ortholog database
│   ├── kegg_pathways_uniprot.tsv     # KEGG pathway annotations
│   ├── reactome_pathways_uniprot.tsv # Reactome pathway annotations
│   ├── regular_names.txt             # Protein name mappings
│   ├── *_interact_deg2_exp.csv       # PPI data per species
│   └── ...
├── _media/
│   ├── css/                 # Stylesheets
│   └── js/                  # jQuery & DataTables
├── _query/                  # Generated JSON query results
└── _log/                    # Visitor logs (not tracked)
```

## Data Sources

### Ortholog Databases

| Database | URL |
|---|---|
| BioGRID | [thebiogrid.org](https://thebiogrid.org/) |
| COG/KOG | [ncbi.nlm.nih.gov/COG](https://www.ncbi.nlm.nih.gov/COG/) |
| eggNOG | [eggnog.embl.de](http://eggnog.embl.de/) |
| Ensembl BioMart | [ensembl.org/biomart](https://www.ensembl.org/biomart/) |
| HomoloGene | [ncbi.nlm.nih.gov/homologene](https://www.ncbi.nlm.nih.gov/homologene/) |
| IntAct | [ebi.ac.uk/intact](https://www.ebi.ac.uk/intact/) |
| InParanoid | [inparanoid.sbc.su.se](http://inparanoid.sbc.su.se/) |
| KEGG | [genome.jp/kegg](https://www.genome.jp/kegg/) |
| OrthoMCL | [orthomcl.org](https://orthomcl.org/) |
| PomBase | [pombase.org](http://www.pombase.org/) |
| UniProt | [uniprot.org](http://www.uniprot.org/) |

### Protein Information from Published Studies

| Species | Reference | PubMed ID |
|---|---|---|
| *A. thaliana* | Ashburner et al., 2000 (Gene Ontology) | [10802651](https://pubmed.ncbi.nlm.nih.gov/10802651/) |
| *D. melanogaster* | Moretto et al., 2013 | [24217298](https://pubmed.ncbi.nlm.nih.gov/24217298/) |
| *H. sapiens* | Graml et al., 2014 | [25373780](https://pubmed.ncbi.nlm.nih.gov/25373780/) |
| *S. cerevisiae* | Jorgensen et al., 2002 | [12089449](https://pubmed.ncbi.nlm.nih.gov/12089449/) |
| *S. cerevisiae* | Neumann et al., 2010 | [20360735](https://pubmed.ncbi.nlm.nih.gov/20360735/) |
| *S. pombe* | Hayles et al., 2013 | [23697806](https://pubmed.ncbi.nlm.nih.gov/23697806/) |

## External Code

This project uses the following third-party libraries:

| Library | Version | License |
|---|---|---|
| [ip2country](http://phpweby.com/software/ip2country) by Blagoj Janevski | 1.0.2 | GNU GPL v2 |
| [jQuery](https://jquery.com/) | 1.11.2 | MIT |
| [jQuery DataTables](https://datatables.net/) | 1.10.5 | MIT |

GeoIP data: [MaxMind GeoLite](https://dev.maxmind.com/geoip/geolite2-free-geolocation-data)

## Author

**Zoltan Dul, PhD**
- Email: [zoltan.dul@gmail.com](mailto:zoltan.dul@gmail.com)
- Twitter: [@ZoliQa](https://twitter.com/ZoliQa)
- GitHub: [ZoliQua](https://github.com/ZoliQua)

## License

This program is free software; you can redistribute it and/or modify it under the terms of the [GNU General Public License v2](LICENSE.md) as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the [GNU General Public License](LICENSE.md) for more details.

Please always copyleft your redistribution :)
