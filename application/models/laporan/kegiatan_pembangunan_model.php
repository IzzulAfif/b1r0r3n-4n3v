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
	
	
	function get_detil_belanja($params){
		$where1 = ' where 1=1 ';
		$where2 = " where 1=1 ";
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kdlokasi'])) $where2 .= " and t0.kdlokasi='".$params['kdlokasi']."'";
			if (isset($params['kode_e1'])) $where .= " and t0.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and sk.kode_e2 = '".$params['kode_e2']."' " ;
			if (isset($params['indikator'])) $where1 .= " and ss.kode_ss_kl='".$params['indikator']."'";
			if (isset($params['kode_program'])) $where2 .= " and t0.kode_program='".$params['kode_program']."'";
			if (isset($params['kode_kegiatan'])) $where2 .= " and t0.kode_kegiatan='".$params['kode_kegiatan']."'";
			if (isset($params['tahun']))  {
				$where1 .= " and ss.tahun = ".$params['tahun'];
				$where2 .= " and t0.tahun = ".$params['tahun'];
				$where .= " and t0.tahun = ".$params['tahun'];
			}
			if (isset($params['tahun_renstra']))  $where .= " and t0.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		
		$sql1 = "SELECT DISTINCT ss.tahun, ss.kode_ss_kl, ikukl.kode_iku_kl, ikue1.kode_e1, ikue1.kode_iku_e1,  ikk.kode_ikk, ikk.deskripsi, ikk.satuan
FROM anev_sasaran_strategis ss JOIN anev_iku_kl ikukl ON ss.kode_ss_kl=ikukl.kode_ss_kl
JOIN anev_iku_eselon1 ikue1 ON ikukl.kode_iku_kl=ikue1.kode_iku_kl
JOIN anev_ikk ikk ON ikue1.kode_iku_e1=ikk.kode_iku_e1 ".$where1;

		$sql2 = " select prog.tahun,prog.kode_e1,prog.nama_program,prog.kode_program, keg.nama_kegiatan ,keg.kode_kegiatan,  ikk.kode_e2,ikk.kode_ikk, ikk.deskripsi, ikk.satuan , output.nmoutput, output.satuan as satuan_output 
from anev_program_eselon1 prog left join anev_kegiatan_eselon2 keg on prog.kode_program = keg.kode_program and prog.tahun = keg.tahun 
left join anev_rekap_output rekap on rekap.kode_kegiatan = keg.kode_kegiatan and rekap.tahun = keg.tahun 
left join anev_output output on output.kdoutput = rekap.kdoutput and output.kode_kegiatan = rekap.kode_kegiatan 
left join anev_ikk ikk on ikk.kode_ikk = rekap.kode_ikk and ikk.tahun = rekap.tahun ";
		

	$sql = "select * from ($sql2) t0 inner join ($sql1) t1 on t1.tahun=t0.tahun and t1.kode_ikk = t0.kode_ikk ".$where2;
	//var_dump($sql);die;
	$sql .= " order by t0.kode_e1,t0.kode_e2,t0.nama_program, t0.nama_kegiatan";
	//$sql .= " limit 0,100";
		return $this->mgeneral->run_sql($sql);
	
	}
	
	//yusup
	function get_detil_belanja_old($params){
		$where1 = ' where 1=1 ';
		$where2 = " where 1=1 ";
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kdlokasi'])) $where2 .= " and t0.kdlokasi='".$params['kdlokasi']."'";
			if (isset($params['kode_e1'])) $where .= " and t0.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and sk.kode_e2 = '".$params['kode_e2']."' " ;
			if (isset($params['indikator'])) $where1 .= " and ss.kode_ss_kl='".$params['indikator']."'";
			if (isset($params['kode_program'])) $where2 .= " and t0.kode_program='".$params['kode_program']."'";
			if (isset($params['kode_kegiatan'])) $where2 .= " and t0.kode_kegiatan='".$params['kode_kegiatan']."'";
			if (isset($params['tahun']))  {
				$where1 .= " and ss.tahun = ".$params['tahun'];
				$where2 .= " and t0.tahun = ".$params['tahun'];
				$where .= " and t0.tahun = ".$params['tahun'];
			}
			if (isset($params['tahun_renstra']))  $where .= " and t0.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		
		$sql1 = "SELECT DISTINCT ss.tahun, ss.kode_ss_kl, ikukl.kode_iku_kl, ikue1.kode_e1, ikue1.kode_iku_e1, ikk.kode_e2, ikk.kode_ikk, ikk.deskripsi, ikk.satuan 
FROM anev_sasaran_strategis ss JOIN anev_iku_kl ikukl ON ss.kode_ss_kl=ikukl.kode_ss_kl
JOIN anev_iku_eselon1 ikue1 ON ikukl.kode_iku_kl=ikue1.kode_iku_kl
JOIN anev_ikk ikk ON ikue1.kode_iku_e1=ikk.kode_iku_e1".$where1;

		$sql2 = "SELECT distinct i.tahun, i.kode_satker, i.kode_program, i.kode_kegiatan, i.kdlokasi, i.nmitem, i.volkeg, i.satkeg, i.hargasat, i.jumlah, i.kode_ikk FROM anev_item_satker i ";
		

	$sql = "select * from ($sql2 where i.kode_ikk <> '' and i.kode_ikk is not null ) t0 inner join ($sql1) t1 on t1.tahun=t0.tahun and t1.kode_ikk = t0.kode_ikk ".$where2;
	//var_dump($sql);die;
	//$sql .= " limit 0,100";
		return $this->mgeneral->run_sql($sql);
	
	}
	
}