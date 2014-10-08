<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-15 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Target_capaian_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['tahun_renstra'])) $where .= " and t.tahun_renstra='".$params['tahun_renstra']."'";
			if (isset($params['sasaran'])) $where .= " and t.kode_ss_kl='".$params['sasaran']."'";
		}
		$sql = "select t.*,iku.kode_iku_kl,iku.deskripsi,iku.satuan from anev_target_kl t LEFT JOIN anev_iku_kl iku on t.kode_iku_kl = iku.kode_iku_kl".$where;
		$sql .= " group by iku.kode_iku_kl";
		
		return $this->mgeneral->run_sql($sql);
	}
}

