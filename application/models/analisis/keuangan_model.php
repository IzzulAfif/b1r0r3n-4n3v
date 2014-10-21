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
	
	function get_kl_keu($renstra,$tahun1,$tahun2){
		
		$sql = 'select * FROM anev_program_eselon1 pr 
				INNER JOIN anev_pendanaan_program pp ON pr.kode_program = pp.kode_program
				WHERE pr.tahun >= '.$tahun1.' AND pr.tahun <= '.$tahun2.' AND pp.tahun_renstra = "'.$renstra.'"
				group by pr.kode_program order by pr.kode_e1,pr.tahun';
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_detail_keu($tahun1,$tahun2,$kd_program)
	{
		$sql = "SELECT *  FROM anev_program_eselon1 WHERE tahun >= '".$tahun1."' AND tahun <= '".$tahun2."' AND `kode_program` LIKE '".$kd_program."'";
		return $this->mgeneral->run_sql($sql);
	}
}