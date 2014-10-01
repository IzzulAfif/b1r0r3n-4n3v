<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-10-1 13:00
 @fungsi	 : 
 @revision	 :
*/
	

class Kelompok_indikator_e2_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_data($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and c.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and d.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and b.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_awal'])) $where .= " and d.tahun between ".$params['tahun_awal']."  and  ".$params['tahun_akhir'];
		}
		$sql = "SELECT DISTINCT a.no_kel AS nomor, a.deskripsi AS kel_indikator, d.tahun, d.kode_e2 AS kode_e2, d.kode_ikk AS kode_ikk, d.deskripsi AS indikator_e2, d.satuan AS satuan,f.nama_e2 FROM anev_kel_indikator a LEFT JOIN anev_iku_kl b ON a.kode_ss_kl = b.kode_ss_kl JOIN anev_iku_eselon1 c on b.kode_iku_kl = c.kode_iku_kl and b.tahun=c.tahun JOIN anev_ikk d on c.kode_iku_e1=d.kode_iku_e1 and c.tahun=d.tahun LEFT JOIN anev_eselon2 f ON f.kode_e2=d.kode_e2 and d.tahun between left(f.tahun_renstra,4) and right(f.tahun_renstra,4) ".$where;
		$sql .= " ORDER BY d.tahun, kode_e2, kode_ikk ";
		return $this->mgeneral->run_sql($sql);
	
	}

	
}

