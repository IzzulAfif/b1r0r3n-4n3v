<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-22 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Program_eselon1_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and f.kode_e1='".$params['kode_e1']."'";
			if (isset($params['tahun'])) $where .= " and f.tahun ='".$params['tahun']."'";
		}
		$sql = "select f.*, e1.nama_e1 from anev_program_eselon1 f inner join anev_eselon1 e1 on e1.kode_e1=f.kode_e1 ".$where;
		$sql .= " order by f.tahun desc, f.kode_program";
		return $this->mgeneral->run_sql($sql);
	}

}

