<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pengiriman extends Admin_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model("pengiriman_model");
    }
	public function index()
	{
		$this->cekLoginStatus("staff gudang",true);

		$data['title'] = "DATA PENGIRIMAN";
		$data['layout'] = "pengiriman/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if(!$page)
			$page = 1;

		$offset = ($page-1) * $limit;

		list($data['data'],$total) = $this->pengiriman_model->getAll($filter,$limit,$offset,$orderBy,$orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("pengiriman?");
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

		$data['title'] = "FORM PENGIRIMAN";
		$data['layout'] = "pengiriman/manage";

		$data['data'] = new StdClass();
		$data['data']->id_surat_jalan = "";
		$data['data']->id = "";
		$data['data']->tanggal = "";
		$data['data']->id_kategori = "";
		$data['data']->kategori = "";
		$data['data']->barang = "";
		$data['data']->id_pool = "";
		$data['data']->pool = "";
		$data['data']->alamat = "";
		$data['data']->id_driver = "";
		$data['data']->driver = "";
		$data['data']->status = "";
		$data['data']->keterangan = "";
		$data['data']->penerimaan = "";
		$data['data']->no_po = "";
		$data['data']->nopol = "";
		$data['data']->autocode = $this->generate_code();

		if($id)
		{
			$dt =  $this->pengiriman_model->get_by("pg.id_surat_jalan",$id,true);
			if(!empty($dt))
				$data['data'] = $dt;
		}
		$this->load->model("master_kendaraan_model");
		list($data['kendaraan'],$total) = $this->master_kendaraan_model->getAll(null,null,null,null,null);

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

			if(!empty($post['id_surat_jalan']))
				$data['id_surat_jalan'] = $post['id_surat_jalan'];
			else
				$error[] = "id tidak boleh kosong";

			if(!empty($post['tanggal']))
				$data['tanggal'] =  DateTime::createFromFormat('d/m/Y', $post['tanggal'])->format('Y-m-d');
			else
				$error[] = "tanggal tidak boleh kosong";



			if(!empty($post['id_driver']))
				$data['id_driver'] = $post['id_driver'];
			else
				$error[] = "driver tidak boleh kosong";


			if(!empty($post['id_kendaraan']))
				$data['id_kendaraan'] = $post['id_kendaraan'];
			else
				$error[] = "id kendaraan tidak boleh kosong";


			$data['status'] = 1;

			if(!empty($id))
			{
				if(!empty($post['status']))
					$data['status'] = $post['status'];
				else
					$error[] = "status tidak boleh kosong";
			}

			if($data['status'] != 1)
			{
				if(!empty($post['penerima']))
					$data['penerima'] = $post['penerima'];
				else
					$error[] = "keterangan tidak boleh kosong";

				if(!empty($post['keterangan']))
					$data['keterangan'] = $post['keterangan'];
				else
					$error[] = "keterangan tidak boleh kosong";
			}

			if(empty($error))
			{
				if(empty($id))
				{
					$cekpengiriman = $this->pengiriman_model->get_by("pg.id_surat_jalan",$post['id_surat_jalan']);
					if(!empty($cekpengiriman))
						$error[] = "id sudah terdaftar";
				}
			}

			if(empty($error))
			{
				$save = $this->pengiriman_model->save($id,$data,false);

				$datailkode = $post['detail']['id_amplop'];
				$datailpool = $post['detail']['id_tujuan'];
				$datailjumlah = $post['detail']['qty'];


				if(!empty($id))
				{
					$this->pengiriman_model->remove_detail($id);
				}

				foreach($datailkode as $key => $val)
				{

					if(empty($id))
						$detail['id_surat_jalan'] = $data['id_surat_jalan'];
					else
						$detail['id_surat_jalan'] = $id;

					$detail['id_amplop'] = $val;
					$detailhistory['id_amplop'] = $val;
					$detailhistory['tanggal'] = date("Y-m-d");
					$detailhistory['waktu'] = date("H:i:s");
					$detailhistory['location'] = 'Perjalanan Menuju Tujuan';
					$detailhistory['status'] = 'Dikirim';


					$form_data['status'] = 2;
					if ($post['status'] != 2) {
						$form_data['status'] = 2;
					}

					$where2['id_amplop'] = $val;
					$this->pengiriman_model->amplop_detail_update_process_db($form_data, $where2);

					$this->pengiriman_model->save_detail($detail);
					$this->pengiriman_model->save_history($detailhistory);
				}


				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if($post['action'] == "save")
					redirect("pengiriman/manage/".$id);
				else
					redirect("pengiriman");
			}
			else
			{
				$err_string = "<ul>";
				foreach($error as $err)
					$err_string .= "<li>".$err."</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("pengiriman/manage/".$id);
			}
		}
		else
		  redirect("pengiriman");
	}

	public function delete($id = "")
	{
		$this->cekLoginStatus("staff gudang",true);

		if(!empty($id))
		{
			$cek = $this->pengiriman_model->get_by("pg.id_surat_jalan",$id,true);
			if(empty($cek))
			{
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("pengiriman");
			}
			else
			{
				$this->pengiriman_model->remove($id);
				$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
				redirect("pengiriman");
			}
		}
		else
			redirect("pengiriman");
	}

	public function generate_code()
	{
		$prefix = "SPB" . date("Y");
		$code = "0001";

		$last = $this->pengiriman_model->get_last();

		if (!empty($last)) {
			$number = substr($last->id_surat_jalan, 9, 8) + 1;
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
		$data['layout'] = "pengiriman/cetak";

		$this->load->library("qrcodeci");
		if($id)
		{
			$dt =  $this->pengiriman_model->get_by("pg.id_surat_jalan",$id,true);
			if($dt)
			{
				$this->qrcodeci->generate($dt->id_surat_jalan);
				$data['data'] = $dt;
				//var_dump($dt);
				//exit();
				$this->load->view('blank',$data);
			}
			else
			{
				redirect("pengiriman");
			}

		}
		else
		{
			redirect("pengiriman");
		}
	}

	public function rekap()
	{
		$this->cekLoginStatus("finance",true);

		$data['title'] = "Laporan Pengiriman Barang";
		$data['layout'] = "pengiriman/rekap";

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

		list($data['data'],$total) = $this->pengiriman_model->getAllLaporan($filter,0,0,"pg.id_surat_jalan","desc");

		if($action)
		{
			$this->export($action,$data['data'],$filter);
		}
		else
				$this->load->view('template',$data);

	}

	public function rekapbooking()
	{
		$this->cekLoginStatus("finance",true);

		$data['title'] = "Monitoring Ttb Booking";
		$data['layout'] = "pengiriman/rekapbooking";

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

		list($data['data'],$total) = $this->pengiriman_model->getAllLaporanbooking($filter,0,0,"pg.id_amplop","desc");

		if($action)
		{
			$this->export($action,$data['data'],$filter);
		}
		else
				$this->load->view('template',$data);

	}

	public function rekapditerimastb()
	{
		$this->cekLoginStatus("finance",true);

		$data['title'] = "Monitoring Ttb Diterima Oleh STB";
		$data['layout'] = "pengiriman/rekapditerimastb";

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

		list($data['data'],$total) = $this->pengiriman_model->getAllLaporanditerimastb($filter,0,0,"pg.id_amplop","desc");

		if($action)
		{
			$this->export($action,$data['data'],$filter);
		}
		else
				$this->load->view('template',$data);

	}

	public function rekapdikirim()
	{
		$this->cekLoginStatus("finance",true);

		$data['title'] = "Monitoring Ttb Dikirim";
		$data['layout'] = "pengiriman/rekapdikirim";

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

		list($data['data'],$total) = $this->pengiriman_model->getAllLaporandikirim($filter,0,0,"pg.id_surat_jalan","desc");

		if($action)
		{
			$this->export($action,$data['data'],$filter);
		}
		else
				$this->load->view('template',$data);

	}

	public function rekapretur()
	{
		$this->cekLoginStatus("finance",true);

		$data['title'] = "Monitoring Ttb Retur";
		$data['layout'] = "pengiriman/rekapretur";

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

		list($data['data'],$total) = $this->pengiriman_model->getAllLaporanretur($filter,0,0,"pg.id_surat_jalan","desc");

		if($action)
		{
			$this->export($action,$data['data'],$filter);
		}
		else
				$this->load->view('template',$data);

	}

	public function rekapditerimapenerima()
	{
		$this->cekLoginStatus("finance",true);

		$data['title'] = "Monitoring Ttb Diterima Oleh Penerima";
		$data['layout'] = "pengiriman/rekapditerimapenerima";

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

		list($data['data'],$total) = $this->pengiriman_model->getAllLaporanditerimapenerima($filter,0,0,"pg.id_surat_jalan","desc");

		if($action)
		{
			$this->export($action,$data['data'],$filter);
		}
		else
				$this->load->view('template',$data);

	}

	public function export($action,$data,$filter)
	{
		$this->cekLoginStatus("finance",true);

		$title = "Laporan Data Pengiriman Barang";
		$file_name = $title."_".date("Y-m-d");
		$headerTitle = $title;

		if(empty($data))
		{
			$this->session->set_flashdata('admin_save_error', "data tidak tersedia");
			redirect("pengiriman/rekap?from=".$filter->from."&to=".$filter->to."&status=".$filter->status."");
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
			$dat['SPB'] = $dt['id_surat_jalan'];
			$dat['Tanggal'] = date("d-m-Y",strtotime($dt['tanggal']));
			$dat['Np TTB'] = $dt['id_amplop'];
			$dat['Nama Pengirim'] = $dt['nama_pengirim'];
			$dat['Nama Penerima'] = $dt['nama_penerima'];
			$dat['Driver'] = $dt['nama_driver'];
			$status = "Order";
			if($dt['status'] == 2)
				$status = "Dikirim";
			else if($dt['status'] == 3)
				$status = "Diretur";
			else if($dt['status'] == 4)
				$status = "Diterima";

			$dat['Status'] = $status;

			$newdata[] = $dat;
		}


		return $newdata;
	}

}
