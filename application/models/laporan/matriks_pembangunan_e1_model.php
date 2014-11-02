<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-20 13:00
 @fungsi	 : 
 @revision	 :
*/
	

class Matriks_pembangunan_e1_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_output($params){
	
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and prog.kode_e1='".$params['kode_e1']."'";
			//if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['rentang_awal'])) $where .= " and prog.tahun between '".$params['rentang_awal']."' and '".$params['rentang_akhir']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ='select prog.tahun,prog.kode_e1,prog.nama_program,prog.kode_program, keg.nama_kegiatan ,keg.kode_kegiatan,  ikk.kode_e2,ikk.kode_ikk, ikk.deskripsi, ikk.satuan , output.nmoutput, output.satuan as satuan_output,rekap.total_volkeg, rekap.total_jumlah 
from anev_program_eselon1 prog left join anev_kegiatan_eselon2 keg on prog.kode_program = keg.kode_program and prog.tahun = keg.tahun 
left join anev_rekap_output rekap on rekap.kode_kegiatan = keg.kode_kegiatan and rekap.tahun = keg.tahun 
left join anev_output output on output.kdoutput = rekap.kdoutput and output.kode_kegiatan = rekap.kode_kegiatan 
left join anev_ikk ikk on ikk.kode_ikk = rekap.kode_ikk and ikk.tahun = rekap.tahun '.$where;
		$sql .= 'order by prog.kode_program,keg.kode_kegiatan,output.kdoutput';
		return $this->mgeneral->run_sql($sql);
	}
	
	

	
}

