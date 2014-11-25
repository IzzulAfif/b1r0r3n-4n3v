<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-08-09 00:00
 @revision	 :
*/

class Home extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
	}
	
	function index()
	{
		
		//var_dump($this->my_session->all_userdata());
		$setting['sd_left']	= array('cur_menu'	=> "");
		$setting['page']	= array('pg_aktif'	=> "");
		$template			= $this->template->load($setting); #load static template file
		
		$data				= ""; #kirim data ke konten file
		$template['konten']	= $this->load->view('home',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
}