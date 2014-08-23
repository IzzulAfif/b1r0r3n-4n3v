<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-08-17 00:00
 @revision	 :
*/

class Cross_section extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
	}
	function index()
	{
		$data['kl']			= $this->mgeneral->getAll("anev_kl");
		$data['esselon1']	= $this->mgeneral->getAll("anev_eselon1");
		$this->load->view('analisis/cross_section',$data);
	}
}