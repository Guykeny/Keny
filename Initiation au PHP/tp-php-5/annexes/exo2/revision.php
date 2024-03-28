<?php
function importerCSV(string $fileName, array &$villes)
{
	if($id=fopen($fileName, 'r')){
        while($city=fgetcsv($id,200,";")){
            $ville=[];
            $ville["nom"]=(string) $city[0];
            $ville["region"]=(string) $city[1];
            $ville["population"]=(int) $city[2];
            if($city[3]==="1"){
                $ville["prefecture"]=true;
            }
            $villes[]=$ville;
        }
    } fclose($id);
}


$villes = [];
importerCSV("villes.csv", $villes);

// A MODIFIER
$str = <<<HEREDOC
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>TP PHP 5.2 - Villes</title>
<style>
	table { border-collapse: collapse; }
	table, th, tr, td { border: 1px solid black;}
</style>
</head>
<body>
HEREDOC;

// A COMPLETER
$str= "<table border=1>";
$str .="<tr>"."<th>"."Nom"."</th>"."<th>"."Region"."</th>"."<th>"."Population"."</th>"."<th>"."Prefecture"."</th>"."</tr>";
foreach($villes as $val){
    $str .= "<tr>"."<td>".$val['nom']."</td>"."<td>".$val["region"]."</td>"."<td>".$val["population"]."</td>"."<td>";
    if(array_key_exists("prefecture",$val)){
        $str .= "oui";
    }else{
        $str .= "non";
    }
    $str .= "</td></tr>";
    
}
$str .="</table>";
$str .= "</body></html>";

echo $str;
?>