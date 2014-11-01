<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-22 23:30
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
			if (isset($params['kode_e1'])) $where .= " and f.kode_e1='".$params['kode_e1']."'";
			if (isset($params['tahun'])) $where .= "and f.tahun = ".$params['tahun'];
			if (isset($params['tahun_renstra'])) {$tahun = explode("-",$params['tahun_renstra']); $where .= "and f.tahun between '".$tahun[0]."' and '".$tahun[1]."'";}
		}
		$sql = "select f.*, e1.nama_e1 from anev_program_eselon1 f inner join anev_eselon1 e1 on e1.kode_e1=f.kode_e1 ".$where;
		$sql .= "  GROUP BY f.kode_program order by f.tahun desc, f.kode_program";
		//echo $sql;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_pendanaan($params)
	{
		$where = ' where 1=1 ';
		$where2 = ' where kode_program = a.kode_program ';
		
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and a.kode_e1='".$params['kode_e1']."'";
			if (isset($params['tahun'])) $where .= "and a.tahun = ".$params['tahun'];
			if (isset($params['tahun_renstra'])) {$tahun = explode("-",$params['tahun_renstra']); $where .= "and a.tahun between '".$tahun[0]."' and '".$tahun[1]."'"; $where2 .= "and a.tahun between '".$tahun[0]."' and '".$tahun[1]."'";}
		}
		$sql = "SELECT a.*,(SELECT sum(pagu) as total  FROM anev_program_eselon1 ".$where2.") as total FROM anev_program_eselon1 a ".$where." group by kode_program";
		//echo $sql;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_pendanaan2($params)
	{
		$where = " where a.tahun_renstra = '".$params['tahun_renstra']."'";
		
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and a.kode_e1='".$params['kode_e1']."'";
		}
		$sql = "SELECT * FROM anev_pendanaan_program a inner join anev_program_eselon1 b ON a.kode_program = b.kode_program ".$where." group by a.kode_program";
		//echo $sql;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_list($params) {
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['tahun'])) $where .= "and tahun = ".$params['tahun'];
			if (isset($params['tahun_renstra'])) $where .= " and tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql = "select distinct distinct kode_program, nama_program from anev_program_eselon1 ".$where;
		//$this->db->escape($tahun_renstra);
		$result = $this->mgeneral->run_sql($sql);
		$list[0] = 'Pilih Program';
		if (isset($params['isNotMandatory'])) $list[0] = 'Semua Program';
		if (isset($result)){
			foreach ($result as $i) {
				$list[$i->kode_program] = $i->nama_program;
			}
		}
		return $list;	
	}
	
	
	function get_where($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_program'])) $where .= " and f.kode_program='".$params['kode_program']."'";
			if (isset($params['tahun_renstra'])) $tahun = explode("-",$params['tahun_renstra']); $where .= "and f.tahun between '".$tahun[0]."' and '".$tahun[1]."'";
		}
		$sql = "select f.*, e1.nama_e1 from anev_program_eselon1 f inner join anev_eselon1 e1 on e1.kode_e1=f.kode_e1 ".$where;
		$sql .= " order by f.tahun desc, f.kode_program";
		#echo $sql;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_program_list($tahun_awal, $tahun_akhir,$e1) {
		$where = '';
		if ($e1!=0) $where = " and kode_e1 = '".$e1."'";
		$sql = "select distinct kode_sp_e1, deskripsi from anev_sasaran_program where tahun<=$tahun_akhir and tahun>=$tahun_awal ".$where;
		$result = $this->mgeneral->run_sql($sql);
		$list[0] = 'Pilih Sasaran Strategis';
		foreach ($result as $i) {
			$list[$i->kode_sp_e1] = $i->deskripsi;
		}
		return $list;	
	}

}

