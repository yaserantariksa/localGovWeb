<?php

/**
 * @author arshakariza
 * @copyright 2012
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Layanan_unggulan_mdl extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }



    function layanan_unggulan(){
        $sql    = $this->db->Query("select * from layanan order by lid desc");
            return $sql;
    }

    function pelayanan_detail($lid){
        $sql    = $this->db->Query("select * from layanan where lid=".$lid);
            return $sql;
    }



    function delete_pelayanan($lid){
//        $this->db->debug =true;


        $ok = $this->db->execute("delete from layanan where lid=".$lid);
        return $ok;
    }

    function kat(){

        $rs     = $this->db->query("select nama_kategori,lkid  from layanan_kat order by lkid DESC");
        return $rs;

    }

    function act_pelayanan ($images,$title,$content,$uri,$lid,$lkid){

//        $this->db->debug =true;
        if ($lid==''){
        $sql    = "INSERT INTO layanan (judul,deskripsi,lkid,images)
                            VALUES ('".$title."','".$content."','".$lkid."','".$images."')";
        }else{

                if ($images==''){
                        $sql    = "UPDATE layanan SET 
                                            judul = '".$title."',
                                            deskripsi ='".$content."',
                                            lkid ='".$lkid."'
                                            WHERE lid='".$lid."'";

                }else{
                        $sql    = "UPDATE layanan SET 
                                            judul = '".$title."',
                                            deskripsi ='".$content."',
                                            lkid ='".$lkid."',
                                            images ='".$images."'
                                            WHERE lid='".$lid."'";
                }
        }


        $ok      = $this->db->execute($sql);

        return $ok;

    }




}
?>
