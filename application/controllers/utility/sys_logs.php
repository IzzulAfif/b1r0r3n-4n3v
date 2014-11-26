<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-08-09 00:00
 @revision	 :
*/

class sys_logs extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('utility/login_log_model','login_log',TRUE);
	}
	
	function index()
	{
		
		//var_dump($this->my_session->all_userdata());
		$setting['sd_left']	= array('cur_menu'	=> "UTILITY");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file
		
		$data				= ""; #kirim data ke konten file
		$template['konten']	= $this->load->view('utility/syslogs_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	
	function getdata(){
		$params=null;//['tahun_renstra'] = $periode;
		//echo $this->satker->get_datatables($params);
		$data = $this->login_log->get_datatables($params);
		//var_dump($data);
		echo json_encode($data);
		//echo $data;
	}
}