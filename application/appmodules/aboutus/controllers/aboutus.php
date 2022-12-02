<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Aboutus extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->users->authentication();
        $this->load->model('aboutus_mdl');
        $this->load->library('../../controllers/main');
        $this->main->_head();
    }

    function list_aboutus(){

        $tpl = $this->load->template("aboutus.html");
        $id     = $this->uri->segment('3');
            $judul      = "Tentang Kami";
        $ab  = $this->aboutus_mdl->aboutus($id);
        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
            'aboutus'       => $ab->fields['konten'],
            'judul'         => $judul,
            'id'            => $id,
        ));
        
        
        $this->load->render_template($tpl);    

    }

    function act_aboutus(){
        $ab  = $this->aboutus_mdl->act_aboutus();

    }
}
