<?php
// Dolibarr init
define('NOLOGIN', 1);
define('NOCSRFCHECK', 1);
define('NOREQUIREMENU', 1);
define('NOREQUIREHTML', 1);

require '../../../main.inc.php'; // depuis htdocs/custom/mailboxmodule/scripts/

header('Content-Type: application/json');

global $db;

$q = trim(GETPOST('q', 'alpha'));        // Texte saisi
$type = trim(GETPOST('type', 'alpha'));  // project, facture, commande, thirdparty

if (empty($q) || empty($type)) {
    echo json_encode([]); exit;
}

// Limiter à 20 résultats
$max_results = 20;

$result = [];

try {
    if ($type === 'project') {
        $sql = "SELECT rowid as id, title as label 
                FROM ".MAIN_DB_PREFIX."projet
                WHERE title LIKE '%".$db->escape($q)."%'
                ORDER BY datec DESC
                LIMIT $max_results";

    } elseif ($type === 'facture') {
        $sql = "SELECT rowid as id, CONCAT(ref, ' - ', IFNULL(label, '')) as label
                FROM ".MAIN_DB_PREFIX."facture
                WHERE ref LIKE '%".$db->escape($q)."%'
                   OR label LIKE '%".$db->escape($q)."%'
                ORDER BY datec DESC
                LIMIT $max_results";

    } elseif ($type === 'commande') {
        $sql = "SELECT rowid as id, CONCAT(ref, ' - ', IFNULL(note_private, '')) as label
                FROM ".MAIN_DB_PREFIX."commande
                WHERE ref LIKE '%".$db->escape($q)."%'
                   OR note_private LIKE '%".$db->escape($q)."%'
                ORDER BY date_creation DESC
                LIMIT $max_results";

    } elseif ($type === 'thirdparty') {
        $sql = "SELECT rowid as id, nom as label
                FROM ".MAIN_DB_PREFIX."societe
                WHERE nom LIKE '%".$db->escape($q)."%'
                   OR name_alias LIKE '%".$db->escape($q)."%'
                ORDER BY datec DESC
                LIMIT $max_results";

    } else {
        // Type inconnu → renvoyer liste vide
        echo json_encode([]); exit;
    }

    $resql = $db->query($sql);
    if ($resql) {
        while ($obj = $db->fetch_object($resql)) {
            $result[] = [
                'id'    => (int)$obj->id,
                'label' => $obj->label
            ];
        }
    }
} catch (Throwable $e) {
    dol_syslog('Erreur search_targets.php : '.$e->getMessage(), LOG_ERR);
    // Par sécurité, renvoyer une liste vide
    echo json_encode([]); exit;
}

// Renvoyer en JSON
echo json_encode($result);
exit;
?>
