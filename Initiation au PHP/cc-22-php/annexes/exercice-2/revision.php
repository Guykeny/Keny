<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique apt</title>
    <style>
        .code{ color: blue; font-family: 'Courier New', Courier, monospace;}
        body{display: block;}
        h1{color: blueviolet; text-align: center;}
        div{ border: 2px solid blueviolet; margin: 8px auto; border-radius: 10px; background-color: rgba(138, 43, 223, 0.1); padding: 8px;}
        div>h2 {color: blueviolet; text-align: center;}
        table{ margin-right: 10px; margin-left: 8px;}
        th{ white-space: nowrap; vertical-align: text-top; text-align: right;}
    </style>
</head>
<body>
    <h1>Historique <span class="code">apt</span></h1>
    <?php
    $filename="history.log";
    $file=file_get_contents($filename);
    $logEntries=explode("\n\n",$f);
    
    $log=[];
    foreach($logEntries as $val){
        if(!empty($val)){
        $ligne=explode("\n",$var);
        $tab=[];
        foreach($ligne as $v){
            list($key,$value)=array_map('trim',explode(":",$v,2));
            $tab[$key]=$value;
            }
            $log[]=$tab;
        }
    }
   var_dump($logs);

   
    ?>
</body>
</html>
