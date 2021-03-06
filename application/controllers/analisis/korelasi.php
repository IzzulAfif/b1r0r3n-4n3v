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
		$gdata1				= $this->get_data_kl($this->input->post("tahun1"), $this->input->post("tahun2"),$this->input->post("indikator"),$this->input->post("sasaran"),"1");
		$gdata2				= $this->get_data_kl($this->input->post("tahun1"), $this->input->post("tahun2"),$this->input->post("indikator2"),$this->input->post("sasaran2"),"2");
		
		$data['post']		= $this->input->post();
		$data['title1']		= $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$this->input->post("sasaran"),'kode_iku_kl'=>$this->input->post("indikator")),"anev_iku_kl");
		$data['title2']		= $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$this->input->post("sasaran2"),'kode_iku_kl'=>$this->input->post("indikator2")),"anev_iku_kl");
		$data['gdata1'] 	= $gdata1;
		$data['gdata2']		= $gdata2;
		$data['tahun1']		= $this->input->post("tahun1");
		$data['tahun2']		= $this->input->post("tahun2");
		$this->load->view('analisis/korelasi_grafik',$data);
	}
	
	function get_data_kl($tahun1,$tahun2,$indikator,$sasaran,$tipe)
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
						if($tipe==2):
							$persen = ((2*$d->target-$d->realisasi)/$d->target)*100;
						else:
							$persen = ($d->realisasi/$d->target)*100;
						endif;
						$total_persen = $total_persen+$persen;
					else:
						$persen = 100;
						$total_persen = $total_persen+$persen;
					endif;
				endforeach;
				$rata2 = $total_persen/count($data);
				$total_persen_es1 = $total_persen_es1+$rata2;
				$total_es1++;
				$graf_data[] = array('kode'		=> $e1->kode_e1,
									 'nama'		=> $e1->singkatan,
									 'detail'	=> $data,
								   	 'rata2'	=> number_format($rata2,2,'.','.'));
			endif;
		endforeach;
		
		$dataKL	= $this->analisis_model->get_capaian_kinerja_kl($indikator,$tahun1,$tahun2);
		$total_persen = 0;
		
		
		if (count($dataKL)==0) {
			/*echo "<script>alert('Data tidak ada');</script>";*/
			return;
		}
		
		
		foreach($dataKL as $kl):
			if($d->target!="0" && $kl->target!=""):
				if($tipe==2):
					$persen = ((2*$kl->target-$kl->realisasi)/$kl->target)*100;
				else:
					$persen = ($kl->realisasi/$kl->target)*100;
				endif;
				$total_persen = $total_persen+$persen;
			else:
				$persen = 100;
				$total_persen = $total_persen+$persen;
			endif;
		endforeach;
		$rata2kl = $total_persen/count($dataKL);
		$graf_data[] = array('kode'	=> "022",
							 'nama'	=> "Kementerian",
							 'detail'	=> $dataKL,
							 'rata2'=> number_format($rata2kl,2,'.','.'));
							 
		$rata2total = number_format(($total_persen_es1+$rata2kl)/($total_es1+1),2,'.','.');
		$dataReturn = array('gdata'	=> $graf_data,
							'rata2'	=> $rata2total);
		return $dataReturn;
	}
	
	function proses_e1()
	{
		$e1 = $this->input->post("unit_kerja");
		$gdata1				= $this->get_data_e1($e1,$this->input->post("tahun1"), $this->input->post("tahun2"),$this->input->post("indikator"),$this->input->post("sasaran"),"1");
		$gdata2				= $this->get_data_e1($e1,$this->input->post("tahun1"), $this->input->post("tahun2"),$this->input->post("indikator2"),$this->input->post("sasaran2"),"2");
		
		$data['post']		= $this->input->post();
		$data['title1']		= $this->mgeneral->getValue("deskripsi",array('kode_sp_e1'=>$this->input->post("sasaran"),'kode_iku_e1'=>$this->input->post("indikator")),"anev_iku_eselon1");
		$data['title2']		= $this->mgeneral->getValue("deskripsi",array('kode_sp_e1'=>$this->input->post("sasaran2"),'kode_iku_e1'=>$this->input->post("indikator2")),"anev_iku_eselon1");
		$data['gdata1'] 	= $gdata1;
		$data['gdata2']		= $gdata2;
		$data['tahun1']		= $this->input->post("tahun1");
		$data['tahun2']		= $this->input->post("tahun2");
		$this->load->view('analisis/korelasi_grafik',$data);
	}
	
	function get_data_e1($e1,$tahun1,$tahun2,$indikator,$sasaran,$tipe)
	{
		$kodee1	 = $e1;
		$namae1	 = $this->mgeneral->getValue("singkatan",array("kode_e1"=>$e1),"anev_eselon1");
		$eselon1 = $this->mgeneral->getWhere(array("kode_e1"=>$e1),"anev_eselon2");
		$graf_data		  = array();
		$total_persen_es1 = 0;
		$total_es1		  = 0;
		
		foreach($eselon1 as $e1):
			$data = $this->analisis_model->get_detail_capaian_kinerja2($e1->kode_e2,$indikator,$tahun1,$tahun2,$sasaran);
			$total_persen = 0;
			if(count($data)!=0):
				foreach($data as $d):
					if($d->target!="0" && $d->target!="" && is_numeric($d->target)):
						if($tipe==2):
							$persen = ((2*$d->target-$d->realisasi)/$d->target)*100;
						else:
							#echo $d->target."<Br>";
							$persen = ($d->realisasi/$d->target)*100;
						endif;
						$total_persen = $total_persen+$persen;
					else:
						$persen = 100;
						$total_persen = $total_persen+$persen;
					endif;
				endforeach;
				$rata2 = $total_persen/count($data);
				$total_persen_es1 = $total_persen_es1+$rata2;
				$total_es1++;
				$graf_data[] = array('kode'		=> $e1->kode_e2,
									 'nama'		=> $e1->singkatan,
								   	 'detail'	=> $data,
									 'rata2'	=> number_format($rata2,2,'.','.'));
			endif;
		endforeach;
		
		$data = $this->analisis_model->get_detail_capaian_kinerja3($kodee1,$indikator,$tahun1,$tahun2,$sasaran);
		$total_persen = 0;
		if(count($data)!=0):
			foreach($data as $d):
				if($d->target!="0" && $d->target!=""):
					if($tipe==2):
						$persen = ((2*$d->target-$d->realisasi)/$d->target)*100;
					else:
						$persen = ($d->realisasi/$d->target)*100;
					endif;
					$total_persen = $total_persen+$persen;
				else:
					$persen = 100;
					$total_persen = $total_persen+$persen;
				endif;
			endforeach;
			$rata2 = $total_persen/count($data);
			$total_persen_es1 = $total_persen_es1+$rata2;
			$total_es1++;
			$graf_data[] = array('kode'		=> $kodee1,
								 'nama'		=> $namae1,
								 'detail'	=> $data,
								 'rata2'	=> number_format($rata2,2,'.','.'));
		endif;
									 
		if($total_es1!=0): $rata2total = number_format($total_persen_es1/$total_es1,2,'.','.'); else: $rata2total = 0; endif;	
		
		$dataReturn = array('gdata'	=> $graf_data,
							'rata2'	=> $rata2total);
		return $dataReturn;
	}
}