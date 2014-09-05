<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-15 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Sasaran_program_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and f.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and f.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, e1.nama_e1, ss.deskripsi as sastra_deskripsi from anev_sasaran_program f inner join anev_eselon1 e1 on f.kode_e1=e1.kode_e1 and f.tahun between left(e1.tahun_renstra,4) and right(e1.tahun_renstra,4) left join anev_sasaran_strategis ss on f.kode_ss_kl = ss.kode_ss_kl and f.tahun= ss.tahun".$where;
		$sql .= " order by f.tahun desc, f.kode_sp_e1";
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

