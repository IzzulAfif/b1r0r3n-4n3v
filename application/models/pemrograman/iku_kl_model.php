<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-15 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Iku_kl_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and f.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and f.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, kl.nama_kl,ss.deskripsi as sastra_deskripsi from anev_iku_kl f inner join anev_kl kl on f.kode_kl=kl.kode_kl and f.tahun between left(kl.tahun_renstra,4) and right(kl.tahun_renstra,4) left join anev_sasaran_strategis ss  on f.kode_ss_kl = ss.kode_ss_kl and f.tahun = ss.tahun".$where;
		$sql .= " order by f.tahun desc, f.kode_iku_kl";
		return $this->mgeneral->run_sql($sql);
	}
	
	//utk laporan renstra
	function get_renstra($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and f.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and f.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select distinct kode_iku_kl, deskripsi from anev_iku_kl f inner join anev_kl kl on f.kode_kl=kl.kode_kl ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	

}

