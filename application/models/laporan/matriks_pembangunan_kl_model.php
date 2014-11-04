<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-20 13:00
 @fungsi	 : 
 @revision	 :
*/
	

class Matriks_pembangunan_kl_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_sasaran_kl($params){
	
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			//if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			if (isset($params['rentang_awal'])) $where .= " and iku.tahun between '".$params['rentang_awal']."' and '".$params['rentang_akhir']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ='select distinct skl.tahun_renstra,skl.sasaran_kl as deskripsi,skl.kode_sasaran_kl
from anev_sasaran_kl skl left join anev_sasaran_strategis ss on ss.kode_sasaran_kl = skl.kode_sasaran_kl
and ss.tahun between left(skl.tahun_renstra,4) and right(skl.tahun_renstra,4)
left join anev_sasaran_program sasprog on sasprog.kode_ss_kl= ss.kode_ss_kl
 and sasprog.tahun = ss.tahun
left join anev_iku_eselon1 iku on iku.tahun=ss.tahun and iku.kode_sp_e1 = sasprog.kode_sp_e1
left join anev_kinerja_eselon1 kinerja on kinerja.tahun = sasprog.tahun and kinerja.kode_sp_e1=sasprog.kode_sp_e1 and kinerja.kode_iku_e1 = iku.kode_iku_e1  '.$where;
		$sql .= 'order by iku.kode_iku_kl';
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_indikator($params){
	
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['kode_sasaran_kl'])) $where .= " and skl.kode_sasaran_kl='".$params['kode_sasaran_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			if (isset($params['rentang_awal'])) $where .= " and iku.tahun between '".$params['rentang_awal']."' and '".$params['rentang_akhir']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ='select distinct iku.deskripsi,iku.satuan,iku.kode_iku_e1,e1.nama_e1
from anev_sasaran_kl skl left join anev_sasaran_strategis ss on ss.kode_sasaran_kl = skl.kode_sasaran_kl
and ss.tahun between left(skl.tahun_renstra,4) and right(skl.tahun_renstra,4)
left join anev_sasaran_program sasprog on sasprog.kode_ss_kl= ss.kode_ss_kl
 and sasprog.tahun = ss.tahun
left join anev_iku_eselon1 iku on iku.tahun=ss.tahun and iku.kode_sp_e1 = sasprog.kode_sp_e1
left join anev_kinerja_eselon1 kinerja on kinerja.tahun = sasprog.tahun and kinerja.kode_sp_e1=sasprog.kode_sp_e1 and kinerja.kode_iku_e1 = iku.kode_iku_e1
left join anev_eselon1 e1 on e1.kode_e1 = iku.kode_e1 and e1.tahun_renstra = skl.tahun_renstra
'.$where;
		$sql .= 'order by iku.kode_iku_e1';
		return $this->mgeneral->run_sql($sql);
	}
	
	function hitung_total($params){
		$where = 'where 1=1';
		if (isset($params)){
			if (isset($params['tahun'])) $where .= " and output.tahun='".$params['tahun']."'";
			if (isset($params['kode_iku_e1'])) $where .= " and ikk.kode_iku_e1='".$params['kode_iku_e1']."'";
		}	
		$sql  = 'select sum(total_volkeg) as total from anev_rekap_output output inner join anev_ikk ikk on output.kode_ikk =ikk.kode_ikk and  ikk.tahun=output.tahun '.$where;
		$data =$this->mgeneral->run_sql($sql);
		$r=0;
		if(isset($data)){
			foreach ($data as $rs) {
				$r = $rs->total;
			}
		}
		return $r;
		
	}

	
}

