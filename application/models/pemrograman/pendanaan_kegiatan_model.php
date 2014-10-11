<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-10-11
 @fungsi	 : 
 @revision	 :
*/
	

class Pendanaan_kegiatan_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	//utk laporan renstra
	function get_renstra($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and e2.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= "and f.tahun_renstra = '".$params['tahun_renstra']."'";
		
		}
		$sql = "select distinct f.*, e2.nama_e2,p.nama_kegiatan from anev_pendanaan_kegiatan f inner join anev_eselon2 e2 on e2.kode_e2=f.kode_e2 and f.tahun_renstra=e2.tahun_renstra inner join anev_kegiatan_eselon2 p on f.kode_kegiatan = p.kode_kegiatan and p.tahun between left(f.tahun_renstra,4) and right(f.tahun_renstra,4) ".$where;
		$sql .= "  order by f.kode_kegiatan";
		//echo $sql;
		return $this->mgeneral->run_sql($sql);
	}
	
	

}

