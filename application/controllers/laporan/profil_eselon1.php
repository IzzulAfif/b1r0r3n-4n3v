<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-16 00:00
 @revision	 :
*/

class Profil_eselon1 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/unit_kerja/fungsi_eselon1_model','fungsi_e1');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(null);
		$template['konten']	= $this->load->view('laporan/profil_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadprofile()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('laporan/profil_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_unit_kerja($e1){
		$data = $this->eselon2->get_all(array("kode_e1"=>$e1));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->nama_e2.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function get_fungsi($tahun,$e1){
		$data = $this->fungsi_e1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->fungsi_e1.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function get_tugas($tahun,$e1){
		$data = $this->eselon1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->tugas_e1.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
   function print_pdf($tahun,$e1)
   {
	   $this->load->library('pdf');
	   $data['renstra']		= $tahun;
	   $data['nama_unit'] 	= $this->mgeneral->getValue("nama_e1",array('kode_e1'=>$e1,'tahun_renstra'=>$tahun),"anev_eselon1");
	   $data['unit_kerja']	= $this->eselon2->get_all(array("kode_e1"=>$e1));
	   $data['fungsi']		= $this->fungsi_e1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
	   $data['tugas']		= $this->eselon1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
	   
	   $html = $this->load->view('laporan/print/pdf_profile_e1',$data,true);
	   
	   echo $this->pdf->cetak($html,"profile_eselon1.pdf");
   }

}