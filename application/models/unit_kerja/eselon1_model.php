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
			if (isset($params['kode_e1'])) $where .= " and e1.kode_e1='".$params['kode_e1']."'";
			if (isset($params['tahun_renstra'])) $where .= " and e1.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select e1.*, kl.nama_kl from anev_eselon1 e1 inner join anev_kl kl on e1.kode_kl=kl.kode_kl and e1.tahun_renstra=kl.tahun_renstra ".$where;
		return $this->mgeneral->run_sql($sql);
	}

	function get_list($params) {
		$where = ' where 1=1 ';
		if (isset($params)){	
			
			if (isset($params['check_locking'])){ //jika method ini digunakan untuk combobox dan untuk filter data, maka eselon 1 hanya dimunculkan 
				// eselon1 tertentu saja jika setting FILTER_E1_LOCKING bernilai true (lihat constants.php)
				if (($params['check_locking']==true)&&(FILTER_E1_LOCKING==true)) $where .= " and kode_e1 in (".FILTER_E1_LIST.")";
			}
		}
		$sql = "select distinct kode_e1, nama_e1 from anev_eselon1 ".$where;
		
		
		$result = $this->mgeneral->run_sql($sql);
		
		$list[0] = 'Pilih Unit Kerja Eselon I';
		if (isset($result))
			foreach ($result as $i) {
				$list[$i->kode_e1] = $i->nama_e1;
			}
		return $list;
	}
	
	function get_list_tahun_renstra($params) {
		$where = ' where 1=1 ';
		if (isset($params)){	
			
			if (isset($params['check_locking'])){ //jika method ini digunakan untuk combobox dan untuk filter data, maka eselon 1 hanya dimunculkan 
				// eselon1 tertentu saja jika setting FILTER_E1_LOCKING bernilai true (lihat constants.php)
				if (($params['check_locking']==true)&&(FILTER_E1_LOCKING==true)) $where .= " and kode_e1 in (".FILTER_E1_LIST.")";
			}
		}
		$sql = "select distinct tahun_renstra from anev_eselon1 ".$where;
		
		
		$result = $this->mgeneral->run_sql($sql);
		
		$list[0] = 'Pilih Tahun Renstra';
		if (isset($result))
			foreach ($result as $i) {
				$list[$i->tahun_renstra] = $i->tahun_renstra;
			}
		return $list;
	}
	
	
	function save($data){
		$this->mgeneral->save($data,'anev_eselon1');
	}
	
	function update($data,$whereData){
		
		$this->mgeneral->update($whereData,$data,'anev_eselon1');
	}
	
	function delete($whereData){		
		$this->mgeneral->delete($whereData,'anev_eselon1');
	}
	
	function get_es1($tahun){
		
		$data= $this->mgeneral->getWhere(array('tahun_renstra'=>$tahun),"anev_eselon1");
		$list[]	= array('kode'=>"","nama"=>"Pilih Unit Kerja");
		foreach ($data as $d) {
			$list[] = array('kode'=>$d->kode_e1,'nama'=>$d->nama_e1);
		}
		return $list;
	}

}

