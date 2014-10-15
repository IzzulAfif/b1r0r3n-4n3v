<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Faizal
 @date       : 2014-08-15 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class sasaran_strategis_m extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_renstra_list() {
		$sql = "select distinct tahun from anev_sasaran_strategis";
		$result = $this->mgeneral->run_sql($sql);
		$list[0] = 'Pilih tahun';
		foreach ($result as $i) {
			$list[$i->tahun] = $i->tahun;
		}
		return $list;
	}

	function get_sasaran_list($tahun_renstra) {
		$sql = "select distinct kode_ss_kl, deskripsi from anev_sasaran_strategis where 1=1";
		$result = $this->mgeneral->run_sql($sql);
		$list[0] = 'Pilih sasaran strategis';
		foreach ($result as $i) {
			$list[$i->kode_ss_kl] = $i->deskripsi;
		}
		return $list;	
	}

	function get_capaian_kinerja($kode_sasaran_kl, $tahun_awal, $tahun_akhir) {
		if($kode_sasaran_kl=="0"): 
			$where = ""; 
		else: 
			$where = " and s.kode_ss_kl=".$this->db->escape($kode_sasaran_kl)." "; 
		endif;
		
		$sql = "select s.kode_kl, s.tahun, s.kode_ss_kl, i.kode_iku_kl, s.deskripsi, i.deskripsi indikator, i.satuan, k.target, k.realisasi, k.persen 
			from anev_sasaran_strategis s inner join anev_iku_kl i on s.tahun=i.tahun inner join anev_kinerja_kl k 
			on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_ss_kl=s.kode_ss_kl and k.kode_iku_kl=i.kode_iku_kl) 
 			where k.tahun<=".$this->db->escape($tahun_akhir)." and k.tahun>=".$this->db->escape($tahun_awal)
 			." ".$where."order by i.kode_iku_kl asc, k.tahun asc";
 		return $this->mgeneral->run_sql($sql);	
	}

	function get_detail_capaian_kinerja($kode_iku_kl, $tahun_awal, $tahun_akhir, $kode_ss_kl) {
		$sql = "select s.kode_e1, s.kode_ss_kl, i.kode_iku_kl, s.tahun, s.kode_sp_e1, i.kode_iku_e1, s.deskripsi, i.deskripsi indikator, i.satuan, k.target, k.realisasi, k.persen
			from anev_sasaran_program s inner join anev_iku_eselon1 i on s.tahun=i.tahun inner join anev_kinerja_eselon1 k on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_sp_e1=s.kode_sp_e1 and k.kode_iku_e1=i.kode_iku_e1)
 			where k.tahun<=".$this->db->escape($tahun_akhir)." and k.tahun>=".$this->db->escape($tahun_awal)
 			." and i.kode_iku_kl=".$this->db->escape($kode_iku_kl)."and s.kode_ss_kl=".$this->db->escape($kode_ss_kl)
 			." order by i.kode_iku_e1 asc, k.tahun asc";
 		return $this->mgeneral->run_sql($sql);	
	}
}

