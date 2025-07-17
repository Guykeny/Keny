<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title>TP PHP 6.2 - Formulaire d'inscription étudiants</title>
</head>
<body style="background-color: #ffcc00;">
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<fieldset>
<legend><b>Inscrivez-vous ou affichez la liste des étudiants</b></legend>
<label>Nom :&nbsp;&nbsp;&nbsp;&nbsp;</label>
<input type="text" name="nom" value="Didact" size=30/><br/><br/>
<label>Prénom : </label>
<input type="text" name="prenom" value="Otto" size=30/><br/><br/>
<label>Groupe :&nbsp;</label>
<select name="groupe"  required="required">
<option value="I1" selected="selected">I1</option>
<option value="I2">I2</option>
<option value="I3">I3</option>
<option value="I4">I4</option>
<option value="I5">I5</option>
<option value="I6">I6</option>
</select><br/><br/>
<input type="submit" value="S'inscrire" name="envoi" />
<input type="submit" value="Lister" name="affiche" />
</fieldset>
</form>
<?php
$file= __DIR__."/etudiants.csv";

if(isset($_POST["envoi"])){
    if(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["groupe"])){
        $nom=trim($_POST["nom"]);
        $prenom=trim($_POST["prenom"]);
        $groupe=trim($_POST["groupe"]);
        $rec = "\n".$nom.";".$prenom.";".$groupe;

        if(file_exists($file)){
            if($id=fopen($file, "a")){
                flock($id,2);
                fwrite($id,$rec);
                flock($id,3);
                fclose($id);
                echo "<h3>",ucwords(strtolower($prenom)), " ",ucwords(strtolower($nom)) ,"vous etes inscrits dans le groupe".$groupe ."</h3>";
            }else{
                echo " le fichier est inaccessible à toi sale merdeux";
            }
        }else{
            $id=fopen($file, "w");
            fwrite($id,$rec);
           fclose($id);
        }
    }
}
if(isset($_POST["affiche"])){
    if($id=fopen($file, "r")){
        echo "<table border=\"2\"><tbody>";
        echo "<thead><tr><th>ID</th><th>NOM</th><th>PRENOM</th><th>GROUPE</th></tr></thead>";
        $i=0;
        while($tab= fgetcsv($id,200,";")){
            if($i != 0){
                $nom=$tab[0];
                $prenom=$tab[1];
                $groupe=$tab[2];
                $email = str_replace(" ","-",strtolower($tab[1])).".".str_replace(" ","-",strtolower($tab[0]))."@univ-angers.fr";
                echo "<tr><td>$i</td><td><a href=\"mailto: $email\" >$nom</a></td><td>$prenom</td><td>$groupe</td></tr>";
            }
            $i++;
        }
        
    } fclose($id);
    echo "</tbody></table>";
}
// A COMPLETER
?>
</body>
</html>
