<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class master_tarif extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("master_tarif_model");
		$this->load->model('Location_model');
		$this->load->helper('form');
		$this->cekLoginStatus("admin", true);
	}

	public function index()
	{
		$data['title'] = "DATA master_tarif";
		$data['layout'] = "master_tarif/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->master_tarif_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("master_tarif?");
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
		$data['title'] = "FORM master_tarif";
		$data['layout'] = "master_tarif/manage";


		$data['data'] = new StdClass();
		$data['data']->id_tarif = "";
		$data['data']->id_jenis_layanan = "";

		$data['data']->jenis_paket = "";
		$data['data']->berat_tarif = "";
		$data['data']->harga_tarif = "";
		$data['data']->durasi_master_tarif = "";
		$data['provinsi'] = $this->master_tarif_model->provinsi();
		$data['data']->id_provinsi = "";
		$data['data']->id_kota = "";
		$data['data']->id_kecamatan = "";
		$data['data']->id_provinsi_asal = "";
		$data['data']->id_kota_asal = "";
		$data['data']->id_kecamatan_asal = "";
		$data['data']->id_provinsi_tujuan = "";
		$data['data']->id_kota_tujuan = "";
		$data['data']->id_kecamatan_tujuan = "";
		$data['data']->autocode = $this->generate_code();

		if ($id) {
			$dt =  $this->master_tarif_model->get_by("id_tarif", $id, true);
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

			if (!empty($post['id_tarif']))
				$data['id_tarif'] = $post['id_tarif'];
			else
				$error[] = "id tidak boleh kosong";

			if (!empty($post['id_jenis_layanan']))
				$data['id_jenis_layanan'] = $post['id_jenis_layanan'];
			else
				$error[] = "jenis master_tarif tidak boleh kosong";



			if (empty($post['id_provinsi_asal']))
				$error[] = "provinsi asal tidak boleh kosong";

			if (empty($post['id_kota_asal']))
				$error[] = "kabupaten asal tidak boleh kosong";

			if (!empty($post['id_kecamatan_asal']))
					$data['id_kecamatan_asal'] = $post['id_kecamatan_asal'];
			else
					$error[] = "asal tidak boleh kosong";





			if (empty($post['id_provinsi_tujuan']))
				$error[] = "provinsi tujuan tidak boleh kosong";

			if (empty($post['id_kota_tujuan']))
				$error[] = "kabupaten tujuan tidak boleh kosong";

			if (!empty($post['id_kecamatan_tujuan']))
						$data['id_kecamatan_tujuan'] = $post['id_kecamatan_tujuan'];
			else
						$error[] = "tujuan tidak boleh kosong";



			if (!empty($post['berat_tarif']))
				$data['berat_tarif'] = $post['berat_tarif'];
			else
				$error[] = "jenis paket tidak boleh kosong";

			if (!empty($post['harga_tarif']))
				$data['harga_tarif'] = $post['harga_tarif'];
			else
				$error[] = "harga tidak boleh kosong";

			if (empty($error)) {
				if (empty($id)) {
					$cekmaster_tarif = $this->master_tarif_model->get_by("id_tarif", $post['id_tarif']);
					if (!empty($cekmaster_tarif))
						$error[] = "id sudah terdaftar";
				}
			}

			if (empty($error)) {
				//var_dump($data);
				//exit();
				$save = $this->master_tarif_model->save($id, $data, false);
				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("master_tarif/manage/" . $id);
				else
					redirect("master_tarif");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("master_tarif/manage/" . $id);
			}
		} else
			redirect("master_tarif");
	}

	public function delete($id = "")
	{
		if (!empty($id)) {
			$cek = $this->master_tarif_model->get_by("id_tarif", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("master_tarif");
			} else {

					$this->master_tarif_model->remove($id);

					$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
					redirect("master_tarif");

			}
		} else
			redirect("master_tarif");
	}

	public function generate_code()
	{
		$prefix = "TRF";
		$code = "0001";

		$last = $this->master_tarif_model->get_last();
		if (!empty($last)) {
			$number = substr($last->id_tarif, 3, 4) + 1;
			$code = str_pad($number, 4, "0", STR_PAD_LEFT);
		}
		return $prefix . $code;
	}

	function ambil_data()
	{

		$modul = $this->input->post('modul');
		$id = $this->input->post('id');

		if ($modul == "kabupaten_asal") {
			echo $this->master_tarif_model->kabupaten($id);
		} else if ($modul == "kecamatan_asal") {
			echo $this->master_tarif_model->kecamatan($id);
		} else if ($modul == "kelurahan_asal") {
			echo $this->master_tarif_model->kelurahan($id);
		} else if ($modul == "kabupaten_tujuan") {
			echo $this->master_tarif_model->kabupaten($id);
		} else if ($modul == "kecamatan_tujuan") {
			echo $this->master_tarif_model->kecamatan($id);
		} else if ($modul == "kelurahan_tujuan") {
			echo $this->master_tarif_model->kelurahan($id);
		}
	}
}
