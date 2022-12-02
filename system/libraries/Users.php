<?php

/**
 * @author hasancx
 * @copyright 2012
 */

class Users extends CI_Controller {
   
    private $db;
    private $CI;
    
    function __construct() {
        
       $this->CI = & get_instance();
       
       $this->db = $this->CI->adodb->db();
    } 
    
    function login_process($username, $pass) {

        $pre = $this->db->prepare("SELECT  asid,username, user_group, user_module, user_store, user_permission, user_group FROM app_users a WHERE username=? AND userpass=md5(?) AND a.is_active='1'");

        $res = $this->db->execute($pre, array($username,$pass));
     
        if(!$res) die("2");

 
 
        if(!$res->EOF) {

            session_name(APP_SESSION);
	        $this->regSession($res->fields);
            
            $this->redirect_login('main');
            die("1"); //sukses
        }
        else {
            
            $this->redirect_login('login/index/2');
            die("2");
        }
    
    }
    
    function regSession($data) {
        
        if($data['user_group']!='')
        {
            $msid_group = $this->db->getOne("SELECT ARRAY(SELECT msid_list FROM role_group WHERE rgid IN(".$data['user_group']."))");
            
            $mmid_group = $this->db->getOne("SELECT ARRAY(SELECT mmid_list FROM role_group WHERE rgid IN(".$data['user_group']."))");
            
            $msid_group = str_replace('"','',trim($msid_group,'{}'));
            
            $mmid_group = str_replace('"','',trim($mmid_group,'{}'));
        
            $data['user_module'] .= ",".$mmid_group;
            
            $data['user_module'] = trim($data['user_module'],',');
            
            $data['user_permission'] .= ",".$msid_group;
            
            $data['user_permission'] = trim($data['user_permission'],',');
        }
        
        $_SESSION['DATA_USER'] = $data;
        
        $_SESSION['LAST_ACTIVITY'] = time();
     
        $res = $this->db->execute("SELECT msid, mmid, link, segment FROM m_submenu WHERE is_active='t'");
        
        $user_permission = array();
        while(!$res->EOF)
        {
            $user_permission[] = array('msid' => $res->fields['msid'],'mmid' => $res->fields['mmid'],'link' => $res->fields['link'],'segment' => $res->fields['segment']);
            $res->movenext();
        }
        
        $_SESSION['CONTENT'] = $user_permission;
    }
    
    function authentication() {
        
        if(!isset($_SESSION['LAST_ACTIVITY'])) {
           
            $this->redirect_login('login');
        }
        else if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']> SESSION_EXIPRE)) {
            
            $this->clear_session();   
            
            $this->redirect_login('login');
        }
        else {
            
            $_SESSION['LAST_ACTIVITY'] = time();
            
            $access = $this->CI->uri->uri_string();
            
        }
    }
    
    function clear_session() {
        
        session_destroy();
        session_unset();
    }
    
    function redirect_login($url_to_login) {
        
        if($this->CI->input->is_ajax_request())
        die('session_expired');
        else
        die("<script>window.top.location='" . site_url($url_to_login) . "';</script>");
    
    }
}
