<?php
class Setting_model extends CI_Model {

	var $table   = 'setting';
	var $tabel_provinsi='provinsi';
	var $tabel_kabupaten='kabupaten';
	var $tabel_kecamatan='kecamatan';
	var $tabel_kelurahan='kelurahan';

	function __construct()
	{
        // Call the Model constructor
		parent::__construct();
	}

	function get_all()
	{
		$this->db->from($this->table);
		$this->db->order_by("id_setting", "asc");
		return $this->db->get();
	}   
	
	function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_setting',$id);
		return $this->db->get();
	}
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}
	
	function update($id, $data){
		$this->db->where('id_setting', $id);
		$this->db->update($this->table, $data);
	}

	function remove($id){
		$this->db->where('id_setting', $id);
		$this->db->delete($this->table);
	}
	
	function get_setting()
	{
		$this->db->from($this->table);
		return $this->db->get();
	}	

	public function ambil_provinsi() {
	$sql_prov=$this->db->get($this->tabel_provinsi);	
	if($sql_prov->num_rows()>0){
		foreach ($sql_prov->result_array() as $row)
			{
				$result['-']= '- Choose Province -';
				$result[$row['id_provinsi']]= ucwords(strtolower($row['nama_provinsi']));
			}
			return $result;
		}
	}
	
	public function ambil_kabupaten($kode_prop){
	$this->db->where('id_provinsi',$kode_prop);
	$this->db->order_by('nama_kabupaten','asc');
	$sql_kabupaten=$this->db->get($this->tabel_kabupaten);
		if($sql_kabupaten->num_rows()>0){

		foreach ($sql_kabupaten->result_array() as $row)
        {
            $result[$row['id_kabupaten']]= ucwords(strtolower($row['nama_kabupaten']));
        }
		} else {
		   $result['-']= '- Belum Ada Kabupaten -';
		}
        return $result;
	}
	
	public function ambil_kecamatan($kode_kab){
	$this->db->where('id_kabupaten',$kode_kab);
	$this->db->order_by('nama_kecamatan','asc');
	$sql_kecamatan=$this->db->get($this->tabel_kecamatan);
	if($sql_kecamatan->num_rows()>0){

		foreach ($sql_kecamatan->result_array() as $row)
        {
            $result[$row['id_kecamatan']]= ucwords(strtolower($row['nama_kecamatan']));
        }
		} else {
		   $result['-']= '- Belum Ada Kecamatan -';
		}
        return $result;
	}

	public function ambil_kelurahan($kode_kec){
	$this->db->where('id_kecamatan',$kode_kec);
	$this->db->order_by('nama_kelurahan','asc');
	$sql_kelurahan=$this->db->get($this->tabel_kelurahan);
	if($sql_kelurahan->num_rows()>0){

		foreach ($sql_kelurahan->result_array() as $row)
        {
            $result[$row['id_kelurahan']]= ucwords(strtolower($row['nama_kelurahan']));
        }
		} else {
		   $result['-']= '- Belum Ada Kelurahan -';
		}
        return $result;
	}

}
?>