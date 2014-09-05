<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-09-04
 @fungsi	 : 
 @revision	 :
*/
	

class Capaian_kinerja_e1_model extends CI_Model
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
	
	
	function get_indikator($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_ss_kl'])) $where .= " and sp.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['kode_sp_e1'])) $where .= " and sp.kode_sp_e1='".$params['kode_sp_e1']."'";
			if (isset($params['range_awal'])) $where .= " and kinerja.tahun between ".$params['range_awal']." and ".$params['range_akhir'];
		}
		$sql = "select kinerja.tahun,kinerja.kode_iku_e1,iku.deskripsi, iku.satuan,kinerja.target,kinerja.realisasi, kinerja.persen from anev_kinerja_eselon1 kinerja inner join anev_iku_eselon1 iku on kinerja.kode_iku_e1 = iku.kode_iku_e1 and kinerja.tahun = iku.tahun	inner join anev_sasaran_program sp on sp.kode_sp_e1 = iku.kode_sp_e1 and sp.tahun = iku.tahun	inner join anev_sasaran_strategis ss on sp.kode_ss_kl = ss.kode_ss_kl and sp.tahun = ss.tahun ".$where;
		$sql .= " order by kinerja.kode_iku_e1, kinerja.tahun ";
		return $this->mgeneral->run_sql($sql);
	
	}

}

