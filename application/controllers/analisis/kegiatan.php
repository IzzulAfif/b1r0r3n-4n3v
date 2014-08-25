<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-08-24 00:00
 @revision	 :
*/

class Kegiatan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('analisis/analisis_model','',TRUE);
	}
	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "ANALISIS");
		$setting['page']	= array('pg_aktif'	=> "map");
		$template			= $this->template->load($setting); #load static template file
		
		$data				= "";
		$template['konten']	= $this->load->view('analisis/kegiatan',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function data()
	{
		$data = null;
		$this->load->view('analisis/data_kegiatan',$data);
	}
	
	function get_program($tahun)
	{
		$result	= $this->analisis_model->get_program($tahun);
		echo json_encode($result);
	}
	
	function get_kegiatan($tahun,$program)
	{
		$result	= $this->analisis_model->get_kegiatan($tahun,$program);
		echo json_encode($result);
	}
	
	function map()
	{
		$data = null;
		$this->load->view('analisis/map_kegiatan',$data);
	}
}