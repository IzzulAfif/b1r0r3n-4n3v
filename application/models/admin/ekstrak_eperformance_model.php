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

