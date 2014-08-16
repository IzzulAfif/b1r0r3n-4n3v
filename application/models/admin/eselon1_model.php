<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-15 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Eselon1_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and e1.kode_kl='".$params['kode_kl']."'";
		}
		$sql = "select e1.*, kl.nama_kl from anev_eselon1 e1 inner join anev_kl kl on e1.kode_kl=kl.kode_kl ".$where;
		return $this->mgeneral->run_sql($sql);
	}

}

