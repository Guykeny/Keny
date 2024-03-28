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
    // Partie 1 : fichier -> $logs (array)
    $filename="history.log";
    $f=file_get_contents($filename);
    $logEntries= explode("\n\n", $f);

    $logs=[];
    foreach ($logEntries as $value) {
        if(!empty($value )){
            $lines= explode("\n", $value);
            $log=[];

            foreach($lines as $line){
                list($key,$value)=array_map('trim',explode(":",$line,2));
                $log[$key]=$value;
            }
            $logs[]=$log;
        }
    }
    var_dump($logs);

    // Partie 2 : affichage HTML de $logs (array)
    // Si la partie 1 n'est pas réussie décommenter la ligne suivante (require) afin d'utiliser un tableau $logs fonctionnel
    // require("logs.php");
   
// ... (votre code précédent)

    echo '<div>';
    echo '<h2>Contenu du fichier history.log</h2>';
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Start-Date</th>';
    echo '<th>End-Date</th>';
    echo '<th>Commandline</th>';
    echo '<th>Requested-By</th>';
    echo '<th>Upgrade</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($logs as $log) {
        echo '<tr>';
        echo '<td>' . (isset($log['Start-Date']) ? $log['Start-Date'] : '') . '</td>';
        echo '<td>' . (isset($log['End-Date']) ? $log['End-Date'] : '') . '</td>';
        echo '<td>' . (isset($log['Commandline']) ? $log['Commandline'] : '') . '</td>';
        echo '<td>' . (isset($log['Requested-By']) ? $log['Requested-By'] : '') . '</td>';
        echo '<td>' . (isset($log['Upgrade']) ? $log['Upgrade'] : '') . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';


   
    ?>
</body>
</html>
