<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author hasancx@yahoo.com
 * @copyright 2012
 */

class Slideimage extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->users->authentication();
        $this->load->model('slideimage_mdl');
        $this->load->library('../../controllers/main');
        $this->main->_head();
    }
    
    function list_slide(){


        $tpl = $this->load->template('image_slider.html');
        
        $tpl->defineDynamicBlock('row');
        $res = $this->slideimage_mdl->get_slide();
        $no =1;
        while(!$res->EOF)
        {
            $tpl->assignDynamic('row',array(
                  'VNO'                           => $no++,
                  'SLIDEID'                       => $res->fields['slide_id'],
                  'IMG'                           => $res->fields['image'],
                  'TITLE_EN'                      => $res->fields['title_en'],
                  'TITLE_ID'                      => $res->fields['title_id'],
                  'DESC_EN'                       => $res->fields['desc_en'],
                  'DESC_ID'                       => $res->fields['desc_id'],
            ));
            
            $tpl->parseConcatDynamic('row');
            $res->movenext();
        }


        $tpl->assign(array(
            'BASE_URL'      => base_url(),
        ));


        
        $this->load->render_template($tpl);


    }

    function add_new_slide(){

        $dropid = $this->input->get('dropid');
        $tpl    = $this->load->template('new_slide.html');
        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
        ));
        
        
        $this->load->render_template($tpl);    
    }

    function act_new_slide(){
           $aConfig['upload_path']      = 'slide/';
           $aConfig['allowed_types']    = '*';
           $aConfig['overwrite']        = true;     
           $this->load->library('upload');
           $ext = pathinfo($_FILES['namafile']['name'], PATHINFO_EXTENSION);

           $_FILES['namafile']['name'] = date('Ymd').'_photo.'.$ext;
           $_FILES['namafile']['name'] = date('Ymd').'_photo_'.rand().'.'.$ext;
           $this->upload->initialize($aConfig);
           if($this->upload->do_upload('namafile')){
            $Ok     = $this->slideimage_mdl->slide_upload($_FILES['namafile']['name']);
            }else{

                die('gagal upload photo');
            }

        }


    function delete_slide(){
       $slideid   = $this->input->get('slideid');
       $del    = $this->slideimage_mdl->delete_slide($slideid);

    }


    function edit_slide(){

        $mid = $this->input->get('slideid');
        $rs     = $this->slideimage_mdl->mainimage_edit($mid);
        $tpl = $this->load->get_template("image_slider_edit.html");
        $tpl->assign(array(
            'MID'           => $mid,
            'BASE_URL'      => base_url(),
        ));
        
        
        $this->load->render_template($tpl);    
    }

    function act_new_slide_edit(){
            $Ok     = $this->web_mdl->slide_upload_edit();

    }



}
