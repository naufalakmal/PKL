<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class master_pool extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("master_pool_model");
		$this->load->model('Location_model');
		$this->cekLoginStatus("admin", true);
	}

	public function index()
	{
		$data['title'] = "DATA master_pool";
		$data['layout'] = "master_pool/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->master_pool_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("master_pool?");
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
		$data['title'] = "FORM master_pool";
		$data['layout'] = "master_pool/manage";


		$data['data'] = new StdClass();
		$data['data']->id_pool = "";
		$data['data']->nama_pool = "";
		$data['data']->telepon_pool = "";
		$data['data']->jenis_tujuan = "";
		$data['provinsi'] = $this->master_pool_model->provinsi();
		$data['data']->id_provinsi = "";
		$data['data']->id_kota = "";
		$data['data']->id_kecamatan = "";
		$data['data']->alamat_pool = "";
		$data['data']->hargakg = "";
		$data['data']->autocode = $this->generate_code();

		if ($id) {
			$dt =  $this->master_pool_model->get_by("id_pool", $id, true);
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

			if (!empty($post['id_pool']))
				$data['id_pool'] = $post['id_pool'];
			else
				$error[] = "id tidak boleh kosong";

			if (!empty($post['nama_pool']))
				$data['nama_pool'] = $post['nama_pool'];
			else
				$error[] = "nama tidak boleh kosong";

			if (is_numeric($post['telepon_pool']))
				$data['telepon_pool'] = $post['telepon_pool'];
			else
				$error[] = "telepon hanya boleh angka";

			if (!empty($post['telepon_pool']))
				$data['telepon_pool'] = $post['telepon_pool'];
			else
				$error[] = "telepon tidak boleh kosong";

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



			if (!empty($post['alamat_pool']))
				$data['alamat_pool'] = $post['alamat_pool'];
			else
				$error[] = "alamat tidak boleh kosong";

			if (is_numeric($post['hargakg']))
				$data['hargakg'] = $post['hargakg'];
			else
				$error[] = "harga per kg hanya boleh angka";

			if (!empty($post['hargakg']))
				$data['hargakg'] = $post['hargakg'];
			else
				$error[] = "harga per kg tidak boleh kosong";

			if (empty($error)) {
				if (empty($id)) {
					$cekmaster_pool = $this->master_pool_model->get_by("id_pool", $post['id_pool']);
					if (!empty($cekmaster_pool))
						$error[] = "id sudah terdaftar";

					$cek = $this->master_pool_model->get_by("nama_pool", $post['nama_pool']);
					if (!empty($cek))
						$error[] = "nama sudah terdaftar";
				} else {
					$cek = $this->master_pool_model->cekName($id, $post['nama_pool']);
					if (!empty($cek))
						$error[] = "nama sudah terdaftar";
				}
			}

			if (empty($error)) {
				$save = $this->master_pool_model->save($id, $data, false);
				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("master_pool/manage/" . $id);
				else
					redirect("master_pool");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("master_pool/manage/" . $id);
			}
		} else
			redirect("master_pool");
	}

	public function delete($id = "")
	{
		if (!empty($id)) {
			$cek = $this->master_pool_model->get_by("id_pool", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("master_pool");
			} else {
				$cek = $this->master_pool_model->cekAvalaible($id);
				if (!empty($cek)) {
					$this->session->set_flashdata('admin_save_error', "data sedang digunakan");
					redirect("master_pool");
				} else {
					$this->master_pool_model->remove($id);

					$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
					redirect("master_pool");
				}
			}
		} else
			redirect("master_pool");
	}

	public function generate_code()
	{
		$prefix = "POOL";
		$code = "0001";

		$last = $this->master_pool_model->get_last();
		if (!empty($last)) {
			$number = substr($last->id_pool, 4, 5) + 1;
			$code = str_pad($number, 4, "0", STR_PAD_LEFT);
		}
		return $prefix . $code;
	}

	function ambil_data()
	{

		$modul = $this->input->post('modul');
		$id = $this->input->post('id');

		if ($modul == "kabupaten") {
			echo $this->master_pool_model->kabupaten($id);
		} else if ($modul == "kecamatan") {
			echo $this->master_pool_model->kecamatan($id);
		} else if ($modul == "kelurahan") {
			echo $this->master_pool_model->kelurahan($id);
		}
	}
}
