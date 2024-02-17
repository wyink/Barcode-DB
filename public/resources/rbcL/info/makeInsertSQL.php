<?php

$infile = fopen("All.txt","r") or die("");
$outfile = fopen("category_rbcL_insert.sql","w") or die("");
//QBB10235.1	435677	sp|Schoenoplectus confusus ge|Schoenoplectus fm|Cyperaceae ph|Streptophyta
//INSERT INTO category_rbcL(geneID,taxID,species,genus,family,phylum) VALUES('CAR62526.1',554962,'Campylanthus spinosus','Campylanthus','Plantaginaceae','Streptophyta');

$sqlSyntax = "INSERT INTO category_rbcL(geneID,taxID,species,genus,family,phylum) VALUES";
while ($line = fgets($infile)) {
    $line = trim($line);
    preg_match_all("/^(.+)\t(\d+)\tsp\|(.+) ge\|(.+) fm\|(.+) ph\|(.+)$/",$line,$m,PREG_PATTERN_ORDER);

    //if each category includes single quote('), one more('') should be added to avoide sql error.
    $needChecked = [$m[3][0],$m[4][0],$m[5][0],$m[6][0]];

    for( $i = 0; $i < count($needChecked); $i++ ) {
        //remove prefix ; ex.sp,ge,fm,ph
        $needChecked[$i] = str_replace("'","''",$needChecked[$i]);
    }
    
    fwrite(
        $outfile,
        "{$sqlSyntax}('{$m[1][0]}','{$m[2][0]}','{$needChecked[0]}','{$needChecked[1]}','{$needChecked[2]}','{$needChecked[3]}')\n"
    );
    
}