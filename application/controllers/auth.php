<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {

	// public function before() {
	// 	$this->load->library('lauth');
	// 	if($this->lauth->isLoggedIn() && $this->uri->segment(1) != 'logout') {
	// 		redirect('');
	// 	}
	// }

	public function index() {
		// $data = array(
		// 	'error' => $this->lauth->is_error(),
		// 	'errorMessage' => $this->lauth->get_error(),
		// );
		///$this->load->view('simgisjabar/login/login', $data);
		$this->load->view('simgisjabar');
	}

	// public function login() {
	// 	$username = $this->input->post('username');
	// 	$password = $this->input->post('password');
	// 	if((!isset($username) || $username == '') || (!isset($password) || $password == '')) {
	// 		$this->lauth->raise_error(ERROR_EMPTY);
	// 	} else {
	// 		if($this->lauth->login($username, $password)) {
	// 			redirect('');
	// 		}
	// 	}
	// 	$data = array(
	// 		'error' => $this->lauth->get_error(),
	// 		'errorMessage' => $this->lauth->get_error(),
	// 	);
	// 	$this->load->view('simgisjabar/login/login', $data);
	// }

	// public function logout() {
	// 	$this->lauth->logout();
	// 	redirect('');
	// }
}
