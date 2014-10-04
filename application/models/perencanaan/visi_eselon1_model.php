<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-15 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Visi_eselon1_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and f.kode_e1='".$params['kode_e1']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select 	f.tahun_renstra, f.kode_e1, f.kode_visi_e1, f.visi_e1 , e1.nama_e1 from anev_visi_eselon1 f inner join anev_eselon1 e1 on e1.kode_e1=f.kode_e1 and e1.tahun_renstra = f.tahun_renstra ".$where;
	
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_jml_visi($params){		
		return $this->mgeneral->getValue('count(kode_e1)', $params, 'anev_visi_eselon1');
	}
	
	function get_where($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_visi_e1'])) $where .= " and f.kode_visi_e1='".$params['kode_visi_e1']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select f.*, e1.nama_e1 from anev_visi_eselon1 f inner join anev_eselon1 e1 on e1.kode_e1=f.kode_e1 ".$where;
	
		return $this->mgeneral->run_sql($sql);
	}

}

