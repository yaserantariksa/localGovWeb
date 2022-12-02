<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Karir extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->users->authentication();
        $this->load->model('karir_mdl');
        $this->load->library('../../controllers/main');
        $this->main->_head();
    }

    function list_karir(){
        $tpl = $this->load->template("list_karir.html");

        $rs     = $this->karir_mdl->list_karir();
        $no =1;


    
        while(!$rs->EOF)
        {

            $tpl->assignDynamic('row',array(
                  'VNO'                         => $no++,
                  'TITLE'                       => $rs->fields['nama_loker'],
                  'CONTENT'                     => $rs->fields['jabatan'],
                  'LOID'                         => $rs->fields['loid'],
                  'KODE'                         => $rs->fields['kode'],
                  'BASE_URL'                    => base_url(),

            ));
            
            $tpl->parseConcatDynamic('row');
            $rs->movenext();
        }


        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
            'TITLE'         => $this->input->post('title'),
            'LAST'      => $this->karir_mdl->get_last(),
        ));
        
        
        $this->load->render_template($tpl);    

    }



    function addedit_karir(){
        $loid    = $this->input->get('loid');

        $tpl = $this->load->template("add_karir.html");

        if ($loid!=''){
            $rs             = $this->karir_mdl->karir_detail($loid);
            $title          = $rs->fields['nama_loker'];
            $content        = $rs->fields['jabatan'];
            $loid           = $rs->fields['loid'];
            $kode           = $rs->fields['kode'];
        }else{
            $title          = ""; 
            $content        = "";
            $loid           = '';
            $kode           = '';
        }
        $res_kgid           = $this->karir_mdl->kat();

        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
            'TITLE'         => $title,
            'JABATAN'       => $content,
            'KODE'          => $kode,
            'LOID'          => $loid,
        ));
        
        
        $this->load->render_template($tpl);    
    }



    function act_karir(){
       $title   = $this->input->post('title');
       $content   = $this->input->post('jabatan');
       $kode   = $this->input->post('kode');
       $loid   = $this->input->post('loid');


        $Ok     = $this->karir_mdl->act_karir($title,$content,$loid,$kode); 

          die("<script language='javascript'>alert('Karir Saved!');window.location.replace('".base_url()."karir/list_karir')</script>");

    }

    function delete(){
        $loid   = $this->input->get('loid');
        $ok     = $this->karir_mdl->delete_karir($loid);
          die("<script language='javascript'>alert('Karir Deleted!');window.location.replace('".base_url()."karir/list_karir')</script>");
    }


    function save_last_update(){
      $data   = $this->input->post('last');
      $ok   = $this->karir_mdl->save_last_update($data);
    }


}
