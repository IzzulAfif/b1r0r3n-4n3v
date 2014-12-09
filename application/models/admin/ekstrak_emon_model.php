<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-29 00:00
 @fungsi	 : 
 @revision	 :
*/
	

class Ekstrak_emon_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	 
	
	function get_list() {
		$where = ' where hide=0 ';
		if (isset($params)){
			//if (isset($params['kode_e1'])) $where .= " and kode_e1='".$params['kode_e1']."'";
		}
		$sql = "select distinct id,jenis_data from anev_webservice where tipe_aplikasi = 'E-Monitoring' and hide=0 order by urutan asc ";
		
		
		$result = $this->mgeneral->run_sql($sql);
		
		$list[0] = 'Pilih Jenis Data';
		if (isset($result))
			foreach ($result as $i) {
				$list[$i->id] = $i->jenis_data;
			}
		return $list;
	}
	
	

}

