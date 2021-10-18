<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Laporan_pembayaran extends Admin_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model("laporan_pembayaran_model");
    }
	public function index()
	{
		$this->cekLoginStatus("staff gudang",true);

		$data['title'] = "DATA PEMBAYARAN";
		$data['layout'] = "laporan_pembayaran/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if(!$page)
			$page = 1;

		$offset = ($page-1) * $limit;

		list($data['data'],$total) = $this->laporan_pembayaran_model->getAll($filter,$limit,$offset,$orderBy,$orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("laporan_pembayaran?");
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
		$data['layout'] = "laporan_pembayaran/manage";

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
			$dt =  $this->laporan_pembayaran_model->get_by("pg.no_bayar_amplop",$id,true);
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
					$ceklaporan_pembayaran = $this->laporan_pembayaran_model->get_by("pg.no_bayar_amplop",$post['no_bayar_amplop']);
					if(!empty($ceklaporan_pembayaran))
						$error[] = "id sudah terdaftar";
				}
			}

			if(empty($error))
			{
				$id_amplop = $post['id_amplop'];
				$data_ubah_daftar_piutang['jumlah_bayar']  = $post['bayar_amplop'] + $post['jumlah_bayar'] ;
				$data_ubah_daftar_piutang['sisa_piutang']  = $post['sisa_piutang']-$post['bayar_amplop'] ;
				if($post['kembalian_amplop'] < 0)
					$data_ubah_daftar_piutang['status']  = 'Belum Lunas';
				else
						$data_ubah_daftar_piutang['status']  = 'Lunas';
				$save = $this->laporan_pembayaran_model->save($id,$data,false);
				$ubah_piutang = $this->laporan_pembayaran_model->ubah_piutang($id_amplop,$data_ubah_daftar_piutang,false);
				$datailkode = $post['detail']['id_barang'];
				$datailjumlah = $post['detail']['qty'];

				if(!empty($id))
				{
					$this->laporan_pembayaran_model->remove_detail($id);
				}
				foreach($datailkode as $key => $val)
				{
					if(empty($id))
						$detail['no_bayar_amplop'] = $data['no_bayar_amplop'];
					else
						$detail['no_bayar_amplop'] = $id;
					$this->laporan_pembayaran_model->save_detail($detail);
				}


				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if($post['action'] == "save")
					redirect("laporan_pembayaran/manage/".$id);
				else
					redirect("laporan_pembayaran");
			}
			else
			{
				$err_string = "<ul>";
				foreach($error as $err)
					$err_string .= "<li>".$err."</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("laporan_pembayaran/manage/".$id);
			}
		}
		else
		  redirect("laporan_pembayaran");
	}

	public function delete($id = "")
	{
		$this->cekLoginStatus("staff gudang",true);

		if(!empty($id))
		{
			$cek = $this->laporan_pembayaran_model->get_by("pg.no_bayar_amplop",$id,true);
			if(empty($cek))
			{
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("laporan_pembayaran");
			}
			else
			{
				$this->laporan_pembayaran_model->remove($id);
				$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
				redirect("laporan_pembayaran");
			}
		}
		else
			redirect("laporan_pembayaran");
	}

	public function generate_code()
	{
		$prefix = "TTB" . date("Ymd");
		$code = "0001";

		$last = $this->laporan_pembayaran_model->get_last();
		if (!empty($last)) {
			$number = substr($last->no_bayar_amplop, 14, 15) + 1;
			$code = str_pad($number, 4, "0", STR_PAD_LEFT);
		}
		return $prefix . $code;
	}

	public  function cetak($id)
	{
		$this->cekLoginStatus("staff gudang",true);

		$data['title'] = "CETAK PENGIRIMAN";
		$data['layout'] = "laporan_pembayaran/cetak";

		$this->load->library("qrcodeci");
		if($id)
		{
			$dt =  $this->laporan_pembayaran_model->get_by("pg.no_bayar_amplop",$id,true);
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
				redirect("laporan_pembayaran");
			}

		}
		else
		{
			redirect("laporan_pembayaran");
		}
	}

	public function rekap()
	{
		$this->cekLoginStatus("finance",true);

		$data['title'] = "Laporan Pembayaran Pelanggan";
		$data['layout'] = "laporan_pembayaran/rekap";

		$action = $this->input->get('action');

		$from = $this->input->get('from');
		$to = $this->input->get('to');

		$status = $this->input->get('status');

		if(!$from)
			$from = date('Y-m-d',strtotime("-30 days")); ;

		if(!$to)
			$to = date("Y-m-d");



		$filter = new StdClass();
		$filter->from = date('Y-m-d',strtotime($from));
		$filter->to = date('Y-m-d',strtotime($to));
		$filter->status = $status;

		list($data['data'],$total) = $this->laporan_pembayaran_model->getAllLaporanPiutangPerPelanggan($filter,0,0,"pg.id_pelanggan","desc");


		if($action)
		{
			$this->export($action,$data['data'],$filter);
		}
		else

				$this->load->view('template',$data);

	}

	public function rekaplanjut($id = "")
	{
		$this->cekLoginStatus("finance",true);

		$data['title'] = "Laporan Piutang Pelanggan";
		$data['layout'] = "laporan_pembayaran/rekaplanjut";
		$action = $this->input->get('actiondetail');
		$cek_nama = $this->laporan_pembayaran_model->get_nama_pelanggan("pg.id_pelanggan",$id,true);

		$data['title1'] = $cek_nama->nama;
		$data['id'] = $id;
		list($data['data'],$total) = $this->laporan_pembayaran_model->getAllLaporanPiutangDetailPerPelanggan($id,0,0,"pg.id_pelanggan","desc");
		if($action)
		{

			$this->exportdetail($action,$data['data'],$id);
		}
		else
				$this->load->view('template',$data);

	}



	public function export($action,$data,$filter)
	{
		$this->cekLoginStatus("finance",true);

		$title = "Laporan Pembayaran";
		$file_name = $title."_".date("Y-m-d");
		$headerTitle = $title;

		if(empty($data))
		{
			$this->session->set_flashdata('admin_save_error', "data tidak tersedia");
			redirect("laporan_pembayaran/rekap?from=".$filter->from."&to=".$filter->to."&status=".$filter->status."");
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

	public function exportdetail($action,$data,$id)
	{
		$this->cekLoginStatus("finance",true);
		$cek_nama = $this->laporan_pembayaran_model->get_nama_pelanggan("pg.id_pelanggan",$id,true);
		$nama = $cek_nama->nama;
		//var_dump($nama);
		//exit();
		//var_dump($data);
		//exit();
		$title = "Rincian Pembayaran Piutang an $nama";
		$file_name = $title."_".date("Y-m-d");
		$headerTitle = $title;

		if(empty($data))
		{
			$this->session->set_flashdata('admin_save_error', "data tidak tersedia");
			redirect("laporan_pembayaran/rekaplanjut");
		}
		else
		{
			if($action == "exceldetail")
			{
				$this->load->library("excel");
				$this->excel->setActiveSheetIndex(0);
				$this->excel->stream($file_name.'.xls',$this->generate_format_detail($data),$headerTitle);
			}
		}
	}

	public function generate_format_detail($data)
	{
		$newdata = array();
		$grantotal = 0;
		$i=0;
		foreach($data as $key => $dt)

		{
					$i++;
			$dat = array();
			$dat['No'] = $i;
			$dat['Tanggal'] = date("d-m-Y",strtotime($dt['tanggal_bayar_amplop']));
			$dat['Deskripsi'] = $dt['no_bayar_amplop'];
			$dat['No Bukti'] = $dt['no_bayar_amplop'];
			$dat['Kredit'] = $dt['terbayar'];

			$newdata[] = $dat;
		}


		return $newdata;
	}

	public function generate_format($data)
	{
		$newdata = array();
		$grantotal = 0;
		$i=0;
		foreach($data as $key => $dt)
		{
			$i++;
			$dat = array();
			$dat['No'] = $i;
			$dat['Tanggal'] = date("d-m-Y",strtotime($dt['tanggal']));
			$dat['Kode Pelanggan'] = $dt['id_pelanggan'];
			$dat['Nama Pelanggan'] = $dt['nama'];
			$dat['Kredit'] = $dt['totalkredit'];


			$newdata[] = $dat;
		}


		return $newdata;
	}

}
