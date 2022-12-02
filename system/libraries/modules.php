<?php

/**
 * kimsen
 * @copyright 2014
 */

class CI_Modules {
    private $db;
	var $monthname = array(
										"none",     "Jan",   "Feb", "Mar",
										"Apr",    "Mei",       "Juni",     "Juli", 
										"Agustus",  "Sept", "Okt",
										"Nop", "Des");
										
	//mother language month names
	var $monthnamelong = array(
										"none",     "Januari",   "Februari", "Maret",
										"April",    "Mei",       "Juni",     "Juli", 
										"Agustus",  "September", "Oktober",
										"Nopember", "Desember");


    function __construct() {
       $CI = & get_instance();
       $this->db = $CI->adodb->db();
    } 
    
    function datetostring()
	{
		
	}
	
	function UpdateStock($branch,$kode_gk,$item_code,$jml)
	{
	    #$this->db->debug =1;
		$rs=$this->db->execute("select kode_brg from gl_transinventory where branch_id=".$branch." 
		and kode_gk=".$kode_gk." and kode_brg='".$item_code."'");
		if ($rs->recordcount()<=0)
		{
			$ok = $this->db->execute("insert into gl_transinventory (branch_id,kode_gk,kode_brg,vol) values 
			(".$branch.",".$kode_gk.",'".$item_code."',".$jml.")");
		}
		else
		{	
	        $ok = $this->db->execute("Update gl_transinventory set vol=vol+".$jml." where branch_id=".$branch." 
			and kode_gk=".$kode_gk." and kode_brg='".$item_code."'");
		}
		return $ok;
	}
	
	function isodate2string($isodate)/*{{{*/
	{
		$tmp_date=explode("-", $isodate);
		$bln = (int) ($tmp_date[1]*1);
		$tanggal = "$tmp_date[2] {$this->monthname[$bln]} $tmp_date[0]";
		return $tanggal;
	}/*}}}*/
	function dateIndo($isodate)/*{{{*/
	{
		$tmp_date=explode("-", $isodate);
		$bln = (int) ($tmp_date[1]*1);
		$tanggal = $tmp_date[2]."-".$tmp_date[1]."-".$tmp_date[0];
		return $tanggal;
	}/*}}}*/
	//$this->dayname[0];
	
	function dbtstamp2stringlong($dbtstamp)/*{{{*/
	{
		$s = explode(" ",$dbtstamp);
		$t = explode(':',$s[1]);
		$u = explode('.',$t[2]);
        
		return $this->isodate2date($s[0]) . " {$t[0]}:{$t[1]}:{$u[0]}";
	}/*}}}*/
	
	  function isodate2date($isodate)/*{{{*/
	  {
		if ($isodate == '') return '';
			$tmp_date=explode("-", $isodate);
			$bln = (int) ($tmp_date[1]*1);
			$tanggal = "$tmp_date[2] ".substr($this->monthname[$bln],0,3)." $tmp_date[0]";
			return $tanggal;
	  }/*}}}*/
  
	function get_combo_option_date($curdate='')/*{{{*/
  {
    $str = '';
    for ($i=1;$i<32;$i++)
    {
      if ($i == $curdate) $sel = 'selected';
      else $sel = '';
      $str .= "<option value='$i' $sel>$i</option>\r\n";
    }
    return $str;
  }/*}}}*/

  function get_combo_option_month($curmonth='')/*{{{*/
  {
    $str = '';
    for ($i=1;$i<13;$i++)
    {
      if ($i == $curmonth) $sel = 'selected';
      else $sel = '';
      $str .= "<option value='$i' $sel>$i</option>\r\n";
    }
    return $str;
  }/*}}}*/

 function get_combo_option_day($curday='')/*{{{*/
  {
    $str = '';
    for ($i=0;$i<7;$i++)
    {
      if ($i == $curday) $sel = 'selected';
      else $sel = '';
			$str .= "<option value='$i' $sel>{$this->dayname[$i]}</option>\r\n";
    }
    return $str;
  }/*}}}*/

  function get_combo_option_year($curyear,$startyear, $endyear)/*{{{*/
  {
    $str = '';
    for ($i=$startyear;$i<=$endyear;$i++)
    {
      if ($i == $curyear) $sel = 'selected';
      else $sel = '';
      $str .= "<option value='$i' $sel>$i</option>\r\n";
    }
    return $str;
  }/*}}}*/
	
  function get_combo_option_month_long($curmonth='',$selected_month='', $firstnull = false)/*{{{*/
  {
    $str = '';
		$monthnm = array(
										"",     "Jan",   "Feb", "Mar",
										"Apr",    "Mei",       "Jun",     "Jul", 
										"Agust",  "Sept", "Okt",
										"Nop", "Des");
    $minval = $firstnull ? 0 : 1;
		for ($i=$minval;$i<13;$i++)
    {
      if ($selected_month != '' && $i == $selected_month) $sel = 'selected';
      elseif ($i == $curmonth) $sel = 'selected';
      else $sel = '';
			$month_nm = $monthnm[$i];
      $str .= "<option value='$i' $sel>$month_nm</option>\r\n";
    }
    return $str;
  }/*}}}*/
	
}

?>
