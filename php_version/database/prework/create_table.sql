CREATE TABLE category_rbcL
(
    geneID  nchar(10)       NOT NULL,
    taxID   int             NOT NULL,
    species    nchar(100)   NOT NULL,
    genus      nchar(30)    NOT NULL,
    family     nchar(30)    NOT NULL,
    phylum     nchar(30)    NOT NULL,
    isCurated  bit          NOT NULL,
 PRIMARY KEY (geneID));

CREATE TABLE category_matK
(
    geneID  nchar(10)       NOT NULL,
    taxID   int             NOT NULL,
    species    nchar(100)   NOT NULL,
    genus      nchar(30)    NOT NULL,
    family     nchar(30)    NOT NULL,
    phylum     nchar(30)    NOT NULL,
    isCurated  bit          NOT NULL,
 PRIMARY KEY (geneID));

CREATE TABLE family_count
(
    familyName          nchar(100)  NOT NULL,
    allIncludedCount    int         NOT NULL,
    curatedDbCount      int         NOT NULL,
 PRIMARY KEY (familyName));

CREATE TABLE genus_count
(
    genusName           nchar(100)  NOT NULL,
    allIncludedCount    int         NOT NULL,
    curatedDbCount      int         NOT NULL,
 PRIMARY KEY (genusName));

 
CREATE TABLE species_count
(
    speciesName         nchar(100)  NOT NULL,
    allIncludedCount    int         NOT NULL,
    curatedDbCount      int         NOT NULL,
 PRIMARY KEY (speciesName));
