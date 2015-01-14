<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-10-01 00:00
 @revision	 :
*/

class Kelompok_indikator extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/unit_kerja/kl_model','kl');
		$this->load->model('/admin/kel_indikator_model','kel_indikator');
		$this->load->model('/laporan/kelompok_indikator_kl_model','kel_indikator_kl');
		$this->load->model('/laporan/kelompok_indikator_e1_model','kel_indikator_e1');
		$this->load->model('/laporan/kelompok_indikator_e2_model','kel_indikator_e2');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		$data['kelompok_indikator'] = $this->kel_indikator->get_list(null);
		$template['konten']	= $this->load->view('laporan/kelompok_indikator_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	
	function get_unit_kerja($kl){
		$data = $this->eselon1->get_all(array("kode_kl"=>$kl));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->nama_e1.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function get_list_eselon1($tahun)	{
		$params = array("tahun_renstra"=>$tahun,"isNotMandatory"=>true);
		echo json_encode($this->eselon1->get_list($params));
	}
		
	function get_list_eselon2($tahun,$kode_e1)	{
		$params = array("tahun_renstra"=>$tahun,"kode_e1"=>$kode_e1,"isNotMandatory"=>true);
		echo json_encode($this->eselon2->get_list($params));
	}
	
	function getindikator_kl($kel_indikator,$tahun_awal,$tahun_akhir,$kode_kl,$ajaxCall=true,$forExcel=false){
		$params['tahun'] = $tahun_awal;
		//$params['tahun_akhir'] = $tahun_akhir;
		$params['kode_ss_kl'] = $kel_indikator;
	//	$params['kode_kl'] = $kode_kl;
		$data= $this->kel_indikator_kl->get_data($params);
		$showTahun = false;//($tahun_akhir-$tahun_awal)>0;
		
		$rs = '';$i=1;
		if ($ajaxCall)
				$head = '<table class="display table table-bordered table-striped" width="100%">';
			else
				$head = '<table  border="1" cellpadding="4" cellspacing="0">';
		
		
		$head .= '<thead><tr  align="center">
					<th class="col-sm-1" style="vertical-align:middle;text-align:center;" width="30">No.</th>
					<th class="col-sm-2" style="vertical-align:middle;text-align:center;" width="80">Kode</th>
					<th style="vertical-align:middle;text-align:center" width="330">Indikator Kinerja Utama (IKU)</th>
					<th class="col-sm-2" style="vertical-align:middle;text-align:center" width="80">Satuan</th>					
				</tr></thead>';	
		$head .= '<tbody>';	
		
		$foot = '</tbody>';		
		$foot .= '</table>';
		
		//$rs .= 	'<tr>';
		$tahun = "";
		if (isset($data)){
			foreach($data as $d): 
				if ($i==1) $rs .=$head;
				$rs .= '<tr class="gradeX">
					<td width="30">'.($i++).'</td>				
					<td width="80">'.$d->kode_iku_kl.'</td>					
					<td width="330">'.$d->indikator_kl.'</td>					
					<td width="80">'.$d->satuan.'</td>					
					
				</tr>';
				endforeach; 
				$rs .= $foot;
		} else {
			$rs .= '<tr class="gradeX">
				<td>&nbsp;</td>'				
					.'<td>&nbsp;</td>				
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
			$rs = '';
		}
		
		if ($forExcel){
			return $data;
		}
		else {
			if ($ajaxCall)	echo $rs;
			else return $rs;
		}
	}
	
	function getindikator_e1($kel_indikator,$tahun_awal,$tahun_akhir,$kode_e1,$kode_e2=null,$ajaxCall=true,$forExcel=false){
		//kode_E2 null = tampilkan Checkbox Eselon 2 nya tidak dicek
		$params['tahun'] = $tahun_awal;
		//$params['tahun_awal'] = $tahun_awal;
		//$params['tahun_akhir'] = $tahun_akhir;
		$params['kode_ss_kl'] = $kel_indikator;
		if (($kode_e1!="-1")&&($kode_e1!="0"))
			$params['kode_e1'] = $kode_e1;
		$data= $this->kel_indikator_e1->get_data($params);
		$showTahun = ($tahun_akhir-$tahun_awal)>0;
		$showUnitKerja = !isset($params['kode_e1']);
		
		$rs = '';$i=1;
		if ($ajaxCall)
				$head = '<table class="display table table-bordered table-striped" width="100%">';
			else
				$head = '<table  border="1" cellpadding="4" cellspacing="0">';
		
		$head .= '<thead><tr  align="center">
					<th class="col-sm-1" style="vertical-align:middle;text-align:center;" width="30">No.</th>
					<th class="col-sm-2" style="vertical-align:middle;text-align:center;" width="80">Kode</th>
					<th style="vertical-align:middle;text-align:center" width="330">Indikator Kinerja Utama (IKU)</th>
					<th class="col-sm-2" style="vertical-align:middle;text-align:center" width="80">Satuan</th>							
				</tr></thead>';	
		$head .= '<tbody>';

		$foot = '</tbody>';		
		$foot .= '</table><br>'.(!$ajaxCall?"<br><br>":"");	
		//$rs .= 	'<tr>';
		$tahun ="";
		$unitkerja = "";
		$kode="";
		if (isset($data)){
			foreach($data as $d): 
				if ($unitkerja!=$d->nama_e1){
					$unitkerja=$d->nama_e1;
					if ($i>1) {
						$rs .=$foot;
						
						if ($kode_e2!=null){
							//var_dump($kode);die;
							$z= $this->getindikator_e2($kel_indikator,$tahun_awal,$tahun_akhir,$kode,$kode_e2,$ajaxCall,true);
							//var_dump($z);die;
							$rs .= $z;
							//var_dump($z);
						}
					}
					$kode = $d->kode_e1;
					$i=1;
					if ($ajaxCall)
						$rs .= "<p class='text-info'><b>Unit Kerja Eselon I : ".$unitkerja.'</b></p>';
					else
						$rs .= "<b>Unit Kerja Eselon I : ".$unitkerja.'</b><br><br>';
				
					$rs .= $head;
				}
				if ($tahun!=$d->tahun){
					$tahun=$d->tahun;
					
				}
				$rs .= '<tr class="gradeX">
						<td width="30">'.($i++).'</td>				
					<td width="80">'.$d->kode_iku_e1.'</td>					
					<td width="330">'.$d->indikator_e1.'</td>					
					<td width="80">'.$d->satuan.'</td>				
					
				</tr>';
				endforeach; 
				$rs .= $foot;
				if ($kode_e2!=null){
					$z= $this->getindikator_e2($kel_indikator,$tahun_awal,$tahun_akhir,$kode,$kode_e2,$ajaxCall,true);
					$rs .= $z;
				}
		} else {
			$rs .= '<tr class="gradeX">
				<td>&nbsp;</td>'
					
					.'<td>&nbsp;</td>				
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
			$rs = '';
		}
		
		if ($forExcel){
			return $data;
		}
		else {
			if ($ajaxCall)	echo $rs;
			else return $rs;
		}
	}
	
	function getindikator_e2($kel_indikator,$tahun_awal,$tahun_akhir,$kode_e1,$kode_e2,$ajaxCall=true,$callFromE1=false,$forExcel=false){
		$params['tahun'] = $tahun_awal;
		$params['kode_ss_kl'] = $kel_indikator;
		if (($kode_e1!="-1")&&($kode_e1!="0"))
			$params['kode_e1'] = $kode_e1;
		if (($kode_e2!="-1")&&($kode_e2!="0"))
			$params['kode_e2'] = $kode_e2;
		$data= $this->kel_indikator_e2->get_data($params);
		$showTahun = ($tahun_akhir-$tahun_awal)>0;
		$showUnitKerja = !isset($params['kode_e2']);
		
		$rs = '';$i=1;
		if ($ajaxCall)
				$head = '<table class="display table table-bordered table-striped" width="100%">';
			else
				$head = '<table  border="1" cellpadding="4" cellspacing="0">';
		
		$head .= '<thead><tr  align="center">
					<th class="col-sm-1" style="vertical-align:middle;text-align:center;" width="30">No.</th>
					<th class="col-sm-2" style="vertical-align:middle;text-align:center;" width="80">Kode</th>
					<th style="vertical-align:middle;text-align:center" width="330">Indikator Kinerja Kegiatan (IKK)</th>
					<th class="col-sm-2" style="vertical-align:middle;text-align:center" width="80">Satuan</th>	
				</tr></thead>';	
		$head	 .= '<tbody>';	
		
		
		 $foot = '</tbody>';		
		 $foot .= '</table><br>'.(!$ajaxCall?"<br><br>":"");
		//$rs .= 	'<tr>';
		$tahun ="";
		$unitkerja = "";
		if (isset($data)){
			foreach($data as $d): 
				if ($unitkerja!=$d->nama_e2){
					$unitkerja=$d->nama_e2;
					if ($i>1) $rs .=$foot;
					$i=1;
					if ($ajaxCall)
						$rs .= "<p class='text-info'><b>Unit Kerja Eselon II : ".$unitkerja.'</b></p>';
					else
						$rs .= "<b>Unit Kerja Eselon II : ".$unitkerja.'</b><br><br>';
				//	$rs .= "<p class='text-info'><b>Tahun : ".$d->tahun.'</b></p>';
					$rs .= $head;
				}
				if ($tahun!=$d->tahun){
					$tahun=$d->tahun;
					
				}
				$rs .= '<tr class="gradeX">
					<td width="30">'.($i++).'</td>				
					<td width="80">'.$d->kode_ikk.'</td>					
					<td width="330">'.$d->indikator_e2.'</td>					
					<td width="80">'.$d->satuan.'</td>				
					
				</tr>';
				endforeach; 
			$rs .= $foot;
		} else {
			$rs .= '<tr class="gradeX">
				<td>&nbsp;</td>'
				.'<td>&nbsp;</td>				
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
			
			$rs ='';
		}
		
		
		//var_dump("<pre>".$rs."</pre>");die;
		if ($forExcel){
			return $data;
		}
		else {
			if ($ajaxCall){
			if ($callFromE1) return $rs;
			else echo $rs;
			}else return $rs;
		}
	}
	
	function getindikator($kel_indikator,$tahun_awal,$tahun_akhir){
		$params['tahun_awal'] = $tahun_awal;
		$params['tahun_akhir'] = $tahun_akhir;
		$params['kode_ss_kl'] = $kel_indikator;
		$showKL = $this->input->post('chkKl');
		$showE1 = $this->input->post('chkE1');
		$showE2 = $this->input->post('chkE2');
	//	$params['kode_kl'] = $kode_kl;
		$data= $this->indikator->get_data($params);
		$showTahun = ($tahun_akhir-$tahun_awal)>0;
		
		$rs = '';$i=1;
		$rs = '<table class="display table table-bordered table-striped" width="100%">';
		
		$rs .= '
		<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center">No.</th>'.					
					($showTahun?'<th style="vertical-align:middle;text-align:center" >Tahun</th>':'').
					'<th style="vertical-align:middle;text-align:center" >Kode IKU KL</th>
					<th style="vertical-align:middle;text-align:center" >Deskripsi</th>
					<th style="vertical-align:middle;text-align:center" >Satuan</th>					
				</tr>';
					$rs .= 	'</tr></thead>';	
		$rs .= '<tbody>';	
		//$rs .= 	'<tr>';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.($i++).'</td>'.
					($showTahun?'<td>'.$d->tahun.'</td>':'')
					
					.'<td>'.$d->kode_iku_kl.'</td>					
					<td>'.$d->indikator_kl.'</td>					
					<td>'.$d->satuan.'</td>					
					
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td>&nbsp;</td>'.
					($showTahun?'<td> </td>':'')
					
					.'<td>&nbsp;</td>				
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
		}
		
		 $rs .= '</tbody>';		
		 $rs .= '</table>';
		echo $rs;
	}
	
					//2010-2014/2013/SSKP.01/0/0/true/true/false
   function print_pdf($renstra,$tahun,$indikator,$e1,$e2,$showKl,$showE1,$showE2)
   {
	    $this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Kelompok Indikator');
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
		 $pdf->Write(0, 'Kelompok  Indikator ', '', 0, 'L', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		$data['renstra']		= $renstra;
	   $data['tahun']		= $tahun;
	   $data['indikator']		= $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$indikator),"anev_kel_indikator");
	   $data['showKl']		= $showKl;
	   $data['showE1']		= $showE1;
	   $data['showE2']		= $showE2;
//	   $data['kementerian'] = $this->mgeneral->getValue("nama_kl",array('kode_kl'=>$kl,'tahun_renstra'=>$tahun),"anev_kl");
	   $data['ikuKl']	= $this->getindikator_kl($indikator,$tahun,$tahun,"",false);
												//$kel_indikator,$tahun_awal,$tahun_akhir,$kode_e1,$kode_e2=null,$ajaxCall
												//var_dump(($showE1=="true")&&($showE2=="true"));die;
	   $data['ikuE1']	= $this->getindikator_e1($indikator,$tahun,$tahun,$e1,(($showE1=="true")&&($showE2=="true")?$e2:null),false);
	   if ($showE2=="true")
			$data['ikuE2']	= $this->getindikator_e2($indikator,$tahun,$tahun,$e1,$e2,false,false);
	   
		$html = $this->load->view('laporan/print/pdf_indikator',$data,true);
	//	$html = $data['ikuE2'];
		//var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('KelompokIndikator.pdf', 'I');
   }
   
    function excel($renstra,$tahun,$indikator,$e1,$e2,$showKl,$showE1,$showE2){
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Kelompok Indikator');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'KELOMPOK INDIKATOR '.strtoupper($this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$indikator),"anev_kel_indikator")));
		$this->excel->getActiveSheet()->setCellValue('A2', 'Periode Renstra ');
		$this->excel->getActiveSheet()->setCellValue('B2', $renstra);
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->mergeCells('A3:D3');
		$params = array("tahun_renstra"=>$renstra);
		$posisiRow = 4;
		$params['tahun'] = $tahun;
		//$params['tahun_akhir'] = $tahun_akhir;
		$params['kode_ss_kl'] = $indikator;
	
		
		
		/////kelompok indikator KL here..
		//jeda 1 row
		if ($showKl=="true"){
			$posisiRow++;
			$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'IKU KEMENTERIAN');
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
			$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':D'.$posisiRow);
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$posisiRow++;
			$columHeader = array("No.","Kode","Indikator Kinerja Utama (IKU)","Satuan");		
			$datakl = $this->getindikator_kl($indikator,$tahun,$tahun,"",false,true);
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
			if (isset($datakl)){
				foreach($datakl as $s){ 
					 
						$data[] = array($no++,$s->kode_iku_kl,$s->indikator_kl,$s->satuan);
					 
				}
				if (count($datakl)>0){
					$this->excel->getActiveSheet()->fromArray($data,NULL,'A'.$posisiRow);	
					$posisiRow += count($data);
				}else $posisiRow++;
			}
		}
		/////END    Kelmopok indikator KL HERE...
		
		
		//IKU Eselon 1
		
		//jeda 1 row
		$posisiRow++;
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'IKU ESELON I '.($showE2=="true"?"dan IKK ESELON II":""));
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':D'.$posisiRow);
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$columHeader = array("No.","Kode","Indikator Kinerja Utama (IKU)","Satuan");		
		$columHeader_e2 = array("No.","Kode","Indikator Kinerja Kegiatan (IKK)","Satuan");		
///		$posisiRow++;
		$datae1=$this->getindikator_e1($indikator,$tahun,$tahun,$e1,(($showE1=="true")&&($showE2=="true")?$e2:null),false,true);
		
		
		$posisiRow++;
		$no=1;$i=1;$j=1;
		$unitkerja = "";
		$kode="";
		if ($showE1=="true"){
			if (isset($datae1)){
				foreach($datae1 as $s){ 
					if ($unitkerja!=$s->nama_e1){
						$unitkerja=$s->nama_e1;
						
						if ($i>1) {
							if ($showE2=="true"){
								 
								$datae2= $this->getindikator_e2($indikator,$tahun,$tahun,$kode,$e2,false,false,true);
								$posisiRow++; 
								$unitkerja_e2 = "";
								$kode_e2="";$no_e2=1;
								if (isset($datae2)){
									foreach($datae2 as $s2){ 
										if ($unitkerja_e2!=$s2->nama_e2){
											$unitkerja_e2=$s2->nama_e2;
											$kode_e2 = $s2->kode_e2;
											if ($i>1) {
												$posisiRow++;
											}
											
											$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':D'.$posisiRow);
											$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Unit Kerja Eselon II : '.$unitkerja_e2);
											$posisiRow++; 
											$this->excel->getActiveSheet()->fromArray($columHeader_e2,NULL,'A'.$posisiRow);
											$this->excel->getActiveSheet()->getStyle('A'.($posisiRow).':D'.$posisiRow)->applyFromArray(
											array(
												'font'    => array('bold'=> true),
												'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
												'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
												'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
											));	
											$posisiRow++;
											$no_e2=1;
										}
											
										$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, $no_e2++);
										$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, $s2->kode_ikk);
										$this->excel->getActiveSheet()->setCellValue('C'.$posisiRow, $s2->indikator_e2);
										$this->excel->getActiveSheet()->setCellValue('D'.$posisiRow, $s2->satuan);
										$posisiRow++;
									}
								}//end isset data e2
							}
						}
						$kode = $s->kode_e1;
						$posisiRow++;
						$i=1;
						$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':D'.$posisiRow);
						$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Unit Kerja Eselon I : '.$unitkerja);
						$posisiRow++;
						$this->excel->getActiveSheet()->fromArray($columHeader,NULL,'A'.$posisiRow);
						$this->excel->getActiveSheet()->getStyle('A'.($posisiRow).':D'.$posisiRow)->applyFromArray(
						array(
							'font'    => array('bold'=> true),
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
							'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
							'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
						));	
						$posisiRow++;
						$no=1;
					}	
					
					$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, $no++);
					$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, $s->kode_iku_e1);
					$this->excel->getActiveSheet()->setCellValue('C'.$posisiRow, $s->indikator_e1);
					$this->excel->getActiveSheet()->setCellValue('D'.$posisiRow, $s->satuan);
					$posisiRow++;
					$i++;	
						//$data[] = array($no++,$s->kode_iku_e1,$s->indikator_e1,$s->satuan);
					 
				}
			}//end iset datae1
		}
		// if (count($datae1)>0){
			//$this->excel->getActiveSheet()->fromArray($data,NULL,'A'.$posisiRow);	
			// $posisiRow += count($datae1);
		// }else
		$posisiRow++;
		if ($showE2=="true"){ ///tampilkan E2 terakhir
			$datae2= $this->getindikator_e2($indikator,$tahun,$tahun,$kode,$e2,false,false,true);
						 
			$unitkerja_e2 = "";
			$kode_e2="";$no_e2=1;
			if (isset($datae2)){
				foreach($datae2 as $s2){ 
					if ($unitkerja_e2!=$s2->nama_e2){
						$unitkerja_e2=$s2->nama_e2;
						$kode_e2 = $s2->kode_e2;
						if ($i>1) {
							$posisiRow++;
						}
						
						$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':D'.$posisiRow);
						$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Unit Kerja Eselon II : '.$unitkerja_e2);
						$posisiRow++; 
						$this->excel->getActiveSheet()->fromArray($columHeader_e2,NULL,'A'.$posisiRow);
						$this->excel->getActiveSheet()->getStyle('A'.($posisiRow).':D'.$posisiRow)->applyFromArray(
						array(
							'font'    => array('bold'=> true),
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
							'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
							'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
						));	
						$posisiRow++;
						$no_e2=1;
					}
						
					$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, $no_e2++);
					$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, $s2->kode_ikk);
					$this->excel->getActiveSheet()->setCellValue('C'.$posisiRow, $s2->indikator_e2);
					$this->excel->getActiveSheet()->setCellValue('D'.$posisiRow, $s2->satuan);
					$posisiRow++;
				}
			}//end isset datae2
		}
		//ENDIKU Eselon 1
			
		$this->excel->setActiveSheetIndex(0);	
		$filename='KelompokIndikator'.$tahun.'.xls'; 
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