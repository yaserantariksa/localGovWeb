<?php

function get_list_satuan($data,$id, $def_value='',$options=''){
        
    $data = explode(';',$data);
    
    $list = '<select name="kode_satuan[]" id="kode_satuan_'.$id.'" '.$options.'>';
    
    if(is_array($data))
    foreach ($data as $key => $value){
        
        if($def_value==$value)
        $list .='<option value="'.$value.'" selected="selected">'.$value.'</option>';
        else
        $list .='<option value="'.$value.'">'.$value.'</option>';
    }
    
    $list .= '</select>';
    
    return $list;
}

function get_paging($page=0, $record_count=0, $form='',$rows=PAGE_ROWS){
    
    $paging = '';
    
    if($page==0){
        
        //if($record_count > 0 AND $rows==$record_count)
        $paging = '<div class="wrap_page"><span class="cxpage_disabled"><< Prev</span> <input type="text" class="cxpage_textbox" name="page" id="cxpage" size="3" value="'.($page+1).'" data-form="'.$form.'"/> <span id="nextpage" class="cxpage" data-page="'.$page.'" data-form="'.$form.'">Next >></span></div>';
    }
    elseif($rows>$record_count){
        $paging = '<div class="wrap_page"><span id="prevpage" class="cxpage" data-page="'.$page.'" data-form="'.$form.'"><< Prev</span> <input type="text" class="cxpage_textbox" name="page" id="cxpage" size="3" value="'.($page+1).'" data-form="'.$form.'"/> <span class="cxpage_disabled">Next >></span></div>';
    }
    else{
        $paging = '<div class="wrap_page"><span id="prevpage" class="cxpage" data-page="'.$page.'" data-form="'.$form.'"><< Prev</span> <input type="text" class="cxpage_textbox" name="page" id="cxpage" size="3" value="'.($page+1).'" data-form="'.$form.'" /> <span id="nextpage" class="cxpage" data-page="'.$page.'" data-form="'.$form.'">Next >></span></div>';
    }
    
    return $paging;
}

function paging_jqgrid($rows,$total_rows,$page){
    
    $result = array();
    $result['page'] = $page;
    $result['total'] = ($total_rows < $rows)?$page:-1;
    $result['records'] = $total_rows;
    return $result;
}

function get_nama_bulan($id){
        
    $list_bulan[1]  = 'Januari';
    $list_bulan[2]  = 'Februari';
    $list_bulan[3]  = 'Maret';
    $list_bulan[4]  = 'April';
    $list_bulan[5]  = 'Mei';
    $list_bulan[6]  = 'Juni';
    $list_bulan[7]  = 'Juli';
    $list_bulan[8]  = 'Agustus';
    $list_bulan[9]  = 'September';
    $list_bulan[10] = 'Oktober';
    $list_bulan[11] = 'November';
    $list_bulan[12] = 'Desember';
    
    return $list_bulan[$id];
}

function get_bulan(){
    
    $list_bulan[1]  = 'Januari';
    $list_bulan[2]  = 'Februari';
    $list_bulan[3]  = 'Maret';
    $list_bulan[4]  = 'April';
    $list_bulan[5]  = 'Mei';
    $list_bulan[6]  = 'Juni';
    $list_bulan[7]  = 'Juli';
    $list_bulan[8]  = 'Agustus';
    $list_bulan[9]  = 'September';
    $list_bulan[10] = 'Oktober';
    $list_bulan[11] = 'November';
    $list_bulan[12] = 'Desember';
    
    return $list_bulan;
}

function doc_id($jtid, $id){
        
    $CI = & get_instance();
    
    $res = $CI->adodb->db()->execute("SELECT * FROM general_ledger WHERE jtid=$jtid AND reff_id=$id");
    
    if($res->EOF) return array('','');
    $result = array();
    
    $result[0] = 'Doc ID '.date('y',strtotime($res->fields['tgl_jurnal'])).'-'.$jtid.'-'.str_pad($res->fields['id_doc'],6,'0',STR_PAD_LEFT);
    
    $result[1] = $res->fields['id'];
    
    $result[2] = date('y',strtotime($res->fields['tgl_jurnal'])).'-'.$jtid.'-'.str_pad($res->fields['id_doc'],6,'0',STR_PAD_LEFT);
 
    return $result;
}

function get_kota_rs(){
        
    $CI = & get_instance();
    
    $kota = $CI->adodb->db()->getOne("SELECT data FROM config WHERE key='kota_rs' LIMIT 1");
         
    return $kota;
}

function stock_queue(){
    
    return "SELECT data FROM config WHERE key='STOCK_QUEUE' FOR UPDATE";
}

function get_norm($pid){
    
    if($pid==0) 
        return 'OTC';
    else{
	if(strlen($pid) <=6){
            $str = str_pad($pid, 6, "0", STR_PAD_LEFT);    
            $ret = substr($str,0,2) .'-'. substr($str,2,2) .'-'. substr($str,4,2);
        }
        else{
            $str = str_pad($pid, 8, "0", STR_PAD_LEFT);
            $ret = substr($str,0,2) .'-'. substr($str,2,2) .'-'. substr($str,4,2) .'-'. substr($str,6,2);
        }
        return $ret;
    } 
}

function rm_to_pid($norm){
    
    $pid = str_replace("-","",$norm);
    
    if($pid=='OTC')
        return 0;
    else{
        return $pid*1;
    }
}

function get_next_noreg(){
    
    $CI = & get_instance();
    
    $no_reg = $CI->adodb->db()->getOne("SELECT MAX(substr(no_reg,7)) FROM patient_reg WHERE date(pregdate)= DATE('now()')")+1;
    $no_reg = str_pad($no_reg,4,'0',STR_PAD_LEFT);
    $no_reg = date('ymd').''.$no_reg;
    return $no_reg;
}

function get_umur($birthday, $tgl='today') {
    $age = date_create($birthday)->diff(date_create($tgl))->m;
    
    $date1 = new DateTime($birthday);
    $date2 = new DateTime("today");
    $interval = $date1->diff($date2);
    $age =  $interval->y . "thn, " . $interval->m."bln, ".$interval->d."hr"; 

    return $age;
}

function angka_romawi($num) 
{
	$n = intval($num);
	$res = '';
	 /*** roman_numerals array  ***/
	$roman_numerals = array(
				'M'  => 1000,
				'CM' => 900,
				'D'  => 500,
				'CD' => 400,
				'C'  => 100,
				'XC' => 90,
				'L'  => 50,
				'XL' => 40,
				'X'  => 10,
				'IX' => 9,
				'V'  => 5,
				'IV' => 4,
				'I'  => 1
	);
	
	foreach ($roman_numerals as $roman => $number) 
	{
		/*** divide to get  matches ***/
		$matches = intval($n / $number);
		 /*** assign the roman char * $matches ***/
		$res .= str_repeat($roman, $matches);
		 /*** substract from the number ***/
		$n = $n % $number;
	}
	/*** return the res ***/
	return $res;
}

function terbilang($satuan){ 
    
    $huruf = array ("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh","sebelas"); 
    
    if ($satuan < 12) 
        return " ".$huruf[$satuan]; 
    elseif ($satuan < 20) 
        return terbilang($satuan - 10)." belas"; 
    elseif ($satuan < 100) 
        return terbilang($satuan / 10)." puluh".terbilang($satuan % 10); 
    elseif ($satuan < 200) 
        return " seratus".terbilang($satuan - 100); 
    elseif ($satuan < 1000) 
        return terbilang($satuan / 100)." ratus".terbilang($satuan % 100); 
    elseif ($satuan < 2000) 
        return " seribu".terbilang($satuan - 1000); 
    elseif ($satuan < 1000000) 
        return terbilang($satuan / 1000)." ribu".terbilang($satuan % 1000); 
    elseif ($satuan < 1000000000) 
        return terbilang($satuan / 1000000)." juta".terbilang($satuan % 1000000); 
    elseif ($satuan >= 1000000000) 
        echo " Miliyar".terbilang($satuan % 1000000000); 
}

function _check_pass($logname,$pass,$pid)
{
    $CI = & get_instance();

    $sql = "SELECT asid 
            FROM app_users 
            WHERE username='{$logname}' 
                    AND userpass='".md5($pass)."' 
                    AND pid='{$pid}'";

    $ispass = $CI->adodb->db()->getOne($sql);

    return $ispass;
}

function _check_reg_active($pregid)
{
    $CI = & get_instance();
    //$CI->adodb->db()->debug = 1;
    $msg = array();
    $msg['ispass'] = true;

    // cek pasien keluar
    $sql = "SELECT pregid FROM patient_reg WHERE is_discharged='t' AND pregid={$pregid}";
    $rs = $CI->adodb->db()->execute($sql);
    if(!$rs->EOF) {
        $msg['ispass'] = false;
        $msg['err'] = 'Pasien sudah keluar';
    }

    /*
    // cek sudah ada pembayaran
    $sql = "SELECT ppid FROM payment_patient WHERE pregid={$pregid}";
    $rs = $CI->adodb->db()->execute($sql);
    if(!$rs->EOF) {
        $msg['ispass'] = false;
        $msg['err'] = 'Pasien sudah ada pembayaran';
    }

    // cek sudah ada konfirmasi bill
    $sql = "SELECT ipid FROM inv_patient WHERE pregid={$pregid}";
    $rs = $CI->adodb->db()->execute($sql);
    if(!$rs->EOF) {
        $msg['ispass'] = false;
        $msg['err'] = 'Pasien sudah ada konfirmasi tagihan';
    }
    */

    return $msg;
}

function _get_data_regis($pregid)
{
    $CI = & get_instance();

    //$CI->adodb->db()->debug = 1;

    $sql = "SELECT a.*,
                    func_rm(b.pid) as norm,
                    (CASE WHEN a.pid=0 THEN a.nama_otc ELSE b.name_real END) as name_real 
            FROM patient_reg a
                JOIN patient b ON b.pid=a.pid
            WHERE a.pregid=$pregid";
    $sql = "SELECT a.*,
                    func_rm(b.pid) as norm,
                    (CASE WHEN a.pid=0 THEN a.nama_otc ELSE b.name_real END) as name_real, 
                    (CASE WHEN a.is_inpatient='t' THEN 
                            COALESCE(d.class_name,'') || ' - ' || COALESCE(d.room_name,'')  || ' ' || COALESCE(d.bed_nr,'')
                    ELSE 
                            c.name_formal 
                    END) as ruang,
                    f.nama as doctor,
                    e.insurance_name as penjamin
            FROM patient_reg a
                INNER JOIN patient b ON b.pid=a.pid
                INNER JOIN department c ON a.did=c.did
                LEFT JOIN v_class d ON d.cbid=a.cbid                           
                LEFT JOIN insurance e on e.insid=a.insid
                INNER JOIN person f ON f.pid=a.doc_id
            WHERE a.pregid=$pregid";

    return $CI->adodb->db()->execute($sql);
}

function _cbClassOne($csid)
{
    $CI = & get_instance();

    $sql_tipe = "select class_name,csid from class_stay where is_active is true and csid={$csid} order by urutan";

    $res = $CI->adodb->db()->execute($sql_tipe);

    return $res;
}

function _get_igid($pregid)
{
    $CI = & get_instance();

    $sql = "select igid from patient_reg where pregid={$pregid}";

    $res = $CI->adodb->db()->GetOne($sql);

    return $res;
}

function _get_ttid($doc_id)
{
    $CI = & get_instance();

    //$CI->adodb->db()->debug = 1;

    $sql = "select ttid from person where pid={$doc_id}";

    $res = $CI->adodb->db()->GetOne($sql);

    return $res;
}

function _info_rs()
{
    $CI = & get_instance();
    
    //$CI->adodb->db()->debug = 1;

    $sql = "SELECT mfilter,mark FROM m_conf WHERE mcgid=1";
    $res = $CI->adodb->db()->query($sql);

    while(!$res->EOF)
    {
        $rec[$res->fields['mfilter']] = $res->fields['mark'];

        $res->moveNext();
    }

    return $rec;
}

function _get_bulan($m)
{
    switch ($m) {
        case '1':
            # code...
            $res = 'Januari';
            break;
        case '2':
            # code...
            $res = 'Februari';
            break;
        case '3':
            # code...
            $res = 'Maret';
            break;
        case '4':
            # code...
            $res = 'April';
            break;
        case '5':
            # code...
            $res = 'Mei';
            break;
        case '6':
            # code...
            $res = 'Juni';
            break;
        case '7':
            # code...
            $res = 'Juli';
            break;
        case '8':
            # code...
            $res = 'Agustus';
            break;
        case '9':
            # code...
            $res = 'September';
            break;
        case '10':
            # code...
            $res = 'Oktober';
            break;
        case '11':
            # code...
            $res = 'November';
            break;
        case '12':
            # code...
            $res = 'Desember';
            break;
        
        
        default:
            # code...
            $res = 'Non';
            break;
    }

    return $res;
}


function _get_hari($w)
{
    switch ($w) {
        case '0':
            # code...
            $res = 'Minggu';
            break;
        case '1':
            # code...
            $res = 'Senin';
            break;
        case '2':
            # code...
            $res = 'Selasa';
            break;
        case '3':
            # code...
            $res = 'Rabu';
            break;
        case '4':
            # code...
            $res = 'Kamis';
            break;
        case '5':
            # code...
            $res = 'Jumat';
            break;
        case '6':
            # code...
            $res = 'Sabtu';
            break;
        
        default:
            # code...
            $res = 'Non';
            break;
    }

    return $res;
}

function _is_inpatient($pregid)
{
    $CI = & get_instance();
    
    //$CI->adodb->db()->debug = 1;

    $sql = "SELECT is_inpatient FROM patient_reg WHERE pregid=$pregid";
    $is_inpatient = $CI->adodb->db()->GetOne($sql);

    return $is_inpatient;
}

function _combo_person($etid)
{
    $CI = & get_instance();
    
    #$CI->adodb->db()->debug = 1;

    $sql = "SELECT nama, pid FROM person WHERE etid IN($etid) AND is_active='t' ORDER BY nama";
    $rs = $CI->adodb->db()->execute($sql);

    return $rs;
}

function get_combo_option_month($curmonth='')/*{{{*/
  {
    $str = '';
    for ($i=1;$i<13;$i++)
    {
      if ($i == $curmonth) $sel = 'selected';
      else $sel = '';
      $str .= "<option value='$i' $sel>".$i."</option>\r\n";
    }
    return $str;
  }/*}}}*/

  function get_combo_option_month_long($curmonth='')/*{{{*/
  {
    $str = '';
        $monthnm = array(
                                        "none",     "Januari",   "Februari", "Maret",
                                        "April",    "Mei",       "Juni",     "Juli", 
                                        "Agustus",  "September", "Oktober",
                                        "Nopember", "Desember");
    for ($i=1;$i<13;$i++)
    {
      if ($i == $curmonth) $sel = 'selected';
      else $sel = '';
            $month_nm = $monthnm[$i];
      $str .= "<option value='$i' $sel>".$month_nm."</option>\r\n";
    }
    return $str;
  }/*}}}*/

 function get_combo_option_day($curday='')/*{{{*/
  {
    $str = '';
    for ($i=0;$i<7;$i++)
    {
      if ($i == $curday) $sel = 'selected';
      else $sel = '';
            $str .= "<option value='$i' $sel>{$this->dayname[$i]}</option>\r\n";
    }
    return $str;
  }/*}}}*/

  function get_combo_option_year($curyear,$startyear, $endyear)/*{{{*/
  {
    $str = '';
//  $startyear = 2014;   
 for ($i=$startyear;$i<=$endyear;$i++)
    {
      if ($i == $curyear) $sel = 'selected';
      else $sel = '';
      $str .= "<option value='$i' $sel>$i</option>\r\n";
    }
    return $str;
  }/*}}}*/

  function escape_quote($mystring){
    
    return str_replace("'","''",$mystring);
  }
 
  function get_nama_user($pid=-1){
    $CI = & get_instance();
    $pid = ($pid==-1)?$_SESSION['DATA_USER']['pid']:$pid;
    return $CI->adodb->db()->getOne("SELECT nama FROM person WHERE pid=".$pid);
  }

  function get_class_name($csid){
    $CI = & get_instance();
    return $CI->adodb->db()->getOne("SELECT class_name FROM class_stay WHERE csid=".$csid);
  } 

  function _get_info_rs() {

        $CI = & get_instance();

        $data['logo_banner'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='logo_banner'");

        $data['kode_rs'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='kode_rs'");

        $data['registrasi_rs'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='registrasi_rs'");

        $data['company_name'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='company_name'");

        $data['jenis_rs'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='jenis_rs'");

        $data['kelas'] = $CI->adodb->db()->GetOne("SELECT ARRAY_TO_STRING(ARRAY(SELECT x.class_name FROM class_stay x where x.is_active='t' ORDER BY x.urutan),', ') as class_name");

        $data['nama_direktur'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='nama_direktur'");

        $data['nama_penyelenggara'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='nama_penyelenggara'");

        $data['company_address'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='company_address'");

        $data['city'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='city'");

        $data['zip_code'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='zip_code'");

        $data['company_phone'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='company_phone'");

        $data['company_fax'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='company_fax'");

        $data['company_email'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='company_email'");

        $data['no_humas'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='no_humas'");

        $data['website'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='website'");

        $data['luas_tanah_rs'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='luas_tanah_rs'");

        $data['luas_bangunan_rs'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='luas_bangunan_rs'");

        $data['surat_izin_nomor'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='surat_izin_nomor'");

        $data['surat_izin_tanggal'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='surat_izin_tanggal'");

        $data['surat_izin_oleh'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='surat_izin_oleh'");

        $data['surat_izin_sifat'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='surat_izin_sifat'");

        $data['surat_izin_masa_berlaku'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='surat_izin_masa_berlaku'");

        $data['status_penyelenggara_swasta'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='status_penyelenggara_swasta'");

        $data['akreditasi_rs_pentahapan'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='akreditasi_rs_pentahapan'");

        $data['akreditasi_rs_status'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='akreditasi_rs_status'");

        $data['akreditasi_rs_tanggal'] = $CI->adodb->db()->GetOne("SELECT mark FROM m_conf WHERE mfilter='akreditasi_rs_tanggal'");

        return $data; 
    }

    function _get_general_info() {

        $CI = & get_instance();

        $rs = $CI->adodb->db()->execute("SELECT mfilter, mark FROM m_conf");

        while(!$rs->EOF) {

            $data[$rs->fields['mfilter']] = $rs->fields['mark'];

            $rs->moveNext();

        }        

        return $data;

    }


