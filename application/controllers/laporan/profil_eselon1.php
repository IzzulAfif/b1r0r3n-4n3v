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
	

	
	function get_unit_kerja($tahun,$e1){
		$data = $this->eselon2->get_all(array("tahun_renstra"=>$tahun,"kode_e1"=>$e1));
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
	
	function get_fungsi($tahun,$e1){
		$data = $this->fungsi_e1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->fungsi_e1.'</li>';
			 }
			 $rs .= '</ol>';
		}
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
	
   function print_pdf($tahun,$e1)
   {
	   $this->load->library('tcpdf_','pdf');
	   
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Rencana Strategis Kementerian');
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
		// set font
		$pdf->SetFont('helvetica', 'B', 12);
		// add a page
		$pdf->AddPage();
		$pdf->Write(0, 'PROFILE UNIT KERJA ESELON I', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 10);
		
	   $data['renstra']		= $tahun;
	   $data['nama_unit'] 	= $this->mgeneral->getValue("nama_e1",array('kode_e1'=>$e1,'tahun_renstra'=>$tahun),"anev_eselon1");
	   $data['unit_kerja']	= $this->eselon2->get_all(array("kode_e1"=>$e1));
	   $data['fungsi']		= $this->fungsi_e1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
	   $data['tugas']		= $this->eselon1->get_all(array("kode_e1"=>$e1,"tahun_renstra"=>$tahun));
	   
	   $html = $this->load->view('laporan/print/pdf_profile_e1',$data,true);
	   
	   $pdf->writeHTML($html, true, false, false, false, '');
		$pdf->SetFont('helvetica', 'B', 10);
	
		$pdf->Output('profile_eselon1.pdf', 'I');
   }

}