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
	//pilihan data" yg akan diekstrak dari emon
		$list['0'] = 'Pilih Jenis Data';
		$list['satker'] = 'Satker';
		$list['item'] = 'Item Satker';
		$list['lokasi'] = 'Lokasi';
		$list['kota'] = 'Kab/Kota';
		return $list;
	}

}

