<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-10-1 13:00
 @fungsi	 : 
 @revision	 :
*/
	

class Kelompok_indikator_e1_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_data($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and c.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and b.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_awal'])) $where .= " and c.tahun between ".$params['tahun_awal']."  and  ".$params['tahun_akhir'];
			if (isset($params['tahun'])) $where .= " and c.tahun = ".$params['tahun'];
		}
		$sql = "SELECT DISTINCT a.no_kel AS nomor, a.deskripsi AS kel_indikator,c.tahun, c.kode_e1 AS kode_e1, c.kode_iku_e1 AS kode_iku_e1, c.deskripsi AS indikator_e1, c.satuan AS satuan, e.nama_e1 FROM anev_kel_indikator a LEFT JOIN anev_iku_kl b ON a.kode_ss_kl = b.kode_ss_kl JOIN anev_iku_eselon1 c on b.kode_iku_kl = c.kode_iku_kl LEFT JOIN anev_eselon1 e ON e.kode_e1=c.kode_e1 and c.tahun between left(e.tahun_renstra,4) and right(e.tahun_renstra,4)
 ".$where;
		$sql .= " ORDER BY   kode_e1,c.tahun, kode_iku_e1";
		return $this->mgeneral->run_sql($sql);
	
	}

	
}

