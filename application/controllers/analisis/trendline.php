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
	}
	
	function index()
	{
		$data['kl']			= $this->mgeneral->getAll("anev_kl");
		$this->load->view('analisis/trendline',$data);
	}
	
	function eselon1()
	{
		$data['esselon1']	= $this->mgeneral->getAll("anev_eselon1");
		$this->load->view('analisis/trendline_e1',$data);
	}
	
	function get_tahun($kode)
	{
		if(strlen($kode)=="3"):
			$result	= $this->analisis_model->get_tahun_sasaran_strategis($kode);
			
		else:
			$result	= $this->analisis_model->get_tahun_sasaran_program($kode);
		endif;
		
		echo json_encode($result);
	}
	
	function get_sasaran($kode,$tahun)
	{
		if(strlen($kode)=="3"):
			$result	= $this->analisis_model->get_sasaran_strategis($kode,$tahun);
		else:
			$result	= $this->analisis_model->get_sasaran_program($kode,$tahun);
		endif;
		
		echo json_encode($result);
	}
	
	function get_indikator($kode,$tahun,$sasaran)
	{
		if(strlen($kode)=="3"):
			$result	= $this->analisis_model->get_iku_kl($kode,$tahun,$sasaran);
		else:
			$result	= $this->analisis_model->get_iku_e1($kode,$tahun,$sasaran);
		endif;
		
		echo json_encode($result);
	}
	
	function get_satuan($kode,$tahun,$indikator)
	{
		if(strlen($kode)=="3"):
			$result	= $this->mgeneral->getValue("satuan",array('kode_iku_kl'=>$indikator,'tahun'=>$tahun),"anev_iku_kl");
		else:
			$result	= $this->mgeneral->getValue("satuan",array('kode_iku_e1'=>$indikator,'tahun'=>$tahun),"anev_iku_eselon1");
		endif;
		
		echo $result;
	}
}