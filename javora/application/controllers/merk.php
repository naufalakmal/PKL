<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Merk extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Merk_model");
		$this->cekLoginStatus("admin", true);
	}
	public function index()
	{
		$data['title'] = "DATA MERK";
		$data['layout'] = "merk/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->Merk_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("merk?");
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
		$data['title'] = "FORM MERK";
		$data['layout'] = "merk/manage";

		$data['data'] = new StdClass();
		$data['data']->id_merk = "";
		$data['data']->nama_merk = "";
		$data['data']->keterangan = "";
		$data['data']->autocode = $this->generate_code();

		if ($id) {
			$dt =  $this->Merk_model->get_by("id_merk", $id, true);
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

			if (!empty($post['id_merk']))
				$data['id_merk'] = $post['id_merk'];
			else
				$error[] = "id tidak boleh kosong";

			if (!empty($post['nama_merk']))
				$data['nama_merk'] = $post['nama_merk'];
			else
				$error[] = "nama_merk tidak boleh kosong";

			if (!empty($post['keterangan']))
				$data['keterangan'] = $post['keterangan'];
			else
				$error[] = "keterangan tidak boleh kosong";

			if (empty($error)) {
				if (empty($id)) {
					$cekmerk = $this->Merk_model->get_by("id_merk", $post['id_merk']);
					if (!empty($cekmerk))
						$error[] = "id sudah terdaftar";

					$cek = $this->Merk_model->get_by("nama_merk", $post['nama_merk']);
					if (!empty($cek))
						$error[] = "nama_merk sudah terdaftar";
				} else {
					$cek = $this->Merk_model->cekName($id, $post['nama_merk']);
					if (!empty($cek))
						$error[] = "nama_merk sudah terdaftar";
				}
			}

			if (empty($error)) {
				$save = $this->Merk_model->save($id, $data, false);
				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("merk/manage/" . $id);
				else
					redirect("merk");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("merk/manage/" . $id);
			}
		} else
			redirect("merk");
	}

	public function delete($id = "")
	{
		if (!empty($id)) {
			$cek = $this->Merk_model->get_by("id_merk", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("merk");
			} else {
				$cek = $this->Merk_model->cekAvalaible($id);
				if (!empty($cek)) {
					$this->session->set_flashdata('admin_save_error', "data sedang digunakan");
					redirect("merk");
				} else {
					$this->Merk_model->remove($id);

					$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
					redirect("merk");
				}
			}
		} else
			redirect("merk");
	}

	public function generate_code()
	{
		$prefix = "MRK";
		$code = "01";

		$last = $this->Merk_model->get_last();
		if (!empty($last)) {
			$number = substr($last->id_merk, 3, 2) + 1;
			$code = str_pad($number, 2, "0", STR_PAD_LEFT);
		}
		return $prefix . $code;
	}
}
