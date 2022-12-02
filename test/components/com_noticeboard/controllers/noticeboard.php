<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class NoticeBoardsControllerNoticeBoard extends NoticeBoardsController
{
	/**
	 * constructor 
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register tasks
		$this->registerTask( 'add'  , 'edit');
	}


	/**
	 * display the edit form
	 * @return void
	 */
	function add()
	{
		JRequest::setVar( 'view', 'new' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}


	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'noticeboard' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}
	

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('noticeboard');

		if ($model->store($post)) {
			$msg = JText::_( 'Notice Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Notice' );
		}

		// Check the table in so it can be edited
		$link = 'index.php?option=com_noticeboard';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('noticeboard');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Notices Could not be Deleted' );
		} else {
			$msg = JText::_( 'Notice(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_noticeboard', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_noticeboard', $msg );
	}
}