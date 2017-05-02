<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
		}else{
			redirect('login','refresh');
		}	
	}
	
	public function index()
	{
		$this->load->model('pegawai_model');
		$data["pegawai_list"] = $this->pegawai_model->getDataPegawai();
		$this->load->view('pegawai',$data);	
	}

	public function datatable()
	{
		$this->load->model('pegawai_model');
		$data["pegawai_list"] = $this->pegawai_model->getDataPegawai();
		$this->load->view('pegawai_datatable',$data);	
	}


	public function create()
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama'/*mengambil value input text*/, 'Nama'/*Nama di tampilan*/, 'trim|required');
		$this->form_validation->set_rules('nip'/*mengambil value input text*/, 'NIP'/*Nama di tampilan*/, 'trim|required');
		$this->form_validation->set_rules('tgllahir'/*mengambil value input text*/, 'Tanggal Lahir'/*Nama di tampilan*/, 'trim|required');
		$this->form_validation->set_rules('alamat'/*mengambil value input text*/, 'Alamat'/*Nama di tampilan*/, 'trim|required');
		$this->load->model('pegawai_model');	
		if($this->form_validation->run()==FALSE){

			$this->load->view('tambah_pegawai_view');

		}else{
				$config['upload_path']          = './assets/uploads/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 1000000000;
                $config['max_width']            = 10240;
                $config['max_height']           = 7680;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());
						$this->load->view('tambah_pegawai_view',$error);
                }
                else
                {
						$this->pegawai_model->insertPegawai();
						$this->load->view('tambah_pegawai_sukses');
                }
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
		$data['pegawai']=$this->pegawai_model->getPegawai($id);
		$data2=$this->pegawai_model->getPegawai($id);
		$nama=$data2[0]->foto;
		if($this->form_validation->run()==FALSE)
		{
			$this->load->view('edit_pegawai_view',$data);
		}
		else
		{
			$config['upload_path'] = './assets/uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '1000';
			$config['max_width']  = '10240';
			$config['max_height']  = '7680';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload()){
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('tambah_pegawai_view',$error);
			}
		

			else
		{
			$image_data = $this->upload->data();
			unlink('assets/uploads/'.$nama);
			$this->pegawai_model->UpdateById($id);
			$this->load->view('edit_pegawai_sukses');
		}

	}
}

	//method update butuh parameter id berapa yang akan di update
	/*public function update($id)
	{
		//load library
		$this->load->helper('url','form');	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		//sebelum update data harus ambil data lama yang akan di update
		$this->load->model('pegawai_model');
		$data['pegawai']=$this->pegawai_model->getPegawai($id);
		//skeleton code
		if($this->form_validation->run()==FALSE){

		//setelah load data dikirim ke view
			$this->load->view('edit_pegawai_view',$data);

		}else{
				$config['upload_path']          = './assets/uploads/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 1000000000;
                $config['max_width']            = 10240;
                $config['max_height']           = 7680;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload() )
                {
                        $error = array('error' => $this->upload->display_errors());
						$this->load->view('tambah_pegawai_view',$error);
                }
                else
                {
                		$image_data = $this->upload->data();

						$configer = array (
							'image_library' => 'gd2',
							'source_image' => $image_data['full_path'],
							'maintain_ratio' => TRUE,
							'width' => 250,
							'height' => 250,
							);
						$this->load->library('image_lib', $config);

						$this->image_lib->clear();
						$this->image_lib->initialize($configer);
						$this->image_lib->resize();

						$this->pegawai_model->updateById($id);
						$this->load->view('edit_pegawai_sukses');
                }
		}
	}
*/
	public function delete($id)
	{
		$this->load->model('pegawai_model');
		$data["pegawai_list"] = $this->pegawai_model->deleteById($id);
		$data2 = $this->pegawai_model->deleteById($id);
		$nama=$data2[0]->foto;
		//@unlink('assets/uploads/'.$nama);
		//$this->load->helper("url");
		//delete(base_url("assets/uploads/".$nama));

		$this->load->view('hapus_pegawai_sukses',$data);	
	}
}

/* End of file Pegawai.php */
/* Location: ./application/controllers/Pegawai.php */

 ?>