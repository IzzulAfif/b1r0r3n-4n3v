<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-16 00:00
 @revision	 :
*/

class Profil_eselon1 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/unit_kerja/fungsi_eselon1_model','fungsi_e1');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(null);
		$template['konten']	= $this->load->view('laporan/profil_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadprofile()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(null);
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/profil_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_list_eselon1($tahun)
	{
		$params = array("tahun_renstra"=>$tahun);
		echo json_encode($this->eselon1->get_list($params));
	}
	

	
	function get_unit_kerja($tahun,$e1,$ajaxCall=true){
		$data = $this->eselon2->get_all(array("tahun_renstra"=>$tahun,"kode_e1"=>$e1));
		$rs = '';
		if (isset($data)){
			$showNumber = (count($data)>1);
			if ($showNumber) $rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				if ($showNumber) $rs .= '<li>'.$d->nama_e2.'</li>';
				else $rs .=  $d->nama_e2;
				//else $rs .= ($showNumber?$i++.". ":"").$d->nama_e2."<br>";
			 }
			if ($showNumber)  $rs .= '</ol>';
	}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_fungsi($tahun,$e1,$ajaxCall=true){
		$data = $this->fungsi_e1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$showNumber = (count($data)>1);
			if ($showNumber) $rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				if ($showNumber) $rs .= '<li>'.$d->fungsi_e1.'</li>';
				else $rs .=  $d->fungsi_e1;
			 }
			if ($showNumber)  $rs .= '</ol>';
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_tugas($tahun,$e1,$ajaxCall=true){
		$data = $this->eselon1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$showNumber = (count($data)>1);
			if ($showNumber) $rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				if ($showNumber) $rs .= '<li>'.$d->tugas_e1.'</li>';
				else $rs .= $d->tugas_e1;
			 }
			if ($showNumber)  $rs .= '</ol>';
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
   function print_pdf($tahun,$e1)
   {
	   $this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Profil Unit Kerja Eselon I');
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
		
		// add a page
		
		// set font
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage();
		//var_dump($e1);
		 $pdf->Write(0, 'Profil Unit Kerja Eselon I ', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

	   $data['renstra']		= $tahun;
	   $data['nama_unit'] 	= $this->mgeneral->getValue("nama_e1",array('kode_e1'=>$e1,'tahun_renstra'=>$tahun),"anev_eselon1");
	   $data['unitkerja']	= $this->get_unit_kerja($tahun,$e1,false);//$this->eselon2->get_all(array("kode_e1"=>$e1));
	   $data['fungsi']		= $this->get_fungsi($tahun,$e1,false);//fungsi_e1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
	   $data['tugas']		= $this->get_tugas($tahun,$e1,false);//$this->eselon1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
	   
		$html = $this->load->view('laporan/print/pdf_profile_e1',$data,true);
	//	$html = $data['ikuE2'];
		//var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('ProfilEselonI.pdf', 'I');
   }
   
   public function excel($tahun,$e1){
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Profil Unit Kerja Eselon I');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:B1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Profil Unit Kerja Eselon I');
		$this->excel->getActiveSheet()->setCellValue('A2', 'Periode Renstra ');
		$this->excel->getActiveSheet()->setCellValue('B2', $tahun);
		$this->excel->getActiveSheet()->mergeCells('A3:B3');
		
		$params = array('kode_e1'=>$e1,'tahun_renstra'=>$tahun);
		$posisiRow = 4;		
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Unit Kerja');
		$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow,  $this->mgeneral->getValue("nama_e1",$params,"anev_eselon1"));
		$posisiRow++;
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Tugas');
		$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow,  $this->mgeneral->getValue("tugas_e1",$params,"anev_eselon1"));
		
		$posisiRow++;
		$fungsi = $this->fungsi_e1->get_all($params);
		$fungsi_arr = null;
		
		if (isset($fungsi)){
			foreach ($fungsi as $u){
				$fungsi_arr[] = array($u->fungsi_e1);
			}
		}
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Fungsi');
		if (count($fungsi_arr)>0){
			$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+count($fungsi_arr)-1));
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->fromArray($fungsi_arr,NULL,'B'.$posisiRow);		
			$posisiRow += count($fungsi_arr);
		}else $posisiRow++;
		
		$unitkerja = $this->eselon2->get_all($params);
		$unitkerja_arr = null;		
		if (isset($unitkerja)){
			foreach ($unitkerja as $u){
				$unitkerja_arr[] = array($u->nama_e2);
			}
		}		
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Unit Kerja');		
		if (count($unitkerja_arr)>0){
			$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+count($unitkerja_arr)-1));
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->fromArray($unitkerja_arr,NULL,'B'.$posisiRow);
		}
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(100);
		
		$this->excel->getActiveSheet()->getStyle('B4:B100'.$this->excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
	
		$filename='profil_eselon1_'.$tahun.'.xls'; 
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