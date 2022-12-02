<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * NoticeBoards View
 */
class NoticeBoardsViewNoticeBoards extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'NoticeBoard Manager' ), 'generic.png' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		// Get data from the model
		$items		= & $this->get( 'Data');

		$this->assignRef('items',		$items);

		parent::display($tpl);
	}
}