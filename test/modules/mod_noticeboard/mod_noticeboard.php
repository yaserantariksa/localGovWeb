<?php
/**
* @version		1.0
* @package		Noticeboard
* @copyright	Copyright (C) 2009 SP. All rights reserved.
* @license		GNU/GPL
*  
*/


// no direct access 
defined('_JEXEC') or die('Restricted access');

//include helper file
require_once (dirname(__FILE__).DS.'helper.php');

//get parameters
$nb_width = intval( $params ->get( 'width' ) );
$nb_height = intval( $params->get( 'height' ) );
$nb_bgcolor =  $params->get( 'bg_color' );
$nb_border_color = $params->get( 'border_color' );
$nb_border_width = intval( $params ->get( 'border_width' ) );
$nb_border_style = $params->get( 'border_style' );
$nb_spacing = intval( $params ->get( 'spacing' ) );
$nb_text_size = intval( $params->get( 'text_size') );
$nb_scroll_speed = intval( $params->get( 'scroll_speed' ) );
$nb_scroll_delay = intval( $params->get( 'scroll_delay' ) );
$nb_show_title = $params ->get( 'show_title' );

//add qscroller's javascript to document head and enable mootools
$js_filename = 'qscroller.php';
$path = 'modules/mod_noticeboard/assets/'; 

require_once($path . $js_filename);
//JHTML::script($js_filename, $path , true);
JHTML::_("behavior.mootools");

$lists = ModNoticeBoardHelper::getList($params);
require(JModuleHelper::getLayoutPath('mod_noticeboard'));