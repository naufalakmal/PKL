<?php
class master_driver_Model extends CI_Model
{
	var $table  = 'master_driver';
	var $key  = 'id';
	function __construct()
	{
		parent::__construct();
	}
	function getAll($filter = null, $limit = 20, $offset = 0, $orderBy, $orderType)
	{
		$where = "";
		$cond = array();
		if (isset($filter)) {
			if (!empty($filter->keyword)) {
				$cond[] = "(lower(" . $this->key . ") like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								)";
			}
		}

		$limitOffset = "LIMIT $offset,$limit";
		if ($limit == 0)
			$limitOffset = "";

		if (!$orderBy)
			$orderBy = $this->key;

		if (!$orderType)
			$orderType = "asc";

		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*,p.nama,p.alamat,p.hp,p.nik,q.nama as spv
								   FROM " . $this->table . " pg
								   LEFT JOIN master_karyawan p on p.id = pg.karyawan_id
									 LEFT JOIN master_spv a on a.id = pg.spv_id
									 LEFT JOIN master_karyawan q on q.id = a.karyawan_id

								   $where group by pg.id ORDER BY $orderBy $orderType $limitOffset
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
		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS pg.*,p.nama,p.alamat,p.hp,p.nik
								   FROM " . $this->table . " pg
								   LEFT JOIN master_karyawan p on p.id = pg.karyawan_id

								   $where group by pg.id
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
	
	public function hitungJumlahAsset()
	{
		$query = $this->db->get('master_driver');
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}






}
