<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-15 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Sasaran_strategis_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and f.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_sasaran_kl'])) $where .= " and f.kode_sasaran_kl='".$params['kode_sasaran_kl']."'";
			
			if (isset($params['tahun'])) $where .= " and f.tahun = ".$params['tahun'];
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		#$sql = "select f.*, kl.nama_kl, skl.sasaran_kl from anev_sasaran_strategis f inner join anev_kl kl on f.kode_kl=kl.kode_kl and f.tahun between left(kl.tahun_renstra,4) and right(kl.tahun_renstra,4) left join anev_sasaran_kl skl on f.kode_sasaran_kl = skl.kode_sasaran_kl and f.tahun between left(skl.tahun_renstra,4) and right(skl.tahun_renstra,4) ".$where;
		$sql = "select f.*, kl.nama_kl from anev_sasaran_strategis f inner join anev_kl kl on f.kode_kl=kl.kode_kl and f.tahun between left(kl.tahun_renstra,4) and right(kl.tahun_renstra,4) ".$where;
		$sql .= "group by f.kode_ss_kl order by f.tahun desc, f.kode_ss_kl";
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_list($params) {
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_sasaran_kl'])) $where .= " and kode_sasaran_kl='".$params['kode_sasaran_kl']."'";
			if (isset($params['tahun'])) $where .= " and tahun = ".$params['tahun'];
			if (isset($params['tahun_renstra'])) $where .= " and tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select distinct distinct kode_ss_kl, deskripsi from anev_sasaran_strategis ".$where;
		//$this->db->escape($tahun_renstra);
		$result = $this->mgeneral->run_sql($sql);
		$list[0] = 'Pilih Sasaran Strategis';
		if (isset($result)){
			foreach ($result as $i) {
				$list[$i->kode_ss_kl] = $i->deskripsi;
			}
		}
		return $list;	
	}
	
	function get_renstra($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and f.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_sasaran_kl'])) $where .= " and f.kode_sasaran_kl='".$params['kode_sasaran_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select distinct kode_ss_kl, deskripsi from anev_sasaran_strategis f ".$where;
		return $this->mgeneral->run_sql($sql);
	}

}

