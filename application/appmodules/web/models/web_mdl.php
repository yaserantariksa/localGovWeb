<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author dharmadhiester
 * @copyright 2012
 */

class Web_mdl extends CI_Model{
    
    function __construct(){
        
        parent::__construct();
    }

    function aboutus(){

        $rs     = $this->db->getOne("select aboutus from aboutus");
        return $rs;

    }

    function filejadwal(){

        $rs     = $this->db->getOne("select filename  from jadwal_dokter_jadwal");
        return $rs;

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

    function get_kat(){
//        $this->db->debug =true;
        $rs     = $this->db->query("select *  from kat_gallery order by nama_kategori ASC");
        return $rs;
    }

    function get_kat_lay(){
        $rs     = $this->db->query("select *  from layanan_kat WHERE header IS NULL OR header < 1 /* and lkid not in (2,3) */ order by urutan ASC");
        return $rs;
    }

    function get_tentang(){
        $this->db->debug =true;
        $rs     = $this->db->query("select *  from tentang order by tid ASC");
        return $rs;
    }

    function get_kat_lay_sub($lkid){
//        $this->db->debug =true;
        $rs     = $this->db->query("select *  from layanan_kat WHERE header='".$lkid."'  order by urutan ASC");
        return $rs;
    }

    function get_karir(){
  //      $this->db->debug =true;
        $rs     = $this->db->query("select *  from lowongan  order by loid DESC");
        return $rs;
    }
    function get_penjamin_perusahaan(){
  //      $this->db->debug =true;
        $rs     = $this->db->query("select *  from penjamin WHERE kode = 'PERUSAHAAN' -- order by loid ASC");
        return $rs;
    }
    function get_penjamin_asuransi(){
  //      $this->db->debug =true;
        $rs     = $this->db->query("select *  from penjamin WHERE kode = 'ASURANSI' -- order by loid ASC");
        return $rs;
    }
    

    function get_last_penjamin(){
        $ok     = $this->db->getOne("select data from last_update_penjamin");
        return $ok;
    }

    function get_last_karir(){
        $ok     = $this->db->getOne("select data from last_update_karir");
        return $ok;
    }


    function get_kat_gal($kgid){

        $addsql         = 'where 1=2';
        if ($kgid !=''){
            $addsql     = " where a.kgid=".$kgid;
        }

        $rs     = $this->db->query("select *  from gallery a LEFT JOIN kat_gallery b ON (a.kgid=b.kgid)  ".$addsql." order by a.urutan ASC");
        return $rs;
    }

    function get_tentang_kontent(){
//        $this->db->debug =true;

        $rs     = $this->db->query("select *  from tentang");
        return $rs;
    }

    function get_kelurahan(){
//      $this->db->debug =true;

        $rs     = $this->db->query("select *  from data_kelurahan ORDER BY nama_kelurahan ASC");
        return $rs;
    }

    function get_kelurahan_detail($dkid){
//      $this->db->debug =true;

        $rs     = $this->db->query("select *  from data_kelurahan WHERE dkid=".$dkid);
        return $rs;
    }

        function get_kat_lay2($lkid){
        $addsql         = ' and a.lkid=-1 --  ORDER BY RAND() LIMIT 30';
        if ($lkid !=''){
            $addsql     = " AND a.lkid=".$lkid;
        }

        $rs     = $this->db->query("select *  from layanan a LEFT JOIN layanan_kat b ON (a.lkid=b.lkid) where 1=1 ".$addsql);
        return $rs;
    }

    function get_slide(){
        $rs     = $this->db->query("select *  from slider order by slide_id DESC");
        return $rs;
    }

    function get_promo(){
        $rs     = $this->db->query("select *  from promo order by proid DESC");
        return $rs;
    }


    function get_layanan(){
        $rs     = $this->db->query("select *  from layanan where lkid=1 order by lid desc limit 6");
        return $rs;
    }

    function get_dokter(){

        $rs     = $this->db->query("select *  from doctor a LEFT JOIN department b ON (a.did=b.did) order by doctor_id DESC");
        return $rs;
    }

    function get_dokter_front(){
        $rs     = $this->db->query("select *  from doctor a 
                                            LEFT JOIN department b ON (a.did=b.did) 
                                            LEFT JOIN doctor_schedule c ON (a.doctor_id=c.doctor_id) 
                                           order by rand() LIMIT 4");

//        $rs     = $this->db->query("select *  from doctor a LEFT JOIN department b ON (a.did=b.did) order by rand() LIMIT 4");
        return $rs;
    }

    function get_dokter_search($did,$namadokter){
//        $this->db->debug =true;
        $addsql = 'WHERE 1=1';
        if ($did!=''){
            $addsql .= " AND b.did=".$did;
        }

        if ($namadokter!=''){
            $addsql .= " AND upper(nama_dokter) like upper('%".$namadokter."%')";
        }
        $rs     = $this->db->query("select *  from doctor a 
                                            LEFT JOIN department b ON (a.did=b.did) 
                                            LEFT JOIN doctor_schedule c ON (a.doctor_id=c.doctor_id) 
                                            ".$addsql." order by b.urutan asc,
                                             ABS(case when a.urutan =0 then 999999 else a.urutan end) ASC
                                             ");
        return $rs;
    }


    function show_layanan($lid){
        $rs     = $this->db->query("select *  from layanan where lid=".$lid);
        return $rs;
    }


    function news_detail($title){
        $rs     = $this->db->query("select *  from news where title='".$title."'");
        return $rs;
    }

    function show_news($news_id){
        $rs     = $this->db->query("select *  from news where news_id=".$news_id);
        return $rs;
    }

    function show_unggulan($lid){
        $rs     = $this->db->query("select *  from layanan where lid=".$lid);
        return $rs;
    }

    function get_news(){
        $rs     = $this->db->query("select *  from news  order by news_id DESC LIMIT 6");
        return $rs;
    }

    function news_detail_depan(){
        $rs     = $this->db->query("select *  from news  order by news_id DESC LIMIT 1");
        return $rs;
    }

    function get_all_news($data,$istot=false,$offset=0,$paging=10){
//        $this->db->debug =true;
        $lp= " limit ".$paging." OFFSET ".$offset;


        $sql     = "select *  from news  order by news_id DESC";

       if ($istot==false)
                {$sqlx = $sql.$lp;}
                else
                {$sqlx = $sql;}
        $rs=$this->db->Execute($sqlx);
        return $rs;       


    }

    function get_last(){
        $ok     = $this->db->getOne("select data from last_update");
        return $ok;
    }

    
} //END class
