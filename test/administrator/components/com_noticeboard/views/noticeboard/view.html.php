<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

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

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Notice Board' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		}
		else {
			//for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );

		}
		

		$this->assignRef('noticeboard',	$noticeboard);

		parent::display($tpl);
	}
}