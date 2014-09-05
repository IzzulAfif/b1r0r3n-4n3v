<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-09-02 00:00
 @revision	 :
*/

class Capaian_kinerja_eselon1 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
		$this->load->model('/laporan/capaian_kinerja_e1_model','capaian');
		$this->load->model('/pemrograman/sasaran_strategis_model','sastra');
		$this->load->model('/pemrograman/sasaran_program_model','sasprog');
		
		
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(null);
		$template['konten']	= $this->load->view('laporan/capaian_kinerja_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loaddata()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(null);
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/capaian_kinerja_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_sasaran($tahun_awal,$tahun_akhir)
	{
		$params['tahun_renstra'] = $tahun_awal.'-'.$tahun_akhir;
		echo json_encode($this->sastra->get_list($params));
	}
	
	
	function get_capaian($range_awal,$range_akhir,$kode_ss_kl){
		$dataAll = array();
		$data = $this->sasprog->get_all(array("kode_ss_kl"=>$kode_ss_kl,"tahun_renstra"=>$range_awal.'-'.$range_akhir));
		//$arrTahun = explode("-",$tahun);		
		//$rangetahun = $arrTahun[1]-$arrTahun[0];
		$rangetahun = $range_akhir-$range_awal;
		$rs = '<table class="display table table-bordered table-striped" width="100%">';
		
		$rs .= '
		<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center"   rowspan="3">Sasaran Program</th>					
					<th style="vertical-align:middle;text-align:center" rowspan="3">Indikator</th>
					<th style="vertical-align:middle;text-align:center"  rowspan="3">Satuan</th>
					<th style="vertical-align:middle;text-align:center"   colspan="'.(($rangetahun+1)*3).'">Realisasi Pencapaian</th>
					
				</tr>';
		$rs .= 	'<tr>';
		$rangetahun_arr = array();
		//for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)
		for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
			$rs .= 	'<th style="vertical-align:middle;text-align:center" colspan="3">'.$colTahun.'</th>';
			$rangetahun_arr[] = $colTahun;
		}	
		$rs .= 	'</tr>';	
		$rs .= 	'<tr>';	
		for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
			$rs .= 	'<th style="vertical-align:middle;text-align:center" >Target</th>';
			$rs .= 	'<th style="vertical-align:middle;text-align:center" >Realisasi</th>';
			$rs .= 	'<th style="vertical-align:middle;text-align:center" >Persen</th>';
			$rangetahun_arr[] = $colTahun;
		}	
					
		$rs .= 	'</tr></thead>';	
		$rs .= '<tbody>';		
		$i=0;
		 $j=0;
		$kode_sp_e1 = '';
		foreach($data as $d){
			if ($kode_sp_e1 != $d->kode_sp_e1){
				$kode_sp_e1 = $d->kode_sp_e1;
			} else {
				continue;
			}
			$data_indikator = $this->capaian->get_indikator(array("kode_sp_e1"=>$d->kode_sp_e1,"range_awal"=>$range_awal,"range_akhir"=>$range_akhir));
			$kode_iku = '';
			$data[$i]->rowspan=0;
			if (isset($data_indikator)) {
				foreach($data_indikator as $ss){
					if ($kode_iku != $ss->kode_iku_e1){
						$kode_iku = $ss->kode_iku_e1;
						$data[$i]->indikator[$j]->deskripsi = $ss->deskripsi;
						$data[$i]->indikator[$j]->satuan = $ss->satuan;
						//for ($x=0;$x<count($rangetahun_arr);$x++){
							$data[$i]->indikator[$j]->target[$ss->tahun] = $ss->target;
							$data[$i]->indikator[$j]->realisasi[$ss->tahun] = $ss->realisasi;
							$data[$i]->indikator[$j]->persen[$ss->tahun] = $ss->persen;
						//}
						$data[$i]->rowspan++ ;
						$j++;
					}else{
						$data[$i]->indikator[$j-1]->target[$ss->tahun] = $ss->target;
						$data[$i]->indikator[$j-1]->realisasi[$ss->tahun] = $ss->realisasi;
						$data[$i]->indikator[$j-1]->persen[$ss->tahun] = $ss->persen;
					}
					//$data[$i]->indikator=$data_indikator;
					//$data[$i]->rowspan += sizeof($data[$i]->indikator);
				/*if (sizeof($data[$i]->indikator)>0){							
					$j=0;
					foreach($data_indikator as $ss){										
						$data[$i]->strategis[$j]->iku = $data_iku;					
						$data[$i]->strategis[$j]->rowspan = sizeof($data_iku);
						$j++;
					}			
				}
				*/
				}
			}
			$i++;
		 }
		 
		 $i=0;$kode_sp_e1 = '';
		 foreach($data as $d){
			if ($kode_sp_e1 != $d->kode_sp_e1){
				$kode_sp_e1 = $d->kode_sp_e1;
			} else {
				continue;
			}
			
			
			$rs .= '<tr>';
			if ($data[$i]->rowspan==0) 
				$rs .= '<td >'.$d->deskripsi.'</td>';
			else
				$rs .= '<td rowspan="'.($data[$i]->rowspan).'" >'.$d->deskripsi.'</td>';
			//$rs .= '<td >'.$d->sasaran_kl.'</td>';
			
			//$rs .= '</tr>';
			if (isset($data[$i]->indikator)) {	
				if ( sizeof($data[$i]->indikator)>0){				
					$j=0;				
					$textarea_opt = array("name"=>"txtKeterangan[]","rows"=>2,"cols"=>20);
					foreach($data[$i]->indikator as $ss){
						if ($j==0){
							$rs .= '<td    valign="top">'.$ss->deskripsi.'</td>';
							$rs .= '<td    valign="top">'.$ss->satuan.'</td>';
							for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
								$target = isset($ss->target[$colTahun])?$ss->target[$colTahun]:'-';
								$realisasi = isset($ss->realisasi[$colTahun])?$ss->realisasi[$colTahun]:'-';
								$persen = isset($ss->persen[$colTahun])?$ss->persen[$colTahun]:'-';
								$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($target).'</td>';
								$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
								$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($persen).'</td>';
							}
							//$rs .= '<td    valign="top">'.form_textarea($textarea_opt).'</td>';			
							$rs .= '</tr>';
						}
						else {						
							$rs .= '<tr>';
							$rs .= '<td   valign="top">'.$ss->deskripsi.'</td>';
							$rs .= '<td    valign="top">'.$ss->satuan.'</td>';
							for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
								$target = isset($ss->target[$colTahun])?$ss->target[$colTahun]:'-';
								$realisasi = isset($ss->realisasi[$colTahun])?$ss->realisasi[$colTahun]:'-';
								$persen = isset($ss->persen[$colTahun])?$ss->persen[$colTahun]:'-';
								$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($target).'</td>';
								$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
								$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($persen).'</td>';
							}
							//$rs .= '<td    valign="top">'.form_textarea($textarea_opt).'</td>';			
							$rs .= '</tr>';
						}					
						
						
									
						$j++;
					}			
				}
				else { 				
				}
			}else {
				$rs .= '<td >&nbsp;</td>';
				$rs .= '<td >&nbsp;</td>';
				$rs .= '<td >&nbsp;</td>';
				for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
					$rs .= '<td >&nbsp;</td>';
					$rs .= '<td >&nbsp;</td>';
					$rs .= '<td >&nbsp;</td>';
				}
			//	$rs .= '<td >&nbsp;</td>';
				$rs .= '</tr>';
			}
			
			$i++;
		 }
		 $rs .= '</tbody>';		
		 $rs .= '</table>';
		
		echo $rs;
	}
	
	function get_tugas($tahun,$e1){
		$data = $this->eselon1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->tugas_e1.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}

}