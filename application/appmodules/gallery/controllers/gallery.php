<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Gallery extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->users->authentication();
        $this->load->model('gallery_mdl');
        $this->load->library('../../controllers/main');
        $this->main->_head();
    }

    function list_gallery(){

        $tpl = $this->load->template("list_gallery.html");        
        $tpl->defineDynamicBlock('row');
        $res = $this->gallery_mdl->get_gallery();
        $no =1;
        while(!$res->EOF)
        {
            $tpl->assignDynamic('row',array(
                  'VNO'                        => $no++,
                  'GID'                        => $res->fields['gid'],
                  'IMG'                        => $res->fields['filename'],
                  'TITLE'                      => $res->fields['title'],
                  'KAT'                        => $res->fields['nama_kategori'],
            ));
            
            $tpl->parseConcatDynamic('row');
            $res->movenext();
        }
        $tpl->assign(array(
            'BASE_URL'      => base_url(),
        ));

        $this->load->render_template($tpl);    
    }

    function add_new_gallery(){
        $gid = $this->input->get('gid');
        $tpl = $this->load->template("upload.html");
        $res_kgid           = $this->gallery_mdl->kat();
        if ($gid!=''){
            $rs             = $this->gallery_mdl->get_gal($gid);
            $title          = $rs->fields['title'];
            $urutan         = $rs->fields['urutan'];
            $kgid           = $rs->fields['kgid'];
            $req            = '';
        }else{

            $title          = '';
            $urutan         = '';
            $req            = 'required="required"';
            $kgid           = '';
        }

        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
            'title'         => $title,
            'urutan'        => $urutan,
            'REQ'           => $req,
            'GID'           => $gid,
            'KATEGORI'      => $res_kgid->GetMenu2('kgid',$kgid,true,false,'','class="form-control" id="kgid" style="width:30%" required'),
        ));
        
        
        $this->load->render_template($tpl);    
    }


    function act_upload_gallery(){

         $filename  = '';
         $title   = $this->input->post('title');
         $title2   = rand();
         $kgid   = $this->input->post('kgid');
          if ($_FILES['images']['name']!=''){
                     $aConfig['upload_path']      = 'gallery/';
                     $aConfig['allowed_types']    = '*';
                     $aConfig['overwrite']        = true;     
                     $this->load->library('upload');
                     $ext = pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION);

                     $_FILES['images']['name'] =  date('Ymd').'_photo_'.trim(str_replace(' ','_',$title.'_'.$title2)).'.'.$ext;
                     $this->upload->initialize($aConfig);

                     if($this->upload->do_upload('images')){
                      $filename = date('Ymd').'_photo_'.trim(str_replace(' ','_',$title.'_'.$title2)).'.'.$ext;
//                      $Ok     = $this->gallery_mdl->upload($filename,$title,$kgid);
                      }else{

                          die('gagal upload photo');
                      }

          }
          $gid      = $this->input->post('gid');
          $Ok     = $this->gallery_mdl->upload($filename,$title,$kgid,$gid);


    }

    function delete_image(){
       $gid   = $this->input->get('gid');
       $del    = $this->gallery_mdl->delete_gallery($gid);

    }


}
