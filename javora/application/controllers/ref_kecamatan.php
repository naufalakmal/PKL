<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class ref_kecamatan extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model("ref_kecamatan_model");

	}
	public function index()
	{
		$this->cekLoginStatus("staff gudang", true);

		$data['title'] = "DATA REFERENSI KECAMATAN";
		$data['layout'] = "ref_kecamatan/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->ref_kecamatan_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("ref_kecamatan?");
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
		$this->cekLoginStatus("staff gudang", true);

		$data['title'] = "DATA REFERENSI KECAMATAN";
		$data['layout'] = "ref_kecamatan/manage";



		$data['data'] = new StdClass();
		$data['data']->id_kota = "";
		$data['data']->id_provinsi = "";
		$data['data']->nama_kota = "";
		$data['data']->nama_provinsi = "";



		if ($id) {
			$dt =  $this->ref_kecamatan_model->get_by("pg.id_kota", $id, true);
			if (!empty($dt))
				$data['data'] = $dt;
		}

		$this->load->model("ref_provinsi_model");
		list($data['ref_provinsi'], $total) = $this->ref_provinsi_model->getAll(null, null, null, null, null);

		$this->load->view('template', $data);
	}

	public function ajaxGetPrice()
	{
		$data['data'] = $this->m_tarif->getFilter();
		$this->load->view('components/ajax/show_price', $data);
	}

	public function save()
	{
		$this->cekLoginStatus("staff gudang", true);

		$data = array();
		$post = $this->input->post();

		if ($post) {
			$error = array();


			if (!empty($post['provinsi_id']))
				$data['provinsi_id'] = $post['provinsi_id'];
			else
				$error[] = "Provinsi tidak boleh kosong";

			if (!empty($post['nama_kota']))
					$data['nama_kota'] = $post['nama_kota'];
			else
					$error[] = "kota / kab tidak boleh kosong";

			if (empty($error)) {
				if (empty($id)) {
					$cekref_kecamatan = $this->ref_kecamatan_model->get_by("pg.id_kota", $post['id']);
					if (!empty($cekref_kecamatan))
						$error[] = "id sudah terdaftar";
				}
			}

			if (empty($error)) {
				//var_dump($data);
				//exit();
				$save = $this->ref_kecamatan_model->save($id, $data, false);


				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("ref_kecamatan/manage/" . $id);
				else
					redirect("ref_kecamatan");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("ref_kecamatan/manage/" . $id);
			}
		} else
			redirect("ref_kecamatan");
	}

	public function delete($id = "")
	{
		$this->cekLoginStatus("staff gudang", true);

		if (!empty($id)) {
			$cek = $this->ref_kecamatan_model->get_by("pg.id_kota", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("ref_kecamatan");
			} else {
				$this->ref_kecamatan_model->remove($id);
				$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
				redirect("ref_kecamatan");
			}
		} else
			redirect("ref_kecamatan");
	}




}
