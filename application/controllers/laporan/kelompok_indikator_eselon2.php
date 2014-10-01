<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-10-01 00:00
 @revision	 :
*/

class Kelompok_indikator_eselon2 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/admin/kel_indikator_model','kel_indikator');
		$this->load->model('/laporan/kelompok_indikator_e2_model','indikator');
		
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(array("check_locking"=>true));
		$template['konten']	= $this->load->view('laporan/kelompok_indikator_eselon2_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadindikator()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(array("check_locking"=>true));
		$data['kelompok_indikator'] = $this->kel_indikator->get_list(null);
		echo $this->load->view('laporan/kelompok_indikator_eselon2_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_list_eselon1()
	{
		$params = null;//array("check_locking"=>true);
		echo json_encode($this->eselon1->get_list($params));
	}
	
	function get_list_eselon2($kode_e1)
	{
		$params = array("kode_e1"=>$kode_e1);
		echo json_encode($this->eselon2->get_list($params));
	}
	
	function get_unit_kerja($e2){
		$data = $this->eselon2->get_all(array("kode_e2"=>$e2));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->nama_e2.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function getindikator($kel_indikator,$tahun_awal,$tahun_akhir,$kode_e1,$kode_e2){
		$params['tahun_awal'] = $tahun_awal;
		$params['tahun_akhir'] = $tahun_akhir;
		$params['kode_ss_kl'] = $kel_indikator;
		if (($kode_e1!="-1")&&($kode_e1!="0"))
			$params['kode_e1'] = $kode_e1;
		if (($kode_e2!="-1")&&($kode_e2!="0"))
			$params['kode_e2'] = $kode_e2;
		$data= $this->indikator->get_data($params);
		$showTahun = ($tahun_akhir-$tahun_awal)>0;
		$showUnitKerja = !isset($params['kode_e2']);
		
		$rs = '';$i=1;
		$rs = '<table class="display table table-bordered table-striped" width="100%">';
		
		$rs .= '
		<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center">No.</th>'.					
					($showTahun?'<th style="vertical-align:middle;text-align:center" >Tahun</th>':'').
					($showUnitKerja?'<th style="vertical-align:middle;text-align:center" >Unit Kerja</th>':'').
					'<th style="vertical-align:middle;text-align:center" >Kode IKK</th>
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
					($showTahun?'<td>'.$d->tahun.'</td>':'').
					($showUnitKerja?'<td>'.$d->nama_e2.'</td>':'')
					
					.'<td>'.$d->kode_ikk.'</td>					
					<td>'.$d->indikator_e2.'</td>					
					<td>'.$d->satuan.'</td>					
					
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td>&nbsp;</td>'.
					($showTahun?'<td> </td>':'').
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
	


}