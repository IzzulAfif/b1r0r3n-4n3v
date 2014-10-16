<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-16 00:00
 @revision	 :
*/

class Profil_eselon2 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/unit_kerja/fungsi_eselon2_model','fungsi_e2');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(array("check_locking"=>true));
		$template['konten']	= $this->load->view('laporan/profil_eselon2_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadprofile()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_all(null);
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/profil_eselon2_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_list_eselon1($tahun)
	{
		$params = array("tahun_renstra"=>$tahun);
		echo json_encode($this->eselon1->get_list($params));
	}
	
	function get_list_eselon2($tahun,$kode_e1)
	{
		$params = array("tahun_renstra"=>$tahun,"kode_e1"=>$kode_e1);
		echo json_encode($this->eselon2->get_list($params));
	}
	
	function get_unit_kerja($tahun,$e2){
		$data = $this->eselon2->get_all(array("tahun_renstra"=>$tahun,"kode_e2"=>$e2));
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
	
	function get_fungsi($tahun,$e2,$ajaxCall=true){
		$data = $this->fungsi_e2->get_all(array("kode_e2"=>$e2,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$showNumber = (count($data)>1);
			if ($showNumber) $rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				if ($showNumber) $rs .= '<li>'.$d->fungsi_e2.'</li>';
				else $rs .= $d->fungsi_e2;
			 }
			 if ($showNumber) $rs .= '</ol>';
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_tugas($tahun,$e2,$ajaxCall=true){
		$data = $this->eselon2->get_all(array("kode_e2"=>$e2,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$showNumber = (count($data)>1);
			if ($showNumber) $rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				if ($showNumber) $rs .= '<li>'.$d->tugas_e2.'</li>';
				else $rs .= $d->tugas_e2;
			 }
			 if ($showNumber) $rs .= '</ol>';
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function print_pdf($tahun,$e2)
   {
	   //$this->load->library('pdf');
	    $this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Profil Unit Kerja Eselon II');
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
		 $pdf->Write(0, 'Profil Unit Kerja Eselon II ', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

	   $data['renstra']		= $tahun;
	   $data['nama_unit'] 	= $this->mgeneral->getValue("nama_e2",array('kode_e2'=>$e2,'tahun_renstra'=>$tahun),"anev_eselon2");
	  // $data['unit_kerja']	= $this->eselon2->get_all(array("kode_e2"=>$e2,"tahun_renstra"=>$tahun));
	   $data['fungsi']		= $this->get_fungsi($tahun,$e2,false);
	   $data['tugas']		= $this->get_tugas($tahun,$e2,false);
	   
		$html = $this->load->view('laporan/print/pdf_profile_e2',$data,true);
	//	$html = $data['ikuE2'];
		//var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('ProfilEselonII.pdf', 'I');
		
	 
   }

}