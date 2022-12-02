<?php if(! defined('BASEPATH')) exit('No direct script access allowed');


 class Web extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();
        
        $this->load->model('web_mdl');
    }
    


    function index(){
        
        $tpl        = $this->load->template('home.html');

	        $res_news = $this->web_mdl->get_news();

	        while(!$res_news->EOF)
	        {

	            $tpl->assignDynamic('row',array(
	                  'VNO'                             => $no++,
	                  'news_id'                         => $res_news->fields['news_id'],
	                  'tanggal'                         => date('d-m-Y',strtotime($res_news->fields['tanggal'])),
	                  'title'                      	    => $res_news->fields['title'],
	                  'judulink'                	    => str_replace(' ', '-', $res_news->fields['title']),
	                  'images'                    	    => $res_news->fields['images'],
	                  'content'                         => str_replace('  ','',str_replace('</p>','',str_replace('<p>','',substr($res_news->fields['content'], 0, 500)))),
	                  'JABATAN'                         => $res_news->fields['jabatan'],
	                  'BASE_URL'                        => base_url(),

	            ));
	            
	            $tpl->parseConcatDynamic('row');

	            $res_news->movenext();
	        }

		$rs 		= $this->web_mdl->news_detail_depan();
		$tpl->assign($rs->fields);
        $tpl->assign(array(
              'BASEURL'                 => str_replace('web/','',base_url()),
              'judulink'                => str_replace(' ', '-', $rs->fields['title']),
              'ABOUT'                   => $this->web_mdl->aboutus(),
              'LAST'                    => $this->web_mdl->get_last(),
              'FILEJADWAL'              => $this->web_mdl->filejadwal(),
              'header'                  => $this->header_front(),
              'footer'                  => $this->footer(),

        ));
        
        $this->load->render_template($tpl);
    }


    function show_news(){
      $news_id    = $this->input->post('news_id');
      $get_news   = $this->web_mdl->show_news($news_id);
            $row = array(
            'judul'         => $get_news->fields['title'],
            'isi'           => $get_news->fields['content'],
            'image'         => '<img src="'.base_url().'news_image/'.$get_news->fields['images'].'" class="img-responsive">',
            'pdf'           => 'Download File : <a href="'.base_url().'news_pdf/'.$get_news->fields['pdf'].'">'.$get_news->fields['pdf'].'</a>',
      );

      echo json_encode($row);


    }

    function show_layanan(){
      $lid    = $this->input->post('lid');
      $get_layanan   = $this->web_mdl->show_layanan($lid);
            $row = array(
            'judul'         => $get_layanan->fields['judul'],
            'isi'           => $get_layanan->fields['deskripsi'],
            'image'         => '<img src="'.base_url().'layanan/'.str_replace('&','',$get_layanan->fields['images']).'" class="img-responsive">',
            'pdf'           => '',//Download File : <a href="'.base_url().'news_pdf/'.$get_news->fields['pdf'].'">'.$get_news->fields['pdf'].'</a>',
      );

      echo json_encode($row);


    }


    function show_unggulan(){
      $lid    = $this->input->post('lid');
      $get_unggulan   = $this->web_mdl->show_unggulan($lid);
            $row = array(
            'judul'         => $get_unggulan->fields['judul'],
            'isi'           => $get_unggulan->fields['deskripsi'],
            'image'         => '<img src="layanan/'.$get_unggulan->fields['images'].'" class="img-responsive">',
      );

      echo json_encode($row);


    }

    function gallery(){
        
        $tpl        = $this->load->template('gallery.html');
        $kgid       = $this->input->get('kgid',1);


       $res_kat = $this->web_mdl->get_kat();
        $no =1;
        $li = '';

        while(!$res_kat->EOF)
        {
            if ($kgid==$res_kat->fields['kgid']){
              $bg   =  '#1d8717';
              $fonco = "#FFF";
            }else{
              $bg   = '';
              $fonco = "";
            }



            $li   .='<li style="background:'.$bg.'"><a href="'.base_url().'web/gallery?kgid='.$res_kat->fields['kgid'].'" style="color:'.$fonco.'">'.$res_kat->fields['nama_kategori'].'</a></li>';
            $res_kat->movenext();
        }


       $res_kat_gal = $this->web_mdl->get_kat_gal($kgid);

        $noxx =1;
        $galx = '';


        while(!$res_kat_gal->EOF)
        {
            $galx   .='<div class="col-lg-6 col-sm-7 col-xs-9">
                    <a title="'.$res_kat_gal->fields['nama_kategori'].'" href="#"> <span>'.$res_kat_gal->fields['title'].'</span><br>
                            <img class=" thumbnail img-responsive" src="'.base_url().'gallery/'.$res_kat_gal->fields['filename'].'"
                    ></a></div>';
            $res_kat_gal->movenext();
        }

        $tpl->assign(array(
              'BASEURL'                 => base_url(),
              'LI'                      => $li,
              'GAL'                     => $galx,
              'header'                  => $this->header(),
              'footer'                  => $this->footer(),
        ));
        
        $this->load->render_template($tpl);
    }




    function berita(){
        
        $data=$this->data_var();
        $tpl        = $this->load->template('news_list.html');
        $lkid       = $this->input->get('lkid');

       

        $noxx =1;
        $galx = '';

        $jmlbris            		 = $this->web_mdl->get_all_news($data,true)->RecordCount();
        $config['page_query_string'] = true;
        $config['base_url'] = base_url().'web/berita?';

        $config['total_rows'] = $jmlbris;
        $config['per_page'] = 10; 
        $offset=($data['per_page']=='')?0:$data['per_page'];
        $res_news = $this->web_mdl->get_all_news($data,false,$offset,10);
        $this->pagination->initialize($config); 
        $prev= $this->pagination->create_links();
        $i=$data['per_page']+1;

        while(!$res_news->EOF)
        {

            $tpl->assignDynamic('row',array(
                  'VNO'                             => $no++,
                  'news_id'                         => $res_news->fields['news_id'],
                  'tanggal'                         => date('d/m/Y H:i',strtotime($res_news->fields['tanggal'])),
                  'title'                      	    => $res_news->fields['title'],
                  'judulink'                	    => str_replace(' ', '-', $res_news->fields['title']),
                  'images'                    	    => $res_news->fields['images'],
                  'content'                         => str_replace('  ','',str_replace('</p>','',str_replace('<p>','',substr($res_news->fields['content'], 0, 500)))),
                  'JABATAN'                         => $res_news->fields['jabatan'],
                  'BASE_URL'                        => base_url(),

            ));
            
            $tpl->parseConcatDynamic('row');

            $res_news->movenext();
        }

        $tpl->assign(array(
              'BASEURL'                 => base_url(),
              'header'                  => $this->header(),
              'footer'                  => $this->footer(),
              'PREVNEXT' 				=> $prev
        ));
        
        $this->load->render_template($tpl);
    }

    	function newsd(){
	        $tpl        = $this->load->template('news_detail.html');
    		$title  	= $this->uri->Segment(3);
    		$title 		= str_replace('-', ' ', $title);

	        $res_news = $this->web_mdl->get_news();

	        while(!$res_news->EOF)
	        {

	            $tpl->assignDynamic('row',array(
	                  'VNO'                             => $no++,
	                  'news_id'                         => $res_news->fields['news_id'],
	                  'tanggal'                         => date('d/m/Y H:i',strtotime($res_news->fields['tanggal'])),
	                  'title'                      	    => $res_news->fields['title'],
	                  'judulink'                	    => str_replace(' ', '-', $res_news->fields['title']),
	                  'images'                    	    => $res_news->fields['images'],
	                  'content'                         => str_replace('  ','',str_replace('</p>','',str_replace('<p>','',substr($res_news->fields['content'], 0, 500)))),
	                  'JABATAN'                         => $res_news->fields['jabatan'],
	                  'BASE_URL'                        => base_url(),

	            ));
	            
	            $tpl->parseConcatDynamic('row');

	            $res_news->movenext();
	        }



    		$rs 		= $this->web_mdl->news_detail($title);
    		$tpl->assign($rs->fields);
	        $tpl->assign(array(
	              'BASEURL'                 => base_url(),
                  'tanggal'                 => date('d/m/Y H:i',strtotime($rs->fields['tanggal'])),
	              'header'                  => $this->header(),
	              'footer'                  => $this->footer(),
	        ));
	        $this->load->render_template($tpl);
    	}

    function data_var()/*{{{*/
      {
        $retQ = array();
        $retP = array();
        $data = array();
        $retQ = (!is_array($this->input->get()))?array():$this->input->get();
        $retP = (!is_array($this->input->post()))?array():$this->input->post();
        $data =array_merge($retQ,$retP);
        return $data;
      }/*}}}*/


    function tentang(){
        $tpl        = $this->load->template('tentang.html');
        $tid        = $this->input->get('tid','1');


       $rs = $this->web_mdl->get_tentang_kontent();

        $tpl->assign($rs->fields);
        $tpl->assign(array(
              'BASEURL'                 => base_url(),
              'header'                  => $this->header(),
              'footer'                  => $this->footer(),
        ));
        
        $this->load->render_template($tpl);
    }

    function kelurahan(){
        $tpl        = $this->load->template('kelurahan.html');
        $tpl->defineDynamicBlock('row');

       $rs = $this->web_mdl->get_kelurahan();
        while(!$rs->EOF)
        {

	            $tpl->assignDynamic('row',array(
	                  'VNO'                             => $no++,
	                  'dkid' 		                    => $rs->fields['dkid'],
	                  'nama_kelurahan'                  => $rs->fields['nama_kelurahan'],
	                  'BASE_URL'                        => base_url(),

	            ));

            $tpl->parseConcatDynamic('row');
            $rs->movenext();
        }

        $tpl->assign(array(
              'BASEURL'                 => base_url(),
              'header'                  => $this->header(),
              'footer'                  => $this->footer(),
        ));
        
        $this->load->render_template($tpl);
    }


    	function detikel(){
	        $tpl        = $this->load->template('detikel.html');
    		$dkid    	= $this->uri->Segment(3);


    		$rs 		= $this->web_mdl->get_kelurahan_detail($dkid);
    		$tpl->assign($rs->fields);
	        $tpl->assign(array(
	              'BASEURL'                 => base_url(),
                  'tanggal'                 => date('d/m/Y H:i',strtotime($rs->fields['tanggal'])),
	              'header'                  => $this->header(),
	              'footer'                  => $this->footer(),
	        ));
	        $this->load->render_template($tpl);
    	}


    function header(){
        $tpl        = $this->load->template('header.html');

        $tpl->assign(array(
              'BASEURL'                 => base_url(),

        ));
        
        $this->load->render_template($tpl);


//    return $header;
    }

    function header_front(){
        $tpl        = $this->load->template('header_front.html');

        $tpl->assign(array(
              'BASEURL'                 => base_url(),

        ));
        
        $this->load->render_template($tpl);


//    return $header;
    }

    function footer(){
      $footer   = '    <div class="skew-c"></div><footer class="footer">
					        <div class="container">
					            <div class="row">
					                <div class="col-sm-2" >
						                <img src="https://www.bekasikota.go.id/uploads/logo-footer.png" alt="image">
					                </div>
					                <div class="col-sm-4" style="float:left">
					                    <div class="footer-distributed widget clearfix"><br>
					                        <div class="widget-title">
					                            <h3>Pemerintah Kota Bekasi</h3>
												<p>Jl. Jend. Ahmad Yani, RT.001/RW.005, Marga Jaya, Kec. Bekasi Selatan Kota Bekasi <br>Jawa Barat 17141</p>
					                        </div>
					                    </div>
					                </div>
					            </div>
					        </div>
					    </footer>

					    <script src="'.base_url().'frontmodules/js/all.js"></script>
					    <script src="'.base_url().'frontmodules/js/custom.js"></script>
					    <script src="'.base_url().'frontmodules/js/portfolio.js"></script>
					    <script src="'.base_url().'frontmodules/js/hoverdir.js"></script>    

					</body>
					</html>';


    return $footer;
    }
        
 }
