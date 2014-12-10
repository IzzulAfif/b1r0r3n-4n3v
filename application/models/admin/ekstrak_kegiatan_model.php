<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-31
 @fungsi	 : 
 @revision	 :
*/
	

class Ekstrak_kegiatan_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	
	
	function get_datatables($params){
		$this->datatables->select('tahun, kode_kegiatan, nama_kegiatan, kode_program, pagu, realisasi, kode_e2 ');
		$this->datatables->from('anev_kegiatan_eselon2');
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
	 
		foreach ($data as $update_item) {
			$sql = 'INSERT INTO anev_kegiatan_eselon2 (  tahun, kode_kegiatan, nama_kegiatan, kode_program,  kode_e2  )
					VALUES (?,?,?,?,?)
					ON DUPLICATE KEY UPDATE 
						nama_kegiatan=VALUES(nama_kegiatan),	
						kode_program=VALUES(kode_program),	
						kode_e2=VALUES(kode_e2)';
			//,$update_item['pagu']
			$query = $this->db->query($sql, array( $update_item['tahun'],$update_item['kode_kegiatan'],$update_item['nama_kegiatan'],$update_item['kode_program'],$update_item['kode_e2']));   
			
			$sql = 'INSERT IGNORE INTO anev_pendanaan_kegiatan (  tahun_renstra, kode_e2,kode_program,kode_kegiatan  )
					VALUES (?,?,?,?) ';
			//,$update_item['pagu']
			$query = $this->db->query($sql, array( $update_item['tahun_renstra'],$update_item['kode_e2'], $update_item['kode_program'],$update_item['kode_kegiatan']));   
		}
		
		$this->db->trans_complete();
			//print_r($this->db);die;
	    return $this->db->trans_status();
	
	}

}

