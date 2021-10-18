<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class master_spv extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model("master_spv_model");
	}
	public function index()
	{
		$this->cekLoginStatus("staff gudang", true);

		$data['title'] = "DATA MASTER SPV";
		$data['layout'] = "master_spv/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->master_spv_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("master_spv?");
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

		$data['title'] = "DATA MASTER SPV";
		$data['layout'] = "master_spv/manage";



		$data['data'] = new StdClass();
		$data['data']->id = "";
		$data['data']->karyawan_id = "";
		$data['data']->nik = "";
		$data['data']->nama = "";
		$data['data']->alamat = "";
		$data['data']->hp = "";
		$data['data']->username = "";
		$data['data']->password = "";



		if ($id) {
			$dt =  $this->master_spv_model->get_by("pg.id", $id, true);
			if (!empty($dt))
				$data['data'] = $dt;
		}

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


			if (!empty($post['karyawan_id']))
				$data['karyawan_id'] = $post['karyawan_id'];
			else
				$error[] = "Karyawan tidak boleh kosong";

			if (!empty($post['username']))
				$data['username'] = $post['username'];
			else
				$error[] = "username harus diisi";

			if (!empty($post['password'])) 
				$data['password'] = password_hash($post['username'], PASSWORD_BCRYPT);
			else
				$error[] = "Password harus diisi";

			if (empty($error)) {
				if (empty($id)) {
					$cekmaster_spv = $this->master_spv_model->get_by("pg.id", $post['id']);
					if (!empty($cekmaster_spv))
						$error[] = "id sudah terdaftar";
				}
			}

			if (empty($error)) {
				//var_dump($data);
				//exit();
				$save = $this->master_spv_model->save($id, $data, false);

				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("master_spv/manage/" . $id);
				else
					redirect("master_spv");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("master_spv/manage/" . $id);
			}
		} else
			redirect("master_spv");
	}

	public function delete($id = "")
	{
		$this->cekLoginStatus("staff gudang", true);

		if (!empty($id)) {
			$cek = $this->master_spv_model->get_by("pg.id", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("master_spv");
			} else {
				$this->master_spv_model->remove($id);
				$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
				redirect("master_spv");
			}
		} else
			redirect("master_spv");
	}
}
