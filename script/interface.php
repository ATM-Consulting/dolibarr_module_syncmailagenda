<?php

	require '../config.php';
	
	
	$get = GETPOST('get');
	
	switch ($get) {
		case 'boxes':
		
			__out(_mailboxes(GETPOST('host'),GETPOST('user'),GETPOST('pass')),'json');
			
			break;
		
	}

function _mailboxes($host, $user, $pass) {
	$mbox = imap_open($host, $user, $pass);
	
	$list = imap_getmailboxes($mbox, $host, "*");
	
	imap_close($mbox);
	
	$Tab=array();
	foreach($list as $v){
		$v->name = substr($v->name,strlen($host));
		$Tab[] = $v;		
	}

	
	return $Tab;
}
