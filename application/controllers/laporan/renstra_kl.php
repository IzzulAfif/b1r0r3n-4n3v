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
		$this->load->model('/perencanaan/program_eselon1_model','program_e1');
		$this->load->model('/pemrograman/sasaran_strategis_model','sasaran_strategis');
		$this->load->model('/pemrograman/iku_kl_model','iku_kl');
		$this->load->model('/laporan/renstra_kl_model','renstra_kl');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
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
	
	function loadprofile()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data = null;
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/renstra_kl_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_detail($tahun,$kl)
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->get_rencana_detail($tahun,$kl);
		$data['periode'] = $tahun;
		$template['konten']	= $this->load->view('laporan/renstra_kl_detail_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container_popup',$template);
	}
	
	
	function get_visi($tahun,$ajaxCall=true){
		$data = $this->visi_kl->get_all(array("tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->visi_kl.'</li>';
			 }
			 $rs .= '</ol>';
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_misi($tahun,$ajaxCall=true){
		$data = $this->misi_kl->get_all(array("tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->misi_kl.'</li>';
			 }
			 $rs .= '</ol>';
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_tujuan($tahun,$ajaxCall=true){
		$data = $this->tujuan_kl->get_all(array("tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->tujuan_kl.'</li>';
			 }
			 $rs .= '</ol>';
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_program($tahun,$ajaxCall=true){
		$data = $this->program_e1->get_renstra(array("tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->nama_program.'</li>';
			 }
			 $rs .= '</ol>';
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	
	function get_sasaran($tahun,$kl,$ajaxCall=true){
		$dataAll = array();
		
		$rs = '';
		$data_strategis = $this->sasaran_strategis->get_renstra(array("tahun_renstra"=>$tahun));
		if (isset($data_strategis)){
			$rs = '<table class="display table table-bordered table-striped">';
			
			$rs .= '
			<thead><tr  align="center">
						
						<th style="vertical-align:middle;text-align:center" width="30%" >Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center"  >No.</th>
						<th style="vertical-align:middle;text-align:center" width="50%" >Indikator Kinerja Utama (IKU)</th>
						<th style="vertical-align:middle;text-align:center"  >Satuan</th>
			
					</tr>';
			
						
			$rs .= 	'</thead>';	
			$rs .= '<tbody>';		
			$rs .= '<tr>';		
			$i=0;
			foreach($data_strategis as $ss){					
					$data_iku = $this->iku_kl->get_renstra(array("tahun_renstra"=>$tahun,"kode_ss_kl"=>$ss->kode_ss_kl));
					$jml_data_iku = count($data_iku);
					$data_strategis[$i]->rowspan += sizeof($data_iku);
					$data_strategis[$i]->iku = $data_iku;					
					$data_strategis[$i]->rowspan = sizeof($data_iku);
					$i++;
			}			
			$i=0;
			
			$no=1;	
			foreach($data_strategis as $ss){
					if ($i==0)
						$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
					else {
						
						$rs .= '<tr>';
						$rs .= '<td  rowspan="'.$ss->rowspan.'" valign="top">'.$ss->deskripsi.'</td>';
					}
					
					$jml_data_iku = count($ss->iku);
					$x=0;
					if ($jml_data_iku>0){
						foreach($ss->iku as $iku){
							if ($x==0){
							
							}
							else {
								//
								$rs .= '<tr>';
								
							}
							
							  $rs .= '<td   >'.($no).'.</td>';
							  $rs .= '<td   valign="top">'.$iku->deskripsi.'</td>';
							  $rs .= '<td   valign="top">'.$iku->satuan.'</td>';
							  
							  $rs .= '</tr>';
							$x++;
							$no++;
						}
						
					}
					else {
					
					}
					
					$i++;
				}
			
			
			$rs .= '</tbody>';		
			$rs .= '</table>';
			
		} 
			 
			 
		
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	
	
	function get_rencana_detail($tahun,$kl){
		$dataAll = array();
		
		$rs = '';
		
			$rs = '<table class="display table table-bordered table-striped">';
			$arrTahun = explode("-",$tahun);
			
			$rangetahun = $arrTahun[1]-$arrTahun[0];
			
		//	$rs = '<table class="table" border="1">';
			$rs .= '
			<thead><tr  align="center">
						
						<th style="vertical-align:middle;text-align:center" width="30%" rowspan="2">Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center" rowspan="2" >No.</th>
						<th style="vertical-align:middle;text-align:center" width="50%" rowspan="2">Indikator Kinerja Utama (IKU)</th>
						<th style="vertical-align:middle;text-align:center" width="100px" rowspan="2">Satuan</th>
						<th style="vertical-align:middle;text-align:center"  colspan="'.($rangetahun+1).'">Target Pencapaian</th>
					</tr>';
			$rs .= 	'<tr>';
				for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)	
						$rs .= 	'<th style="vertical-align:middle;text-align:center">'.$colTahun.'</th>';
						
			$rs .= 	'		</tr></thead>';	
			$rs .= '<tbody>';
						
			$i=0;
			 
			
				
				$data_strategis = $this->sasaran_strategis->get_renstra(array("tahun_renstra"=>$tahun));
				$jml_data_strategis = count($data_strategis);
				$no=1;
				//$data[$i]->rowspan = sizeof($data_strategis);
				if (isset($data_strategis)){				
					//$rs .="<ol>";
					$j=0;
					foreach($data_strategis as $ss){					
						$data_iku = $this->renstra_kl->get_indikator(array("tahun_renstra"=>$tahun,"kode_ss_kl"=>$ss->kode_ss_kl));
						$kode_iku = '';
						$data_strategis[$j]->rowspan =0;
						if (isset($data_iku)) {
							$x=0;
							foreach($data_iku as $iku){
								//if ($kode_iku != $iku->kode_iku_kl){
									$kode_iku = $iku->kode_iku_kl;
									$data_strategis[$j]->iku[$x]->deskripsi = $iku->deskripsi;					
									$data_strategis[$j]->iku[$x]->satuan = $iku->satuan;					
								//	$data_strategis[$j]->iku[$x]->target[$iku->tahun] = $iku->target;	
									$data_strategis[$j]->iku[$x]->target1 = $iku->target_thn1;	
									$data_strategis[$j]->iku[$x]->target2 = $iku->target_thn2;	
									$data_strategis[$j]->iku[$x]->target3 = $iku->target_thn3;	
									$data_strategis[$j]->iku[$x]->target4 = $iku->target_thn4;	
									$data_strategis[$j]->iku[$x]->target5 = $iku->target_thn5;	
										
						
									$data_strategis[$j]->rowspan++;
									$x++;
							/*	}
								else {
									//$data_strategis[$j]->iku[$x-1]->target[$iku->tahun] = $iku->target;	
								}*/
							}
						}
						
						
						$j++;
					}			
				}
				
			 $i=0;
			
				$jml_data_strategis = sizeof($data_strategis);
			
				$rs .= '<tr>';
				
					
				if (isset($data_strategis)){		
					
					
					$j=0;
					
					foreach($data_strategis as $ss){
						if ($j==0){
							if ($ss->rowspan==0)
								$rs .= '<td     valign="top">'.$ss->deskripsi.'</td>';
							else
								$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
						}
						else {
							$rs .= '<tr>';							
							if ($ss->rowspan==0)								
								$rs .= '<td     valign="top">'.$ss->deskripsi.'</td>';
							else								
								$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
						}
						
						$jml_data_iku = count($data_strategis[$j]->iku);
						$x=0;
						if ($jml_data_iku>0){
							foreach($data_strategis[$j]->iku as $iku){
								if ($x==0){
								  
								}
								else {
									$rs .= '<tr>';
								}
								$rs .= '<td   valign="top">'.$no.'</td>';
								$rs .= '<td    valign="top">'.$iku->deskripsi.'</td>';
								$rs .= '<td   valign="top">'.$iku->satuan.'</td>';
								//for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){	
									//$realisasi = isset($iku->target[$colTahun])?$iku->target[$colTahun]:'-';
									$realisasi = isset($iku->target1)?$iku->target1:'-';
									$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target2)?$iku->target2:'-';
									$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target3)?$iku->target3:'-';
									$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target4)?$iku->target4:'-';
									$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target5)?$iku->target5:'-';
									$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									
								//}
								$rs .= '</tr>';
								$x++;
								$no++;
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
				
			 $rs .= '</tbody>';		
			 $rs .= '</table>';
		
		// var_dump($data[0]);die;
		return $rs;
	}
	
	function print_pdf($tahun)
   {
	   $this->load->library('pdf');
	   $data['renstra']		= $tahun;
	   $data['kementerian'] = $this->mgeneral->getValue("nama_kl",array('tahun_renstra'=>$tahun),"anev_kl");
	   $data['tujuan']		= $this->get_tujuan($tahun,false);
	   $data['misi']		= $this->get_misi($tahun,false);
	   $data['visi']		= $this->get_visi($tahun,false);
	   $data['program']		= $this->get_program($tahun,false);
	   $data['sasaran']		= $this->get_sasaran($tahun,null,false);
	   
	   $html = $this->load->view('laporan/print/pdf_renstra_kl',$data,true);
	   
	   echo $this->pdf->cetak($html,"renstra_kementerian.pdf");
   }
	
	
	
	function get_sasaran_old($tahun,$kl){
	//ga jadi gara" tble anev_sasaran_kl di DROP
		$dataAll = array();
		$data = $this->sasaran_kl->get_all(array("tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<table class="display table table-bordered table-striped">';
			
			$rs .= '
			<thead><tr  align="center">
						<th style="vertical-align:middle;text-align:center" width="20%" >Sasaran</th>
						<th style="vertical-align:middle;text-align:center" width="20%" >Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center" width="40%" >Indikator Kinerja Utama (IKU)</th>
			
					</tr>';
			
						
			$rs .= 	'</thead>';	
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
						$data_iku = $this->iku_kl->get_renstra(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun,"kode_ss_kl"=>$ss->kode_ss_kl));
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
			
					
				if ($jml_data_strategis>0){
					
					
					$j=0;
					
					foreach($data[$i]->strategis as $ss){
						if ($j==0)
							$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
						else {
							
							$rs .= '<tr>';
							$rs .= '<td  rowspan="'.$ss->rowspan.'" valign="top">'.$ss->deskripsi.'</td>';
						}
						
						$jml_data_iku = count($data[$i]->strategis[$j]->iku);
						$x=0;
						if ($jml_data_iku>0){
							foreach($data[$i]->strategis[$j]->iku as $iku){
								if ($x==0){
								  $rs .= '<td   valign="top">'.$iku->deskripsi.'</td>';
								  
								  $rs .= '</tr>';
								}
								else {
									//
									$rs .= '<tr>';
									$rs .= '<td    valign="top">'.$iku->deskripsi.'</td>';
									
									$rs .= '</tr>';
								}
								$x++;
							}
							
						}
						else {
						
						}
						
						$j++;
					}
				
				}
				else { 
					
				}
				
				$i++;
			 }
			 $rs .= '</tbody>';		
			 $rs .= '</table>';
		}
		
		echo $rs;
	}
	function get_rencana_detail_OLD($tahun,$kl){
	//ga jadi gara" anev_sasaran_kl di DROP
		$dataAll = array();
		$data = $this->sasaran_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
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
						$rs .= 	'<th style="vertical-align:middle;text-align:center">'.$colTahun.'</th>';
						
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
					foreach($data[$i]->strategis as $ss){					
						$data_iku = $this->renstra_kl->get_indikator(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun,"kode_ss_kl"=>$ss->kode_ss_kl));
						$kode_iku = '';
						$data[$i]->strategis[$j]->rowspan =0;
						if (isset($data_iku)) {
							$x=0;
							foreach($data_iku as $iku){
								if ($kode_iku != $iku->kode_iku_kl){
									$kode_iku = $iku->kode_iku_kl;
									$data[$i]->strategis[$j]->iku[$x]->deskripsi = $iku->deskripsi;					
									$data[$i]->strategis[$j]->iku[$x]->satuan = $iku->satuan;					
									$data[$i]->strategis[$j]->iku[$x]->target[$iku->tahun] = $iku->target;	
									$data[$i]->rowspan++;
									//$data[$i]->strategis[$j]->rowspan = sizeof($data_iku);
									$data[$i]->strategis[$j]->rowspan++;
									$x++;
								}
								else {
									$data[$i]->strategis[$j]->iku[$x-1]->target[$iku->tahun] = $iku->target;	
								}
							}
						}
						//$jml_data_iku = count($data_iku);
						
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
						if ($j==0){
							if ($ss->rowspan==0)
								$rs .= '<td     valign="top">'.$ss->deskripsi.'</td>';
							else
								$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
						}
						else {
							$rs .= '<tr>';							
							if ($ss->rowspan==0)								
								$rs .= '<td     valign="top">'.$ss->deskripsi.'</td>';
							else								
								$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
						}
						
						$jml_data_iku = count($data[$i]->strategis[$j]->iku);
						$x=0;
						if ($jml_data_iku>0){
							foreach($data[$i]->strategis[$j]->iku as $iku){
								if ($x==0){
								  $rs .= '<td   valign="top">'.$iku->deskripsi.'</td>';
								  $rs .= '<td   valign="top">'.$iku->satuan.'</td>';
								  for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){	
										
										$realisasi = isset($iku->target[$colTahun])?$iku->target[$colTahun]:'-';
										$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
								  }		
								  $rs .= '</tr>';
								}
								else {
									//
									$rs .= '<tr>';
									$rs .= '<td    valign="top">'.$iku->deskripsi.'</td>';
									$rs .= '<td   valign="top">'.$iku->satuan.'</td>';
									for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){	
										$realisasi = isset($iku->target[$colTahun])?$iku->target[$colTahun]:'-';
										$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									}
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
		}
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