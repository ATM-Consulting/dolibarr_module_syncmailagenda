<?php

class SyncMailAgenda extends SeedObject {
   
    public $element = 'syncmailagenda';
    
    public $table_element='syncmailagenda';
    
    function __construct($db) {
        
        $this->db = &$db;
        
        global $langs;
        
        $this->fields=array(
            'fk_soc'=>array('type'=>'integer','index'=>true)
            ,'fk_contact'=>array('type'=>'integer','index'=>true)
            ,'fk_user'=>array('type'=>'integer','index'=>true)
            ,'messageid'=>array('type'=>'string','lenght'=>100,'index'=>true)
            ,'mto'=>array('type'=>'string','lenght'=>100,'index'=>true)
            ,'mfrom'=>array('type'=>'string','lenght'=>100,'index'=>true)
            ,'body'=>array('type'=>'text')
            ,'title'=>array('type'=>'string')
        );
        
        $this->init();
        
        $this->lines = array();
        $this->nbLines = 0;
    }
    

    
}
    