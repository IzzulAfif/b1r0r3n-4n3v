<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-10-01 00:00
 @revision	 :
*/

class Kelompok_indikator extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/kl_model','kl');
		$this->load->model('/admin/kel_indikator_model','kel_indikator');
		$this->load->model('/laporan/kelompok_indikator_kl_model','kel_indikator_kl');
		$this->load->model('/laporan/kelompok_indikator_e1_model','kel_indikator_e1');
		$this->load->model('/laporan/kelompok_indikator_e2_model','kel_indikator_e2');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		$data['kelompok_indikator'] = $this->kel_indikator->get_list(null);
		$template['konten']	= $this->load->view('laporan/kelompok_indikator_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	
	function get_unit_kerja($kl){
		$data = $this->eselon1->get_all(array("kode_kl"=>$kl));
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
	
	
	function getindikator($kel_indikator,$tahun_awal,$tahun_akhir){
		$params['tahun_awal'] = $tahun_awal;
		$params['tahun_akhir'] = $tahun_akhir;
		$params['kode_ss_kl'] = $kel_indikator;
	//	$params['kode_kl'] = $kode_kl;
		$data= $this->indikator->get_data($params);
		$showTahun = ($tahun_akhir-$tahun_awal)>0;
		
		$rs = '';$i=1;
		$rs = '<table class="display table table-bordered table-striped" width="100%">';
		
		$rs .= '
		<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center">No.</th>'.					
					($showTahun?'<th style="vertical-align:middle;text-align:center" >Tahun</th>':'').
					'<th style="vertical-align:middle;text-align:center" >Kode IKU KL</th>
					<th style="vertical-align:middle;text-align:center" >Deskripsi</th>
					<th style="vertical-align:middle;text-align:center" >Satuan</th>					
				</tr>';
					$rs .= 	'</tr></thead>';	
		$rs .= '<tbody>';	
		//$rs .= 	'<tr>';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.($i++).'</td>'.
					($showTahun?'<td>'.$d->tahun.'</td>':'')
					
					.'<td>'.$d->kode_iku_kl.'</td>					
					<td>'.$d->indikator_kl.'</td>					
					<td>'.$d->satuan.'</td>					
					
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td>&nbsp;</td>'.
					($showTahun?'<td> </td>':'')
					
					.'<td>&nbsp;</td>				
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
		}
		
		 $rs .= '</tbody>';		
		 $rs .= '</table>';
		echo $rs;
	}
	
   function print_pdf($tahun,$kl)
   {
	   $this->load->library('pdf');
	   $data['renstra']		= $tahun;
	   $data['kementerian'] = $this->mgeneral->getValue("nama_kl",array('kode_kl'=>$kl,'tahun_renstra'=>$tahun),"anev_kl");
	   $data['unit_kerja']	= $this->eselon1->get_all(array("kode_kl"=>$kl));
	   $data['fungsi']		= $this->fungsi_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
	   $data['tugas']		= $this->kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
	   
	   $html = $this->load->view('laporan/print/pdf_profile_kl',$data,true);
	   
	   echo $this->pdf->cetak($html,"profile_kementerian.pdf");
   }
	
}