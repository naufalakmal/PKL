<?php
class Transaksi_ttb_Model extends CI_Model
{
	var $table  = 'transaksi_ttb';
	var $view  = 'v_ttb';
	var $key  = 'id_amplop';
	function __construct()
	{
		parent::__construct();
	}

	function getAllttb($filter = null, $limit = 20, $offset = 0, $orderBy, $orderType)
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
	function getAll($filter = null, $limit = 20, $offset = 0, $orderBy, $orderType)
	{
		$where = "";
		$cond = array();
		if (isset($filter)) {
			if (!empty($filter->keyword)) {
				$cond[] = "(lower(" . $this->key . ") like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
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

		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*,p.nama pelanggan,p.alamat

								   FROM " . $this->table . " pg



								   LEFT JOIN master_pelanggan p on p.id_pelanggan = pg.id_pelanggan
								   $where group by pg.id_amplop ORDER BY $orderBy $orderType $limitOffset
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
		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*,p.nama pelanggan,p.alamat

								   FROM " . $this->table . " pg



								   LEFT JOIN master_pelanggan p on p.id_pelanggan = pg.id_pelanggan
								   $where group by pg.id_amplop
								   ");

		if (!$obj)
			$result = $query->result_array();
		else
			$result = $query->row();

		$query->free_result();

		return $result;
	}

	public function get_by_pelanggan($field, $value = "", $obj = false)
	{
		if (!$field)
			$field = 'id_pelanggan';

		$where = "WHERE $field = '" . $this->db->escape_str(strtolower($value)) . "'";
		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.hutang

									 FROM " . 'master_pelanggan' . " pg




									 $where group by pg.id_pelanggan
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
		$this->db->where_in($this->key, $id)->delete("transaksi_ttb_history");
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

		$this->db->where_in($this->key, $id)->delete("transaksi_ttb_history");
	}

	public function hitungJumlahOrder()
	{
		$query = $this->db->get('transaksi_ttb');
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}

	public function hitungJumlahTtb()
	{
		$query = $this->db->get_where('transaksi_ttb', array('status' => '1'));
		//$query = $this->db->get('transaksi_ttb');
		//$this->db->where('status', 0);
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}

	public function hitungJumlahDikirim()
	{
		$query = $this->db->get_where('transaksi_ttb', array('status' => '2'));
		//$query = $this->db->get('transaksi_ttb');
		//$this->db->where('status', 0);
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}

	function save_detail($data = array())
	{
		$this->db->insert("transaksi_ttb_history", $data);
		return $this->db->affected_rows();
	}
	function save_piutang($data = array())
	{
		$this->db->insert("daftar_piutang", $data);
		return $this->db->affected_rows();
	}
	function save_rekening_piutang($data = array())
	{
		$this->db->insert("rekening_laporan_piutang", $data);
		return $this->db->affected_rows();
	}
	function update_hutang_pelanggan($pelanggan, $data = array())
	{

		$this->db->where('id_pelanggan', $pelanggan);
		$this->db->update('master_pelanggan', $data);
		return $this->db->affected_rows();
	}
}
