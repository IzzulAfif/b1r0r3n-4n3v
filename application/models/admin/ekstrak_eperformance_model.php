<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-29 00:00
 @fungsi	 : 
 @revision	 :
*/
	

class Ekstrak_eperformance_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	 
	function get_list() {
		$where = ' where 1=1 ';
		if (isset($params)){
			//if (isset($params['kode_e1'])) $where .= " and kode_e1='".$params['kode_e1']."'";
		}
		$sql = "select distinct id,jenis_data from anev_webservice where tipe_aplikasi = 'E-Performance' ";
		
		
		$result = $this->mgeneral->run_sql($sql);
		
		$list[0] = 'Pilih Jenis Data';
		if (isset($result))
			foreach ($result as $i) {
				$list[$i->id] = $i->jenis_data;
			}
		return $list;
	}
	
	function get_list_old() {
	//pilihan data" yg akan diekstrak dari eperformance
		$list['0'] = 'Pilih Jenis Data';
		$list['unit_kerja'] = 'Unit Kerja';
		$list['program'] = 'Program';
		$list['kegiatan'] = 'Kegiatan';
		$list['iku'] = 'IKU/IKK';
		$list['kinerja'] = 'Kinerja';
		
		
		
		return $list;
	}

}

