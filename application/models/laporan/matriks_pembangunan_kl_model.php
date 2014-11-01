<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-20 13:00
 @fungsi	 : 
 @revision	 :
*/
	

class Matriks_pembangunan_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_sasaran_kl($params){
	
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ='select distinct skl.tahun_renstra,skl.sasaran_kl as deskripsi,skl.kode_sasaran_kl
from anev_sasaran_kl skl left join anev_sasaran_strategis ss on ss.kode_sasaran_kl = skl.kode_sasaran_kl
and ss.tahun between left(skl.tahun_renstra,4) and right(skl.tahun_renstra,4)
left join anev_sasaran_program sasprog on sasprog.kode_ss_kl= ss.kode_ss_kl
 and sasprog.tahun = ss.tahun
left join anev_iku_eselon1 iku on iku.tahun=ss.tahun and iku.kode_sp_e1 = sasprog.kode_sp_e1
left join anev_kinerja_eselon1 kinerja on kinerja.tahun = sasprog.tahun and kinerja.kode_sp_e1=sasprog.kode_sp_e1 and kinerja.kode_iku_e1 = iku.kode_iku_e1 '.$where;
		$sql .= 'order by iku.kode_iku_kl';
		return $this->mgeneral->run_sql($sql);
	}

	
}

