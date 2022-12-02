<?php

/**
 * @author arshakariza
 * @copyright 2012
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjamin_mdl extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }



    function list_penjamin(){
        $sql    = $this->db->Query("select * from penjamin order by loid desc");
            return $sql;
    }

    function penjamin_detail($loid){
        $sql    = $this->db->Query("select * from penjamin where loid=".$loid);
            return $sql;
    }



    function delete_penjamin($loid){
//        $this->db->debug =true;


        $ok = $this->db->execute("delete from penjamin where loid=".$loid);
        return $ok;
    }

    function kat(){

        $rs     = $this->db->query("select nama_kategori,lkid  from layanan_kat order by lkid DESC");
        return $rs;

    }

    function act_penjamin ($title,$content,$loid,$kode){
//        $this->db->debug =true;

        if ($loid==''){
        $sql    = "INSERT INTO penjamin (nama_loker,jabatan,kode)
                            VALUES ('".$title."','".$content."','".$kode."')";
        }else{

        $sql    = "UPDATE penjamin SET 
                            nama_loker = '".$title."',
                            jabatan ='".$content."',
                            kode ='".$kode."'
                            WHERE loid='".$loid."'";
        }

        $ok      = $this->db->execute($sql);

        return $ok;

    }

    function save_last_update($data){

        $ok     = $this->db->Execute("update last_update_penjamin set data='".$data."'");

            die("
                <script>
                alert('Success!');
               window.location.replace('".base_url()."penjamin/list_penjamin');
               window.close();
                </script>
                    "); 
    }

    function get_last(){
        $ok     = $this->db->getOne("select data from last_update_penjamin");
        return $ok;
    }




}
?>