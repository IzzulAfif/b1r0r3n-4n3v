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
		$sql = "select distinct tahun_renstra from anev_sasaran_kl";
		$result = $this->mgeneral->run_sql($sql);
		$list[0] = 'Pilih tahun';
		foreach ($result as $i) {
			$list[$i->tahun_renstra] = $i->tahun_renstra;
		}
		return $list;
	}

	function get_sasaran_list($tahun_renstra) {
		$sql = "select distinct kode_sasaran_kl, sasaran_kl from anev_sasaran_kl where tahun_renstra=".$this->db->escape($tahun_renstra);
		$result = $this->mgeneral->run_sql($sql);
		$list[0] = 'Pilih sasaran';
		foreach ($result as $i) {
			$list[$i->kode_sasaran_kl] = $i->sasaran_kl;
		}
		return $list;	
	}

	function get_capaian_kinerja($kode_sasaran_kl, $tahun_awal, $tahun_akhir) {
		$sql = "select s.kode_kl, s.tahun, s.kode_ss_kl, i.kode_iku_kl, s.deskripsi, i.deskripsi indikator, i.satuan, k.target, k.realisasi, k.persen 
			from anev_sasaran_strategis s inner join anev_iku_kl i on s.tahun=i.tahun inner join anev_kinerja_kl k 
			on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_ss_kl=s.kode_ss_kl and k.kode_iku_kl=i.kode_iku_kl) 
 			where k.tahun<=".$this->db->escape($tahun_akhir)." and k.tahun>=".$this->db->escape($tahun_awal)
 			." and s.kode_sasaran_kl=".$this->db->escape($kode_sasaran_kl)." order by i.kode_iku_kl asc, k.tahun asc";
 		return $this->mgeneral->run_sql($sql);	
	}

}

