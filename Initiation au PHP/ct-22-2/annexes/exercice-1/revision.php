<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="src/style.css">
    <title>Génération d'un tableau de ville à modifier</title>
</head>

<body>
    <?php
    require("src/data.php");
    // Filtrer $villes pour ne garder que les préfectures
    $villes=array_filter($villes, function($a)
{
    return isset($a["prefecture"]) && $a["prefecture"]== "1";
});

    // Trier $villes dans l'ordre décroissant de population
   usort($villes, function($a,$b){
    return $b["population"] <=>$a["population"];
   });

    // Exporter $villes au format csv
    function importercv(string $file , array &$villes){
    if($id=fopen($file,'r')){
        while( $city=fgetcsv($id, 200,",")){
            $ville=[];
            $ville["nom_ville"]= (string) $city[0];
            $ville["nom_region"]=(string) $city[1];
            $ville["population"]=(int) $city[2];
            $villes[]=$villes;
        }   
    }fclose($id);
    
}
    importercv("src/villes.csv",$villes);
    ?>
    <h1>Modifier des villes</h1>
    <form action="" method="post">
        <table>
            <thead>
                <tr>
                    <th>Ville</th>
                    <th>Région</th>
                    <th>Population</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Remplir le corps du tableau
                foreach($villes as $id_ville => $ville){
                    echo "<tr>";
                    echo "<td>". $ville["nom_ville"] . "</td>";
                    echo "<td>". $ville["nom_region"] . "</td>";
                    echo "<td><input type='number' name='population[{$ville[$id_ville]}]' value='{$ville['population']}'/></td>";
                    echo "</tr>";
                }

                
                
                
                ?>
            </tbody>
            <tr>
                <td><input type="text" name="nom_ville"></td>
                <td><select name="nom_region">
                        <option value=""></option>
                        <option value="Auvergne-Rhône-Alpes">Auvergne-Rhône-Alpes</option>
                        <option value="Bourgogne-Franche-Comté">Bourgogne-Franche-Comté</option>
                        <option value="Bretagne">Bretagne</option>
                        <option value="Centre-Val de Loire">Centre-Val de Loire</option>
                        <option value="Corse">Corse</option>
                        <option value="Grand Est">Grand Est</option>
                        <option value="Hauts-de-France">Hauts-de-France</option>
                        <option value="Ile-de-France">Ile-de-France</option>
                        <option value="Normandie">Normandie</option>
                        <option value="Nouvelle Aquitaine">Nouvelle Aquitaine</option>
                        <option value="Occitanie">Occitanie</option>
                        <option value="Pays de la Loire">Pays de la Loire</option>
                        <option value="Provence-Alpes-Côte d'Azur">Provence-Alpes-Côte d'Azur</option>
                    </select></td>
                <td><input type="number" name="population"/></td>
            </tr>
        </table>
        <div class="btn-block">
            <button type="submit">Modifier Villes</button>
        </div>
    </form>
</body>

</html>
