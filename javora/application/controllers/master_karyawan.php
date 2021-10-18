<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class master_karyawan extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("master_karyawan_model");
		$this->cekLoginStatus("admin", true);
	}
	public function index()
	{
		$data['title'] = "DATA MASTER KARYAWAN";
		$data['layout'] = "master_karyawan/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->master_karyawan_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("master_karyawan?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		$this->load->view('template', $data);
	}

	public function manage($id = "")
	{
		$data['title'] = "FORM master_karyawan";
		$data['layout'] = "master_karyawan/manage";

		$data['data'] = new StdClass();
		$data['data']->id = "";
		$data['data']->nik = "";
		$data['data']->nama = "";
		$data['data']->hp = "";
		$data['data']->alamat = "";
		$data['data']->sim_a = "";
		$data['data']->sim_c = "";
		$data['data']->email = "";
		$data['data']->photo_sim_a = "";
		$data['data']->photo_sim_c = "";
		$data['data']->foto = "";


		if ($id) {
			$dt =  $this->master_karyawan_model->get_by("id", $id, true);
			if (!empty($dt))
				$data['data'] = $dt;
		}

		$this->load->view('template', $data);
	}

	public function save()
	{
		$data = array();
		$post = $this->input->post();

		if ($post) {
			$error = array();
			// $id = $post['nik'];

			if (!empty($post['nik']))
				$data['nik'] = $post['nik'];
			else
				$error[] = "nik tidak boleh kosong";

			if (!empty($post['nama']))
				$data['nama'] = $post['nama'];
			else
				$error[] = "nama tidak boleh kosong";

			if (!empty($post['hp']))
				$data['hp'] = $post['hp'];
			else
				$error[] = "hp tidak boleh kosong";

			if (!empty($post['alamat']))
				$data['alamat'] = $post['alamat'];
			else
				$error[] = "alamat tidak boleh kosong";

			if (!empty($post['sim_a']))
				$data['sim_a'] = $post['sim_a'];
			else
				$error[] = "sim_a tidak boleh kosong";

			if (!empty($post['sim_c']))
				$data['sim_c'] = $post['sim_c'];
			else
				$error[] = "sim_c tidak boleh kosong";

			if (!empty($post['email']))
				$data['email'] = $post['email'];
			else
				$error[] = "email tidak boleh kosong";

			if (!empty($_FILES['foto'])) {
				$foto = (object) @$_FILES['foto'];
				$path = './assets/avatars/';
				if ($foto->type !== 'image/jpeg') {
					$error[] = 'foto harus jpeg!';
				}
				move_uploaded_file(
					$foto->tmp_name,
					"{$path}/{$foto->name}"
				);
				$data['foto'] = $foto->name;
			} else
				$data['foto'] = 'default.jpg';

			if (!empty($_FILES['fotosima'])) {
				$fotosima = (object) @$_FILES['fotosima'];
				$path = './assets/avatars/sima';
				if ($fotosima->type !== 'image/jpeg') {
					$error[] = 'Foto harus jpeg!';
				}
				move_uploaded_file(
					$fotosima->tmp_name,
					"{$path}/{$fotosima->name}"
				);
				$data['fotosima'] = $fotosima->name;
			} else
				$data['fotosima'] = 'default.jpg';

			if (!empty($_FILES['fotosimc'])) {
				$fotosimc = (object) @$_FILES['fotosimc'];
				$path = './assets/avatars/simc';
				if ($fotosimc->type !== 'image/jpeg') {
					$error[] = 'Foto harus jpeg!';
				}
				move_uploaded_file(
					$fotosimc->tmp_name,
					"{$path}/{$fotosimc->name}"
				);
				$data['fotosimc'] = $fotosimc->name;
			} else
				$data['fotosimc'] = 'default.jpg';


			if (empty($error)) {
				$save = $this->master_karyawan_model->save($id, $data, false);
				// var_dump($save);
				// exit();
				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("master_karyawan/manage/" . $id);
				else
					redirect("master_karyawan");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("master_karyawan/manage/" . $id);
			}
		} else
			redirect("master_karyawan");
	}

	public function delete($id = "")
	{
		if (!empty($id)) {
			$cek = $this->master_karyawan_model->get_by("id", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("master_karyawan");
			} else {
				$cek = $this->master_karyawan_model->cekAvalaible($id);
				if (!empty($cek)) {
					$this->session->set_flashdata('admin_save_error', "data sedang digunakan");
					redirect("master_karyawan");
				} else {
					$this->master_karyawan_model->remove($id);

					$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
					redirect("master_karyawan");
				}
			}
		} else
			redirect("master_karyawan");
	}
}
