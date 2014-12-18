<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-31
 @fungsi	 : 
 @revision	 :
*/
	

class Output_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	
	function get_datatables($params){
		if (isset($params)){
			// if ((isset($params['kode_e1']))&&($params['kode_e1']!="0"))$this->datatables->where("s.kode_e1",$params['kode_e1']);
			// if ((isset($params['tahun_renstra']))&&($params['tahun_renstra']!="0"))$this->datatables->where("s.tahun_renstra",$params['tahun_renstra']);
			
		}
		
		$this->datatables->select('kode_kegiatan, kdoutput, nmoutput, satuan ');
		$this->datatables->from('anev_output s');
	
		// $this->datatables->where($key_condition, $val = NULL, true);
		//$this->datatables->join('anev_lokasi l', 'e1.kode_e1=s.kode_e1 and e1.tahun_renstra=s.tahun_renstra', 'left');
		//$this->datatables->add_column('aksi', '$1','e2_action(e2.kode_e2)');
		return $this->datatables->generate();
		
	
	}
	
	function get_record_count($params){
		$this->db->select("s.tahun_renstra, s.kode_satker, s.nama_satker, s.lokasi_satker, s.kode_e1");
		$this->db->from("anev_output s left join anev_eselon1 e1 on e1.kode_e1=s.kode_e1 and e1.tahun_renstra=s.tahun_renstra",false);
		
		return $this->db->count_all_results();
	}
	
	
	function save_ekstrak($data){
		$this->db->trans_start();
		// foreach($data as $d){
			// $this->db->insert('anev_matriks_pembangunan', $d);
		// }
		
		foreach ($data as $update_item) {
			unset($update_item['status']);
			// $insert_query = $this->db->insert_string('anev_lokasi', $update_item);
			// $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);			
			// $this->db->query($insert_query);  
			$sql = 'INSERT INTO anev_output (kode_kegiatan, kdoutput, nmoutput, satuan)
					VALUES (?, ?, ?, ?)
					ON DUPLICATE KEY UPDATE 
						nmoutput=VALUES(nmoutput), satuan=VALUES(satuan)';

			$query = $this->db->query($sql, array( $update_item['KDGIAT'], 
												  $update_item['KDOUTPUT'], 
												  $update_item['NMOUTPUT'],  
												  $update_item['SAT']
												  )); 
		}
		
		$this->db->trans_complete();
			//print_r($this->db);die;
	    return $this->db->trans_status();
	
	}

}

