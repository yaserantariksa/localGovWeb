<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Require the base controller
require_once( JPATH_COMPONENT.DS.'controller.php' );

//add styles and javascript
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="administrator/components/com_noticeboard/helpers/style.css" type="text/css" media="screen" />');
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="administrator/components/com_noticeboard/helpers/norounded.css" type="text/css" media="screen" />');
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="administrator/components/com_noticeboard/helpers/rounded.css" type="text/css" media="screen" />');
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="administrator/components/com_noticeboard/helpers/general.css" type="text/css" media="screen" />');
$mainframe->addCustomHeadTag ('<script language="javascript" type="text/javascript" src="includes/js/joomla.javascript.js"></script>');

// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

// Create the controller
$classname	= 'NoticeBoardsController'.$controller;
$controller	= new $classname( );

// Perform the Request task 
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();