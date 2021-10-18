<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("master_kendaraan_model");
		$this->load->model("master_driver_model");
		$this->load->model("transaksi_order_model");
		$this->load->model("transaksi_ttb_model");
		//$this->load->model("transaksi_pembayaran_amplop_model");
	
	}

	public function index()
	{
		$data['title'] = "DASHBOARD";
		$data['layout'] = "dashboard";
		$data['total_kendaraan'] = $this->master_kendaraan_model->hitungJumlahAsset();
		$data['total_driver'] = $this->master_driver_model->hitungJumlahAsset();
		$data['total_order'] = $this->transaksi_order_model->hitungJumlahOrder();
		$data['total_ttb'] = $this->transaksi_ttb_model->hitungJumlahTtb();
		$data['total_dikirim'] = $this->transaksi_ttb_model->hitungJumlahDikirim();
		//$data['total_kurir'] = $this->kurir_model->hitungJumlahAsset();
		//$data['total_pelanggan'] = $this->pelanggan_model->hitungJumlahAsset();
		//$data['total_pengiriman'] = $this->pengiriman_model->hitungJumlahAsset();


		$this->load->view('template', $data);
	}
}
