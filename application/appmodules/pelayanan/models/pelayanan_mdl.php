<?php

/**
 * @author arshakariza
 * @copyright 2012
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pelayanan_mdl extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }



    function list_pelayanan(){
        $sql    = $this->db->Query("select * from promo order by proid desc");
            return $sql;
    }

    function pelayanan_detail($proid){
        $sql    = $this->db->Query("select * from promo where proid=".$proid);
            return $sql;
    }



    function delete_pelayanan($proid){
//        $this->db->debug =true;

        $nama_file = $this->db->GetOne("select image from promo where proid=".$proid);

        $file      = 'pelayanan/'.$nama_file;
        @unlink($file);

        $ok = $this->db->execute("delete from promo where proid=".$proid);
        return $ok;
    }


    function act_pelayanan($images,$title,$content,$uri,$proid){

        $this->db->debug =true;

        if ($proid==''){
        $sql    = "INSERT INTO promo (judul,deskripsi,image)
                            VALUES ('".$title."','".$content."','".$images."')";
        }else{
            $addi = '';
            if ($images!=''){
                $addi   = ",image ='".$images."'";
            }
        $sql    = "UPDATE promo SET 
                            judul = '".$title."',
                            deskripsi ='".$content."'
                            ".$addi."
                            WHERE proid='".$proid."'";
        }

        $ok      = $this->db->execute($sql);

        return $ok;

    }




}
?>
