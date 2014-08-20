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
	
	function get_tahun_sasaran_strategis($kode){
		
		$sql = "SELECT distinct(tahun) FROM anev_sasaran_strategis WHERE kode_kl = '$kode'";
		$data= $this->mgeneral->run_sql($sql);
		$list[] = 'Pilih tahun';
		foreach ($data as $d) {
			$list[] = $d->tahun;
		}
		return $list;
	}
	
	function get_tahun_sasaran_program($kode)
	{
		$sql = "SELECT distinct(tahun) FROM anev_sasaran_program WHERE kode_e1 = '$kode'";
		$data= $this->mgeneral->run_sql($sql);
		$list[] = 'Pilih tahun';
		foreach ($data as $d):
			$list[] = $d->tahun;
		endforeach;
		
		return $list;
	}

	function get_sasaran_strategis($kode,$tahun)
	{
		$data	= $this->mgeneral->getWhere(array('kode_kl'=>$kode,'tahun'=>$tahun),"anev_sasaran_strategis");
		$list[]	= array('kode'=>"","deskripsi"=>"Pilih Sasaran");
		foreach($data as $d):
			$list[] = array('kode'=>$d->kode_ss_kl,'deskripsi'=>"- ".$d->deskripsi);
		endforeach;
		
		return $list;
	}
	
	function get_sasaran_program($kode,$tahun)
	{
		$data	= $this->mgeneral->getWhere(array('kode_e1'=>$kode,'tahun'=>$tahun),"anev_sasaran_program");
		$list[]	= array('kode'=>"","deskripsi"=>"Pilih Sasaran");
		foreach($data as $d):
			$list[] = array('kode'=>$d->kode_sp_e1,'deskripsi'=>"- ".$d->deskripsi);
		endforeach;
		
		return $list;
	}
	
	function get_iku_kl($kode,$tahun,$sasaran)
	{
		$data	= $this->mgeneral->getWhere(array('kode_kl'=>$kode,'tahun'=>$tahun,'kode_ss_kl'=>$sasaran),"anev_iku_kl");
		$list[]	= array('kode'=>"","deskripsi"=>"Pilih Indikator","satuan"=>"");
		foreach($data as $d):
			$list[] = array('kode'=>$d->kode_iku_kl,'deskripsi'=>"- ".$d->deskripsi);
		endforeach;
		
		return $list;
	}
	
	function get_iku_e1($kode,$tahun,$sasaran)
	{
		$data	= $this->mgeneral->getWhere(array('kode_e1'=>$kode,'tahun'=>$tahun,'kode_sp_e1'=>$sasaran),"anev_iku_eselon1");
		$list[]	= array('kode'=>"","deskripsi"=>"Pilih Indikator","satuan"=>"");
		foreach($data as $d):
			$list[] = array('kode'=>$d->kode_iku_e1,'deskripsi'=>"- ".$d->deskripsi);
		endforeach;
		
		return $list;
	}
}

