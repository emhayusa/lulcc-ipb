<?php
class Kecamatan_model extends CI_Model {

	var $table   = 'kecamatan';

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	function get_all()
	{
		$this->db->from($this->table);
		$this->db->order_by("id_kecamatan", "asc");
		return $this->db->get();
	}

	function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_kecamatan',$id);
		return $this->db->get();
	}
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}
	
	function update($id, $data){
		$this->db->where('id_kecamatan', $id);
		$this->db->update($this->table, $data);
	}

	function remove($id){
		$this->db->where('id_kecamatan', $id);
		$this->db->delete($this->table);
	}
	
}
?>