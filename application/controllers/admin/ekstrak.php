<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup JS
 @date       : 2014-08-15 00:00
 @revision	 :
*/

class Ekstrak extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('/admin/ekstrak_emon_model','emon');
		$this->load->model('/admin/ekstrak_eperformance_model','eperformance');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		
	}
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "ADMIN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file
		
		$data['data']		= null;//
		$template['konten']	= $this->load->view('admin/ekstrak_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loademon()
	{
		$data['data'] = null;//$this->fungsi->get_all(null);
		$data['tipe_data'] = $this->emon->get_list();
		$data['eselon1']	= $this->eselon1->get_list(null);
		$data['tahun_renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('admin/ekstrak_emon_v',$data,true); #load konten template file		
	}
	
	function loadeperformance()
	{		
		$data['data'] = null;//$this->fungsi->get_all(null);
		$data['tipe_data'] = $this->eperformance->get_list();
		$data['tahun_renstra']	= $this->tahun_renstra->get_list(null);		
		echo $this->load->view('admin/ekstrak_eperformance_v',$data,true); #load konten template file		
	}	
		
}