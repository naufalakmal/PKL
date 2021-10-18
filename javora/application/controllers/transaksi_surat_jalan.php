<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class transaksi_surat_jalan extends Admin_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model("transaksi_surat_jalan_model");
    }
	public function index()
	{
		$this->cekLoginStatus("staff gudang",true);

		$data['title'] = "PEMBUATAN SURAT JALAN";
		$data['layout'] = "transaksi_surat_jalan/index";

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if(!$page)
			$page = 1;

		$offset = ($page-1) * $limit;

		list($data['data'],$total) = $this->transaksi_surat_jalan_model->getAll($filter,$limit,$offset,$orderBy,$orderType);

		$this->load->library('pagination');
		$config['base_url'] = site_url("transaksi_surat_jalan?");
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

		$data['title'] = "FORM SURAT JALAN";
		$data['layout'] = "transaksi_surat_jalan/manage";

		$data['data'] = new StdClass();
		$data['data']->id_surat_jalan = "";
		$data['data']->tanggal = "";
		$data['data']->id = "";
		$data['data']->id_kategori = "";
		$data['data']->kategori = "";
		$data['data']->amplop = "";
		$data['data']->suratjalan = "";
		$data['data']->id_pool = "";
		$data['data']->pool = "";
		$data['data']->alamat = "";
		$data['data']->id_driver = "";
		$data['data']->driver = "";
		$data['data']->status = "";
		$data['data']->keterangan = "";
		$data['data']->penerimaan = "";
		$data['data']->no_po = "";
		$data['data']->no_kendaraan = "";
		$data['data']->nopol = "";
		$data['data']->autocode = $this->generate_code();

		if($id)
		{
			$dt =  $this->transaksi_surat_jalan_model->get_by("pg.id_surat_jalan",$id,true);
			if(!empty($dt))
				$data['data'] = $dt;
		}
		$this->load->model("master_kendaraan_model");
		list($data['kendaraan'],$total) = $this->master_kendaraan_model->getAll(null,null,null,null,null);
		//var_dump($data['kendaraan']);
		//exit();

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

			if(!empty($post['id_pool']))
				$data['id_pool'] = $post['id_pool'];
			else
				$error[] = "pool tidak boleh kosong";

			if(!empty($post['id_driver']))
				$data['id_driver'] = $post['id_driver'];
			else
				$error[] = "driver tidak boleh kosong";
			if(!empty($post['id_kendaraan']))
					$data['id_kendaraan'] = $post['id_kendaraan'];
			else
					$error[] = "kendaraan tidak boleh kosong";






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
					$cektransaksi_surat_jalan = $this->transaksi_surat_jalan_model->get_by("pg.id_surat_jalan",$post['id_surat_jalan']);
					if(!empty($cektransaksi_surat_jalan))
						$error[] = "id sudah terdaftar";
				}
			}

			if(empty($error))
			{
				$save = $this->transaksi_surat_jalan_model->save($id,$data,false);

				$datailkode = $post['detail']['id_amplop'];
				$datailpool = $post['detail']['id_pool'];
				$datailjumlah = $post['detail']['qty'];

				if(!empty($id))
				{
					$this->transaksi_surat_jalan_model->remove_detail($id);
				}

				foreach($datailkode as $key => $val)
				{

					if(empty($id))
						$detail['id_surat_jalan'] = $data['id_surat_jalan'];
					else
						$detail['id_surat_jalan'] = $id;

					$detail['id_amplop'] = $val;
					$detail['qty'] = $datailjumlah[$val];
					$detail['id_pool'] = $datailpool[$val];

					$this->transaksi_surat_jalan_model->save_detail($detail);
				}


				$this->session->set_flashdata('admin_save_success', "data berhasil disimpan");

				if($post['action'] == "save")
					redirect("transaksi_surat_jalan/manage/".$id);
				else
					redirect("transaksi_surat_jalan");
			}
			else
			{
				$err_string = "<ul>";
				foreach($error as $err)
					$err_string .= "<li>".$err."</li>";
				$err_string .= "</ul>";

				$this->session->set_flashdata('admin_save_error', $err_string);
				redirect("transaksi_surat_jalan/manage/".$id);
			}
		}
		else
		  redirect("transaksi_surat_jalan");
	}

	public function delete($id = "")
	{
		$this->cekLoginStatus("staff gudang",true);

		if(!empty($id))
		{
			$cek = $this->transaksi_surat_jalan_model->get_by("pg.id_surat_jalan",$id,true);
			if(empty($cek))
			{
				$this->session->set_flashdata('admin_save_error', "ID tidak terdaftar");
				redirect("transaksi_surat_jalan");
			}
			else
			{
				$this->transaksi_surat_jalan_model->remove($id);
				$this->session->set_flashdata('admin_save_success', "data berhasil dihapus");
				redirect("transaksi_surat_jalan");
			}
		}
		else
			redirect("transaksi_surat_jalan");
	}

	public function generate_code()
	{
		$prefix = "SPB" . date("Ymd");
		$code = "0001";

		$last = $this->transaksi_surat_jalan_model->get_last();

		if (!empty($last)) {
			$number = substr($last->id_surat_jalan, 14, 15) + 1;
			//var_dump($number);
			//exit();
			$code = str_pad($number, 4, "0", STR_PAD_LEFT);
		}
		return $prefix . $code;
	}

	public  function cetak($id)
	{
		$this->cekLoginStatus("staff gudang",true);

		$data['title'] = "CETAK SURAT JALAN";
		$data['layout'] = "transaksi_surat_jalan/cetak";

		$this->load->library("qrcodeci");
		if($id)
		{
			$dt =  $this->transaksi_surat_jalan_model->get_by("pg.id_surat_jalan",$id,true);

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
				redirect("transaksi_surat_jalan");
			}

		}
		else
		{
			redirect("transaksi_surat_jalan");
		}
	}

	public function rekap()
	{
		$this->cekLoginStatus("finance",true);

		$data['title'] = "Laporan transaksi_surat_jalan amplop";
		$data['layout'] = "transaksi_surat_jalan/rekap";

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

		list($data['data'],$total) = $this->transaksi_surat_jalan_model->getAll($filter,0,0,"pg.id_surat_jalan","desc");

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

		$title = "Laporan Data transaksi_surat_jalan amplop";
		$file_name = $title."_".date("Y-m-d");
		$headerTitle = $title;

		if(empty($data))
		{
			$this->session->set_flashdata('admin_save_error', "data tidak tersedia");
			redirect("transaksi_surat_jalan/rekap?from=".$filter->from."&to=".$filter->to."&status=".$filter->status."");
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
			$dat['ID transaksi_surat_jalan'] = $dt['id_surat_jalan'];
			$dat['Tanggal'] = date("d-m-Y",strtotime($dt['tanggal']));
			$dat['pool'] = $dt['pool'];
			$dat['No. PO'] = $dt['no_po'];
			$dat['driver'] = $dt['driver'];
			$dat['No. Kendaraan'] = $dt['no_kendaraan'];
			$dat['Penerima'] = $dt['penerima'];

			$status = "Dikirim";
			if($dt['status'] == 2)
				$status = "Diterima";
			else if($dt['status'] == 3)
				$status = "Ditolak";
			else if($dt['status'] == 4)
				$status = "Diterima sebagian";

			$dat['Status'] = $status;

			$newdata[] = $dat;
		}


		return $newdata;
	}

}
