<?php
	
	define('INC_FROM_CRON_SCRIPT',true);
	require('config.php');
	
	dol_include_once('/contact/class/contact.class.php');
	dol_include_once('/societe/class/societe.class.php');
	dol_include_once('/comm/action/class/actioncomm.class.php');
	
	/*ini_set('display_errors',1);
	error_reporting(E_ALL);
	*/
	
	$res = $db->query("SELECT * FROM ".MAIN_DB_PREFIX."user_extrafields WHERE imap_connect IS NOT NULL");
	
	while($obj = $db->fetch_object($res)) {
		print "Récupération de la liste des boites mail de {$obj->imap_login}<br>";
		_get_mailboxes($obj->fk_object, $obj->imap_connect, $obj->imap_sent_mailbox, $obj->imap_login, $obj->imap_password);
			
	}

/**
 * Fonction permettant de générer la liste des boites mail disponibles (réception, envoi, brouillons), en cas de difficultés
 */

function _get_mailboxes($usertodo, $host, $mailbox, $login, $password) {

	$mbox = imap_open($host.$mailbox, $login, $password);
	
	$list = imap_getmailboxes($mbox, $host, "*");
	
	var_dump($list);
	
	imap_close($mbox);

}	