<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_data extends CI_Model {

	var $tablename = 'mgolongan';

	function getGolCount() {
		$this->db->from($this->tablename)->where('jenis', '1');
		return $this->db->count_all_results();
	}


  function getWilayah() {
   $this->db->select('*');
   $this->db->from('mwilayah');
   $query = $this->db->get();
   
   return $query->result();
  }



	function getBidangByGol($golongan) {
		$this->db->from('mbidang')->where('golongan', $golongan);
		return $this->db->get();
	}

	function getKelompokByBid($bidang) {
		$this->db->from('mkelompok')->where('bidang', $bidang);
		return $this->db->get();
	}
	
	function getSubkelByKel($kelompok) {
		$this->db->from('mkelompok1')->where('kelompok', $kelompok);
		return $this->db->get();
	}
	
	function getBarangBySub($sub) {
		$this->db->from('mbarang')->where('kd_kelompok', $sub);
		return $this->db->get();
	}
	
	function getFilter($data) {
		$tablename = '';
		if($data['gol']=='01'){$tablename="trkib_a";}
		elseif($data['gol']=='02'){$tablename="trkib_b";}
		elseif($data['gol']=='03'){$tablename="trkib_c";}
		elseif($data['gol']=='04'){$tablename="trkib_d";}
		elseif($data['gol']=='05'){$tablename="trkib_e";}
		elseif($data['gol']=='06'){$tablename="trkib_f";}
		
		$this->db->from($tablename);
		$this->db->join('mbarang', $tablename.'.kd_brg = mbarang.kd_brg');	 
		$this->db->join('mkelompok1', 'mbarang.kd_kelompok = mkelompok1.kd_kelompok');
		$this->db->join('mkelompok', 'mkelompok1.kelompok = mkelompok.kelompok');
		$this->db->join('mbidang', 'mkelompok.bidang = mbidang.bidang');
		
		if($data['reg']!=''){$this->db->like('no_reg', $data['reg'], 'both');}
		if($data['bid']!=''){$this->db->like('mbidang.bidang', $data['bid'], 'both');}
		if($data['kel']!=''){$this->db->like('mkelompok.kelompok', $data['kel'], 'both');}
		if($data['sub']!=''){$this->db->like('mkelompok1.kd_kelompok', $data['sub'], 'both');}
		if($data['brg']!=''){$this->db->like('mbarang.kd_brg', $data['brg'], 'both');}
		
		return $this->db->get();
	}
	
	function getUnitFilter($data) {
		$tablename = 'unit_skpd';
		
		$this->db->from($tablename);
		
		if($data['fil']!=''){
			$this->db->like('kd_uskpd', $data['fil']);
			$this->db->or_like('nm_uskpd', $data['fil']);
		}
			
		return $this->db->get();
	}
}