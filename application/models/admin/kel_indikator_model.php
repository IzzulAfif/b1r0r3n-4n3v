<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-10-1
 @fungsi	 : 
 @revision	 :
*/
	

class Kel_indikator_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	
	function get_list($params) {
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_ss_kl'])) $where .= " and kode_ss_kl='".$params['kode_ss_kl']."'";
		}
		$sql = "select distinct kode_ss_kl, deskripsi from anev_kel_indikator ".$where;
		$sql .= " order by kode_ss_kl";
		
		$result = $this->mgeneral->run_sql($sql);
		
		$list[0] = 'Pilih Kelompok Indikator';
		if (isset($result))
			foreach ($result as $i) {
				$list[$i->kode_ss_kl] = $i->deskripsi;
			}
		return $list;
	}
	
	
	function get_datatables($params){
		$this->datatables->select('no_kel, deskripsi,kode_ss_kl ');
		$this->datatables->from('anev_kel_indikator');
	
		return $this->datatables->generate();
	
	}

}

