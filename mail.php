<?php

	require 'config.php';
	
	dol_include_once('/syncmailagenda/class/syncmailagenda.class.php');
	
	$fk_soc = GETPOST('fk_soc');
	$action = GETPOST('action');
	
	$PDOdb=new TPDOdb;
	
	switch($action) {
		case 'view':
			$m = new TSyncMailAgenda;
			$m->load($PDOdb, GETPOST('id'),$fk_soc);
			
			_fiche($m, $fk_soc);
			break;
			
		default:
			_liste($PDOdb, $fk_soc);
						
			break;
	}

function _fiche(&$m,$fk_soc) {
	global $db,$conf,$langs;
	llxHeader();
	
	if($fk_soc>0) {
		dol_include_once('/core/lib/company.lib.php');
		dol_include_once('/societe/class/societe.class.php');
		
		$object = new Societe($db);
		$object->fetch($fk_soc);
		
		$head = societe_prepare_head($object);
		dol_fiche_head($head, 'mail', $langs->trans("ThirdParty"),0,'company');
	}
	
	
	$upload_dir =$conf->syncmailagenda->dir_output.'/'.$m->getId();
	$urlsource = $_SERVER["PHP_SELF"] . "?id=" . $object->id.'&fk_soc='.$fk_soc;
	
	$var = true;

	dol_include_once('/core/class/html.formfile.class.php');
	$formfile=new FormFile($db);
	$formfile->show_documents('syncmailagenda', $m->getId(), $upload_dir, $urlsource, 0, 0, $object->modelpdf);

	?><br />
	<div class="titre">Mail <?php echo htmlentities($m->messageid) ?></div>
	<table class="border" width="100%">
		<tr>
			<td style="font-weight: bold;"><?php echo $m->title ?></td>
		</tr>
		<tr>
			<td ><?php echo $m->body ?></td>
		</tr>
	</table>
	<?php
	
	
	dol_fiche_end();
	
	llxFooter();
}

function _liste(&$PDOdb, $fk_soc = 0) {
	global $db,$conf,$langs;
	
	llxHeader();
	
	if($fk_soc>0) {
		$object = new Societe($db);
		$object->fetch($fk_soc);
		
		$head = societe_prepare_head($object);
		dol_fiche_head($head, 'mail', $langs->trans("ThirdParty"),0,'company');
	}
	
	$l=new TListviewTBS('listMail');
	
	$sql="SELECT rowid as Id, title, body, fk_user, fk_contact,date_cre FROM ".MAIN_DB_PREFIX."syncmailagenda WHERE 1";
	if($fk_soc>0)$sql.=" AND fk_soc = ".$fk_soc;
	
	$TOrderBy = array('date_cre'=>'DESC');
	
	echo $l->render($PDOdb, $sql,array(
		'link'=>array(
			'title'=>'<a href="?action=view&id=@Id@&fk_soc='.$fk_soc.'">@val@</a>'
		)
		,'hide'=>array('body')
		,'title'=>array(
			'title'=>$langs->trans('Title')
			,'body'=>$langs->trans('Body')
			,'fk_user'=>$langs->trans('User')
			,'fk_contact'=>$langs->trans('Contact')
		)
		,'type'=>array(
			'date_cre'=>'date'
		)
		,'liste'=>array(
			'titre'=>''
		)
		,'orderBy'=>$TOrderBy
		,'search'=>array(
			'title'=>true
		)
		,'eval'=>array(
			'fk_user'=>'_get_link_user(@val@)'
			,'fk_contact'=>'_get_link_contact(@val@)'
		)
		
		
	));
	
	dol_fiche_end();
	
	llxFooter();
}

function _get_link_contact($fk_contact) {
	global $db;
	
	dol_include_once('/contact/class/contact.class.php');
	
	$u=new Contact($db);
	$u->fetch($fk_contact);
	
	return $u->getNomUrl(1);
	
	
}

function _get_link_user($fk_user) {
	global $db;
	
	$u=new User($db);
	$u->fetch($fk_user);
	
	return $u->getNomUrl(1);
	
	
}
