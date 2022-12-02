<?php



/**

 * @author arshakariza

 * @copyright 2012

 */



if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class News_mdl extends CI_Model {

    

    function __construct()

    {

        parent::__construct();

    }

        function news(){

        $adwhere  = '';

        if ($this->input->post('title')!=''){

            $adwhere = " where upper(title) like upper('%".$this->input->post('title')."%') or upper(content) like upper('%".$this->input->post('title')."%')";

        }

        $sql    = $this->db->Query("select * from news {$adwhere} order by tanggal desc");

        return $sql;

    }



    function news_detail($news_id){

        $sql    = $this->db->Query("select * from news where news_id=".$news_id);

        return $sql;

    }







    function delete_news($news_id){

//        $this->db->debug =true;



        $nama_file = $this->db->GetOne("select images from news where news_id=".$news_id);



        $file      = 'news_image/'.$nama_file;

        @unlink($file);



        $ok = $this->db->execute("delete from news where news_id=".$news_id);

        return $ok;

    }





    function act_news($images,$title,$content,$uri,$news_id,$pdf){



        $this->db->debug =true;


        if ($news_id==''){

        $sql    = "INSERT INTO news (title,content,uri,images,pdf)

                            VALUES ('".$title."','".$content."','".$uri."','".$images."','".$pdf."')";

        }else{

            $addi = '';

            if ($images!=''){

                $addi   = ",images ='".$images."'";

            }

            if ($pdf!=''){

                $addi   = ",pdf ='".$pdf."'";

            }

        $sql    = "UPDATE news SET 

                            title = '".$title."',

                            content ='".$content."',

                            uri ='".$uri."'

                            ".$addi."

                            WHERE news_id='".$news_id."'";

        }



        $ok      = $this->db->execute($sql);



        return $ok;



    }







}

?>