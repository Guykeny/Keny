<?php
if(isset($_POST["nom"]) && isset($_POST['prenom']) && isset($_POST['ville'])){
	echo "Nom : ".$_POST["nom"]."<br>";
	echo "Prénom : ".$_POST["prenom"]."<br>";
	echo "Ville : ".$_POST["ville"]."<br>";
}
?>