<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-09-04
 @fungsi	 : 
 @revision	 :
*/
	

class Capaian_kinerja_e2_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_capaian_kinerja($kode_sasaran_kl, $tahun_awal, $tahun_akhir) {
		$sql = "select s.kode_kl, s.tahun, s.kode_ss_kl, i.kode_iku_kl, s.deskripsi, i.deskripsi indikator, i.satuan, k.target, k.realisasi, k.persen 
			from anev_sasaran_strategis s inner join anev_iku_kl i on s.tahun=i.tahun inner join anev_kinerja_kl k 
			on (s.tahun=k.tahun and i.tahun=k.tahun and k.kode_ss_kl=s.kode_ss_kl and k.kode_iku_kl=i.kode_iku_kl) 
 			where k.tahun<=".$this->db->escape($tahun_akhir)." and k.tahun>=".$this->db->escape($tahun_awal)
 			." and s.kode_sasaran_kl=".$this->db->escape($kode_sasaran_kl)." order by i.kode_iku_kl asc, k.tahun asc";
 		return $this->mgeneral->run_sql($sql);	
	}
	
	function get_sasaran_kl($params){
	
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_e1'])) $where .= " and sasprog.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and saskeg.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ='select distinct skl.tahun_renstra,skl.sasaran_kl as deskripsi,skl.kode_sasaran_kl
from anev_sasaran_kl skl left join anev_sasaran_strategis ss on ss.kode_sasaran_kl = skl.kode_sasaran_kl
and ss.tahun between left(skl.tahun_renstra,4) and right(skl.tahun_renstra,4)
left join anev_sasaran_program sasprog on sasprog.kode_ss_kl= ss.kode_ss_kl and sasprog.tahun = ss.tahun
left join anev_sasaran_kegiatan saskeg on saskeg.kode_sp_e1= sasprog.kode_sp_e1 and sasprog.tahun = saskeg.tahun
left join anev_ikk iku on iku.tahun=saskeg.tahun and iku.kode_sk_e2 = saskeg.kode_sk_e2
left join anev_kinerja_eselon2 kinerja on kinerja.tahun = sasprog.tahun and kinerja.kode_sk_e2=saskeg.kode_sk_e2 and kinerja.kode_ikk = iku.kode_ikk   '.$where;
		$sql .= 'order by iku.kode_ikk';
	//	var_dump($sql);
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_sasaran_program($params){
	/*Sasaran Kemenhub diganti menjadi Sasaran Program unit kerja Eselon I (dikarenakan cascading dari Sasaran Kemenhub ke Sasaran Kegiatan masih belum akurat, sehingga informasi yang ditampilkan menjadi salah)*/
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_e1'])) $where .= " and sasprog.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and saskeg.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
		//	if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			if (isset($params['tahun_renstra'])) $where .= " and sasprog.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ='select distinct sasprog.deskripsi as deskripsi,sasprog.kode_sp_e1
from anev_sasaran_program sasprog 
left join anev_sasaran_kegiatan saskeg on saskeg.kode_sp_e1= sasprog.kode_sp_e1 and sasprog.tahun = saskeg.tahun
left join anev_ikk iku on iku.tahun=saskeg.tahun and iku.kode_sk_e2 = saskeg.kode_sk_e2
left join anev_kinerja_eselon2 kinerja on kinerja.tahun = sasprog.tahun and kinerja.kode_sk_e2=saskeg.kode_sk_e2 
and kinerja.kode_ikk = iku.kode_ikk '.$where;
		$sql .= 'order by iku.kode_ikk';
		//var_dump($sql);die;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_sasaran_kegiatan($params){
	/*Sasaran Kemenhub diganti menjadi Sasaran Program unit kerja Eselon I (dikarenakan cascading dari Sasaran Kemenhub ke Sasaran Kegiatan masih belum akurat, sehingga informasi yang ditampilkan menjadi salah)*/
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_e1'])) $where .= " and sasprog.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and saskeg.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['kode_sp_e1'])) $where .= " and sasprog.kode_sp_e1='".$params['kode_sp_e1']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			if (isset($params['tahun_renstra'])) $where .= " and sasprog.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ='select distinct saskeg.deskripsi as deskripsi,saskeg.kode_sk_e2
from anev_sasaran_program sasprog 
left join anev_sasaran_kegiatan saskeg on saskeg.kode_sp_e1= sasprog.kode_sp_e1 and sasprog.tahun = saskeg.tahun
left join anev_ikk iku on iku.tahun=saskeg.tahun and iku.kode_sk_e2 = saskeg.kode_sk_e2
left join anev_kinerja_eselon2 kinerja on kinerja.tahun = sasprog.tahun and kinerja.kode_sk_e2=saskeg.kode_sk_e2 
and kinerja.kode_ikk = iku.kode_ikk   '.$where;
		$sql .= 'order by iku.kode_ikk';
	//	var_dump($sql);die;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_sasaran_strategis($params){
	
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_e1'])) $where .= " and sasprog.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and saskeg.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_sasaran_kl'])) $where .= " and skl.kode_sasaran_kl='".$params['kode_sasaran_kl']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ='select distinct skl.tahun_renstra,skl.sasaran_kl,saskeg.deskripsi,saskeg.kode_sk_e2
from anev_sasaran_kl skl left join anev_sasaran_strategis ss on ss.kode_sasaran_kl = skl.kode_sasaran_kl
and ss.tahun between left(skl.tahun_renstra,4) and right(skl.tahun_renstra,4)
left join anev_sasaran_program sasprog on sasprog.kode_ss_kl= ss.kode_ss_kl and sasprog.tahun = ss.tahun
left join anev_sasaran_kegiatan saskeg on saskeg.kode_sp_e1= sasprog.kode_sp_e1 and sasprog.tahun = saskeg.tahun
left join anev_ikk iku on iku.tahun=ss.tahun and iku.kode_sk_e2 = saskeg.kode_sk_e2
left join anev_kinerja_eselon2 kinerja on kinerja.tahun = sasprog.tahun and kinerja.kode_sk_e2=saskeg.kode_sk_e2 and kinerja.kode_ikk = iku.kode_ikk   '.$where;
		$sql .= 'order by iku.kode_ikk';
		return $this->mgeneral->run_sql($sql);
	}
	
	
	function get_capaian($params){
		/*Sasaran Kemenhub diganti menjadi Sasaran Program unit kerja Eselon I (dikarenakan cascading dari Sasaran Kemenhub ke Sasaran Kegiatan masih belum akurat, sehingga informasi yang ditampilkan menjadi salah)*/
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_e1'])) $where .= " and sasprog.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and saskeg.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['kode_sp_e1'])) $where .= " and sasprog.kode_sp_e1='".$params['kode_sp_e1']."'";
			if (isset($params['kode_sk_e2'])) $where .= " and saskeg.kode_sk_e2='".$params['kode_sk_e2']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			if (isset($params['tahun_renstra'])) $where .= " and sasprog.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ="
select distinct saskeg.tahun,iku.deskripsi as deskripsi,saskeg.kode_sk_e2,sasprog.tahun, kinerja.realisasi,kinerja.target,
 iku.kode_ikk, saskeg.kode_sk_e2, sasprog.kode_sp_e1
from anev_sasaran_program sasprog 
left join anev_sasaran_kegiatan saskeg on saskeg.kode_sp_e1= sasprog.kode_sp_e1 and sasprog.tahun = saskeg.tahun
left join anev_ikk iku on iku.tahun=saskeg.tahun and iku.kode_sk_e2 = saskeg.kode_sk_e2
left join anev_kinerja_eselon2 kinerja on kinerja.tahun = sasprog.tahun and kinerja.kode_sk_e2=saskeg.kode_sk_e2 
and kinerja.kode_ikk = iku.kode_ikk   ".$where;
		$sql .= 'order by iku.kode_ikk';
		//var_dump($sql);die;
		return $this->mgeneral->run_sql($sql);
	}
	
	
	function get_capaian_old($params){
		/*Sasaran Kemenhub diganti menjadi Sasaran Program unit kerja Eselon I (dikarenakan cascading dari Sasaran Kemenhub ke Sasaran Kegiatan masih belum akurat, sehingga informasi yang ditampilkan menjadi salah)*/
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_kl'])) $where .= " and skl.kode_kl='".$params['kode_kl']."'";
			if (isset($params['kode_e1'])) $where .= " and sasprog.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and saskeg.kode_e2='".$params['kode_e2']."'";
			if (isset($params['kode_ss_kl'])) $where .= " and ss.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['kode_sp_e1'])) $where .= " and sasprog.kode_sp_e1='".$params['kode_sp_e1']."'";
			if (isset($params['kode_sk_e2'])) $where .= " and saskeg.kode_sk_e2='".$params['kode_sk_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
			//if (isset($params['tahun_renstra'])) $where .= " and skl.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
		}
		$sql ="select distinct skl.tahun_renstra,skl.sasaran_kl,coalesce(iku.deskripsi,'') as deskripsi , sasprog.tahun, kinerja.realisasi,kinerja.target, iku.kode_ikk, saskeg.kode_sk_e2, skl.kode_sasaran_kl
from anev_sasaran_kl skl left join anev_sasaran_strategis ss on ss.kode_sasaran_kl = skl.kode_sasaran_kl
and ss.tahun between left(skl.tahun_renstra,4) and right(skl.tahun_renstra,4)
left join anev_sasaran_program sasprog on sasprog.kode_ss_kl= ss.kode_ss_kl and sasprog.tahun = ss.tahun
left join anev_sasaran_kegiatan saskeg on saskeg.kode_sp_e1= sasprog.kode_sp_e1 and sasprog.tahun = saskeg.tahun
left join anev_ikk iku on iku.tahun=ss.tahun and iku.kode_sk_e2 = saskeg.kode_sk_e2
left join anev_kinerja_eselon2 kinerja on kinerja.tahun = sasprog.tahun and kinerja.kode_sk_e2=saskeg.kode_sk_e2 and kinerja.kode_ikk = iku.kode_ikk   ".$where;
		$sql .= 'order by iku.kode_ikk';
		
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_indikator($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_ss_kl'])) $where .= " and sp.kode_ss_kl='".$params['kode_ss_kl']."'";
			if (isset($params['kode_sp_e1'])) $where .= " and sp.kode_sp_e1='".$params['kode_sp_e1']."'";
			if (isset($params['range_awal'])) $where .= " and kinerja.tahun between ".$params['range_awal']." and ".$params['range_akhir'];
		}
		$sql = "select kinerja.tahun,kinerja.kode_ikk,iku.deskripsi, iku.satuan,kinerja.target,kinerja.realisasi, kinerja.persen from anev_kinerja_eselon2 kinerja inner join anev_ikk iku on kinerja.kode_ikk = iku.kode_ikk and kinerja.tahun = iku.tahun	inner join anev_sasaran_program sp on sp.kode_sp_e1 = iku.kode_sp_e1 and sp.tahun = iku.tahun	inner join anev_sasaran_strategis ss on sp.kode_ss_kl = ss.kode_ss_kl and sp.tahun = ss.tahun ".$where;
		$sql .= " order by kinerja.kode_ikk, kinerja.tahun ";
		return $this->mgeneral->run_sql($sql);
	
	}

}

