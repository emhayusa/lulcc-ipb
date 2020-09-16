<?php
class Tutorial_model extends CI_Model {

    var $table   = 'tutorial';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function get_all()
    {
		$this->db->from($this->table);
		$this->db->order_by("id_tutorial", "asc");
		return $this->db->get();
	}
		
	function get_by_id($id)
    {
		$this->db->from($this->table);
		$this->db->where('id_tutorial',$id);
		return $this->db->get();
	}
	
	function insert($data)
	{
	    $this->db->insert($this->table, $data);
	}
	
	function update($id, $data){
	    $this->db->where('id_tutorial', $id);
	    $this->db->update($this->table, $data);
	}
		
	function remove($id){
	    $this->db->where('id_tutorial', $id);
	    $this->db->delete($this->table);
	}
	
}
?>