<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Penjamin extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->users->authentication();
        $this->load->model('penjamin_mdl');
        $this->load->library('../../controllers/main');
        $this->main->_head();
    }

    function list_penjamin(){
        $tpl = $this->load->template("list_penjamin.html");

        $rs     = $this->penjamin_mdl->list_penjamin();
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
            'LAST'      => $this->penjamin_mdl->get_last(),
        ));
        
        
        $this->load->render_template($tpl);    

    }



    function addedit_penjamin(){
        $loid    = $this->input->get('loid');

        $tpl = $this->load->template("add_penjamin.html");

        if ($loid!=''){
            $rs             = $this->penjamin_mdl->penjamin_detail($loid);
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
        $res_kgid           = $this->penjamin_mdl->kat();

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



    function act_penjamin(){
       $title   = $this->input->post('title');
       $content   = $this->input->post('jabatan');
       $kode   = $this->input->post('kode');
       $loid   = $this->input->post('loid');


        $Ok     = $this->penjamin_mdl->act_penjamin($title,$content,$loid,$kode); 

          die("<script language='javascript'>alert('penjamin Saved!');window.location.replace('".base_url()."penjamin/list_penjamin')</script>");

    }

    function delete(){
        $loid   = $this->input->get('loid');
        $ok     = $this->penjamin_mdl->delete_penjamin($loid);
          die("<script language='javascript'>alert('penjamin Deleted!');window.location.replace('".base_url()."penjamin/list_penjamin')</script>");
    }


    function save_last_update(){
      $data   = $this->input->post('last');
      $ok   = $this->penjamin_mdl->save_last_update($data);
    }


}
