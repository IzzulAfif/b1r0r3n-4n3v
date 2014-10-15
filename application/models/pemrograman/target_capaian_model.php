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
	
	function get_e1($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['tahun_renstra'])) $where .= " and t.tahun_renstra='".$params['tahun_renstra']."'";
			if (isset($params['sasaran'])) $where .= " and t.kode_sp_e1='".$params['sasaran']."'";
		}
		$sql = "select t.*,iku.kode_iku_e1,iku.deskripsi,iku.satuan from anev_target_eselon1 t LEFT JOIN anev_iku_eselon1 iku on t.kode_iku_e1 = iku.kode_iku_e1".$where;
		$sql .= " group by iku.kode_iku_e1";
		
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_e2($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['tahun_renstra'])) $where .= " and t.tahun_renstra='".$params['tahun_renstra']."'";
			if (isset($params['sasaran'])) $where .= " and t.kode_sk_e2='".$params['sasaran']."'";
		}
		$sql = "select t.*,ikk.kode_ikk,ikk.deskripsi,ikk.satuan from anev_target_eselon2 t LEFT JOIN anev_ikk ikk on t.kode_ikk = ikk.kode_ikk".$where;
		$sql .= " group by ikk.kode_ikk";
		
		return $this->mgeneral->run_sql($sql);
	}
}

