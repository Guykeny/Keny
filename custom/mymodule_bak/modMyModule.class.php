// /htdocs/custom/mymodule/modMyModule.class.php
<?php

include_once DOL_DOCUMENT_ROOT.'/core/modules/DolibarrModules.class.php';

class modMyModule extends DolibarrModules
{
    public function __construct($db)
    {
        global $langs, $conf;

        $this->db = $db;
        $this->numero = 50000; // >100000 si tu veux éviter les conflits
        $this->rights_class = 'mymodule';
        $this->family = 'other';
        $this->name = preg_replace('/^mod/i', '', get_class($this));
        $this->description = "Module de test personnalisé";
        $this->version = '1.0';
        $this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
        $this->picto = 'generic';
        $this->module_parts = [];

        // Fichiers à créer automatiquement
        $this->dirs = array("/mymodule/temp");

        // Page de config
        $this->config_page_url = array("setup.php@mymodule");

        // Droits
        $this->rights = [];
        $r = 0;
        $this->rights[$r][0] = 50001;
        $this->rights[$r][1] = 'Lire';
        $this->rights[$r][2] = 'r';
        $this->rights[$r][3] = 1;
        $this->rights[$r][4] = 'read';
        $r++;

        // Menus
        $this->menu = array();
        $this->menu[] = array(
            'fk_menu'=>'',
            'type'=>'top',
            'titre'=>'MyModule',
            'mainmenu'=>'mymodule',
            'leftmenu'=>'mymodule',
            'url'=>'/mymodule/index.php',
            'langs'=>'mymodule@mymodule',
            'position'=>100,
            'enabled'=>'$conf->mymodule->enabled',
            'perms'=>'1',
            'target'=>''
        );
    }
}
