<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author hasancx@yahoo.com
 * @copyright 2012
 */

class Dokter extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->users->authentication();
        $this->load->model('dokter_mdl');
	$this->load->model('menu_mdl');
	$this->load->model('modules_mdl');
        $this->load->library('../../controllers/main');
        $this->main->_head();
    }
    

    function doctor(){
        $tpl = $this->load->template("doctor.html");        
        $tpl->defineDynamicBlock('row');
        $res = $this->dokter_mdl->get_doctor();
        $res_dept = $this->dokter_mdl->spesialis();
        $did        = $this->input->post('did');
        $no =1;
        while(!$res->EOF)
        {

            $tpl->assignDynamic('row',array( 	
                  'VNO'                          => $no++,
                  'DOCTORID'                     => $res->fields['iddokter'],
                  'PHOTO'                        => ($res->fields['photo']!='')?$res->fields['photo']:'nopic.png',
                  'NAMA'                         => $res->fields['nama_dokter'],
                  'DEPT'                         => $res->fields['name_real'],
                  'URUTAN'                       => $res->fields['urut_dokter'],
                  'SENIN'                        => str_replace('00:00:00','','Jadwal 1 : <br>'.$res->fields['start_senin'].' <br>Jadwal 2 :  '.$res->fields['end_senin'].' <br>Jadwal 3 :  '.$res->fields['alsenin']),//str_replace('00:00:00','',$res->fields['start_senin']).'-'.str_replace('00:00:00','',$res->fields['end_senin'])),
                  'SELASA'                       => str_replace('00:00:00','','Jadwal 1 : <br>'.$res->fields['start_selasa'].' <br>Jadwal 2 :  '.$res->fields['end_selasa'].' <br>Jadwal 3 :  '.$res->fields['alselasa']),////str_replace('00:00:00','',$res->fields['start_selasa']).'-'.str_replace('00:00:00','',$res->fields['end_selasa'])),
                  'RABU'                         => str_replace('00:00:00','','Jadwal 1 : <br>'.$res->fields['start_rabu'].' <br>Jadwal 2 :  '.$res->fields['end_rabu'].' <br>Jadwal 3 :  '.$res->fields['alrabu']),//str_replace('00:00:00','',$res->fields['start_rabu']).'-'.str_replace('00:00:00','',$res->fields['end_rabu'])),
                  'KAMIS'                        => str_replace('00:00:00','','Jadwal 1 : <br>'.$res->fields['start_kamis'].' <br>Jadwal 2 :  '.$res->fields['end_kamis'].' <br>Jadwal 3 :  '.$res->fields['alkamis']),//str_replace('00:00:00','',$res->fields['start_kamis']).'-'.str_replace('00:00:00','',$res->fields['end_kamis'])),
                  'JUMAT'                        => str_replace('00:00:00','','Jadwal 1 : <br>'.$res->fields['start_jumat'].' <br>Jadwal 2 :  '.$res->fields['end_jumat'].' <br>Jadwal 3 :  '.$res->fields['aljumat']),//str_replace('00:00:00','',$res->fields['start_jumat']).'-'.str_replace('00:00:00','',$res->fields['end_jumat'])),
                  'SABTU'                        => str_replace('00:00:00','','Jadwal 1 : <br>'.$res->fields['start_sabtu'].' <br>Jadwal 2 :  '.$res->fields['end_sabtu'].' <br>Jadwal 3 :  '.$res->fields['alsabtu']),//str_replace('00:00:00','',$res->fields['start_sabtu']).'-'.str_replace('00:00:00','',$res->fields['end_sabtu'])),
                  'MINGGU'                       => str_replace('00:00:00','','Jadwal 1 : <br>'.$res->fields['start_minggu'].' <br>Jadwal 2 :  '.$res->fields['end_minggu'].' <br>Jadwal 3 :  '.$res->fields['alminggu']),////str_replace('00:00:00','',$res->fields['start_minggu']).'-'.str_replace('00:00:00','',$res->fields['end_minggu'])),
            ));
            
            $tpl->parseConcatDynamic('row');
            $res->movenext();
        }



        $tpl->assign(array(
            'DEPA'            => $res_dept->GetMenu2('did',$did,true,false,'','style="color:#333" class="form-control"'),
            'BASE_URL'      => base_url(),
            'NAMA'      => $this->input->post('nama'),
            'LAST'      => $this->dokter_mdl->get_last(),
        ));

        $this->load->render_template($tpl);
    }

    function addedit_doctor(){
        $doctor_id    = $this->input->get('doctor_id');
        $tpl = $this->load->template("add_doctor.html");

        if ($doctor_id!=''){
            $rs             = $this->dokter_mdl->doctor_detail($doctor_id);
            $nama_dokter          = $rs->fields['nama_dokter'];
            $photo                = $rs->fields['photo'];
            $urutan               = $rs->fields['urutan_dokter'];
            $did                  = $rs->fields['did'];
            $ssenin               = $rs->fields['start_senin'];
            $sselasa              = $rs->fields['start_selasa'];
            $srabu                = $rs->fields['start_rabu'];
            $skamis               = $rs->fields['start_kamis'];
            $sjumat               = $rs->fields['start_jumat'];
            $ssabtu               = $rs->fields['start_sabtu'];
            $sminggu              = $rs->fields['start_minggu'];
            $esenin               = $rs->fields['end_senin'];
            $eselasa              = $rs->fields['end_selasa'];
            $erabu                = $rs->fields['end_rabu'];
            $ekamis               = $rs->fields['end_kamis'];
            $ejumat               = $rs->fields['end_jumat'];
            $esabtu               = $rs->fields['end_sabtu'];
            $eminggu              = $rs->fields['end_minggu'];

            $alsenin               = $rs->fields['alsenin'];
            $alselasa              = $rs->fields['alselasa'];
            $alrabu                = $rs->fields['alrabu'];
            $alkamis               = $rs->fields['alkamis'];
            $aljumat               = $rs->fields['aljumat'];
            $alsabtu               = $rs->fields['alsabtu'];
            $alminggu              = $rs->fields['alminggu'];

            $chk_senin            = ($rs->fields['dis_senin']==1)?'checked="checked"':'';
            $chk_selasa           = ($rs->fields['dis_selasa']==1)?'checked="checked"':'';
            $chk_rabu             = ($rs->fields['dis_rabu']==1)?'checked="checked"':'';
            $chk_kamis            = ($rs->fields['dis_kamis']==1)?'checked="checked"':'';
            $chk_jumat            = ($rs->fields['dis_jumat']==1)?'checked="checked"':'';
            $chk_sabtu            = ($rs->fields['dis_sabtu']==1)?'checked="checked"':'';
            $chk_mingg            = ($rs->fields['dis_minggu']==1)?'checked="checked"':'';


        }else{
            $nama_dokter          = ""; 
            $photo                = "";
            $did                  = "";
            $ssenin               = "";
            $sselasa              = "";
            $srabu                = "";
            $skamis               = "";
            $sjumat               = "";
            $ssabtu               = "";
            $sminggu              = "";
            $esenin               = "";
            $eselasa              = "";
            $erabu                = "";
            $ekamis               = "";
            $ejumat               = "";
            $esabtu               = "";
            $eminggu              = "";
            $alsenin              = "";
            $alselasa             = "";
            $alrabu               = "";
            $alkamis              = "";
            $aljumat              = "";
            $alsabtu              = "";
            $alminggu             = "";

            $chk_senin            = "";
            $chk_selasa           = "";
            $chk_rabu             = "";
            $chk_kamis            = "";
            $chk_jumat            = "";
            $chk_sabtu            = "";
            $chk_mingg            = "";
            $urutan               = ""; // $this->dokter_mdl->get_max_urutan()+1;
        }

        if ($photo ==''){
            $photo = 'nopic.png';
        }


        $res_dept = $this->dokter_mdl->spesialis();

        $tpl->assign(array(
            'USER'          => $_SESSION['DATA_USER']['username'],
            'BASE_URL'      => base_url(),
            'NAMADOKTER'         => $nama_dokter,
            'PHOTO'         => $photo,
            'DOCTORID'        => $doctor_id,
            'DEPT'            => $res_dept->GetMenu2('did',$did,true,false,'','style="height:30px; color:#333"'),
            'URUTAN'            => $urutan,
            'SSENIN'            => $ssenin,
            'SSELASA'            => $sselasa,
            'SRABU'            => $srabu,
            'SKAMIS'            => $skamis,
            'SJUMAT'            => $sjumat,
            'SSABTU'            => $ssabtu,
            'SMINGGU'            => $sminggu,
            'ESENIN'            => $esenin,
            'ESELASA'           => $eselasa,
            'ERABU'             => $erabu,
            'EKAMIS'            => $ekamis,
            'EJUMAT'            => $ejumat,
            'ESABTU'            => $esabtu,
            'EMINGGU'           => $eminggu,
            'ALSENIN'            => $alsenin,
            'ALSELASA'           => $alselasa,
            'ALRABU'             => $alrabu,
            'ALKAMIS'            => $alkamis,
            'ALJUMAT'            => $aljumat,
            'ALSABTU'            => $alsabtu,
            'ALMINGGU'           => $alminggu,
            'chk_senin'         => $chk_senin,
            'chk_selasa'        => $chk_selasa,
            'chk_rabu'          => $chk_rabu,
            'chk_kamis'         => $chk_kamis,
            'chk_jumat'         => $chk_jumat,
            'chk_sabtu'         => $chk_sabtu,
            'chk_minggu'        => $chk_minggu,

        ));
        
        
        $this->load->render_template($tpl);    
    }


    function act_save_dr(){
       $nama_dokter   = $this->input->post('nama_dokter');
       $did   = $this->input->post('did');
       $doctor_id   = $this->input->post('doctor_id');
       $filename    = '';

      if ($_FILES['images']['name']!=''){
           $aConfig['upload_path']      = 'dokter/';
           $aConfig['allowed_types']    = '*';
           $aConfig['overwrite']        = true;     
           $this->load->library('upload');
           $ext = pathinfo($_FILES['images']['name'], PATHINFO_EXTENSION);

           $_FILES['images']['name'] = str_replace(' ','_',$nama_dokter).'.'.$ext;
           $this->upload->initialize($aConfig);
           $this->upload->do_upload('images');
           $filename = $_FILES['images']['name'];

        }

        $ok     = $this->dokter_mdl->act_save_dr($filename,$nama_dokter,$did,$doctor_id);


    }

    function delete_doctor(){

       $doctorid   = $this->input->get('doctor_id');

       $del        = $this->dokter_mdl->delete_doctor($doctorid);
    }

    function save_last_update(){
      $data   = str_replace('%20',' ',$this->uri->segment(3));
      $ok   = $this->dokter_mdl->save_last_update($data);
    }




    function upload_jadwal_act(){
          $ok   = $this->dokter_mdl->upload_jadwal_dokter();

    }
}
