<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-08-17 00:00
 @revision	 :
*/

class Korelasi extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('analisis/analisis_model','',TRUE);
	}
	
	function index()
	{
		$data['kl']			= $this->mgeneral->getAll("anev_kl");
		$this->load->view('analisis/korelasi',$data);
	}
	
	function eselon1()
	{
		$data['esselon1']	= $this->mgeneral->getAll("anev_eselon1");
		$this->load->view('analisis/korelasi_e1',$data);
	}
	
	function proses_kl()
	{
		$gdata1				= $this->get_data_kl($this->input->post("tahun1"), $this->input->post("tahun2"),$this->input->post("indikator"),$this->input->post("sasaran"));
		$gdata2				= $this->get_data_kl($this->input->post("tahun1"), $this->input->post("tahun2"),$this->input->post("indikator2"),$this->input->post("sasaran2"));
		
		$data['post']		= $this->input->post();
		$data['title1']		= $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$this->input->post("sasaran"),'kode_iku_kl'=>$this->input->post("indikator")),"anev_iku_kl");
		$data['title2']		= $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$this->input->post("sasaran2"),'kode_iku_kl'=>$this->input->post("indikator2")),"anev_iku_kl");
		$data['gdata1'] 	= $gdata1;
		$data['gdata2']		= $gdata2;
		$this->load->view('analisis/korelasi_grafik',$data);
	}
	
	function get_data_kl($tahun1,$tahun2,$indikator,$sasaran)
	{
		$eselon1 = $this->mgeneral->getAll("anev_eselon1");
		$graf_data		  = array();
		$total_persen_es1 = 0;
		$total_es1		  = 0;
		
		foreach($eselon1 as $e1):
			$data = $this->analisis_model->get_detail_capaian_kinerja($e1->kode_e1,$indikator,$tahun1,$tahun2,$sasaran);
			$total_persen = 0;
			if(count($data)!=0):
				foreach($data as $d):
					if($d->target!="0" && $d->target!=""):
						$persen = ($d->target/$d->realisasi)*100;
						$total_persen = $total_persen+$persen;
					endif;
				endforeach;
				$rata2 = $total_persen/count($data);
				$total_persen_es1 = $total_persen_es1+$rata2;
				$total_es1++;
				$graf_data[] = array('kode'		=> $e1->kode_e1,
									 'nama'		=> $e1->singkatan,
								   	 'rata2'	=> number_format($rata2,2,'.','.'));
			endif;
		endforeach;
		
		$rata2total = number_format($total_persen_es1/$total_es1,2,'.','.');	
		
		$dataReturn = array('gdata'	=> $graf_data,
							'rata2'	=> $rata2total);
		return $dataReturn;
	}
	
	function proses_e1()
	{
		$e1 = $this->input->post("unit_kerja");
		$gdata1				= $this->get_data_e1($e1,$this->input->post("tahun1"), $this->input->post("tahun2"),$this->input->post("indikator"),$this->input->post("sasaran"));
		$gdata2				= $this->get_data_e1($e1,$this->input->post("tahun1"), $this->input->post("tahun2"),$this->input->post("indikator2"),$this->input->post("sasaran2"));
		
		$data['post']		= $this->input->post();
		$data['title1']		= $this->mgeneral->getValue("deskripsi",array('kode_sp_e1'=>$this->input->post("sasaran"),'kode_iku_e1'=>$this->input->post("indikator")),"anev_iku_eselon1");
		$data['title2']		= $this->mgeneral->getValue("deskripsi",array('kode_sp_e1'=>$this->input->post("sasaran2"),'kode_iku_e1'=>$this->input->post("indikator2")),"anev_iku_eselon1");
		$data['gdata1'] 	= $gdata1;
		$data['gdata2']		= $gdata2;
		$this->load->view('analisis/korelasi_grafik',$data);
	}
	
	function get_data_e1($e1,$tahun1,$tahun2,$indikator,$sasaran)
	{
		$eselon1 = $this->mgeneral->getWhere(array("kode_e1"=>$e1),"anev_eselon2");
		$graf_data		  = array();
		$total_persen_es1 = 0;
		$total_es1		  = 0;
		
		foreach($eselon1 as $e1):
			$data = $this->analisis_model->get_detail_capaian_kinerja2($e1->kode_e2,$indikator,$tahun1,$tahun2,$sasaran);
			$total_persen = 0;
			if(count($data)!=0):
				foreach($data as $d):
					if($d->target!="0" && $d->target!=""):
						$persen = ($d->target/$d->realisasi)*100;
						$total_persen = $total_persen+$persen;
					endif;
				endforeach;
				$rata2 = $total_persen/count($data);
				$total_persen_es1 = $total_persen_es1+$rata2;
				$total_es1++;
				$graf_data[] = array('kode'		=> $e1->kode_e2,
									 'nama'		=> $e1->singkatan,
								   	 'rata2'	=> number_format($rata2,2,'.','.'));
			endif;
		endforeach;
		
		$rata2total = number_format($total_persen_es1/$total_es1,2,'.','.');	
		
		$dataReturn = array('gdata'	=> $graf_data,
							'rata2'	=> $rata2total);
		return $dataReturn;
	}
}