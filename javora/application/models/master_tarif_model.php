<?php
class master_tarif_Model extends CI_Model
{
	var $table  = 'master_tarif';
	var $key  = 'id_tarif';

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
								 or lower(r.nama_kota) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(s.nama_provinsi) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(p.nama_kecamatan) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								 or lower(q.nama_kecamatan) like '%" . $this->db->escape_str(strtolower($filter->keyword)) . "%'
								)";
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

		$query = $this->db->query("SELECT SQL_CALC_FOUND_ROWS *,r.nama_kota,s.nama_provinsi,p.nama_kecamatan as nama_kecamatan_asal,q.nama_kecamatan as nama_kecamatan_tujuan
								   FROM " . $this->table . " pg
									 LEFT JOIN ref_kecamatan p on p.id_kecamatan = pg.id_kecamatan_asal
									 LEFT JOIN ref_kecamatan q on q.id_kecamatan = pg.id_kecamatan_tujuan
									 LEFT JOIN ref_kota r on r.id_kota = q.kota_id
									 LEFT JOIN ref_provinsi s on s.id_provinsi = r.provinsi_id
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
		$query = $this->db->query("SELECT  *
								   FROM " . $this->table . "
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

	public function cekName($id, $name)
	{
		$where = "WHERE " . $this->key . " <> '" . $this->db->escape_str(strtolower($id)) . "' and nama = '" . $this->db->escape_str(strtolower($name)) . "' ";
		$query = $this->db->query("SELECT  *
								   FROM " . $this->table . "
								   $where
								   ");

		$result = $query->result_array();

		$query->free_result();

		return $result;
	}



	public function get_last()
	{
		$query = $this->db->query("SELECT  * FROM " . $this->table . " order by " . $this->key . " desc limit 0,1");
		$result = $query->row();
		$query->free_result();

		return $result;
	}

	public function get_ref_provinsi()
	{
		$this->db->order_by('nama_provinsi', 'ASC');
		$query = $this->db->get('ref_provinsi');
		return $query->result();
	}

	public function hitungJumlahAsset()
	{
		$query = $this->db->get('master_tarif');
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}

	function provinsi()
	{

		$this->db->order_by('nama_provinsi', 'ASC');
		$ref_provinsis = $this->db->get('ref_provinsi');


		return $ref_provinsis->result_array();
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
