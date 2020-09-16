<?php
class Services_model extends CI_Model {

    var $table   = 'services';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function get_all()
    {
		$this->db->from($this->table);
		$this->db->order_by("id_service", "desc");
		return $this->db->get();
	}
		
	function get_by_id($id)
    {
		$this->db->from($this->table);
		$this->db->where('id_service',$id);
		return $this->db->get();
	}
	
	function insert($data)
	{
	    $this->db->insert($this->table, $data);
	}
	
	function update($id, $data){
	    $this->db->where('id_service', $id);
	    $this->db->update($this->table, $data);
	}
		
	function remove($id){
	    $this->db->where('id_service', $id);
	    $this->db->delete($this->table);
	}
	
}
?>