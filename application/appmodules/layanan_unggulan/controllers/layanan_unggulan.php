<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Layanan_unggulan extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->users->authentication();
        $this->load->model('layanan_unggulan_mdl');
        $this->load->library('../../controllers/main');
        $this->main->_head();
    }

    function list_layanan(){
        $tpl = $this->load->template("layanan_unggulan.html");

        $rs     = $this->layanan_unggulan_mdl->layanan_unggulan();
        $no =1;


    
        while(!$rs->EOF)
        {

            $tpl->assignDynamic('row',array(
                  'VNO'                         => $no++,
                  'TITLE'                       => $rs->fields['judul'],
                  'CONTENT'                     => $rs->fields['deskripsi'],
                  'LID'                         => $rs->fields['lid'],
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
        $lid    = $this->input->get('lid');

        $tpl = $this->load->template("add_layanan.html");

        if ($lid!=''){
            $rs             = $this->layanan_unggulan_mdl->pelayanan_detail($lid);
            $title          = $rs->fields['judul'];
            $content        = $rs->fields['deskripsi'];
            $lkid           = $rs->fields['lkid'];
            $image          = '<img src="'.base_url().'layanan/'.$rs->fields['images'].'" style="max-width:30%; margin:0;" class="image-responsive" />';
        }else{
            $title          = ""; 
            $content        = "";
            $image          = "";
            $lkid           = '';
        }
        $res_kgid           = $this->layanan_unggulan_mdl->kat();

        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
            'TITLE'         => $title,
            'CONTENT'       => $content,
            'IMAGE'         => $image,
            'LID'           => $lid,
            'KATEGORI'      => $res_kgid->GetMenu2('lkid',$lkid,true,false,'','class="form-control" id="lkid" style="width:30%"'),
        ));
        
        
        $this->load->render_template($tpl);    
    }



    function act_pelayanan(){
       $title   = $this->input->post('title');
       $content   = $this->input->post('content');
       $lid   = $this->input->post('lid');
       $lkid   = $this->input->post('lkid');

       $filename    = '';

      if ($_FILES['images']['name']!=''){
           $aConfig['upload_path']      = 'layanan/';
           $aConfig['allowed_types']    = '*';
           $aConfig['overwrite']        = true;     
           $this->load->library('upload');
           $ext = pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION);

           $_FILES['images']['name'] = date('Ymd').'_'.str_replace(' ','_',trim($title)).'.'.$ext;
           $this->upload->initialize($aConfig);
           $this->upload->do_upload('images');
           $filename = $_FILES['images']['name'];
        }


        $Ok     = $this->layanan_unggulan_mdl->act_pelayanan($filename,$title,$content,str_replace(' ','-',trim($title)),$lid,$lkid); 

          die("<script language='javascript'>alert('Layanan Unggulan Saved!');window.location.replace('".base_url()."layanan_unggulan/list_layanan')</script>");

    }

    function delete(){
        $lid   = $this->input->get('lid');
        $ok     = $this->layanan_unggulan_mdl->delete_pelayanan($lid);
          die("<script language='javascript'>alert('Layanan Unggulan Deleted!');window.location.replace('".base_url()."layanan_unggulan/list_layanan')</script>");
    }


}
