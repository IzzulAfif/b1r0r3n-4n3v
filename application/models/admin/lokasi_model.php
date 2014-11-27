<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-31
 @fungsi	 : 
 @revision	 :
*/
	

class Lokasi_model extends CI_Model
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
	
	
	function get_datatables($params=null){
		$this->datatables->select('kdlokasi, lokasi ');
		$this->datatables->from('anev_lokasi');
		$aOrder =isset($_POST['iSortCol_0'])?$_POST['iSortCol_0']:0;
		$aOrderDir =isset($_POST['sSortDir_0'])?$_POST['sSortDir_0']:"ASC";
		$sOrder = "";
	/*	if ( isset( $aOrder ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<count($aOrder) ; $i++ )
			{
				if ( $aCols[intval($aOrder[$i]['column'])]['orderable'] == "true" )
				{
					$sOrder .= $aCols[intval($aOrder[$i]['column'])]['data']." ".($aOrder[$i]['dir']=='asc' ? 'ASC' : 'DESC') .", ";
				}
			}
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}*/
		//$this->datatables->join('anev_eselon1 e1', 'e1.kode_e1=e2.kode_e1 and e1.tahun_renstra=e2.tahun_renstra', 'left');
		//$this->datatables->add_column('aksi', '$1','e2_action(e2.kode_e2)');
		return $this->datatables->generate();
	
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
			$sql = 'INSERT INTO anev_lokasi (kdlokasi,lokasi)
					VALUES (?, ?)
					ON DUPLICATE KEY UPDATE 
						lokasi=VALUES(lokasi)';

			$query = $this->db->query($sql, array( $update_item['kdlokasi'], 
												  $update_item['nmlokasi']
												  )); 
		}
		
		$this->db->trans_complete();
			//print_r($this->db);die;
	    return $this->db->trans_status();
	
	}

}

