<?php
require '../../main.inc.php';
require_once './secret.key.php';

if (empty($user->id)) accessforbidden();

$clef = IMAP_SECRET_KEY;

$sql = "SELECT email, password_crypt FROM llx_user_imap WHERE fk_user = ".((int)$user->id);
$resql = $db->query($sql);

if (!$resql || !($obj = $db->fetch_object($resql))) {
    print 'Identifiants IMAP non trouvés.';
    exit;
}

$email_user = $obj->email;
$motdepasse_user = openssl_decrypt($obj->password_crypt, 'AES-128-ECB', $clef);

if (empty($email_user) || empty($motdepasse_user)) {
    print 'Erreur : Email ou mot de passe manquant.';
    exit;
}

$_SESSION['autologin_user'] = $email_user;
$_SESSION['autologin_pass'] = $motdepasse_user;

// 🚨 Force l’écriture de la session AVANT redirection
session_write_close();
header("Location: http://localhost/roundcube/");
exit;
