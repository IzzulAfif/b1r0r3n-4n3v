<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-18 17:00
 @revision	 :
*/

class Matriks_pembangunan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/perencanaan/visi_kl_model','visi_kl');
		$this->load->model('/perencanaan/misi_kl_model','misi_kl');
		$this->load->model('/perencanaan/tujuan_kl_model','tujuan_kl');
		$this->load->model('/perencanaan/sasaran_kl_model','sasaran_kl');
		$this->load->model('/perencanaan/program_eselon1_model','program_e1');
		$this->load->model('/perencanaan/sasaran_strategis_model','sasaran_strategis');
		$this->load->model('/perencanaan/iku_kl_model','iku_kl');
		$this->load->model('/laporan/matriks_pembangunan_model','matriks');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$setting['header']	= '';
		$setting['sd_right']	= '';
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
		$template['konten']	= $this->load->view('laporan/matriks_pembangunan_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function get_detail($tahun,$kl)
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->get_rencana_detail($tahun,$kl);
		$template['konten']	= $this->load->view('laporan/renstra_kl_detail_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container_popup',$template);
	}
	
	function get_sasaran($tahun,$kl,$range_awal,$range_akhir){
		$dataAll = array();
		$data = $this->sasaran_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		$arrTahun = explode("-",$tahun);		
		//$rangetahun = $arrTahun[1]-$arrTahun[0];
		$rangetahun = $range_akhir-$range_awal;
		$rs = '<table class="display table table-bordered table-striped">';
		
		$rs .= '
		<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center" width="20%" rowspan="2">Sasaran Kementerian</th>					
					<th style="vertical-align:middle;text-align:center" width="40%" rowspan="2">Indikator</th>
					<th style="vertical-align:middle;text-align:center" width="10%" rowspan="2">Satuan</th>
					<th style="vertical-align:middle;text-align:center" width="100px" colspan="'.($rangetahun+1).'">Realisasi Pencapaian</th>
					<th style="vertical-align:middle;text-align:center" width="100px" rowspan="2">Keterangan</th>
				</tr>';
		$rs .= 	'<tr>';
		$rangetahun_arr = array();
		//for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)
		for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
			$rs .= 	'<th style="vertical-align:middle;text-align:center">'.$colTahun.'</th>';
			$rangetahun_arr[] = $colTahun;
		}	
					
		$rs .= 	'</tr></thead>';	
		$rs .= '<tbody>';		
		$i=0;
		 $j=0;
		
		foreach($data as $d){
			
			$data_indikator = $this->matriks->get_indikator(array("kode_sasaran_kl"=>$d->kode_sasaran_kl,"range_awal"=>$range_awal,"range_akhir"=>$range_akhir));
			$kode_iku = '';
			$data[$i]->rowspan=0;
			if (isset($data_indikator)) {
				foreach($data_indikator as $ss){
					if ($kode_iku != $ss->kode_iku_e1){
						$kode_iku = $ss->kode_iku_e1;
						$data[$i]->indikator[$j]->deskripsi = $ss->deskripsi;
						$data[$i]->indikator[$j]->satuan = $ss->satuan;
						//for ($x=0;$x<count($rangetahun_arr);$x++){
							$data[$i]->indikator[$j]->realisasi[$ss->tahun] = $ss->realisasi;
						//}
						$data[$i]->rowspan++ ;
						$j++;
					}else{
						$data[$i]->indikator[$j-1]->realisasi[$ss->tahun] = $ss->realisasi;
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
		 
		 $i=0;
		 foreach($data as $d){
			
			
			
			$rs .= '<tr>';
			if ($data[$i]->rowspan==0) 
				$rs .= '<td >'.$d->sasaran_kl.'</td>';
			else
				$rs .= '<td rowspan="'.($data[$i]->rowspan).'" >'.$d->sasaran_kl.'</td>';
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
								$realisasi = isset($ss->realisasi[$colTahun])?$ss->realisasi[$colTahun]:'-';
								$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							}
							$rs .= '<td    valign="top">'.form_textarea($textarea_opt).'</td>';			
							$rs .= '</tr>';
						}
						else {						
							$rs .= '<tr>';
							$rs .= '<td   valign="top">'.$ss->deskripsi.'</td>';
							$rs .= '<td    valign="top">'.$ss->satuan.'</td>';
							for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
								$realisasi = isset($ss->realisasi[$colTahun])?$ss->realisasi[$colTahun]:'-';
								$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							}
							$rs .= '<td    valign="top">'.form_textarea($textarea_opt).'</td>';			
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
				for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
					$rs .= '<td >&nbsp;</td>';
				}
				$rs .= '<td >&nbsp;</td>';
				$rs .= '</tr>';
			}
			
			$i++;
		 }
		 $rs .= '</tbody>';		
		 $rs .= '</table>';
		
		echo $rs;
	}
	
	function get_rencana_detail($tahun,$kl){
		$dataAll = array();
		$data = $this->sasaran_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		
		$rs = '<table class="display table table-bordered table-striped">';
		$arrTahun = explode("-",$tahun);
		
		$rangetahun = $arrTahun[1]-$arrTahun[0];
		
	//	$rs = '<table class="table" border="1">';
		$rs .= '
		<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center" width="20%" rowspan="2">Sasaran</th>
					<th style="vertical-align:middle;text-align:center" width="20%" rowspan="2">Sasaran Strategis</th>
					<th style="vertical-align:middle;text-align:center" width="40%" rowspan="2">Indikator</th>
					<th style="vertical-align:middle;text-align:center" width="100px" rowspan="2">Satuan</th>
					<th style="vertical-align:middle;text-align:center" width="100px" colspan="'.($rangetahun+1).'">Target Pencapaian</th>
				</tr>';
		$rs .= 	'<tr>';
			for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)	
					$rs .= 	'<th>'.$colTahun.'</th>';
					
		$rs .= 	'		</tr></thead>';	
		$rs .= '<tbody>';		
		$i=0;
		 
		foreach($data as $d){
			
			$data_strategis = $this->sasaran_strategis->get_renstra(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun,"kode_sasaran_kl"=>$d->kode_sasaran_kl));
			$jml_data_strategis = count($data_strategis);
			$data[$i]->strategis=$data_strategis;
			//$data[$i]->rowspan = sizeof($data_strategis);
			if ($jml_data_strategis>0){				
				//$rs .="<ol>";
				$j=0;
				foreach($data_strategis as $ss){					
					$data_iku = $this->iku_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun,"kode_ss_kl"=>$ss->kode_ss_kl));
					$jml_data_iku = count($data_iku);
					$data[$i]->rowspan += sizeof($data_iku);
					$data[$i]->strategis[$j]->iku = $data_iku;					
					$data[$i]->strategis[$j]->rowspan = sizeof($data_iku);
					$j++;
				}			
			}
			
			$i++;
		 }
		 
		 $i=0;
		 foreach($data as $d){
			
			$jml_data_strategis = sizeof($data[$i]->strategis);
			$colspan_sasaran = 
			$rs .= '<tr>';
			$rs .= '<td rowspan="'.($data[$i]->rowspan).'" >'.$d->sasaran_kl.'</td>';
			//$rs .= '<td  colspan="3">'.$d->sasaran_kl.'</td>';
				
			if ($jml_data_strategis>0){
				
				
				$j=0;
				
				foreach($data[$i]->strategis as $ss){
					if ($j==0)
						$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
					else {
						
						
						//$rs .= '</tr>';
						$rs .= '<tr>';
						$rs .= '<td  rowspan="'.$ss->rowspan.'" valign="top">'.$ss->deskripsi.'</td>';
					//	$rs .= '<td width="50%"  colspan="2" valign="top">'.$ss->deskripsi.'</td>';
					}
					
					$jml_data_iku = count($data[$i]->strategis[$j]->iku);
					$x=0;
					if ($jml_data_iku>0){
						foreach($data[$i]->strategis[$j]->iku as $iku){
							if ($x==0){
							  $rs .= '<td   valign="top">'.$iku->deskripsi.'</td>';
							  $rs .= '<td   valign="top">'.$iku->satuan.'</td>';
							  for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)	
									$rs .= 	'<td align="right">0</td>';
							  $rs .= '</tr>';
							}
							else {
								//
								$rs .= '<tr>';
								$rs .= '<td    valign="top">'.$iku->deskripsi.'</td>';
								$rs .= '<td   valign="top">'.$iku->satuan.'</td>';
								for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)	
									$rs .= 	'<td align="right">0</td>';
								$rs .= '</tr>';
							}
							$x++;
						}
						
					}
					else {
					//	$rs .= '<td width="50%">&nbsp;</td>';
					}
					
					$j++;
				}
			
			}
			else { 
				//$rs .= '<td></td>';
				//$rs .= '<td></td>';
			}
			//$rs .= '</tr>';
			
			$i++;
		 }
		 $rs .= '</tbody>';		
		 $rs .= '</table>';
		// var_dump($data[0]);die;
		return $rs;
	}
	
	function get_sasaran_ga_jadi_($tahun,$kl){
		$data = $this->sasaran_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		
		$rs = '<table class="table">';
		$rs .= '<tr>
					<td width="30%">Sasaran</td>
					<td width="40%">Sasaran Strategis</td>
					<td width="30%">Indikator</td>
				</tr>';
		foreach($data as $d){
			$data_strategis = $this->sasaran_strategis->get_renstra(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun,"kode_sasaran_kl"=>$d->kode_sasaran_kl));
			$jml_data_strategis = count($data_strategis);
			
			
			$rs .= '<tr>';
			$rs .= '<td >'.$d->sasaran_kl.'</td>';
			if ($jml_data_strategis>0){
				$rs .= '<td colspan="2">';
				$rs .= '<table class="" style="margin-top:-13px" border="0" width="100%">';
				//$rs .="<ol>";
				foreach($data_strategis as $ss){
					$rs .= '<tr>';
					$rs .= '<td width="50%" valign="top">'.$ss->deskripsi.'</td>';
					$data_iku = $this->iku_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun,"kode_ss_kl"=>$ss->kode_ss_kl));
					$jml_data_iku = count($data_iku);
					if ($jml_data_iku>0){
						$rs .= '<td width="50%" valign="top">';
						$rs .="<ol style='margin:-2px -15px -10px -30px;'>";
						foreach($data_iku as $iku){
							$rs .= '<li>'.$iku->deskripsi.'</li>';
						}
						$rs .="</ol>";
						$rs .= '</td>';
					}
					else {
						$rs .= '<td width="50%">&nbsp;</td>';
					}
					$rs .= '</tr>';
				}
				//$rs .="</ol>";
				$rs .= '</table>';
				
				
				$rs .= '</td>';
				
			}
			else { 
				$rs .= '<td></td>';
				$rs .= '<td></td>';
			}
			$rs .= '</tr>';
		 }
		 $rs .= '</table>';
		echo $rs;
	}
}