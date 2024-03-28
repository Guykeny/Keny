<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<title>TP PHP 2.1 - Egalité et conversion</title>
<style>
        th {
            background-color: cyan;
        }

        th,
        td {
            border: 1px solid;
        }

        table {
            text-align: left;
            border: 2px solid;
            border-collapse: collapse;
        }
</style>
</head>
<body>
<?php
    $table=["TRUE"=> TRUE,"FALSE"=>FALSE,"1"=>1 , "-1"=>-1,"0"=>0,"\"1\""=>"1","\"0\""=>"0","\"-1\""=>"-1","NULL"=>NULL,"[]"=>[],"\"\""=>""];

function  b2s( bool $x): string {if($x) return "TRUE"; else return "";}


    echo "<table>";
    echo "<tr>";
    echo "<th>==</th>";
    foreach($table  as $k => $v){
        echo "<th>$k</th>";
    }
    echo "</tr>";
   
    foreach($table  as $k => $v){
        echo "<tr>";
     echo  "<th>$k</th>";
     foreach($table as $l){
        echo "<td>".b2s($v==$l)."</td>";
     }
     echo "</tr>";
    }
    echo "</table>";
// A COMPLETER
?>
</body>
</html>
