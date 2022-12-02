<?php

/**
 * @author dikdik@yahoo.com
 * @copyright 2012
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_mdl extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    function get_main_menu() {
        $add_sql = '';
        if($_SESSION['DATA_USER']['is_admin']!='t')
        {
            if($_SESSION['DATA_USER']['user_module']!='')
            $add_sql = " AND mmid IN(".$_SESSION['DATA_USER']['user_module'].")";
            else
            $add_sql = " AND mmid=-1";    
        }
        $res = $this->db->Execute("SELECT * FROM m_menu WHERE is_active='t' $add_sql ORDER BY urutan DESC");
        
        return $res;        
    }
    
    function get_submenu($parent) {
        #$this->db->debug =true;
        $add_sql = '';
        if($_SESSION['DATA_USER']['is_admin']!='t')
        {
            if($_SESSION['DATA_USER']['user_permission']!='')
            $add_sql = " AND msid IN(".$_SESSION['DATA_USER']['user_permission'].")";
            else
            $add_sql = " AND msid=-1";    
        }
        $res = $this->db->execute("SELECT * FROM m_submenu WHERE mmid=".$parent." AND is_active='t' AND is_display='t' $add_sql ORDER BY urutan ASC");
        
        return $res;
    }
}

?>