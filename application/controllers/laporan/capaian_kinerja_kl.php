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
		$data['eselon1'] = $this->eselon1->get_list(null);
		$template['konten']	= $this->load->view('laporan/capaian_kinerja_kl_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loaddata()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		//$data['eselon1'] = $this->eselon1->get_list(null);
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
	

	
	function get_capaian($tahun,$ajaxCall=true){
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
						<th style="vertical-align:middle;text-align:center;width:20%"  valign="middle" width="100" rowspan="2">'.$setValignMiddle.'Sasaran</th>
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
				$rs .= '<td rowspan="'.($data[$i]->rowspan).'" >'.$d->sasaran_kl.'</td>';			
				
							
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
		
		if ($ajaxCall)	echo $rs;
		else return $rs;
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

}