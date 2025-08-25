<?php
/**
 * Script d'autologin amélioré pour Roundcube depuis Dolibarr
 * Ce script est la page d'entrée dans Dolibarr
 */

// Charger l'environnement Dolibarr
$res = 0;
$paths = [
    '../../main.inc.php', 
    '../../../main.inc.php', 
    '../../../../main.inc.php'
];
foreach ($paths as $path) {
    if (file_exists($path)) {
        require $path;
        $res = 1;
        break;
    }
}

if (!$res) {
    die('Erreur: Impossible de charger main.inc.php');
}

// Vérifier la connexion utilisateur et les droits
if (empty($user->id)) {
    accessforbidden();
}

if (!$user->hasRight('roundcubemodule', 'webmail', 'read')) {
    accessforbidden('Vous n\'avez pas les droits pour accéder au webmail');
}

// Récupération de l'URL de Roundcube depuis la configuration de Dolibarr
$roundcube_url = '';
if (!empty($conf->global->ROUNDCUBE_URL)) {
    $roundcube_url = $conf->global->ROUNDCUBE_URL;
    if (strpos($roundcube_url, 'http') !== 0) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $roundcube_url = $protocol . $_SERVER['HTTP_HOST'] . $roundcube_url;
    }
} else {
    // URL par défaut si non configurée
    $roundcube_url = DOL_URL_ROOT . '/custom/roundcubemodule/roundcube/';
}

// Assurer que l'URL se termine par un slash
if (substr($roundcube_url, -1) !== '/') {
    $roundcube_url .= '/';
}

$account_id = isset($_GET['account_id']) ? (int)$_GET['account_id'] : 0;
$debug = !empty($conf->global->ROUNDCUBE_DEBUG);

// Définir le "secret" partagé. Il doit être le même que dans le plugin Roundcube.
$shared_secret = 'MyAx37okNmcBQWxsVIGDW29WDXiiuRkqZVZJQ364oyGFjCDzTvSznzQflQvsYpdW';

// Construction de l'URL de redirection avec les paramètres attendus par le plugin
$separator = (strpos($roundcube_url, '?') === false) ? '?' : '&';

$redirect_url = $roundcube_url . $separator .
               '_autologin=1' .
               '&secret=' . urlencode($shared_secret) .
               '&dolibarr_id=' . urlencode($user->id);

// Ajouter account_id seulement s'il est spécifié et valide (supérieur à 0)
if (!empty($account_id) && $account_id > 0) {
    $redirect_url .= '&account_id=' . urlencode($account_id);
    error_log("Redirection avec account_id: " . $account_id);
} else {
    error_log("Redirection sans account_id (utilisation du compte par défaut)");
}

// Mode debug : afficher les informations au lieu de rediriger
if ($debug) {
    echo "<h1>Debug Autologin</h1>";
    echo "<p>Account ID: " . ($account_id ?: 'Non spécifié') . "</p>";
    echo "<p>Redirection vers : <a href=\"$redirect_url\">$redirect_url</a></p>";
    echo "</body></html>";
    exit;
}

// Redirection automatique
header('Location: ' . $redirect_url);
exit;
?>