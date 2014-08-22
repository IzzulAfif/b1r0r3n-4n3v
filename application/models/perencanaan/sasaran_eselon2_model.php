<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-22 00:30
 @fungsi	 : 
 @revision	 :
*/
	

class Sasaran_eselon2_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e2'])) $where .= " and f.kode_e1='".$params['kode_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select f.*, kl.nama_e2 from anev_sasaran_eselon2 f inner join anev_eselon2 kl on f.kode_e2=kl.kode_e2 ".$where;
		return $this->mgeneral->run_sql($sql);
	}

}

