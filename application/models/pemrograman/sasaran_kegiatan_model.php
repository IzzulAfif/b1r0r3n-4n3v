<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-24
 @fungsi	 : 
 @revision	 :
*/
	

class Sasaran_kegiatan_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_sp_e1'])) $where .= " and f.kode_sp_e1='".$params['kode_sp_e1']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, e2.nama_e2, sp.deskripsi as sasprog_deskripsi from anev_sasaran_kegiatan f inner join anev_eselon2 e2 on f.kode_e2=e2.kode_e2 and f.tahun between left(e2.tahun_renstra,4) and right(e2.tahun_renstra,4) left join anev_sasaran_program sp on f.kode_sp_e1 = sp.kode_sp_e1 and f.tahun= sp.tahun".$where;
		$sql .= " group by f.kode_sk_e2 order by f.tahun desc, f.kode_sk_e2";
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_renstra($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and f.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_sasaran_e1'])) $where .= " and f.kode_sasaran_e1='".$params['kode_sasaran_e1']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select distinct kode_ss_e1, deskripsi from anev_sasaran_strategis f ".$where;
		return $this->mgeneral->run_sql($sql);
	}

}

