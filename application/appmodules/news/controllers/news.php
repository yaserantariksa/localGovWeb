<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class News extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->users->authentication();
        $this->load->model('news_mdl');
        $this->load->library('../../controllers/main');
        $this->main->_head();
    }

    function list_news(){
        $tpl = $this->load->template("news.html");

        $rs     = $this->news_mdl->news();
        $no =1;


    
        while(!$rs->EOF)
        {


                $content = strip_tags($rs->fields['content']);

                if (strlen($content) > 500) {

                    // truncate string
                    $stringCut = substr($content, 0, 500);

                    // make sure it ends in a word so assassinate doesn't become ass...
                    $content = substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a href="/this/story">Read More</a>'; 
                }


            $tpl->assignDynamic('row',array(
                  'VNO'                         => $no++,
                  'TITLE'                       => $rs->fields['title'],
                  'CONTENT'                     => $content,
                  'TANGGAL'                     => $rs->fields['tanggal'],
                  'NEWSID'                      => $rs->fields['news_id'],
                  'IMAGES'                      => ($rs->fields['images']=='')?'logo.png':$rs->fields['images'],
                  'BASE_URL'                    => base_url(),

            ));
            
            $tpl->parseConcatDynamic('row');
            $rs->movenext();
        }


        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
            'TITLE'         => $this->input->post('title')
        ));
        
        
        $this->load->render_template($tpl);    

    }


    function addedit_news(){
        $news_id    = $this->input->get('newsid');

        $tpl = $this->load->template("add_news.html");

        if ($news_id!=''){
            $rs             = $this->news_mdl->news_detail($news_id);
            $title          = $rs->fields['title'];
            $content        = $rs->fields['content'];
            $image          = $rs->fields['images'];
        }else{
            $title          = ""; 
            $content        = "";
            $image          = "";
        }

        if ($image ==''){
            $image = 'logo.png';
        }


        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
            'TITLE'         => $title,
            'CONTENT'       => $content,
            'IMAGE'         => $image,
            'NEWSID'        => $news_id,
        ));
        
        
        $this->load->render_template($tpl);    
    }

    function act_news(){
       $title   = $this->input->post('title');
       $content   = $this->input->post('content');
       $news_id   = $this->input->post('newsid');
       $filename    = '';
       $pdf    = '';

      if ($_FILES['images']['name']!=''){
           $aConfig['upload_path']      = 'news_image/';
           $aConfig['allowed_types']    = '*';
           $aConfig['overwrite']        = true;     
           $this->load->library('upload');
           $ext = pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION);

           $_FILES['images']['name'] = date('Ymd').'_'.str_replace(' ','_',$title).'.'.$ext;
           $this->upload->initialize($aConfig);
           $this->upload->do_upload('images');
           $filename = $_FILES['images']['name'];

        }


      if ($_FILES['pdf']['name']!=''){
           $aConfig['upload_path']      = 'news_pdf/';
           $aConfig['allowed_types']    = '*';
           $aConfig['overwrite']        = true;     
           $this->load->library('upload');
           $ext = pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION);

           $_FILES['pdf']['name'] = date('Ymd').'_'.str_replace(' ','_',$title).'.'.$ext;
           $this->upload->initialize($aConfig);
           $this->upload->do_upload('pdf');
           $pdf = $_FILES['pdf']['name'];

        }



        $Ok     = $this->news_mdl->act_news($filename,$title,$content,str_replace(' ','-',$title),$news_id,$pdf);

          die("<script language='javascript'>alert('News Saved!');window.location.replace('".base_url()."news/list_news')</script>");

    }

    function delete(){
        $news_id   = $this->input->get('newsid');
        $ok     = $this->news_mdl->delete_news($news_id);
          die("<script language='javascript'>alert('News Deleted!');window.location.replace('".base_url()."news/list_news')</script>");
    }

}
