<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lokasi extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model("lokasi_model");

	}

	public function index()
	{
		$data['title'] = "lokasi";
		$data['layout'] = "lokasi/index";
		$this->cekLoginStatus("staff gudang", true);



		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 15;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->lokasi_model->getAll($filter, $limit, $offset, $orderBy, $orderType);
		//var_dump($data['data']);
		//exit();

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
}
