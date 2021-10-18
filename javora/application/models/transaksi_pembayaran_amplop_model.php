<?php
class Transaksi_pembayaran_amplop_Model extends CI_Model
{
	var $table  = 'transaksi_pembayaran_amplop';
	var $table1  = 'daftar_piutang';
	var $view  = 'v_pembayaran_amplop';
	var $key  = 'no_bayar_amplop';
	var $key1  = 'id_amplop';
	var $key2  = 'id_pelanggan';
	function __construct()
    {
        parent::__construct();
    }

		function getAllpembayaran_amplop($filter = null, $limit = 20, $offset = 0, $orderBy, $orderType)
		{
			$where = "";
			$cond[] = "(pg.status = '" . 1 . "')";
			$cond = array();

			if (isset($filter)) {
				if (!empty($filter->keyword)) {
					$cond[] = "(lower(" . $this->key . ") like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(id_amplop) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(tanggal) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(nama_pengirim) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(c.nama_tujuan) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(nama_penerima) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(alamat_penerima) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(ongkos_bersih) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(jenis_kirim) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(kecamatan) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(provinsi) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									)";
				}

				if (!empty($filter->barang)) {
					$cond[] = "lower(b.id_amplop) not in ('" . implode($filter->barang, "', '") . "')";
				}


				if (!empty($cond))
					$where = " where " . implode(" and ", $cond);
			}

			$limitOffset = "LIMIT $offset,$limit";
			if ($limit == 0)
				$limitOffset = "";

			if (!$orderBy)
				$orderBy = $this->key;

			if (!$orderType)
				$orderType = "asc";

			$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS b.*,CONCAT( c.id_tujuan,',', c.nama_tujuan  ) AS  tujuan
									   FROM " . $this->view . " b
										 LEFT JOIN master_tujuan c on c.id_tujuan = b.id_tujuan

									   $where ORDER BY $orderBy $orderType $limitOffset
									   ");

			$result = $query->result_array();
			$query->free_result();

			$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

			return array($result, $total);
		}

		function getAllDaftarPiutang($filter = null,$limit = 20,$offset = 0, $orderBy, $orderType)
		{
			$where = "";
			$cond = array();
		  	if (isset($filter))
		  	{
				if (!empty($filter->keyword))
				{
					  $cond[] = "(lower(".$this->key.") like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(p.alamat) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(b.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(k.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(pg.status) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(p.id_pelanggan) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(p.alamat) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(kk.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(kk.id_kurir) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(k.id_kategori) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									)";
				}

				if (!empty($filter->status))
				{
					if(strtolower($filter->status) != "all")
						$cond[] = "(pg.status = '" . $this->db->escape_str(strtolower($filter->status)) . "')";
				}

				if (!empty($filter->from) || !empty($filter->to))
				{
					$cond[] = "(pg.tgl_transaksi >= '" . $this->db->escape_str($filter->from) . "' and pg.tgl_transaksi <= '" . $this->db->escape_str($filter->to) . "' )";
				}

				if(!empty($cond))
					$where = " where ". implode(" and ", $cond);
		  	}

			$limitOffset = "LIMIT $offset,$limit";
			if($limit == 0)
				$limitOffset = "";

			if(!$orderBy)
				$orderBy = $this->key1;

			if(!$orderType)
				$orderType = "asc";

			$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*

									   FROM v_daftar_piutang pg
									   $where group by pg.id_amplop ORDER BY $orderBy $orderType $limitOffset
									   ");

			$result = $query->result_array();
			$query->free_result();

			$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

			return array($result,$total);
		}
		function getAllLaporanPiutang($filter = null,$limit = 20,$offset = 0, $orderBy, $orderType)
		{
			$where = "";
			$cond = array();
		  	if (isset($filter))
		  	{
				if (!empty($filter->keyword))
				{
					  $cond[] = "(lower(".$this->key.") like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(p.alamat) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(b.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(k.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(pg.status) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(p.id_pelanggan) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(p.alamat) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(kk.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(kk.id_kurir) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(k.id_kategori) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									)";
				}

				if (!empty($filter->status))
				{
					if(strtolower($filter->status) != "all")
						$cond[] = "(pg.status = '" . $this->db->escape_str(strtolower($filter->status)) . "')";
				}

				if (!empty($filter->from) || !empty($filter->to))
				{
					$cond[] = "(pg.tgl_transaksi >= '" . $this->db->escape_str($filter->from) . "' and pg.tgl_transaksi <= '" . $this->db->escape_str($filter->to) . "' )";
				}

				if(!empty($cond))
					$where = " where ". implode(" and ", $cond);
		  	}

			$limitOffset = "LIMIT $offset,$limit";
			if($limit == 0)
				$limitOffset = "";

			if(!$orderBy)
				$orderBy = $this->key1;

			if(!$orderType)
				$orderType = "asc";

			$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*

									   FROM daftar_piutang pg




									   $where group by pg.id_amplop ORDER BY $orderBy $orderType $limitOffset
									   ");

			$result = $query->result_array();
			$query->free_result();

			$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

			return array($result,$total);
		}

		function getAllLaporanPiutangPerPelanggan($filter = null,$limit = 20,$offset = 0, $orderBy, $orderType)
		{
			$where = "";
			$cond = array();
		  	if (isset($filter))
		  	{
				if (!empty($filter->keyword))
				{
					  $cond[] = "(lower(".'p.nama'.") like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(p.alamat) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
									 or lower(p.id_pelanggan) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'

									)";
				}

				if (!empty($filter->status))
				{
					if(strtolower($filter->status) != "all")
						$cond[] = "(pg.status = '" . $this->db->escape_str(strtolower($filter->status)) . "')";
				}

				if (!empty($filter->from) || !empty($filter->to))
				{
					$cond[] = "(pg.tgl_transaksi >= '" . $this->db->escape_str($filter->from) . "' and pg.tgl_transaksi <= '" . $this->db->escape_str($filter->to) . "' )";
				}

				if(!empty($cond))
					$where = " where ". implode(" and ", $cond);
		  	}

			$limitOffset = "LIMIT $offset,$limit";
			if($limit == 0)
				$limitOffset = "";

			if(!$orderBy)
				$orderBy = 'pg.id_pelanggan';

			if(!$orderType)
				$orderType = "asc";

				$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*,p.*,sum(pg.debit) as jumlah_hutang,sum(pg.kredit) as jumlah_sudah_bayar,(sum(pg.debit) -sum(pg.kredit)) as jumlah_sisa_piutang

										   FROM rekening_laporan_piutang pg
											 LEFT JOIN master_pelanggan p on p.id_pelanggan = pg.id_pelanggan

										   $where group by pg.id_pelanggan ORDER BY $orderBy $orderType $limitOffset
										   ");

			$result = $query->result_array();
			$query->free_result();

			$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

			return array($result,$total);
		}


	function getAll($filter = null,$limit = 20,$offset = 0, $orderBy, $orderType)
	{
		$where = "";
		$cond = array();
	  	if (isset($filter))
	  	{
			if (!empty($filter->keyword))
			{
				  $cond[] = "(lower(".$this->key.") like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(p.alamat) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(b.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(k.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(pg.status) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(p.id_pelanggan) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(p.alamat) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(kk.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(kk.id_kurir) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(k.id_kategori) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								)";
			}

			if (!empty($filter->status))
			{
				if(strtolower($filter->status) != "all")
					$cond[] = "(pg.status = '" . $this->db->escape_str(strtolower($filter->status)) . "')";
			}

			if (!empty($filter->from) || !empty($filter->to))
			{
				$cond[] = "(pg.tanggal >= '" . $this->db->escape_str($filter->from) . "' and pg.tanggal <= '" . $this->db->escape_str($filter->to) . "' )";
			}

			if(!empty($cond))
				$where = " where ". implode(" and ", $cond);
	  	}

		$limitOffset = "LIMIT $offset,$limit";
		if($limit == 0)
			$limitOffset = "";

		if(!$orderBy)
			$orderBy = $this->key;

		if(!$orderType)
			$orderType = "asc";

		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*,p.nama pelanggan,p.alamat

								   FROM ".$this->table." pg



								   LEFT JOIN master_pelanggan p on p.id_pelanggan = pg.id_pelanggan
								   $where ORDER BY $orderBy $orderType $limitOffset
								   ");

		$result = $query->result_array();
		$query->free_result();

		$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

		return array($result,$total);
	}

	public function get_by($field, $value = "",$obj = false)
	{
		if(!$field)
		$field = $this->key;

		$where = "WHERE $field = '".$this->db->escape_str(strtolower($value))."'";
		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*

								   FROM ".$this->table." pg

								   $where group by pg.no_bayar_amplop
								   ");

		if(!$obj)
			$result = $query->result_array();
		else
			$result = $query->row();

		$query->free_result();

		return $result;
	}

	function getAllLaporanPiutangDetailPerPelanggan($id)
	{
		//var_dump($id);
		//exit();

		//if (!is_array($id))
			//$id = array($id);

		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*
									 FROM transaksi_ttb pg
									 LEFT JOIN master_pelanggan p on p.id_pelanggan = pg.id_pelanggan

									 where pg.id_pelanggan='" .$id. "'
									 ");

		$result = $query->result_array();
		$query->free_result();
		$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;
		return array($result,$total);
	}

	function remove($id)
    {
      if (!is_array($id))
		    $id = array($id);

		$this->db->where_in($this->key, $id)->delete($this->table);
    }
	function ubah_piutang($id_amplop,$data_ubah_daftar_piutang = array())
		{
			$this->db->where($this->key1, $id_amplop);
			$this->db->update($this->table1, $data_ubah_daftar_piutang);
			return $this->db->affected_rows();
		}

	function save($id = "",$data = array(), $insert_id = false)
	{

		if (!empty($id))
		{
			$this->db->where($this->key, $id);
			$this->db->update($this->table, $data);
		}
		else
		{
			$this->db->insert($this->table, $data);
		}

		return $this->db->affected_rows();
	}

	public function get_last()
	{
		$query = $this->db->query("SELECT  * FROM ".$this->table." order by ".$this->key." desc limit 0,1");
		$result = $query->row();
		$query->free_result();

		return $result;
	}

	function save_rekening_piutang($data = array())
	{
		$this->db->insert("rekening_laporan_piutang", $data);
		return $this->db->affected_rows();
	}
	function update_hutang_pelanggan($pelanggan,$data = array())
		{

			$this->db->where('id_pelanggan', $pelanggan);
			$this->db->update('master_pelanggan', $data);
			return $this->db->affected_rows();
		}






}
