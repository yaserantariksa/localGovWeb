<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author hasancx@yahoo.com
 * @copyright 2011
 */

class Apotek extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->users->authentication();
    }
    
    function index(){
        
        $tpl = $this->load->get_template('apotek.html');
        
        $tpl->render();
    }
}