<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-22 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Kegiatan_eselon2_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['tahun'])) $where .= " and f.tahun ='".$params['tahun']."'";
		}
		$sql = "select f.*, e2.nama_e2,prog.nama_program from anev_kegiatan_eselon2 f inner join anev_eselon2 e2 on e2.kode_e2=f.kode_e2 and f.tahun between left(e2.tahun_renstra,4) and right(e2.tahun_renstra,4) left join anev_program_eselon1 prog on f.kode_program = prog.kode_program and f.tahun = prog.tahun".$where;
		$sql .= " order by f.tahun desc, f.kode_kegiatan";
		return $this->mgeneral->run_sql($sql);
	}

}

