<?php
class transaksi_surat_jalan_Model extends CI_Model
{
	var $table  = 'transaksi_surat_jalan';
	var $key  = 'id_surat_jalan';
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
								 or lower(b.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(k.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(pg.status) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(p.id_pool) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(p.nama) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
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

			$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*,kr.id kurir,b.nama_pengirim,p.nama_pool pool,p.alamat_pool,kd.nopol,CONCAT( kd.nopol,'|', kd.nopol ) AS  driver_truk
											,group_concat(concat(dp.id_amplop,'|',b.nama_pengirim,'|',b.nama_penerima,'|',b.berat_amplop,'|',b.satuan,'|',dp.qty)   order by b.id_amplop SEPARATOR '===')  as amplop
											FROM ".$this->table." pg
											LEFT JOIN transaksi_surat_jalan_detail dp on dp.id_surat_jalan = dp.id_surat_jalan
											LEFT JOIN transaksi_amplop b on b.id_amplop = dp.id_amplop
											LEFT JOIN master_kendaraan kd on kd.id = pg.id_kendaraan
											LEFT JOIN master_driver kr on kr.id = pg.id_driver
											LEFT JOIN master_pool p on p.id_pool = pg.id_pool
								   						$where group by pg.id_surat_jalan ORDER BY $orderBy $orderType $limitOffset
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
		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*,kr.id kurir,b.nama_pengirim,p.nama_pool pool,p.alamat_pool,kd.nopol,CONCAT( kd.nopol,'|', kd.nopol ) AS  driver_truk
										,group_concat(concat(dp.id_amplop,'|',b.nama_pengirim,'|',b.nama_penerima,'|',b.berat_amplop,'|',b.satuan,'|',dp.qty)   order by b.id_amplop SEPARATOR '===')  as amplop
										FROM ".$this->table." pg
										LEFT JOIN transaksi_surat_jalan_detail dp on dp.id_surat_jalan = dp.id_surat_jalan
										LEFT JOIN transaksi_amplop b on b.id_amplop = dp.id_amplop
										LEFT JOIN master_kendaraan kd on kd.id = pg.id_kendaraan
										LEFT JOIN master_driver kr on kr.id = pg.id_driver
										LEFT JOIN master_pool p on p.id_pool = pg.id_pool
								   	$where group by pg.id_surat_jalan
								   ");

		if(!$obj)
			$result = $query->result_array();
		else
			$result = $query->row();

		$query->free_result();

		return $result;
	}

	function remove($id)
    {
      if (!is_array($id))
		    $id = array($id);

		$this->db->where_in($this->key, $id)->delete($this->table);
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
		//var_dump($query);
		//exit();
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



}
