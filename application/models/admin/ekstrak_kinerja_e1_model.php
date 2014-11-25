<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-31
 @fungsi	 : 
 @revision	 :
*/
	

class Ekstrak_kinerja_e1_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	
	
	function get_datatables($params){
		$this->datatables->select('ke1.tahun,ke1.kode_iku_e1, ke1.target,ke1.realisasi  , iku.deskripsi as iku, iku.satuan  ,ss.deskripsi as sasaran',false);
		$this->datatables->from('anev_kinerja_eselon1 ke1
INNER JOIN anev_iku_eselon1 iku ON ke1.kode_iku_e1 = iku.kode_iku_e1 and  ke1.tahun=iku.tahun
INNER JOIN anev_sasaran_program ss ON ss.kode_sp_e1=ke1.kode_sp_e1 and ss.tahun=ke1.tahun',false);
if (isset($params)){
			if (isset($params['tahun_renstra']))
			$this->datatables->where("ke1.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)");
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

}

