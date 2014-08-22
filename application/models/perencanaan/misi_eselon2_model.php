<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2024-08-25 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Misi_eselon2_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 2=2 ';
		if (isset($params)){
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select f.*, e2.nama_e2 from anev_misi_eselon2 f inner join anev_eselon2 e2 on e2.kode_e2=f.kode_e2 ".$where;
		return $this->mgeneral->run_sql($sql);
	}

}

