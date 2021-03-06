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
		$this->load->model('evaluasi/sasaran_strategis_m','',TRUE);
		$this->load->model('analisis/analisis_model','',TRUE);
	}
	
	function index()
	{
		$data['kl']			= $this->mgeneral->getAll("anev_kl");
		$this->load->view('analisis/cross_section',$data);
	}
	
	function eselon1()
	{
		$data['esselon1']	= $this->mgeneral->getAll("anev_eselon1");
		$this->load->view('analisis/cross_section_e1',$data);
	}
	
	function proses_kl()
	{
		$eselon1 = $this->mgeneral->getAll("anev_eselon1");
		$graf_data		  = array();
		$total_persen_es1 = 0;
		$total_es1		  = 0;
		$detail_data	  = "";
		foreach($eselon1 as $e1):
			$data = $this->analisis_model->get_detail_capaian_kinerja($e1->kode_e1,$this->input->post("indikator"),$this->input->post("tahun1"), $this->input->post("tahun2"),$this->input->post("sasaran"));
			$total_persen = 0;
			if(count($data)!=0):
				foreach($data as $d):
					if($d->target!="0" && $d->target!=""):
						$persen = ((2*$d->target-$d->realisasi)/$d->target)*100;
						$total_persen = $total_persen+$persen;
					else:
						$persen = 100;
						$total_persen = $total_persen+$persen;
					endif;
				endforeach;
				$rata2 = $total_persen/count($data);
				$total_persen_es1 = $total_persen_es1+$rata2;
				$total_es1++;
				$graf_data[] = array('nama'		=> $e1->singkatan,
									 'detail'	=> $data,
								   	 'rata2'	=> number_format($rata2,2,'.','.'),
									 'color'	=> "-");
			endif;
		endforeach;
		
		$dataKL	= $this->analisis_model->get_capaian_kinerja_kl($this->input->post("indikator"),$this->input->post("tahun1"), $this->input->post("tahun2"));
		$total_persen = 0;
		
		$rata2total = 0;
		if (count($dataKL)!=0) {
		
		foreach($dataKL as $kl):
			if($d->target!="0" && $kl->target!=""):
				$persen = ((2*$kl->target-$kl->realisasi)/$kl->target)*100;
				$total_persen = $total_persen+$persen;
			else:
				$persen = 100;
				$total_persen = $total_persen+$persen;
			endif;
		endforeach;
		$rata2 = $total_persen/count($dataKL);
		$graf_data[] = array('nama'		=> "Kementerian",
							 'detail'	=> $dataKL,
							 'rata2'	=> number_format($rata2,2,'.','.'),
							 'color'	=> "DB843D");
		
		$rata2total = number_format($total_persen_es1/$total_es1,2,'.','.');
		
		}
		$data['post']		= $this->input->post();
		$data['title']		= $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$this->input->post("sasaran"),'kode_iku_kl'=>$this->input->post("indikator")),"anev_iku_kl");
		$data['gdata'] 		= $graf_data;
		$data['rata2']		= $rata2total;
		$data['subtitle']	= "dari Tahun ".$this->input->post("tahun1")." s.d. ".$this->input->post("tahun2");
		$this->load->view('analisis/cross_section_grafik',$data);
	}
	
	function proses_e1()
	{
		$eselon2 = $this->mgeneral->getWhere(array('kode_e1'=>$this->input->post("unit_kerja")),"anev_eselon2");
		$graf_data		  = array();
		$total_persen_es1 = 0;
		$total_es1		  = 0;
		
		foreach($eselon2 as $e2):
			$data = $this->analisis_model->get_capaian_kinerja_e1($e2->kode_e2,$this->input->post("tahun1"), $this->input->post("tahun2"),$this->input->post("sasaran"),$this->input->post("indikator"));
				
				$total_persen = 0;
				if(count($data)!=0):
					foreach($data as $d):
						if($d->target!="0" && $d->target!=""):
							$target 	= (is_numeric($d->target)?$d->target:1);
							$realisasi	= (is_numeric($d->realisasi)&&$d->realisasi!=0?$d->realisasi:1);
							$persen 	= ((2*$target-$realisasi)/$target)*100;
							$total_persen = $total_persen+$persen;
						else:
							$persen = 100;
							$total_persen = $total_persen+$persen;
						endif;
					endforeach;
					$rata2 = $total_persen/count($data);
					$total_persen_es1 = $total_persen_es1+$rata2;
					$total_es1++;
					$graf_data[] = array('nama'		=> $e2->singkatan,
										 'detail'	=> $data,
								   	 	 'rata2'	=> number_format($rata2,2,'.','.'),
										 'color'	=> "-");
									 
				endif;
			
		endforeach;
		#echo "<pre>";
		#print_r($graf_data);
		$dataKL	= $this->analisis_model->get_capaian_kinerja_eselon1($this->input->post("indikator"),$this->input->post("tahun1"), $this->input->post("tahun2"));
		
		$total_persen = 0;
		if (count($dataKL)==0) {
			echo "<script>alert('Data tidak ada');</script>";
			return;
		}
		
		#print_r($dataKL);
		foreach($dataKL as $kl):
			if($kl->target!="0" && $kl->target!="" && is_numeric($kl->target)):
				$persen = ((2*$kl->target-$kl->realisasi)/$kl->target)*100;
				$total_persen = $total_persen+$persen;
			else:
				$persen = 100;
				$total_persen = $total_persen+$persen;
			endif;
		endforeach;
		$e1Nama= $this->mgeneral->getValue("singkatan",array('kode_e1'=>$this->input->post("unit_kerja")),"anev_eselon1");
		$rata2 = $total_persen/count($dataKL);
		$graf_data[] = array('nama'		=> $e1Nama,
							 'detail'	=> $dataKL,
							 'rata2'	=> number_format($rata2,2,'.','.'),
							 'color'	=> "DB843D");
							 
		if($total_es1!=0): $rata2total = number_format($total_persen_es1/$total_es1,2,'.','.'); else: $rata2total = 0; endif;
		
		$data['post']		= $this->input->post();
		$data['title']		= $this->mgeneral->getValue("deskripsi",array('kode_sp_e1'=>$this->input->post("sasaran"),'kode_iku_e1'=>$this->input->post("indikator")),"anev_iku_eselon1");
		$data['gdata'] 		= $graf_data;
		$data['rata2']		= $rata2total;
		$data['subtitle']	= "dari Tahun ".$this->input->post("tahun1")." s.d. ".$this->input->post("tahun2");
		$this->load->view('analisis/cross_section_grafik',$data);
	}
}