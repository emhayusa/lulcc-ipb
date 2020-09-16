<?php
class Reporting_model extends CI_Model {

	var $table   = 'reporting';
	
	var $table_view   = 'view_reporting';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function get_all()
    {
		$this->db->from($this->table);
		$this->db->order_by("id_reporting", "asc");
		return $this->db->get();
	}

	function get_all_view()
    {
		$this->db->from($this->table_view);
		$this->db->order_by("id_reporting", "desc");
		return $this->db->get();
	}
		
	function get_by_id($id)
    {
		$this->db->from($this->table);
		$this->db->where('id_reporting',$id);
		return $this->db->get();
	}

	function get_all_view_by_id($id)
    {
		$this->db->from($this->table_view);
		$this->db->where('id_reporting',$id);
		return $this->db->get();
	}
	
	function insert($data)
	{
	    $this->db->insert($this->table, $data);
	}
	
	function update($id, $data){
	    $this->db->where('id_reporting', $id);
	    $this->db->update($this->table, $data);
	}
		
	function remove($id){
	    $this->db->where('id_reporting', $id);
	    $this->db->delete($this->table);
	}
	
}
?>