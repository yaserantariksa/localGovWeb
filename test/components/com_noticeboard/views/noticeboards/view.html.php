<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
// Component Helper
jimport('joomla.application.component.helper');

class NoticeBoardsViewNoticeBoards extends JView
{
	function display($tpl = null)
	{
		
		 // Load the toolbar helper
		require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'toolbar.php' );
		 
		echo "<div id=\"toolbar-box\">\n";
		echo "<div class=\"t\">\n";
		echo "<div class=\"t\">\n";
		echo "<div class=\"t\"></div>\n";
		echo "</div></div>\n";
		echo "<div class=\"m\">\n";
		echo noticeboardHelperToolbar::getToolbar( 'list' );
		echo "<div class=\"header\">NoticeBoard Manager</div>\n";
		echo "<div class=\"clr\"></div>\n";
		echo "</div>\n";
		echo "<div class=\"b\">\n";
		echo "<div class=\"b\">\n";
		echo "<div class=\"b\"></div>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "</div>\n";

		// Get data from the model
		$items		=& $this->get( 'Data');
		$this->assignRef('items',		$items);

		parent::display($tpl);
	}
}