<?php
class Lokasi_driver_Model extends CI_Model
{
	var $table  = 'transaksi_surat_jalan';
	var $key  = 'id_surat_jalan';
	var $table1  = 'transaksi_ttb';
	var $key1  = 'id_amplop';
	function __construct()
    {
        parent::__construct();
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
								 or lower(b.id_barang) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(p.nama_tujuan) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(b.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(k.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(pg.status) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(p.id_pelanggan) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(p.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(kk.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(kk.id_driver) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
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

			$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*,kr.id kurir,b.nama_pengirim,b.id_amplop,p.nama_tujuan tujuan,p.alamat_tujuan,kd.nopol,CONCAT( kd.nopol,'|', kd.nopol ) AS  driver_truk
											,group_concat(concat(dp.id_amplop,'|',b.nama_pengirim,'|',b.nama_penerima,'|',b.berat_amplop,'|',b.satuan,'|',b.berat_amplop)   order by b.id_amplop SEPARATOR '===')  as amplop
											FROM ".$this->table." pg
											LEFT JOIN transaksi_surat_jalan_detail dp on dp.id_surat_jalan = dp.id_surat_jalan
											LEFT JOIN transaksi_ttb b on b.id_amplop = dp.id_amplop
											LEFT JOIN master_kendaraan kd on kd.id = pg.id_kendaraan
											LEFT JOIN master_driver kr on kr.id = pg.id_driver
											LEFT JOIN master_tujuan p on p.id_tujuan = b.id_tujuan
															$where group by pg.id_surat_jalan ORDER BY $orderBy $orderType $limitOffset
															");

		$result = $query->result_array();
		$query->free_result();

		$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

		return array($result,$total);
	}

	public function getLokasi()
	{
		$query = "SELECT MAX(id) as id FROM riwayat GROUP BY id_lokasi ORDER BY waktu DESC";
		$id = mysqli_query($this->link->conn,$query);
		$all_id = '';
		$i = 0;
		foreach ($id as $value) {
			if ($i == 0)
				$all_id .= "'";
			$all_id .= $value['id'];
			if ($i != ($id->num_rows-1))
				$all_id .= "','";
			else
				$all_id .="'";
			$i++;
		}
		// echo $all_id;die;
		$query = "SELECT `riwayat`.*, merk,plat_nomor,pengguna, latitude, longitude, batas, nama_lokasi FROM `kendaraan`,`lokasi`,`riwayat` WHERE `lokasi`.id_kendaraan = `kendaraan`.id AND `lokasi`.id = `riwayat`.id_lokasi AND `riwayat`.id IN ($all_id)";
		$lokasi = mysqli_query($this->link->conn,$query);
		$all_lokasi = array();
		$idx = 0;
		foreach ($lokasi as $value) {
			if ($value['status'] == 'Di Izinkan')
				$color = 'blue';
			else
				$color = 'red';
			$all_lokasi[$idx][0] = '<table><tbody><tr><td colspan="3"><p style="text-align: center;"><h4><strong><center>Lokasi Terkini</center></strong></h4></p><p style="text-align: center;"><span>Status :</spa> <span class="badge" style="background-color: '.$color.';color:white;">'.$value['status'].'</span> <a href="#"> Detail</a></p></td></tr><tr><td width="100px">Pengguna</td><td>:</td><td width="200px">'.$value['pengguna'].'</td></tr><tr><td>Motor</td><td width="10px">:</td><td>'.$value['merk'].' ('.$value['plat_nomor'].')'.'</td></tr><tr><td>Lokasi Batas</td><td>:</td><td>'.$value['nama_lokasi'].'</td></tr><tr><td>Radius</td><td>:</td><td>'.$value['batas'].' Km</td></tr><tr><td>Lokasi Terkini</td><td>:</td><td>Janti</td></tr><tr><td>Jarak</td><td>:</td><td>'.$value['jarak_now'].' Km</td></tr></tbody></table>';
			$all_lokasi[$idx][1] = $value['latitude_now'];
			$all_lokasi[$idx][2] = $value['longitude_now'];
			$idx++;
		}
		return $all_lokasi;
	}

	function getAllLaporan($filter = null,$limit = 20,$offset = 0, $orderBy, $orderType)
	{
		$where = "";

		$cond = array();
	  	if (isset($filter))
	  	{


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

			$query = $this->db->query("SELECT * from v_spb pg

															$where ORDER BY $orderBy $orderType $limitOffset
															");

		$result = $query->result_array();
		$query->free_result();

		$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

		return array($result,$total);
	}

	function getAllLaporanbooking($filter = null,$limit = 20,$offset = 0, $orderBy, $orderType)
	{
		$where = "";

		$cond = array();

	  	if (isset($filter))
	  	{


			if (!empty($filter->status))
			{

					$cond[] = "(pg.status = '0')";
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

			$query = $this->db->query("SELECT * from v_spb pg

															$where ORDER BY $orderBy $orderType $limitOffset
															");

		$result = $query->result_array();
		$query->free_result();

		$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

		return array($result,$total);
	}

	function getAllLaporanditerimastb($filter = null,$limit = 20,$offset = 0, $orderBy, $orderType)
	{
		$where = "";

		$cond = array();

	  	if (isset($filter))
	  	{


			if (!empty($filter->status))
			{

					$cond[] = "(pg.status = '1')";
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

			$query = $this->db->query("SELECT * from v_spb pg

															$where ORDER BY $orderBy $orderType $limitOffset
															");

		$result = $query->result_array();
		$query->free_result();

		$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

		return array($result,$total);
	}

	function getAllLaporandikirim($filter = null,$limit = 20,$offset = 0, $orderBy, $orderType)
	{
		$where = "";

		$cond = array();

	  	if (isset($filter))
	  	{


			if (!empty($filter->status))
			{

					$cond[] = "(pg.status = '2')";
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

			$query = $this->db->query("SELECT * from v_spb pg

															$where ORDER BY $orderBy $orderType $limitOffset
															");

		$result = $query->result_array();
		$query->free_result();

		$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

		return array($result,$total);
	}

	function getAllLaporanretur($filter = null,$limit = 20,$offset = 0, $orderBy, $orderType)
	{
		$where = "";

		$cond = array();

	  	if (isset($filter))
	  	{


			if (!empty($filter->status))
			{

					$cond[] = "(pg.status = '4')";
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

			$query = $this->db->query("SELECT * from v_spb pg

															$where ORDER BY $orderBy $orderType $limitOffset
															");

		$result = $query->result_array();
		$query->free_result();

		$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

		return array($result,$total);
	}

	function getAllLaporanditerimapenerima($filter = null,$limit = 20,$offset = 0, $orderBy, $orderType)
	{
		$where = "";

		$cond = array();

	  	if (isset($filter))
	  	{


			if (!empty($filter->status))
			{

					$cond[] = "(pg.status = '3')";
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

			$query = $this->db->query("SELECT * from v_spb pg

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
		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*,kr.id kurir,b.nama_pengirim,p.nama_tujuan tujuan,p.alamat_tujuan,kd.nopol,CONCAT( kd.nopol,'|', kd.nopol ) AS  driver_truk
										,group_concat(concat(dp.id_amplop,'|',b.nama_pengirim,'|',b.nama_penerima,'|',b.berat_amplop,'|',b.satuan,'|',p.nama_tujuan)   order by b.id_amplop SEPARATOR '===')  as amplop
										FROM ".$this->table." pg
										LEFT JOIN transaksi_surat_jalan_detail dp on dp.id_surat_jalan = pg.id_surat_jalan
										LEFT JOIN transaksi_ttb b on b.id_amplop = dp.id_amplop
										LEFT JOIN master_kendaraan kd on kd.id = pg.id_kendaraan
										LEFT JOIN master_driver kr on kr.id = pg.id_driver
										LEFT JOIN master_tujuan p on p.id_tujuan = b.id_tujuan
								   $where group by pg.id_surat_jalan
								   ");

		if(!$obj)
			$result = $query->result_array();
		else
			$result = $query->row();

		$query->free_result();

		return $result;
	}

	public function get_by_ttb()
	{
		$where = "";

		$cond = array();

	  	if (isset($filter))
	  	{


			if (!empty($filter->status))
			{

					$cond[] = "(pg.status = '3')";
			}

			if (!empty($filter->from) || !empty($filter->to))
			{
				$cond[] = "(pg.tanggal >= '" . $this->db->escape_str($filter->from) . "' and pg.tanggal <= '" . $this->db->escape_str($filter->to) . "' )";
			}

			if(!empty($cond))
				$where = " where ". implode(" and ", $cond);
	  	}





			$query = $this->db->query("SELECT id_amplop from transaksi_surat_jalan_detail

															$where
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
		$this->db->where_in($this->key, $id)->delete("transaksi_surat_jalan_detail");
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

	function remove_detail($id)
    {
      if (!is_array($id))
		    $id = array($id);

		$this->db->where_in($this->key, $id)->delete("transaksi_surat_jalan_detail");
    }

	function save_detail($data = array())
	{
		$this->db->insert("transaksi_surat_jalan_detail", $data);
		return $this->db->affected_rows();
	}

	function save_history($data = array())
	{
		$this->db->insert("transaksi_ttb_history", $data);
		return $this->db->affected_rows();
	}

	function update_detail($id)
    {
      if (!is_array($id))
		    $id = array($id);

				$this->db->where($this->key1, $id);
				$this->db->update($this->table1, $data);
    }
	public function amplop_detail_update_process_db($data, $where)
	  {
	    $this->db->where($where);
	    $this->db->update('transaksi_ttb', $data);
	  }
}
