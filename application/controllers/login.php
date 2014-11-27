<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup
 @date       : 2014-11-18 00:00
 @revision	 :
*/

class Login extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('utility/login_log_model','login_log',TRUE);
	}
	
	function index()
	{
		$setting['sd_left']	= array('cur_menu'	=> "");
		$setting['page']	= array('pg_aktif'	=> "");
		$template			= $this->template->load($setting); #load static template file
		
		$data				= ""; #kirim data ke konten file
		$template['konten']	= $this->load->view('login_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container_popup',$template);
	}
	
	function login(){
	
	
	}
	
	public function create_session(){
		$data = $this->input->post('session');
		//$data = json_decode($data,true);
		//var_dump(IS_AJAX);
	//	var_dump($data);die;
		$this->my_session->set_userdata($data);
		$dataLog['user_id']  	=$this->my_session->userdata('user_id');
		$dataLog['user_name']	=$this->my_session->userdata('user_name');;
		$dataLog['unit_kerja_e1']=$this->my_session->userdata('unit_kerja_e1');;
		$dataLog['unit_kerja_e2']=$this->my_session->userdata('user_kerja_e2');;
		$this->login_log->insertLoginLog($dataLog);
		//var_dump($this->my_session->all_userdata());DIE;
		echo true;
		//redirect(base_url()."home");
	}
	
	
	public function logout(){
		//$this->my_session->sess_destroy();
		$this->session->sess_destroy();
		redirect(SSO_SERVER);
	}
	
}