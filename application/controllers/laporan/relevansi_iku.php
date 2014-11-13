<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-22 00:00
 @revision	 :
*/

class Relevansi_iku extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();		
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('laporan/relevansi_iku_model','relevansi',TRUE);
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
		echo $this->load->view('laporan/relevansi_iku_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_iku($periode,$tahun,$chkKL,$chkE1,$chkE2,$e1,$e2,$ajaxCall=true){
		$rs = '';
		
		
		if ($ajaxCall)
			$head = '<table class="display table table-bordered table-striped" width="100%">';
		else
			$head = '<table  border="1" cellpadding="4" cellspacing="0">';
			
		//atur lebar kolom utk pdf		
		$widthKl = 130;
		$widthE1 = 130;
		$widthE2 = 180;
		
		$headKL = '';	
		if ($chkKL=="true")	{
			if (($chkE1=="false")&&($chkE2=="false"))
				$widthKl = 500;
			else if ((($chkE1=="true")&&($chkE2=="false"))||(($chkE1=="false")&&($chkE2=="true")))
				$widthKl = 150;
			$headKL .= '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="'.$widthKl.'">IKU Kementerian</th>';	
		}
			
		$headE1 = '';
		$headE2 = '';
			
		if ($chkE1=="true"){
			if (($chkKL=="true")&&($chkE2=="false"))
				$widthE1 = 310;
			else if (($chkKL=="false")&&($chkE2=="false"))
				$widthE1 = 500;
			else if (($chkKL=="false")&&($chkE2=="true"))
				$widthE1 = 200;	
			$headE1 = '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="'.$widthE1.'">IKU Eselon I</th>';	
		}
		if ($chkE2=="true"){
			if (($chkKL=="true")&&($chkE1=="false"))
				$widthE2 = 310;
			else if (($chkKL=="false")&&($chkE1=="false"))
				$widthE2 = 500;
			else if (($chkKL=="false")&&($chkE1=="true"))
				$widthE2 = 250;
			$headE2 = '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="'.$widthE2.'">IKK</th>';	
		}
		
		
		$head .= '<thead><tr>'.$headKL.$headE1.$headE2.'</tr></thead><tbody>';	
					 
		$colKL = '';			 
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
		
		$data = $this->relevansi->get_iku($params);
		$kode_iku_kl = '-1';
		$kode_ss_kl = '-1';
		$kode_iku_e1 = '-1';
		$kode_iku_e2 = '-1';
		if (isset($data)){
			$rs .= $head;
			$i=0;$cur_idx_kl=0;$cur_idx_e1=0;
			
			foreach ($data as $d){
				if ($headKL!=""){ //tampilkan kolom iku KL
					if ($kode_iku_kl!=$d->kode_iku_kl){
						$kode_iku_kl=$d->kode_iku_kl;
						$data[$i]->rowspan_kl = 1;
						$cur_idx_kl=$i;
					}					
					else{
						$data[$cur_idx_kl]->rowspan_kl++;
					}
				}
												
				if ($headE1!=""){ //tampilkan kolom iku e1
					if ($kode_iku_e1!=$d->kode_iku_e1){
						$kode_iku_e1=$d->kode_iku_e1;
						$data[$i]->rowspan_e1 = 1;
						$cur_idx_e1=$i;
					}					
					else{
						$data[$cur_idx_e1]->rowspan_e1++;
					}
				}
				$i++;		
			}//end foreach
			
			//	var_dump($data);die;
			$noKL=1;$noE1=1;$noE2=1;
			foreach ($data as $d){
				$rs .= 	'<tr class="gradeX">';	
				if ($headKL!=""){ //tampilkan kolom IKU KL
					if (isset($d->rowspan_kl)){
						$rs .= '<td width="30" '.($d->rowspan_kl>0?'rowspan="'.$d->rowspan_kl.'"':'').'>'.($noKL++).'</td>';
						$rs .= '<td width="'.$widthKl.'" '.($d->rowspan_kl>0?'rowspan="'.$d->rowspan_kl.'"':'').'>'.$d->deskripsi_kl.'</td>';
						$noE1=1;
					}
				}
				if ($headE1!=""){ //tampilkan kolom IKU E1
					if (isset($d->rowspan_e1)){
						$nomorTampil = $noE1++;
						if (isset($d->rowspan_kl)){
							if ($d->rowspan_kl==$d->rowspan_e1)
								$nomorTampil ='';
						}
						$rs .= '<td width="30" '.($d->rowspan_e1>0?'rowspan="'.$d->rowspan_e1.'"':'').'>'.($nomorTampil).'</td>';
						$rs .= '<td width="'.$widthE1.'" '.($d->rowspan_e1>0?'rowspan="'.$d->rowspan_e1.'"':'').'>'.$d->deskripsi_e1.'</td>';
						$noE2=1;
					}
				}
				if ($headE2!=""){ //tampilkan kolom IKK
					$nomorTampil = $noE2++;
					if (isset($d->rowspan_e1)){
						if ($d->rowspan_e1<=1)
							$nomorTampil ='';
					}
					$rs .= '<td width="30" >'.($nomorTampil).'</td>';
					$rs .= '<td width="'.$widthE2.'" >'.$d->deskripsi_e2.'</td>';
				}
				
				$rs .= '</tr>';
				
			}//end foreach
			
		}//end isset data
		
					 
		$foot = '</tbody></table>';			 
		
		$rs .= $foot;
		
	//	$rs = $head.$foot;
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	
	function print_pdf($periode,$tahun,$chkKL,$chkE1,$chkE2,$e1,$e2)
   {
	    $this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Cascading IKU');
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
		 $pdf->Write(0, 'CASCADING IKU/IKK ', '', 0, 'L', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		 $pdf->Write(0, 'Tahun '.$tahun, '', 0, 'L', true, 0, false, false, 0);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		
	
	   $data['relevansi'] = $this->get_iku($periode,$tahun,$chkKL,$chkE1,$chkE2,$e1,$e2,false);
		$html = $this->load->view('laporan/print/pdf_relevansi_iku',$data,true);
	
		
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('CascadingIKU_IKK.pdf', 'I');
   }
	
}