<?php

/**
 * @author arshakariza
 * @copyright 2012
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery_mdl extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }

    function get_gallery(){
        $rs     = $this->db->query("select *  from gallery a left join kat_gallery b ON (a.kgid=b.kgid) order by gid DESC");
        return $rs;
    }

    function get_gal($gid){
        $rs     = $this->db->query("select *  from gallery a left join kat_gallery b ON (a.kgid=b.kgid) where a.gid='".$gid."' order by gid DESC");
        return $rs;
    }

    function kat(){
        $rs     = $this->db->query("select nama_kategori,kgid  from kat_gallery order by kgid DESC");
        return $rs;
    }


   function upload($namafile,$title,$kgid,$gid){
   //     $this->db->debug =true;
    $urutan         = $this->input->post('urutan',0);
    if ($gid !=''){

                    if ($namafile!=''){
                            $res = $this->db->Execute("UPDATE gallery SET filename='".$namafile."',title='".$title."',urutan='".$urutan."',kgid=".$kgid." WHERE gid=".$gid);
                    }else{
                            $res = $this->db->Execute("UPDATE gallery SET title='".$title."',urutan='".$urutan."',kgid=".$kgid." WHERE gid=".$gid);
                        }


    }else{
                    if ($namafile!=''){
                            $res = $this->db->Execute("INSERT INTO gallery (filename,title,kgid,urutan) VALUES ('".$namafile."','".$title."','".$kgid."','".$urutan."')");
                    }else{
                            $res = $this->db->Execute("INSERT INTO gallery (filename,title,kgid,urutan) VALUES ('".$namafile."','".$title."','".$kgid."','".$urutan."')");
                        }

    }

        if ($res){
            die("
                <script>
                alert('Upload Success!');
                window.location.replace('".base_url()."gallery/list_gallery')
                </script>
                    ");

            }

    }

    function delete_gallery($gid){
        $nama_file = $this->db->GetOne("SELECT filename FROM gallery where gid=".$gid);
        $file      = 'gallery/'.$nama_file;
        @unlink($file);
        $delet     = $this->db->Execute("delete from gallery where gid=".$gid);
        if ($delet){
            die("
                <script>
                alert('Delete Success!');
                window.location.replace('".base_url()."gallery/list_gallery')
                </script>
                    ");

            }

    }
}
?>