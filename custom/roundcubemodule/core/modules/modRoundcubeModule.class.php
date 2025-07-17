<?php

include_once DOL_DOCUMENT_ROOT . '/core/modules/DolibarrModules.class.php';

class modRoundcubeModule extends DolibarrModules
{
    public function __construct($db)
    {
        global $langs, $conf;

        $this->db = $db;
        $this->numero = 104010;
        $this->rights_class = 'roundcubemodule';
        $this->family = "crm";
        $this->name = preg_replace('/^mod/i', '', get_class($this));
        $this->description = "Accès au webmail Roundcube depuis Dolibarr";
        $this->version = '1.0';
        $this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
        $this->picto = 'fa-envelope';
        $this->config_page_url = array();
        $this->langfiles = array();
        $this->rights = array();
        $this->module_parts = array();
        $this->dirs = array("/roundcubemodule/temp");

        $this->menu = array(
            array(
                'fk_menu' => 0,
                'type' => 'top',
                'titre' => 'Webmail',
                'mainmenu' => 'fa-envelope',
                'leftmenu' => '',
                'url' => '/custom/roundcubemodule/roundcube_iframe.php',
                'langs' => 'fr_FR',
                'position' => 100,
                'enabled' => '1',
                'perms' => '1',
                //'target' => '_blank',
                'user' => 2
            )
        );
    





    
    }
}
