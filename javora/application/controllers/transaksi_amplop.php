<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class transaksi_amplop extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("master_tarif_model");
		$this->load->model("master_pelanggan_model");
		$this->load->model("transaksi_amplop_model");
		$this->load->model("m_tarif");
	}
	public function index()
	{
		$this->cekLoginStatus("staff gudang", true);

		$data['title'] = "DATA TTB";
		$data['layout'] = "transaksi_amplop/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->transaksi_amplop_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("transaksi_amplop?");
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

		$data['title'] = "FORM TTB";
		$data['layout'] = "transaksi_amplop/manage";



		$data['data'] = new StdClass();
		$data['data']->id_provinsi = "";
		$data['provinsi'] = $this->master_tarif_model->provinsi();
		$data['data']->id_amplop = "";
		$data['data']->tanggal = "";
		$data['data']->id_kategori = "";
		$data['data']->kategori = "";
		$data['data']->barang = "";
		$data['data']->id_pelanggan = "";
		$data['data']->pelanggan = "";
		$data['data']->alamat = "";
		$data['data']->nama_pengirim = "";
		$data['data']->alamat_pengirim = "";
		$data['data']->id_tujuan = "";
		$data['data']->nama_tujuan = "";
		$data['data']->alamat_tujuan = "";
		$data['data']->hp_pengirim = "";
		$data['data']->kecamatan = "";
		$data['data']->tarif = "";
		$data['data']->kota = "";
		$data['data']->provinsi = "";
		$data['data']->hargakg = "";
		$data['data']->berat_amplop = "";
		$data['data']->satuan = "";
		$data['data']->jenis_tujuan = "";
		$data['data']->jenis_kirim = "";
		$data['data']->jenis_bayar = "";
		$data['data']->id_kurir = "";
		$data['data']->kurir = "";
		$data['data']->telepon_kurir = "";
		$data['data']->ongkos_kirim = "";
		$data['data']->ongkos_bongkar = "";
		$data['data']->diskon = "";
		$data['data']->ongkos_bersih = "";
		$data['data']->bayar_amplop = "";
		$data['data']->kembalian_amplop = "";
		$data['data']->status = "";
		$data['data']->keterangan = "";
		$data['data']->tarifan = "";
		$data['data']->no_po = "";
		$data['data']->no_kendaraan = "";
		$data['data']->autocode = $this->generate_code();

		if ($id) {
			$dt =  $this->transaksi_amplop_model->get_by("pg.id_amplop", $id, true);
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
			$id = $post['id'];

			if (!empty($post['id_amplop']))
				$data['id_amplop'] = $post['id_amplop'];
			else
				$error[] = "id tidak boleh kosong";

			if (!empty($post['tanggal']))
				$data['tanggal'] =  DateTime::createFromFormat('d/m/Y', $post['tanggal'])->format('Y-m-d');
			else
				$error[] = "tanggal tidak boleh kosong";

			if (!empty($post['id_pelanggan']))
				$data['id_pelanggan'] = $post['id_pelanggan'];
			else
				$error[] = "pelanggan tidak boleh kosong";



			if (!empty($post['jenis_kirim']))
				$data['jenis_kirim'] = $post['jenis_kirim'];
			else
				$error[] = "jenis kirim tidak boleh kosong";

			if (!empty($post['jenis_bayar']))
				$data['jenis_bayar'] = $post['jenis_bayar'];
			else
				$error[] = "jenis bayar tidak boleh kosong";

			if (is_numeric($post['berat_amplop']))
				$data['berat_amplop'] = $post['berat_amplop'];
			else
				$error[] = "berat kirim hanya boleh angka";

			if (is_numeric($post['tarif']))
				$data['tarif'] = $post['tarif'];
			else
					$error[] = "tarif";

			if (!empty($post['berat_amplop']))
				$data['berat_amplop'] = $post['berat_amplop'];
			else
				$error[] = "berat kirim tidak boleh kosong";

			if (!empty($post['satuan']))
				$data['satuan'] = $post['satuan'];
			else
				$error[] = "berat kirim tidak boleh kosong";

			if (is_numeric($post['ongkos_kirim']))
				$data['ongkos_kirim'] = $post['ongkos_kirim'];
			else
				$error[] = "ongkos kirim hanya boleh angka";

			if (!empty($post['ongkos_kirim']))
				$data['ongkos_kirim'] = $post['ongkos_kirim'];
			else
				$error[] = "ongkos kirim tidak boleh kosong";

			if (is_numeric($post['ongkos_bongkar']))
				$data['ongkos_bongkar'] = $post['ongkos_bongkar'];
			else
				$error[] = "ongkos bongkar muat hanya boleh angka";

			if (!empty($post['ongkos_bongkar']))
				$data['ongkos_bongkar'] = $post['ongkos_bongkar'];
			else
				$data['ongkos_bongkar'] = 0;




			if (is_numeric($post['ongkos_bersih']))
				$data['ongkos_bersih'] = $post['ongkos_bersih'];
			else
				$error[] = "ongkos bersih hanya boleh angka";

			if (!empty($post['ongkos_bersih']))
				$data['ongkos_bersih'] = $post['ongkos_bersih'];
			else
				$error[] = "ongkos bersih tidak boleh kosong";

			if (is_numeric($post['bayar_amplop']))
				$data['bayar_amplop'] = $post['bayar_amplop'];
			else
				$error[] = "bayar hanya boleh angka";

			if (!empty($post['bayar_amplop']))
				$data['bayar_amplop'] = $post['bayar_amplop'];
			else
				$data['bayar_amplop'] = 0;



			if (!empty($post['kembalian_amplop']))
				$data['kembalian_amplop'] = $post['kembalian_amplop'];
			else
				$data['kembalian_amplop'] = 0;

			if (!empty($post['nama_pengirim']))
				$data['nama_pengirim'] = $post['nama_pengirim'];
			else
				$error[] = "nama pengirim tidak boleh kosong";

			if (!empty($post['alamat_pengirim']))
				$data['alamat_pengirim'] = $post['alamat_pengirim'];
			else
				$error[] = "alamat pengirim tidak boleh kosong";

			if (!empty($post['hp_pengirim']))
				$data['hp_pengirim'] = $post['hp_pengirim'];
			else
				$error[] = "hp pengirim tidak boleh kosong";

			if (!empty($post['nama_penerima']))
				$data['nama_penerima'] = $post['nama_penerima'];
			else
				$error[] = "nama penerima tidak boleh kosong";

			if (!empty($post['alamat_penerima']))
				$data['alamat_penerima'] = $post['alamat_penerima'];
			else
				$error[] = "alamat penerima tidak boleh kosong";

			if (!empty($post['hp_penerima']))
				$data['hp_penerima'] = $post['hp_penerima'];
			else
				$error[] = "hp penerima tidak boleh kosong";

			if (!empty($post['provinsi']))
				$data['provinsi'] = $post['provinsi'];
			else
				$error[] = "provinsi tidak boleh kosong";

			if (!empty($post['kota']))
				$data['kota'] = $post['kota'];
			else
				$error[] = "kota tidak boleh kosong";

			if (!empty($post['kecamatan']))
				$data['kecamatan'] = $post['kecamatan'];
			else
				$error[] = "kecamatan tidak boleh kosong";

			if (!empty($post['id_tujuan']))
					$data['id_tujuan'] = $post['id_tujuan'];
			else
					$error[] = "tujuan tidak boleh kosong";

			if (!empty($post['tanggal']))
					$data1['tanggal'] =  DateTime::createFromFormat('d/m/Y', $post['tanggal'])->format('Y-m-d');
			else
					$error[] = "tanggal tidak boleh kosong";

			if (!empty($post['id_amplop']))
					$data1['id_amplop'] = $post['id_amplop'];
			else
					$error[] = "id tidak boleh kosong";

			$data['status'] = 1;

			if (!empty($id)) {
				if (!empty($post['status']))
					$data['status'] = $post['status'];
				else
					$error[] = "status tidak boleh kosong";
			}

			if ($data['status'] != 1) {

				if (!empty($post['keterangan']))
					$data['keterangan'] = $post['keterangan'];
				else
					$error[] = "Keterangan tidak boleh kosong";
			}

			if (empty($error)) {
				if (empty($id)) {
					$cektransaksi_amplop = $this->transaksi_amplop_model->get_by("pg.id_amplop", $post['id_amplop']);
					if (!empty($cektransaksi_amplop))
						$error[] = "id sudah terdaftar";
				}
			}

			if (empty($error)) {
				$data_history['id_amplop'] = $data['id_amplop'];
				$data_history['tanggal'] = date("Y-m-d");
				$data_history['waktu'] = date("H:i:s");
				$data_history['location'] = 'Majalaya';
				$data_history['status'] = 'Posting Loket';


				$save = $this->transaksi_amplop_model->save($id, $data, false);
				$this->transaksi_amplop_model->save_detail($data_history);

				$datailkode = $post['detail']['id_barang'];
				$datailjumlah = $post['detail']['qty'];

				if (!empty($id)) {
					$this->transaksi_amplop_model->remove_detail($id);
				}

				foreach ($datailkode as $key => $val) {

					if (empty($id))
						$detail['id_amplop'] = $data['id_amplop'];
					else
						$detail['id_amplop'] = $id;

					$detail['id_barang'] = $val;
					$detail['qty'] = $datailjumlah[$val];
					$this->transaksi_amplop_model->save_detail($detail);
				}


				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if ($post['action'] == "save")
					redirect("transaksi_amplop/manage/" . $id);
				else
					redirect("transaksi_amplop");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("transaksi_amplop/manage/" . $id);
			}
		} else
			redirect("transaksi_amplop");
	}

	public function delete($id = "")
	{
		$this->cekLoginStatus("staff gudang", true);

		if (!empty($id)) {
			$cek = $this->transaksi_amplop_model->get_by("pg.id_amplop", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("transaksi_amplop");
			} else {
				$this->transaksi_amplop_model->remove($id);
				$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
				redirect("transaksi_amplop");
			}
		} else
			redirect("transaksi_amplop");
	}

	public function generate_code()
	{
		$prefix = "TTB" . date("Ymd");
		$code = "0001";

		$last = $this->transaksi_amplop_model->get_last();
		if (!empty($last)) {
			$number = substr($last->id_amplop, 14, 15) + 1;
			$code = str_pad($number, 4, "0", STR_PAD_LEFT);
		}
		return $prefix . $code;
	}

	public  function cetak($id)
	{
		$this->cekLoginStatus("staff gudang", true);

		$data['title'] = "CETAK TTB";
		$data['layout'] = "transaksi_amplop/cetak";

		$this->load->library("qrcodeci");
		if ($id) {
			$dt =  $this->transaksi_amplop_model->get_by("pg.id_amplop", $id, true);
			if ($dt) {
				$this->qrcodeci->generate($dt->id_amplop);
				$data['data'] = $dt;
				$this->load->view('blank', $data);
			} else {
				redirect("transaksi_amplop");
			}
		} else {
			redirect("transaksi_amplop");
		}
	}

	public function rekap()
	{
		$this->cekLoginStatus("finance", true);

		$data['title'] = "Laporan TTB";
		$data['layout'] = "transaksi_amplop/rekap";

		$action = $this->input->get('action');

		$from = $this->input->get('from');
		$to = $this->input->get('to');

		$status = $this->input->get('status');

		if (!$from)
			$from = date('Y-m-d', strtotime("-30 days"));;

		if (!$to)
			$to = date("Y-m-d");

		if (!$status)
			$status = "all";

		$filter = new StdClass();
		$filter->from = date('Y-m-d', strtotime($from));
		$filter->to = date('Y-m-d', strtotime($to));
		$filter->status = $status;

		list($data['data'], $total) = $this->transaksi_amplop_model->getAll($filter, 0, 0, "pg.id_amplop", "desc");

		if ($action) {
			$this->export($action, $data['data'], $filter);
		} else
			$this->load->view('template', $data);
	}

	public function export($action, $data, $filter)
	{
		$this->cekLoginStatus("finance", true);

		$title = "Laporan TTB";
		$file_name = $title . "_" . date("Y-m-d");
		$headerTitle = $title;

		if (empty($data)) {
			$this->session->set_flashdata('admin_save_error', "data tidak tersedia");
			redirect("transaksi_amplop/rekap?from=" . $filter->from . "&to=" . $filter->to . "&status=" . $filter->status . "");
		} else {
			if ($action == "excel") {
				$this->load->library("excel");
				$this->excel->setActiveSheetIndex(0);
				$this->excel->stream($file_name . '.xls', $this->generate_format($data), $headerTitle);
			}
		}
	}

	public function generate_format($data)
	{
		$newdata = array();
		$grantotal = 0;
		foreach ($data as $key => $dt) {

			$dat = array();
			$dat['ID transaksi_amplop'] = $dt['id_amplop'];
			$dat['Tanggal'] = date("d-m-Y", strtotime($dt['tanggal']));
			$dat['Pelanggan'] = $dt['pelanggan'];
			$dat['Jenis Amplop'] = $dt['jenis_kirim'];
			$dat['Jenis Bayar'] = $dt['jenis_bayar'];
			$dat['Ongkos Kirim'] = $dt['ongkos_kirim'];
			$dat['Ongkos Lainnya'] = $dt['ongkos_bongkar'];
			$dat['Diskon'] = $dt['diskon'];
			$dat['Ongkos Bersih'] = $dt['ongkos_bersih'];
			$dat['tarif'] = $dt['tarif'];

			$status = "Dikirim";
			if ($dt['status'] == 2)
				$status = "Diterima";
			else if ($dt['status'] == 3)
				$status = "Ditolak";

			$dat['Status'] = $status;

			$newdata[] = $dat;
		}


		return $newdata;
	}

	function rupiah($angka)
	{

		$hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
		return $hasil_rupiah;
	}

	function ambil_data()
	{
		$modul = $this->input->post('modul');
		$id = $this->input->post('id');

		if ($modul == "kabupaten") {
			echo $this->transaksi_amplop_model->kabupaten($id);
		} else if ($modul == "kecamatan") {
			echo $this->transaksi_amplop_model->kecamatan($id);
		} else if ($modul == "tarif") {
			echo $this->transaksi_amplop_model->tarif($id);
		}
	}

}
