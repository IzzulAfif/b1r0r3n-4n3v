<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-22 00:00
 @revision	 :
*/

class Rencana_eselon1 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/kl_model','kl');
		
		$this->load->model('/perencanaan/visi_eselon1_model','visi');
		$this->load->model('/perencanaan/misi_eselon1_model','misi');
		$this->load->model('/perencanaan/tujuan_eselon1_model','tujuan');
		$this->load->model('/perencanaan/sasaran_eselon1_model','sasaran');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "PERENCANAAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		//$setting = null;
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
		$data['eselon1'] = $this->eselon1->get_list(null);
		$template['konten']	= $this->load->view('perencanaan/rencana_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadvisi()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PERENCANAAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->visi->get_all(null);
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('perencanaan/visi_eselon1_v',$data,true); #load konten template file		
	}
	
	function loadmisi()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PERENCANAAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->misi->get_all(null);
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('perencanaan/misi_eselon1_v',$data,true); #load konten template file		
	}
	
	function loadtujuan()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PERENCANAAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->tujuan->get_all(null);
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('perencanaan/tujuan_eselon1_v',$data,true); #load konten template file		
	}
	
	function loadsasaran()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PERENCANAAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->sasaran->get_all(null);
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('perencanaan/sasaran_eselon1_v',$data,true); #load konten template file		
	}
	
	
	function get_unit_kerja($kl){
		$data = $this->eselon1->get_all(array("kode_eselon1"=>$kl));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->nama_e1.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function get_fungsi($tahun,$kl){
		$data = $this->fungsi_eselon1->get_all(array("kode_eselon1"=>$kl,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->fungsi_eselon1.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function get_tugas($tahun,$kl){
		$data = $this->kl->get_all(array("kode_eselon1"=>$kl,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->tugas_eselon1.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	
}