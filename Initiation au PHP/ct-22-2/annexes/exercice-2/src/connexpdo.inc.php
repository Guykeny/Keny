<?php

function connexpdo(string $db)
{
    $sgbd = "mysql"; // choix de MySQL
    $host = "localhost";
    $charset = "UTF8";
    $user = "root"; // user id
    $pass = ""; // A MODIFIER EN FONCTION
    $pdo = new PDO("$sgbd:host=$host;dbname=$db;charset=$charset", $user, $pass);
    // force le lancement d'exception en cas d'erreurs d'exécution de requêtes SQL
    // via eg. $pdo->query()
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
