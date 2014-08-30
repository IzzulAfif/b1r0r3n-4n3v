<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-17 00:00
 @fungsi	 : 
 @revision	 :
*/
	

class Kl_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
		
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['tahun_renstra'])) $where .= " and kl.tahun_renstra='".$params['tahun_renstra']."'";
			if (isset($params['kode_kl'])) $where .= " and kl.kode_kl='".$params['kode_kl']."'";
		}
		$sql = "select kl.* from anev_kl kl ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	
	function get_list($params) {
		$where = ' where 1=1 ';
		if (isset($params)){				
			if (isset($params['tahun_rensta'])) $where .= " and tahun_rensta='".$params['tahun_rensta']."'";
			
		}
		$sql = "select distinct kode_kl, nama_kl from anev_kl ".$where;
		
		
		$result = $this->mgeneral->run_sql($sql);
		
		$list[0] = 'Pilih Kementerian';
		if (isset($result))
			foreach ($result as $i) {
				$list[$i->kode_kl] = $i->nama_kl;
			}
		return $list;
	}
	
	function get_renstra(){
		
		$sql = "SELECT distinct(tahun_renstra) as tahun FROM anev_kl WHERE 1 = 1";
		$data= $this->mgeneral->run_sql($sql);
		$list[] = 'Pilih Periode Renstra';
		foreach ($data as $d) {
			$list[] = $d->tahun;
		}
		return $list;
	}
	
	function get_kementerian($tahun){
		
		$data= $this->mgeneral->getWhere(array('tahun_renstra'=>$tahun),"anev_kl");
		$list[]	= array('kode'=>"","nama"=>"Pilih Kementerian");
		foreach ($data as $d) {
			$list[] = array('kode'=>$d->kode_kl,'nama'=>$d->nama_kl);
		}
		return $list;
	}
}

