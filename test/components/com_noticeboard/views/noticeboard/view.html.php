<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
// Component Helper
jimport('joomla.application.component.helper');

class NoticeBoardsViewNoticeBoard extends JView
{
	/**
	 * display method of Noticeboard
	 * @return void
	 **/
	function display($tpl = null)
	{
		
		//get notice
		$noticeboard	=& $this->get('Data');
		$isNew		= ($noticeboard->id < 1);
	
		// Load the toolbar helper
		require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'toolbar.php' );
		 
		// render the toolbar on the page. 
		echo "<div id=\"toolbar-box\">\n";
		echo "<div class=\"t\">\n";
		echo "<div class=\"t\">\n";
		echo "<div class=\"t\"></div>\n";
		echo "</div></div>\n";
		echo "<div class=\"m\">\n";
		echo noticeboardHelperToolbar::getToolbar( 'edit' );
			
		echo "<div class=\"header\">NoticeBoard Manager ";
			if($isNew)	{ echo(' (New) '); } 
			else		{ echo(' (Edit) '); }
		echo "</div>\n";
		
		echo "<div class=\"clr\"></div>\n";
		echo "</div>\n";
		echo "<div class=\"b\">\n";
		echo "<div class=\"b\">\n";
		echo "<div class=\"b\"></div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "</div>\n";
		
		
		$this->assignRef('noticeboard',	$noticeboard);
		parent::display($tpl);
	}
}