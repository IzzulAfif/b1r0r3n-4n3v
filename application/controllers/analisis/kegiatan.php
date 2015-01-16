<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-08-24 00:00
 @revision	 : 2014-09-01 --> melanjutkan
*/

class Kegiatan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('analisis/analisis_model','',TRUE);
		$this->load->model('admin/lokasi_model','lokasi',TRUE);
		$this->load->model('analisis/kegiatan_model','kegiatan',TRUE);
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
	}
	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "ANALISIS");
		$setting['page']	= array('pg_aktif'	=> "map");
		$template			= $this->template->load($setting); #load static template file
		
		$data				= "";
		$template['konten']	= $this->load->view('analisis/kegiatan',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function data()
	{
		$data = null;
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		$data['lokasi'] = $this->lokasi->get_list(null);
		$data['output'] = null;//$this->kegiatan->get_output(null);
		$this->load->view('analisis/data_kegiatan',$data);
	}
	
	function get_program($tahun)
	{
		$result	= $this->kegiatan->get_program($tahun);
		echo json_encode($result);
	}
	
	function get_kegiatan($tahun,$program)
	{
		$result	= $this->kegiatan->get_kegiatan($tahun,$program);
		echo json_encode($result);
	}
	
	function get_output($kegiatan)
	{
		$result	= $this->kegiatan->get_output(array("kode_kegiatan"=>$kegiatan));
		echo json_encode($result);
	}
	
	function get_list_rincian($tahun,$kode_program,$kode_kegiatan,$kdouput,$tipe="html")
	{
		$params['tahun'] = $tahun;
		$params['kode_program'] = $kode_program;
		$params['kode_kegiatan'] = $kode_kegiatan;
		//diganti ku output $params['kdlokasi'] = $kdlokasi;
		$params['kdoutput'] = $kdouput;
		
		$data	= $this->kegiatan->get_rincian_paket_pekerjaan($params);
		
		$rs = '';$i=1;
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td style="width:20px;">'.($i++).'</td>
					<td style="width:250px;">'.$d->nmitem.'</td>
					<td align="right" style="width:50px;">'.$this->utility->cekNumericFmt($d->volkeg).'</td>					
					<td style="width:70px;">'.$d->satkeg.'</td>					
					<td>'.$d->nama_kabkota.'</td>'					
					//<td>'.$d->nama_status.'</td>					
					
				.'</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="5">Data tidak ditemukan</td>
			</tr>';
			//<td>&nbsp;</td>				<td>&nbsp;</td>
		}
		if($tipe=="html"):
			echo $rs;
		else:
			return $rs;
		endif;
	}
	
	function print_list_rincian($tahun,$kode_program,$kode_kegiatan,$kdouput)
	{
		
		$tabel  = '<page format="A4"><table style="width:650px;" border="1" cellpadding="4" cellspacing="0">';
		$tabel .= '<thead>
                    	<tr>
                    		<th style="width:20px;">No</th>
                            <th style="width:250px;">Paket Pekerjaan</th>
                            <th style="width:50px;">Volume</th>
                            <th style="width:70px;">Satuan</th>
                           <th>Kabupaten/Kota</th>
                        </tr>
                    </thead>';
		$tabel .= $this->get_list_rincian($tahun,$kode_program,$kode_kegiatan,$kdouput,"get");
		$tabel .= '</table></page>';
		
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', FALSE, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Rincian Paket Pekerjaan');
		$pdf->SetHeaderMargin(15);
		$pdf->SetTopMargin(15);
		$pdf->SetLeftMargin(15);
		$pdf->SetRightMargin(15);
		$pdf->setFooterMargin(5);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);	
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		
		// set font
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage('P');
		//var_dump($e1);
		 $pdf->Write(0, 'Rincian Paket Pekerjaan ', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);
				
		$pdf->writeHTML($tabel, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('kegiatan_detail.pdf', 'I');
	}
	
	function ekspor_list_rincian($tahun,$kode_program,$kode_kegiatan,$kdouput)
	{
		$params['tahun'] = $tahun;
		$params['kode_program'] = $kode_program;
		$params['kode_kegiatan'] = $kode_kegiatan;
		//diganti ku output $params['kdlokasi'] = $kdlokasi;
		$params['kdoutput'] = $kdouput;
		
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Rincian Paket Pekerjaan');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->mergeCells('A1:E1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Analisis dan Evaluasi Capaian Program ');
		
		$this->excel->getActiveSheet()->mergeCells('A2:E2');
		
		$this->excel->getActiveSheet()->setCellValue('A4', 'No');
		$this->excel->getActiveSheet()->setCellValue('B4', 'Paket Pekerjaan');
		$this->excel->getActiveSheet()->setCellValue('C4', 'Volume');
		$this->excel->getActiveSheet()->setCellValue('D4', 'Satuan');
		$this->excel->getActiveSheet()->setCellValue('E4', 'Kab/Kota');
		
		$data	= $this->kegiatan->get_rincian_paket_pekerjaan($params);
		if(count($data)!=0):
		
		$no=1;
		$rowExcel = 5;
		foreach($data as $d):
			$this->excel->getActiveSheet()->setCellValue('A'.$rowExcel, $no);
			$this->excel->getActiveSheet()->setCellValue('B'.$rowExcel, $d->nmitem);
			$this->excel->getActiveSheet()->setCellValue('C'.$rowExcel, $d->volkeg);
			$this->excel->getActiveSheet()->setCellValue('D'.$rowExcel, $d->satkeg);
			$this->excel->getActiveSheet()->setCellValue('E'.$rowExcel, $d->nama_kabkota);
			$no++;
			$rowExcel++;
		endforeach;
		
		endif;
		
		$filename='rincian_paket_pekerjaan.xls'; 
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
	
	function map()
	{
		$data = null;
		$this->load->view('analisis/map_kegiatan',$data);
	}
}