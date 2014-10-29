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
		$data['kl'] = $kl;
		$template['konten']	= $this->load->view('laporan/renstra_kl_detail_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container_popup',$template);
	}
	
	
	function get_visi($tahun,$ajaxCall=true){
		$data = $this->visi_kl->get_all(array("tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			if ($ajaxCall){					
				$rs .= '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->visi_kl.'</li>';						
				 }
				 $rs .= '</ol>';
			}else {//buat PDF
				$i=1;
				$showNumber = (count($data)>1);
				$rs .= '<table  border="0" cellpadding="2" cellspacing="0">';
				foreach($data as $d){					
					if ($showNumber)
						$rs .= '<tr><td width="10">&nbsp;</td><td width="15" align="right">'.($i).'.</td><td width="500">'.$d->visi_kl.'</td></tr>';
					else
						$rs .= '<tr><td width="10">&nbsp;</td><td colspan="2" width="515">'.$d->visi_kl.'</td></tr>';
					$i++;
				}
				$rs .= '</table>';			
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_misi($tahun,$ajaxCall=true){
		$data = $this->misi_kl->get_all(array("tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			if ($ajaxCall){					
				$rs .= '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->misi_kl.'</li>';						
				 }
				 $rs .= '</ol>';
			}else {//buat PDF
				$i=1;
				$showNumber = (count($data)>1);
				$rs .= '<table  border="0" cellpadding="2" cellspacing="0">';
				foreach($data as $d){					
					if ($showNumber)
						$rs .= '<tr><td width="10">&nbsp;</td><td width="15" align="right">'.($i).'.</td><td width="500">'.$d->misi_kl.'</td></tr>';
					else
						$rs .= '<tr><td width="10">&nbsp;</td><td colspan="2" width="515">'.$d->misi_kl.'</td></tr>';
					$i++;
				}
				$rs .= '</table>';			
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_tujuan($tahun,$ajaxCall=true){
		$data = $this->tujuan_kl->get_all(array("tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			if ($ajaxCall){					
				$rs .= '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->tujuan_kl.'</li>';						
				 }
				 $rs .= '</ol>';
			}else {//buat PDF
				$i=1;
				$showNumber = (count($data)>1);
				$rs .= '<table  border="0" cellpadding="2" cellspacing="0">';
				foreach($data as $d){					
					if ($showNumber)
						$rs .= '<tr><td width="10">&nbsp;</td><td width="15" align="right">'.($i).'.</td><td width="500">'.$d->tujuan_kl.'</td></tr>';
					else
						$rs .= '<tr><td width="10">&nbsp;</td><td colspan="2" width="515">'.$d->tujuan_kl.'</td></tr>';
					$i++;
				}
				$rs .= '</table>';			
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_program($tahun,$ajaxCall=true){
		$data = $this->program_e1->get_renstra(array("tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			if ($ajaxCall){					
				$rs .= '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->nama_program.'</li>';						
				 }
				 $rs .= '</ol>';
			}else {//buat PDF
				$i=1;
				$showNumber = (count($data)>1);
				$rs .= '<table  border="0" cellpadding="2" cellspacing="0">';
				foreach($data as $d){					
					if ($showNumber)
						$rs .= '<tr><td width="10">&nbsp;</td><td width="15" align="right">'.($i).'.</td><td width="500">'.$d->nama_program.'</td></tr>';
					else
						$rs .= '<tr><td width="10">&nbsp;</td><td colspan="2" width="515">'.$d->nama_program.'</td></tr>';
					$i++;
				}
				$rs .= '</table>';			
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	
	function get_sasaran($tahun,$kl,$ajaxCall=true,$forExcel=false){
		$dataAll = array();
		
		$rs = '';
		$data_strategis = $this->sasaran_strategis->get_renstra(array("tahun_renstra"=>$tahun));
		if (isset($data_strategis)){
			if ($ajaxCall){
				$rs = '<table class="display table table-bordered table-striped">';
				/*$rs .= '
			<thead><tr  align="center">
						
						<th style="vertical-align:middle;text-align:center" width="30%" >Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center"  >No.</th>
						<th style="vertical-align:middle;text-align:center" width="50%" >Indikator Kinerja Utama (IKU)</th>
						<th style="vertical-align:middle;text-align:center"  >Satuan</th>
			
					</tr>';
					$rs .= 	'</thead>';	
				*/
			}
			else {
				$rs = '<table  border="1" cellpadding="4" cellspacing="0">';
				
			
			}	
				
			$rs .= '
			<thead><tr  align="center">
						
						<th style="vertical-align:middle;text-align:center" class="col-sm-3" width="180" >Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center;width:1%"  width="30">No.</th>
						<th style="vertical-align:middle;text-align:center" width="230" >Indikator Kinerja Utama (IKU)</th>
						<th style="vertical-align:middle;text-align:center" width="80" >Satuan</th>
			
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
						$rs .= '<td  width="180"  rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
					else {
						
						$rs .= '<tr>';
						$rs .= '<td width="180" rowspan="'.$ss->rowspan.'" valign="top">'.$ss->deskripsi.'</td>';
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
							  $rs .= '<td width="30"  >'.($no).'.</td>';
							  $rs .= '<td  width="230" valign="top">'.$iku->deskripsi.'</td>';
							  $rs .= '<td  width="80" valign="top">'.$iku->satuan.'</td>';
							  
							  $rs .= '</tr>';
							$x++;
							$no++;
						}						
					}
					else {
					
					}					
					$i++;
				}
			
			//if ($ajaxCall){
				$rs .= '</tbody>';		
			//}
			$rs .= '</table>';
			
		} 
			 
		if ($forExcel) {
			return	 $data_strategis;
		}
		else {
			if ($ajaxCall)	echo $rs;
			else return $rs;
		}
	}
	
	function get_rencana_detail($tahun,$kl,$ajaxCall=true,$forExcel=false){
		$dataAll = array();		
		$rs = '';		
		if ($ajaxCall)
			$rs = '<table class="display table table-bordered table-striped" width="100%">';
		else
			$rs = '<table  border="1" cellpadding="2" cellspacing="0">';
		$arrTahun = explode("-",$tahun);
		
		$rangetahun = $arrTahun[1]-$arrTahun[0];
			
		//	$rs = '<table class="table" border="1">';
		//buat valign supaya midlle
	//	$innertable = "\n".'<tr><td rowspan="'.$rows.'">';
  //      $innertable .= '<span style="font-size: 25px;">'.str_repeat('&nbsp;<br/>', $rows-1).'</span>';
//        $innertable .= $cat['Category']['name'].'</td>';
			$setValignMiddle = '';$rowspan =2;
			if (!$ajaxCall)
				$setValignMiddle =  '<span style="font-size:5px;">'.str_repeat('&nbsp;<br/>', $rowspan-1).'</span>';
				
			$rs .= '<thead><tr  align="center" valign="middle">						
						<th style="vertical-align:middle;text-align:center;width:20%"  valign="middle" width="100" rowspan="2">'.$setValignMiddle.'Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center;width:1%" width="30" rowspan="2" >'.$setValignMiddle.'No.</th>
						<th style="vertical-align:middle;text-align:center;width:50%" width="150" rowspan="2">'.$setValignMiddle.'Indikator Kinerja Utama (IKU)</th>
						<th style="vertical-align:middle;text-align:center;width:10%" width="80" rowspan="2">'.$setValignMiddle.'Satuan</th>
						<th style="vertical-align:middle;text-align:center" width="'.(85*($rangetahun+1)).'" colspan="'.($rangetahun+1).'">Target Pencapaian</th>
					</tr>';
			$rs .= 	'<tr>';
				for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)	
						$rs .= 	'<th style="vertical-align:middle;text-align:center" width="85">'.$colTahun.'</th>';
						
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
								$rs .= '<td  width="100"    valign="top">'.$ss->deskripsi.'</td>';
							else
								$rs .= '<td  width="100"   rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
						}
						else {
							$rs .= '<tr>';							
							if ($ss->rowspan==0)								
								$rs .= '<td   width="100"   valign="top">'.$ss->deskripsi.'</td>';
							else								
								$rs .= '<td  width="100"   rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
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
								$rs .= '<td  width="30"  align="center">'.$no.'</td>';
								$rs .= '<td  width="150"   valign="top">'.$iku->deskripsi.'</td>';
								$rs .= '<td  width="80"  valign="top">'.$iku->satuan.'</td>';
								//for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){	
									//$realisasi = isset($iku->target[$colTahun])?$iku->target[$colTahun]:'-';
									$realisasi = isset($iku->target1)?$iku->target1:'-';
									$rs .= 	'<td width="85"  align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target2)?$iku->target2:'-';
									$rs .= 	'<td width="85"  align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target3)?$iku->target3:'-';
									$rs .= 	'<td width="85"  align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target4)?$iku->target4:'-';
									$rs .= 	'<td width="85"  align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target5)?$iku->target5:'-';
									$rs .= 	'<td width="85"  align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									
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
		if ($forExcel) {
			return	 $data_strategis;
		}
		else {
			return $rs;
		}
	}
	
	public function print_pdf($tahun){
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Rencana Strategis Kementerian Perhubungan');
		$pdf->SetHeaderMargin(15);
		$pdf->SetTopMargin(15);
		$pdf->setFooterMargin(5);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);	
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		
		// add a page
			$e1='';
		// set font
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage();
	
		 $pdf->Write(0, 'RENCANA STRATEGIS KEMENTERIAN PERHUBUNGAN', '', 0, 'L', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		 $data['renstra']		= $tahun;
	   $data['kementerian'] = $this->mgeneral->getValue("nama_kl",array('tahun_renstra'=>$tahun),"anev_kl");
	   $data['tujuan']		= $this->get_tujuan($tahun,false);
	   $data['misi']		= $this->get_misi($tahun,false);
	   $data['visi']		= $this->get_visi($tahun,false);
	   $data['program']		= $this->get_program($tahun,false);
	   $data['sasaran']		= $this->get_sasaran($tahun,null,false);
		$html = $this->load->view('laporan/print/pdf_renstra_kl',$data,true);
	//	$html = $data['sasaran'];
		$pdf->writeHTML($html, true, false, false, false, '');
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Output('RenstraKementerian.pdf', 'I');
	}
	
	public function target_print_pdf($tahun,$kl){
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Rencana Strategis Kementerian');
		$pdf->SetHeaderMargin(15);
		$pdf->SetLeftMargin(10);
		$pdf->SetTopMargin(15);
		$pdf->setFooterMargin(5);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);	
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		
		// add a page
			$e1='';
		// set font
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage('L');
	
		 $pdf->Write(0, 'TARGET CAPAIAN KINERJA KEMENTERIAN PERHUBUNGAN', '', 0, 'L', true, 0, false, false, 0);
		 $pdf->Write(0, 'TAHUN '.$tahun, '', 0, 'L', true, 0, false, false, 0);
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		$data['target'] =  $this->get_rencana_detail($tahun,$kl,false);
		$html = $this->load->view('laporan/print/pdf_renstra_target_kl',$data,true);
	//	$html = $data['sasaran'];
		$pdf->writeHTML($html, true, false, false, false, '');		
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('TargetCapaianKementerian.pdf', 'I');
	}
	
	
	public function excel($tahun){
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Renstra Kementerian');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'RENCANA STRATEGIS KEMENTERIAN PERHUBUNGAN');
		$this->excel->getActiveSheet()->setCellValue('A2', 'Periode Renstra ');
		$this->excel->getActiveSheet()->setCellValue('B2', $tahun);
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->mergeCells('A3:D3');
		$params = array("tahun_renstra"=>$tahun);
		$posisiRow = 4;
		
		$visi=$this->visi_kl->get_all($params);
		$visi_arr = null;		
		if (isset($visi)){
			foreach ($visi as $u){
				$visi_arr[] = array($u->visi_kl);
			}
		}
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Visi');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		if (count($visi_arr)>0){
			$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+count($visi_arr)-1));
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->fromArray($visi_arr,NULL,'B'.$posisiRow);		
			for ($i=0;$i<count($visi_arr);$i++)
				$this->excel->getActiveSheet()->mergeCells('B'.($posisiRow+$i).':D'.($posisiRow+$i));
			$posisiRow += count($visi_arr);
		}else $posisiRow++;
		
		
		$misi = $this->misi_kl->get_all($params);
		$misi_arr = null;		
		if (isset($misi)){
			foreach ($misi as $u){
				$misi_arr[] = array($u->misi_kl);
			}
		}
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Misi');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		if (count($misi_arr)>0){
			$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+count($misi_arr)-1));
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->fromArray($misi_arr,NULL,'B'.$posisiRow);
			for ($i=0;$i<count($misi_arr);$i++)
				$this->excel->getActiveSheet()->mergeCells('B'.($posisiRow+$i).':D'.($posisiRow+$i));
			
			$posisiRow += count($misi_arr);				
		}else $posisiRow++;
		
		$tujuan = $this->tujuan_kl->get_all($params);
		$tujuan_arr = null;		
		if (isset($tujuan)){
			foreach ($tujuan as $u){
				$tujuan_arr[] = array($u->tujuan_kl);
			}
		}
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Tujuan');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		if (count($tujuan_arr)>0){
			$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+count($tujuan_arr)-1));
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->fromArray($tujuan_arr,NULL,'B'.$posisiRow);			
			for ($i=0;$i<count($tujuan_arr);$i++)
				$this->excel->getActiveSheet()->mergeCells('B'.($posisiRow+$i).':D'.($posisiRow+$i));
			$posisiRow += count($tujuan_arr);		
		}else $posisiRow++;
		
		/////SASARAN STRATEGIS DAN IKU HERE...
		//jeda 1 row
		$posisiRow++;
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Sasaran Strategis dan IKU');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':D'.$posisiRow);
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$posisiRow++;
		$columHeader = array("Sasaran Strategis","No.","Indikator Kinerja Utama (IKU)","Satuan");		
		$sasaran = $this->get_sasaran($tahun,-1,false,true);
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow.':D'.$posisiRow)->applyFromArray(
				array(
					'font'    => array('bold'=> true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
					'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
				));
		
		$this->excel->getActiveSheet()->fromArray($columHeader,NULL,'A'.$posisiRow);
		$posisiRow++;
		$no=1;
		foreach($sasaran as $s){ 
			foreach($s->iku as $iku){
				$data[] = array($s->deskripsi,$no++,$iku->deskripsi,$iku->satuan);
			}
		}
		if (count($data)>0){
			$this->excel->getActiveSheet()->fromArray($data,NULL,'A'.$posisiRow);	
			$posisiRow += count($data);
		}else $posisiRow++;
		/////END    SASARAN STRATEGIS DAN IKU HERE...
		
		//jeda 1 row
		$posisiRow++;
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Target Capaian Kinerja');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, 'Klik Disini');
		$this->excel->getActiveSheet()->mergeCells('B'.$posisiRow.':D'.$posisiRow);
		$this->excel->getActiveSheet()->getCell('B'.$posisiRow)->getHyperlink()->setUrl("sheet://'Target Capaian Kinerja'!A1");
		$posisiRow++;		
		
		$program = $this->program_e1->get_renstra($params);
		$program_arr = null;		
		if (isset($program)){
			foreach ($program as $u){
				$program_arr[] = array($u->nama_program);
			}
		}
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Program');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		if (count($program_arr)>0){
			$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+count($program_arr)-1));
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->fromArray($program_arr,NULL,'B'.$posisiRow);
			for ($i=0;$i<count($program_arr);$i++)
				$this->excel->getActiveSheet()->mergeCells('B'.($posisiRow+$i).':D'.($posisiRow+$i));
			$posisiRow += count($program_arr);
		}else $posisiRow++;
		
		//jeda 1 row
		$posisiRow++;
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Kebutuhan Pendanaan');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, 'Klik Disini');
		$this->excel->getActiveSheet()->mergeCells('B'.$posisiRow.':D'.$posisiRow);
		$this->excel->getActiveSheet()->getCell('B'.$posisiRow)->getHyperlink()->setUrl("sheet://'Kebutuhan Pendanaan'!A1");
		$posisiRow++;
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		//$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(100);
		$this->excel->getActiveSheet()->getStyle('A4:A'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('B4:B'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('C4:C'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('D4:D'.$posisiRow)->getAlignment()->setWrapText(true); 
		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(4);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(80);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		
		
		$arrTahun = explode("-",$tahun);		
		$rangetahun = $arrTahun[1]-$arrTahun[0];
		for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){
			$columRentang[] = $colTahun;
		}
		//buat sheet TARGET CAPAIAN KINERJA-------
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet()->setTitle('Target Capaian Kinerja');
		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:E1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'TARGET CAPAIAN KINERJA KEMENTERIAN PERHUBUNGAN');
		$this->excel->getActiveSheet()->setCellValue('A2', 'TAHUN');
		$this->excel->getActiveSheet()->setCellValue('B2', $tahun);
		$this->excel->getActiveSheet()->mergeCells('B2:E2');
		$this->excel->getActiveSheet()->mergeCells('A3:F3');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(4);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(80);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$posisiRow = 5;
		$columHeader = array("Sasaran Strategis","No.","Indikator Kinerja Utama (IKU)","Satuan","Target Pencapaian");				
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow.':D'.($posisiRow+1))->applyFromArray(
				array(
					'font'    => array('bold'=> true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
					'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
				));
		
		$this->excel->getActiveSheet()->fromArray($columHeader,NULL,'A'.$posisiRow);
		$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+1));
		$this->excel->getActiveSheet()->mergeCells('B'.$posisiRow.':B'.($posisiRow+1));
		$this->excel->getActiveSheet()->mergeCells('C'.$posisiRow.':C'.($posisiRow+1));
		$this->excel->getActiveSheet()->mergeCells('D'.$posisiRow.':D'.($posisiRow+1));
		//$this->excel->getActiveSheet()->mergeCells('E'.$posisiRow.':D'.($posisiRow+1));
		$posisiRow++;		
		$this->excel->getActiveSheet()->fromArray($columRentang,NULL,'E'.$posisiRow);
		$posisiRow++;
		$target = $this->get_rencana_detail($tahun,-1,false,true);
		$no=1;
		foreach($target as $s){ 
			foreach($s->iku as $iku){
				$dataTarget[] = array($s->deskripsi,$no++,$iku->deskripsi,$iku->satuan,$iku->target1,$iku->target2,$iku->target3,$iku->target4,$iku->target5);
			}
		}
		if (count($dataTarget)>0){
			$this->excel->getActiveSheet()->fromArray($dataTarget,NULL,'A'.$posisiRow);	
			$posisiRow += count($dataTarget);
		}else $posisiRow++;
		
		$this->excel->getActiveSheet()->getStyle('A4:A'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('B4:B'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('C4:C'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('D4:D'.$posisiRow)->getAlignment()->setWrapText(true); 
		//---------------------end  target capaian kinerja
		
		//buat sheet kEBUTUHANN PENDANAAN
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(2);
		$this->excel->getActiveSheet()->setTitle('Kebutuhan Pendanaan');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:B1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'KEBUTUHAN PENDANAAN KEMENTERIAN PERHUBUNGAN');
		$this->excel->getActiveSheet()->setCellValue('A2', 'TAHUN');
		$this->excel->getActiveSheet()->setCellValue('B2', $tahun);
		$this->excel->getActiveSheet()->mergeCells('A3:F3');
		//---------------------end  kEBUTUHANN PENDANAAN
		
		
		
		$this->excel->setActiveSheetIndex(0);	
		$filename='RenstraKementerian'.$tahun.'.xls'; 
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');		
   }

	
}