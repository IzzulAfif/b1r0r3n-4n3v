<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-15 23:30
 @fungsi	 : 
 @revision	 :
*/
	

class Visi_kl_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and f.kode_kl='".$params['kode_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select f.*, kl.nama_kl from anev_visi_kl f inner join anev_kl kl on f.kode_kl=kl.kode_kl and f.tahun_renstra= kl.tahun_renstra ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_where($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_visi_kl'])) $where .= " and f.kode_visi_kl='".$params['kode_visi_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and f.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select f.*, kl.nama_kl from anev_visi_kl f inner join anev_kl kl on f.kode_kl=kl.kode_kl and f.tahun_renstra= kl.tahun_renstra ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_datatables($params){
		$this->datatables->select('f.tahun_renstra,kl.nama_kl,f.kode_visi_kl,f.visi_kl, ');
		$this->datatables->from('anev_visi_kl f');
		$this->datatables->join('anev_kl kl', 'f.kode_kl=kl.kode_kl  and f.tahun_renstra=kl.tahun_renstra', 'inner');
		$this->datatables->add_column('aksi', '$1','e2_action(f.kode_visi_kl,f.tahun)');
		return $this->datatables->generate();
	}

}

