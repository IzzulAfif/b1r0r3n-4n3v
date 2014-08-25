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
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_sk_e2'])) $where .= " and f.kode_sk_e2='".$params['kode_sk_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, e2.nama_e2,sk.deskripsi as saskeg_deskripsi from anev_ikk f inner join anev_eselon2 e2 on f.kode_e2=e2.kode_e2 and f.tahun between left(e2.tahun_renstra,4) and right(e2.tahun_renstra,4) left join anev_sasaran_kegiatan sk  on f.kode_sk_e2 = sk.kode_sk_e2 and f.tahun = sk.tahun".$where;
		$sql .= " order by f.tahun desc, f.kode_ikk";
		return $this->mgeneral->run_sql($sql);
	}
	
	//utk laporan renstra
	function get_renstra($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_ss_e2'])) $where .= " and f.kode_ss_e2='".$params['kode_ss_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select distinct kode_ikk, deskripsi from anev_iku_e2 f inner join anev_e2 kl on f.kode_e2=kl.kode_e2 ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	

}
