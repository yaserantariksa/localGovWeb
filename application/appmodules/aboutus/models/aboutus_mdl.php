<?php

/**
 * @author arshakariza
 * @copyright 2012
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aboutus_mdl extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }

    function aboutus($id){
        $rs     = $this->db->Query("select * from tentang  where tid=".$id);
        return $rs;

    }


    function act_aboutus(){
//        $this->db->debug =true;
        $id         = $this->input->post('id');
        $rs     = $this->db->Query("UPDATE tentang set 
                                                        konten ='".$this->input->post('ab')."' where tid='".$id."'
                                                        ");
            die("
                <script>
                alert('Data Saved!');
                window.location.replace('".base_url()."aboutus/list_aboutus/".$id."')
                </script>
                    ");

    }

}
?>