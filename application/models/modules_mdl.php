<?php

/**
 * @author dikdik@yahoo.com
 * @copyright 2012
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modules_mdl extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    


    function menu() {
//       $this->db->debug =true;
        


        $sql            = "SELECT a.amid,a.menu_name,a.menu_link,a.urutan,a.div
                                FROM appmenu a
                                LEFT JOIN appsubmenu b ON (a.amid = b.amid)

                                GROUP BY a.amid,a.menu_name,a.menu_link,a.urutan,a.div
                                ORDER BY a.urutan asc";
        $rs=$this->db->Execute($sql);

        return $rs;        
    }
        
    function get_submenu($menuheader) {
       //$this->db->debug =1;

        $res        = $this->db->execute("SELECT amid FROM appmenu WHERE menu_link='".$menuheader."'");
        $parent     = $res->fields['amid'];
        
                $res = $this->db->execute("SELECT *
                                                    FROM appsubmenu a
                                                    WHERE a.amid = ".$parent." ORDER BY urutan ");
        
        return $res;
    }
    

    function get_history_visite($id)
    {
    	//$this->db->debug = true;
    	$sql = "SELECT a.pregid, a.pid, b.name_formal FROM patient_reg a, department b WHERE a.did=b.did AND a.is_discharged IS NOT TRUE AND a.pid={$id}";
    	$res = $this->db->execute($sql);
        return $res;
    }

    function cbGroup()
    {
        $res = $this->db->execute("SELECT groupname, igid FROM insurance_group ORDER BY UPPER(groupname)");
        return $res;
    }

    function cbCoaBank()
    {
        $res = $this->db->execute("SELECT coacode || ' - ' || coaname, mcoaid FROM m_coa WHERE is_bank='t' ORDER BY UPPER(coacode || ' - ' || coaname)");
        return $res;
    }

    function cbCoaAsset()
    {
        $res = $this->db->execute("SELECT coacode || ' - ' || coaname, mcoaid FROM m_coa WHERE id_group=1 ORDER BY UPPER(coacode || ' - ' || coaname)");
        return $res;
    }

    function cbInsurance()
    {
        $res = $this->db->execute("SELECT insurance_name, insid FROM insurance ORDER BY UPPER(insurance_name)");
        return $res;
    }    

    function getInsuranceName($insid)
    {
        $res = $this->db->GetOne("SELECT insurance_name, insid FROM insurance WHERE insid={$insid}");
        return $res;
    }    

    function cbTipeInsurance()
    {
        $res = $this->db->execute("SELECT type_name, itid FROM insurance_type ORDER BY UPPER(type_name)");
        return $res;
    }

    function cb_group_asuransi()
    {
        $sql_asuransi = "select groupname,igid from insurance_group order by lower(groupname)";
        $res = $this->db->execute($sql_asuransi);
        return $res;
    }

    function get_group_name($igid)
    {
        $sql = "select groupname from insurance_group where igid={$igid}";
        $res = $this->db->GetOne($sql);
        return $res;
    }

    function get_dept_name($did)
    {
        $sql = "select name_formal from department where did={$did}";
        $res = $this->db->GetOne($sql);
        return $res;
    }

    function get_type_name($ttid)
    {
        $sql = "select type_name from tarif_type where ttid={$ttid}";
        $res = $this->db->GetOne($sql);
        return $res;
    }

    function cb_tipe_tarif()
    {
        $sql_tipe = "select type_name,ttid from tarif_type order by lower(type_name)";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function dataPoli()
    {
        //$this->db->debug = 1;
        $sql_tipe = "select name_formal,did from department where is_del is not true  order by lower(name_formal)";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function PoliDoc($did)
    {
        $sql_tipe = "select a.nama, a.pid from person a join doctor_department b on b.pid=a.pid where a.etid=2 and b.did={$did} order by lower(nama)";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function dataPoliGetOne($did)
    {
        //$this->db->debug = 1;
        $sql_tipe = "select name_formal,did from department where is_del is not true AND did={$did} order by lower(name_formal)";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function getIdDeptFromConfig($mfilter)
    {
        //$this->db->debug = 1;
        $sql = "select mark from m_conf where mfilter='{$mfilter}'";
        $res = $this->db->GetOne($sql);
        return $res;
    }

    function docSchedule($did, $pid)
    {
        $sql_tipe = "select a.dsid, a.start_hour || ':' || a.start_minute || ' - ' || a.end_hour || ':' || a.end_minute as jam_praktek, a.daily_room, a.weekday from doc_schedule a where a.pid=$pid and a.did=$did";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function cbPoli()
    {
        
        //$this->db->debug = 1;
        $sql_tipe = "select name_formal,did from department where is_del is not true and dtid=1 order by lower(name_formal)";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function cbPoliDoc($did)
    {
        //$this->db->debug = 1;
        if(!$did) $did = -1;
        $sql_tipe = "select a.nama, a.pid from person a join doctor_department b on b.pid=a.pid where a.etid=2 and b.did={$did} order by lower(nama)";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function cbPoliPegawai($did)
    {
        //$this->db->debug = 1;
        if(!$did) $did = -1;
        $sql_tipe = "select a.nama, a.pid from person a join doctor_department b on b.pid=a.pid where b.did={$did} order by lower(nama)";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function cbHari()
    {
        $sql_tipe = "select 'Minggu', '0' as id UNION ALL select 'Senin', '1' UNION ALL select 'Selasa', '2' UNION ALL select 'Rabu', '3' UNION ALL select 'Kamis', '4' UNION ALL select 'Jumat', '5' UNION ALL select 'Sabtu', '6'";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function cbJam()
    {
        $sql_tipe = "";
        for($jam=0;$jam<24;$jam++) 
            $sql_tipe .= " select '".str_pad($jam, 2, "0", STR_PAD_LEFT)."' as nama, '".str_pad($jam, 2, "0", STR_PAD_LEFT)."' as id union all";
        $sql_tipe = rtrim($sql_tipe, ' union all');

        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function cbMenit()
    {
        $sql_tipe = "";
        for($menit=0;$menit<60;$menit++)
            $sql_tipe .= " select '".str_pad($menit, 2, "0", STR_PAD_LEFT)."' as nama, '".str_pad($menit, 2, "0", STR_PAD_LEFT)."' as id union all";
        $sql_tipe = rtrim($sql_tipe, ' union all');

        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function cbDoc()
    {

        //$this->db->debug = 1;

        $sql_tipe = "select a.nama, a.pid from person a where a.etid IN(2,5) AND a.is_active is true order by lower(a.nama)";

        $res = $this->db->execute($sql_tipe);

        return $res;
        
    }

    function cb_coa()
    {
        $sql_tipe = "select a.coacode || ' - ' || a.coaname, a.mcoaid from m_coa a where a.is_active is true order by lower(a.coacode || ' - ' || a.coaname)";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function get_cost_center()
    {
        $sql_tipe = "select a.kode_rncc || ' ' || a.nama_rncc, a.rnccid from rnc_center a where a.is_active is true order by lower(a.kode_rncc || ' ' || a.nama_rncc)";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function cbHubPegawai()
    {
        $sql = "select 'Suami' as nama,'Suami' as id union all
                select 'Istri', 'Istri' union all
                select 'Ayah', 'Ayah' union all
                select 'Ibu', 'Ibu' union all
                select 'Anak Pertama', 'Anak Pertama' union all
                select 'Anak Kedua', 'Anak Kedua' union all
                select 'Anak Ketiga', 'Anak Ketiga' union all
                select 'Saudara Kandung Laki-laki', 'Saudara Kandung Laki-laki' union all
                select 'Saudara Kandung Perempuan', 'Saudara Kandung Perempuan' union all
                select 'Sendiri', 'Sendiri' union all
                select 'Lain-Lain', 'Lain-Lain'";
        $res = $this->db->execute($sql);
        return $res;
    }

    function cbDept()
    {
        
        //$this->db->debug = 1;
        $sql_tipe = "select name_formal,did from department where is_del is not true order by lower(name_formal)";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function cbClassOne($csid)
    {        
        //$this->db->debug = 1;
        $sql_tipe = "select class_name,csid from class_stay where is_active is true and csid={$csid} order by urutan";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function cbClass()
    {        
        //$this->db->debug = 1;
        $sql_tipe = "select class_name, csid from class_stay where is_active is true order by csid";
        $res = $this->db->execute($sql_tipe);
        return $res;
    }

    function _get_info_conf($mcgid) {

        $info = array();

        $sql = "SELECT mfilter, mark FROM m_conf WHERE mcgid={$mcgid}";

        $rs = $this->db->Query($sql);

        while(!$rs->EOF)
        {

            $info[$rs->fields['mfilter']] = $rs->fields['mark'];

            $rs->moveNext();

        }
        
        return $info; 
    }

    function get_detail_user(){
        return $this->db->Query("SELECT message, b.avatar FROM cometchat_status a, app_users b WHERE a.userid=b.pid AND a.userid=".$_SESSION['DATA_USER']['pid']);        
    }

    function cbRM()
    {
        
        //$this->db->debug = 1;
        $sql = "select ('(' || func_rm(pid) || ') ' || coalesce(name_real,'')) as name_real,pid
                from patient where is_del is not true order by lower(name_real)";
        $res = $this->db->execute($sql);
        return $res;
    }

    function getValueRM()
    {

        $pid = $this->input->post('pid');

        $sql = "select func_rm(pid) as norm,identification_cards,
                    place_of_birth,date_of_birth, (case when gender='m' then 'Laki-laki' else 'Perempuan' end) as gender,
                    marital_status, religion, email, 
                    address, mobile_number
                from patient where pid={$pid}";
        $res = $this->db->execute($sql);
        return $res;

    }

    function _authentication($hhid)
    {

        //if($_SESSION['DATA_USER']['pid']==1) $this->db->debug = 1;

        $username = $_SESSION['DATA_USER']['username'];

        $userpass = $this->input->post('userpass');

        $keterangan = $this->input->post('keterangan');

        $create_id = $_SESSION['DATA_USER']['pid'];


        $sql = "SELECT asid FROM app_users WHERE username='{$username}' AND userpass=md5('{$userpass}')";

        $rs = $this->db->query($sql);

        if($rs->EOF)

            return 2; // salah password

        else
        {

            $sqli = "INSERT INTO hist (hhid,keterangan,create_id) VALUES ({$hhid},'{$keterangan}',{$create_id})";

            $ok = $this->db->execute($sqli);

            if($ok) return 1; // ok
            else return 3; // salah query

        }

    }

    function cbLabGroup()
    {

        //$this->db->debug = 1;
        $sql_tipe = "select mlgname, mlgid from m_laboratorium_group order by no_urut";

        $res = $this->db->execute($sql_tipe);

        return $res;

    }

    function cbRadGroup()
    {
        
        //$this->db->debug = 1;
        $sql_tipe = "select mrgname, mrgid from m_radiologi_group order by no_urut";

        $res = $this->db->execute($sql_tipe);

        return $res;

    }

    function cbOkGroup()
    {
        
        //$this->db->debug = 1;
        $sql_tipe = "select morjnama, morjid from m_orj order by morjnama";

        $res = $this->db->execute($sql_tipe);

        return $res;

    }
    
}

?>
