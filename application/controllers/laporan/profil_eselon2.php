<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-16 00:00
 @revision	 :
*/

class Profil_eselon2 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/unit_kerja/fungsi_eselon2_model','fungsi_e2');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_all(array("check_locking"=>true));
		$template['konten']	= $this->load->view('laporan/profil_eselon2_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function get_list_eselon1()
	{
		$params = array("check_locking"=>true);
		echo json_encode($this->eselon1->get_list($params));
	}
	
	function get_list_eselon2($kode_e1)
	{
		$params = array("kode_e1"=>$kode_e1);
		echo json_encode($this->eselon2->get_list($params));
	}
	
	function get_unit_kerja($e2){
		$data = $this->eselon2->get_all(array("kode_e2"=>$e2));
		
		//var_dump($data);
		$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
		foreach($data as $d){
			$rs .= '<li>'.$d->nama_e2.'</li>';
		 }
		 $rs .= '</ol>';
		echo $rs;
	}
	
	function get_fungsi($tahun,$e2){
		$data = $this->fungsi_e2->get_all(array("kode_e2"=>$e2,"tahun_renstra"=>$tahun));
		
		$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
		foreach($data as $d){
			$rs .= '<li>'.$d->fungsi_e2.'</li>';
		 }
		 $rs .= '</ol>';
		echo $rs;
	}
	
	function get_tugas($tahun,$e2){
		$data = $this->eselon2->get_all(array("kode_e2"=>$e2,"tahun_renstra"=>$tahun));
		
		$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
		foreach($data as $d){
			$rs .= '<li>'.$d->tugas_e2.'</li>';
		 }
		 $rs .= '</ol>';
		echo $rs;
	}

}