<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class master_kendaraan extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("master_kendaraan_model");
		$this->cekLoginStatus("admin", true);
	}
	public function index()
	{
		$data['title'] = "DATA MASTER KENDARAAN";
		$data['layout'] = "master_kendaraan/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->master_kendaraan_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("master_kendaraan?");
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
		$data['title'] = "FORM MASTER KENDARAAN";
		$data['layout'] = "master_kendaraan/manage";

		$data['data'] = new StdClass();
		$data['data']->id = "";
		$data['data']->nopol = "";
		$data['data']->nomesin = "";
		$data['data']->merk = "";
		$data['data']->cc = "";
		$data['data']->tahun_kendaraan = "";



		if ($id) {
			$dt =  $this->master_kendaraan_model->get_by("id", $id, true);
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



			if (!empty($post['nopol']))
				$data['nopol'] = $post['nopol'];
			else
				$error[] = "nopol tidak boleh kosong";

			if (!empty($post['nomesin']))
				$data['nomesin'] = $post['nomesin'];
			else
				$error[] = "nomor mesin tidak boleh kosong";

			if (!empty($post['merk']))
				$data['merk'] = $post['merk'];
			else
				$error[] = "merk tidak boleh kosong";

			if (!empty($post['cc']))
				$data['cc'] = $post['cc'];
			else
				$error[] = "cc tidak boleh kosong";

			if (!empty($post['tahun_kendaraan']))
				$data['tahun_kendaraan'] = $post['tahun_kendaraan'];
			else
				$error[] = "tahun kendaraan tidak boleh kosong";



			if (empty($error)) {
				if (empty($id)) {
					$cekmaster_kendaraan = $this->master_kendaraan_model->get_by("id", $post['id']);
					if (!empty($cekmaster_kendaraan))
						$error[] = "id sudah terdaftar";


				} else {
					$cek = $this->master_kendaraan_model->cekName($id);
					if (!empty($cek))
						$error[] = "nomor polisi sudah terdaftar";
				}
			}

			if (empty($error)) {
				$save = $this->master_kendaraan_model->save($id, $data, false);
				//var_dump($data);
				//exit();
				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("master_kendaraan/manage/" . $id);
				else
					redirect("master_kendaraan");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("master_kendaraan/manage/" . $id);
			}
		} else
			redirect("master_kendaraan");
	}

	public function delete($id = "")
	{
		if (!empty($id)) {
			$cek = $this->master_kendaraan_model->get_by("id", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("master_kendaraan");
			} else {
				$cek = $this->master_kendaraan_model->cekAvalaible($id);
				if (!empty($cek)) {
					$this->session->set_flashdata('admin_save_error', "data sedang digunakan");
					redirect("master_kendaraan");
				} else {
					$this->master_kendaraan_model->remove($id);

					$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
					redirect("master_kendaraan");
				}
			}
		} else
			redirect("master_kendaraan");
	}


}
