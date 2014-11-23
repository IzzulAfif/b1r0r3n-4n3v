<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup JS
 @date       : 2014-09-02 00:00
 @revision	 :
*/

class Pengaturan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
		$this->load->model('/admin/webservice_model','webservice');
		
		
	}
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "ADMIN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file
		
		$data['data']		= null;//
		$template['konten']	= $this->load->view('admin/pengaturan_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadtahunrenstra(){		
		$data['data'] = $this->tahun_renstra->get_all(null);	
		echo $this->load->view('admin/tahun_renstra_v',$data,true); #load konten template file		
	}
	
	function loadwebservice(){		
		$data['data'] = $this->webservice->get_all(null);	
		echo $this->load->view('admin/webservice_v',$data,true); #load konten template file		
	}
	
	function loadinfo(){
		$data['info_text']	= $this->mgeneral->getValue("info",array('info_id'=>"1"),"anev_info");
		echo $this->load->view('admin/info_v',$data,true); #load konten template file		
	}
	
	function save_info()
	{
		$info = $this->input->post("info");
		$cekInfo = $this->mgeneral->getWhere(array('info_id'=>"1"),"anev_info");
		
		$varData = array('info_id'	=> "1",
						 'info'		=> $info);
		if(count($cekInfo)==0):	
			$this->mgeneral->save($varData,"anev_info");
		else:
			$this->mgeneral->update(array('info_id'=>"1"),$varData,"anev_info");
		endif;		
		
		redirect("admin/pengaturan");
	}
	
}