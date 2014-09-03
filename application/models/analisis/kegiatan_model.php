<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup
 @date       : 2014-09-01 13:00
 @fungsi	 : 
 @revision	 : 
*/
	

class Kegiatan_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	
	function get_program($tahun)
	{
		$data = $this->mgeneral->getWhere(array('tahun'=>$tahun),"anev_program_eselon1");
		$list[]	= array('kode_program'=>"-1","nama_program"=>"Pilih Program");
		foreach($data as $d):
			$list[] = array('kode_program'=>$d->kode_program,'nama_program'=>"- ".$d->nama_program);
		endforeach;
		
		return $list;
	}
	
	function get_kegiatan($tahun,$program)
	{
		$data = $this->mgeneral->getWhere(array('tahun'=>$tahun,'kode_program'=>$program),"anev_kegiatan_eselon2");
		$list[]	= array('kode_kegiatan'=>"-1","nama_kegiatan"=>"Pilih Kegiatan");
		foreach($data as $d):
			$list[] = array('kode_kegiatan'=>$d->kode_kegiatan,'nama_kegiatan'=>"- ".$d->nama_kegiatan);
		endforeach;
		
		return $list;
	}
	
	//yusup
	function get_rincian_paket_pekerjaan($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kdlokasi'])) $where .= " and i.kdlokasi='".$params['kdlokasi']."'";
			if (isset($params['kode_program'])) $where .= " and i.kode_program='".$params['kode_program']."'";
			if (isset($params['kode_kegiatan'])) $where .= " and i.kode_kegiatan='".$params['kode_kegiatan']."'";
			if (isset($params['tahun'])) $where .= " and i.tahun='".$params['tahun']."'";
		}
	$sql = 'select i.nmitem, i.volkeg, i.satkeg, kk.nama_kabkota, s.nama_status from anev_item_satker i left join anev_kabkota kk on i.kdkabkota = kk.kdkabkota left join anev_status_kegiatan s on s.kode_status = i.kode_status '.$where;
	$sql .= " limit 0,100";
		return $this->mgeneral->run_sql($sql);
	
	}
	
}