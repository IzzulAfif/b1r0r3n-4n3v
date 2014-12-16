<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-31
 @fungsi	 : 
 @revision	 :
*/
	

class Kabkota_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and e2.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and e2.kode_e2='".$params['kode_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and e1.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select e2.*, e1.nama_e1 from anev_eselon2 e2 inner join anev_eselon1 e1 on e1.kode_e1=e2.kode_e1 and e1.tahun_renstra=e2.tahun_renstra ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_list($params) {
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kdlokasi'])) $where .= " and kdlokasi='".$params['kdlokasi']."'";
		}
		$sql = "select distinct kdlokasi, lokasi from anev_lokasi ".$where;
		$sql .= " order by lokasi";
		
		$result = $this->mgeneral->run_sql($sql);
		
		$list[0] = 'Pilih Lokasi';
		if (isset($result))
			foreach ($result as $i) {
				$list[$i->kdlokasi] = $i->lokasi;
			}
		return $list;
	}
	
	
	function get_datatables($params){
		$this->datatables->select('kdlokasi,kdkabkota, nama_kabkota,latitude,longitude ');
		$this->datatables->from('anev_kabkota');
	
		return $this->datatables->generate();
	
	}
	
	
	function save_ekstrak($data){
		$this->db->trans_start();
		
		foreach ($data as $update_item) {
		//	unset($update_item['status']);
			$sql = 'INSERT INTO anev_kabkota (kdlokasi,kdkabkota,nama_kabkota)
					VALUES (?,?, ?)
					ON DUPLICATE KEY UPDATE 
						nama_kabkota=VALUES(nama_kabkota)';

			$query = $this->db->query($sql, array( $update_item['kdlokasi'],  $update_item['kdkabkot'], 
												  $update_item['nmkabkota']
												  )); 
		}
		
		$this->db->trans_complete();
			//print_r($this->db);die;
	    return $this->db->trans_status();
	
	}


}

