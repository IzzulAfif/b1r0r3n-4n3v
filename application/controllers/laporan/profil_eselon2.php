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
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(array("check_locking"=>true));
		$template['konten']	= $this->load->view('laporan/profil_eselon2_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadprofile()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_all(null);
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/profil_eselon2_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_list_eselon1($tahun)
	{
		$params = array("tahun_renstra"=>$tahun);
		echo json_encode($this->eselon1->get_list($params));
	}
	
	function get_list_eselon2($tahun,$kode_e1)
	{
		$params = array("tahun_renstra"=>$tahun,"kode_e1"=>$kode_e1);
		echo json_encode($this->eselon2->get_list($params));
	}
	
	function get_unit_kerja($tahun,$e2){
		$data = $this->eselon2->get_all(array("tahun_renstra"=>$tahun,"kode_e2"=>$e2));
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
	
	function get_fungsi($tahun,$e2){
		$data = $this->fungsi_e2->get_all(array("kode_e2"=>$e2,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->fungsi_e2.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function get_tugas($tahun,$e2){
		$data = $this->eselon2->get_all(array("kode_e2"=>$e2,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->tugas_e2.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function print_pdf($tahun,$e2)
   {
	   $this->load->library('pdf');
	   $data['renstra']		= $tahun;
	   $data['nama_unit'] 	= $this->mgeneral->getValue("nama_e2",array('kode_e2'=>$e2,'tahun_renstra'=>$tahun),"anev_eselon2");
	   $data['unit_kerja']	= $this->eselon2->get_all(array("kode_e2"=>$e2,"tahun_renstra"=>$tahun));
	   $data['fungsi']		= $this->fungsi_e2->get_all(array("kode_e2"=>$e2,"tahun_renstra"=>$tahun));
	   $data['tugas']		= $this->eselon2->get_all(array("kode_e2"=>$e2,"tahun_renstra"=>$tahun));
	   
	   $html = $this->load->view('laporan/print/pdf_profile_e2',$data,true);
	   
	   echo $this->pdf->cetak($html,"profile_eselon2.pdf");
   }

}