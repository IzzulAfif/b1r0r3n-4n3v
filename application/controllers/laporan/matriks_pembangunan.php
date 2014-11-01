<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-18 17:00
 @revision	 :
*/

class Matriks_pembangunan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
	//	$this->load->model('/unit_kerja/eselon1_model','eselon1');
	//	$this->load->model('/unit_kerja/kl_model','kl');
	//	$this->load->model('/perencanaan/sasaran_kl_model','sasaran_kl');
	//	$this->load->model('/perencanaan/program_eselon1_model','program_e1');
	//	$this->load->model('/pemrograman/sasaran_strategis_model','sasaran_strategis');
	//	$this->load->model('/pemrograman/iku_kl_model','iku_kl');
	//	$this->load->model('/laporan/matriks_pembangunan_model','matriks');
		//$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$setting['header']	= '';
		$setting['sd_right']	= '';
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
	//	$data['renstra']	= $this->tahun_renstra->get_list(null);
		$template['konten']	= $this->load->view('laporan/matriks_pembangunan_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	
}