<?php
/*
 * Script créant et vérifiant que les champs requis s'ajoutent bien
 */

if(!defined('INC_FROM_DOLIBARR')) {
	define('INC_FROM_CRON_SCRIPT', true);

	require('../config.php');

}

global $db;

dol_include_once('/syncmailagenda/class/syncmailagenda.class.php');

$o=new SyncMailAgenda($db);
$o->init_db_by_vars();