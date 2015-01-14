<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup
 @date       : 2014-09-20 00:00
 @revision	 :
*/

class Kegiatan_pembangunan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('analisis/analisis_model','',TRUE);
		$this->load->model('admin/lokasi_model','lokasi',TRUE);
		$this->load->model('admin/tahun_renstra_model','tahun_renstra',TRUE);
		$this->load->model('pemrograman/kegiatan_eselon2_model','kegiatan',TRUE);
		$this->load->model('laporan/kegiatan_pembangunan_model','pembangunan',TRUE);
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/pemrograman/sasaran_strategis_model','sastra');
		$this->load->model('/pemrograman/program_eselon1_model','program');
		$this->load->model('/admin/kel_indikator_model','kel_indikator');
		
	}
	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "map");
		$template			= $this->template->load($setting); #load static template file
		
		$data['tahun_renstra']				= $this->tahun_renstra->get_list(null);
		$data['eselon1'] = $this->eselon1->get_list(array("check_locking"=>false));
		$data['kelompok_indikator'] = $this->kel_indikator->get_list(null);
		$data['lokasi'] = $this->lokasi->get_list(null);
		$template['konten']	= $this->load->view('laporan/kegiatan_pembangunan_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	function get_list_eselon1()
	{
		$params = array("check_locking"=>false);
		echo json_encode($this->eselon1->get_list($params));
	}
	
	function get_list_eselon2($kode_e1)
	{
		$params = array("kode_e1"=>$kode_e1);
		echo json_encode($this->eselon2->get_list($params));
	}
	
	
	function get_sastra($tahun)
	{		
		$result	= $this->sastra->get_list(array("tahun"=>$tahun));
		echo json_encode($result);
	}
	
	function get_program($tahun)
	{		
		$result	= $this->program->get_list(array("tahun"=>$tahun,"isNotMandatory"=>true));
		echo json_encode($result);
	}
	
	function get_kegiatan($tahun,$program)
	{
		$result	= $this->kegiatan->get_list(array("tahun"=>$tahun,"kode_program"=>$program,"isNotMandatory"=>true));
		echo json_encode($result);
	}
	
	function get_list_rincian($tahun,$indikator,$kode_program,$kode_kegiatan,$kdlokasi,$ajaxCall=true,$forExcel=false)
	{
		$params['tahun'] = $tahun;
		$params['indikator'] = $indikator;
		if ($kode_program!="0")
			$params['kode_program'] = $kode_program;
		if ($kode_kegiatan!="0")	
			$params['kode_kegiatan'] = $kode_kegiatan;
		//$params['kdlokasi'] = $kdlokasi;
		
		$data	= $this->pembangunan->get_detil_belanja($params);
		if ($ajaxCall)
				$head = '<table class="display table table-bordered table-striped" width="100%">';
			else
				$head = '<table  border="1" cellpadding="4" cellspacing="0">';
					
		$head .= '<thead>
                    	<tr>
                    		<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:1%" width="30">No.</th>'
                            .($ajaxCall?'<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="100">Program</th>':'')
                            .'<th style="vertical-align:middle;text-align:center;width:20%" width="100">Kegiatan</th>
                            <th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="120">IKK</th>
                            <th class="col-sm-1" style="vertical-align:middle;text-align:center;width:10%" width="70">Satuan</th>
                            <th class="col-sm-1" style="vertical-align:middle;text-align:center;width:10%" width="70">Realisasi</th>
                            <th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="160">Output</th>
                            <th class="col-sm-1" style="vertical-align:middle;text-align:center;width:10%" width="70">Satuan</th>
                            <th class="col-sm-1" style="vertical-align:middle;text-align:center;width:10%" width="80">Volume</th>
                            <th class="col-sm-1" style="vertical-align:middle;text-align:center;width:10%" width="80">Jumlah</th>
                        </tr>
                    </thead>
					 <tbody>';
					 
		$foot =	'</tbody>
    	        </table>';
		$totalPagu = 0;
		if ($ajaxCall)
			$rs = $head;
		else
			$rs ='';
		$i=1;
		
		//setting rowspan
		if (isset($data)){
			$nama_program = '';
			$nama_kegiatan = '';
			$kode_ikk = '-1';
			$i=0;
			$cur_idx_program=0;
			$cur_idx_kegiatan=0;
			$cur_idx_ikk=0;
			foreach($data as $d){						
				if ($nama_program!=$d->nama_program){
					$nama_program=$d->nama_program;
					$data[$i]->program_rowspan = 1;
					$cur_idx_program = $i;
				}else{
					$data[$cur_idx_program]->program_rowspan++;
				}
				if ($nama_kegiatan!=$d->nama_kegiatan){
					$nama_kegiatan=$d->nama_kegiatan;
					$data[$i]->kegiatan_rowspan = 1;
					$cur_idx_kegiatan = $i;
				}else{
					$data[$cur_idx_kegiatan]->kegiatan_rowspan++;
				}
				if ($kode_ikk!=$d->kode_ikk){
					$kode_ikk = $d->kode_ikk;
					$data[$i]->ikk_rowspan = 1;
					$data[$i]->sum_jumlah = $d->total_jumlah;					
					$cur_idx_ikk = $i;
				}else{
					$data[$cur_idx_ikk]->ikk_rowspan++;
					$data[$cur_idx_ikk]->sum_jumlah += $d->total_jumlah;
				}
				
				$i++;
			}
		}
			
			
		if (isset($data)){
			//$rs = $head;
			$nama_program = '';
			$i=1;$no=1;
			foreach($data as $d): 
			//	$totalPagu += $d->jumlah;
				if ($ajaxCall){	
					$rs .= '<tr class="gradeX">';				
					if (isset($d->program_rowspan)){
						$rs .= '<td width="30" '.($d->program_rowspan>0?'rowspan="'.$d->program_rowspan.'"':'').'>'.($no++).'</td>';
						$rs .= '<td width="100" '.($d->program_rowspan>0?'rowspan="'.$d->program_rowspan.'"':'').'>'.$d->nama_program.'</td>';
					}
				}else {
						if ($nama_program != $d->nama_program){
						//	var_dump('kadie');
							$nama_program = $d->nama_program;
							if ($no>1)
								$rs .= $foot;
							$rs .= "<p class='text-info'><b>Nama Program : ".$d->nama_program.'</b></p>';
							$rs .= $head;
							$rs .= '<tr class="gradeX">';				
						
						
						}
						else {
							$rs .= '<tr class="gradeX">';				
						}
				
				}
				if (isset($d->kegiatan_rowspan)){
					if (!$ajaxCall){	
						
						$rs .= '<td width="30" '.($d->kegiatan_rowspan>0?'rowspan="'.$d->kegiatan_rowspan.'"':'').'>'.($no++).'</td>';
					}
					$rs .= '<td width="100" '.($d->kegiatan_rowspan>0?'rowspan="'.$d->kegiatan_rowspan.'"':'').'>'.$d->nama_kegiatan.'</td>';
				}
					
				if (isset($d->ikk_rowspan))
					$rs .= '<td width="120" '.($d->ikk_rowspan>0?'rowspan="'.$d->ikk_rowspan.'"':'').'>'.$d->deskripsi.'</td>
					<td width="70" '.($d->ikk_rowspan>0?'rowspan="'.$d->ikk_rowspan.'"':'').'>'.$d->satuan.'</td>
					<td width="70" align="right" '.($d->ikk_rowspan>0?'rowspan="'.$d->ikk_rowspan.'"':'').'>'.$this->utility->cekNumericFmt($d->realisasi).'</td>';
					
				$rs .= '<td width="160">'.$d->nmoutput.'</td>
				<td width="70">'.$d->satuan_output.'</td><td width="80" align="right" >'.$this->utility->cekNumericFmt($d->total_volkeg).'</td>';
				
				if (isset($d->ikk_rowspan))
					$rs .= '<td width="80" align="right" '.($d->ikk_rowspan>0?'rowspan="'.$d->ikk_rowspan.'"':'').'>'.$this->utility->cekNumericFmt($d->sum_jumlah).'</td>';
					
					//sementara hide dulu coz blm ada data nya
					/*<td align="right">'.$this->utility->cekNumericFmt($d->hargasat).'</td>					
					<td align="right">'.$this->utility->cekNumericFmt($d->jumlah).'</td>					
					<td width="80" align="right">'.$this->utility->cekNumericFmt($d->volkeg).'</td>					
					
					*/
					$rs .='</tr>';
				endforeach; 
		} else {
			if (!$ajaxCall) 
				$rs .= $head;
			$rs .= '<tr class="gradeX">
					<td colspan="10" width="780">Data tidak ditemukan</td>
					</tr>';
		}
		
		
		$rs .= $foot;
	//	var_dump($rs);die;
		if ($forExcel){
			return $data;
		}
		else {
			if ($ajaxCall)	echo $rs;
			else return $rs;
		}
	}
	
	function print_pdf($renstra,$tahun,$indikator,$kode_program,$kode_kegiatan,$kdlokasi)
   {
	    $this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Rincian Kegiatan Pembangunan Menurut Indikator');
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
		$pdf->AddPage('L');
		//var_dump($e1);
		 $pdf->Write(0, 'OUTPUT KEGIATAN PEMBANGUNAN MENURUT KELOMPOK INDIKATOR', '', 0, 'L', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		$data['renstra']		= $renstra;
	   $data['tahun']		= $tahun;
	   $data['indikator']		= $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$indikator),"anev_kel_indikator");
	   $data['program']		= $this->mgeneral->getValue("nama_program",array('kode_program'=>$kode_program,'tahun'=>$tahun),"anev_program_eselon1");
	  // $data['kegiatan']		= $this->mgeneral->getValue("nama_kegiatan",array('kode_kegiatan'=>$kode_kegiatan,'tahun'=>$tahun),"anev_kegiatan_eselon2");
	//  $data['lokasi']		= $this->mgeneral->getValue("lokasi",array('kdlokasi'=>$kdlokasi),"anev_lokasi");
	   //$data['indikator']		= $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$indikator,'tahun_renstra'=>$indikator),"anev_kel_indikator");
	   
	   $data['itempekerjaan'] = $this->get_list_rincian($tahun,$indikator,$kode_program,$kode_kegiatan,$kdlokasi,false);
	   
		$html = $this->load->view('laporan/print/pdf_pembangunan',$data,true);
	
	//	var_dump($html);die;
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('RincianKegiatanPembangunan.pdf', 'I');
   }
	
	function excel($renstra,$tahun,$indikator,$kode_program,$kode_kegiatan,$kdlokasi){
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Rincian Kegiatan Pembangunan');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:I1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'OUTPUT KEGIATAN PEMBANGUNAN MENURUT KELOMPOK INDIKATOR');
		$this->excel->getActiveSheet()->setCellValue('A2', 'Periode Renstra ');
		$this->excel->getActiveSheet()->setCellValue('B2', $renstra);
		$this->excel->getActiveSheet()->setCellValue('A3', 'Tahun ');
		$this->excel->getActiveSheet()->setCellValue('B3', $tahun);
		$this->excel->getActiveSheet()->setCellValue('A4', 'Indikator ');
		$this->excel->getActiveSheet()->setCellValue('B4', $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$indikator),"anev_kel_indikator"));
		$this->excel->getActiveSheet()->setCellValue('A5', 'Item Pekerjaan Pembangunan ');
		$this->excel->getActiveSheet()->mergeCells('A5:G5');
		//$this->excel->getActiveSheet()->mergeCells('A3:D3');
		$params = array("tahun_renstra"=>$renstra);
		$posisiRow = 7;
		 $columHeader = array("No.","Kegiatan","IKK","Satuan","Realisasi","Output","Satuan","Volume","Jumlah");
		$data =  $this->get_list_rincian($tahun,$indikator,$kode_program,$kode_kegiatan,$kdlokasi,false,true);
		if (isset($data)){
			$nama_program = '';
			$i=1;$no=1;
			foreach ($data as $d){
				if ($nama_program != $d->nama_program){
					$nama_program = $d->nama_program;
					// if ($no>1)
						// $rs .= $foot;
					$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':I'.$posisiRow);
					$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow,$d->nama_program );
					$posisiRow++; 
					$this->excel->getActiveSheet()->fromArray($columHeader,NULL,'A'.$posisiRow);
						$this->excel->getActiveSheet()->getStyle('A'.($posisiRow).':D'.$posisiRow)->applyFromArray(
						array(
							'font'    => array('bold'=> true),
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
							'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
							'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
						));	
					//$rs .= $head;
					$posisiRow++; 
				}	
				$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, $no++);
				$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, $d->nama_kegiatan);
				$this->excel->getActiveSheet()->setCellValue('C'.$posisiRow, $d->deskripsi);
				$this->excel->getActiveSheet()->setCellValue('D'.$posisiRow, $d->satuan);
				$this->excel->getActiveSheet()->setCellValue('E'.$posisiRow, $this->utility->cekNumericFmt($d->realisasi));
				$this->excel->getActiveSheet()->setCellValue('F'.$posisiRow, $d->nmoutput);
				$this->excel->getActiveSheet()->setCellValue('G'.$posisiRow, $d->satuan_output);
				$this->excel->getActiveSheet()->setCellValue('H'.$posisiRow, $this->utility->cekNumericFmt($d->total_volkeg));
				$this->excel->getActiveSheet()->setCellValue('I'.$posisiRow, $this->utility->cekNumericFmt($d->sum_jumlah));
				$posisiRow++;	
			}
		}
		
		$this->excel->setActiveSheetIndex(0);	
		$filename='KegiatanPembangunan'.$tahun.'.xls'; 
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