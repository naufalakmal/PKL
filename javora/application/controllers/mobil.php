<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mobil extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("mobil_model");
		$this->cekLoginStatus("admin", true);
	}
	public function index()
	{
		$data['title'] = "DATA MOBIL";
		$data['layout'] = "mobil/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->mobil_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("mobil?");
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
		$data['title'] = "FORM MOBIL";
		$data['layout'] = "mobil/manage";

		$data['data'] = new StdClass();
		$data['data']->id_mobil = "";
		$data['data']->nama = "";
		$data['data']->id_merk = "";
		$data['data']->warna = "";
		$data['data']->no_polisi = "";
		$data['data']->autocode = $this->generate_code();

		if ($id) {
			$dt =  $this->mobil_model->get_by("id_mobil", $id, true);
			if (!empty($dt))
				$data['data'] = $dt;
		}
		$this->load->model("merk_model");
		list($data['merk'], $total) = $this->merk_model->getAll(null, null, null, null, null);

		$this->load->view('template', $data);
	}

	public function save()
	{
		$data = array();
		$post = $this->input->post();

		if ($post) {
			$error = array();
			$id = $post['id'];

			if (!empty($post['id_mobil']))
				$data['id_mobil'] = $post['id_mobil'];
			else
				$error[] = "id tidak boleh kosong";

			if (!empty($post['nama']))
				$data['nama'] = $post['nama'];
			else
				$error[] = "nama tidak boleh kosong";

			if (!empty($post['id_merk']))
				$data['id_merk'] = $post['id_merk'];
			else
				$error[] = "merk tidak boleh kosong";

			if (!empty($post['warna']))
				$data['warna'] = $post['warna'];
			else
				$error[] = "warna tidak boleh kosong";

			if (!empty($post['no_polisi']))
				$data['no_polisi'] = $post['no_polisi'];
			else
				$error[] = "no polisi tidak boleh kosong";

			if (empty($error)) {
				if (empty($id)) {
					$cekmobil = $this->mobil_model->get_by("id_mobil", $post['id_mobil']);
					if (!empty($cekmobil))
						$error[] = "id sudah terdaftar";
				}
			}

			if (empty($error)) {
				$save = $this->mobil_model->save($id, $data, false);
				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("mobil/manage/" . $id);
				else
					redirect("mobil");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("mobil/manage/" . $id);
			}
		} else
			redirect("mobil");
	}

	public function delete($id = "")
	{
		if (!empty($id)) {
			$cek = $this->mobil_model->get_by("id_mobil", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("mobil");
			} else {
				$cek = $this->mobil_model->cekAvalaible($id);
				if (!empty($cek)) {
					$this->session->set_flashdata('admin_save_error', "data sedang digunakan");
					redirect("mobil");
				} else {
					$this->mobil_model->remove($id);

					$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
					redirect("mobil");
				}
			}
		} else
			redirect("mobil");
	}

	public function generate_code()
	{
		$prefix = "MBL";
		$code = "0001";

		$last = $this->mobil_model->get_last();
		if (!empty($last)) {
			$number = substr($last->id_mobil, 3, 4) + 1;
			$code = str_pad($number, 4, "0", STR_PAD_LEFT);
		}
		return $prefix . $code;
	}
}
