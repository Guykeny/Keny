<!DOCTYPE html>
<html>
<head>
<title>TP PHP 5.1 - Génération de formulaire</title>
</head>
<body>
<?php
include('form-generation.inc.php');
// A COMPLETER
$code= form("completez le formulaire","form-generation.php","post");
$code .= text("Votre nom", "nom");
$code .= text("votre prénom","prenom");
$code .= radio("Paris" ,"ville", "Paris");
$code .= radio("Lyon" ,"ville"," ");
$code .= submit("Envoyez", "Effacer");
$code .= inform();
echo $code;
?>
 </body>
</html>
