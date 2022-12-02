<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class TableNoticeBoard extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */
	var $title = null;

	/**
	 * @var string
	 */
	var $description = null;


	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableNoticeBoard(& $db) {
		parent::__construct('#__noticeboard', 'id', $db);
	}
}