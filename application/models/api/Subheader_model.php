<?php
class Subheader_model extends CI_Model {

    var $table   = 'subheader';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function count_all(){			
		return $this->db->count_all_results($this->table);
	}
	
	public function get_page($page, $size)
	{
		
		return $this->db->get($this->table, $size, $page);
	}

	function get_all()
    {
		$this->db->select('id_subheader, subheader_name, commodity_id');
		$this->db->from($this->table);
		$this->db->order_by("id_subheader", "asc");
		return $this->db->get();
	}

	function get_by_id($id)
    {
		$this->db->select('id_subheader, subheader_name, commodity_id');
		$this->db->from($this->table);
		$this->db->where('id_subheader',$id);
		return $this->db->get();
	}	
	
}
?>