<?php
/* Module de gestion des frais de port
 * Copyright (C) 2013 ATM Consulting <support@atm-consulting.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 	\file		admin/mymodule.php
 * 	\ingroup	mymodule
 * 	\brief		This file is an example module setup page
 * 				Put some comments here
 */
// Dolibarr environment

require('../config.php');
dol_include_once('/syncmailagenda/class/syncmailagenda.class.php');

$PDOdb=new TPDOdb;

global $db;

// Libraries
dol_include_once('syncmailagenda/lib/syncmailagenda.lib.php');
dol_include_once('core/lib/admin.lib.php');
//require_once "../class/myclass.class.php";
// Translations
$langs->load("syncmailagenda@syncmailagenda");

// Access control
if (! $user->admin) {
    accessforbidden();
}

// Parameters
$action = GETPOST('action', 'alpha');

/*
 * Actions
 */

switch ($action) {
	case 'save':
   		$TDivers = isset($_REQUEST['TDivers']) ? $_REQUEST['TDivers'] : array();
        
        foreach($TDivers as $name=>$param) {
        
            dolibarr_set_const($db, $name, $param);
            
        }
        if(!empty($TDivers)) setEventMessage( $langs->trans('RegisterSuccess') );
        
		break;
	default:
		
		break;
}
 
/*
 * View
 */ 

//print_r($TFraisDePort);
 
$page_name = "SyncMailAgendaSetup";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">'
    . $langs->trans("BackToModuleList") . '</a>';
print_fiche_titre($langs->trans($page_name), $linkback);

// Configuration header
$head = SyncMailAgendaAdminPrepareHead();
dol_fiche_head(
    $head,
    'settings',
    $langs->trans("Module104998Name"),
    0,
    "syncmailagenda@syncmailagenda"
);

?>
<table width="100%" class="noborder" style="background-color: #fff;">
    <tr class="liste_titre">
        <td colspan="2"><?php echo $langs->trans('Parameters') ?></td>
    </tr>
<tr>
    <td><?php echo $langs->trans('setSYNCMAILAGENDA_ONLY_MAIL_OBJECT') ?></td><td><?php
    
        if($conf->global->SYNCMAILAGENDA_ONLY_MAIL_OBJECT==0) {
            
             ?><a href="?action=save&TDivers[SYNCMAILAGENDA_ONLY_MAIL_OBJECT]=1"><?=img_picto($langs->trans("Disabled"),'switch_off'); ?></a><?php
            
        }
        else {
             ?><a href="?action=save&TDivers[SYNCMAILAGENDA_ONLY_MAIL_OBJECT]=0"><?=img_picto($langs->trans("Activated"),'switch_on'); ?></a><?php
            
        }
    
    ?></td>             
</tr>
</table><?php

print 'IMAP_MAX_PARSE_MAIL '.$conf->global->IMAP_MAX_PARSE_MAIL

llxFooter();

$db->close();