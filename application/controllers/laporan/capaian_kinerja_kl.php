<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-09-02 00:00
 @revision	 :
*/

class Capaian_kinerja_kl extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
		$this->load->model('/laporan/capaian_kinerja_kl_model','capaian');
		$this->load->model('/pemrograman/sasaran_strategis_model','sastra');
		$this->load->model('/perencanaan/sasaran_kl_model','sasaran');
		$this->load->model('/pemrograman/sasaran_program_model','sasprog');
		$this->load->model('/pemrograman/iku_kl_model','iku_kl');
		
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$template['konten']	= $this->load->view('laporan/capaian_kinerja_kl_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loaddata()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file	
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/capaian_kinerja_kl_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_sasaran($tahun_awal,$tahun_akhir)
	{
		$params['tahun_renstra'] = $tahun_awal.'-'.$tahun_akhir;
		echo json_encode($this->sastra->get_list($params));
	}
	

	
	function get_capaian($tahun,$ajaxCall=true,$forExcel=false){
		$dataAll = array();
		$data = $this->capaian->get_sasaran_kl(array("tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			if ($ajaxCall)
				$rs = '&nbsp;
				<table class="display table table-bordered table-striped" width="100%">';
			else
				$rs = '<table  border="1" cellpadding="2" cellspacing="0">';
			
			$arrTahun = explode("-",$tahun);			
			$rangetahun = $arrTahun[1]-$arrTahun[0];	
			$setValignMiddle = '';$rowspan =2;
			if (!$ajaxCall)
				$setValignMiddle =  '<span style="font-size:5px;">'.str_repeat('&nbsp;<br/>', $rowspan-1).'</span>';
				
			$rs .= '<thead><tr  align="center" valign="middle">						
						<th style="vertical-align:middle;text-align:center;width:20%"  valign="middle" width="100" rowspan="2">'.$setValignMiddle.'Sasaran Kemenhub</th>
						<th style="vertical-align:middle;text-align:center;width:20%"  valign="middle" width="100" rowspan="2">'.$setValignMiddle.'Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center;width:1%" width="30" rowspan="2" >'.$setValignMiddle.'No.</th>
						<th style="vertical-align:middle;text-align:center;width:30%" width="110" rowspan="2">'.$setValignMiddle.'Indikator Kinerja Utama (IKU)</th>
						<th style="vertical-align:middle;text-align:center" width="'.(85*($rangetahun+1)).'" colspan="'.($rangetahun+1).'">Capaian Kinerja</th>
					</tr>';
			$rs .= 	'<tr>';
				for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)	
						$rs .= 	'<th style="vertical-align:middle;text-align:center" width="85">'.$colTahun.'</th>';
						
			$rs .= 	'		</tr></thead>';	
			$rs .= '<tbody>';             
			$i=0;
				 
			foreach($data as $d){						
				$data_strategis = $this->capaian->get_sasaran_strategis(array("tahun_renstra"=>$tahun,"kode_sasaran_kl"=>$d->kode_sasaran_kl));
				$jml_data_strategis = count($data_strategis);
				$data[$i]->strategis=$data_strategis;
				$data[$i]->rowspan =0;//sizeof($data_strategis);
				if ($jml_data_strategis>0){                             
						//$rs .="<ol>";
					$j=0;
					foreach($data_strategis as $ss){                                        
						$data_iku = $this->capaian->get_capaian(array("tahun_renstra"=>$tahun,"kode_ss_kl"=>$ss->kode_ss_kl));
						$jml_data_iku = count($data_iku);
						$kode_iku = '';
					//	$data_strategis[$j]->rowspan =0;
						$data[$i]->strategis[$j]->rowspan =0;
						if (isset($data_iku)) {
							$x=0;
							foreach($data_iku as $iku){
								if ($kode_iku != $iku->kode_iku_kl){
									$kode_iku = $iku->kode_iku_kl;
									$data[$i]->strategis[$j]->iku[$x]->deskripsi = $iku->deskripsi;					
									//$data[$i]->strategis[$j]->iku[$x]->satuan = $iku->satuan;					
									$data[$i]->strategis[$j]->iku[$x]->target[$iku->tahun] = $iku->target;	
									$data[$i]->strategis[$j]->iku[$x]->realisasi[$iku->tahun] = $iku->realisasi;	
									
									$data[$i]->strategis[$j]->rowspan++;
									$data[$i]->rowspan++;// += sizeof($data_iku);
									$x++;
								}
								else {
									$data[$i]->strategis[$j]->iku[$x-1]->target[$iku->tahun] = $iku->target;	
									$data[$i]->strategis[$j]->iku[$x-1]->realisasi[$iku->tahun] = $iku->realisasi;	
								}
							}
							//$data[$i]->rowspan += sizeof($data_iku);
							//$data[$i]->strategis[$j]->rowspan = sizeof($data_iku);
						}
						
						
						$j++;
						/*$data_iku = $this->capaian->get_indikator(array("tahun_renstra"=>$tahun,"kode_ss_kl"=>$ss->kode_ss_kl));
						$jml_data_iku = count($data_iku);
						$data[$i]->rowspan += sizeof($data_iku);
						$data[$i]->strategis[$j]->iku = $data_iku;                                      
						$data[$i]->strategis[$j]->rowspan = sizeof($data_iku);
						$j++;*/
					}                       
				}				
				$i++;
			}
				 
			$i=0;
			$no=1;
			foreach($data as $d){					
				$jml_data_strategis = sizeof($data[$i]->strategis);
				
				$rs .= '<tr>';
				$rs .= '<td rowspan="'.($data[$i]->rowspan).'" >'.$d->deskripsi.'</td>';			
				
							
				if ($jml_data_strategis>0){					
					$j=0;				
					foreach($data[$i]->strategis as $ss){
						if ($j==0){
							$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
					
						}else {										
							$rs .= '<tr>';
							$rs .= '<td  rowspan="'.$ss->rowspan.'" valign="top">'.$ss->deskripsi.'</td>';
					
						}
						
						$jml_data_iku = count($data[$i]->strategis[$j]->iku);
						$x=0;
						if ($jml_data_iku>0){
							foreach($data[$i]->strategis[$j]->iku as $iku){
								if ($x==0){
								}
								else {										//
									$rs .= '<tr>';									
								}
								//buat ngitung dulu rowspan
								/*$rs .= '<tr>';
								$rs .= '<td >'.$d->sasaran_kl.'-'.($data[$i]->rowspan).'</td>';	
								$rs .= '<td     valign="top">'.$ss->deskripsi.'-'.$ss->rowspan.'</td>';
								}*/
								
								$rs .= '<td  align="center" valign="top">'.($no++).'</td>';
								$rs .= '<td  width="110"  valign="top">'.$iku->deskripsi.'</td>';
								for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){	
									$realisasi = isset($iku->realisasi[$colTahun])?$iku->realisasi[$colTahun]:'-';
									//$realisasi = 0;//isset($iku->target1)?$iku->target1:'-';
									$rs .= 	'<td width="85"  align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';									
								}
								
								$rs .= '</tr>';
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
		else {
			$rs = 'Data tidak ditemukan.';
		}
		
		if ($forExcel){
			return $data;
		}else {
			if ($ajaxCall)	echo $rs;
			else return $rs;
		}
	}
	
	public function print_pdf($tahun){
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Realisasi Capaian Kinerja Kementerian');
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
		$pdf->AddPage('L');
	
		 $pdf->Write(0, 'REALISASI CAPAIAN KINERJA KEMENTERIAN PERHUBUNGAN', '', 0, 'L', true, 0, false, false, 0);
		  $pdf->Write(0, 'TAHUN '.$tahun, '', 0, 'L', true, 0, false, false, 0);
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		$data['renstra']		= $tahun;
	   $data['kementerian'] = $this->mgeneral->getValue("nama_kl",array('tahun_renstra'=>$tahun),"anev_kl");
	   
	   $data['capaian']		= $this->get_capaian($tahun,false);
		$html = $this->load->view('laporan/print/pdf_capaian_kl',$data,true);
	//	$html = $data['sasaran'];
		$pdf->writeHTML($html, true, false, false, false, '');
	
	
		$pdf->SetFont('helvetica', 'B', 10);
		
		
	
	
	
		$pdf->Output('CapaianKinerjaKementerian.pdf', 'I');
	}
	
	public function excel($tahun){
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Capaian Kinerja Kementerian');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:E1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'REALISASI CAPAIAN KINERJA KEMENTERIAN');
		$this->excel->getActiveSheet()->setCellValue('A2', 'Periode Renstra ');
		$this->excel->getActiveSheet()->setCellValue('B2', $tahun);
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->mergeCells('A3:D3');
		$params = array("tahun_renstra"=>$tahun);
		$arrTahun = explode("-",$tahun);		
		$rangetahun = $arrTahun[1]-$arrTahun[0];
		for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){
			$columRentang[] = $colTahun;
		}
		$posisiRow = 4;
		$data 		= $this->get_capaian($tahun,false,true);
		$columHeader = array("Sasaran Kemenhub","Sasaran Strategis","No.","Indikator Kinerja Utama (IKU)","Capaian Kinerja");		
		 
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow.':D'.$posisiRow)->applyFromArray(
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
		$this->excel->getActiveSheet()->mergeCells('E'.$posisiRow.':I'.($posisiRow));
		$posisiRow++;		
		$this->excel->getActiveSheet()->fromArray($columRentang,NULL,'E'.$posisiRow);
		$posisiRow++;
		if (isset($data)){
			$i=0;$no=1;
			$sasaran_kl = '';
			$sasaran_ss = '';
			foreach ($data as $d){
				if ($sasaran_kl!=$d->deskripsi){
					$sasaran_kl = $d->deskripsi;
					$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, $d->deskripsi);
					$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+$data[$i]->rowspan-1));
				}
				if (isset($data[$i]->strategis)){
					$j=0;
					foreach($data[$i]->strategis as $ss){
						if ($sasaran_ss!=$ss->deskripsi){
							$sasaran_ss = $ss->deskripsi;
							$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, $ss->deskripsi);
							$this->excel->getActiveSheet()->mergeCells('B'.$posisiRow.':B'.($posisiRow+$ss->rowspan-1));
						}
						if (isset($data[$i]->strategis[$j]->iku)){							
							foreach($data[$i]->strategis[$j]->iku as $iku){
								$this->excel->getActiveSheet()->setCellValue('C'.$posisiRow, ($no++));
								$this->excel->getActiveSheet()->setCellValue('D'.$posisiRow, $iku->deskripsi);
								$startcol = 69;
								for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){	
									$realisasi = isset($iku->realisasi[$colTahun])?$iku->realisasi[$colTahun]:'-';
									//$realisasi = 0;//isset($iku->target1)?$iku->target1:'-';
									$this->excel->getActiveSheet()->setCellValue(chr($startcol).$posisiRow, $realisasi);
									$startcol++;
									//$rs .= 	'<td width="85"  align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';									
								}
								$posisiRow++;
							}//end foreach IKU
						}
						$j++;
					}//end foreach data strategis
				}
				$i++;
			}//end foreach data
			
		}
		$this->excel->getActiveSheet()->getStyle('A4:A'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('B4:B'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('C4:C'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('D4:D'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
		//$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
		$this->excel->setActiveSheetIndex(0);	
		$filename='CapaianKinerjaKementerian'.$tahun.'.xls'; 
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