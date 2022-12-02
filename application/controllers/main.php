<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author hasancx@yahoo.com
 * @copyright 2011
 */

class Main extends CI_Controller {
    
    public function __construct() {
        
        parent::__construct();
        
        $this->users->authentication();
        
        $this->load->model('menu_mdl');
        
    }
    
    public function index() {
        
        $tpl = $this->load->get_template('main_tpl.html');

        if(APP_SESSION=='CX_KLINIK')
        
            $header = 'Information System';

        else

            $header = 'APLIKASI PELATIHAN';
        
        $this->load->model('modules_mdl');

        $rs  = $this->modules_mdl->menu();
                            $submenu = '';
        while(!$rs->EOF)
            {

                $submenuname    =  $rs->fields['menu_name'];
                $submenulink    =  $rs->fields['menu_link'];
                $no=1;
                if($rs->fields['urutan']==1){
                    $sel    = 'sel';
                }else{
                    $sel    = '';
                }

                    // FOR SUB MENU NA NYAK!!!
                            $rs2    = $this->modules_mdl->get_submenu($submenulink);
                            $subm   = '<ul>';
                            while(!$rs2->EOF)
                                {
                                    $subm       .= '
                                                      <li>
                                                            <a  href="'.$rs2->fields['submenu_link'].'" target="masuk_sini">
                                                                <i class="'.$rs->fields['div'].'"></i>
                                                                <span>'.$rs2->fields['submenu_name'].'</span>
                                                            </a>
                                                      </li>';
                                    $rs2->movenext();
                                }

            $subm           .= '</ul>';

                            $submenu .= '<li class="cm-submenu">
                                              <a href="#"   class="'.$rs->fields['div'].'">'.$submenuname.'</a>
                                '.$subm.'
                            </li>';

                $rs->movenext();
            }



        $tpl->assign(array(
            'VSUBMENU'      => $submenu,
            'HEADER' => $header,
            'BASEURL' => base_url(),
            'VUSER' => $_SESSION['DATA_USER']['username'],

        ));
        
        $tpl->render();
    }


    public  function _head(){

        $tpl = $this->load->get_template('header_script.html');

        if(APP_SESSION=='CX_KLINIK')
        
            $header = 'Information System';

        else

            $header = 'APLIKASI PELATIHAN';
        
        $this->load->model('modules_mdl');

        $rs  = $this->modules_mdl->menu();
                            $submenu = '';
        while(!$rs->EOF)
            {

                $submenuname    =  $rs->fields['menu_name'];
                $submenulink    =  $rs->fields['menu_link'];
                $no=1;
                if($rs->fields['urutan']==1){
                    $sel    = 'sel';
                }else{
                    $sel    = '';
                }

                    // FOR SUB MENU NA NYAK!!!
                            $rs2    = $this->modules_mdl->get_submenu($submenulink);
                            $subm   = '<ul>';
                            while(!$rs2->EOF)
                                {
                                    $subm       .= '
                                                      <li>
                                                            <a  href="'.$rs2->fields['submenu_link'].'" target="masuk_sini">
                                                                <i class="'.$rs->fields['div'].'"></i>
                                                                <span>'.$rs2->fields['submenu_name'].'</span>
                                                            </a>
                                                      </li>';
                                    $rs2->movenext();
                                }

            $subm           .= '</ul>';

                            $submenu .= '<li class="cm-submenu">
                                              <a href="#"   class="'.$rs->fields['div'].'">'.$submenuname.'</a>
                                '.$subm.'
                            </li>';

                $rs->movenext();
            }



        $tpl->assign(array(
            'VSUBMENU'      => $submenu,
            'HEADER' => $header,
            'BASEURL' => base_url(),
            'VUSER' => $_SESSION['DATA_USER']['username'],

        ));
        
        $tpl->render();

    }
    
    function blank($id=''){

	$tpl = $this->load->get_template('info_modul.html');
        
        $tpl->assign(array(
            'BASEURL' => base_url(),
            'modul' => urldecode($id)
        ));
        
        $tpl->render();
    }
    
    /**
     *  function footer berisi start menu/menu utama
     */
    public function footer() {
        
        $tpl = $this->load->get_template('menu.html');
        
        $res = $this->menu_mdl->get_main_menu();
        
        if($res->EOF) $tpl->assign('record','');
        
        while(!$res->EOF)
        {
            $tpl->assignDynamic('record',array(
                'VMMID' => $res->fields['mmid'],
                'VMENU' => $res->fields['menu'],
                'VLINK' => $res->fields['link'],
                'VIMAGES'=> base_url().$res->fields['images']
            ));
            
            $tpl->parseConcatDynamic('record');
            $res->movenext();
        }
        
        $tpl->assign('BASEURL', base_url());
        
	    $tpl->render();
        
    }
    
    function _generate_submenu($data, $parent = 0) {
    
        static $i = 1;
    	$tab = str_repeat("\t\t", $i);
    	if (isset($data[$parent])) {
    		$html = "\n$tab<ul class='navcx'>";
    		$i++;
    		foreach ($data[$parent] as $v) {
    			$child = $this->_generate_submenu($data, $v['msid']);
    			$html .= "\n\t$tab<li>";
                //if($v['link']=='#')
                //    $html .= '<b>'.$v['submenu'].'</b>';
               // else
                    $html .= '<a href="{BASEURL}'.$v['link'].'" target="contentcx">'.$v['submenu'].'</a>';
    			if ($child) {
    				$i--;
    				$html .= $child;
    				$html .= "\n\t$tab";
    			}
    			$html .= '</li>';
    		}
    		$html .= "\n$tab</ul>";
    		return $html;
    	} else {
    		return false;
    	}
    }
    
    public function get_submenu($mmid=0) {
        
        $tpl = $this->load->get_template("submenu.html");
        
        //kalau admin buka semua menu
        //if($_SESSION['DATA_USER']['is_admin']=='1') $mmid = 1;
        
        $res = $this->menu_mdl->get_submenu($mmid);
        
        $data = array();
        while(!$res->EOF)
        {
            $data[$res->fields['msid_parent']][] = $res->fields;
            
            $res->moveNext();
        }
      
        $submenu = $this->_generate_submenu($data);
        
        $tpl->assign(array(
            'VSUBMENU'  => $submenu,
            'BASEURL'  => base_url()        
        ));
        
        $tpl->render();
    }
    
    public function content() {
        $tpl = $this->load->get_template('main.html');
        
        $tpl->assign('BASEURL', base_url());
        $tpl->assign('test',$_SESSION['DATA_USER']['pid']);
        $this->load->render_template($tpl); 
    
    }


    function depan(){

        $this->dashboard();
    }

    function dashboard(){


        $tpl = $this->load->get_template('dashboard.html');
        $tpl->assign('BASEURL', base_url());
        
        $tpl->render();
    }



    
}

?>
