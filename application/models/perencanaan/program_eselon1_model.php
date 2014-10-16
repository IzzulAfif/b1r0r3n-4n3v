<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-18 11:30
 @fungsi	 : 
 @revision	 :
*/
	

class Program_eselon1_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and f.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_sasaran_kl'])) $where .= " and f.kode_sasaran_kl='".$params['kode_sasaran_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select f.*, kl.nama_kl from anev_sasaran_strategis f inner join anev_kl kl on f.kode_kl=kl.kode_kl  and e1.tahun_renstra = f.tahun_renstra ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_jml_program($params){		
		$rs = $this->mgeneral->run_sql('select count(distinct nama_program) as jml_program from anev_program_eselon1 where '.$params);
		//var_dump($rs);
		return $rs[0]->jml_program;
		//$this->mgeneral->getValue('count(kode_e1)', $params, 'anev_program_eselon1');
	}
	
	function get_renstra($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and f.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_kl'])) $where .= " and f.kode_e1 in (select kode_e1 from anev_eselon1 where kode_kl = '".$params['kode_kl']."' and tahun_renstra = '".$params['tahun_renstra']."')";
			//if (isset($params['kode_sasaran_kl'])) $where .= " and f.kode_sasaran_kl='".$params['kode_sasaran_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select distinct kode_program, nama_program,e.nama_e1,f.kode_e1 from anev_program_eselon1 f inner join anev_eselon1 e on f.kode_e1=e.kode_e1 and f.tahun between left(e.tahun_renstra,4) and right(e.tahun_renstra,4) ".$where;
		return $this->mgeneral->run_sql($sql);
	}

}

