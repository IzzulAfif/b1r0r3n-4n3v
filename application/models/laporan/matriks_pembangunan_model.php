<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-20 13:00
 @fungsi	 : 
 @revision	 :
*/
	

class Matriks_pembangunan_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and kl.kode_kl='".$params['kode_kl']."'";
		}
		$sql = "select kl.* from anev_kl kl ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_indikator($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_sasaran_kl'])) $where .= " and ss.kode_sasaran_kl='".$params['kode_sasaran_kl']."'";
			if (isset($params['range_awal'])) $where .= " and kinerja.tahun between ".$params['range_awal']." and ".$params['range_akhir'];
		}
		$sql = "select kinerja.tahun,kinerja.kode_iku_e1,iku.deskripsi, iku.satuan,kinerja.target,kinerja.realisasi, kinerja.persen from anev_kinerja_eselon1 kinerja inner join anev_iku_eselon1 iku on kinerja.kode_iku_e1 = iku.kode_iku_e1 and kinerja.tahun = iku.tahun	inner join anev_sasaran_program sp on sp.kode_sp_e1 = iku.kode_sp_e1 and sp.tahun = iku.tahun	inner join anev_sasaran_strategis ss on sp.kode_ss_kl = ss.kode_ss_kl and sp.tahun = ss.tahun ".$where;
		$sql .= " order by kinerja.kode_iku_e1, kinerja.tahun ";
		return $this->mgeneral->run_sql($sql);
	
	}

	
}

