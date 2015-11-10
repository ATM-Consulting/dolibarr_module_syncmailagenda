<?php

class TSyncMailAgenda extends TObjetStd {
    function __construct() {
        global $langs;
         
        parent::set_table(MAIN_DB_PREFIX.'syncmailagenda');
        parent::add_champs('messageid,mfrom,mto',array('type'=>'string', 'index'=>true));
		parent::add_champs('fk_soc,fk_contact,fk_user',array('type'=>'integer', 'index'=>true));
		
        parent::add_champs('body',array('type'=>'text'));
        
        parent::_init_vars('title');
        parent::start();    
        
         
    }
	

    
}
    