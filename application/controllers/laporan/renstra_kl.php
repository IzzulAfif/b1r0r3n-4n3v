<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-16 00:00
 @revision	 :
*/

class Renstra_kl extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/perencanaan/visi_kl_model','visi_kl');
		$this->load->model('/perencanaan/misi_kl_model','misi_kl');
		$this->load->model('/perencanaan/tujuan_kl_model','tujuan_kl');
		$this->load->model('/perencanaan/sasaran_kl_model','sasaran_kl');
		$this->load->model('/perencanaan/sasaran_strategis_model','sasaran_strategis');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
		$template['konten']	= $this->load->view('laporan/renstra_kl_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	
	function get_visi($tahun,$kl){
		$data = $this->visi_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		//var_dump($data);
		$rs = '<ol>';
		foreach($data as $d){
			$rs .= '<li>'.$d->visi_kl.'</li>';
		 }
		 $rs .= '</ol>';
		echo $rs;
	}
	
	function get_misi($tahun,$kl){
		$data = $this->misi_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		
		$rs = '<ol>';
		foreach($data as $d){
			$rs .= '<li>'.$d->misi_kl.'</li>';
		 }
		 $rs .= '</ol>';
		echo $rs;
	}
	
	function get_tujuan($tahun,$kl){
		$data = $this->tujuan_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		
		$rs = '<ol>';
		foreach($data as $d){
			$rs .= '<li>'.$d->tujuan_kl.'</li>';
		 }
		 $rs .= '</ol>';
		echo $rs;
	}
	
	function get_sasaran($tahun,$kl){
		$data = $this->sasaran_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		
		$rs = '<table class="table">';
		$rs .= '<tr>
					<td width="30%">Sasaran</td>
					<td width="40%">Sasaran Strategis</td>
					<td width="30%">Indikator</td>
				</tr>';
		foreach($data as $d){
			$data_strategis = $this->sasaran_strategis->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun,"kode_sasaran_kl"=>$d->kode_sasaran_kl));
			$jml_data_strategis = count($data_strategis);
			
			
			$rs .= '<tr>';
			$rs .= '<td >'.$d->sasaran_kl.'</td>';
			if ($jml_data_strategis>0){
				$rs .= '<td>';
				$rs .="<ol>";
				foreach($data_strategis as $ss){
						$rs .= '<li>'.$ss->deskripsi.'</li>';
				}
				$rs .="</ol>";
				$rs .= '</td>';
			}
			else 
				$rs .= '<td></td>';
			$rs .= '<td></td>';
			
		 }
		 $rs .= '</table>';
		echo $rs;
	}
	
	
}