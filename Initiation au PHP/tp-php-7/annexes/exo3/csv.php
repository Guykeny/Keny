<?php
// TODO Lire le fichier countries.csv
if($id=fopen("countries.csv", 'r')){
    while($city=fgetcsv($id,200,";")){
        ville=[];
        ville["formegov"]= (string) $city[2];
    }
    fclose($id);
}
// TODO Générer le fichier governments.csv
?>
