<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map extends MY_Controller{
	protected $limit = 5;


	// public function before() {
	// 	//parent::before();
	// 	$this->load->model('mdl_map');
	// }
	// 
    function __construct() {
    	parent::__construct();
        // first do something important
		$this->load->model('mdl_map');	

    }

	public function index() {

		$data = array();
		$data['groups'] = $this->mdl_map->get_mgolongan()->result_array();
		$data['golongan'] = array();
		$results = $this->mdl_map->get_mgolongan_for_recap()->result_array();
		//echo $this->db->last_query();exit;
		foreach ($results as $vg) {
		    $data['golongan'][$vg['golongan']]['golongan'] = $vg['golongan'];
			$data['golongan'][$vg['golongan']]['name'] = $vg['nm_golongan'];
			$data['golongan'][$vg['golongan']]['bidang'][$vg['bidang']]['id'] = $vg['bidang'];
			$data['golongan'][$vg['golongan']]['bidang'][$vg['bidang']]['name'] = $vg['nm_bidang'];
		}
		//$data['kelurahan_data'] = $this->mdl_map->get_kelurahan_data($this->session->userdata['user_data']['kelurahan_id'])->row_array();
        /* 
		echo '<pre>';
		print_r($data['golongan']);
		exit;
		*/
		$this->template->display('map/index', $data);
	}

	public function petatematik($id) {
		$data = array('status'=>false);
	
		//$data = array('legend'=>$legend);
		if(substr($id,0,2)=='01'){
		   $asets = $this->mdl_map->get_all_kiba(substr($id,0,4))->result_array();
		}
		else if(substr($id,0,2)=='02'){
		   $asets = $this->mdl_map->get_all_kiba(substr($id,0,4))->result_array();
		}
		else if(substr($id,0,2)=='03'){
		   $asets = $this->mdl_map->get_all_kibc(substr($id,0,4))->result_array();
		}
		else if(substr($id,0,2)=='04'){
		   $asets = $this->mdl_map->get_all_kibd(substr($id,0,4))->result_array();
		}
		else if(substr($id,0,2)=='05'){
		   $asets = $this->mdl_map->get_all_kibe(substr($id,0,4))->result_array();
		}
		else if(substr($id,0,2)=='06'){
		   $asets = $this->mdl_map->get_all_kibf(substr($id,0,4))->result_array();
		}
		$gol = $this->mdl_map->get_golongan(substr($id,0,4))->row_array();
		
		if(count($asets)>0) {
			$data = array('status'=>true);
			if( (substr($id,0,2)=='01') or (substr($id,0,2)=='03') or (substr($id,0,2)=='04') or (substr($id,0,2)=='06') ){
			  $legend = $this->mdl_map->get_nm_kelompok($id)->result_array();
			}
			else {
			  $legend ="test";
			  
			}
		    $data['legend']=$legend;
			$data['asets'] = $asets;
			$data['count']=count($asets);
			$data['gol'] = $gol;
		}

		echo json_encode($data);
	}
	

	public function petaunitskpd($id) {
		$data = array('status'=>false);
		$gol = substr($id,0,2);
		$bid = substr($id,0,4);
		
		$units = $this->mdl_map->get_spesific_unit($gol,$bid)->result_array();
		
		if(count($units)>0) {
			$data = array('status'=>true);
			if( ($gol=='02') or ($gol=='05') ){
			  $legend = $this->mdl_map->get_unit_legend($gol,$bid)->result_array();
			}
			else {
			  $legend ="test";
			  
			}
		    $data['legend']=$legend;
			$data['units'] = $units;
		}

		echo json_encode($data);
	}
	
	public function unittematik($id) {
		$data = array('status'=>false);
	
		$unit = $this->mdl_map->get_all_uskpd()->result_array();

		if(count($unit)>0) {
			$data = array('status'=>true);
			//$legend = $this->mdl_map->get_nm_kelompok($id)->result_array();
		    //$data['legend']=$legend;
			$data['unit'] = $unit;
		}

		echo json_encode($data);
	}
	
	//start abah update 08012014: tambah fungsi view tematik fullscreen A2
	public function cetaktematik($id) {
		//echo $id;exit;
		$data = array();		
	    $data['lat']= '-7.057395800000000000';
		$data['lon']= '140.498818600000030000';
		$data['category']=$id;
	    $this->template->single('cetak/index', $data);
	}
	//end abah update 08012014: tambah fungsi view tematik fullscreen A2
	
	public function responden() {
		$data = array();
		$data['responden'] = array();
		if($input = $this->input->post()) {
			$data_id = isset($input['data_id'])?$input['data_id']:'';
			$kd_brg = isset($input['kdbrg'])?$input['kdbrg']:'';
			//echo(kd_brg);exit;
			if($data_id!='') {
				//$responden = $this->mdl_map->get_data_trkiba($data_id)->row_array();
				if(substr($kd_brg,0,2)=='01'){
				   $responden = $this->mdl_map->get_data_trkiba($data_id)->row_array();
				   $layout='map/trkib_a';
				}
				else if(substr($kd_brg,0,2)=='02'){
				   $responden = $this->mdl_map->get_data_trkibb($data_id)->row_array();
				   $layout='map/trkib_b';
				}
				else if(substr($kd_brg,0,2)=='03'){
				   $responden = $this->mdl_map->get_data_trkibc($data_id)->row_array();
				   $layout='map/trkib_c';
				}
				else if(substr($kd_brg,0,2)=='04'){
				   $responden = $this->mdl_map->get_data_trkibd($data_id)->row_array();
				   $layout='map/trkib_d';
				}
				else if(substr($kd_brg,0,2)=='05'){
				   $responden = $this->mdl_map->get_data_trkibe($data_id)->row_array();
				    $layout='map/trkib_e';
				}
				else if(substr($kd_brg,0,2)=='06'){
				   $responden = $this->mdl_map->get_data_trkibf($data_id)->row_array();
				    $layout='map/trkib_f';
				}
			
				if(count($responden)>0) {
					$data['responden'] = $responden;
					//$layout='map/trkib_a';					
				}
			}
		}
		$this->template->single($layout, $data);
	}
	
	public function unit() {
		$data = array();
		$data['unit'] = array();
		if($input = $this->input->post()) {
			$data_id = isset($input['id'])?$input['id']:'';
			$cat = isset($input['category'])?$input['category']:'';
			if($data_id!='') {
				$unit = $this->mdl_map->get_data_uskpd($data_id)->row_array();
				$asset = $this->mdl_map->get_data_asset_uskpd($cat,$data_id)->result_array();
				if(count($unit)>0) {
					$data['unit'] = $unit;				 
					$data['asset'] = $asset;				 
				}
			}
		}
		$this->template->single('map/unitskpd', $data);
	}
	
	public function quick_search($rws) {
		$table_name="";
		$data = array('status'=>false);
		if($input = $this->input->post()) {
			$qs = isset($input['qs'])?$input['qs']:'';
			//$rws = ($rws>0)?$rws:false;
			if($rws=='01'){$table_name = 'trkib_a';}
			else if($rws=='02'){$table_name = 'trkib_b';} 
			else if($rws=='03'){$table_name = 'trkib_c';} 	
			else if($rws=='04'){$table_name = 'trkib_d';} 	
			else if($rws=='05'){$table_name = 'trkib_e';} 	
			else if($rws=='06'){$table_name = 'trkib_f';} 				
			//$rws=true;
			if($qs) {
				$resp = $this->mdl_map->get_quick_search($qs, $rws, $table_name)->result_array();
				if(count($resp)>0) {
					$data = array('status'=>true);
					$data['responden'] = $resp;
				}
			}
		}
		echo json_encode($data);
	}
	
	public function add_search($rws) {
		$table_name="";
		$data = array('status'=>false);
		if($input = $this->input->post()) {
			$qs = isset($input['qs'])?$input['qs']:'';
			//$rws = ($rws>0)?$rws:false;
			if($rws=='01'){$table_name = 'trkib_a';}
			else if($rws=='02'){$table_name = 'trkib_b';} 
			else if($rws=='03'){$table_name = 'trkib_c';} 	
			else if($rws=='04'){$table_name = 'trkib_d';} 	
			else if($rws=='05'){$table_name = 'trkib_e';} 	
			else if($rws=='06'){$table_name = 'trkib_f';} 				
			//$rws=true;
			if($qs) {
				$resp = $this->mdl_map->get_add_search($qs, $rws, $table_name)->result_array();
				if(count($resp)>0) {
					$data = array('status'=>true);
					$data['responden'] = $resp;
				}
			}
		}
		echo json_encode($data);
	}
	//search skpd
	public function skpd_search() {
		$table_name="unit_skpd";
		$data = array('status'=>false);
		if($input = $this->input->post()) {
			$key = isset($input['key'])?strtoupper($input['key']):'';
			if($key!='') {
				$resp = $this->mdl_map->get_search_skpd($key)->result_array();
				if(count($resp)>0) {
					$data = array('status'=>true);
					$data['responden'] = $resp;
				}
			}
		}
		echo json_encode($data);
	}
	
	public function mod_quick_search($gol,$bid,$kel,$sub) {
		$table_name="";
		$data = array('status'=>false);
		if($input = $this->input->post()) {
			$qs = isset($input['qs'])?$input['qs']:'';
			//$rws = ($rws>0)?$rws:false;
			if($gol=='01'){$table_name = 'trkib_a';$tablegis = 'trkiba_gis';}
			else if($gol=='02'){$table_name = 'trkib_b';$tablegis = 'trkibb_gis';} 
			else if($gol=='03'){$table_name = 'trkib_c';$tablegis = 'trkibc_gis';} 	
			else if($gol=='04'){$table_name = 'trkib_d';$tablegis = 'trkibd_gis';} 	
			else if($gol=='05'){$table_name = 'trkib_e';$tablegis = 'trkibe_gis';} 	
			else if($gol=='06'){$table_name = 'trkib_f';$tablegis = 'trkibf_gis';} 				
			//$gol=true;
			if($qs) {
				$resp = $this->mdl_map->get_mod_quick_search($qs, $table_name, $tablegis, $gol, $bid, $kel, $sub)->result_array();
				if(count($resp)>0) {
					$data = array('status'=>true);
					$data['responden'] = $resp;
				}
			}
		}
		echo json_encode($data);
	}
	
	public function simpan_data() {
		if($input = $this->input->post()) {
			echo $input['koordinat'];
		}
	}
	
	public function get_bidang_list($golongan){
		$bidangs = $this->mdl_map->get_bid_by_gol($golongan);
		$data['list'] = '<select style="width:260px" id="mki_quick_search_bid">';
		$data['list'] .= '<option id="mki_quick_search_bid_nol" value="nol">-- Bidang Aset --</option>';
		foreach($bidangs->result_array() as $bid){
			$data['list'].='<option id="mki_quick_search_bid_'.$bid['bidang'].'" value="'.$bid['bidang'].'">'.$bid['nm_bidang'].'</option>';
		}
		$data['list'] .= '</select>';
		
		echo json_encode($data);
	}
	
	// public function get_kelompok_list($bidang){
	// 	$kelompok = $this->mdl_map->get_kel_by_bid($bidang);
	// 	$data['list'] = '<select style="width:260px" id="mki_quick_search_kel">';
	// 	$data['list'] .= '<option id="mki_quick_search_kel_nol" value="nol">-- Kelompok Aset --</option>';
	// 	foreach($kelompok->result_array() as $kel){
	// 		$data['list'].='<option id="mki_quick_search_kel_'.$kel['kelompok'].'" value="'.$kel['kelompok'].'">'.$kel['nm_kelompok'].'</option>';
	// 	}
	// 	$data['list'] .= '</select>';
		
	// 	echo json_encode($data);
	// }
	
	// public function get_subkel_list($kelompok){
	// 	$subkel = $this->mdl_map->get_sub_by_kel($kelompok);
	// 	$data['list'] = '<select style="width:260px" id="mki_quick_search_sub">';
	// 	$data['list'] .= '<option id="mki_quick_search_sub_nol" value="nol">-- Sub-Kelompok Aset --</option>';
	// 	foreach($subkel->result_array() as $kel){
	// 		$data['list'].='<option id="mki_quick_search_sub_'.$kel['kd_kelompok'].'" value="'.$kel['kd_kelompok'].'">'.$kel['nm_kelompok'].'</option>';
	// 	}
	// 	$data['list'] .= '</select>';
		
	// 	echo json_encode($data);
	// }
	
	// public function get_barang_list($subkel){
	// 	$barang = $this->mdl_map->get_brg_by_sub($subkel);
	// 	$data['list'] = '<select style="width:260px" id="mki_quick_search_brg">';
	// 	$data['list'] .= '<option id="mki_quick_search_brg_nol" value="nol">-- Barang Aset --</option>';
	// 	foreach($barang->result_array() as $brg){
	// 		$data['list'].='<option id="mki_quick_search_brg_'.$brg['kd_brg'].'" value="'.$brg['kd_brg'].'">'.$brg['nm_brg'].'</option>';
	// 	}
	// 	$data['list'] .= '</select>';
		
	// 	echo json_encode($data);
	// }
		
	public function add_responden() {
		$data = array();
		$responden = array();
		if($input = $this->input->post()) {
			$data['lat'] = $this->input->post('lat');
			$data['long'] = $this->input->post('lng');
			$data['noreg'] = $this->input->post('register');
		    $data['kdbrg'] = $this->input->post('kdbrg');
			$kd_gol = substr($data['kdbrg'],0,2);
			
			if($kd_gol=='01'){
			   $responden = $this->mdl_map->get_data_trkiba($this->input->post('register'))->row_array();
			}
			else if($kd_gol=='02'){
			   $responden = $this->mdl_map->get_data_trkibb($this->input->post('register'))->row_array();
			}
			else if($kd_gol=='03'){
			   $responden = $this->mdl_map->get_data_trkibc($this->input->post('register'))->row_array();
			}
			else if($kd_gol=='04'){
			   $responden = $this->mdl_map->get_data_trkibd($this->input->post('register'))->row_array();
			}
			else if($kd_gol=='05'){
			   $responden = $this->mdl_map->get_data_trkibe($this->input->post('register'))->row_array();
			}
			else if($kd_gol=='06'){
			   $responden = $this->mdl_map->get_data_trkibf($this->input->post('register'))->row_array();
			}
			$data['resp'] = $responden;
		}
		$this->template->single('map/addresponden', $data);
	}
	
	public function save_responden(){
		$data = array();
		$data2 = array();
		if($input = $this->input->post()) {
			$golongan = $this->input->post('gol');
			//echo $gol;
			//Data KIB
			//$data['no_reg'] = $this->input->post('noreg');
			//$data['kd_brg'] = $this->input->post('kdbrg');
			$no_reg = $this->input->post('noreg');
			/*
			$data['alamat1'] = $this->input->post('alamat1');
			$data['alamat2'] = $this->input->post('alamat2');
			$data['alamat3'] = 'PAPUA BARAT';
			$data['no_dokumen'] = $this->input->post('nodok');
			if($gol=='01'){
				$data['no_sertifikat'] = $this->input->post('noser');
				$data['tgl_sertifikat'] = $this->input->post('tglser');
			}
			*/
			$data['data_map_latitude'] = $this->input->post('lat');
			$data['data_map_longitude'] = $this->input->post('lon');
			$this->mdl_map->update_trkib($no_reg,$golongan,$data);
			//print_r($data);
			//$this->mdl_map->add_resp($gol,$data);
			//Data GIS
			//$data2['data_no_reg'] = $this->input->post('noreg');
			//$data2['data_map_latitude'] = $this->input->post('lat');
			//$data2['data_map_longitude'] = $this->input->post('lon');
			//$data2['data_tanggal_entry'] = $this->input->post('tglser');
			//$data2['data_status'] = '1';
			//print_r($data2);
			//$this->mdl_map->add_resp_gis($gol,$data2);
		}
	}
	
	
	public function get_asetunit() {
		$data = array();
		$data['aset'] = array();
		if($input = $this->input->post()) {
			$kdskpd = isset($input['kdskpd'])?$input['kdskpd']:'';
			$kdbidang = isset($input['kdbidang'])?$input['kdbidang']:'';
			//echo(kdbidang);exit;

				if(substr($kdbidang,0,2)=='02'){
				//if($kdbidang=='02'){
				     $asets = $this->mdl_map->get_data_asetunitb($kdskpd,$kdbidang)->result_array();
				     $layout='map/asetunit_b';
				}
				else if(substr($kdbidang,0,2)=='05'){
				//else if($kdbidang=='05'){
				   $asets = $this->mdl_map->get_data_asetunite($kdskpd,$kdbidang)->result_array();
				   $layout='map/asetunit_e';
				}
				
				//echo($this->db->last_query());
				//exit;				
				//var_dump($asets);exit;
				 
				if(count($asets)>0) {
					$data['aset'] = $asets;				 
				}
			}
				$this->template->single($layout, $data);
	}

	public function add_skpd() {
		$data = array();
		$responden = array();
		if($input = $this->input->post()) {
			$data['lat'] = $this->input->post('lat');
			$data['long'] = $this->input->post('lng');
			$data['kdskpd'] = $this->input->post('kdskpd');
		    $data['nmskpd'] = $this->input->post('nmskpd');
			
		    $responden = $this->mdl_map->get_data_uskpd($data['kdskpd'])->row_array();
			$data['resp'] = $responden;
		}
		$this->template->single('map/addskpd', $data);
	}
	
	public function save_skpd(){
		$data = array();
		if($input = $this->input->post()) {
			$kdskpd = $this->input->post('kdskpd');
			$data['data_map_latitude'] = $this->input->post('lat');
			$data['data_map_longitude'] = $this->input->post('lon');
			$this->mdl_map->update_skpd($kdskpd,$data);
		}
	}
	
	public function petauskpd($id) {
		$data = array('status'=>false);
	
		if(substr($id,0,2)=='02'){
		   $asets = $this->mdl_map->get_all_kibb(substr($id,0,4))->result_array();
		}
		else if(substr($id,0,2)=='05'){
		   $units = $this->mdl_map->get_all_kibe(substr($id,0,4))->result_array();
		}

		if(count($units)>0) {
			$data = array('status'=>true);
			if( (substr($id,0,2)=='02') or (substr($id,0,2)=='05') ){
			  $legend = $this->mdl_map->get_nm_kelompok($id)->result_array();
			}
			else {
			  $legend ="test";
			  
			}
		    $data['legend']=$legend;
			$data['units'] = $units;
		}

		echo json_encode($data);
	}
}

