<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class master_driver extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model("master_driver_model");
	}
	public function index()
	{
		$this->cekLoginStatus("staff gudang", true);

		$data['title'] = "DATA MASTER DRIVER";
		$data['layout'] = "master_driver/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->master_driver_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("master_driver?");
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

		$data['title'] = "DATA MASTER DRIVER";
		$data['layout'] = "master_driver/manage";



		$data['data'] = new StdClass();
		$data['data']->id = "";
		$data['data']->karyawan_id = "";
		$data['data']->nik = "";
		$data['data']->nama = "";
		$data['data']->alamat = "";
		$data['data']->hp = "";
		$data['data']->spv_id = "";
		$data['data']->username = "";
		$data['data']->password = "";



		if ($id) {
			$dt =  $this->master_driver_model->get_by("pg.id", $id, true);
			if (!empty($dt))
				$data['data'] = $dt;
		}
		$this->load->model("master_spv_model");
		list($data['master_spv'], $total) = $this->master_spv_model->getAll(null, null, null, null, null);

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

			if (!empty($post['spv_id']))
				$data['spv_id'] = $post['spv_id'];
			else
				$error[] = "spv tidak boleh kosong";

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
					$cekmaster_driver = $this->master_driver_model->get_by("pg.id", $post['id']);
					if (!empty($cekmaster_driver))
						$error[] = "id sudah terdaftar";
				}
			}

			if (empty($error)) {
				//var_dump($data);
				//exit();
				$save = $this->master_driver_model->save($id, $data, false);


				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("master_driver/manage/" . $id);
				else
					redirect("master_driver");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("master_driver/manage/" . $id);
			}
		} else
			redirect("master_driver");
	}

	public function delete($id = "")
	{
		$this->cekLoginStatus("staff gudang", true);

		if (!empty($id)) {
			$cek = $this->master_driver_model->get_by("pg.id", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("master_driver");
			} else {
				$this->master_driver_model->remove($id);
				$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
				redirect("master_driver");
			}
		} else
			redirect("master_driver");
	}
}
