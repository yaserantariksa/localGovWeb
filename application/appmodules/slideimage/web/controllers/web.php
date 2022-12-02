<?php if(! defined('BASEPATH')) exit('No direct script access allowed');


 class Web extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->load->model('web_mdl');
    }
    


    function index(){
        
        $tpl        = $this->load->template('home.html');
        $res_cb     = $this->web_mdl->spesialis();
        $res_slide  = $this->web_mdl->get_slide();

        $nosli =1;
        $slide = '';
        while(!$res_slide->EOF)
        {
          if ($nosli==1){
            $act = 'active';
          }else{
            $act = '';
          }
             $slide .= '
                    <div class="item '.$act.'" style="margin:auto; padding:0">
                      <img src="slide/'.$res_slide->fields['image'].'"  alt="slide'.$nosli.'" width="260" height="145">
                    </div>
                        '; 
          $act = '';
          $nosli ++;
            $res_slide->movenext();
        }

       $res_layanan = $this->web_mdl->get_layanan();

        $no =1;
        $layanan = '';
        while(!$res_layanan->EOF)
        {
             $layanan .= '<div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="0ms">
                        <div class="media service-box">
                            <div class="pull-left">
                                <i class="fa fa-cubes"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                  <a data-toggle="modal" data-target="#view-unggulan" data-id="'.$res_layanan->fields['lid'].'" id="show_unggulan" style="cursor:pointer" >
                                    '.$res_layanan->fields['judul'].'
                                  </a>
                                </h4>
                                <p>'.$res_layanan->fields['deskripsi'].'</p>
                            
                            </div>
                        </div>
                    </div>'; 

            $res_layanan->movenext();
        }



        $res_dokter = $this->web_mdl->get_dokter_front();
        $no =1;
        $dokter = '';
        while(!$res_dokter->EOF)
        {



              $hari .= 'SENIN'  .' : '.str_replace('00:00:00','',$res_dokter->fields['start_senin']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_senin']).'<br>';
              $hari .= 'SELASA' .' : '.str_replace('00:00:00','',$res_dokter->fields['start_selasa']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_selasa']).'<br>';
              $hari .= 'RABU'   .' : '.str_replace('00:00:00','',$res_dokter->fields['start_rabu']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_rabu']).'<br>';
              $hari .= 'KAMIS'  .' : '.str_replace('00:00:00','',$res_dokter->fields['start_kamis']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_kamis']).'<br>';
              $hari .= 'JUMAT'  .' : '.str_replace('00:00:00','',$res_dokter->fields['start_jumat']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_jumat']).'<br>';
              $hari .= 'SABTU'  .' : '.str_replace('00:00:00','',$res_dokter->fields['start_sabtu']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_sabtu']).'<br>';
              $hari .= 'MINGGU' .' : '.str_replace('00:00:00','',$res_dokter->fields['start_minggu']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_minggu']).'<br>';



            if ($res_dokter->fields['photo']==''){
              $dokterimg  = 'nopic.png';
            }else{
              $dokterimg  = $res_dokter->fields['photo'];
            }

             $dokter .= '<div class="col-sm-6 col-md-3">
                    <div class="team-member wow fadeInUp" data-wow-duration="400ms" data-wow-delay="100ms">
                        <div class="team-img">
                            <img class="img-responsive" src="'.base_url().'dokter/'.$dokterimg.'" alt="">
                        </div>
                        <div class="team-info">
                            <h4 style="min-height:40px; font-size:1em">'.$res_dokter->fields['nama_dokter'].'</h4>
                            <span style="font-size:1.1em">'.$res_dokter->fields['name_real'].'</span>
                        </div>
                        <p style="font-size:.7em">'.$hari.'</p>
                        <ul class="social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>'; 
                $hari = '';

            $res_dokter->movenext();
        }




        $res_news = $this->web_mdl->get_news();
        $news = '';
        while(!$res_news->EOF)
        {
             $news .= '<div class="col-sm-2">
                        <div class="blog-post blog-large wow fadeInLeft" data-wow-duration="300ms" data-wow-delay="0ms"  style="background:#FFF">
                            <article>
                                <header class="entry-header">
                                    <div class="entry-thumbnail">
                                        <img class="img-responsive" src="news_image/'.$res_news->fields['images'].'" alt="">
                                    </div>
                                    <div class="entry-date" style="font-size:.7em; line-height:normal">'.$res_news->fields['title'].'</div>
                            <button data-toggle="modal" data-target="#view-news" data-id="'.$res_news->fields['news_id'].'" id="show_news" class="btn btn-xs btn-info">
                                <i class="glyphicon glyphicon-eye-open"></i> Selanjutnya
                            </button>

                                </header>

                                <footer class="entry-meta">
                                    <span class="entry-author"><i class="fa fa-pencil"></i> <a href="#">'.$res_news->fields['user'].'</a></span>
                                </footer>
                            </article>
                        </div>
                    </div>'; 

            $res_news->movenext();
        }



        $res_promo = $this->web_mdl->get_promo();

        $no =1;
        $i =1;
        $aktif = '';

        $promoa = '<ul class="badhon-tab" role="tablist" style="margin-right:1%; border:none">';
        $promob = '';
        while(!$res_promo->EOF)
        {
            $i = $no++;
          if ($i==1){
              $aktif ='active';
          }else{
              $aktif  = '';
          }
             $promoa .= '<li class="'.$$aktif.'"><a href="#'.$res_promo->fields['proid'].'" aria-controls="home" role="tab" data-toggle="tab">
                      <!-- <i class="'.$res_promo->fields['div'].'"></i> -->
                        <i class="fa fa-briefcase"></i>
                      '.$res_promo->fields['judul'].'
                      </a></li>'; 
             $promob .= '<div class="tab-pane '.$aktif.' edit-tab" id="'.$res_promo->fields['proid'].'" style="margin-left:-10px;">
                           <img src="pelayanan/'.$res_promo->fields['image'].'">

                            <p>'.$res_promo->fields['deskripsi'].'</p>

                          </div>
                          ';

            $res_promo->movenext();
        }

        $promoa   .= '
                    </ul>';

        $tpl->assign(array(
              'BASEURL'                 => base_url(),
              'SLIDE'                   => $slide,
              'PROMOA'                  => $promoa,
              'PROMOB'                  => $promob,
              'LAYANAN'                 => $layanan,
              'DOKTER'                  => $dokter,
              'NEWS'                    => $news,
              'NAMADOKTER'              => $this->input->post('namadokter'),
              'SPESIALIS'               => $res_cb->GetMenu2('did',$this->input->post('did'),true,false,'','class="form-control" id="did"'),
              'ABOUT'                   => $this->web_mdl->aboutus()
        ));
        
        $this->load->render_template($tpl);
    }


    function show_news(){
      $news_id    = $this->input->post('news_id');
      $get_news   = $this->web_mdl->show_news($news_id);
            $row = array(
            'judul'         => $get_news->fields['title'],
            'isi'           => $get_news->fields['content'],
            'image'         => '<img src="news_image/'.$get_news->fields['images'].'" class="img-responsive">',
      );

      echo json_encode($row);


    }

    function show_unggulan(){
      $lid    = $this->input->post('lid');
      $get_unggulan   = $this->web_mdl->show_unggulan($lid);
            $row = array(
            'judul'         => $get_unggulan->fields['judul'],
            'isi'           => $get_unggulan->fields['deskripsi'],
//            'image'         => '<img src="news_image/'.$get_unggulan->fields['images'].'" class="img-responsive">',
      );

      echo json_encode($row);


    }




    function doctor_search(){
      $tpl              = $this->load->template('search.html');
      $did              = $this->input->get('did');
      $namadokter       = $this->input->get('nm');
      $res_cb           = $this->web_mdl->spesialis();

        $res_dokter = $this->web_mdl->get_dokter_search($did,$namadokter);
        $no =1;
        $dokter = '';
        if ($res_dokter->EOF){
          $dokter = "<div style='text-align:center; margin:auto'>Data Yang Anda Cari Tidak Ditemukan</div>";
        }
        while(!$res_dokter->EOF)
        {

              $hari .= 'SENIN'  .' : '.str_replace('00:00:00','',$res_dokter->fields['start_senin']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_senin']).'<br>';
              $hari .= 'SELASA' .' : '.str_replace('00:00:00','',$res_dokter->fields['start_selasa']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_selasa']).'<br>';
              $hari .= 'RABU'   .' : '.str_replace('00:00:00','',$res_dokter->fields['start_rabu']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_rabu']).'<br>';
              $hari .= 'KAMIS'  .' : '.str_replace('00:00:00','',$res_dokter->fields['start_kamis']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_kamis']).'<br>';
              $hari .= 'JUMAT'  .' : '.str_replace('00:00:00','',$res_dokter->fields['start_jumat']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_jumat']).'<br>';
              $hari .= 'SABTU'  .' : '.str_replace('00:00:00','',$res_dokter->fields['start_sabtu']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_sabtu']).'<br>';
              $hari .= 'MINGGU' .' : '.str_replace('00:00:00','',$res_dokter->fields['start_minggu']).'-'.str_replace('00:00:00','',$res_dokter->fields['end_minggu']).'<br>';


            if ($res_dokter->fields['photo']==''){
              $dokterimg  = 'nopic.png';
            }else{
              $dokterimg  = $res_dokter->fields['photo'];
            }
             $dokter .= '<div class="col-sm-6 col-md-3">
                    <div class="team-member wow fadeInUp" data-wow-duration="400ms" data-wow-delay="100ms">
                        <div class="team-img">
                            <img class="img-responsive" src="'.base_url().'dokter/'.$dokterimg.'" alt="">
                        </div>
                        <div class="team-info">
                            <h4 style="min-height:40px; font-size:1em">'.$res_dokter->fields['nama_dokter'].'</h4>
                            <span style="font-size:1.1em">'.$res_dokter->fields['name_real'].'</span>
                        </div>
                        <p style="font-size:.7em">'.$hari.'</p>
                        <ul class="social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>'; 
                $hari = '';
            $res_dokter->movenext();
        }

        $tpl->assign(array(
              'BASEURL'                 => base_url(),
              'DOKTER'                  => $dokter,
              'NAMADOKTER'              => $this->input->get('nm'),
              'SPESIALIS'               => $res_cb->GetMenu2('did',$this->input->get('did'),true,false,'','class="form-control" id="did"'),
        ));
      $this->load->render_template($tpl);

    }



    function gallery(){
        
        $tpl        = $this->load->template('gallery.html');
        $kgid       = $this->input->get('kgid');
        $res_cb     = $this->web_mdl->spesialis();
        $res_slide  = $this->web_mdl->get_slide();


       $res_kat = $this->web_mdl->get_kat();

        $no =1;
        $li = '';

        while(!$res_kat->EOF)
        {
            $li   .='<li><a href="'.base_url().'web/gallery?kgid='.$res_kat->fields['kgid'].'">'.$res_kat->fields['nama_kategori'].'</a></li>';
            $res_kat->movenext();
        }

       $res_kat_gal = $this->web_mdl->get_kat_gal($kgid);

        $noxx =1;
        $galx = '';

        while(!$res_kat_gal->EOF)
        {
            $galx   .='<div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image '.$noxx++.'" href="#"><img class="thumbnail img-responsive" src="'.base_url().'gallery/'.$res_kat_gal->fields['filename'].'"></a> <span>'.$res_kat_gal->fields['title'].'</span></div>';
            $res_kat_gal->movenext();
        }

        $tpl->assign(array(
              'BASEURL'                 => base_url(),
              'LI'                      => $li,
              'GAL'                     => $galx,
              'NAMADOKTER'              => $this->input->post('namadokter'),
              'SPESIALIS'               => $res_cb->GetMenu2('did',$this->input->post('did'),true,false,'','class="form-control" id="did"'),
        ));
        
        $this->load->render_template($tpl);
    }



        
 }
