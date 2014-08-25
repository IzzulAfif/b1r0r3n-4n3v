<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-08-17 00:00
 @revision	 :
*/

class Trendline extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('analisis/analisis_model','',TRUE);
		$this->load->model('analisis/trendline_model','',TRUE);
	}
	
	function index()
	{
		$data['kl']			= $this->mgeneral->getAll("anev_kl");
		$this->load->view('analisis/trendline',$data);
	}
	
	function proses_kl()
	{
		$unit_kerja	= $this->input->post("unit_kerja");
		$renstra	= $this->input->post("renstra");
		$tahun1		= $this->input->post("tahun1");
		$tahun2		= $this->input->post("tahun2");
		$sasaran	= $this->input->post("sasaran");
		$indikator	= $this->input->post("indikator");
		$tahun		= $this->input->post("tahun");
		$target		= $this->input->post("target");
		$trendline	= $this->input->post("trendline");
		$targetline	= $this->input->post("targetline");
		
		$dataKonten = $this->trendline_model->kl($unit_kerja,$sasaran,$indikator,$tahun1,$tahun2);
		
		$data['simulasi']	= $this->input->post();
		$data['gdata'] 		= $dataKonten;
		$data['title']		= $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$sasaran,'kode_iku_kl'=>$indikator),"anev_iku_kl");
		$data['subtitle']	= "dari Tahun $tahun1 s.d. $tahun2"; 
		$this->load->view('analisis/trendline_grafik',$data);
	}
	
	function eselon1()
	{
		$data['esselon1']	= $this->mgeneral->getAll("anev_eselon1");
		$this->load->view('analisis/trendline_e1',$data);
	}
	
	function get_renstra($kode)
	{
		if(strlen($kode)=="3"):
			$result	= $this->analisis_model->get_renstra_sasaran_strategis($kode);
			
		else:
			$result	= $this->analisis_model->get_renstra_sasaran_program($kode);
		endif;
		
		echo json_encode($result);
	}
	
	function get_tahun($kode,$renstra)
	{
		if(strlen($kode)=="3"):
			$result	= $this->analisis_model->get_tahun_sasaran_strategis($kode,$renstra);
			
		else:
			$result	= $this->analisis_model->get_tahun_sasaran_program($kode,$renstra);
		endif;
		
		echo json_encode($result);
	}
	
	function get_sasaran($kode)
	{
		if(strlen($kode)=="3"):
			$result	= $this->analisis_model->get_sasaran_strategis($kode);
		else:
			$result	= $this->analisis_model->get_sasaran_program($kode);
		endif;
		
		echo json_encode($result);
	}
	
	function get_indikator($kode,$sasaran)
	{
		if(strlen($kode)=="3"):
			$result	= $this->analisis_model->get_iku_kl($kode,$sasaran);
		else:
			$result	= $this->analisis_model->get_iku_e1($kode,$sasaran);
		endif;
		
		echo json_encode($result);
	}
	
	function get_satuan($kode,$indikator)
	{
		if(strlen($kode)=="3"):
			$result	= $this->mgeneral->getValue("satuan",array('kode_iku_kl'=>$indikator),"anev_iku_kl");
		else:
			$result	= $this->mgeneral->getValue("satuan",array('kode_iku_e1'=>$indikator),"anev_iku_eselon1");
		endif;
		
		echo $result;
	}
}