<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup
 @date       : 2014-09-01 13:00
 @fungsi	 : 
 @revision	 : 
*/
	

class Kegiatan_pembangunan_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	
	//yusup
	function get_detil_belanja($params){
		$where1 = ' where 1=1 ';
		$where2 = ' where 1=1 ';
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kdlokasi'])) $where2 .= " and i.kdlokasi='".$params['kdlokasi']."'";
			if (isset($params['kode_e1'])) $where .= " and i.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and sk.kode_e2 = '".$params['kode_e2']."' " ;
			if (isset($params['indikator'])) $where1 .= " and ss.kode_ss_kl='".$params['indikator']."'";
			if (isset($params['kode_program'])) $where2 .= " and i.kode_program='".$params['kode_program']."'";
			if (isset($params['kode_kegiatan'])) $where2 .= " and i.kode_kegiatan='".$params['kode_kegiatan']."'";
			if (isset($params['tahun']))  {
				$where1 .= " and ss.tahun = ".$params['tahun'];
				$where2 .= " and i.tahun = ".$params['tahun'];
				$where .= " and i.tahun = ".$params['tahun'];
			}
			if (isset($params['tahun_renstra']))  $where .= " and i.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		
		$sql1 = "SELECT DISTINCT ss.tahun, ss.kode_ss_kl, ikukl.kode_iku_kl, ikue1.kode_e1, ikue1.kode_iku_e1, ikk.kode_e2, ikk.kode_ikk, ikk.deskripsi, ikk.satuan 
FROM anev_sasaran_strategis ss JOIN anev_iku_kl ikukl ON ss.kode_ss_kl=ikukl.kode_ss_kl
JOIN anev_iku_eselon1 ikue1 ON ikukl.kode_iku_kl=ikue1.kode_iku_kl
JOIN anev_ikk ikk ON ikue1.kode_iku_e1=ikk.kode_iku_e1".$where1;

		$sql2 = "SELECT distinct i.tahun, i.kode_satker, i.kode_program, i.kode_kegiatan, i.kdlokasi, i.nmitem, i.volkeg, i.satkeg, i.hargasat, i.jumlah, i.kode_ikk FROM anev_item_satker i ";
		

	$sql = $sql2." inner join ($sql1) t1 on t1.tahun=i.tahun and t1.kode_ikk = i.kode_ikk ".$where2;
	//var_dump($sql);die;
	//$sql .= " limit 0,100";
		return $this->mgeneral->run_sql($sql);
	
	}
	
}