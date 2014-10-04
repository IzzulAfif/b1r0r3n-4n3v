<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-08-12 23:30
 @fungsi	 : general model yang digunakan untuk melakukan query - query sederhana 
 @revision	 :
	YJS 2014-08-20 --> tambah default value di getWhere, getAll utk param limit & limitid
					-> tambah default value utk $r di run_sql()
*/
	
#akses ke semua tabel di database
class mgeneral extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	#querry semua data dalam tabel
		#ex akses : $this->mgeneral->getAll('nama_tabel');
	function getAll($tabel, $order_field="", $order_tipe="",$limit="",$limitend="")
	{
		if($order_field!="" && $order_tipe!=""){ $this->db->order_by($order_field,$order_tipe); }
		if($limit!="" && $limitend==""){ $this->db->limit($limit,0); }
		if($limit!="" && $limitend!=""){ $this->db->limit($limitend,$limit-1); }
		return $this->db->get($tabel)->result();
	}
	
	#fungsi untuk melakukan query standar
		#ex akses : $this->mgeneral->getWhere(array('field1'=>'data','field2'=>'data'),'nama_tabel');
	function getWhere($where,$tabel,$order_field="",$order_tipe="",$limit="",$limitend="") {
		$this->db->where($where);
		if($order_field!=""){ $this->db->order_by($order_field,$order_tipe); }
		if($limit!="" && $limitend==""){ $this->db->limit($limit,0); }
		if($limit!="" && $limitend!=""){ $this->db->limit($limitend,$limit-1); }
		return $this->db->get($tabel)->result();
	}
	
	#fungsi untuk melakukan query standar menggunakan like
		#ex akses : $this->mgeneral->getLike(array('field1'=>'data','field2'=>'data'),'nama_tabel');
	function getLike($where,$tabel)
	{
		$this->db->like($where);
		return $this->db->get($tabel)->result();
	}
	
	#fungsi save data
		#ex akses : $this->mgeneral->save(array_data_insert,nama_tabel);
	function save($varData,$tabel){
		$this->db->insert($tabel, $varData);
		//echo $this->db->last_query();
		return $this->db->insert_id();
	}
	
	#fungsi update data
		#ex akses : $this->mgeneral->update(array('field1'=>'data','field2'=>'data'),array_data_udate,nama_tabel);
	function update($where, $data, $tabel){
		$this->db->where($where);
		$this->db->update($tabel, $data);
	}
	
	#fungsi hapus data
		#ex akses : $this->mgeneral->delete(array('field1'=>'data','field2'=>'data'),nama_tabel);
	function delete($where,$tabel){
		$this->db->where($where);
		$this->db->delete($tabel);
	}
	
    #fungsi untuk mendapatkan nilai dari sebuah field
    #ex akses : $this->mgeneral->getValue(field1,array('field2'=>'data'),'nama_tabel');

    function getValue($field, $where, $tabel) {
        $this->db->select($field,false);
        $this->db->where($where);
        $result = $this->db->get($tabel)->result();
		$value	= "";
        foreach ($result as $r) {
            $value = $r->$field;
        }
        return $value;
    }
	
	function run_sql($query){
		$sql = "".$query."";
				
		$q = $this->db->query($sql);
		$r=null;
		if($q->num_rows() > 0){
			$r = $q->result();
		}
		return $r;
	}

}

