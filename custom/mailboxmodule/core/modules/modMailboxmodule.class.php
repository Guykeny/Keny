<?php
// Licence: GNU GPL v3 ou plus tard

/**
 * \file       core/modules/modMailboxmodule.class.php
 * \ingroup    mailboxmodule
 * \brief      Fichier principal de définition du module Mailboxmodule.
 * Ce fichier est lu par Dolibarr pour détecter et activer le module,
 * et pour configurer ses interactions (menus, onglets, hooks, permissions).
 * (Ce fichier est ici car c'est votre configuration actuelle,
 * bien que la convention Dolibarr préfère htdocs/custom/yourmodule/module_yourmodule.php)
 */

// Inclure la classe de base des modules Dolibarr
// Pour les modules situés dans core/modules, DOL_DOCUMENT_ROOT devrait être déjà défini.
// Si ce n'est pas le cas, Dolibarr lui-même a un problème d'initialisation.
// Nous ne définissons plus DOL_DOCUMENT_ROOT ici car Dolibarr le fait.
include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';

// La classe du module DOIT être nommée 'mod' suivi du nom du module (ex: modMailboxmodule)
class modMailboxmodule extends DolibarrModules
{
    public $rights;         // Array of rights (sera rempli via perms.php)
    public $db;             // Main Dolibarr db handler

    /**
     * Constructeur du module.
     * C'est ici que sont définies les propriétés statiques du module.
     *
     * @param      DoliDB      $db      Database handler
     */
    public function __construct($db)
    {
        global $langs;

        $this->db = $db;

        $this->numero = 104000; // Numéro unique pour votre module (assurez-vous qu'il ne rentre pas en conflit avec d'autres modules)
        $this->rights_class = 'mailboxmodule'; // Nom technique de la classe de droits (correspond au nom du module)
        $this->family = "interface"; // Catégorie du module (ex: interface, tools, setup...)
        $this->name = "mailboxmodule"; // Nom technique du module (le nom du dossier du module, convention)
        // Correction de $this->name pour correspondre au nom du dossier
        // $this->name = preg_replace('/^mod/', '', get_class($this)); // Cette ligne est moins robuste si le nom de la classe change.

        $this->description = "Module pour la gestion des e-mails liés aux objets Dolibarr"; // Description du module (en dur)
        $this->version = '1.0';
        $this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
        $this->picto='email'; // Nom de l'icône à utiliser pour le module (ex: email.png dans htdocs/theme/ton_theme/img/pictos/)

        // Déclaration des onglets personnalisés pour les fiches d'objets (Tiers ici)
        $this->tab_name = array('soc'); // Tableau des types d'objets où ajouter un onglet ('soc' pour Sociétés/Tiers)
        $this->special_tab_lib = array(
            // Associe 'soc' (Tiers) au fichier PHP qui gère l'onglet pour les tiers
            'soc' => 'custom/mailboxmodule/card_mails.php?id='
            // Le "?id=" est important pour que le fichier d'onglet reçoive l'ID du tiers.
        );

        // Indique que le module utilise des hooks (pour l'ajout d'onglets via addHooks())
        $this->module_parts = array('triggers' => 0, 'hooks' => 1);

        // Définition des menus que le module ajoute à Dolibarr
        $this->menu = array();
        $this->menu[] = array(
            'fk_menu'=>'',              // Menu parent (vide pour un menu de niveau supérieur)
            'type'=>'top',              // Type de menu ('top', 'left')
            'titre'=>'Mails Roundcube', // Titre affiché du menu (en dur ici)
            'mainmenu'=>'mailboxmodule',// Nom du menu principal (doit correspondre à $this->name pour être lié au module)
            'leftmenu'=>'',             // Sous-menu de gauche (laissé vide si c'est un menu top direct)
            'url'=>'/mailboxmodule/index.php', // URL de la page cible du menu
            'langs'=>'',                // Clé de langue pour le titre du menu (laissé vide car titre en dur)
            'position'=>100,            // Position du menu dans la liste
            'enabled'=>'1',             // '1' pour activé par défaut
            'perms'=>'1'                // Perms requis pour voir le menu ('1' pour toujours visible si module activé, ou une permission spécifique)
        );

        // IMPORTANT : La déclaration des droits doit se faire UNIQUEMENT via perms.php
        // $this->rights = array();
        // $this->rights[] = array( ... ); // Ceci a été supprimé car obsolète ici.
    }

    /**
     * Méthode d'initialisation du module (appelée lors de l'activation).
     * C'est ici que les tables de la base de données sont créées.
     *
     * @param      string      $options    Options
     * @return     int                     1 si OK, -1 si KO
     */
    public function init($options = '')
    {
        global $langs;

        $sql = array();
        // Requête SQL pour créer la table si elle n'existe pas
        $sql[0] = "
            CREATE TABLE IF NOT EXISTS ".MAIN_DB_PREFIX."mailboxmodule_mail (
                rowid INT(11) AUTO_INCREMENT PRIMARY KEY,
                message_id VARCHAR(255) NOT NULL UNIQUE,
                subject VARCHAR(255),
                from_email VARCHAR(255),
                date_received DATETIME,
                file_path VARCHAR(255),
                fk_soc INT(11) NULL,
                INDEX idx_mailboxmodule_mail_message_id (message_id),
                INDEX idx_mailboxmodule_mail_fk_soc (fk_soc)
            ) ENGINE=INNODB;
        ";

        return $this->_init($sql, $options);
    }

    /**
     * Méthode de suppression du module (appelée lors de la désactivation).
     * C'est ici que les données créées par le module peuvent être supprimées.
     *
     * @param      string      $options    Options
     * @return     int                     1 si OK, 0 si KO
     */
    public function remove($options = '')
    {
        $sql = array();
        // Requête SQL pour supprimer la table à la désactivation
       // $sql[0] = "DROP TABLE IF EXISTS ".MAIN_DB_PREFIX."mailboxmodule_mail;";
        return $this->_remove($sql, $options);
    }

    /**
     * Méthode appelée par les hooks de Dolibarr.
     * C'est ici que l'on intercepte les événements Dolibarr pour ajouter des fonctionnalités.
     *
     * @param      string      $action     Nom de l'action ou du point de hook (dépend du contexte)
     * @param      object      $object     Objet Dolibarr courant (ex: Societe, Commande, Invoice, etc.)
     * @param      string      $hookname   Nom du hook qui a été appelé
     * @return     int                     0=nothing, 1=ok, -1=ko
     */
    public function addHooks($action, $object, $hookname)
    {
        global $langs, $user, $conf, $db;

        // Ce hook est spécifiquement conçu pour ajouter des onglets aux fiches d'objets.
        if ($hookname == 'addCardTab') {
            // Vérifier si l'objet courant est un tiers (société ou compagnie)
            if ($object->element == 'societe' || $object->element == 'company') {
                // Vérifier si l'utilisateur a la permission de lire les mails du module
                // La permission 'read' est définie dans perms.php
                if (!empty($user->rights->mailboxmodule->read)) {
                    $head = array(); // Tableau pour les entêtes d'onglets (non utilisé directement ici pour l'ajout)
                    $tab = 'custom/mailboxmodule/card_mails.php?id=' . $object->id; // URL de votre page d'onglet, passant l'ID du tiers
                    $title = "Mails liés"; // Titre de l'onglet, ici en dur car pas de fichier de langue

                    // Ajouter l'onglet à la fiche de l'objet
                    // Le dernier argument est une valeur booléenne (0 ou 1) pour l'activation.
                    // On met 1 ici car la permission a déjà été vérifiée au-dessus.
                    $this->add_tab($head, $tab, $title, 1);
                }
            }
        }
        return 0; // Retourne 0 si aucune action n'a été effectuée par ce hook
    }
}
?>