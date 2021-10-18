<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class master_pelanggan extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("master_pelanggan_model");
		$this->load->model('Location_model');
		$this->load->helper('form');
		$this->cekLoginStatus("admin", true);
	}

	public function index()
	{
		$data['title'] = "DATA master_pelanggan";
		$data['layout'] = "master_pelanggan/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->master_pelanggan_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("master_pelanggan?");
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
		$data['title'] = "FORM master_pelanggan";
		$data['layout'] = "master_pelanggan/manage";


		$data['data'] = new StdClass();
		$data['data']->id_pelanggan = "";

		$data['data']->nama = "";
		$data['data']->telepon = "";
		$data['data']->alamat = "";
		$data['ref_provinsi'] = $this->master_pelanggan_model->ref_provinsi();
		$data['data']->id_provinsi = "";
		$data['data']->id_kota = "";
		$data['data']->id_kecamatan = "";
		$data['data']->hutang = "";

		$data['data']->autocode = $this->generate_code();

		if ($id) {
			$dt =  $this->master_pelanggan_model->get_by("id_pelanggan", $id, true);
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
			$id = $post['id'];

			if (!empty($post['id_pelanggan']))
				$data['id_pelanggan'] = $post['id_pelanggan'];
			else
				$error[] = "id tidak boleh kosong";

			if (!empty($post['nama']))
				$data['nama'] = $post['nama'];
			else
				$error[] = "nama tidak boleh kosong";

			if (is_numeric($post['telepon']))
				$data['telepon'] = $post['telepon'];
			else
				$error[] = "telepon hanya boleh angka";

			if (!empty($post['telepon']))
				$data['telepon'] = $post['telepon'];
			else
				$error[] = "telepon tidak boleh kosong";

			if (!empty($post['alamat']))
				$data['alamat'] = $post['alamat'];
			else
				$error[] = "alamat tidak boleh kosong";

			if (!empty($post['id_provinsi']))
				$data['id_provinsi'] = $post['id_provinsi'];
			else
				$error[] = "provinsi tidak boleh kosong";

			if (!empty($post['id_kota']))
				$data['id_kota'] = $post['id_kota'];
			else
				$error[] = "kabupaten tidak boleh kosong";

			if (!empty($post['id_kecamatan']))
				$data['id_kecamatan'] = $post['id_kecamatan'];
			else
				$error[] = "kecamatan tidak boleh kosong";
			if (!empty($post['id_kecamatan']))
				$data['hutang'] = $post['hutang'];
			else
				$error[] = "hutang tidak boleh kosong";



			if (empty($error)) {
				if (empty($id)) {
					$cekmaster_pelanggan = $this->master_pelanggan_model->get_by("id_pelanggan", $post['id_pelanggan']);
					if (!empty($cekmaster_pelanggan))
						$error[] = "id sudah terdaftar";

					$cek = $this->master_pelanggan_model->get_by("nama", $post['nama']);
					if (!empty($cek))
						$error[] = "nama sudah terdaftar";
				} else {
					$cek = $this->master_pelanggan_model->cekName($id, $post['nama']);
					if (!empty($cek))
						$error[] = "nama sudah terdaftar";
				}
			}

			if (empty($error)) {
				$save = $this->master_pelanggan_model->save($id, $data, false);
				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("master_pelanggan/manage/" . $id);
				else
					redirect("master_pelanggan");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("master_pelanggan/manage/" . $id);
			}
		} else
			redirect("master_pelanggan");
	}

	public function delete($id = "")
	{
		if (!empty($id)) {
			$cek = $this->master_pelanggan_model->get_by("id_pelanggan", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("master_pelanggan");
			} else {
				$cek = $this->master_pelanggan_model->cekAvalaible($id);
				if (!empty($cek)) {
					$this->session->set_flashdata('admin_save_error', "data sedang digunakan");
					redirect("master_pelanggan");
				} else {
					$this->master_pelanggan_model->remove($id);

					$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
					redirect("master_pelanggan");
				}
			}
		} else
			redirect("master_pelanggan");
	}

	public function generate_code()
	{
		$prefix = "CST";
		$code = "0001";

		$last = $this->master_pelanggan_model->get_last();
		if (!empty($last)) {
			$number = substr($last->id_pelanggan, 3, 4) + 1;
			$code = str_pad($number, 4, "0", STR_PAD_LEFT);
		}
		return $prefix . $code;
	}

	function ambil_data()
	{

		$modul = $this->input->post('modul');
		$id = $this->input->post('id');

		if ($modul == "kabupaten") {
			echo $this->master_pelanggan_model->kabupaten($id);
		} else if ($modul == "kecamatan") {
			echo $this->master_pelanggan_model->kecamatan($id);
		} else if ($modul == "kelurahan") {
			echo $this->master_pelanggan_model->kelurahan($id);
		}
	}
}
