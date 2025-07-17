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
  $table=["TRUE"=>TRUE,"FALSE"=>FALSE,"1"=>1,"0"=>0,"-1"=>-1,"NULL"=>NULL,"[]"=>[],"\"\""=>"","\"1\""=>"1","\"0\""=>"0","\"-1\""=>"-1"];

        function b2s($x):string 
        {
            if($x) return "TRUE";
            else return "";
        }
    echo "<table border=\"0\">";
    echo "<tr>";
    echo "<th>==</th>";
    foreach($table as $key => $val){
        echo "<th> $key </th>";
    }
    echo "</tr>";
    foreach($table as $key => $val){
        echo "<tr>";
        echo "<th>$key</th>";
        foreach($table as $var){
            echo "<td>".b2S($val==$var). "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
?>
</body>
</html>
