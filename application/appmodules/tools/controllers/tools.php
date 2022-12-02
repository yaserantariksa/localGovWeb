<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tools extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->users->authentication();
        $this->load->model('tools_mdl');
        $this->load->library('../../controllers/main');
        $this->main->_head();
    }

    function ganti_passwd(){

        $tpl    = $this->load->template('ganti_passwd.html');
        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
        ));
        
        
        $this->load->render_template($tpl);    
    }


    function act_ganti_passwd(){
      $pass1    = $this->input->post('pass1');
      $pass2    = $this->input->post('pass2');

      if ($pass1 != $pass2){
          die("<Script language='javascript'>alert('password tidak sama'); window.location.replace('".base_url()."tools/ganti_passwd')</script>");
      }

      $ok     = $this->tools_mdl->act_ganti_passwd($pass1,$pass2);

    }

    function list_image(){

        $tpl    = $this->load->template('upload_images.html');

        $dir = 'upload_data/';

        $src   = '';
        // Open a directory, and read its contents
        $src   = '';
        if (is_dir($dir)){
          if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){
            if(($file != ".") and ($file != "..")){
                        $files[] = $file; // put in array.
                }
 
            }
            closedir($dh);
          }
        }

    natsort($files); // sort.

    $src = '<div id="portfolio">';
    $i   = 0;
    foreach($files as $file) {

            $x  =$i++;
              $srcx          .='<div class="col-lg-1 col-md-2 col-xs-6 thumb img" style=" margin-bottom:2%; float:left; height:auto">
                                    <i class="fa fa-remove" style="color:red; border:1px solid #999; padding:1%; height:20px;"></i>
                                    <a class="thumbnail" href="#" style="margin-bottom:0" onCLick="return copyToClipboard('.$x.');">
                                        <img class="img-responsive" src="'.base_url().$dir.$file.'"  alt="" >
                                        <input type="hidden" value="'.base_url().$dir.$file.'" id="'.$x.'">
                                    </a>
                                    
                                </div>';

              $src          .='  <div class="tile scale-anm web all" style="margin-bottom:2%">
                                    <a href="'.base_url().'/tools/delete_image/?file='.$file.'" class="confirmation"><i class="fa fa-remove" style="color:red; border:1px solid #999; padding:1%; height:20px;"></i></a>
                                    <a class="thumbnail" href="#" style="margin-bottom:0" onCLick="return copyToClipboard('.$x.');">
                                        <img class="img-responsive" src="'.base_url().$dir.$file.'"  alt="" >
                                        <input type="hidden" value="'.base_url().$dir.$file.'" id="'.$x.'">
                                    </a>
                                    
                                </div>';
                                      }

        $tpl->assign(array(
            'BASE_URL'      => base_url(),
            'SRC'           => $src.'</div>',
        ));



        $tpl->assign(array(
            'BASE_URL'      => base_url(),
        ));
        
        
        $this->load->render_template($tpl);    
    }    


    function add_new_file(){

        $tpl = $this->load->template("upload_file.html");
        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
        ));
        
        
        $this->load->render_template($tpl);    
    }

    function act_upload_file(){
           $aConfig['upload_path']      = 'upload_data/';
           $aConfig['allowed_types']    = '*';
           $aConfig['overwrite']        = FALSE;     
           $this->load->library('upload');
           $ext = pathinfo($_FILES['namafile']['name'], PATHINFO_EXTENSION);
           $title   = $this->input->post('title');

           $_FILES['namafile']['name'] = date('Ymd').'_photo_'.$title.'.'.$ext;
           $this->upload->initialize($aConfig);
           if($this->upload->do_upload('namafile')){


            die("
                <script>
                alert('Upload Success!');
                window.location.replace('".base_url()."tools/list_image')
                </script>
                    ");


            }else{

                die('gagal upload photo');
            }

        }


        function delete_image(){
        $file     = $this->input->get('file');

        $file      = 'upload_data/'.$file;
        @unlink($file);
            die("
                <script>
                alert('Delete Success!');
                window.location.replace('".base_url()."tools/list_image')
                </script>
                    ");


        }

}
