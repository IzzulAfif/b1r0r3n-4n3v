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
		$list[] = 'Tahun';
		foreach ($data as $d) {
			$list[] = $d->tahun;
		}
		return $list;
	}
	
	function get_renstra_sasaran_program($kode){
		
		$sql = "SELECT distinct(tahun_renstra) as tahun FROM anev_eselon1 WHERE 1 = 1";
		$data= $this->mgeneral->run_sql($sql);
		$list[] = 'Tahun';
		foreach ($data as $d) {
			$list[] = $d->tahun;
		}
		return $list;
	}
	
	function get_tahun_sasaran_strategis($kode,$renstra){
		$thn_renstra = explode("-",$renstra);
		$list[] = 'Tahun';
		for($a=$thn_renstra[0]; $a<=$thn_renstra[1]; $a++) {
			$list[] = $a;
		}
		return $list;
	}
	
	function get_tahun_sasaran_program($kode,$renstra)
	{
		$thn_renstra = explode("-",$renstra);
		$list[] = 'Tahun';
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
}