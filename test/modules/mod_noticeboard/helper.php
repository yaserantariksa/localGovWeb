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

class ModNoticeBoardHelper
{
	function getList(&$params)
	{
		global $mainframe;

		$db			=& JFactory::getDBO();

		$count		= intval($params->get('count', 5));
		
		//get notices and return
		$query =  'select * from `#__noticeboard` order by `id` desc';
		$db->setQuery($query, 0, $count);
		$rows = $db->loadObjectList();

		$i		= 0;
		$lists	= array();
		
		$notices = count($rows);
		
		if($notices > 0){
			foreach ( $rows as $row ){
				$lists[$i]->title = $row->title;
				$lists[$i]->description = $row->description;
				$i++;
			}
		}
		else{
			$lists[0]->title="Noticeboard Error!!";
			$lists[0]->description="Either noticeboard component is not installed or there are no notices to display.";
		}

		return $lists;
	}
}
