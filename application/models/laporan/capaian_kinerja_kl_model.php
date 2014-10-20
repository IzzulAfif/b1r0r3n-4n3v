<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-09-04
 @fungsi	 : 
 @revision	 :
*/
	

class Capaian_kinerja_kl_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_capaian_kinerja($kode_sasaran_kl, $tahun_awal, $tahun_akhir) {
		$sql = "select s.kode_kl, s.tahun, s.kode_ss_kl, i.kode_iku_kl, s.deskripsi, i.deskripsi indikator, i.satuan, k.target, k.realisasi, k.persen 
			from anev_sasaran_strategis s inner join anev_iku_kl i on s.tahun=i.tahun inner join anev_kinerja_kl k 
			on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_ss_kl=s.kode_ss_kl and k.kode_iku_kl=i.kode_iku_kl) 
 			where k.tahun<=".$this->db->escape($tahun_akhir)." and k.tahun>=".$this->db->escape($tahun_awal)
 			." and s.kode_sasaran_kl=".$this->db->escape($kode_sasaran_kl)." order by i.kode_iku_kl asc, k.tahun asc";
 		return $this->mgeneral->run_sql($sql);	
	}
	
	function get_sasaran_kl($params){
	
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ='select distinct skl.tahun_renstra,skl.sasaran_kl as deskripsi,skl.kode_sasaran_kl
from anev_sasaran_kl skl left join anev_sasaran_strategis ss on ss.kode_sasaran_kl = skl.kode_sasaran_kl
and ss.tahun between left(skl.tahun_renstra,4) and right(skl.tahun_renstra,4)
left join anev_iku_kl iku on iku.tahun=ss.tahun and iku.kode_ss_kl = ss.kode_ss_kl
left join anev_kinerja_kl kinerja on kinerja.tahun = ss.tahun and kinerja.kode_ss_kl=ss.kode_ss_kl and kinerja.kode_iku_kl = iku.kode_iku_kl '.$where;
		$sql .= 'order by iku.kode_iku_kl';
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_sasaran_strategis($params){
	
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_sasaran_kl'])) $where .= " and skl.kode_sasaran_kl='".$params['kode_sasaran_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ='select distinct skl.tahun_renstra,skl.sasaran_kl,ss.deskripsi,ss.kode_ss_kl
from anev_sasaran_kl skl left join anev_sasaran_strategis ss on ss.kode_sasaran_kl = skl.kode_sasaran_kl
and ss.tahun between left(skl.tahun_renstra,4) and right(skl.tahun_renstra,4)
left join anev_iku_kl iku on iku.tahun=ss.tahun and iku.kode_ss_kl = ss.kode_ss_kl
left join anev_kinerja_kl kinerja on kinerja.tahun = ss.tahun and kinerja.kode_ss_kl=ss.kode_ss_kl and kinerja.kode_iku_kl = iku.kode_iku_kl '.$where;
		$sql .= 'order by iku.kode_iku_kl';
		return $this->mgeneral->run_sql($sql);
	}
	
	
	function get_capaian($params){
	
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ='select distinct skl.tahun_renstra,skl.sasaran_kl,ss.deskripsi as sastra,iku.deskripsi , ss.tahun, kinerja.realisasi,kinerja.target, iku.kode_iku_kl, ss.kode_ss_kl, skl.kode_sasaran_kl
from anev_sasaran_kl skl left join anev_sasaran_strategis ss on ss.kode_sasaran_kl = skl.kode_sasaran_kl
and ss.tahun between left(skl.tahun_renstra,4) and right(skl.tahun_renstra,4)
left join anev_iku_kl iku on iku.tahun=ss.tahun and iku.kode_ss_kl = ss.kode_ss_kl
left join anev_kinerja_kl kinerja on kinerja.tahun = ss.tahun and kinerja.kode_ss_kl=ss.kode_ss_kl and kinerja.kode_iku_kl = iku.kode_iku_kl '.$where;
		$sql .= 'order by iku.kode_iku_kl';
		return $this->mgeneral->run_sql($sql);
	}
	
	
	
	function get_indikator($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and f.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and f.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, kl.nama_kl, kinerja.target,kinerja.realisasi from anev_iku_kl f inner join anev_kl kl on f.kode_kl=kl.kode_kl left join anev_kinerja_kl kinerja on kinerja.tahun=f.tahun and kinerja.kode_kl = f.kode_kl and kinerja.kode_iku_kl = f.kode_iku_kl and kinerja.kode_ss_kl = f.kode_ss_kl ".$where;
		$sql .= " order by f.kode_iku_kl, kinerja.tahun ";
		return $this->mgeneral->run_sql($sql);
	
	}

}

