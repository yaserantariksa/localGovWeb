<?php
/**
* @version		$Id: plg_iewarning.php 10709 2009-03-21 09:58:52Z juanparati $
* @package		Joomla
* @copyright	Copyright (C) 2009 Terrasolutions.es. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );


class  plgSystemIewarning extends JPlugin
{
	
	function plgSystemIewarning(& $subject, $config)
	{			
    parent::__construct($subject, $config);
		
		//load the translation
	//	$this->loadLanguage( );
   	   $this->loadLanguage( '', JPATH_ADMINISTRATOR );
	}


	function onAfterDispatch()
	{
	  global $mainframe;
	  	 		  
    $document = &JFactory::getDocument();
    
    if ($document->getType() == 'html')
    {
         
      if (JRequest::getCmd('iewarning_off', '')!='') {     	      
         //JRequest::setVar('iewarning_off', 1, 'COOKIE', false); // Do not work! :(
         setcookie('iewarning_off', 'yes');
         $_COOKIE['iewarning_off']='yes';                      
      } else {
        
        $ieversion = $this->params->get('ie_version');
                  
        if ($this->params->get('ie_sucks')) {
          
          $sel[0]=JText::_('IEURL');      
          $sel[1]=JText::_('MOZILLAURL');  // My prefer, if you are driver use BMW, if you are web developer use Firefox
          $sel[2]=JText::_('SAFARIURL');   // My girldfriend uses this sometimes
          $sel[3]=JText::_('OPERAURL');    // Nice, the most modern and multiplatform web browser!
          $sel[4]=JText::_('CHROMEURL');   // My sister uses this, is simple, clean and faster, very faster (V8 Power)
          
          $mainframe->addCustomHeadTag("    	
     	    <!--[if ".$ieversion."]>
          <script type=\"text/javascript\">               
            document.location.href='{$sel[rand(0, count($sel)-1)]}';
          </script>
          <![endif]-->
          ");
    	       
        } else {  
           
          $document->addScript(JURI::base().'plugins/system/iewarning/js/warning.js');     	           
           
          $mainframe->addCustomHeadTag('    	
          <!--[if '.$ieversion.']>      
          <script type="text/javascript">   
                           
             var msg1  = "'.JText::_('IEISOUTDATE_TEXT').'";
             var msg2  = "'.JText::_('BESTEXPERIENCE_TEXT').'.";
             var msg3  = "'.JText::_('JUSTCLICK_TEXT').'";
             var br1   = "'.JText::_('IEVERSION').'"; // 8+
             var br2   = "'.JText::_('FIREFOXVERSION').'"; // 3+
             var br3   = "'.JText::_('SAFARIVERSION').'"; // 3+
             var br4   = "'.JText::_('OPERAVERSION').'"; // 9.5+";
             var br5   = "'.JText::_('CHROMEVERSION').'"; //2.0+
             var url1  = "'.JText::_('IEURL').'"; // http://www.microsoft.com/windows/Internet-explorer/default.aspx
             var url2  = "'.JText::_('MOZILLAURL').'"; // http://www.mozilla.com/firefox/
             var url3  = "'.JText::_('SAFARIURL').'"; // http://www.apple.com/safari/download/
             var url4  = "'.JText::_('OPERAURL').'"; // http://www.opera.com/download/
             var url5  = "'.JText::_('CHROMEURL').'"; //http://www.google.com/chrome
             var allowmsg = "'.JText::_('CONTINUEATMYRISK').'";
             var allowcontinue ='.(int)$this->params->get('allow_continue').';
             var waruri = "'.JURI::base().'plugins/system/iewarning/images/";                       
                   
             window.addEvent(\'domready\', function(){ iewarning(waruri); });      
          </script>
          <![endif]-->
          ');
            
        }
      } 
      
   }          	       
  
	}
	
	function isIE6 () { // Deprecated?  
		$msie='/msie\s(5\.[5-9]|[6]\.[0-9]*).*(win)/i';
		return isset($_SERVER['HTTP_USER_AGENT']) &&
			preg_match($msie,$_SERVER['HTTP_USER_AGENT']) &&
			!preg_match('/opera/i',$_SERVER['HTTP_USER_AGENT']);
	}

  
}
