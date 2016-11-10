<?php
class Mdl_map extends CI_Model{

	function __construct(){
		parent:: __construct();
	}

	/* Start of generate Identity */
	function get_empty_id($kelurahan_id) {
		//$this->db->select('data_id,data_nomor_identitas,data_map_latitude,data_map_longitude,data_responden_nik,data_responden_nama,data_responden_alamat,data_responden_rt,data_responden_rw,data_responden_kelurahan_id,data_responden_telepon,data_responden_jumlah_kk,data_responden_jumlah_jiwa');
		$this->db->select('data_id');
		$this->db->where('data_responden_kelurahan_id', $kelurahan_id);
		$this->db->where('data_nomor_identitas', '');
		$this->db->order_by('data_id', 'ASC');
		return $this->db->get('datas', 1000, 0);
	}
	function get_last_inch($kelurahan_id) {
		$this->db->select('data_nomor_identitas');
		$this->db->where('data_responden_kelurahan_id', $kelurahan_id);
		$this->db->where('data_nomor_identitas != ""');
		$this->db->order_by('data_id', 'DESC');
		return $this->db->get('datas', 1, 1);
	}
	function update_identity($id, $data) {
		$this->db->where('data_id', $id);
		$this->db->update('datas', $data);
	}
	/* End of generate Identity */

	function get_all_responden() {
		//$this->db->select('data_id, data_nomor_identitas, data_map_latitude, data_map_longitude, data_responden_nik, data_responden_nama, data_responden_alamat, data_responden_rt, data_responden_rw, data_responden_kelurahan_id, data_responden_telepon');
		$this->db->select('*');
		$this->db->where('data_map_latitude != ""');
		$this->db->where('data_map_longitude != ""');
		$this->db->where('data_status', 1);
		$this->db->where('data_responden_kelurahan_id', $this->session->userdata['user_data']['kelurahan_id']);
		$this->db->order_by('data_id', 'RANDOM');
		return $this->db->get('datas');
	}

	function get_data_id_by_pilihan($rt, $rw, $pid) {
		$this->db->select('data_id');
		$this->db->join('datas', 'data_kuisoner_data_id = data_id');
		$this->db->where('data_responden_rt', $rt);
		$this->db->where('data_responden_rw', $rw);
		$this->db->where('data_kuisoner_pilihan_id', $pid);
		return $this->db->get('data_kuisoner');
	}



	function get_responden($id, $table_name) {
		$this->db->query("call sp_datas('', 'data_id = ".$id." AND data_status = 1','', '".$table_name."');");
		clean_mysqli_connection($this->db->conn_id);
		$this->db->where('data_id', $id);
		return $this->db->get($table_name);
	}

	function get_all_kuisoner() {
		$this->db->join('kuisoner', 'kuisoner_group.kuisoner_group_id = kuisoner.kuisoner_group_id');
		$this->db->where('kuisoner_group_status', 1);
		$this->db->where('kuisoner_status', 1);
		$this->db->order_by('kuisoner_group_urutan, kuisoner_urutan', 'ASC');
		return $this->db->get('kuisoner_group');
	}

	function get_kuisoner_for_recap() {
		$this->db->select('kuisoner_group.kuisoner_group_id,kuisoner_group_nama,kuisoner_id,kuisoner_rekap_nama');
		$this->db->join('kuisoner', 'kuisoner_group.kuisoner_group_id = kuisoner.kuisoner_group_id');
		$this->db->where('kuisoner_group_status', 1);
		$this->db->where('kuisoner_status', 1);
		$this->db->where('kuisoner_rekap', 1);
		$this->db->order_by('kuisoner_group_urutan, kuisoner_urutan', 'ASC');
		return $this->db->get('kuisoner_group');
	}

	function get_kuisoner_item($kuisoner) {
		$this->db->select('kuisoner_pilihan_id,kuisoner_pilihan_teks');
		$this->db->where('kuisoner_pilihan_kuisoner_id', $kuisoner);
		$this->db->where('kuisoner_pilihan_parent_id', 0);
		$this->db->where('kuisoner_pilihan_status', 1);
		return $this->db->get('ppuc_kuisoner_pilihan');
	}

	function get_kuisoner_group() {
		$this->db->order_by('kuisoner_group_urutan','ASC');
		return $this->db->get('kuisoner_group');
	}

	function get_kelurahan_data($kelurahan_id) {
		$this->db->select('kecamatan_id, kelurahan_id, kecamatan_nama, kelurahan_nama');
		$this->db->join('ppuc_kecamatan', 'kelurahan_kecamatan_id = kecamatan_id');
		$this->db->where('kelurahan_id', $kelurahan_id);
		return $this->db->get('ppuc_kelurahan');
	}

	function get_rw($kelurahan_id) {
		$this->db->select('rw');
		$this->db->where('kel', $kelurahan_id);
		$this->db->group_by('rw');
		$this->db->order_by('rw', 'ASC');
		return $this->db->get('view_area');
	}
	function get_rt($kelurahan_id, $rw) {
		$this->db->select('rt');
		$this->db->where('rw', $rw);
		$this->db->where('kel', $kelurahan_id);
		$this->db->group_by('rt');
		$this->db->order_by('rt', 'ASC');
		return $this->db->get('view_area');
	}
	
	
	//abah fungsi untuk get golongan aset
	
	function get_mgolongan() {
		$this->db->select('*');
		$this->db->where('jenis','1');
		$this->db->order_by('golongan','ASC');
		return $this->db->get('mgolongan');
			//$this->db->where('golongan',$golongan);
	}
	
	function get_mgolongan_for_recap() {
		$this->db->select('mgolongan.golongan,nm_golongan,bidang,nm_bidang');
		$this->db->join('mbidang', 'mgolongan.golongan = mbidang.golongan');	
		$this->db->where('jenis','1');		
		$this->db->order_by('golongan, bidang', 'ASC');		
		return $this->db->get('mgolongan');
	}
	
	function get_all_kiba($bidang) {
		$this->db->select('*'); 
		$this->db->join('mbarang', 'trkib_a.kd_brg = mbarang.kd_brg');	 
		//$this->db->join('mkelompok1', 'mbarang.kd_kelompok = mkelompok1.kd_kelompok');	 
		$this->db->where('data_map_latitude != ""');
		$this->db->where('data_map_longitude != ""');
		$this->db->where('substr(trkib_a.kd_brg,1,4)',$bidang);
		return $this->db->get('trkib_a');
	}
	
	function get_detail_kiba($no_reg) {
		$this->db->select('*'); 
		$this->db->from('trkib_a'); 
		$this->db->join('mbarang', 'trkib_a.kd_brg = mbarang.kd_brg');	 
		$this->db->where('no_reg',$no_reg);
		return $this->db->get();
	}
	
	function get_detail_aset($no_reg,$gol) {
		if($gol=='01'){$table='trkib_a';}
		if($gol=='02'){$table='trkib_b';}
		if($gol=='03'){$table='trkib_c';}
		if($gol=='04'){$table='trkib_d';}
		if($gol=='05'){$table='trkib_e';}
		$this->db->select('*'); 
		$this->db->from($table); 
		$this->db->join('mbarang', $table.'.kd_brg = mbarang.kd_brg');
		if(($gol=='02')or($gol=='05')){
			$this->db->join('unit_skpd', $table.'.kd_unit = unit_skpd.kd_uskpd');	 
		}
		$this->db->where('no_reg',$no_reg);
		return $this->db->get();
	}
	
	function get_all_kibb($bidang) {
	   /// $filter ='substring(trkib_b.kd_unit,1,5)';
		//$data1='substr(trkib_b.kd_brg,1,4) AS bidang';
	
		///$this->db->select('unit_skpd.*,trkib_b.kd_brg,trkib_b.no_reg'); 
		//$this->db->join('mbarang', 'trkib_b.kd_brg = mbarang.kd_brg');	
		//$this->db->join('unit_skpd','trkib_b.kd_unit=unit_skpd.kd_uskpd');
		//$this->db->join('unit_skpd','substr(trkib_b.kd_unit,1,5)'='unit_skpd.kd_uskpd');	
		//func
	///	$this->db->join('unit_skpd','substr(trkib_b.kd_unit,1,5)'='unit_skpd.kd_uskpd');	
		//$this->db->join('unit_skpd',$filter);	
		//$this->db->where('trkib_b.data_map_latitude != ""');
		//$this->db->where('trkib_b.data_map_longitude != ""');
	///	$this->db->where('substr(trkib_b.kd_brg,1,4)',$bidang);
	///	return $this->db->get('trkib_b');
		
   		$sql = "SELECT unit_skpd.*,trkib_b.kd_brg,trkib_b.no_reg FROM trkib_b ";
		$sql .= " JOIN unit_skpd ON SUBSTR(trkib_b.kd_unit,1,5)=unit_skpd.kd_uskpd ";
		$sql .= " WHERE SUBSTR(trkib_b.kd_brg,1,4) = $bidang ";  
        //echo $sql;exit; 		
   		return $this->db->query($sql); 
	
		
	}
	
	function get_all_kibc($bidang) {
		//$this->db->select('data_id, data_nomor_identitas, data_map_latitude, data_map_longitude, data_responden_nik, data_responden_nama, data_responden_alamat, data_responden_rt, data_responden_rw, data_responden_kelurahan_id, data_responden_telepon');
		$this->db->select('*'); 
		$this->db->join('mbarang', 'trkib_c.kd_brg = mbarang.kd_brg');	 
		$this->db->where('data_map_latitude != ""');
		$this->db->where('data_map_longitude != ""');
		$this->db->where('substr(trkib_c.kd_brg,1,4)',$bidang);
		return $this->db->get('trkib_c');
	}
	
		function get_all_kibd($bidang) {
		//$this->db->select('data_id, data_nomor_identitas, data_map_latitude, data_map_longitude, data_responden_nik, data_responden_nama, data_responden_alamat, data_responden_rt, data_responden_rw, data_responden_kelurahan_id, data_responden_telepon');
		$this->db->select('*'); 
		$this->db->join('mbarang', 'trkib_d.kd_brg = mbarang.kd_brg');	 
		$this->db->where('data_map_latitude != ""');
		$this->db->where('data_map_longitude != ""');
		$this->db->where('substr(trkib_d.kd_brg,1,4)',$bidang);
		return $this->db->get('trkib_d');
	}
	
		function get_all_kibe($bidang) {
			$sql = "SELECT unit_skpd.*,trkib_e.kd_brg,trkib_e.no_reg FROM trkib_e ";
			$sql .= " JOIN unit_skpd ON SUBSTR(trkib_e.kd_unit,1,5)=unit_skpd.kd_uskpd ";
			$sql .= " WHERE SUBSTR(trkib_e.kd_brg,1,4) = $bidang ";  
			//echo $sql;exit; 		
			return $this->db->query($sql); 
	}
	
	function get_all_kibf($bidang) {
		//$this->db->select('data_id, data_nomor_identitas, data_map_latitude, data_map_longitude, data_responden_nik, data_responden_nama, data_responden_alamat, data_responden_rt, data_responden_rw, data_responden_kelurahan_id, data_responden_telepon');
		$this->db->select('*'); 
		$this->db->join('mbarang', 'trkib_f.kd_brg = mbarang.kd_brg');	 
		$this->db->where('data_map_latitude != ""');
		$this->db->where('data_map_longitude != ""');
		$this->db->where('substr(trkib_f.kd_brg,1,4)',$bidang);
		return $this->db->get('trkib_f');
	}
	
	function get_all_uskpd() {
		//$this->db->select('data_id, data_nomor_identitas, data_map_latitude, data_map_longitude, data_responden_nik, data_responden_nama, data_responden_alamat, data_responden_rt, data_responden_rw, data_responden_kelurahan_id, data_responden_telepon');
		$this->db->select('*');
		$this->db->where('data_map_latitude != ""');
		$this->db->where('data_map_longitude != ""');
		//$this->db->where('data_responden_kelurahan_id', $this->session->userdata['user_data']['kelurahan_id']);
		//$this->db->order_by('data_id', 'RANDOM');
		return $this->db->get('unit_skpd_gis');
	}
	
	function get_nm_kelompok($id) {
		$this->db->select('kelompok,nm_kelompok');
		$this->db->where('bidang', $id);
		return $this->db->get('mkelompok');
	}
	
	function get_data_trkiba($id) {
		$this->db->select('*');
		//$this->db->join('trkib_a', 'trkib_a.no_reg = trkiba_gis.data_no_reg');	 
        $this->db->join('mbarang', 'trkib_a.kd_brg = mbarang.kd_brg');	 
		$this->db->where('no_reg',$id);
		//$this->db->where('data_status', 1);
		return $this->db->get('trkib_a');
	}
		
	function get_data_uskpd($id) {
		$this->db->select('*');
		$this->db->where('kd_uskpd',$id);
		return $this->db->get('unit_skpd');
	}
		
	function get_data_asset_uskpd($cat,$uskpd) {
		$this->db->select('*');
		$table = 'trkib_b';
		$this->db->join('mbarang',$table.'.kd_brg=mbarang.kd_brg');
		$this->db->where('kd_unit',$uskpd);
		return $this->db->get($table);
	}
	
	function get_data_trkibb($id) {
		$this->db->select('*'); 
        $this->db->join('mbarang', 'trkib_b.kd_brg = mbarang.kd_brg');	 
		$this->db->where('no_reg',$id);
		//$this->db->where('data_status', 1);
		return $this->db->get('trkib_b');
	}
	
	
	function get_data_trkibc($id) {
		$this->db->select('*');
		//$this->db->join('trkib_a', 'trkib_a.no_reg = trkiba_gis.data_no_reg');	 
        $this->db->join('mbarang', 'trkib_c.kd_brg = mbarang.kd_brg');	 
		$this->db->where('no_reg',$id);
		//$this->db->where('data_status', 1);
		return $this->db->get('trkib_c');
	}
	
	function get_data_trkibd($id) {
		$this->db->select('*');
		//$this->db->join('trkib_a', 'trkib_a.no_reg = trkiba_gis.data_no_reg');	 
        $this->db->join('mbarang', 'trkib_d.kd_brg = mbarang.kd_brg');	 
		$this->db->where('no_reg',$id);
		//$this->db->where('data_status', 1);
		return $this->db->get('trkib_d');
	}
	
	function get_data_trkibe($id) {
		$this->db->select('*');
		//$this->db->join('trkib_a', 'trkib_a.no_reg = trkiba_gis.data_no_reg');	 
        $this->db->join('mbarang', 'trkib_e.kd_brg = mbarang.kd_brg');	 
		$this->db->where('no_reg',$id);
		//$this->db->where('data_status', 1);
	return $this->db->get('trkib_e');
	}
	
	function get_data_trkibf($id) {
		$this->db->select('*');
		//$this->db->join('trkib_a', 'trkib_a.no_reg = trkiba_gis.data_no_reg');	 
        $this->db->join('mbarang', 'trkib_f.kd_brg = mbarang.kd_brg');	 
		$this->db->where('no_reg',$id);
		//$this->db->where('data_status', 1);
	return $this->db->get('trkib_f');
	}
	
	
	
	function get_quick_search($keyword, $rws=false, $table) {
	    //$join = $table.".noreg";
		$this->db->select('*');
		if($table=='') {
		   $table="trkib_a";
		}
    
		//$this->db->join('trkiba_gis', $table.".no_reg" ."= trkiba_gis.data_no_reg");			
		//$this->db->join('trkiba_gis', 'trkib_a.no_reg = trkiba_gis.data_no_reg');	 
		$this->db->like('no_reg', $keyword);
		//if($rws) {
		//	$this->db->where('data_responden_rw', $rws);
		//}
		// 'trkiba_gis.data_no_reg'' 
		return $this->db->get($table);
	}
	
	function get_add_search($keyword, $rws=false, $table) {
	    //$join = $table.".noreg";
		$this->db->select('*');
		if($table=='') {
		   $table="trkib_a";
		}
		$this->db->like('no_reg', $keyword);
		//if($rws) {
		//	$this->db->where('data_responden_rw', $rws);
		//}
		// 'trkiba_gis.data_no_reg'' 
		return $this->db->get($table);
	}
	
	function get_search_skpd($keyword) {
		$query = "SELECT * FROM unit_skpd WHERE nm_uskpd LIKE '%$keyword%' OR kd_uskpd LIKE '%$keyword%'";
		
		return $this->db->query($query);
	}
	
	function get_mod_quick_search($keyword, $table, $tablegis, $gol, $bid, $kel, $sub) {
		//$this->db->select('*');
		if($table=='') {
		   $table="trkib_a";
		}
		if($tablegis=='') {
			$tablegis="trkiba_gis";
		}
		//$this->db->join('trkiba_gis', $table.".no_reg" ."= trkiba_gis.data_no_reg");
		$filreg = $gol;
		if($bid!='nol'){$filreg=$bid;}
		if($kel!='nol'){$filreg=$kel;}
		if($sub!='nol'){$filreg=$sub;}
		//$this->db->like('no_reg', $keyword);
		$query = "SELECT * FROM ".$table." JOIN ".$tablegis." ON ".$table.".no_reg = ".$tablegis.".data_no_reg WHERE ".$table.".no_reg LIKE '".$filreg."%".$keyword."%'";
		return $this->db->get($query);
	}
	
	function get_bid_by_gol($golongan){
		$this->db->select('*');
		$this->db->from('mbidang');
		$this->db->where('golongan',$golongan);
		$this->db->order_by('bidang','ASC');
		return $this->db->get();
	}
	
	function get_kel_by_bid($bidang){
		$this->db->select('*');
		$this->db->from('mkelompok');
		$this->db->where('bidang',$bidang);
		$this->db->order_by('kelompok','ASC');
		return $this->db->get();
	}
	
	function get_sub_by_kel($kelompok){
		$this->db->select('*');
		$this->db->from('mkelompok1');
		$this->db->where('kelompok',$kelompok);
		$this->db->order_by('kd_kelompok','ASC');
		return $this->db->get();
	}
	
	function get_brg_by_sub($kelompok){
		$this->db->select('*');
		$this->db->from('mbarang');
		$this->db->where('kd_kelompok',$kelompok);
		$this->db->order_by('kd_brg','ASC');
		return $this->db->get();
	}
	
	function add_resp($gol, $data){
		$this->db->flush_cache();
		if($gol=='01'){$table='trkib_a';}
		if($gol=='02'){$table='trkib_b';}
		if($gol=='03'){$table='trkib_c';}
		if($gol=='04'){$table='trkib_d';}
		if($gol=='05'){$table='trkib_e';}
		$result = $this->db->insert($table,$data);
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	function update_trkib($noreg,$gol,$data) {
	    //echo $gol;
		//$this->db->flush_cache();
	    if($gol=='01'){$table='trkib_a';}
		else if($gol=='02'){$table='trkib_b';}
		else if($gol=='03'){$table='trkib_c';}
		else if($gol=='04'){$table='trkib_d';}
		else if($gol=='05'){$table='trkib_e';}

		echo $table;
		//$this->db->where('no_reg', $noreg);
		//$result = $this->db->update("'".$tabel."'",$data);
		$sql = "update ".$table."  set data_map_latitude='".$data['data_map_latitude']."',data_map_longitude='".$data['data_map_longitude']."' ";
		$sql .= "where no_reg='".$noreg."'";
		return $this->db->query($sql); 
		/*
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
		*/
	}
	
	function update_skpd($kdskpd,$data) {
		$table = "unit_skpd";
		$sql = "update ".$table."  set data_map_latitude='".$data['data_map_latitude']."',data_map_longitude='".$data['data_map_longitude']."' ";
		$sql .= "where kd_uskpd='".$kdskpd."'";
		return $this->db->query($sql); 
	}
	
	
	function add_resp_gis($gol, $data){
		$this->db->flush_cache();
		if($gol=='01'){$table='trkiba_gis';}
		if($gol=='02'){$table='trkibb_gis';}
		if($gol=='03'){$table='trkibc_gis';}
		if($gol=='04'){$table='trkibd_gis';}
		if($gol=='05'){$table='trkibe_gis';}
		$result = $this->db->insert($table,$data);
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	function get_data_asetunitb($kdskpd,$kdbarang) {
	    $filter ='substr(trkib_b.kd_unit,1,5)';
		$this->db->select('*');
		//$this->db->join('trkib_a', 'trkib_a.no_reg = trkiba_gis.data_no_reg');	 
        $this->db->join('mbarang', 'trkib_b.kd_brg = mbarang.kd_brg');
		$this->db->join('unit_skpd', $filter = 'unit_skpd.kd_uskpd');
		$this->db->where('substr(trkib_b.kd_unit,1,5)',$kdskpd);
		$this->db->where('substr(trkib_b.kd_brg,1,4)',$kdbarang);
		$this->db->where('unit_skpd.kd_uskpd',$kdskpd);
		//$this->db->where('data_status', 1);
		return $this->db->get('trkib_b');
	}
	
	function get_data_asetunite($kdskpd,$kdbarang) {
	    $filter ='substr(trkib_e.kd_unit,1,5)';
		$this->db->select('*');
		//$this->db->join('trkib_a', 'trkib_a.no_reg = trkiba_gis.data_no_reg');	 
        $this->db->join('mbarang', 'trkib_e.kd_brg = mbarang.kd_brg');
		$this->db->join('unit_skpd', $filter = 'unit_skpd.kd_uskpd');
		$this->db->where('substr(trkib_e.kd_unit,1,5)',$kdskpd);
		$this->db->where('substr(trkib_e.kd_brg,1,4)',$kdbarang);
		$this->db->where('unit_skpd.kd_uskpd',$kdskpd);
		//$this->db->where('data_status', 1);
		return $this->db->get('trkib_e');
	}
		
	function set_detail_kiba($data) {
	    if($data['bidang']=='01'){$table='trkib_a';}
		else if($data['bidang']=='02'){$table='trkib_b';}
		else if($data['bidang']=='03'){$table='trkib_c';}
		else if($data['bidang']=='04'){$table='trkib_d';}
		else if($data['bidang']=='05'){$table='trkib_e';}

		$this->db->set('data_map_latitude', $data['data_map_latitude']);
		$this->db->set('data_map_longitude', $data['data_map_longitude']);
		$this->db->where('no_reg', $data['no_reg']);
		// $sql = "update ".$table."  set data_map_latitude='".$data['data_map_latitude']."',data_map_longitude='".$data['data_map_longitude']."' ";
		// $sql .= "where no_reg='".$data['no_reg']."'";
		return $this->db->update($table);
	}
	
	function set_detail_uskpd($data) {
	    $this->db->set('data_map_latitude', $data['data_map_latitude']);
		$this->db->set('data_map_longitude', $data['data_map_longitude']);
		$this->db->where('kd_uskpd', $data['kd_uskpd']);
		// $sql = "update ".$table."  set data_map_latitude='".$data['data_map_latitude']."',data_map_longitude='".$data['data_map_longitude']."' ";
		// $sql .= "where no_reg='".$data['no_reg']."'";
		return $this->db->update('unit_skpd');
	}
	
	function get_unit_detail($data){
		$this->db->from('unit_skpd');
		$this->db->where('kd_uskpd',$data['kd_uskpd']);
		return $this->db->get();
	}
	
	function get_spesific_unit($gol,$bid){
		if($gol='02'){$table='trkib_b';}
		else if($gol='05'){$table='trkib_e';}
		
		$this->db->select('unit_skpd.*');
		$this->db->from($table);
		$this->db->join('mbarang', $table.'.kd_brg = mbarang.kd_brg');
		$this->db->join('mkelompok1', 'mbarang.kd_kelompok = mkelompok1.kd_kelompok');
		$this->db->join('mkelompok', 'mkelompok1.kelompok = mkelompok.kelompok');
		$this->db->join('mbidang', 'mkelompok.bidang = mbidang.bidang');
		$this->db->join('unit_skpd', $table.'.kd_unit = unit_skpd.kd_uskpd');
		$this->db->where('mkelompok.bidang', $bid);
		$this->db->group_by("unit_skpd.kd_uskpd"); 
		
		return $this->db->get();
	}
	
	function get_unit_legend($gol,$bid){
		if($gol='02'){$table='trkib_b';}
		else if($gol='05'){$table='trkib_e';}
		
		$this->db->select('unit_skpd.*');
		$this->db->from($table);
		$this->db->join('mbarang', $table.'.kd_brg = mbarang.kd_brg');
		$this->db->join('mkelompok1', 'mbarang.kd_kelompok = mkelompok1.kd_kelompok');
		$this->db->join('mkelompok', 'mkelompok1.kelompok = mkelompok.kelompok');
		$this->db->join('mbidang', 'mkelompok.bidang = mbidang.bidang');
		$this->db->join('unit_skpd', $table.'.kd_unit = unit_skpd.kd_uskpd');
		$this->db->where('mkelompok.bidang', $bid);
		$this->db->group_by("unit_skpd.kd_uskpd"); 
		
		return $this->db->get();
	}
	
	function get_spesific_aset($data){
		if($data['gol']='02'){$table='trkib_b';}
		else if($data['gol']='05'){$table='trkib_e';}
		
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('mbarang', $table.'.kd_brg = mbarang.kd_brg');
		$this->db->join('mkelompok1', 'mbarang.kd_kelompok = mkelompok1.kd_kelompok');
		$this->db->join('mkelompok', 'mkelompok1.kelompok = mkelompok.kelompok');
		$this->db->join('mbidang', 'mkelompok.bidang = mbidang.bidang');
		$this->db->join('unit_skpd', $table.'.kd_unit = unit_skpd.kd_uskpd');
		$this->db->where('mkelompok.bidang', $data['bid']);
		$this->db->where('unit_skpd.kd_uskpd', $data['kd_uskpd']);
		
		return $this->db->get();
	}
	
	function get_golongan($bid){
		
		$this->db->select('*');
		$this->db->from('mbidang');
		$this->db->join('mgolongan','mbidang.golongan=mgolongan.golongan');
		$this->db->where('mbidang.bidang',$bid);
		
		return $this->db->get();
	}
	
}