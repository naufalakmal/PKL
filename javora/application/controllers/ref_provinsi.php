<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class ref_provinsi extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("ref_provinsi_model");
		$this->cekLoginStatus("admin", true);
	}
	public function index()
	{
		$data['title'] = "DATA REFERENSI PROVINSI";
		$data['layout'] = "ref_provinsi/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->ref_provinsi_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("ref_provinsi?");
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
		$data['title'] = "FORM REFERENSI PROVINSI";
		$data['layout'] = "ref_provinsi/manage";

		$data['data'] = new StdClass();
		$data['data']->id_provinsi = "";
		$data['data']->nama_provinsi = "";



		if ($id) {
			$dt =  $this->ref_provinsi_model->get_by("id_provinsi", $id, true);
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




			if (!empty($post['nama_provinsi']))
				$data['nama_provinsi'] = $post['nama_provinsi'];
			else
				$error[] = "nama provinsi tidak boleh kosong";



			if (empty($error)) {
				if (empty($id)) {
					$cekref_provinsi = $this->ref_provinsi_model->get_by("id_provinsi", $post['id']);
					if (!empty($cekref_provinsi))
						$error[] = "id sudah terdaftar";


				} else {
						$cek = $this->ref_provinsi_model->cekName($id, $post['nama_provinsi']);
					//var_dump($cek);
					//exit();
					if (!empty($cek))
						$error[] = "nama sudah terdaftar";
				}
			}

			if (empty($error)) {
				$save = $this->ref_provinsi_model->save($id, $data, false);
				//var_dump($data);
				//exit();
				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("ref_provinsi/manage/" . $id);
				else
					redirect("ref_provinsi");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("ref_provinsi/manage/" . $id);
			}
		} else
			redirect("ref_provinsi");
	}

	public function delete($id = "")
	{
		if (!empty($id)) {
			$cek = $this->ref_provinsi_model->get_by("id_provinsi", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("ref_provinsi");
			} else {
				$cek = $this->ref_provinsi_model->cekAvalaible($id);
				if (!empty($cek)) {
					$this->session->set_flashdata('admin_save_error', "data sedang digunakan");
					redirect("ref_provinsi");
				} else {
					$this->ref_provinsi_model->remove($id);

					$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
					redirect("ref_provinsi");
				}
			}
		} else
			redirect("ref_provinsi");
	}


}
