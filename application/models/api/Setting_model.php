<?php
class Setting_model extends CI_Model {

    var $table   = 'setting';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
    function get_by_id($id)
    {
		$this->db->select('logo, title, footer, about');
		$this->db->from($this->table);
		$this->db->where('id_setting',$id);
		return $this->db->get();
	}
}
?>