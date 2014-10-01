<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-10-1 13:00
 @fungsi	 : 
 @revision	 :
*/
	

class Kelompok_indikator_kl_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_data($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and b.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and b.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_awal'])) $where .= " and b.tahun between ".$params['tahun_awal']."  and  ".$params['tahun_akhir'];
		}
		$sql = "SELECT DISTINCT a.no_kel AS nomor,b.tahun, a.deskripsi AS kel_indikator, b.kode_iku_kl AS kode_iku_kl, b.deskripsi AS indikator_kl, b.satuan AS satuan FROM anev_kel_indikator a LEFT JOIN anev_iku_kl b ON a.kode_ss_kl = b.kode_ss_kl ".$where;
		$sql .= " ORDER BY tahun,kode_iku_kl";
		return $this->mgeneral->run_sql($sql);
	
	}

	
}

