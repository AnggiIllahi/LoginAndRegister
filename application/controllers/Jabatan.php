<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {

	public function index($idPegawai)
	{
		$this->load->model('pegawai_model');		
		$data["jabatan_list"] = $this->pegawai_model->getJabatanByPegawai($idPegawai);
		$this->load->view('jabatan', $data);
	}

	public function datatableJabatan()
	{
		$this->load->model('pegawai_model');
		$data["jabatan_list"] = $this->pegawai_model->getJabatanByPegawai($idPegawai);
		$this->load->view('jabatan',$data);	
	}

	public function create($idPegawai)
	{
		// idPegawai = 1
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
		$this->load->model('pegawai_model');	
		if($this->form_validation->run()==FALSE){
			$this->load->view('tambah_jabatan_view');
		}else{
			$this->pegawai_model->insertJabatan($idPegawai);
			$this->load->view('tambah_pegawai_sukses');
		}
	}

	public function update($id)
	{
		$this->load->helper('url','form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jabatan', 'Nama', 'trim|required');
		//$this->form_validation->set_rules('Nip','nip','trim|required');
		//$this->form_validation->set_rules('Tanggal','tanggal','trim|required');
		//$this->form_validation->set_rules('Alamat','alamat','trim|required');

		$this->load->model('pegawai_model');
		$data['jabatan']=$this->pegawai_model->getJabatan($id);

		if($this->form_validation->run()==FALSE)
		{
			$this->load->view('edit_jabatan_view',$data);
		}
		else
		{

			$this->pegawai_model->UpdateJabatanById($id);
			$this->load->view('edit_pegawai_sukses');
		}

	}

	public function delete($id)
	{
		$this->load->model('pegawai_model');
		$data["jabatan"] = $this->pegawai_model->deleteById($id);
		$this->load->view('hapus_pegawai_sukses',$data);	
	}

}

/* End of file Jabatan.php */
/* Location: ./application/controllers/Jabatan.php */

 ?>