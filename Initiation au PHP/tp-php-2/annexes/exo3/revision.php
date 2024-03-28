<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<title>TP PHP 2.3 - Statistiques</title>
<style type="text/css">
    div {position:fixed; top:10px; left:50%; border:1px black solid;}
    .hautsalaire {background-color:orange;}
    .bassalaire {background-color:lightblue;}
</style>
<body>
<?php
require("tabEmployees.php");

$ageMoyen = 0;// Age moyen des employés
$salaireMoyen = 0; // Salaire moyen des plus de 55 ans

$tenRichest = array(); // Tableau contenant les 10 employés ayant le plus haut salaire

// A COMPLETER
// Q1 : age moyen de tous les employés
foreach($employees as $val){
    
    $ageMoyen=$ageMoyen+$val['age'];
}
$ageMoyen=$ageMoyen/count($employees);

// Q2 : salaire moyen des employés de plus de 55 ans
$employ=array_filter($employees, function($x){
    return $x['age']>55;
});
foreach($employ as $v){
    $salaireMoyen=$salaireMoyen + $v['salary'];
}
$salaireMoyen=$salaireMoyen/count($employ);
//array_filter permet de filter un tableau en utilisant une fonction et ce qui va reste dans le tableau c'est le resultat de ta fonction donc les elements qui satisfont la fonction que tu as defini
// Q3 : Les 10 plus haut salaire
// Exemple : $tenRichest = ["Oren Dudley (9985 €)", "Jerome Flynn (9881 €)", ...]
//usort utiliser un tableau et une fonction de comparaison pour trie ;
usort($employees, function($a,$b){
    return $b['salary'] <=> $a['salary'];

});
$i=0;
while($employees[$i]['salary'] >= $employees[9]['salary']){
    $tenRichest[]=$employees[$i]['name']. "(".$employees[$i]['salary']. "€)";
    $i++;
}
// Affichage des 3 variables remplies dans les réponses aux questions 1 à 3
echo "<p>Age moyen des employés : ".round($ageMoyen,2)." ans</p>";
echo "<p>Salaire moyen des employés de plus de 55 ans : ".round($salaireMoyen,2)." €</p>";
echo "<p>Top 10 des plus haut salaire : <ol>";
foreach($tenRichest as $e) echo "<li>$e</li>";
echo "</ol></p>";
?>
</body>
</html>