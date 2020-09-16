<?php
class Login_model extends CI_Model {

    var $table   = 'user';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function cek_data($where){
        return $this->db->get_where($this->table,$where);
    }	
	
	function insert($data)
	{
	    $this->db->insert($this->table, $data);
	}
	
	function update($id, $data){
	    $this->db->where('id_user', $id);
	    $this->db->update($this->table, $data);
	}
		
	function delete($id){
	    $this->db->where('id_user', $id);
	    $this->db->delete($this->table);
	}
	
}
?>