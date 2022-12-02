<?php

/**
 * @author arshakariza
 * @copyright 2012
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slideimage_mdl extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    



    function get_slide(){
        $rs     = $this->db->query("select *  from slider order by slide_id DESC");
        return $rs;
    }

    function get_slide_edit($slideid){
        $rs     = $this->db->query("select *  from slider where slide_id=".$slideid);
        return $rs;
    }

    function slide_upload($namafile){
//        $base->db->debug =true;
        $title_id   = $this->input->post('title_id');
        $title_en   = $this->input->post('title_en');
        $desc_id    = $this->input->post('desc_id');
        $desc_en    = $this->input->post('desc_en');
        $res = $this->db->Execute("INSERT INTO slider (image) VALUES ('".$namafile."')");

        if ($res){
            die("
                <script>
                alert('Upload Success!');
                window.location.replace('list_slide')
                </script>
                    ");

            }

    }

    function delete_slide($slideid){
        $nama_file = $this->db->GetOne("SELECT image FROM slider where slide_id=".$slideid);
        $file      = 'slide/'.$nama_file;
        @unlink($file);
        $delet     = $this->db->Execute("delete from slider where slide_id=".$slideid);
        if ($delet){
            die("
                <script>
                alert('Delete Success!');
                window.location.replace('list_slide')
                </script>
                    ");

            }
    }




}
?>