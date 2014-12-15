<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-24 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Iku_eselon1_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and f.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_sp_e1'])) $where .= " and f.kode_sp_e1='".$params['kode_sp_e1']."'";
			if (isset($params['tahun'])) $where .= " and f.tahun = ".$params['tahun'];
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, e1.nama_e1,sp.deskripsi as sasprog_deskripsi from anev_iku_eselon1 f inner join anev_eselon1 e1 on f.kode_e1=e1.kode_e1 and f.tahun between left(e1.tahun_renstra,4) and right(e1.tahun_renstra,4) left join anev_sasaran_program sp  on f.kode_sp_e1 = sp.kode_sp_e1 and f.tahun = sp.tahun".$where;
		$sql .= " group by f.kode_iku_e1 order by f.tahun desc, f.kode_iku_e1";
		return $this->mgeneral->run_sql($sql);
	}
	
	//utk laporan renstra
	function get_renstra($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and f.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_sp_e1'])) $where .= " and f.kode_sp_e1='".$params['kode_sp_e1']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select distinct kode_iku_e1, deskripsi,satuan from anev_iku_eselon1 f inner join anev_eselon1 kl on f.kode_e1=kl.kode_e1 ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	

}

