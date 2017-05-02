<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('login');		
	}

	public function cekLogin()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_cekDb');
		if($this->form_validation->run()==false){
			$this->load->view('login');
		}else{
			redirect('Pegawai','refresh');
		}
	}

	public function cekDb($password)
	{
		$this->load->model('user');
		$username = $this->input->post('username');
		$result = $this->user->login($username,$password);
		if($result){
			$sess_array = array();
			foreach ($result as $row) {
				$sess_array = array(
					'id'=>$row->id,
					'username'=> $row->username
				);
				$this->session->set_userdata('logged_in',$sess_array);
			}
			return true;
		}else{
			$this->form_validation->set_message('cekDb',"Login Gagal Username dan Password tidak valid");
			return false;
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('login','refresh');
	}

	public function create()
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		// $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[user.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_cekDbInsert');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->load->model('user');	
		if($this->form_validation->run()==FALSE){

			$this->load->view('tambah_user_view');

		}else{
			$this->user->insertUser();
			$this->load->view('tambah_pegawai_sukses');
		} 
	}

	// public function cekDbInsert($username)
	// {
	// 	$this->load->model('user');
	// 	$username = $this->input->post('username');
	// 	$result = $this->user->cekInsert($username);
	// 	if($result){
	// 		$sess_array = array();
	// 		foreach ($result as $row) {
	// 			$sess_array = array(
	// 				'id'=>$row->id,
	// 				'username'=> $row->username
	// 			);
	// 		}
	// 		return true;
	// 	}else{
	// 		$this->form_validation->set_message('cekDbInsert',"Username sudah ada!");
	// 		return false;
	// 	}
	// }

	public function cekDbInsert()
	{
		$this->load->model('user');
		$username = $this->input->post('username');
		$result = $this->user->cekInsert($username);
		if($result){
			$this->form_validation->set_message('cekDbInsert',"Username Sudah Ada!");
			return false;
		}
		else{
			return true;
		}
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
?>