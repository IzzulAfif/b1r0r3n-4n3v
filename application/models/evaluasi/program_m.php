<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Faizal
 @date       : 2014-08-15 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class program_m extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	/*
	get data tahun_renstra dari anev_eselon1
	*/
	function get_renstra_list() {
		$sql = "select distinct tahun_renstra from anev_eselon1";
		$result = $this->mgeneral->run_sql($sql);
		$list[0] = 'Pilih tahun';
		foreach ($result as $i) {
			$list[$i->tahun_renstra] = $i->tahun_renstra;
		}
		return $list;
	}

	function get_program_list($tahun_awal, $tahun_akhir) {
		$sql = "select distinct kode_program, nama_program from anev_program_eselon1 where tahun<=$tahun_akhir and tahun>=$tahun_awal";
		$result = $this->mgeneral->run_sql($sql);
		$list[0] = 'Pilih program';
		foreach ($result as $i) {
			$list[$i->kode_program] = $i->nama_program;
		}
		return $list;	
	}

	function get_pelaksana_program($kode_program) {
		$sql = "select p.kode_e1, nama_e1 from anev_program_eselon1 p inner join anev_eselon1 
			e on p.kode_e1=e.kode_e1 where p.kode_program=".$this->db->escape($kode_program);
		$result = $this->mgeneral->run_sql($sql);
		return $result[0];	
	}

	function get_kegiatan_program($kode_program) {
		$sql = "select p.kode_e1, kode_kegiatan, nama_kegiatan from anev_program_eselon1 p 
			inner join anev_kegiatan_eselon2 k on k.kode_program=p.kode_program where p.kode_program=".$this->db->escape($kode_program);
		$result = $this->mgeneral->run_sql($sql);
		foreach ($result as $i) {
			$list[$i->kode_kegiatan] = $i->nama_kegiatan;
		}
		return $list;	
	}
	
	function get_pelaksana_kegiatan($kode_kegiatan)
	{
		$sql = "select k.kode_e2, nama_e2 from anev_kegiatan_eselon2 k inner join anev_eselon2
			e on k.kode_e2=e.kode_e2 where k.kode_kegiatan=".$this->db->escape($kode_kegiatan);
		$result = $this->mgeneral->run_sql($sql);
		return $result[0];
	}
	
	function get_output_kegiatan($kode_kegiatan)
	{
		$sql = "select * from anev_output where kode_kegiatan=".$this->db->escape($kode_kegiatan);
		$result = $this->mgeneral->run_sql($sql);
		foreach ($result as $i) {
			$list[$i->kdoutput] = $i->nmoutput;
		}
		return $list;
	}
	
	function get_realisasi_program($kode_program, $tahun_awal, $tahun_akhir) {
		$sql = "select * from anev_program_eselon1 where tahun<=".$this->db->escape($tahun_akhir)." and tahun>=".$this->db->escape($tahun_awal)
			." and kode_program=".$this->db->escape($kode_program)." order by tahun asc";
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_realisasi_kegiatan($kode_kegiatan, $tahun_awal, $tahun_akhir) {
		$sql = "select * from anev_kegiatan_eselon2 where tahun<=".$this->db->escape($tahun_akhir)." and tahun>=".$this->db->escape($tahun_awal)
			." and kode_kegiatan=".$this->db->escape($kode_kegiatan)." order by tahun asc";
		return $this->mgeneral->run_sql($sql);
	}

	function get_capaian_kinerja($kode_e1, $tahun_awal, $tahun_akhir) {
		$sql = "select s.kode_e1, s.tahun, s.kode_sp_e1, i.kode_iku_e1, s.deskripsi, i.deskripsi indikator, i.satuan, k.target, k.realisasi, k.persen
			from anev_sasaran_program s inner join anev_iku_eselon1 i on s.tahun=i.tahun  inner join anev_kinerja_eselon1 k on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_sp_e1=s.kode_sp_e1 and k.kode_iku_e1=i.kode_iku_e1)
 			where k.tahun<=".$this->db->escape($tahun_akhir)." and k.tahun>=".$this->db->escape($tahun_awal)
 			." and k.kode_e1=".$this->db->escape($kode_e1)." order by s.kode_e1 asc, i.kode_iku_e1 asc, k.tahun asc";
 		return $this->mgeneral->run_sql($sql);	
	}
	
	function get_capaian_kinerja2($kode_e2, $tahun_awal, $tahun_akhir) {
		$sql = "select s.kode_e2, s.tahun, s.kode_sk_e2, i.kode_ikk, s.deskripsi, i.deskripsi indikator, i.satuan, k.target, k.realisasi, k.persen
			from anev_sasaran_kegiatan s inner join anev_ikk i on s.tahun=i.tahun  inner join anev_kinerja_eselon2 k on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_sk_e2=s.kode_sk_e2 and k.kode_ikk=i.kode_ikk)
 			where k.tahun<=".$this->db->escape($tahun_akhir)." and k.tahun>=".$this->db->escape($tahun_awal)
 			." and k.kode_e2=".$this->db->escape($kode_e2)." order by s.kode_e2 asc, i.kode_ikk asc, k.tahun asc";
 		return $this->mgeneral->run_sql($sql);	
	}
	
	function get_rata2_capain_kinerja($kode_e1, $tahun_awal, $tahun_akhir)
	{
		if($kode_e1!=""):
			$where = " and k.kode_e1='$kode_e1'";
		else:
			$where = "";
		endif;
		
		$sql = "select s.tahun, avg(k.persen) as persen from anev_sasaran_program s inner join anev_iku_eselon1 i on s.tahun=i.tahun  inner join anev_kinerja_eselon1 k on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_sp_e1=s.kode_sp_e1 and k.kode_iku_e1=i.kode_iku_e1) where k.tahun <='$tahun_akhir' and k.tahun>='$tahun_awal' ".$where." group by s.tahun asc";
		
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_rata2_serapan_anggaran2($kode_e1, $tahun_awal, $tahun_akhir)
	{
		if($kode_e1!=""):
			$where = "and kode_e1=".$this->db->escape($kode_e1);
		else:
			$where = "";
		endif;
		
		$sql = "select tahun,avg(persen) as persen from anev_program_eselon1 where tahun<=".$this->db->escape($tahun_akhir)." and tahun>=".$this->db->escape($tahun_awal)
			." ".$where." group by tahun order by tahun asc";
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_rata2_serapan_anggaran($kode_program, $tahun_awal, $tahun_akhir)
	{
		if($kode_program!=""):
			$where = "and kode_program=".$this->db->escape($kode_program);
		else:
			$where = "";
		endif;
		
		$sql = "select tahun,persen from anev_program_eselon1 where tahun<=".$this->db->escape($tahun_akhir)." and tahun>=".$this->db->escape($tahun_awal)
			." ".$where." order by tahun asc";
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_rata2_capain_kinerja_e2($kode_e2, $tahun_awal, $tahun_akhir)
	{
		if($kode_e2!=""):
			$where = " and k.kode_e2='$kode_e2'";
		else:
			$where = "";
		endif;
		
		$sql = "select s.tahun, avg(k.persen) as persen from anev_sasaran_kegiatan s inner join anev_ikk i on s.tahun=i.tahun  inner join anev_kinerja_eselon2 k on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_sk_e2=s.kode_sk_e2 and k.kode_ikk=i.kode_ikk) where k.tahun <='$tahun_akhir' and k.tahun>='$tahun_awal' ".$where." group by s.tahun asc";
		
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_rata2_serapan_anggaran_e2($kode_kegiatan, $tahun_awal, $tahun_akhir)
	{
		if($kode_kegiatan!=""):
			$where = "and kode_kegiatan=".$this->db->escape($kode_kegiatan);
		else:
			$where = "";
		endif;
		
		$sql = "select tahun,((realisasi/pagu)*100) as persen from anev_kegiatan_eselon2 where tahun<=".$this->db->escape($tahun_akhir)." and tahun>=".$this->db->escape($tahun_awal)
			." ".$where." order by tahun asc";
		return $this->mgeneral->run_sql($sql);
	}
}

