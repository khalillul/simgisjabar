<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_User extends CI_Model {

	var $tablename = 'tbluser';

	function getUser($username) {
		// $this->db->flush_cache();
		$this->db->from($this->tablename)->where('username', $username);
		return $this->db->get();
	}

	function getAllUser() {
		return $this->db->from($this->tablename)->get();
	}

}