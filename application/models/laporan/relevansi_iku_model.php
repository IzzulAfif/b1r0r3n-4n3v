<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup
 @date       : 2014-11-05 
 @fungsi	 : 
 @revision	 : 
*/
	

class Relevansi_iku_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	
	function get_iku($params){
		
		$where = ' where 1=1 ';
		if (isset($params)){		
			if (isset($params['kode_e1'])) $where .= " and ikue1.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and ikk.kode_e2 = '".$params['kode_e2']."' " ;						
			if (isset($params['tahun']))  $where .= " and kl.tahun = ".$params['tahun'];
			//if (isset($params['tahun_renstra']))  $where .= " and kl.tahun_renstra = '".$params['tahun_renstra']."'";
		}
		
		$colE1 = '';
		if ($params['chkE1']=="true") $colE1 = ', ikue1.kode_iku_e1,ikue1.deskripsi as deskripsi_e1';
		$colE2 = '';
		if ($params['chkE2']=="true") $colE2 = ', ikk.kode_ikk,ikk.deskripsi as deskripsi_e2 ';
	
		$sql = "SELECT distinct kl.kode_iku_kl,kl.deskripsi as deskripsi_kl  ".$colE1.$colE2." 
		FROM anev_iku_kl kl ".
		($colE1!=""?"LEFT JOIN anev_iku_eselon1 ikue1 ON ikue1.tahun = kl.tahun AND ikue1.kode_iku_kl = kl.kode_iku_kl ":"").
		($colE2!=""?"LEFT JOIN anev_ikk ikk ON ikk.tahun = ikue1.tahun AND ikue1.kode_iku_e1 = ikk.kode_iku_e1 ":"").$where;
	//var_dump($sql);die;
		$sql .= " ORDER BY kl.kode_iku_kl".($colE1!=""?",ikue1.kode_iku_e1":"").($colE2!=""?",ikk.kode_ikk":"");
	//$sql .= " limit 0,100";
		return $this->mgeneral->run_sql($sql);
	
	}
	
	
}