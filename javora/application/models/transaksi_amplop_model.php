<?php
class transaksi_amplop_Model extends CI_Model
{
	var $table  = 'transaksi_amplop';
	var $table1  = 'transaksi_amplop_history';
	var $view  = 'v_ttb';
	var $key  = 'id_amplop';
	function __construct()
	{
		parent::__construct();
	}

	function getAllamplop($filter = null, $limit = 20, $offset = 0, $orderBy, $orderType)
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

		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS b.*,CONCAT( c.id_pool,',', c.nama_pool  ) AS  pool
								   FROM " . $this->view . " b
									 LEFT JOIN master_pool c on c.id_pool = b.id_pool

								   $where ORDER BY $orderBy $orderType $limitOffset
								   ");

		$result = $query->result_array();
		$query->free_result();

		$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

		return array($result, $total);
	}

	function getAll($filter = null, $limit = 20, $offset = 0, $orderBy, $orderType)
	{
		$where = "";
		$cond = array();
		if (isset($filter)) {
			if (!empty($filter->keyword)) {
				$cond[] = "(lower(" . $this->key . ") like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(id_amplop) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(tanggal) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(nama_pengirim) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(nama_penerima) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(alamat_penerima) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(ongkos_bersih) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(jenis_kirim) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								)";
			}

			if (!empty($filter->status)) {
				if (strtolower($filter->status) != "all")
					$cond[] = "(pg.status = '" . $this->db->escape_str(strtolower($filter->status)) . "')";
			}

			if (!empty($filter->from) || !empty($filter->to)) {
				$cond[] = "(pg.tanggal >= '" . $this->db->escape_str($filter->from) . "' and pg.tanggal <= '" . $this->db->escape_str($filter->to) . "' )";
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
			$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*,CONCAT( pg.kecamatan,',', pg.kota ,',', pg.provinsi  ) AS  address

											FROM ".$this->table." pg

									   	$where ORDER BY $orderBy $orderType $limitOffset
									   ");





		$result = $query->result_array();
		$query->free_result();

		$total = $this->db->query('SELECT found_rows() total_row')->row()->total_row;

		return array($result, $total);
	}

	public function get_by($field, $value = "", $obj = false)
	{
		if (!$field)
			$field = $this->key;

		$where = "WHERE $field = '" . $this->db->escape_str(strtolower($value)) . "'";
		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS *
 								 FROM " . $this->table . " pg
 								 $where
 								 ");

		if (!$obj)
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
		$this->db->where_in($this->key, $id)->delete("transaksi_detail_amplop");
	}

	function save($id = "", $data = array(), $insert_id = false)
	{

		if (!empty($id)) {
			$this->db->where($this->key, $id);
			$this->db->update($this->table, $data);
		} else {
			$this->db->insert($this->table, $data);
		}

		return $this->db->affected_rows();
	}

	public function get_last()
	{
		$query = $this->db->query("SELECT  * FROM " . $this->table . " order by " . $this->key . " desc limit 0,1");
		$result = $query->row();
		$query->free_result();

		return $result;
	}

	function remove_detail($id)
	{
		if (!is_array($id))
			$id = array($id);

		$this->db->where_in($this->key, $id)->delete("transaksi_detail_amplop");
	}

	function save_detail($data = array())
	{
		$this->db->insert("transaksi_amplop_history", $data);
		return $this->db->affected_rows();
	}

	public function hitungJumlahAsset()
	{
		$query = $this->db->get('transaksi_amplop');
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}
	function kabupaten($provId)
	{
		$kabupaten = "<option value='0'>--pilih--</pilih>";

		$this->db->order_by('nama_kota', 'ASC');
		$kab = $this->db->get_where('ref_kota', array('provinsi_id' => $provId));

		foreach ($kab->result_array() as $data) {
			$kabupaten .= "<option value='$data[id_kota]'>$data[nama_kota]</option>";
		}

		return $kabupaten;
	}


	function kecamatan($kabId)
	{
		$kecamatan = "<option value='0'>--pilih--</pilih>";

		$this->db->order_by('nama_kecamatan', 'ASC');
		$kec = $this->db->get_where('ref_kecamatan', array('kota_id' => $kabId));

		foreach ($kec->result_array() as $data) {
			$kecamatan .= "<option value='$data[id_kecamatan]'>$data[nama_kecamatan]</option>";
		}

		return $kecamatan;
	}
}
