<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anak extends CI_Controller {

	public function index($idPegawai)
	{
		$this->load->model('pegawai_model');
		$data["anak_list"] = $this->pegawai_model->getAnakByPegawai($idPegawai);
		$this->load->view('anak',$data);	
	
	}
	
	public function create($idPegawai)
	{
		// idPegawai = 1
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->load->model('pegawai_model');	
		if($this->form_validation->run()==FALSE){
			$this->load->view('tambah_anak_view');
		}else{
			$this->pegawai_model->insertAnak($idPegawai);
			$this->load->view('tambah_pegawai_sukses');
		}
	}

	public function update($id)
	{
		$this->load->helper('url','form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		//$this->form_validation->set_rules('Nip','nip','trim|required');
		//$this->form_validation->set_rules('Tanggal','tanggal','trim|required');
		//$this->form_validation->set_rules('Alamat','alamat','trim|required');

		$this->load->model('pegawai_model');
		$data['anak']=$this->pegawai_model->getAnak($id);

		if($this->form_validation->run()==FALSE)
		{
			$this->load->view('edit_anak_view',$data);
		}
		else
		{

			$this->pegawai_model->UpdateAnakById($id);
			$this->load->view('edit_pegawai_sukses');
		}

	}

	public function delete($id)
	{
		$this->load->model('pegawai_model');
		$data["anak"] = $this->pegawai_model->deleteById($id);
		$this->load->view('hapus_pegawai_sukses',$data);	
	}
}




/* End of file Anak.php */
/* Location: ./application/controllers/Anak.php */
 ?>