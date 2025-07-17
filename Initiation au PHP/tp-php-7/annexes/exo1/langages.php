<?php
$voyelles = [
    'o',
    'e',
    'i',
    'u',
    'a'
];

$anglais = [
    'o' => 248,
    'e' => 355,
    'i' => 222,
    'u' => 107,
    'a' => 198
];

$francais = [
    'o' => 178,
    'e' => 435,
    'i' => 240,
    'u' => 212,
    'a' => 201
];

$gallois = [
    'o' => 152,
    'e' => 264,
    'i' => 221,
    'u' => 107,
    'a' => 266
];

$samoan = [
    'o' => 248,
    'e' => 308,
    'i' => 334,
    'u' => 208,
    'a' => 656
];

$zoulou = [
    'o' => 203,
    'e' => 298,
    'i' => 311,
    'u' => 274,
    'a' => 411
];

$langages = [
    'anglais' => $anglais,
    'français' => $francais,
    'gallois' => $gallois,
    'samoan' => $samoan,
    'zoulou' => $zoulou
];
 //explode Scinde une chaîne de caractères en segments
//implode — Rassemble les éléments d'un tableau en une chaîne
function creerFichier($f, $v, $l)
{
    $fp= fopen($f, 'w');
    fwrite($fp,"LANGUES, " .implode(',', $v). "\n");
    foreach($l as $langue=> $langues){
        fwrite($fp,$langue .",");
        fwrite($fp,implode(",", $langues). "\n");
    }
    fclose($fp);
    // A COMPLETER
}
foreach($langages as $langue=> $langues){
    echo $langues;
}
// TEST
$nomfichier = 'langages.csv';
echo "Fichier $nomfichier :\n";
creerFichier($nomfichier, $voyelles, $langages);
print_r(file_get_contents($nomfichier));
?>