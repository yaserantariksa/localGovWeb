<?php

/**
 * @author arshakariza
 * @copyright 2012
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tools_mdl extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    


    function act_ganti_passwd($pass1,$pass2){

        $ok         = $this->db->Query("update app_users set userpass=md5('".$pass1."') where username='".$_SESSION['DATA_USER']['username']."'");
        if ($ok){
          die("<Script language='javascript'>alert('Password Berhasil di Update!'); window.location.replace('".base_url()."tools/ganti_passwd')</script>");            
        }
    }


}
?>