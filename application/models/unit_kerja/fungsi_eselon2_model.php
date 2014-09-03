<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-18 09:30
 @fungsi	 : 
 @revision	 :
*/
	

class Fungsi_eselon2_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and e2.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and f.kode_e2='".$params['kode_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select f.*, e2.nama_e2 from anev_fungsi_eselon2 f inner join anev_eselon2 e2 on e2.kode_e2=f.kode_e2 ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_by_id($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_fungsi_e2'])) $where .= " and f.kode_fungsi_e2='".$params['kode_fungsi_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select f.*, e2.nama_e2 from anev_fungsi_eselon2 f inner join anev_eselon2 e2 on e2.kode_e2=f.kode_e2 ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	function save($data){
		$this->mgeneral->save($data,'anev_fungsi_eselon2');
	}
	
	function update($data,$whereData){
		
		$this->mgeneral->update($whereData,$data,'anev_fungsi_eselon2');
	}
	
	function delete($whereData){		
		$this->mgeneral->delete($whereData,'anev_fungsi_eselon2');
	}
}

