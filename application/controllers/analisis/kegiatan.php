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
	
	function map()
	{
		$data = null;
		$this->load->view('analisis/map_kegiatan',$data);
	}
}