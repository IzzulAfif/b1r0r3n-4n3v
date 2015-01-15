<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-22 00:00
 @revision	 :
*/

class Relevansi_sastra extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();		
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('laporan/relevansi_sastra_model','relevansi',TRUE);
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
		$template['konten']	= $this->load->view('laporan/relevansi_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	
	function loadpage(){
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data = null;
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/relevansi_sastra_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_sasaran($periode,$tahun,$chkKL,$chkE1,$chkE2,$e1,$e2,$ajaxCall=true,$forExcel=false){
		$rs = '';
		
		
		if ($ajaxCall)
			$head = '<table class="display table table-bordered table-striped" width="100%">';
		else
			$head = '<table  border="1" cellpadding="4" cellspacing="0">';
			
		$headKL = '';	
		$headSastra = '';	
		//atur lebar kolom utk pdf		
		$widthKl = 100;
		$widthSastra = 120;
		$widthSasProg = 140;
		$widthSasKeg = 180;		
		
		if (($chkKL=="true")&&($chkE1=="false")&&($chkE2=="false")){
			$widthKl = 230;
			$headKL .= '<th class="col-sm-1"
			style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="'.$widthKl.'">Sasaran Kemenhub</th>';	
		}
		if ($chkKL=="true"){	
			if (($chkE1=="false")&&($chkE2=="false"))
				$widthSastra = 230;
			else if ((($chkE1=="true")&&($chkE2=="false"))||(($chkE1=="false")&&($chkE2=="true")))
				$widthSastra = 150;
			$headSastra .= '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="'.$widthSastra.'">Sasaran Strategis</th>';	
		}
		
		$headE1 = '';
		$headE2 = '';
		if ($chkE1=="true"){
			if (($chkKL=="true")&&($chkE2=="false"))
				$widthSasProg = 310;
			else if (($chkKL=="false")&&($chkE2=="false"))
				$widthSasProg = 500;
			else if (($chkKL=="false")&&($chkE2=="true"))
				$widthSasProg = 200;	
			$headE1 = '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="'.$widthSasProg.'">Sasaran Program</th>';	
		}
		if ($chkE2=="true"){
			if (($chkKL=="true")&&($chkE1=="false"))
				$widthSasKeg = 310;
			else if (($chkKL=="false")&&($chkE1=="false"))
				$widthSasKeg = 500;
			else if (($chkKL=="false")&&($chkE1=="true"))
				$widthSasKeg = 250;
			$headE2 = '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="'.$widthSasKeg.'">Sasaran Kegiatan</th>';	
		}
		
		
		$head .= '<thead><tr>'.$headKL.$headSastra.$headE1.$headE2.'</tr></thead><tbody>';	
					 
		$colKL = '';			 
		$colSastra = '';			 
		$colE1 = '';			 
		$colE2 = '';			 
		$params['tahun_renstra'] = $periode;
		$params['tahun'] = $tahun;
		$params['chkE1'] = $chkE1;
		$params['chkE2'] = $chkE2;
		if (($e1!="0")&&($chkE1=="true")) $params['kode_e1'] = $e1;
		if (($e2!="0")&&($chkE2=="true")) {
			$params['kode_e2'] = $e2;
		}
		if (($chkE1=="false")&&($chkE2=="true")) $params['kode_e1'] = $e1;
		
		$data = $this->relevansi->get_sasaran($params);
		$kode_sasaran_kl = '-1';
		$kode_ss_kl = '-1';
		$kode_sp_e1 = '-1';
		$kode_sk_e2 = '-1';
		$rs .= $head;
		if (isset($data)){
			$i=0;$cur_idx_kl=0;$cur_idx_sastra=0;$cur_idx_e1=0;
			
			foreach ($data as $d){
				if ($headKL!=""){ //tampilkan kolom sasaran KL
					if ($kode_sasaran_kl!=$d->kode_sasaran_kl){
						$kode_sasaran_kl=$d->kode_sasaran_kl;
						$data[$i]->rowspan_skl = 1;
						$cur_idx_kl=$i;
					}					
					else{
						$data[$cur_idx_kl]->rowspan_skl++;
					}
				}
				
				if ($headSastra!=""){ //tampilkan kolom sasaran strategis
					if ($kode_ss_kl!=$d->kode_ss_kl){
						$kode_ss_kl=$d->kode_ss_kl;
						$data[$i]->rowspan_sastra = 1;
						$cur_idx_sastra=$i;
					}					
					else{
						$data[$cur_idx_sastra]->rowspan_sastra++;
					}
				}
				
				if ($headE1!=""){ //tampilkan kolom sasaran program
					if ($kode_sp_e1!=$d->kode_sp_e1){
						$kode_sp_e1=$d->kode_sp_e1;
						$data[$i]->rowspan_program = 1;
						$cur_idx_e1=$i;
					}					
					else{
						$data[$cur_idx_e1]->rowspan_program++;
					}
				}
				$i++;		
			}//end foreach
				
			//	var_dump($data);die;
			$noKL=1;$noSastra=1;$noE1=1;$noE2=1;
			foreach ($data as $d){
				$rs .= 	'<tr class="gradeX">';	
				if ($headKL!=""){ //tampilkan kolom sasaran KL
					if (isset($d->rowspan_skl)){
						$rs .= '<td width="30" '.($d->rowspan_skl>0?'rowspan="'.$d->rowspan_skl.'"':'').'>'.($noKL++).'</td>';
						$rs .= '<td width="'.$widthKl.'" '.($d->rowspan_skl>0?'rowspan="'.$d->rowspan_skl.'"':'').'>'.$d->sasaran_kl.'</td>';
						$noSastra=1;
					}
				}
				if ($headSastra!=""){ //tampilkan kolom sasaran strategis
					if (isset($d->rowspan_sastra)){
						$rs .= '<td width="30" '.($d->rowspan_sastra>0?'rowspan="'.$d->rowspan_sastra.'"':'').'>'.($noSastra++).'</td>';
						$rs .= '<td width="'.$widthSastra.'" '.($d->rowspan_sastra>0?'rowspan="'.$d->rowspan_sastra.'"':'').'>'.$d->sasaran_strategis.'</td>';
						$noE1=1;
					}
				}
				if ($headE1!=""){ //tampilkan kolom sasaran program
					if (isset($d->rowspan_program)){
						$nomorTampil = $noE1++;
						if (isset($d->rowspan_sastra)){
							if ($d->rowspan_sastra==$d->rowspan_program)
								$nomorTampil ='';
						}
						
						$rs .= '<td width="30" '.($d->rowspan_program>0?'rowspan="'.$d->rowspan_program.'"':'').'>'.($nomorTampil++).'</td>';
						$rs .= '<td width="'.$widthSasProg.'" '.($d->rowspan_program>0?'rowspan="'.$d->rowspan_program.'"':'').'>'.$d->sasaran_program.'</td>';
						$noE2=1;
					}
				}
				if ($headE2!=""){ //tampilkan kolom sasaran kegiatan
					$nomorTampil = $noE2++;
					if (isset($d->rowspan_program)){
						if ($d->rowspan_program<=1)
							$nomorTampil ='';
					}
					$rs .= '<td width="30" >'.($nomorTampil).'</td>';
					$rs .= '<td width="'.$widthSasKeg.'" >'.$d->sasaran_kegiatan.'</td>';
				}
				
				$rs .= '</tr>';
				
			}//end foreach
			
		}//end isset data
		else {
			$rs .= '<tr><td colspan="2">Data tidak ditemukan</td><tr>';
		}
		
					 
		$foot = '</tbody></table>';			 
		
		$rs .= $foot;
		if ($forExcel){
			return $data;
		}
		else {
			if ($ajaxCall)	echo $rs;
			else return $rs;
		}
	}
	
	function print_pdf($periode,$tahun,$chkKL,$chkE1,$chkE2,$e1,$e2)
   {
	    $this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Cascading Sasaran Strategis');
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
		
		// set font
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage();
		//var_dump($e1);
		 $pdf->Write(0, 'CASCADING SASARAN STRATEGIS ', '', 0, 'L', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		 $pdf->Write(0, 'Tahun '.$tahun, '', 0, 'L', true, 0, false, false, 0);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		
	
	//   $data['showKl']		= $showKl;
	 //  $data['showE1']		= $showE1;
	  // $data['showE2']		= $showE2;
//	   $data['kementerian'] = $this->mgeneral->getValue("nama_kl",array('kode_kl'=>$kl,'tahun_renstra'=>$tahun),"anev_kl");
	  // $data['ikuKl']	= $this->getindikator_kl($indikator,$tahun,$tahun,"",false);
												//$kel_indikator,$tahun_awal,$tahun_akhir,$kode_e1,$kode_e2=null,$ajaxCall
												//var_dump(($showE1=="true")&&($showE2=="true"));die;
	   //$data['ikuE1']	= $this->getindikator_e1($indikator,$tahun,$tahun,$e1,(($showE1=="true")&&($showE2=="true")?$e2:null),false);
	   //if ($showE2=="true")
		//	$data['ikuE2']	= $this->getindikator_e2($indikator,$tahun,$tahun,$e1,$e2,false,false);
	   $data['relevansi'] = $this->get_sasaran($periode,$tahun,$chkKL,$chkE1,$chkE2,$e1,$e2,false);
		$html = $this->load->view('laporan/print/pdf_relevansi_sastra',$data,true);
	//	$html = $data['ikuE2'];
	
	//	$html = '<table  border="1" cellpadding="4" cellspacing="0"><thead><tr><td width="30">tes</td></tr></table>';
	 
		//var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('CascadingSasasranStrategis.pdf', 'I');
   }
   
   function excel($periode,$tahun,$chkKL,$chkE1,$chkE2,$e1,$e2){
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Cascading Sasaran Strategis');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:E1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'CASCADING SASARAN STRATEGIS');
		$this->excel->getActiveSheet()->setCellValue('A2', 'Tahun ');
		$this->excel->getActiveSheet()->setCellValue('B2', $tahun);
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->mergeCells('A3:D3');
		$params = array("tahun_renstra"=>$tahun);
		$posisiRow = 4;
		$headKL = '';	
		$headSastra = '';	
		$headE1 = '';	
		$headE2 = '';	
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow.':E'.($posisiRow))->applyFromArray(
			array(
				'font'    => array('bold'=> true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
				'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
				'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
			));
		$column_abjad = 65;	//A
		
		if (($chkKL=="true")&&($chkE1=="false")&&($chkE2=="false")){			
			$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, 'No.');
			$column_abjad++;			
			$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, 'Sasaran Kemenhub');
			$column_abjad++;			
		}
		
		if ($chkKL=="true"){				
			$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, 'No.');
			$column_abjad++;			
			$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, 'Sasaran Strategis');
			$column_abjad++;
		}
		
		if ($chkE1=="true"){				 	
			$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, 'No.');
			$column_abjad++;
			$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, 'Sasaran Program');
			$column_abjad++;
		}
		if ($chkE2=="true"){				 	
			$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, 'No.');
			$column_abjad++;
			$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, 'Sasaran Kegiatan');
			$column_abjad++;
		}
		$posisiRow++;
		 
 
	 
		$data  = $this->get_sasaran($periode,$tahun,$chkKL,$chkE1,$chkE2,$e1,$e2,false,true);
		$rs ='';
		if (isset($data)){
			$noKL=0;$noSastra=0;$noE1=0;$noE2=0;
			$posisiRowKl = $posisiRow;
			$posisiRowSS = $posisiRow;
			$posisiRowE1 = $posisiRow;
			$posisiRowE2 = $posisiRow;
			$sasaran_kl = '';
			$sasaran_ss = '';
			$sasaran_e1 = '';
			$sasaran_e2 = '';			
			foreach ($data as $d){
				$column_abjad = 65;	//A
				if (($chkKL=="true")&&($chkE1=="false")&&($chkE2=="false")){			
					// if (isset($d->rowspan_skl)){
						// $this->excel->getActiveSheet()->mergeCells(chr($column_abjad).$posisiRowKl.':'.chr($column_abjad).$d->rowspan_skl);
						// $posisiRowKl += $d->rowspan_skl;
					// }	
					// else {
						// $posisiRowKl++;
					// }
					if ($sasaran_kl!=$d->sasaran_kl){
						$sasaran_kl=$d->sasaran_kl;
						$noKL++;
						$noSastra=0;
					}
					$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, ($noKL));
					$column_abjad++;
					// if (isset($d->rowspan_skl)){
						// $this->excel->getActiveSheet()->mergeCells(chr($column_abjad).$posisiRowKl.':'.chr($column_abjad).$d->rowspan_skl);
					// }	
					$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, $d->sasaran_kl);
					$column_abjad++;
					
				}
				
				if ($chkKL=="true"){				 	
					// if (isset($d->rowspan_sastra)){
						// $this->excel->getActiveSheet()->mergeCells(chr($column_abjad).$posisiRowSS.':'.chr($column_abjad).($posisiRowSS+$d->rowspan_sastra));										
					// }	
					if ($sasaran_ss!=$d->sasaran_strategis){
						$sasaran_ss=$d->sasaran_strategis;
						$noSastra++;
						$noE1=0;
					}	
					$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, ($noSastra));
					$column_abjad++;
					// if (isset($d->rowspan_sastra)){
						// $this->excel->getActiveSheet()->mergeCells(chr($column_abjad).$posisiRowSS.':'.chr($column_abjad).($posisiRowSS+$d->rowspan_sastra));
					// }
					
					$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, $d->sasaran_strategis);
					// if (isset($d->rowspan_sastra)){
						// $posisiRowSS += $d->rowspan_sastra+1;
					// }
					// else {
						// $posisiRowSS++;
					// } 		
					$column_abjad++;
					
				}
				if ($chkE1=="true"){	
					if ($sasaran_e1!=$d->sasaran_program){
						$sasaran_e1=$d->sasaran_program;
						$noE1++;
						$noE2=0;
					}	 
					$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, $noE1);
					$column_abjad++;
					$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, $d->sasaran_program);
					$column_abjad++;
				}
				if ($chkE2=="true"){					
					$noE2++;
					$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, ($noE2));
					$column_abjad++;
					$this->excel->getActiveSheet()->setCellValue(chr($column_abjad).$posisiRow, $d->sasaran_kegiatan);
					$column_abjad++;
				}
				
				$posisiRow++;
				 
				
			}//end foreach
		}
		
		
		$this->excel->setActiveSheetIndex(0);	
		$filename='CascadingSasaranStrategis'.$tahun.'.xls'; 
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