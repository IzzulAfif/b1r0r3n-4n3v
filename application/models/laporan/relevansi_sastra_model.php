<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup
 @date       : 2014-11-05 
 @fungsi	 : 
 @revision	 : 
*/
	

class Relevansi_sastra_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_sasaran($params){
		
		$where = ' where 1=1 ';
		if (isset($params)){		
			if (isset($params['kode_e1'])) $where .= " and sp.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and sk.kode_e2 = '".$params['kode_e2']."' " ;						
			if (isset($params['tahun']))  $where .= " and ss.tahun = ".$params['tahun'];
			if (isset($params['tahun_renstra']))  $where .= " and skl.tahun_renstra = '".$params['tahun_renstra']."'";
		}
		
		$colE1 = '';
		if ($params['chkE1']=="true") $colE1 = ', sp.kode_sp_e1,sp.deskripsi as sasaran_program';
		$colE2 = '';
		if ($params['chkE2']=="true") $colE2 = ', sk.kode_sk_e2,sk.deskripsi as sasaran_kegiatan ';
	
		$sql = "SELECT distinct skl.kode_sasaran_kl,skl.sasaran_kl,ss.kode_ss_kl, ss.deskripsi as sasaran_strategis ".$colE1.$colE2." 
		FROM anev_sasaran_kl skl 
		LEFT JOIN anev_sasaran_strategis ss ON ss.tahun BETWEEN LEFT(skl.tahun_renstra,4) AND RIGHT(skl.tahun_renstra,4) AND skl.kode_sasaran_kl = ss.kode_sasaran_kl ".
		((($colE1!="")||($colE2!=""))?"LEFT JOIN anev_sasaran_program sp ON sp.tahun = ss.tahun AND sp.kode_ss_kl = ss.kode_ss_kl ":"").
		($colE2!=""?"LEFT JOIN anev_sasaran_kegiatan sk ON sk.tahun = sp.tahun AND sp.kode_sp_e1 = sk.kode_sp_e1 ":"").$where;
	//var_dump($sql);die;
		$sql .= " ORDER BY skl.kode_sasaran_kl,ss.kode_ss_kl".($colE1!=""?",sp.kode_sp_e1":"").($colE2!=""?",sk.kode_sk_e2":"");
	//$sql .= " limit 0,100";
		return $this->mgeneral->run_sql($sql);
	
	}
	
	
}