<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-08-17 00:00
 @revision	 :
*/

class Korelasi extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
	}
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "ANALISIS");
		$setting['page']	= array('pg_aktif'	=> "chart");
		$template			= $this->template->load($setting); #load static template file
		
		$template['konten']	= $this->load->view('analisis/korelasi',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
}