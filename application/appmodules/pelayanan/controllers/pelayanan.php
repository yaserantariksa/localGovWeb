<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pelayanan extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->users->authentication();
        $this->load->model('pelayanan_mdl');
        $this->load->library('../../controllers/main');
        $this->main->_head();
    }

    function list_pelayanan(){
        $tpl = $this->load->template("list_pelayanan.html");

        $rs     = $this->pelayanan_mdl->list_pelayanan();
        $no =1;


    
        while(!$rs->EOF)
        {

            $tpl->assignDynamic('row',array(
                  'VNO'                         => $no++,
                  'TITLE'                       => $rs->fields['judul'],
                  'CONTENT'                     => $rs->fields['deskripsi'],
                  'IMAGE'                       => $rs->fields['image'],
                  'PROID'                       => $rs->fields['proid'],
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



    function addedit_pelayanan(){
        $proid    = $this->input->get('proid');

        $tpl = $this->load->template("add_promo.html");

        if ($proid!=''){
            $rs             = $this->pelayanan_mdl->pelayanan_detail($proid);
            $title          = $rs->fields['judul'];
            $content        = $rs->fields['deskripsi'];
            $image          = '<img src="'.base_url().'pelayanan/'.$rs->fields['image'].'" style="max-width:30%; margin:0;" class="image-responsive" />';
        }else{
            $title          = ""; 
            $content        = "";
            $image          = "";
        }

        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
            'TITLE'         => $title,
            'CONTENT'       => $content,
            'IMAGE'         => $image,
            'PROID'        => $proid,
        ));
        
        
        $this->load->render_template($tpl);    
    }



    function act_pelayanan(){
       $title   = addslashes($this->input->post('title'));
       $content   = $this->input->post('content');
       $proid   = $this->input->post('proid');
       $filename    = '';

      if ($_FILES['images']['name']!=''){
           $aConfig['upload_path']      = 'pelayanan/';
           $aConfig['allowed_types']    = '*';
           $aConfig['overwrite']        = true;     
           $this->load->library('upload');
           $ext = pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION);

           $_FILES['images']['name'] = date('Ymd').'_'.str_replace(' ','_',$title).'.'.$ext;
           $this->upload->initialize($aConfig);
           $this->upload->do_upload('images');
           $filename = $_FILES['images']['name'];

        }

        $Ok     = $this->pelayanan_mdl->act_pelayanan($filename,$title,$content,str_replace(' ','-',$title),$proid);

          die("<script language='javascript'>alert('Promo Saved!');window.location.replace('".base_url()."pelayanan/list_pelayanan')</script>");

    }

    function delete(){
        $proid   = $this->input->get('proid');
        $ok     = $this->pelayanan_mdl->delete_pelayanan($proid);
          die("<script language='javascript'>alert('Promo Deleted!');window.location.replace('".base_url()."pelayanan/list_pelayanan')</script>");
    }


}
