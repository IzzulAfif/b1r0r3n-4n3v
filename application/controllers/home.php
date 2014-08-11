<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
	}
	
	function index()
	{
		$setting			= array(); #settingan untuk static template file
		$template			= $this->template->load($setting); #load static template file
		
		$data				= ""; #kirim data ke konten file
		$template['konten']	= $this->load->view('home',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
}