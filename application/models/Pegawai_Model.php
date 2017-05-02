<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_Model extends CI_Model {

		public function __construct()
		{
			parent::__construct();
			//Do your magic here
		}	

		public function getDataPegawai()
		{
			$this->db->select("id,nama,nip,DATE_FORMAT(tanggalLahir,'%d-%m-%Y') as tanggalLahir, alamat, foto");
			$query = $this->db->get('pegawai');
			return $query->result();
		}

		public function getJabatanByPegawai($idPegawai)
		{
			$this->db->select("pegawai.nama as namaPegawai, jabatan_pegawai.id as pegawaiId, namaJabatan,DATE_FORMAT(tanggalMulai,'%d-%m-%Y') as tanggalMulai,DATE_FORMAT(tanggalSelesai,'%d-%m-%Y') as tanggalSelesai");
			$this->db->where('fk_pegawai', $idPegawai);	
			$this->db->join('pegawai', 'pegawai.id = jabatan_pegawai.fk_pegawai', 'left');	
			$query = $this->db->get('jabatan_pegawai');
			return $query->result();
		}
		public function getAnakByPegawai($idPegawai)
		{
			$this->db->select("pegawai.id as pegawaiId,pegawai.nama as namaPegawai, anak.id as idAnak, anak.nama as namaAnak,DATE_FORMAT(anak.tanggalLahir,'%d-%m-%Y') as tanggalLahir");
			$this->db->where('fk_pegawai', $idPegawai);	
			$this->db->join('pegawai', 'pegawai.id = anak.fk_pegawai', 'left');	
			$query = $this->db->get('anak');
			return $query->result();
		}


		public function insertPegawai()
		{
			$object = array('nama' => $this->input->post('nama'), 'nip' => $this->input->post('nip'),'tanggalLahir' => $this->input->post('tgllahir'),'alamat' => $this->input->post('alamat'),'foto' => $this->upload->data('file_name')
				);
			$this->db->insert('pegawai', $object);
		}

		public function getPegawai($id)
		{
			$this->db->where('id',$id);
			$query = $this->db->get('pegawai');
			return $query->result();
		}

		public function getAnak($id)
		{
			$this->db->where('id',$id);
			$query = $this->db->get('anak');
			return $query->result();
		}

		public function getJabatan($id)
		{
			$this->db->where('id',$id);
			$query = $this->db->get('jabatan_pegawai');
			return $query->result();
		}

		public function UpdateById($id)
		{
			$data = array
			(
				'nama' =>$this->input->post('nama'),
				'nip' =>$this->input->post('nip'),
				'tanggalLahir' =>$this->input->post('tgllahir'),
				'alamat' =>$this->input->post('alamat'),
				'foto' =>$this->upload->data('file_name')

			);
			$this->db->where('id',$id);
			$this->db->update('pegawai',$data);
		}	

		public function deleteById($id)
		{
       		//$this->db->where('id', $id);
			//$this->db->delete('pegawai');
			$this->db->where('id', $id);
			$this->db->delete('anak');
			$this->db->where('id', $id);
			$this->db->delete('jabatan_pegawai');

			$this->db->where('id',$id);
		    $query = $this->db->get('pegawai');
		    $row = $query->row();

    		unlink("assets/uploads/$row->foto");
			$this->db->delete('pegawai', array('id' => $id));
		}
		public function insertJabatan($idPegawai)
		{
			// idPegawai = 1
			$object = array(
				'namaJabatan' => $this->input->post('jabatan'), 
				'tanggalMulai' => $this->input->post('tanggalMulai'),
				'tanggalSelesai' => $this->input->post('tanggalSelesai'),
				'fk_pegawai'=> $idPegawai
				);
			$this->db->insert('jabatan_pegawai', $object);
		}
		public function insertAnak($idPegawai)
		{
			// idPegawai = 1
			$object = array(
				'nama' => $this->input->post('nama'), 
				'tanggalLahir' => $this->input->post('tanggalLahir'),
				'fk_pegawai'=> $idPegawai
				);
			$this->db->insert('anak', $object);
		}

		public function UpdateAnakById($id)
		{
			$data = array
			(
				'nama' => $this->input->post('nama'), 
				'tanggalLahir' => $this->input->post('tanggalLahir')

			);
			$this->db->where('id',$id);
			$this->db->update('anak',$data);
		}	

		public function UpdateJabatanById($id)
		{
			$data = array
			(
				'namaJabatan' => $this->input->post('jabatan'), 
				'tanggalMulai' => $this->input->post('tanggalMulai'),
				'tanggalSelesai' => $this->input->post('tanggalSelesai')
			);
			$this->db->where('id',$id);
			$this->db->update('jabatan_pegawai',$data);
		}	

}

/* End of file Pegawai_Model.php */
/* Location: ./application/models/Pegawai_Model.php */
 ?>