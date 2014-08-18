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
			if (isset($params['kode_kl'])) $where .= " and kl.kode_kl='".$params['kode_kl']."'";
		}
		$sql = "select kl.* from anev_kl kl ".$where;
		return $this->mgeneral->run_sql($sql);
	}

}

