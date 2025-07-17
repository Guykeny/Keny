<?php
// Clef secrète commune
$clef = 'azerty123';

// Mot de passe d'application à chiffrer
$motdepasse = 'yrtfzngztljfmiov';

// Chiffrement
$motdepasse_crypte = openssl_encrypt($motdepasse, 'AES-128-ECB', $clef);

// Affichage
echo "Mot de passe chiffré :<br><textarea cols=100 rows=3>$motdepasse_crypte</textarea>";
