<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : didin
 @date       : 2014-11-04 00:00
 @revision	 :
*/

class dsb_kl extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('evaluasi/program_m','',TRUE);
		$this->load->model('/admin/tahun_renstra_model','setting_th');
	}

	function index()
	{
		$renstra = $this->input->post("renstra");
		
		if($renstra==""):
			$renstra = $this->program_m->get_renstra_list();
			end($renstra);         // move the internal pointer to the end of the array
			$key = key($renstra);  // fetches the key of the element pointed to by the internal pointer
		else:
			$key = $renstra;
		endif;
		
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "DASHBOARD");
		$setting['page']	= array('pg_aktif'	=> "chart");
		$data['renstra']	= $this->setting_th->get_list();
		//$setting = null;
		$template			= $this->template->load($setting); #load static template file		
		
		$tahun				= explode("-",$key);
		
		
		$dRealisasi	= $this->program_m->get_rata2_capain_kinerja("", $tahun[0], $tahun[1]);
		$dSerapan	= $this->program_m->get_rata2_serapan_anggaran2("", $tahun[0], $tahun[1]);
		
		$graphRealisasi  = array();
		if(isset($dRealisasi)):
			foreach($dRealisasi as $dr):
				$graphRealisasi[$dr->tahun] = number_format($dr->persen,0);
			endforeach;
		endif;
		
		$graphSerapan	= array();
		if(isset($dSerapan)):
			foreach($dSerapan as $ds):
				$graphSerapan[$ds->tahun]	= number_format($ds->persen,0);
			endforeach;
		endif;
		
		$data['capaianKl']		= $graphRealisasi;
		$data['dCapaianKl']		= $this->program_m->get_detail_capain_kinerja("", $tahun[0], $tahun[1]);
		$data['serapanKl']		= $graphSerapan;
		$data['tahun1']			= $tahun[0];
		$data['tahun2']			= $tahun[1];
		$template['konten']		= $this->load->view('dashboard/dashboard_kl',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
}