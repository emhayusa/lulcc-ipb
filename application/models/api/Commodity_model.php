<?php
class Commodity_model extends CI_Model {

    var $table   = 'commodity';

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
		$this->db->select('id_commodity, commodity_name, thumbnail_on, thumbnail_off, sort, service_id, subheader');
		$this->db->from($this->table);
		$this->db->order_by("sort", "asc");
		return $this->db->get();
	}
	
	function get_all_service_subheader(){
		
		$this->db->select('id_subheader, commodity_name, id_service, type, url, layer, name, definition, resolution, coverage, data_source, year, frequency, limitation, license, citation');
		$this->db->from($this->table);
		$this->db->join('services', 'id_commodity = services.commodity_id');
		$this->db->join('subheader', 'id_subheader = subheader_id');
	    $this->db->where('subheader', 1);
		$this->db->order_by("name", "asc");
		return $this->db->get();
	}
		
	function get_all_service_no_subheader(){
		
		$this->db->select('id_commodity, commodity_name, id_service, type, url, layer, name, definition, resolution, coverage, data_source, year, frequency, limitation, license, citation ');
		$this->db->from($this->table);
		$this->db->join('services', 'id_commodity = commodity_id');
		$this->db->where('subheader', 0);
		$this->db->order_by("name", "asc");
		return $this->db->get();
	
	}
	
	function get_by_id($id)
    {
		$this->db->select('commodity_name, thumbnail_on, thumbnail_off, sort, service_id');
		$this->db->from($this->table);
		$this->db->where('id_commodity',$id);
		return $this->db->get();
	}	
	
}
?>