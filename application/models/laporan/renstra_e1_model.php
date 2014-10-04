<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-21 13:00
 @fungsi	 : 
 @revision	 :
*/
	

class Renstra_e1_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_indikator($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and f.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_sp_e1'])) $where .= " and f.kode_sp_e1='".$params['kode_sp_e1']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, e1.nama_e1, kinerja.target from anev_iku_eselon1 f inner join anev_eselon1 e1 on f.kode_e1=e1.kode_e1 left join anev_kinerja_eselon1 kinerja on kinerja.tahun=f.tahun and kinerja.kode_e1 = f.kode_e1 and kinerja.kode_iku_e1 = f.kode_iku_e1 and kinerja.kode_sp_e1 = f.kode_sp_e1 ".$where;
		$sql .= " order by f.kode_iku_e1, kinerja.tahun ";
		return $this->mgeneral->run_sql($sql);
	
	}

	
}

