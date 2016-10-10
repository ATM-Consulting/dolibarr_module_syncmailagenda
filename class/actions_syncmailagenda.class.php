<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2015 ATM Consulting <support@atm-consulting.fr>
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
 * \file    class/actions_history.class.php
 * \ingroup history
 * \brief   This file is an example hook overload class file
 *          Put some comments here
 */

/**
 * Class ActionsHistory
 */
class ActionsSyncmailagenda
{
	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * @var array Errors
	 */
	public $errors = array();

	/**
	 * Constructor
	 */
	public function __construct()
	{
	}

	/**
	 * Overloading the doActions function : replacing the parent's function with the one below
	 *
	 * @param   array()         $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    &$object        The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          &$action        Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	function formObjectOptions($parameters, &$object, &$action, $hookmanager)
	{
		
		if (!empty($object) && in_array('usercard', explode(':', $parameters['context'])) && $action == 'edit')
		{
			?>
			<script type="text/javascript">
			$(document).ready(function() {
				$("input[name=options_imap_inbox_mailbox],input[name=options_imap_sent_mailbox]").each(function(i, item) {
					$item = $(item);
					$a=$('<a href="javascript:getMailBox(\''+$item.attr('name')+'\')">[...]</a>');
					$item.after($a);
				});
				
			});
			
			function setMailBox(fieldto, boxname) {
				
				$("input[name="+fieldto+"]").val(boxname);
				
				$('div#mailboxeslist').dialog("close");
				
			}
			
			function getMailBox(fieldto) {
				
				$.ajax({
					url:"<?php echo dol_buildpath('/syncmailagenda/script/interface.php',1) ?>"
					,data:{
						get:"boxes"
						,host:$("input[name=options_imap_connect]").val()
						,user:$("input[name=options_imap_login]").val()
						,pass:$("input[name=options_imap_password]").val()
					}
					,dataType:"json"
					
				}).done(function(data) {
					//console.log(data);
					
					$('div#mailboxeslist').remove();
					
					$div = $('<div id="mailboxeslist"></div>');
					$ul = $('<ul />');
					
					for(x in data) {
						
						$ul.append('<li><a href="javascript:setMailBox(\''+fieldto+'\', \''+data[x].name+'\')">'+data[x].name+'</a></li>');
						
					}
					
					$div.append($ul);
					$('body').append($div);
					
					$div.dialog();
					
				});
				
				
			}
			
			</script>
			<?php
		}
	}
}