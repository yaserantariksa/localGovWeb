<?php

/**
 * @author arshakariza
 * @copyright 2012
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dokter_mdl extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    

    function get_doctor(){
//        $this->db->debug =true;
        $adwhere  = '';
        if ($this->input->post('nama')!=''){
            $adwhere .= " AND upper(nama_dokter) like upper('%".$this->input->post('nama')."%')";
        }

        if ($this->input->post('did')!=''){
            $adwhere .= " AND a.did=".$this->input->post('did');
        }

        $sql    = $this->db->Query("select *,a.doctor_id as iddokter,coalesce(a.urutan,999999) as urut_dokter
                                             from doctor a 
                                                    LEFT JOIN department b ON (a.did=b.did) 
                                                    LEFT JOIN doctor_schedule c ON (a.doctor_id=c.doctor_id)
                                                    WHERE 1=1  
                                                    {$adwhere}
                                                    order by 
                                                    ABS(case when a.urutan =0 then 999999 else a.urutan end) ASC");
        return $sql;
    }

    function doctor_detail($doctor_id){
//$this->db->debug =true;
        $sql    = $this->db->Query("select *,a.doctor_id as iddokter,a.urutan as urutan_dokter
                                             from doctor a 
                                                    LEFT JOIN department b ON (a.did=b.did) 
                                                    LEFT JOIN doctor_schedule c ON (a.doctor_id=c.doctor_id) 
                                                    where a.doctor_id='".$doctor_id."'
                                                ");

/*echo '<pre>';
print_r($sql->fields);
echo 'idik : '.$sql->fields['start_senin'];
echo '</pre>';
echo $sql->fields['start_senin'];
*/
        return $sql;
    }

    function spesialis(){
//        $this->db->debug =true;

        $adwhere  = '';
        if ($this->input->post('nama')!=''){
            $adwhere = " where upper(name_real) like upper('%".$this->input->post('nama')."%')";
        }

        $res = $this->db->execute("select name_real,did from department {$adwhere} order by name_real ASC");
        
        return $res;

    }

    function act_save_dr($filename,$nama_dokter,$did,$doctor_id){

     //  $this->db->debug =true;

//        $this->db->StartTrans();
            $ssenin               = $this->input->post('ssenin'); //($this->input->post('ssenin'))?$this->input->post('ssenin'):'00:00:00';
            $sselasa              = $this->input->post('sselasa'); //($this->input->post('sselasa'))?$this->input->post('sselasa'):'00:00:00';
            $srabu                = $this->input->post('srabu'); //($this->input->post('srabu'))? $this->input->post('srabu'):'00:00:00';
            $skamis               = $this->input->post('skamis'); //($this->input->post('skamis'))?$this->input->post('skamis'):'00:00:00';
            $sjumat               = $this->input->post('sjumat'); //($this->input->post('sjumat'))?$this->input->post('sjumat'):'00:00:00';
            $ssabtu               = $this->input->post('ssabtu'); //($this->input->post('ssabtu'))?$this->input->post('ssabtu'):'00:00:00';
            $sminggu              = $this->input->post('sminggu'); //($this->input->post('sminggu'))?$this->input->post('sminggu'):'00:00:00';
            $esenin               = $this->input->post('esenin'); //($this->input->post('esenin'))?$this->input->post('esenin'):'00:00:00';
            $eselasa              = $this->input->post('eselasa'); //($this->input->post('eselasa'))?$this->input->post('eselasa'):'00:00:00';
            $erabu                = $this->input->post('erabu'); //($this->input->post('erabu'))? $this->input->post('erabu'):'00:00:00';
            $ekamis               = $this->input->post('ekamis'); //($this->input->post('ekamis'))?$this->input->post('ekamis'):'00:00:00';
            $ejumat               = $this->input->post('ejumat'); //($this->input->post('ejumat'))?$this->input->post('ejumat'):'00:00:00';
            $esabtu               = $this->input->post('esabtu'); //($this->input->post('esabtu'))?$this->input->post('esabtu'):'00:00:00';
            $eminggu              = $this->input->post('eminggu'); //($this->input->post('eminggu'))?$this->input->post('eminggu'):'00:00:00';

            $alsenin               = $this->input->post('alsenin'); //($this->input->post('esenin'))?$this->input->post('esenin'):'00:00:00';
            $alselasa              = $this->input->post('alselasa'); //($this->input->post('eselasa'))?$this->input->post('eselasa'):'00:00:00';
            $alrabu                = $this->input->post('alrabu'); //($this->input->post('erabu'))? $this->input->post('erabu'):'00:00:00';
            $alkamis               = $this->input->post('alkamis'); //($this->input->post('ekamis'))?$this->input->post('ekamis'):'00:00:00';
            $aljumat               = $this->input->post('aljumat'); //($this->input->post('ejumat'))?$this->input->post('ejumat'):'00:00:00';
            $alsabtu               = $this->input->post('alsabtu'); //($this->input->post('esabtu'))?$this->input->post('esabtu'):'00:00:00';
            $alminggu              = $this->input->post('alminggu'); //($this->input->post('eminggu'))?$this->input->post('eminggu'):'00:00:00';

            $dis_senin               = ($this->input->post('dis_senin')==1)?$this->input->post('dis_senin'):0;
            $dis_selasa              = ($this->input->post('dis_selasa')==1)?$this->input->post('dis_selasa'):0;
            $dis_rabu                = ($this->input->post('dis_rabu')==1)?$this->input->post('dis_rabu'):0;
            $dis_kamis               = ($this->input->post('dis_kamis')==1)?$this->input->post('dis_kamis'):0;
            $dis_jumat               = ($this->input->post('dis_jumat')==1)?$this->input->post('dis_jumat'):0;
            $dis_sabtu               = ($this->input->post('dis_sabtu')==1)?$this->input->post('dis_sabtu'):0;
            $dis_minggu              = ($this->input->post('dis_minggu')==1)?$this->input->post('dis_minggu'):0;

            $urutan              = $this->input->post('urutan');




        if ($doctor_id==''){
                    $sql    = $this->db->execute("INSERT INTO doctor (nama_dokter,did,photo,urutan)
                                        VALUES ('".$nama_dokter."','".$did."','".$filename."','".$urutan."')");

                    $ok      = $this->db->execute($sql);
                    $doctor_id = $this->db->GetOne("select max(doctor_id) from doctor");

                    $ok   = $this->db->execute("INSERT INTO doctor_schedule (doctor_id,start_senin,start_selasa,start_rabu,start_kamis,start_jumat,start_sabtu,start_minggu
                                                            ,end_senin,end_selasa,end_rabu,end_kamis,end_jumat,end_sabtu,end_minggu
                                                            ,alsenin,alselasa,alrabu,alkamis,aljumat,alsabtu,alminggu,
                                                            dis_senin,dis_selasa,dis_rabu,dis_kamis,dis_jumat,dis_sabtu,dis_minggu)
                                        VALUES 
                                            (".$doctor_id.",'".$ssenin."','".$sselasa."','".$srabu."','".$skamis."','".$sjumat."','".$ssabtu."','".$sminggu."',
                                             '".$esenin."','".$eselasa."','".$erabu."','".$ekamis."','".$ejumat."','".$esabtu."','".$eminggu."',
                                             '".$alsenin."','".$alselasa."','".$alrabu."','".$alkamis."','".$aljumat."','".$alsabtu."','".$alminggu."',
                                             ".$dis_senin.",".$dis_selasa.",".$dis_rabu.",".$dis_kamis.",".$dis_jumat.",".$dis_sabtu.",".$dis_minggu.")");


        }else{
            $addi = '';
            if ($filename!=''){
                $addi   = ",photo ='".$filename."'";
            }

        $sql    = $this->db->execute("UPDATE doctor SET 
                            nama_dokter = '".$nama_dokter."',
                            did ='".$did."',
                            urutan='".$urutan."'
                            ".$addi."
                            WHERE doctor_id='".$doctor_id."'");

        $cek_dr     = $this->db->getOne("delete from doctor_schedule where doctor_id=".$doctor_id);

                    $ok   = $this->db->execute("INSERT INTO doctor_schedule (doctor_id,start_senin,start_selasa,start_rabu,start_kamis,start_jumat,start_sabtu,start_minggu
                                                            ,end_senin,end_selasa,end_rabu,end_kamis,end_jumat,end_sabtu,end_minggu
                                                            ,alsenin,alselasa,alrabu,alkamis,aljumat,alsabtu,alminggu,
                                                            dis_senin,dis_selasa,dis_rabu,dis_kamis,dis_jumat,dis_sabtu,dis_minggu)
                                        VALUES 
                                            (".$doctor_id.",'".$ssenin."','".$sselasa."','".$srabu."','".$skamis."','".$sjumat."','".$ssabtu."','".$sminggu."',
                                             '".$esenin."','".$eselasa."','".$erabu."','".$ekamis."','".$ejumat."','".$esabtu."','".$eminggu."',
                                             '".$alsenin."','".$alselasa."','".$alrabu."','".$alkamis."','".$aljumat."','".$alsabtu."','".$alminggu."',
                                             ".$dis_senin.",".$dis_selasa.",".$dis_rabu.",".$dis_kamis.",".$dis_jumat.",".$dis_sabtu.",".$dis_minggu.")");


        }


    
//        $ok = $this->db->CompleteTrans();
            die("<script language='javascript'>alert('Doctor Saved!');window.location.replace('".base_url()."dokter/doctor')</script>");
          //  return $ok;

    }

    function delete_doctor($doctor_id){
//        $this->db->debug =true;
        $nama_file = $this->db->GetOne("SELECT photo FROM doctor where doctor_id=".$doctor_id);
        $file      = 'dokter/'.$nama_file;
        @unlink($file);
        $delet     = $this->db->Execute("delete from doctor where doctor_id=".$doctor_id);
        if ($delet){
            die("
                <script>
                alert('Delete Success!');
               window.location.replace('".base_url()."dokter/doctor')
                </script>
                    "); 

            }

    }

    function save_last_update($data){

        $ok     = $this->db->Execute("update last_update set data='".$data."'");

            die("
                <script>
                alert('Success!');
               window.opener.location.replace('".base_url()."dokter/doctor');
               window.close();
                </script>
                    "); 
    }

    function get_last(){
        $ok     = $this->db->getOne("select data from last_update");
        return $ok;
    }

    function get_max_urutan(){
        $ok     = $this->db->getOne("select max(urutan) from dokter");
        return $ok;
    }



    function upload_jadwal_dokter($filename){



      if ($_FILES['file_jadwal']['name']!=''){


        $nama_file = $this->db->GetOne("SELECT filename FROM jadwal_dokter_jadwal");
        $file      = 'jadwal_dokter/'.$nama_file;
        @unlink($file);


           $aConfig['upload_path']      = 'jadwal_dokter/';
           $aConfig['allowed_types']    = '*';
           $aConfig['overwrite']        = true;     
           $this->load->library('upload');
           $ext = pathinfo($_FILES['file_jadwal']['name'], PATHINFO_EXTENSION);

           $_FILES['file_jadwal']['name'] ='Jadwal_Dokter_Update.'.$ext;
           $this->upload->initialize($aConfig);
           $this->upload->do_upload('file_jadwal');
           $filename = $_FILES['file_jadwal']['name'];


        $ok         = $this->db->Execute("delete from jadwal_dokter_jadwal");
        $ok         = $this->db->Execute("INSERT INTO jadwal_dokter_jadwal (filename) VALUE ('".$filename."')");


        die("<script language='javascript'>alert('Upload Berhasil!');window.location.replace('".base_url()."dokter/doctor')</script>");

        }else{
            die("<script language='javascript'>alert('Tidak Ada File Untuk di Upload!');window.location.replace('".base_url()."dokter/doctor')</script>");
        }



    }
}
?>