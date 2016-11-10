<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ERROR_PASSWORD', 1);
define('ERROR_USERNAME', 2);
define('ERROR_EMPTY', 3);

class LAuth {

	var $CI;

	var $loginPrefix = 'GL_';

	var $error = false;

	var $errorMessage = array(
		ERROR_EMPTY => "Username &amp; Password tidak boleh kosong",
		ERROR_USERNAME => "Username atau Password Salah",
		ERROR_PASSWORD => "Username atau Password Salah",
	);

	function __construct() {
		$this->CI =& get_instance();
	}

	public function raise_error($errorNumber) {
		$this->error = $errorNumber;
	}

	public function login($username, $password) {
		$this->CI->load->model('mdl_user', 'user');
		$user = $this->CI->user->getUser($username);
		if($user->row()) {
			$uData = $user->row();
			if($uData->password == md5($password)) {
				$this->CI->session->set_userdata($this->loginPrefix.'isLogin', true);
				$this->CI->session->set_userdata($this->loginPrefix.'username', $username);
				return true;
			}
			$this->raise_error(ERROR_PASSWORD);
			return false;
		}
		$this->raise_error(ERROR_USERNAME);
		return false;
	}

	public function get_session($label) {
		return $this->CI->session->userdata($this->loginPrefix.$label);
	}

	public function get_error() {
		if($this->error) {
			return $this->errorMessage[$this->error];
		}
		return false;
	}

	public function is_error() {
		return $this->error;
	}

	public function isLoggedIn() {
		if($this->CI->session->userdata($this->loginPrefix.'isLogin')) {
			return true;
		}
		return false;
	}

	public function logout() {
		$this->CI->session->sess_destroy();
	}
}
