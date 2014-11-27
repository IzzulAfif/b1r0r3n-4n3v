<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-31
 @fungsi	 : 
 @revision	 :
*/
	

class Ekstrak_program_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	
	
	function get_datatables($params){
		$this->datatables->select('kode_program,nama_program,pagu,realisasi,tahun ');
		$this->datatables->from('anev_program_eselon1');
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
			unset($update_item['kddept']);
			unset($update_item['kdunit']);
			unset($update_item['kdprogram']);
			unset($update_item['kdsatker']);
			unset($update_item['kdfungsi']);
			unset($update_item['kdsfung']);
			unset($update_item['thang']);
			unset($update_item['nmprogram']);
			$insert_query = $this->db->insert_string('anev_program_eselon1', $update_item);
			$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
			//var_dump($insert_query);
			$this->db->query($insert_query);  
		}
		
		$this->db->trans_complete();
			//print_r($this->db);die;
	    return $this->db->trans_status();
	
	}

}

