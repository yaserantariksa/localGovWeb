<?php

/**
 * @author dikdik@yahoo.com
 * @copyright 2012
 */


class Login extends CI_Controller {
    
    function __construct() {
        
        parent::__construct();
        
    }
    
    function index($status='1') {
	
	if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < SESSION_EXIPRE)){
            die('<script>window.location.replace("'.base_url().'main");</script>');
        }
        
        $tpl = $this->load->get_template('login.html');
         
        $tpl->assign(array(
              'BASEURL' => base_url()
        ));
        
        $this->users->clear_session();
        
        $tpl->render();
    }
    
    function do_login() {
        
        $username = $this->input->post('username');
        
        $pass = $this->input->post('pass');
        
        $this->users->login_process($username,$pass);
    }
    
    function check_seesion(){
        
        $this->users->authentication();
    }
    
    function do_logout() {
        
        $this->users->clear_session();
        
        $this->users->redirect_login('login');
    }
}

?>
