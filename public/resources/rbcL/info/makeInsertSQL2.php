<?php

$infile = fopen("../category/family.txt","r") or die("");
$outfile = fopen("family_count_insert.sql","w") or die("");
//Acanthaceae	522	29
//INSERT INTO category_rbcL(speciesName,allIncludedCount,curatedDbCount) VALUES('',num,num);

$sqlSyntax = "INSERT INTO family_count(familyName,allIncludedCount,curatedDbCount) VALUES";
while ($line = fgets($infile)) {
    $line = trim($line);
    preg_match_all("/^(.+)\t(\d+)\t(\d+)$/",$line,$m,PREG_PATTERN_ORDER);

    //if each category includes single quote('), one more('') should be added to avoide sql error.
    $needChecked = $m[1][0];
    $needChecked = str_replace("'","''",$m[1][0]);


    fwrite(
        $outfile,
        "{$sqlSyntax}('{$needChecked}',{$m[2][0]},{$m[3][0]})\n"
    );
    
}