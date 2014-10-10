<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-21 13:00
 @fungsi	 : 
 @revision	 :
*/
	

class Renstra_kl_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_indikator($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and f.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and f.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select distinct f.kode_iku_kl,f.deskripsi,f.satuan, kl.nama_kl, kinerja.target_thn1,kinerja.target_thn2,kinerja.target_thn3,kinerja.target_thn4,kinerja.target_thn5 from anev_iku_kl f 
inner join anev_kl kl on f.kode_kl=kl.kode_kl 
left join anev_target_kl kinerja on f.tahun between left(kinerja.tahun_renstra,4) and right(kinerja.tahun_renstra,4)
and kinerja.kode_kl = f.kode_kl and kinerja.kode_iku_kl = f.kode_iku_kl and kinerja.kode_ss_kl = f.kode_ss_kl ".$where;
		$sql .= " order by f.kode_iku_kl ";
		return $this->mgeneral->run_sql($sql);
	
	}
	
	function get_indikator_old($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and f.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and f.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, kl.nama_kl, kinerja.target from anev_iku_kl f inner join anev_kl kl on f.kode_kl=kl.kode_kl left join anev_kinerja_kl kinerja on kinerja.tahun=f.tahun and kinerja.kode_kl = f.kode_kl and kinerja.kode_iku_kl = f.kode_iku_kl and kinerja.kode_ss_kl = f.kode_ss_kl ".$where;
		$sql .= " order by f.kode_iku_kl, kinerja.tahun ";
		return $this->mgeneral->run_sql($sql);
	
	}


	
}

