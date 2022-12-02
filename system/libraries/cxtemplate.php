<?php
/**
 * modified version of LoudTemplate
*/

//======original note below===========
/****************************************************************************
* LoudTemplate : a PHP-language template system                             *
* Copyright (C) 2001  David J. Fischer                                      *
* david@shoutingman.com                                                     *
* http://shoutingman.com                                                    *
*                                                                           *
* This library is free software; you can redistribute it and/or             *
* modify it under the terms of the GNU Lesser General Public                *
* License as published by the Free Software Foundation; either              *
* version 2.1 of the License, or (at your option) any later version.        *
*                                                                           *
* This library is distributed in the hope that it will be useful,           *
* but WITHOUT ANY WARRANTY; without even the implied warranty of            *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU         *
* Lesser General Public License for more details.                           *
*                                                                           *
* You should have received a copy of the GNU Lesser General Public          *
* License along with this library; if not, write to the Free Software       *
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA *
****************************************************************************/
class CxTemplate {
	var	$_parsedPage,
		$_content = array(),
		$_template,
		$_templateBak,
		$_templateFilename,
		$_delimiter,
		$_dynaDelimiter;
	/* Constructor: Intialize the object*/
	function __construct( $file = "", $type="file", $delim_open="", $delim_close="" ) {
		$this->_parsedPage = "";
		$this->_content = array();
		$this->setTemplate($file, $type);
		$this->setDynamicBlockDelimiters();
		if($delim_open || $delim_close)
			$this->setDelimiters($delim_open, $delim_close);
		else
			$this->setDelimiters();
	}
	/* reset all the object & variables to initial, empty state */
	function init() {
		$this->unassign();
		$this->emptyParsedPage();
		$this->setDelimiters();
		$this->setDynamicBlockDelimiters();
		$this->setTemplate( "", "" );
	}
	
	/* set the file to load the template from. resets the template if file is not specified */
	function setTemplate( $template = "", $type = "file" ) {
		if( $template ) {
			switch($type) {
				case "file" :
					$this->_templateFilename = $template;
					$this->_template = $this->loadFile( $this->_templateFilename );
					break;
				case "literal" :
					$this->_templateFilename = "";
					$this->_template = $template;
					break;
				default :
					$this->_templateFilename = "";
					$this->_template = "";
					break;
			}
			$this->_templateBak = $this->_template;
		} elseif( $this->_templateBak ) {
			$this->_template = $this->_templateBak;
		} else {
			$this->_templateFilename = "";
			$this->_template = "";
		}
	}
	
	/* Set the open & close delimiters for keys in the template file. Defaults to '{' & '}' */
	function setDelimiters( $open='{', $close='}' ) {
		$this->_delimiter = array( "open" => $open, "close" => $close );
	}
	
	function setDynamicBlockDelimiters( $open='<!-- START LOOPING: record -->', $close='<!-- END LOOPING: record -->' ) {
		$this->_dynaDelimiter = array( "open" => $open, "close" => $close );
	}
	
	/* Read the file specified by filename $fname and return the contents */
	/* Private function. Not to be called from outside the object. */
	function loadFile( $fname = "" ) {
		$contents = "";
		if($fname) {
		if($fp = fopen($fname, 'r')) {
			$contents = fread($fp, filesize($fname));
			fclose($fp);
		}
		}
		return $contents;
	}
	
	function makeKey( $key ) {
		return;
	}
	function assignKey( $key, $input = "", $type = "", $dep = "" ) {
		$this->assign( $key, $input, $type, $dep);
	}
	function emptyKey( $key ) {
		$this->_content[$key] = NULL;
	}
	function deleteKey( $key ) {
		$this->unassign( $key );
	}
	
	/* Remove the keyrence and associated content data specified bvy the key $key from the object. if $key is unspecified, then all key/value pairs are removed */
	function unassign( $key=0 ) {
		if( !$key ) unset($this->_content);
		else unset($this->_content[$key]);
	}
	
	/* Assign template symbols to content source */
	/* key = record in template file to replace */
	/* input = input data to replace key with */
	/* Valid data types are:
		"dynamic" 	: a dynamic block. The block, including delimiters, is replaced by the block 
					  record key. The content, sans delimiters is used as the template for a new 
					  template object.
		"template" 	: another template object. The input object is parsed and the content substituted into the template
		"file" 		: a file is read and substituted into the template
		"function"	: a function (no parameters allowed) which is called and the return value is substituted into the template
		"php"		: a string containing valid PHP code. It will be executed when parsed.
		"variable"	: a variable, the value of which is substituted into the template
		"literal" 	: a literal value, which is substituted into the template
	*/
	/* type = input data type */
	/* dep = dedendency file required for input */
	function doAssign( $key, $input = "", $type = "", $dep = "" ) {
		
		$this->_content[$key] = array( "INPUT" => $input, "TYPE" => $type, "DEP" => $dep );
	}
	
	function assign( $key, $input = "", $type = "", $dep = "" ) {
	  
		if(is_array($key)) {
			$allKeys = array_keys($key);
			foreach($allKeys as $thisKey) {
				$keylen = (is_array($key[$thisKey]))?sizeof($key[$thisKey]):0;
				$input0 = $key[$thisKey];
				$input1 = "";
				$input2 = ""; 
				if($keylen > 1) {
					$input1 = $key[$thisKey][1];
					if($keylen > 2) {
						$input2 = $key[$thisKey][2];
					}
				}
    
				$this->doAssign($thisKey, $input0, $input1, $input2);
			}
		} else {
			$this->doAssign($key, $input, $type, $dep);
		}
	}
	
	function assignDynamic( $blockKey, $dynKey, $input = "", $type = "", $dep = "" ) {
	
        if(!isset($this->_content[$blockKey])) {$this->defineDynamicBlock($blockKey);}
        
		$tplobj = & $this->_content[$blockKey]["INPUT"];
        
        if(!isset($tplobj)) die('Dynamic looping not defined !');
		
        $tplobj->assign($dynKey, $input, $type, $dep);
        
	}
	
	function &doDynamicBlock( $key ) {
		$blockStart = str_replace( "record", $key, $this->_dynaDelimiter["open"] );
		$blockEnd   = str_replace( "record", $key, $this->_dynaDelimiter["close"] );
		$posStart   = strpos($this->_template, $blockStart); if ($posStart === false) return;
		$posEnd     = strpos($this->_template, $blockEnd); if ($posEnd === false) return;
		$lenStart   = strlen($blockStart);
		$lenEnd     = strlen($blockEnd);
		
		$tpl = $this->_template;
		$dynKey = $this->_delimiter["open"].$key.$this->_delimiter["close"];
		$dynBlock = substr($this->_template, $posStart+$lenStart, $posEnd-($posStart+$lenStart));
		$this->_template = substr($tpl, 0, $posStart-2).$dynKey.substr($tpl, $posEnd+$lenEnd+2);
		
		$tplobj = new CxTemplate( $dynBlock, "literal", $this->_delimiter["open"], $this->_delimiter["close"] );
		$this->_content[$key] = array( "INPUT" => $tplobj, "TYPE" => "dynamic", "DEP" => "" );
        return $this->_content[$key]["INPUT"];
	}
	
	function &defineDynamicBlock( $key ) {
		if(is_array($key)) {
			foreach($key as $thisKey) {// var_dump($thisKey);
				$this->doDynamicBlock($thisKey);
                
			}
		} else { //var_dump($this->doDynamicBlock($key));
			 return $this->doDynamicBlock($key);
		}
	}
	
	function parseConcatDynamic( $key ) {
		$tplobj = & $this->_content[$key]["INPUT"];
		$tplobj->parseConcat();
	}
	/* Parse the template, replacing template symbols with their respective content, and return the result*/
	function parse( $substKey="" ) {
		$parsedPage = $this->_template;
		if( !is_array($this->_content) )
			return $parsedPage;
		
		if($substKey) 
			$keys[] = $substKey;
		else
			$keys = array_keys($this->_content);
		
		foreach($keys as $key) {
			$find = $this->_delimiter["open"].$key.$this->_delimiter["close"];
			$content = $this->_content[$key];
			$val  = $content["INPUT"];
			$type = $content["TYPE"];
			$dep  = $content["DEP"];
			if($dep) { include_once $dep; }
			$replace = "";
			switch($type) {
				case "dynamic" :
				case "template" :
					if($val) $replace = $val->parsedPage();
					break;
				case "file" 	:
					$replace = $this->loadFile($val);
					break;
				case "function"	:
					$replace = $val();
					break;
				case "variable"	:
					if(isset($$val))
						$replace = $$val;
					elseif(isset($GLOBALS["$val"])) 
						$replace = $GLOBALS["$val"];
					break;
				case "php" :
					if(isset($val) && strlen($val)>1) {
						// turn output buffering on (no output goes to browser)
						ob_start();
						// empty any buffer content (anything in the buffer will be lost)
//						ob_clean();
						// execute the script, getting any value returned by the script
						$script_return = eval($val);
						// get any output echo'd by the script
						$script_output = ob_get_contents();
						// empty the buffer and stop output buffering
						ob_end_clean();
						// get any output saved in specific script variable
						if(isset($tpl_script_var))
							$script_var = $tpl_script_var;
						else
							$script_var = "";
						// create template text from script output
						$replace = $script_return.$script_output.$script_var;
					}
					break;
				case "literal" 	:
				default			:
					$replace = $val;
					break;
			} // switch($type)
			$parsedPage = str_replace($find, $replace, $parsedPage);
		} // foreach($keys as $key)
		return $parsedPage;
	}
	
	function parseNew( $substKey="" ) {
		$this->_parsedPage = $this->parse($substKey);
	}
	
	function parseConcat( $substKey="" ) {
		$this->_parsedPage .= $this->parse($substKey);
	}
	
	function parseFirst( $key ) {
		$len = strlen($key);
		$pos = strpos($this->_template, $key);
		$origTemplate = $this->_template;
		$this->_template = substr($this->_template, 0, $pos+$len+1);
		$this->_parsedPage = $this->parse($key);
		$this->_template = $origTemplate;
		$this->_parsedPage .= substr($this->_template, $pos+$len+1);
	}
	
	/* The current template data is replaced with the current page data */
	function setParsedAsTemplate() {
		$this->_template = $this->_parsedPage;
	}
	
	/* The current page data is replaced with the current template data */
	function setTemplateAsParsed() {
		$this->_parsedPage = $this->_template;
	}
	
	function revertTemplate() {
		$this->setTemplate();
	}
	
	/* Return the current template */
	function template() {
		return $this->_template;
	}
	
	/* Empty the parsed page. */
	function emptyParsedPage() {
		$this->_parsedPage = "";
	}
	
	/* Empty the parsed page. */
	function emptyTemplate() {
		$this->_template = "";
	}
	
	/* Return the current page. If there is no parsed page, it is first parsed. */
	function parsedPage() {
		if( !$this->_parsedPage ) $this->parseNew();
		return $this->_parsedPage;
	}
	
	/* Display the page generated by the parsedPage() function.If there is no parsed page, it is first parsed. */
	function render() {
		echo $this->parsedPage();
	}
}
?>
