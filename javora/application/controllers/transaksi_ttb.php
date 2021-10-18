<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Transaksi_ttb extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("transaksi_ttb_model");
	}
	public function index()
	{
		$this->cekLoginStatus("staff gudang", true);

		$data['title'] = "DATA PENGIRIMAN";
		$data['layout'] = "transaksi_ttb/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->transaksi_ttb_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("transaksi_ttb?");
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

		$data['title'] = "FORM PENGIRIMAN";
		$data['layout'] = "transaksi_ttb/manage";

		$data['data'] = new StdClass();
		$data['data']->id_amplop = "";
		$data['data']->tanggal = "";
		$data['data']->id_kategori = "";
		$data['data']->kategori = "";
		$data['data']->barang = "";
		$data['data']->id_pelanggan = "";
		$data['data']->pelanggan = "";
		$data['data']->alamat = "";
		$data['data']->hp_pengirim = "";
		$data['data']->hutang = "";
		$data['data']->id_tarif = "";
		$data['data']->tarif_awal = "";
		$data['data']->tarif = "";
		$data['data']->id_tujuan = "";
		$data['data']->id_via_tujuan = "";
		$data['data']->nama_via_tujuan = "";
		$data['data']->nama_penerima = "";
		$data['data']->hp_penerima = "";
		$data['data']->alamat_penerima = "";
		$data['data']->nama_tujuan = "";

		$data['data']->tujuan = "";
		$data['data']->ongkos_kirim = "";
		$data['data']->ongkos_bongkar = "";
		$data['data']->diskon = "";
		$data['data']->ongkos_bersih = "";
		$data['data']->bayar_amplop = "";
		$data['data']->kembalian_amplop = "";
		$data['data']->hargakg = "";
		$data['data']->berat_amplop = "";
		$data['data']->satuan = "";
		$data['data']->jenis_kirim = "";
		$data['data']->jenis_bayar = "";
		$data['data']->status = "";
		$data['data']->keterangan = "";
		$data['data']->penerimaan = "";
		$data['data']->no_po = "";
		$data['data']->no_kendaraan = "";
		$data['data']->autocode = $this->generate_code();

		if ($id) {
			$dt =  $this->transaksi_ttb_model->get_by("pg.id_amplop", $id, true);
			if (!empty($dt))
				$data['data'] = $dt;
		}

		$this->load->view('template', $data);
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

			if (!empty($post['tarif']))
				$data['tarif'] = $post['tarif'];
			else
				$error[] = "tarif tidak boleh kosong";

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

			if (!empty($post['id_tujuan']))
				$data['id_tujuan'] = $post['id_tujuan'];
			else
				$error[] = "tujuan tidak boleh kosong";


			if (!empty($post['id_via_tujuan']))
				$data['id_via_tujuan'] = $post['id_via_tujuan'];
			else
				$error[] = "via tujuan tidak boleh kosong";




			$data['status'] = 1;
			$data['status_delete'] = 1;

			if (!empty($id)) {
				if (!empty($post['status']))
					$data['status'] = $post['status'];
				else
					$error[] = "status tidak boleh kosong";
			}

			if ($data['status'] != 1) {
				if (!empty($post['penerima']))
					$data['penerima'] = $post['penerima'];
				else
					$error[] = "keterangan tidak boleh kosong";

				if (!empty($post['keterangan']))
					$data['keterangan'] = $post['keterangan'];
				else
					$error[] = "keterangan tidak boleh kosong";
			}

			if (empty($error)) {
				if (empty($id)) {
					$cektransaksi_ttb = $this->transaksi_ttb_model->get_by("pg.id_amplop", $post['id_amplop']);
					if (!empty($cektransaksi_ttb))
						$error[] = "id sudah terdaftar";
				}
			}

			if (empty($error)) {
				$pelanggan = $post['id_pelanggan'];
				$cek_saldo = $this->transaksi_ttb_model->get_by_pelanggan("pg.id_pelanggan", $pelanggan, true);

				$data_history['id_amplop'] = $data['id_amplop'];
				$data_history['tanggal'] = date("Y-m-d");
				$data_history['waktu'] = date("H:i:s");
				$data_history['location'] = 'Majalaya';
				$data_history['status'] = 'Diterima Oleh STB';

				$qty = $data['berat_amplop'];
				$satuan = $data['satuan'];
				$tujuan = $post['nama_tujuan'];
				$deskripsi = "Pengiriman Ke $tujuan sebanyak $qty $satuan";


				$data_piutang['coa'] = 113101;
				$data_piutang['id_pelanggan'] = $data['id_pelanggan'];
				$data_piutang['tgl_transaksi'] = date("Y-m-d");
				$data_piutang['id_amplop'] = $data['id_amplop'];
				$data_piutang['jumlah_piutang'] = $data['ongkos_bersih'];
				$data_piutang['jumlah_bayar'] = $data['bayar_amplop'];
				$data_piutang['sisa_piutang'] = $data_piutang['jumlah_piutang'] - $data_piutang['jumlah_bayar'];
				$data_piutang['keterangan'] = $deskripsi;


				$data_rekening_piutang['id_pelanggan'] = $data['id_pelanggan'];
				$data_rekening_piutang['tanggal'] = date("Y-m-d");
				$data_rekening_piutang['no_bukti'] = $data['id_amplop'];
				$data_rekening_piutang['debit'] = $data['ongkos_bersih'];
				$data_rekening_piutang['kredit'] = $data['bayar_amplop'];

				$saldo_awal = $cek_saldo->hutang;
				$saldo_akhir = $data_rekening_piutang['debit'] - $data_rekening_piutang['kredit'];

				$saldo = $saldo_awal + 	$saldo_akhir;

				$data_pelanggan['hutang'] = $saldo;
				$data_rekening_piutang['saldo'] = $saldo;
				$data_rekening_piutang['deskripsi'] = $deskripsi;

				if ($post['kembalian_amplop'] < 0)
					$data_piutang['status']  = 'Belum Lunas';
				else
					$data_piutang['status']  = 'Lunas';

				$save = $this->transaksi_ttb_model->save($id, $data, false);
				$this->transaksi_ttb_model->save_detail($data_history);
				$this->transaksi_ttb_model->save_piutang($data_piutang);
				$this->transaksi_ttb_model->save_rekening_piutang($data_rekening_piutang);
				$this->transaksi_ttb_model->update_hutang_pelanggan($pelanggan, $data_pelanggan, false);

				$datailkode = $post['detail']['id_barang'];
				$datailjumlah = $post['detail']['qty'];

				if (!empty($id)) {
					$this->transaksi_ttb_model->remove_detail($id);
				}

				foreach ($datailkode as $key => $val) {

					if (empty($id))
						$detail['id_amplop'] = $data['id_amplop'];
					else
						$detail['id_amplop'] = $id;


					$this->transaksi_ttb_model->save_detail($detail);
				}


				$this->session->set_flashdata('admin_save_success', "data berhasile disimpan");
				$my_apikey = "IYQZZJDEI5QD31CRRZMV";
				//$destination = 6281323268184;
				$destination = $data['hp_pengirim'];
				$amplop = $data['id_amplop'];
				$kepada = $data['nama_penerima'];
				$alamat = $data['alamat_penerima'];
				$banyak = $data['berat_amplop'];
				$satuan = $data['satuan'];
				$biaya =	$data['ongkos_bersih'];
				$header = "Yth Bapak / Ibu";
				$isi = "Terimakasih Sudah Menggunakan Jasa Pengiriman STB untuk pengiriman ke $kepada Alamat $alamat Sebanyak @ $banyak $satuan dengan no ttb  *$amplop* dengan biaya Rp. $biaya";
				$footer = "Status Pengiriman dapat dipantau dengan mengunjungi website http://setiatransbudi.com/  dengan memasukan no ttb";
				$headers = "From: Admin@contoh.com" . "\r\n";
				$message = $header . "\r\n\n" .
					$isi . "\r\n\n" .
					$footer;
				$api_url = "http://panel.rapiwha.com/send_message.php";
				$api_url .= "?apikey=" . urlencode($my_apikey);
				$api_url .= "&number=" . urlencode($destination);
				$api_url .= "&text=" . urlencode($message);
				$my_result_object = json_decode(file_get_contents($api_url, false));

				if ($post['action'] == "save")
					redirect("transaksi_ttb/manage/" . $id);
				else
					redirect("transaksi_ttb");
			} else {
				$err_string = "<ul>";
				foreach ($error as $err)
					$err_string .= "<li>" . $err . "</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("transaksi_ttb/manage/" . $id);
			}
		} else
			redirect("transaksi_ttb");
	}

	public function delete($id = "")
	{
		$this->cekLoginStatus("staff gudang", true);

		if (!empty($id)) {
			$cek = $this->transaksi_ttb_model->get_by("pg.id_amplop", $id, true);
			if (empty($cek)) {
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("transaksi_ttb");
			} else {
				$this->transaksi_ttb_model->remove($id);
				$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
				redirect("transaksi_ttb");
			}
		} else
			redirect("transaksi_ttb");
	}

	public function generate_code()
	{
		$prefix = "TTB" . date("Y");
		$code = "0001";

		$last = $this->transaksi_ttb_model->get_last();

		if (!empty($last)) {
			$number = substr($last->id_amplop, 8, 9) + 1;
			//var_dump($number);
			//exit();
			$code = str_pad($number, 4, "0", STR_PAD_LEFT);
		}
		return $prefix . $code;
	}


	public function cetak($id)
	{
		$this->cekLoginStatus("staff gudang", true);

		$data['title'] = "CETAK PENGIRIMAN";
		$data['layout'] = "transaksi_ttb/cetak";

		$this->load->library("qrcodeci");
		if ($id) {
			$dt =  $this->transaksi_ttb_model->get_by("pg.id_amplop", $id, true);
			if ($dt) {
				$this->qrcodeci->generate($dt->id_amplop);
				$data['data'] = $dt;
				//var_dump($dt);
				//exit();
				$this->load->view('blank', $data);
			} else {
				redirect("transaksi_ttb");
			}
		} else {
			redirect("transaksi_ttb");
		}

		$this->load->library('pdf');
		$html = $this->load->view('transaksi_ttb/cetak', [], true);
		$this->pdf->createPDF($html, 'mypdf');
	}

	public function rekap()
	{
		$this->cekLoginStatus("finance", true);

		$data['title'] = "Laporan Transaksi_ttb Barang";
		$data['layout'] = "transaksi_ttb/rekap";

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

		list($data['data'], $total) = $this->transaksi_ttb_model->getAll($filter, 0, 0, "pg.id_amplop", "desc");

		if ($action) {
			$this->export($action, $data['data'], $filter);
		} else
			$this->load->view('template', $data);
	}

	public function export($action, $data, $filter)
	{
		$this->cekLoginStatus("finance", true);

		$title = "Laporan Data Transaksi_ttb Barang";
		$file_name = $title . "_" . date("Y-m-d");
		$headerTitle = $title;

		if (empty($data)) {
			$this->session->set_flashdata('admin_save_error', "data tidak tersedia");
			redirect("transaksi_ttb/rekap?from=" . $filter->from . "&to=" . $filter->to . "&status=" . $filter->status . "");
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
			$dat['ID Transaksi_ttb'] = $dt['id_amplop'];
			$dat['Tanggal'] = date("d-m-Y", strtotime($dt['tanggal']));
			$dat['Pelanggan'] = $dt['pelanggan'];
			$dat['No. PO'] = $dt['no_po'];
			$dat['Tarif'] = $dt['tarif'];
			$dat['No. Kendaraan'] = $dt['no_kendaraan'];
			$dat['Penerima'] = $dt['penerima'];

			$status = "Dikirim";
			if ($dt['status'] == 2)
				$status = "Diterima";
			else if ($dt['status'] == 3)
				$status = "Ditolak";
			else if ($dt['status'] == 4)
				$status = "Diterima sebagian";

			$dat['Status'] = $status;

			$newdata[] = $dat;
		}


		return $newdata;
	}
}
