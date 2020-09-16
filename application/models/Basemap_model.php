<?php
class Basemap_model extends CI_Model {

	var $table   = 'basemap';

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	function get_all()
	{
		$this->db->from($this->table);
		$this->db->order_by("id_basemap", "desc");
		return $this->db->get();
	}

	function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_basemap',$id);
		return $this->db->get();
	}
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}
	
	function update($id, $data){
		$this->db->where('id_basemap', $id);
		$this->db->update($this->table, $data);
	}

	function reset(){
		$this->db->update($this->table, array('main'=>0, 'active'=>0));
	}

	function remove($id){
		$this->db->where('id_basemap', $id);
		$this->db->delete($this->table);
	}
	
}
?>