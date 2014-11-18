<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : didin
 @date       : 2014-10-21 02:00
 @fungsi	 : 
 @revision	 : 
*/
	

class Keuangan_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_kl_keu($renstra,$tahun1,$tahun2,$es1){
		$where = "";
		if(isset($es1)) $where = " AND pr.kode_e1 ='".$es1."' ";
		$sql = 'select * FROM anev_program_eselon1 pr 
				INNER JOIN anev_pendanaan_program pp ON pr.kode_program = pp.kode_program
				WHERE pr.tahun >= '.$tahun1.' AND pr.tahun <= '.$tahun2.' AND pp.tahun_renstra = "'.$renstra.'" '.$where.'
				group by pr.kode_program order by pr.kode_e1,pr.tahun';
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_detail_keu($tahun1,$tahun2,$kd_program)
	{
		$sql = "SELECT *  FROM anev_program_eselon1 WHERE tahun >= '".$tahun1."' AND tahun <= '".$tahun2."' AND `kode_program` LIKE '".$kd_program."'";
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_es2_keu($renstra,$tahun1,$tahun2,$es2){
		$where = "";
		if(isset($es2)) $where = " AND kg.kode_e2 ='".$es2."' ";
		$sql = 'select * FROM anev_kegiatan_eselon2 kg 
				INNER JOIN anev_pendanaan_kegiatan pk ON kg.kode_kegiatan = pk.kode_kegiatan
				WHERE kg.tahun >= '.$tahun1.' AND kg.tahun <= '.$tahun2.' AND pk.tahun_renstra = "'.$renstra.'" '.$where.'
				group by kg.kode_kegiatan order by kg.kode_e2,kg.tahun';
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_detail_keu_es2($tahun1,$tahun2,$kd_kegiatan)
	{
		$sql = "SELECT *  FROM anev_kegiatan_eselon2 WHERE tahun >= '".$tahun1."' AND tahun <= '".$tahun2."' AND `kode_kegiatan` LIKE '".$kd_kegiatan."'";
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_program_e1()
	{
		$sql = "SELECT DISTINCT(kode_program), nama_program, kode_e1 FROM anev_program_eselon1 WHERE 1";
		return $this->mgeneral->run_sql($sql);
	}
}