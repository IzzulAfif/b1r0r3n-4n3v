<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-10-01 00:00
 @revision	 :
*/

class Kelompok_indikator_eselon1 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/admin/kel_indikator_model','kel_indikator');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
		$this->load->model('/laporan/kelompok_indikator_e1_model','indikator');
		$this->load->model('/laporan/kelompok_indikator_e2_model','indikator_e2');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(null);
		
		$template['konten']	= $this->load->view('laporan/kelompok_indikator_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadindikator()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(null);
		$data['kelompok_indikator'] = $this->kel_indikator->get_list(null);
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/kelompok_indikator_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_unit_kerja($e1){
		$data = $this->eselon2->get_all(array("kode_e1"=>$e1));
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
	
	function getindikator($kel_indikator,$tahun_awal,$tahun_akhir,$kode_e1,$kode_e2=null){
		//kode_E2 null = tampilkan Checkbox Eselon 2 nya tidak dicek
		$params['tahun'] = $tahun_awal;
		//$params['tahun_awal'] = $tahun_awal;
		//$params['tahun_akhir'] = $tahun_akhir;
		$params['kode_ss_kl'] = $kel_indikator;
		if (($kode_e1!="-1")&&($kode_e1!="0"))
			$params['kode_e1'] = $kode_e1;
		$data= $this->indikator->get_data($params);
		$showTahun = ($tahun_akhir-$tahun_awal)>0;
		$showUnitKerja = !isset($params['kode_e1']);
		
		$rs = '';$i=1;
		$head = '<table class="display table table-bordered table-striped" width="100%">';
		
		$head .= '
		<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center;width:10px">No.</th>'.						
					'<th style="vertical-align:middle;text-align:center;width:40px" >Kode</th>
					<th style="vertical-align:middle;text-align:center" >Indikator Kinerja Utama (IKU)</th>
					<th style="vertical-align:middle;text-align:center;width:40px" >Satuan</th>									
				</tr>';
					$rs .= 	'</tr></thead>';	
		$head .= '<tbody>';

		$foot = '</tbody>';		
		$foot .= '</table><br>';	
		//$rs .= 	'<tr>';
		$tahun ="";
		$unitkerja = "";
		$kode="";
		if (isset($data)){
			foreach($data as $d): 
				if ($unitkerja!=$d->nama_e1){
					$unitkerja=$d->nama_e1;
					if ($i>1) {
						$rs .=$foot;
						if ($kode_e2!=null){
							$rs .= $this->getindikator_e2($kel_indikator,$tahun_awal,$tahun_akhir,$kode,$kode_e2);
						}
					}
					$kode = $d->kode_e1;
					$i=1;
					$rs .= "<p class='text-info'><b>Unit Kerja Eselon I : ".$unitkerja.'</b></p>';
				//	$rs .= "<p class='text-info'><b>Tahun : ".$d->tahun.'</b></p>';
					$rs .= $head;
				}
				if ($tahun!=$d->tahun){
					$tahun=$d->tahun;
					
				}
				$rs .= '<tr class="gradeX">
					<td>'.($i++).'</td>'					
					.'<td>'.$d->kode_iku_e1.'</td>					
					<td>'.$d->indikator_e1.'</td>					
					<td>'.$d->satuan.'</td>					
					
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td>&nbsp;</td>'
					
					.'<td>&nbsp;</td>				
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
		}
		$rs .= $foot;
		
		echo $rs;
	}
	
	function getindikator_e2($kel_indikator,$tahun_awal,$tahun_akhir,$kode_e1,$kode_e2){
		$params['tahun'] = $tahun_awal;
		$params['kode_ss_kl'] = $kel_indikator;
		if (($kode_e1!="-1")&&($kode_e1!="0"))
			$params['kode_e1'] = $kode_e1;
		if (($kode_e2!="-1")&&($kode_e2!="0"))
			$params['kode_e2'] = $kode_e2;
		$data= $this->indikator_e2->get_data($params);
		$showTahun = ($tahun_akhir-$tahun_awal)>0;
		$showUnitKerja = !isset($params['kode_e2']);
		
		$rs = '';$i=1;
		$head = '<table class="display table table-bordered table-striped" width="100%">';
		
		$head .= '
		<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center;width:10px">No.</th>'.						
					'<th style="vertical-align:middle;text-align:center;width:60px" >Kode</th>
					<th style="vertical-align:middle;text-align:center" >Indikator Kinerja Kegiatan (IKK)</th>
					<th style="vertical-align:middle;text-align:center;width:40px" >Satuan</th>	
				</tr>';
					$head .= 	'</tr></thead>';	
		$head	 .= '<tbody>';	
		
		
		 $foot = '</tbody>';		
		 $foot .= '</table><br>';
		//$rs .= 	'<tr>';
		$tahun ="";
		$unitkerja = "";
		if (isset($data)){
			foreach($data as $d): 
				if ($unitkerja!=$d->nama_e2){
					$unitkerja=$d->nama_e2;
					if ($i>1) $rs .=$foot;
					$i=1;
					$rs .= "<p class='text-info'><b>Unit Kerja Eselon II : ".$unitkerja.'</b></p>';
				//	$rs .= "<p class='text-info'><b>Tahun : ".$d->tahun.'</b></p>';
					$rs .= $head;
				}
				if ($tahun!=$d->tahun){
					$tahun=$d->tahun;
					
				}
				$rs .= '<tr class="gradeX">
					<td>'.($i++).'</td>'					
					.'<td>'.$d->kode_ikk.'</td>					
					<td>'.$d->indikator_e2.'</td>					
					<td>'.$d->satuan.'</td>					
					
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td>&nbsp;</td>'
				.'<td>&nbsp;</td>				
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
		}
		
		$rs .= $foot;
		return $rs;
	}
	
	function getindikator_old($kel_indikator,$tahun_awal,$tahun_akhir,$kode_e1){
		$params['tahun_awal'] = $tahun_awal;
		$params['tahun_akhir'] = $tahun_akhir;
		$params['kode_ss_kl'] = $kel_indikator;
		if (($kode_e1!="-1")&&($kode_e1!="0"))
			$params['kode_e1'] = $kode_e1;
		$data= $this->indikator->get_data($params);
		$showTahun = ($tahun_akhir-$tahun_awal)>0;
		$showUnitKerja = !isset($params['kode_e1']);
		
		$rs = '';$i=1;
		$rs = '<table class="display table table-bordered table-striped" width="100%">';
		
		$rs .= '
		<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center">No.</th>'.					
					($showTahun?'<th style="vertical-align:middle;text-align:center" >Tahun</th>':'').
					($showUnitKerja?'<th style="vertical-align:middle;text-align:center" >Unit Kerja</th>':'').
					'<th style="vertical-align:middle;text-align:center" >Kode IKU Eselon I</th>
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
					($showUnitKerja?'<td>'.$d->nama_e1.'</td>':'')
					
					.'<td>'.$d->kode_iku_e1.'</td>					
					<td>'.$d->indikator_e1.'</td>					
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