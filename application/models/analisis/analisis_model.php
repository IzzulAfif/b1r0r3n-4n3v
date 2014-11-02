<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : didin
 @date       : 2014-08-20 13:00
 @fungsi	 : 
 @revision	 : 
*/
	

class analisis_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_renstra_sasaran_strategis($kode){
		
		$sql = "SELECT distinct(tahun_renstra) as tahun FROM anev_kl WHERE 1 = 1";
		$data= $this->mgeneral->run_sql($sql);
		$list[] = 'Pilih Periode Renstra';
		foreach ($data as $d) {
			$list[] = $d->tahun;
		}
		return $list;
	}
	
	function get_renstra_sasaran_program($kode){
		
		$sql = "SELECT distinct(tahun_renstra) as tahun FROM anev_eselon1 WHERE 1 = 1";
		$data= $this->mgeneral->run_sql($sql);
		$list[] = 'Pilih Periode Renstra';
		foreach ($data as $d) {
			$list[] = $d->tahun;
		}
		return $list;
	}
	
	function get_tahun_sasaran_strategis($kode,$renstra){
		$thn_renstra = explode("-",$renstra);
		$list[] = 'Pilih Tahun';
		for($a=$thn_renstra[0]; $a<=$thn_renstra[1]; $a++) {
			$list[] = $a;
		}
		return $list;
	}
	
	function get_tahun_sasaran_program($kode,$renstra)
	{
		$thn_renstra = explode("-",$renstra);
		$list[] = 'Pilih Tahun';
		for($a=$thn_renstra[0]; $a<=$thn_renstra[1]; $a++) {
			$list[] = $a;
		}
		return $list;
	}

	function get_sasaran_strategis()
	{
		$sql = "select * from anev_sasaran_strategis group by kode_ss_kl";
		$data= $this->mgeneral->run_sql($sql);
		$list[]	= array('kode'=>"","deskripsi"=>"Pilih Sasaran");
		foreach ($data as $d) {
			$list[] = array('kode'=>$d->kode_ss_kl,'deskripsi'=>"- ".$d->deskripsi);
		}
		return $list;
	}
	
	function get_sasaran_program($kode)
	{
		$sql = "select * from anev_sasaran_program where kode_e1 = '$kode' group by kode_sp_e1";
		$data= $this->mgeneral->run_sql($sql);
		$list[]	= array('kode'=>"","deskripsi"=>"Pilih Sasaran");
		foreach ($data as $d) {
			$list[] = array('kode'=>$d->kode_sp_e1,'deskripsi'=>"- ".$d->deskripsi);
		}
		return $list;
	}
	
	function get_iku_kl($kode,$sasaran)
	{
		$sql = "SELECT * FROM `anev_iku_kl` WHERE kode_ss_kl = '$sasaran' and kode_kl = '$kode' group by `kode_iku_kl`";
		$data= $this->mgeneral->run_sql($sql);
		$list[]	= array('kode'=>"","deskripsi"=>"Pilih Indikator");
		foreach($data as $d):
			$list[] = array('kode'=>$d->kode_iku_kl,'deskripsi'=>"- ".$d->deskripsi);
		endforeach;
		
		return $list;
	}
	
	function get_iku_e1($kode,$sasaran)
	{
		$sql = "SELECT * FROM `anev_iku_eselon1` WHERE kode_sp_e1 = '$sasaran' and kode_e1 = '$kode' group by `kode_iku_e1`";
		$data= $this->mgeneral->run_sql($sql);
		$list[]	= array('kode'=>"","deskripsi"=>"Pilih Indikator","satuan"=>"");
		foreach($data as $d):
			$list[] = array('kode'=>$d->kode_iku_e1,'deskripsi'=>"- ".$d->deskripsi);
		endforeach;
		
		return $list;
	}
	
	function get_program($tahun)
	{
		$data = $this->mgeneral->getWhere(array('tahun'=>$tahun),"anev_program_eselon1");
		$list[]	= array('kode_program'=>"","nama_program"=>"Pilih Program");
		foreach($data as $d):
			$list[] = array('kode_program'=>$d->kode_program,'nama_program'=>"- ".$d->nama_program);
		endforeach;
		
		return $list;
	}
	
	function get_kegiatan($tahun,$program)
	{
		$data = $this->mgeneral->getWhere(array('tahun'=>$tahun,'kode_program'=>$program),"anev_kegiatan_eselon2");
		$list[]	= array('kode_kegiatan'=>"","nama_kegiatan"=>"Pilih Kegiatan");
		foreach($data as $d):
			$list[] = array('kode_kegiatan'=>$d->kode_kegiatan,'nama_kegiatan'=>"- ".$d->nama_kegiatan);
		endforeach;
		
		return $list;
	}
	
	//yusup
	function get_rincian_paket_pekerjaan($params){
		$sql = 'select i.nmitem, i.volkeg, i.satkeg, kk.nama_kabkota
from anev_item_satker i left join anev_kabkota kk on i.kdkabkota = kk.kdkabkota
limit 0,50';
	
	}
	
	function get_detail_capaian_kinerja($kode_e1,$kode_iku_kl, $tahun_awal, $tahun_akhir, $kode_ss_kl) {
		$sql = "select es1.singkatan,s.tahun,k.target, k.realisasi, k.persen,k.kode_sp_e1,k.kode_iku_e1,i.deskripsi as nama_iku
				from anev_sasaran_program s inner join anev_iku_eselon1 i on s.tahun=i.tahun 
				inner join anev_kinerja_eselon1 k on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_sp_e1=s.kode_sp_e1 and k.kode_iku_e1=i.kode_iku_e1)
				inner join anev_eselon1 es1 on s.kode_e1 = es1.kode_e1
 				where s.kode_e1 = $kode_e1 AND k.tahun<=".$this->db->escape($tahun_akhir)." and k.tahun>=".$this->db->escape($tahun_awal)
 				." and i.kode_iku_kl=".$this->db->escape($kode_iku_kl)." and s.kode_ss_kl=".$this->db->escape($kode_ss_kl)
 				." order by i.kode_iku_e1 asc, k.tahun asc";
 		return $this->mgeneral->run_sql($sql);	
	}
	
	function get_detail_capaian_kinerja2($kode_e2,$kode_iku_e1, $tahun_awal, $tahun_akhir, $kode_sp_e1) {
 		$sql = "select es2.singkatan,s.tahun,k.target, k.realisasi, k.persen,k.kode_sk_e2,k.kode_ikk 
				from anev_sasaran_kegiatan s 
				inner join anev_ikk i on s.tahun=i.tahun 
				inner join anev_kinerja_eselon2 k on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_sk_e2=s.kode_sk_e2 and k.kode_ikk=i.kode_ikk) 
				inner join anev_eselon2 es2 on s.kode_e2 = es2.kode_e2 where s.kode_e2 = '$kode_e2' AND k.tahun<='$tahun_akhir' and k.tahun>='$tahun_awal' and i.kode_iku_e1='$kode_iku_e1' and s.kode_sp_e1='$kode_sp_e1' order by i.kode_ikk asc, k.tahun asc";
		return $this->mgeneral->run_sql($sql);	
	}
	
	function get_capaian_kinerja_kl($iku,$tahun1,$tahun2)
	{
		$sql = "select i.*,kl.deskripsi as nama_iku from anev_kinerja_kl i
				inner join anev_iku_kl kl on i.kode_iku_kl = kl.kode_iku_kl and i.tahun = kl.tahun
			    where i.kode_iku_kl = ".$this->db->escape($iku)." and i.tahun >= ".$this->db->escape($tahun1)." AND i.tahun <= ".$this->db->escape($tahun2)." ";
		return $this->mgeneral->run_sql($sql);	
	}
	
	function get_target_capaian_kl($iku,$renstra)
	{
		$sql = "select * from anev_target_kl where kode_iku_kl = ".$this->db->escape($iku)." and tahun_renstra = ".$this->db->escape($renstra);
		return $this->mgeneral->run_sql($sql);	
	}
	
	function get_capaian_kinerja_e1($kode_e2, $tahun_awal, $tahun_akhir,$kode_sk,$kode_ikk) {
		$sql = "select es2.singkatan,s.tahun,k.target, k.realisasi, k.persen,k.kode_sk_e2,k.kode_ikk
				from anev_sasaran_program s
				inner join anev_iku_eselon1 i on s.tahun=i.tahun
				inner join anev_ikk ik on i.kode_iku_e1=ik.kode_iku_e1 
				inner join anev_kinerja_eselon2 k on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_ikk=ik.kode_ikk)
				inner join anev_eselon2 es2 on ik.kode_e2 = es2.kode_e2
 				where ik.kode_e2 = '$kode_e2' AND i.tahun<=".$this->db->escape($tahun_akhir)." and i.tahun>=".$this->db->escape($tahun_awal)
 				." and i.kode_sp_e1=".$this->db->escape($kode_sk)." and i.kode_iku_e1=".$this->db->escape($kode_ikk)
 				." group by ik.tahun,ik.kode_ikk order by ik.kode_ikk asc, ik.tahun asc";
		#echo $sql;
 		return $this->mgeneral->run_sql($sql);	 
	}
	
}