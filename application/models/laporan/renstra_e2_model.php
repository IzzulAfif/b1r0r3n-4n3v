<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-21 13:00
 @fungsi	 : 
 @revision	 :
*/
	

class Renstra_e2_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_indikator($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_sk_e2'])) $where .= " and f.kode_sk_e2='".$params['kode_sk_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "SELECT DISTINCT f.kode_ikk,f.deskripsi,f.satuan, e2.nama_e2, kinerja.target_thn1, kinerja.target_thn2, kinerja.target_thn3, kinerja.target_thn4, kinerja.target_thn5 FROM anev_ikk f INNER JOIN anev_eselon2 e2 ON f.kode_e2=e2.kode_e2 LEFT JOIN anev_target_eselon2 kinerja ON  f.tahun BETWEEN LEFT(kinerja.tahun_renstra,4) AND RIGHT(kinerja.tahun_renstra,4) AND kinerja.kode_e2 = f.kode_e2 AND kinerja.kode_ikk = f.kode_ikk AND kinerja.kode_sk_e2 = f.kode_sk_e2 ".$where;
		$sql .= " ORDER BY f.kode_ikk  ";
		return $this->mgeneral->run_sql($sql);
	
	}
	
	function get_indikator_old($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_sk_e2'])) $where .= " and f.kode_sk_e2='".$params['kode_sk_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, e2.nama_e2, kinerja.target from anev_ikk f inner join anev_eselon2 e2 on f.kode_e2=e2.kode_e2 left join anev_kinerja_eselon2 kinerja on kinerja.tahun=f.tahun and kinerja.kode_e2 = f.kode_e2 and kinerja.kode_ikk = f.kode_ikk and kinerja.kode_sk_e2 = f.kode_sk_e2 ".$where;
		$sql .= " order by f.kode_ikk, kinerja.tahun ";
		return $this->mgeneral->run_sql($sql);
	
	}

	
}

