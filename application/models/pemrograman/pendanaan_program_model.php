<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-10-11
 @fungsi	 : 
 @revision	 :
*/
	

class Pendanaan_program_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	//utk laporan renstra
	function get_renstra($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and f.kode_e1='".$params['kode_e1']."'";
			if (isset($params['tahun_renstra'])) $where .= "and f.tahun_renstra = '".$params['tahun_renstra']."'";
		
		}
		$sql = "select distinct f.*, e1.nama_e1,p.nama_program from anev_pendanaan_program f inner join anev_eselon1 e1 on e1.kode_e1=f.kode_e1 and f.tahun_renstra=e1.tahun_renstra inner join anev_program_eselon1 p on f.kode_program = p.kode_program and p.tahun between left(f.tahun_renstra,4) and right(f.tahun_renstra,4) ".$where;
		$sql .= "  order by f.kode_program";
		//echo $sql;
		return $this->mgeneral->run_sql($sql);
	}
	
	

}

