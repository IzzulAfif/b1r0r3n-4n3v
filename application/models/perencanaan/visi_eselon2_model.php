<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-22 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Visi_eselon2_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and e2.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and e2.kode_e2='".$params['kode_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and e2.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select f.*, e2.nama_e2  from anev_eselon2 e2 inner join  anev_visi_eselon2 f on e2.kode_e2=f.kode_e2 and e2.tahun_renstra = f.tahun_renstra ".$where." ORDER BY f.kode_e2,f.kode_visi_e2 ASC";
	
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_jml_visi($params){		
		return $this->mgeneral->getValue('count(kode_e2)', $params, 'anev_visi_eselon2');
	}
	
	function get_where($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_visi_e2'])) $where .= " and f.kode_visi_e2='".$params['kode_visi_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select f.*, e2.nama_e2,e1.kode_e1,e1.nama_e1 from anev_visi_eselon2 f inner join anev_eselon2 e2 on e2.kode_e2=f.kode_e2 inner join anev_eselon1 e1 on e2.kode_e1 = e1.kode_e1 and e2.tahun_renstra = f.tahun_renstra ".$where;
		return $this->mgeneral->run_sql($sql);
	}

}

