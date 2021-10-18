<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transaksi_pembayaran_amplop extends Admin_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model("transaksi_pembayaran_amplop_model");
    }
	public function index()
	{
		$this->cekLoginStatus("staff gudang",true);

		$data['title'] = "DATA PEMBAYARAN";
		$data['layout'] = "transaksi_pembayaran_amplop/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if(!$page)
			$page = 1;

		$offset = ($page-1) * $limit;

		list($data['data'],$total) = $this->transaksi_pembayaran_amplop_model->getAll($filter,$limit,$offset,$orderBy,$orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("transaksi_pembayaran_amplop?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		$this->load->view('template',$data);
	}

	public function manage($id = "")
	{
		$this->cekLoginStatus("staff gudang",true);

		$data['title'] = "FORM PEMBAYARAN";
		$data['layout'] = "transaksi_pembayaran_amplop/manage";

		$data['data'] = new StdClass();
		$data['data']->no_bayar_amplop = "";
		$data['data']->id_amplop = "";
		$data['data']->tanggal = "";
		$data['data']->id_kategori = "";
		$data['data']->kategori = "";
		$data['data']->barang = "";
		$data['data']->id_pelanggan = "";
		$data['data']->pelanggan = "";
		$data['data']->alamat = "";
		$data['data']->hp_pengirim = "";
		$data['data']->id_tarif = "";
		$data['data']->tarif = "";
		$data['data']->id_tujuan = "";
		$data['data']->tujuan = "";
		$data['data']->jumlah_piutang = "";
		$data['data']->jumlah_bayar = "";
		$data['data']->sisa_piutang = "";
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

		if($id)
		{
			$dt =  $this->transaksi_pembayaran_amplop_model->get_by("pg.no_bayar_amplop",$id,true);
			if(!empty($dt))
				$data['data'] = $dt;
		}

		$this->load->view('template',$data);
	}

	public function save()
	{
		$this->cekLoginStatus("staff gudang",true);

		$data = array();
		$post = $this->input->post();

		if($post)
		{
			$error = array();
			$id = $post['id'];
			if(!empty($post['jumlah_piutang']))
				$data['jumlah'] = $post['jumlah_piutang'];
			else
				$error[] = "id tidak boleh kosong";

			if(!empty($post['no_bayar_amplop']))
				$data['no_bayar_amplop'] = $post['no_bayar_amplop'];
			else
				$error[] = "faktur tidak boleh kosong";

			if(!empty($post['tanggal']))
				$data['tanggal_bayar_amplop'] =  DateTime::createFromFormat('d/m/Y', $post['tanggal'])->format('Y-m-d');
			else
				$error[] = "tanggal tidak boleh kosong";
			if(!empty($post['id_pelanggan']))
				$data['id_pelanggan'] = $post['id_pelanggan'];
			else
				$error[] = "pelanggan tidak boleh kosong";
			if(!empty($post['id_pelanggan']))
				$data['id_amplop'] = $post['id_amplop'];
			else
				$error[] = "amplop tidak boleh kosong";
				if (is_numeric($post['bayar_amplop']))
					$data['terbayar'] = $post['bayar_amplop'];
				else
					$error[] = "bayar hanya boleh angka";

				if (!empty($post['bayar_amplop']))
					$data['terbayar'] = $post['bayar_amplop'];
				else
					$data['terbayar'] = 0;
				if($post['kembalian_amplop'] < 0)
					$data['status']  = 'Belum Lunas';
				else
					$data['status']  = 'Lunas';
			if(!empty($id))
			{
				if(!empty($post['status']))
					$data['status'] = $post['status'];
				else
					$error[] = "status tidak boleh kosong";
			}
			if(empty($error))
			{
				if(empty($id))
				{
					$cektransaksi_pembayaran_amplop = $this->transaksi_pembayaran_amplop_model->get_by("pg.no_bayar_amplop",$post['no_bayar_amplop']);
					if(!empty($cektransaksi_pembayaran_amplop))
						$error[] = "id sudah terdaftar";
				}
			}

			if(empty($error))
			{
				$deskripsi = "Pembayaran";
				$pelanggan = $post['id_pelanggan'];
				$id_amplop = $post['id_amplop'];
				$data_ubah_daftar_piutang['jumlah_bayar']  = $post['bayar_amplop'] + $post['jumlah_bayar'] ;
				$data_ubah_daftar_piutang['sisa_piutang']  = $post['sisa_piutang']-$post['bayar_amplop'] ;
				if($post['kembalian_amplop'] < 0)
					$data_ubah_daftar_piutang['status']  = 'Belum Lunas';
				else
						$data_ubah_daftar_piutang['status']  = 'Lunas';

				$data_rekening_piutang['id_pelanggan'] = $pelanggan;
				$data_rekening_piutang['tanggal'] = date("Y-m-d");
				$data_rekening_piutang['no_bukti'] = $data['no_bayar_amplop'];
				$data_rekening_piutang['debit'] = 0;
				$data_rekening_piutang['kredit'] = $post['bayar_amplop'];
				$saldo = $post['sisa_piutang']-$post['bayar_amplop'] ;
				$data_rekening_piutang['saldo'] = $saldo;
				$data_rekening_piutang['deskripsi'] = $deskripsi;

				$data_pelanggan['hutang'] = $saldo;

				//var_dump($saldo);
				//exit();

				$save = $this->transaksi_pembayaran_amplop_model->save($id,$data,false);
				$ubah_piutang = $this->transaksi_pembayaran_amplop_model->ubah_piutang($id_amplop,$data_ubah_daftar_piutang,false);
				$this->transaksi_pembayaran_amplop_model->save_rekening_piutang($data_rekening_piutang);
				$this->transaksi_pembayaran_amplop_model->update_hutang_pelanggan($pelanggan,$data_pelanggan,false);


				$datailkode = $post['detail']['id_barang'];
				$datailjumlah = $post['detail']['qty'];

				if(!empty($id))
				{
					$this->transaksi_pembayaran_amplop_model->remove_detail($id);
				}
				foreach($datailkode as $key => $val)
				{
					if(empty($id))
						$detail['no_bayar_amplop'] = $data['no_bayar_amplop'];
					else
						$detail['no_bayar_amplop'] = $id;
					$this->transaksi_pembayaran_amplop_model->save_detail($detail);
				}


				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if($post['action'] == "save")
					redirect("transaksi_pembayaran_amplop/manage/".$id);
				else
					redirect("transaksi_pembayaran_amplop");
			}
			else
			{
				$err_string = "<ul>";
				foreach($error as $err)
					$err_string .= "<li>".$err."</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("transaksi_pembayaran_amplop/manage/".$id);
			}
		}
		else
		  redirect("transaksi_pembayaran_amplop");
	}

	public function delete($id = "")
	{
		$this->cekLoginStatus("staff gudang",true);

		if(!empty($id))
		{
			$cek = $this->transaksi_pembayaran_amplop_model->get_by("pg.no_bayar_amplop",$id,true);
			if(empty($cek))
			{
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("transaksi_pembayaran_amplop");
			}
			else
			{
				$this->transaksi_pembayaran_amplop_model->remove($id);
				$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
				redirect("transaksi_pembayaran_amplop");
			}
		}
		else
			redirect("transaksi_pembayaran_amplop");
	}

	public function generate_code()
	{
		$prefix = "STB" . date("Y");
		$code = "0001";

		$last = $this->transaksi_pembayaran_amplop_model->get_last();

		if (!empty($last)) {
			$number = substr($last->no_bayar_amplop, 8, 9) + 1;
			//var_dump($number);
			//exit();
			$code = str_pad($number, 4, "0", STR_PAD_LEFT);
		}
		return $prefix . $code;
	}

	public  function cetak($id)
	{
		$this->cekLoginStatus("staff gudang",true);

		$data['title'] = "CETAK PENGIRIMAN";
		$data['layout'] = "transaksi_pembayaran_amplop/cetak";

		$this->load->library("qrcodeci");
		if($id)
		{
			$dt =  $this->transaksi_pembayaran_amplop_model->get_by("pg.no_bayar_amplop",$id,true);
			if($dt)
			{
				$this->qrcodeci->generate($dt->no_bayar_amplop);
				$data['data'] = $dt;
				//var_dump($dt);
				//exit();
				$this->load->view('blank',$data);
			}
			else
			{
				redirect("transaksi_pembayaran_amplop");
			}

		}
		else
		{
			redirect("transaksi_pembayaran_amplop");
		}
	}

	public function rekap()
	{
		$this->cekLoginStatus("finance",true);

		$data['title'] = "Laporan Piutang Pelanggan";
		$data['layout'] = "transaksi_pembayaran_amplop/rekap";

		$action = $this->input->get('action');

		$from = $this->input->get('from');
		$to = $this->input->get('to');

		$status = $this->input->get('status');

		if(!$from)
			$from = date('Y-m-d',strtotime("-30 days")); ;

		if(!$to)
			$to = date("Y-m-d");

		if(!$status)
			$status = "all";

		$filter = new StdClass();
		$filter->from = date('Y-m-d',strtotime($from));
		$filter->to = date('Y-m-d',strtotime($to));
		$filter->status = $status;

		list($data['data'],$total) = $this->transaksi_pembayaran_amplop_model->getAllLaporanPiutangPerPelanggan($filter,0,0,"pg.id_pelanggan","desc");


		if($action)
		{
			$this->export($action,$data['data'],$filter);
		}
		else
				$this->load->view('template',$data);

	}

	public function rekapdetail($id = "")
	{
		$this->cekLoginStatus("finance",true);

		$data['title'] = "Detail Transaksi Pelanggan";
		$data['layout'] = "transaksi_pembayaran_amplop/rekapdetail";



		$id = $id;

		list($data['data'],$total) = $this->transaksi_pembayaran_amplop_model->getAllLaporanPiutangDetailPerPelanggan($id,0,0,"pg.id_pelanggan","desc");




				$this->load->view('template',$data);

	}

	public function export($action,$data,$filter)
	{
		$this->cekLoginStatus("finance",true);

		$title = "Laporan Data Transaksi_pembayaran_amplop Barang";
		$file_name = $title."_".date("Y-m-d");
		$headerTitle = $title;

		if(empty($data))
		{
			$this->session->set_flashdata('admin_save_error', "data tidak tersedia");
			redirect("transaksi_pembayaran_amplop/rekap?from=".$filter->from."&to=".$filter->to."&status=".$filter->status."");
		}
		else
		{
			if($action == "excel")
			{
				$this->load->library("excel");
				$this->excel->setActiveSheetIndex(0);
				$this->excel->stream($file_name.'.xls',$this->generate_format($data),$headerTitle);
			}
		}
	}

	public function generate_format($data)
	{
		$newdata = array();
		$grantotal = 0;
		foreach($data as $key => $dt)
		{

			$dat = array();
			$dat['No Ttb'] = $dt['id_amplop'];
			$dat['Tanggal'] = date("d-m-Y",strtotime($dt['tgl_transaksi']));
			$dat['Pelanggan'] = $dt['id_pelanggan'];
			$dat['Jumlah Piutang'] = $dt['jumlah_piutang'];
			$dat['Jumlah Bayar'] = $dt['jumlah_bayar'];
			$dat['Sisa Piutang'] = $dt['sisa_piutang'];

			$status = "Dikirim";
			if($dt['status'] == 'Lunas')
				$status = "Lunas";
			else if($dt['status'] == 'Belum Lunas')
				$status = "Belum Lunas";

			$dat['Status'] = $status;

			$newdata[] = $dat;
		}


		return $newdata;
	}

}
