<?php
class Basemap_model extends CI_Model {

    var $table   = 'basemap';

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
		$this->db->select('id,thumbnail,url,basemap_name, active, main');
		$this->db->from($this->table);
		$this->db->order_by("id_basemap", "asc");
		return $this->db->get();
	}
		
	function get_by_id($id)
    {
		$this->db->select('thumbnail,url,basemap_name, active, main');
		$this->db->from($this->table);
		$this->db->where('id_basemap',$id);
		return $this->db->get();
	}	
	
}
?>