<?php

// A class to display admin like toolbar at front end

// no direct access
 defined('_JEXEC') or die('Restricted access');
 jimport('joomla.html.toolbar');
 
 class NoticeBoardHelperToolbar extends JObject
 {        
 	
        function getToolbar($type) {
			$bar =& new JToolBar( 'Notice Board' );
			
				
			if($type == "list"){
				
			//$bar->append
				$bar->appendButton( 'Standard', 'new', 'new', 'add', false );
				$bar->appendButton( 'Standard', 'edit', 'Edit', 'edit', true);
				$bar->appendButton( 'Standard', 'delete', 'Delete'	, 'remove', true );
			}
			else{
				$bar->appendButton( 'Standard', 'save', 'Save', 'save', false );
				$bar->appendButton( 'Standard', 'cancel', 'Cancel', 'cancel', false );
			}
			
			return $bar->render();
		 
        }
 
 }
?>