<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="src/style.css">
    <title>Modifier et ajouter des villes</title>
</head>

<body>
    <?php
    require("src/connexpdo.inc.php");
    // Modifier en base les villes dont les populations ne sont pas vides
   
   
    // Ajouter la ville de la dernière ligne si tous les champs sont renseignés.
    
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
                <tr>
                    <td>Paris</td>
                    <td>Ile-de-France</td>
                    <td><input type="number" name="population[9]" value=""></td>
                </tr>
                <tr>
                    <td>Marseille</td>
                    <td>Provence-Alpes-Côte d'Azur</td>
                    <td><input type="number" name="population[3]" value="850602"></td>
                </tr>
                <tr>
                    <td>Nantes</td>
                    <td>Pays de la Loire</td>
                    <td><input type="number" name="population[1]" value="282047"></td>
                </tr>
                <tr>
                    <td>Rennes</td>
                    <td>Bretagne</td>
                    <td><input type="number" name="population[26]" value="222485"></td>
                </tr>
                <tr>
                    <td>Toulon</td>
                    <td>Provence-Alpes-Côte d'Azur</td>
                    <td><input type="number" name="population[4]" value="165514"></td>
                </tr>
                <tr>
                    <td>Angers</td>
                    <td>Pays de la Loire</td>
                    <td><input type="number" name="population[6]" value="155876"></td>
                </tr>
                <tr>
                    <td>Rouen</td>
                    <td>Normandie</td>
                    <td><input type="number" name="population[16]" value="114187"></td>
                </tr>
                <tr>
                    <td>Caen</td>
                    <td>Normandie</td>
                    <td><input type="number" name="population[14]" value="107250"></td>
                </tr>
                <tr>
                    <td>Nanterre</td>
                    <td>Ile-de-France</td>
                    <td><input type="number" name="population[10]" value="95782"></td>
                </tr>
                <tr>
                    <td>Avignon</td>
                    <td>Provence-Alpes-Côte d'Azur</td>
                    <td><input type="number" name="population[2]" value="89592"></td>
                </tr>
                <tr>
                    <td>Quimper</td>
                    <td>Bretagne</td>
                    <td><input type="number" name="population[24]" value="63473"></td>
                </tr>
                <tr>
                    <td>Vannes</td>
                    <td>Bretagne</td>
                    <td><input type="number" name="population[28]" value="54017"></td>
                </tr>
                <tr>
                    <td>Saint-Brieuc</td>
                    <td>Bretagne</td>
                    <td><input type="number" name="population[22]" value="44166"></td>
                </tr>
            </tbody>
            <tr>
                <td><input type="text" name="new_ville"></td>
                <td><select name="new_region">
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
                <td><input type="number" name="new_population" /></td>
            </tr>
        </table>
        <div class="btn-block">
            <button type="submit">Modifier Villes</button>
        </div>
    </form>
</body>

</html>
