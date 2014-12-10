<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-31
 @fungsi	 : 
 @revision	 :
*/
	

class Ekstrak_iku_e1_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	
	
	function get_datatables($params){
		$this->datatables->select(' tahun,  deskripsi,kode_e1,kode_iku_kl,kode_iku_e1,satuan, kode_sp_e1');
		$this->datatables->from('anev_iku_eselon1');
		if (isset($params)){
			if (isset($params['tahun_renstra']))
			$this->datatables->where("tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)");
			if (isset($params['tahun']))
				$this->datatables->where("tahun",$params['tahun']);
		}
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
			//unset($update_item['kddept']);
			//,realisasi
				// realisasi=VALUES(realisasi),	
				//var_dump($update_item);die;		
			$sql = 'INSERT INTO anev_iku_eselon1 ( tahun, kode_iku_e1, kode_e1,kode_iku_kl, deskripsi, satuan, kode_sp_e1  )
					VALUES (?,?,?,?,?,?,?)
					ON DUPLICATE KEY UPDATE 
						deskripsi=VALUES(deskripsi),	
						satuan=VALUES(satuan),	
						kode_e1=VALUES(kode_e1),	
						kode_iku_kl=VALUES(kode_iku_kl),	
						kode_sp_e1=VALUES(kode_sp_e1)';
			//,$update_item['pagu']
			$query = $this->db->query($sql, array( $update_item['tahun'],$update_item['kode_iku_e1'],$update_item['kode_e1'],$update_item['kode_iku_kl'],$update_item['deskripsi'],$update_item['satuan'],$update_item['kode_sasaran_e1']));  
			
			
			$sql = 'INSERT IGNORE INTO anev_target_eselon1 (tahun_renstra,kode_e1,kode_sp_e1,kode_iku_e1 )
					VALUES (?,?,?,?) ';
			//,$update_item['pagu']
			$query = $this->db->query($sql, array( $update_item['tahun_renstra'],$update_item['kode_e1'], $update_item['kode_sasaran_e1'], $update_item['kode_iku_e1'])); 
		}
		
		$this->db->trans_complete();
			//print_r($this->db);die;
	    return $this->db->trans_status();
	
	}
}

