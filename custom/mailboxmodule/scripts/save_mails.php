<?php
define('NOLOGIN', 1);
define('NOCSRFCHECK', 1);
define('NOREQUIREMENU', 1);
define('NOREQUIREHTML', 1);

require '../../../main.inc.php'; // depuis htdocs/custom/mailboxmodule/scripts/
require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';

header('Content-Type: application/json');
global $db, $conf;

try {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) throw new Exception("Pas de données reçues");

    // Récupérer toutes les données envoyées (ajoute link_type et link_id)
    $uid = $db->escape($input['uid']);
    $mbox = $db->escape($input['mbox']);
    $rc_user_email = $db->escape($input['rc_user_email']);
    $subject = $db->escape($input['subject']);
    $date = $db->escape($input['date']);
    $from_raw = $input['from'];
    $raw_email_content = $input['raw_email'] ?? null;
    $attachments = $input['attachments'] ?? [];
    $link_type = isset($input['link_type']) ? $db->escape($input['link_type']) : null;
    $link_id = isset($input['link_id']) ? (int)$input['link_id'] : 0;

    if (empty($from_raw)) throw new Exception("Champ 'from' vide ou absent");
    if (empty($raw_email_content)) throw new Exception("Contenu brut de l'e-mail manquant.");

    // Extraire l'email depuis from
    if (preg_match('/<([^>]+)>/', $from_raw, $matches)) {
        $from_email = $db->escape(trim($matches[1]));
    } else {
        $from_email = $db->escape(trim($from_raw));
    }
    if (!filter_var($from_email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Email d'expéditeur invalide");
    }

    // --- Sauvegarder le fichier EML ---
    $data_dir = DOL_DOCUMENT_ROOT . '/custom/mailboxmodule/data/mails/';
    if (!is_dir($data_dir)) {
        if (!mkdir($data_dir, 0775, true)) throw new Exception("Impossible de créer le répertoire des mails : " . $data_dir);
    }
    $filename_base = preg_replace('/[^\w\s\-\.]/', '', $subject);
    $filename_base = substr($filename_base, 0, 50);
    if (empty($filename_base)) $filename_base = 'email_' . md5($uid . microtime());
    $filename_eml = $filename_base . '_' . time() . '.eml';
    $full_file_path = $data_dir . $filename_eml;
    if (file_put_contents($full_file_path, $raw_email_content) === false) {
        throw new Exception("Impossible d'écrire le fichier EML : " . $full_file_path);
    }
    $relative_file_path = 'custom/mailboxmodule/data/mails/' . $filename_eml;

    // --- Chercher le tiers correspondant ---
    $sql = "SELECT rowid, nom FROM ".MAIN_DB_PREFIX."societe WHERE email = '".$from_email."'";
    $resql = $db->query($sql);
    if (!$resql) throw new Exception($db->lasterror());

    $fk_soc = null;
    $tiers_name = '';
    if ($db->num_rows($resql) > 0) {
        $obj = $db->fetch_object($resql);
        $fk_soc = $obj->rowid;
        $tiers_name = $obj->nom;
    } else {
        $tiers_name = "Aucun tiers trouvé";
    }

    // --- Insertion du mail dans mailboxmodule_mail ---
    $sql_insert = "INSERT INTO ".MAIN_DB_PREFIX."mailboxmodule_mail
        (message_id, subject, from_email, date_received, file_path, fk_soc)
        VALUES (
            '".$uid."',
            ".($subject !== '' ? "'".$subject."'" : "NULL").",
            '".$from_email."',
            ".($date !== '' ? "'".$date."'" : "NULL").",
            '".$db->escape($relative_file_path)."',
            ".($fk_soc !== null ? intval($fk_soc) : "NULL")."
        )";
    $resql_insert = $db->query($sql_insert);
    if (!$resql_insert) throw new Exception("Erreur insertion mail : ".$db->lasterror());

    $new_mail_id = $db->last_insert_id(MAIN_DB_PREFIX."mailboxmodule_mail", 'rowid');

    // --- Sauvegarde des pièces jointes ---
    $attachments_dir = DOL_DOCUMENT_ROOT . '/custom/mailboxmodule/data/fichier_join/';
    if (!is_dir($attachments_dir)) {
        if (!mkdir($attachments_dir, 0775, true)) throw new Exception("Impossible de créer le répertoire des pièces jointes : " . $attachments_dir);
    }

    $nb_attachments = 0;
    foreach ($attachments as $att) {
        $src = $att['path'] ?? '';
        $name = $att['name'] ?? 'unknown.bin';
        if ($src && file_exists($src)) {
            $safe_name = preg_replace('/[^A-Za-z0-9_\.\-]/', '_', $name);
            $dest_filename = $uid . '_' . $safe_name;
            $dest_path = $attachments_dir . $dest_filename;

            if (copy($src, $dest_path)) {
                $relative_path = 'custom/mailboxmodule/data/fichier_join/' . $dest_filename;

                // Enregistrer dans mailboxmodule_attachment
                $sql_att = "INSERT INTO ".MAIN_DB_PREFIX."mailboxmodule_attachment
                    (fk_mail, filename, filepath)
                    VALUES (
                        ".intval($new_mail_id).",
                        '".$db->escape($safe_name)."',
                        '".$db->escape($relative_path)."'
                    )";
                if ($db->query($sql_att)) {
                    $nb_attachments++;
                } else {
                    dol_syslog("Erreur insertion attachment: ".$db->lasterror());
                }

                // --- Copier et ajouter dans ecm_files SI fk_soc existe ---
                if ($fk_soc) {
                    $dest_dir_tiers = DOL_DATA_ROOT.'/societe/'.$fk_soc.'/';
                    if (!is_dir($dest_dir_tiers)) mkdir($dest_dir_tiers, 0777, true);

                    $dest_filename_tiers = time().'_'.$safe_name;
                    $dest_path_tiers = $dest_dir_tiers . $dest_filename_tiers;

                    if (copy($src, $dest_path_tiers)) {
                        $sql_ecm = "INSERT INTO ".MAIN_DB_PREFIX."ecm_files 
                            (ref, label, share, share_pass, entity, filepath, filename, src_object_type, src_object_id, date_c, tms)
                            VALUES (
                                '".$db->escape($dest_filename_tiers)."',
                                '".$db->escape($dest_filename_tiers)."',
                                NULL,
                                NULL,
                                ".(int) $conf->entity.",
                                '".$db->escape('societe/'.$fk_soc)."',
                                '".$db->escape($dest_filename_tiers)."',
                                'company',
                                ".(int) $fk_soc.",
                                '".$db->idate(dol_now())."',
                                '".$db->idate(dol_now())."'
                            )";
                        if (!$db->query($sql_ecm)) dol_syslog("Erreur insertion ecm_files: ".$db->lasterror());
                    }
                }
            }
        }
    }

    // --- Lier le mail au projet/facture/commande via element_element ---
    if ($link_type && $link_id > 0) {
        $allowed_target_types = ['project', 'facture', 'commande'];

        if (!in_array($link_type, $allowed_target_types)) {
            throw new Exception("Type de lien '$link_type' non autorisé.");
        }

        $source_type = 'mailboxmodule_mail';
        $source_id = (int) $new_mail_id;
        $targettype = $link_type;
        $fk_target = (int) $link_id;

        $sql_link = "INSERT INTO ".MAIN_DB_PREFIX."element_element
            (fk_source, sourcetype, fk_target, targettype, relationtype)
            VALUES (
                $source_id,
                '".$db->escape($source_type)."',
                $fk_target,
                '".$db->escape($targettype)."',
                'manual'
            )";
        if (!$db->query($sql_link)) {
            dol_syslog("Erreur insertion element_element: ".$db->lasterror());
        }

        // --- Copier et ajouter dans ecm_files pour l'objet lié (projet/facture/commande) ---
        $dest_dir_target = DOL_DATA_ROOT.'/'.$targettype.'/'.$fk_target.'/';
        if (!is_dir($dest_dir_target)) mkdir($dest_dir_target, 0777, true);

        // 1️⃣ Copier le .eml
        $dest_filename_eml = time().'_'.$filename_eml;
        $dest_path_eml = $dest_dir_target . $dest_filename_eml;

        if (copy($full_file_path, $dest_path_eml)) {
            $sql_ecm_eml = "INSERT INTO ".MAIN_DB_PREFIX."ecm_files 
                (ref, label, entity, filepath, filename, src_object_type, src_object_id, date_c, tms)
                VALUES (
                    '".$db->escape($dest_filename_eml)."',
                    '".$db->escape($subject)."',
                    ".(int) $conf->entity.",
                    '".$db->escape($targettype.'/'.$fk_target)."',
                    '".$db->escape($dest_filename_eml)."',
                    '".$db->escape($targettype)."',
                    ".$fk_target.",
                    '".$db->idate(dol_now())."',
                    '".$db->idate(dol_now())."'
                )";
            if (!$db->query($sql_ecm_eml)) dol_syslog("Erreur insertion ecm_files pour .eml : ".$db->lasterror());
        }

        // 2️⃣ Copier les pièces jointes
        foreach ($attachments as $att) {
            $src = $att['path'] ?? '';
            $name = $att['name'] ?? 'unknown.bin';
            if ($src && file_exists($src)) {
                $safe_name = preg_replace('/[^A-Za-z0-9_\.\-]/', '_', $name);
                $dest_filename_att = time().'_'.$safe_name;
                $dest_path_att = $dest_dir_target . $dest_filename_att;

                if (copy($src, $dest_path_att)) {
                    $sql_ecm_att = "INSERT INTO ".MAIN_DB_PREFIX."ecm_files 
                        (ref, label, entity, filepath, filename, src_object_type, src_object_id, date_c, tms)
                        VALUES (
                            '".$db->escape($dest_filename_att)."',
                            '".$db->escape($safe_name)."',
                            ".(int) $conf->entity.",
                            '".$db->escape($targettype.'/'.$fk_target)."',
                            '".$db->escape($dest_filename_att)."',
                            '".$db->escape($targettype)."',
                            ".$fk_target.",
                            '".$db->idate(dol_now())."',
                            '".$db->idate(dol_now())."'
                        )";
                    if (!$db->query($sql_ecm_att)) dol_syslog("Erreur insertion ecm_files pour attachment : ".$db->lasterror());
                }
            }
        }
    }

    $msg = "Mail UID=$uid enregistré";
    if ($fk_soc) {
        $msg .= " et lié au tiers : $tiers_name (ID=$fk_soc)";
    } else {
        $msg .= " mais sans tiers trouvé";
    }
    $msg .= ". Fichier EML sauvegardé. ";
    if ($nb_attachments > 0) {
        $msg .= "$nb_attachments pièce(s) jointe(s) ajoutée(s).";
    }
    if ($link_type && $link_id > 0) {
        $msg .= " Mail lié à $link_type ID=$link_id.";
    }

    echo json_encode(['status' => 'OK', 'message' => $msg]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'ERROR', 'message' => $e->getMessage()]);
}

exit();
