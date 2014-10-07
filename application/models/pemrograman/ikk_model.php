<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-24 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Ikk_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		/*$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_sk_e2'])) $where .= " and f.kode_sk_e2='".$params['kode_sk_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, e2.nama_e2,sk.deskripsi as saskeg_deskripsi from anev_ikk f inner join anev_eselon2 e2 on f.kode_e2=e2.kode_e2 and f.tahun between left(e2.tahun_renstra,4) and right(e2.tahun_renstra,4) left join anev_sasaran_kegiatan sk  on f.kode_sk_e2 = sk.kode_sk_e2 and f.tahun = sk.tahun".$where;
		$sql .= " group by f.kode_ikk order by f.kode_ikk";
		return $this->mgeneral->run_sql($sql);*/
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_e1'])) $where .= " and iku.kode_e1='".$params['kode_e1']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, e2.nama_e2,sk.deskripsi as saskeg_deskripsi from anev_ikk f inner join anev_eselon2 e2 on f.kode_e2=e2.kode_e2 and f.tahun between left(e2.tahun_renstra,4) and right(e2.tahun_renstra,4) left join anev_sasaran_kegiatan sk  on f.kode_sk_e2 = sk.kode_sk_e2 and f.tahun = sk.tahun left join anev_iku_eselon1 iku on iku.kode_iku_e1 = f.kode_iku_e1 ".$where;
		$sql .= " group by f.kode_ikk order by f.kode_ikk";
		return $this->mgeneral->run_sql($sql);
	}
	
	//utk laporan renstra
	function get_renstra($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_sk_e2'])) $where .= " and f.kode_sk_e2='".$params['kode_sk_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select distinct kode_ikk, deskripsi,satuan from anev_ikk f inner join anev_eselon2 e on f.kode_e2=e.kode_e2 and f.tahun between left(e.tahun_renstra,4) and right(e.tahun_renstra,4) ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	

}

