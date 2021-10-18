<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class master_tujuan extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("master_tujuan_model");
		$this->load->model('Location_model');
		$this->cekLoginStatus("admin", true);
	}

	public function index()
	{
		$data['title'] = "DATA MASTER TUJUAN";
		$data['layout'] = "master_tujuan/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->master_tujuan_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("master_tujuan?");
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
		$data['title'] = "FORM MASTER TUJUAN";
		$data['layout'] = "master_tujuan/manage";


		$data['data'] = new StdClass();
		$data['data']->id_tujuan = "";
		$data['data']->nama_tujuan = "";
		$data['data']->telepon_tujuan = "";
		$data['data']->jenis_tujuan = "";
		$data['provinsi'] = $this->master_tujuan_model->provinsi();
		$data['data']->id_provinsi = "";
		$data['data']->id_kota = "";
		$data['data']->tarif = "";
		$data['data']->id_kecamatan = "";
		$data['data']->alamat_tujuan = "";
		$data['data']->hargakg = "";
		$data['data']->autocode = $this->generate_code();

		if ($id) {
			$dt =  $this->master_tujuan_model->get_by("id_tujuan", $id, true);
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

			if (!empty($post['id_tujuan']))
				$data['id_tujuan'] = $post['id_tujuan'];
			else
				$error[] = "id tidak boleh kosong";

			if (!empty($post['nama_tujuan']))
				$data['nama_tujuan'] = $post['nama_tujuan'];
			else
				$error[] = "nama tujuan tidak boleh kosong";

			if (!empty($post['jenis_tujuan']))
				$data['jenis_tujuan'] = $post['jenis_tujuan'];
			else
				$error[] = "jenis_tujuan tidak boleh kosong";

			if (is_numeric($post['telepon_tujuan']))
				$data['telepon_tujuan'] = $post['telepon_tujuan'];
			else
				$error[] = "telepon hanya boleh angka";

			if (!empty($post['telepon_tujuan']))
				$data['telepon_tujuan'] = $post['telepon_tujuan'];
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



			if (!empty($post['alamat_tujuan']))
				$data['alamat_tujuan'] = $post['alamat_tujuan'];
			else
				$error[] = "alamat tidak boleh kosong";
			if (!empty($post['tarif']))
				$data['tarif'] = $post['tarif'];
			else
				$error[] = "tarif tidak boleh kosong";
			if (is_numeric($post['tarif']))
				$data['tarif'] = $post['tarif'];
			else
				$error[] = "tarif hanya boleh angka";



			if (empty($error)) {
				if (empty($id)) {
					$cekmaster_tujuan = $this->master_tujuan_model->get_by("id_tujuan", $post['id_tujuan']);
					if (!empty($cekmaster_tujuan))
						$error[] = "id sudah terdaftar";

					$cek = $this->master_tujuan_model->get_by("nama_tujuan", $post['nama_tujuan']);
					if (!empty($cek))
						$error[] = "nama sudah terdaftar";
				} else {
					$cek = $this->master_tujuan_model->cekName($id, $post['nama_tujuan']);
					if (!empty($cek))
						$error[] = "nama sudah terdaftar";
				}
			}

			if (empty($error)) {
				$save = $this->master_tujuan_model->save($id, $data, false);
				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("master_tujuan/manage/" . $id);
				else
					redirect("master_tujuan");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("master_tujuan/manage/" . $id);
			}
		} else
			redirect("master_tujuan");
	}

	public function delete($id = "")
	{
		if (!empty($id)) {
			$cek = $this->master_tujuan_model->get_by("id_tujuan", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("master_tujuan");
			} else {
				$cek = $this->master_tujuan_model->cekAvalaible($id);
				if (!empty($cek)) {
					$this->session->set_flashdata('admin_save_error', "data sedang digunakan");
					redirect("master_tujuan");
				} else {
					$this->master_tujuan_model->remove($id);

					$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
					redirect("master_tujuan");
				}
			}
		} else
			redirect("master_tujuan");
	}

	public function generate_code()
	{
		$prefix = "TJAN";
		$code = "0001";

		$last = $this->master_tujuan_model->get_last();
		if (!empty($last)) {
			$number = substr($last->id_tujuan, 4, 5) + 1;
			$code = str_pad($number, 4, "0", STR_PAD_LEFT);
		}
		return $prefix . $code;
	}

	function ambil_data()
	{

		$modul = $this->input->post('modul');
		$id = $this->input->post('id');

		if ($modul == "kabupaten") {
			echo $this->master_tujuan_model->kabupaten($id);
		} else if ($modul == "kecamatan") {
			echo $this->master_tujuan_model->kecamatan($id);
		} else if ($modul == "kelurahan") {
			echo $this->master_tujuan_model->kelurahan($id);
		}
	}
}
