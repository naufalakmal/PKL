<?php
class Ajax extends Admin_Controller
{


	public function getTableKaryawan()
	{
		$this->load->model("master_karyawan_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));


		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;


		list($data['data'], $total) = $this->master_karyawan_model->getAll($filter, $limit, $offset, $orderBy, $orderType);

		$content = "<table class='table table-striped'>
						<thead>
						   <tr>
								<th>ID </th>
								<th>NIK </th>
								<th>NAMA</th>
								<th>ALAMAT</th>
								<th>HP</th>
								<th>Action</th>
							  </tr>
						</thead>
						<tbody>";

		if (sizeof($data['data']) == 0) {
			$content .= "<tr><td colspan='5'><h3>data tidak tersedia</h3></td></tr>";
		} else {
			foreach ($data['data'] as $dt) {

				$content .= "<tr>
								<td>" . $dt['id'] . "</td>
								<td>" . $dt['nik'] . "</td>
								<td>" . $dt['nama'] . "</td>
								<td>" . $dt['alamat'] . "</td>
								<td>" . $dt['hp'] . "</td>";

				$content .= "<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;" . $dt['nik'] . "&quot;,&quot;" . $dt['id'] . "&quot;,&quot;" . $dt['nama'] . "&quot;,&quot;" . $dt['hp'] . "&quot;,&quot;" . $dt['alamat'] . "&quot;)' data-dismiss='modal'>pilih</button></td>";


				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTableKaryawan?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content . ($this->pagination->create_links());
	}

	public function getTablemobil()
	{
		$this->load->model("mobil_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));
		$filter->mobil = $this->input->get('mobil');

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->mobil_model->getAll($filter, $limit, $offset, $orderBy, $orderType);
		$content = "<table class='table table-striped'>
						<thead>
						   <tr>
								<th>ID mobil</th>
								<th>NAMA</th>
								<th>WARNA</th>
								<th>NO POLISI</th>
								<th>Action</th>
							  </tr>
						</thead>
						<tbody>";

		if (sizeof($data['data']) == 0) {
			$content .= "<tr><td colspan='6'><h3>data tidak tersedia</h3></td></tr>";
		} else {
			foreach ($data['data'] as $dt) {

				$content .= "<tr>
								<td>" . $dt['id_mobil'] . "</td>
								<td>" . $dt['nama'] . "</td>
								<td>" . $dt['warna'] . "</td>
								<td>" . $dt['no_polisi'] . "</td>";

				$content .= "<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;" . $dt['id_mobil'] . "&quot;,&quot;" . $dt['nama'] . "&quot;,&quot;" . $dt['warna'] . "&quot;,&quot;" . $dt['no_polisi'] . "&quot;)' data-dismiss='modal'>pilih</button></td>";
				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$link = "";

		if ($total > $limit) {
			$link .= "<ul class='pagination'>";
			for ($i = 0; $i < $total / $limit; $i++) {
				if ($page == $i + 1)
					$link .= "<li class='active'><a>" . ($i + 1) . "</a></li>";
				else
					$link .= "<li><a href='#' onclick='getmobil(" . ($i + 1) . ")'>" . ($i + 1) . "</a></li>";
			}

			$link .= "</ul>";
		}

		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTablemobil?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content . ($this->pagination->create_links());
	}

	public function getTablePelanggan()
	{
		$this->load->model("master_pelanggan_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if(!$page)
			$page = 1;

		$offset = ($page-1) * $limit;


		list($data['data'],$total) = $this->master_pelanggan_model->getAll($filter,$limit,$offset,$orderBy,$orderType);
		$content = "<table class='table table-striped'>
						<thead>
						   <tr>
								<th>ID PELANGGAN</th>
								<th>NAMA</th>
								<th>ALAMAT</th>
								<th>TELEPON</th>
								<th>HUTANG</th>
								<th>Action</th>
							  </tr>
						</thead>
						<tbody>";

		if(sizeof($data['data']) == 0)
		{
			$content .= "<tr><td colspan='5'><h3>data tidak tersedia</h3></td></tr>";
		}
		else
		{
			foreach($data['data'] as $dt)
			{

				$content .= "<tr>
								<td>".$dt['id_pelanggan']."</td>
								<td>".$dt['nama']."</td>
								<td>".$dt['alamat']."</td>
								<td>".$dt['telepon']."</td>
								<td>".$dt['hutang']."</td>";

				$content .="<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;".$dt['id_pelanggan']."&quot;,&quot;".$dt['nama']."&quot;,&quot;".$dt['alamat']."&quot;,&quot;".$dt['telepon']."&quot;,&quot;".$dt['hutang']."&quot;)' data-dismiss='modal'>pilih</button></td>";


				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTablePelanggan?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content.($this->pagination->create_links());

	}

	public function getTablePembayaranAmplop()
	{
		$this->load->model("transaksi_pembayaran_amplop_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if(!$page)
			$page = 1;

		$offset = ($page-1) * $limit;


		list($data['data'],$total) = $this->transaksi_pembayaran_amplop_model->getAllLaporanPiutangPerPelanggan($filter,$limit,$offset,$orderBy,$orderType);
		$content = "<table class='table table-striped'>
						<thead>
						   <tr>
								<th>ID PELANGGAN</th>
								<th>NAMA</th>
								<th>TELEPON</th>
								<th>DEBET</th>
								<th>KREDIT</th>
								<th>Action</th>
							  </tr>
						</thead>
						<tbody>";

		if(sizeof($data['data']) == 0)
		{
			$content .= "<tr><td colspan='5'><h3>data tidak tersedia</h3></td></tr>";
		}
		else
		{
			foreach($data['data'] as $dt)
			{

				$content .= "<tr>

								<td>".$dt['id_pelanggan']."</td>
								<td>".$dt['nama']."</td>
								<td>".$dt['telepon']."</td>
								<td>".$dt['jumlah_hutang']."</td>
								<td>".$dt['jumlah_sudah_bayar']."</td>";


				$content .="<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;".$dt['id_pelanggan']."&quot;,&quot;".$dt['id_pelanggan']."&quot;,&quot;".$dt['nama']."&quot;,&quot;".$dt['telepon']."&quot;,&quot;".$dt['jumlah_hutang']."&quot;,&quot;".$dt['jumlah_sudah_bayar']."&quot;,&quot;".$dt['jumlah_sisa_piutang']."&quot;)' data-dismiss='modal'>pilih</button></td>";


				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTablePelanggan?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content.($this->pagination->create_links());

	}

	public function getTabletujuan()
	{
		$this->load->model("master_tujuan_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;


		list($data['data'], $total) = $this->master_tujuan_model->getAll($filter, $limit, $offset, $orderBy, $orderType);
		$content = "<table class='table table-striped'>
						<thead>
						   <tr>
								<th>ID</th>
								<th>NAMA</th>
								<th>TARIF</th>
								<th>TELEPON</th>
								<th>JENIS TUJUAN</th>
								<th>Action</th>
							  </tr>
						</thead>
						<tbody>";

		if (sizeof($data['data']) == 0) {
			$content .= "<tr><td colspan='5'><h3>data tidak tersedia</h3></td></tr>";
		} else {
			foreach ($data['data'] as $dt) {

				$content .= "<tr>
								<td>" . $dt['id_tujuan'] . "</td>
								<td>" . $dt['nama_tujuan'] . "</td>
								<td>" . $dt['tarif'] . "</td>
								<td>" . $dt['telepon_tujuan'] . "</td>
								<td>" . $dt['jenis_tujuan'] . "</td>";

				$content .= "<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;" . $dt['id_tujuan'] . "&quot;,&quot;" . $dt['nama_tujuan'] . "&quot;,&quot;" . $dt['tarif'] . "&quot;,&quot;" . $dt['telepon_tujuan'] . "&quot;,&quot;" . $dt['jenis_tujuan'] . "&quot;)' data-dismiss='modal'>pilih</button></td>";


				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTablepool?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content . ($this->pagination->create_links());
	}

	public function getTableViapool()
	{
		$this->load->model("master_tujuan_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;


		list($data['data'], $total) = $this->master_tujuan_model->getAllViapool($filter, $limit, $offset, $orderBy, $orderType);
		$content = "<table class='table table-striped'>
						<thead>
						   <tr>
								<th>ID</th>
								<th>NAMA</th>

								<th>Action</th>
							  </tr>
						</thead>
						<tbody>";

		if (sizeof($data['data']) == 0) {
			$content .= "<tr><td colspan='5'><h3>data tidak tersedia</h3></td></tr>";
		} else {
			foreach ($data['data'] as $dt) {

				$content .= "<tr>
								<td>" . $dt['id_tujuan'] . "</td>
								<td>" . $dt['nama_tujuan'] . "</td>";

				$content .= "<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;" . $dt['id_tujuan'] . "&quot;,&quot;" . $dt['nama_tujuan'] . "&quot;)' data-dismiss='modal'>pilih</button></td>";


				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTablepool?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content . ($this->pagination->create_links());
	}

	public function getTablepool()
	{
		$this->load->model("master_pool_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;


		list($data['data'], $total) = $this->master_pool_model->getAll($filter, $limit, $offset, $orderBy, $orderType);
		$content = "<table class='table table-striped'>
						<thead>
						   <tr>
								<th>ID pool</th>
								<th>NAMA</th>
								<th>ALAMAT</th>
								<th>TELEPON</th>
								<th>HARGA PER KG</th>
								<th>Action</th>
							  </tr>
						</thead>
						<tbody>";

		if (sizeof($data['data']) == 0) {
			$content .= "<tr><td colspan='5'><h3>data tidak tersedia</h3></td></tr>";
		} else {
			foreach ($data['data'] as $dt) {

				$content .= "<tr>
								<td>" . $dt['id_pool'] . "</td>
								<td>" . $dt['nama_pool'] . "</td>
								<td>" . $dt['telepon_pool'] . "</td>
								<td>" . $dt['alamat_pool'] . "</td>
								<td>" . $dt['hargakg'] . "</td>";

				$content .= "<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;" . $dt['id_pool'] . "&quot;,&quot;" . $dt['nama_pool'] . "&quot;,&quot;" . $dt['telepon_pool'] . "&quot;,&quot;" . $dt['alamat_pool'] . "&quot;,&quot;" . $dt['hargakg'] . "&quot;)' data-dismiss='modal'>pilih</button></td>";


				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTablepool?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content . ($this->pagination->create_links());
	}

	public function getTabletarif()
	{
		$this->load->model("master_tarif_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;


		list($data['data'], $total) = $this->master_tarif_model->getAll($filter, $limit, $offset, $orderBy, $orderType);
		$content = "<table class='table table-striped'>
						<thead>
						   <tr>
								<th>ID TARIF</th>
								<th>KECAMATAN</th>
								<th>KABUPATEN</th>
								<th>PROVINSI</th>
								<th>TARIF</th>
								<th>Action</th>
							  </tr>
						</thead>
						<tbody>";

		if (sizeof($data['data']) == 0) {
			$content .= "<tr><td colspan='5'><h3>data tidak tersedia</h3></td></tr>";
		} else {
			foreach ($data['data'] as $dt) {

				$content .= "<tr>
								<td>" . $dt['id_tarif'] . "</td>
								<td>" . $dt['nama_kecamatan_tujuan'] . "</td>
								<td>" . $dt['nama_kota'] . "</td>
								<td>" . $dt['nama_provinsi'] . "</td>
								<td>" . $dt['harga_tarif'] . "</td>";

				$content .= "<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;" . $dt['id_tarif'] . "&quot;,&quot;" . $dt['nama_kecamatan_tujuan'] . "&quot;,&quot;" . $dt['nama_kota'] . "&quot;,&quot;" . $dt['nama_provinsi'] . "&quot;,&quot;" . $dt['harga_tarif'] . "&quot;)' data-dismiss='modal'>pilih</button></td>";


				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTablepool?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content . ($this->pagination->create_links());
	}

	public function getTabledriver()
	{
		$this->load->model("master_driver_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;


		list($data['data'], $total) = $this->master_driver_model->getAll($filter, $limit, $offset, $orderBy, $orderType);
		$content = "<table class='table table-striped'>
						<thead>
						   <tr>
								<th>ID DRIVER</th>
								<th>NIK</th>
								<th>NAMA</th>
								<th>ALAMAT</th>
								<th>Action</th>
							  </tr>
						</thead>
						<tbody>";

		if (sizeof($data['data']) == 0) {
			$content .= "<tr><td colspan='6'><h3>data tidak tersedia</h3></td></tr>";
		} else {
			foreach ($data['data'] as $dt) {

				$content .= "<tr>
								<td>" . $dt['id'] . "</td>
								<td>" . $dt['nama'] . "</td>
								<td>" . $dt['nik'] . "</td>
								<td>" . $dt['alamat'] . "</td>";


				$content .= "<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;" . $dt['id'] . "&quot;,&quot;" . $dt['nama'] . "&quot;,&quot;" . $dt['nik'] . "&quot;)' data-dismiss='modal'>pilih</button></td>";


				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$link = "";


		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTableDriver?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content . ($this->pagination->create_links());
	}

	public function getTablebarangamplop()
	{
		$this->load->model("transaksi_ttb_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));
		$filter->barang = $this->input->get('barang');


		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->transaksi_ttb_model->getAllttb($filter, $limit, $offset, $orderBy, $orderType);
		$content = "<table class='table table-striped'>
		<thead>
			 <tr>
				<th>NO TTB</th>
				<th>NAMA PENGIRIM</th>
				<th>NAMA PENERIMA</th>
				<th>TUJUAN</th>
				<th>QTY</th>
				<th>SAT</th>
				<th>Action</th>
				</tr>
		</thead>
		<tbody>";

		if (sizeof($data['data']) == 0) {
			$content .= "<tr><td colspan='6'><h3>data tidak tersedia</h3></td></tr>";
		} else {
			foreach ($data['data'] as $dt) {

				$content .= "<tr>
								<td>" . $dt['id_amplop'] . "</td>
								<td>" . $dt['nama_pengirim'] . "</td>
								<td>" . $dt['nama_penerima'] . "</td>
								<td>" . $dt['tujuan'] . "</td>
								<td>" . $dt['berat_amplop'] . "</td>
								<td>" . $dt['satuan'] . "</td>";

				$content .= "<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;" . $dt['id_amplop'] . "&quot;,&quot;" . $dt['nama_pengirim'] . "&quot;,&quot;" . $dt['nama_penerima'] . "&quot;,&quot;" . $dt['berat_amplop'] ."&quot;,&quot;" . $dt['satuan'] . "&quot;,&quot;"  . $dt['tujuan'] . "&quot;)' data-dismiss='modal'>pilih</button></td>";

				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$link = "";

		if ($total > $limit) {
			$link .= "<ul class='pagination'>";
			for ($i = 0; $i < $total / $limit; $i++) {
				if ($page == $i + 1)
					$link .= "<li class='active'><a>" . ($i + 1) . "</a></li>";
				else
					$link .= "<li><a href='#' onclick='getmobil(" . ($i + 1) . ")'>" . ($i + 1) . "</a></li>";
			}

			$link .= "</ul>";
		}

		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTablemobil?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content . ($this->pagination->create_links());
	}

	public function getTablebarang()
	{
		$this->load->model("transaksi_amplop_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));
		$filter->barang = $this->input->get('barang');


		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->transaksi_amplop_model->getAllamplop($filter, $limit, $offset, $orderBy, $orderType);
		$content = "<table class='table table-striped'>
						<thead>
						   <tr>
								<th>ID AMPLOP</th>
								<th>NAMA PENGIRIM </th>
								<th>NAMA PENERIMA</th>
								<th>QTY</th>
								<th>SATUAN</th>
								<th>Action</th>
							  </tr>
						</thead>
						<tbody>";

		if (sizeof($data['data']) == 0) {
			$content .= "<tr><td colspan='6'><h3>data tidak tersedia</h3></td></tr>";
		} else {
			foreach ($data['data'] as $dt) {

				$content .= "<tr>
								<td>" . $dt['id_amplop'] . "</td>
								<td>" . $dt['nama_pengirim'] . "</td>
								<td>" . $dt['nama_penerima'] . "</td>
								<td>" . $dt['berat_amplop'] . "</td>
								<td>" . $dt['satuan'] . "</td>";

				$content .= "<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;" . $dt['id_amplop'] . "&quot;,&quot;" . $dt['nama_pengirim'] . "&quot;,&quot;" . $dt['nama_penerima'] . "&quot;,&quot;" . $dt['satuan'] . "&quot;)' data-dismiss='modal'>pilih</button></td>";
				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$link = "";

		if ($total > $limit) {
			$link .= "<ul class='pagination'>";
			for ($i = 0; $i < $total / $limit; $i++) {
				if ($page == $i + 1)
					$link .= "<li class='active'><a>" . ($i + 1) . "</a></li>";
				else
					$link .= "<li><a href='#' onclick='getmobil(" . ($i + 1) . ")'>" . ($i + 1) . "</a></li>";
			}

			$link .= "</ul>";
		}

		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTablemobil?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content . ($this->pagination->create_links());
	}

	public function getTableamplop()
	{
		$this->load->model("transaksi_amplop_model");

		$filter = new StdClass();
		$filter->keyword = trim($this->input->get('keyword'));
		$filter->barang = $this->input->get('transaksi_amplop');

		$orderBy = $this->input->get('orderBy');
		$orderType = $this->input->get('orderType');
		$page = $this->input->get('page');

		$limit = 10;
		if (!$page)
			$page = 1;

		$offset = ($page - 1) * $limit;

		list($data['data'], $total) = $this->transaksi_amplop_model->getAll($filter, $limit, $offset, $orderBy, $orderType);
		$content = "<table class='table table-striped'>
						<thead>
						   <tr>
								<th>NO TTB</th>
								<th>NAMA PENGIRIM</th>
								<th>NAMA PENERIMA</th>
								<th>KECAMATAN, KOTA, PROVINSI</th>
								<th>QTY</th>
								<th>SAT</th>
								<th>Action</th>
							  </tr>
						</thead>
						<tbody>";

		if (sizeof($data['data']) == 0) {
			$content .= "<tr><td colspan='9'><h3>data tidak tersedia</h3></td></tr>";
		} else {
			foreach ($data['data'] as $dt) {

				$content .= "<tr>
								<td>" . $dt['id_amplop'] . "</td>
								<td>" . $dt['nama_pengirim'] . "</td>
								<td>" . $dt['nama_penerima'] . "</td>
								<td>" . $dt['address'] . "</td>
								<td>" . $dt['berat_amplop'] . "</td>
								<td>" . $dt['satuan'] . "</td>";

				$content .= "<td><button type='button' class='btn btn-success btn-sm' href='#' onClick='pilih(&quot;" . $dt['id_amplop'] . "&quot;,&quot;" . $dt['nama_pengirim'] . "&quot;,&quot;" . $dt['nama_penerima'] . "&quot;,&quot;" . $dt['berat_amplop'] . "&quot;,&quot;"  . $dt['satuan'] . "&quot;)' data-dismiss='modal'>pilih</button></td>";
				$content  .= "</tr>";
			}
		}

		$content .= "</tbody></table>";

		$link = "";

		if ($total > $limit) {
			$link .= "<ul class='pagination'>";
			for ($i = 0; $i < $total / $limit; $i++) {
				if ($page == $i + 1)
					$link .= "<li class='active'><a>" . ($i + 1) . "</a></li>";
				else
					$link .= "<li><a href='#' onclick='getmobil(" . ($i + 1) . ")'>" . ($i + 1) . "</a></li>";
			}

			$link .= "</ul>";
		}

		$this->load->library('pagination');
		$config['base_url'] = site_url("ajax/getTablemobil?");
		$config['total_rows'] = $total;
		$config['per_page'] = $limit;
		$config['query_string_segment'] = 'page';
		$config['use_page_numbers']  = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		echo $content . ($this->pagination->create_links());
	}
}
