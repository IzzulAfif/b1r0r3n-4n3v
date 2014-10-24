<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-10-21 00:00
*/

class Keuangan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('analisis/analisis_model','',TRUE);
		$this->load->model('analisis/keuangan_model','keuangan',TRUE);
		$this->load->model('/admin/tahun_renstra_model','setting_th');
	}
	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "ANALISIS");
		$setting['page']	= array('pg_aktif'	=> "chart");
		$template			= $this->template->load($setting); #load static template file
		
		$data				= "";
		$template['konten']	= $this->load->view('analisis/keuangan',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function kl()
	{
		$data['renstra']	= $this->setting_th->get_list();
		$this->load->view('analisis/kl_keuangan',$data);
	}
	
	function get_body_kl_keu($renstra,$tahun1,$tahun2,$tipe="html")
	{
		$data		= $this->keuangan->get_kl_keu($renstra,$tahun1,$tahun2,null);
		$th_renstra = explode("-",$renstra);
		for($a=$th_renstra[0];$a<=$th_renstra[1];$a++):
			$arrThn[] = array(	"tahun"		=> $a,
								"target"	=> "0",
								"pagu"		=> "0",
								"realisasi"	=> "0"); 
		endfor;
		
		$table  = '<table class="display table table-bordered table-striped" border="1" cellpadding="4" cellspacing="0">';
		$table .= '<thead>
            		<tr>
                		<th width="3%">No</th>
                		<th width="20%">Program</th>
                		<th width="15%">Uraian</th>';
				for($b=$tahun1; $b<=$tahun2; $b++):
					$table .= '<th>'.$b.'</th>';
				endfor;
		$table .= '<th>Total</th></tr></thead>';
		$table .= '<tbody>';
			
			$no=1;
			foreach($data as $d):
					
					$arrThn[0]['target'] = $d->target_thn1;
					$arrThn[1]['target'] = $d->target_thn2;
					$arrThn[2]['target'] = $d->target_thn3;
					$arrThn[3]['target'] = $d->target_thn4;
					$arrThn[4]['target'] = $d->target_thn5;
					
					$detail_keu = $this->keuangan->get_detail_keu($tahun1,$tahun2,$d->kode_program);
					foreach($detail_keu as $dk):
						$dpagu[$dk->tahun]		= $dk->pagu;
						$drealisasi[$dk->tahun] = $dk->realisasi;
					endforeach;
					
					for($c=0;$c<count($arrThn);$c++):
						if(isset($dpagu[$arrThn[$c]['tahun']])): $nilaiPagu = $dpagu[$arrThn[$c]['tahun']]; else: $nilaiPagu = 0; endif;
						if(isset($drealisasi[$arrThn[$c]['tahun']])): $nilaiReal = $drealisasi[$arrThn[$c]['tahun']]; else: $nilaiReal = 0; endif;
						$tblData[$arrThn[$c]['tahun']] = array( "target"	=> $arrThn[$c]['target'],
													  			"pagu"		=> $nilaiPagu,
													  			"realisasi"	=> $nilaiReal); 
					endfor;
					#print_r($tblData); echo "<br><br>";
					
					$table .= '<tr><td rowspan="3" width="3%" align="center">'.$no.'</td><td rowspan="3" width="20%">'.$d->nama_program.'</td>';
					$table .= '<td width="15%">Target Renstra</td>';
						$tTarget = 0;
						for($b=$tahun1; $b<=$tahun2; $b++):
							$table .= '<td>'.number_format($tblData[$b]['target'],0,',','.').'</td>';
							$tTarget = $tTarget+$tblData[$b]['target'];
						endfor;
						$table .= '<td>'.number_format($tTarget,0,',','.').'</td>';
					$table .= '</tr>';
					
					$table .= '<tr><td width="15%">Pagu</td>';
					$totalpagu=0;
					for($b=$tahun1; $b<=$tahun2; $b++):
						$table .='<td>'.number_format($tblData[$b]['pagu'],0,',','.')."</td>";
						$totalpagu = $totalpagu+$tblData[$b]['pagu'];
					endfor;
					$table .='<td>'.number_format($totalpagu,0,',','.').'</td></tr>';
					
					$table .= '<tr><td width="15%">Realisasi</td>';
					$totalrealisasi=0;
					for($b=$tahun1; $b<=$tahun2; $b++):
						$table .='<td>'.number_format($tblData[$b]['realisasi'],0,',','.')."</td>";
						$totalrealisasi = $totalrealisasi+$tblData[$b]['realisasi'];
					endfor;
					$table .='<td>'.number_format($totalrealisasi,0,',','.').'</td></tr>';
					
				$no++;					
			endforeach;
		
		$table .= '</tbody>';
		$table .= "</table>";
		if($tipe=="get"): return $table; else: echo $table; endif;
	}
	
	function print_keuangankl_pdf($renstra,$tahun1,$tahun2)
	{
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Analisis dan Evaluasi Keuangan Kementerian Perhubungan');
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
		$pdf->AddPage();
		//var_dump($e1);
		 $pdf->Write(0, 'Analisis dan Evaluasi Keuangan Kementerian Perhubungan', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);
	
		$html = $this->get_body_kl_keu($renstra,$tahun1,$tahun2,"get");
		$pdf->writeHTML($html, true, false, false, false, '');
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('keuanganKementerian.pdf', 'I');
	}
	
	function es1()
	{
		$data['renstra']	= $this->setting_th->get_list();
		$this->load->view('analisis/es1_keuangan',$data);
	}
	
	function get_body_es1_keu($renstra,$tahun1,$tahun2,$kode_e1,$tipe="html")
	{
		$data		= $this->keuangan->get_kl_keu($renstra,$tahun1,$tahun2,$kode_e1);
		$th_renstra = explode("-",$renstra);
		for($a=$th_renstra[0];$a<=$th_renstra[1];$a++):
			$arrThn[] = array(	"tahun"		=> $a,
								"target"	=> "0",
								"pagu"		=> "0",
								"realisasi"	=> "0"); 
		endfor;
		
		$table  = '<table class="display table table-bordered table-striped" border="1" cellpadding="4" cellspacing="0">';
		$table .= '<thead>
            		<tr>
                		<th width="20%">Program</th>
                		<th width="15%">Uraian</th>';
				for($b=$tahun1; $b<=$tahun2; $b++):
					$table .= '<th>'.$b.'</th>';
				endfor;
		$table .= '<th>Total</th></tr></thead>';
		$table .= '<tbody>';
			
			$no=1;
			foreach($data as $d):
					
					$arrThn[0]['target'] = $d->target_thn1;
					$arrThn[1]['target'] = $d->target_thn2;
					$arrThn[2]['target'] = $d->target_thn3;
					$arrThn[3]['target'] = $d->target_thn4;
					$arrThn[4]['target'] = $d->target_thn5;
					
					$detail_keu = $this->keuangan->get_detail_keu($tahun1,$tahun2,$d->kode_program);
					foreach($detail_keu as $dk):
						$dpagu[$dk->tahun]		= $dk->pagu;
						$drealisasi[$dk->tahun] = $dk->realisasi;
					endforeach;
					
					for($c=0;$c<count($arrThn);$c++):
						if(isset($dpagu[$arrThn[$c]['tahun']])): $nilaiPagu = $dpagu[$arrThn[$c]['tahun']]; else: $nilaiPagu = 0; endif;
						if(isset($drealisasi[$arrThn[$c]['tahun']])): $nilaiReal = $drealisasi[$arrThn[$c]['tahun']]; else: $nilaiReal = 0; endif;
						$tblData[$arrThn[$c]['tahun']] = array( "target"	=> $arrThn[$c]['target'],
													  			"pagu"		=> $nilaiPagu,
													  			"realisasi"	=> $nilaiReal); 
					endfor;
					$grafikData[] = $tblData;
					
					$table .= '<tr><td rowspan="3" width="20%">'.$d->nama_program.'</td>';
					$table .= '<td width="15%">Target Renstra</td>';
						$tTarget = 0;
						for($b=$tahun1; $b<=$tahun2; $b++):
							$table .= '<td>'.number_format($tblData[$b]['target'],0,',','.').'</td>';
							$tTarget = $tTarget+$tblData[$b]['target'];
						endfor;
						$table .= '<td>'.number_format($tTarget,0,',','.').'</td>';
					$table .= '</tr>';
					
					$table .= '<tr><td width="15%">Pagu</td>';
					$totalpagu=0;
					for($b=$tahun1; $b<=$tahun2; $b++):
						$table .='<td>'.number_format($tblData[$b]['pagu'],0,',','.')."</td>";
						$totalpagu = $totalpagu+$tblData[$b]['pagu'];
					endfor;
					$table .='<td>'.number_format($totalpagu,0,',','.').'</td></tr>';
					
					$table .= '<tr><td width="15%">Realisasi</td>';
					$totalrealisasi=0;
					for($b=$tahun1; $b<=$tahun2; $b++):
						$table .='<td>'.number_format($tblData[$b]['realisasi'],0,',','.')."</td>";
						$totalrealisasi = $totalrealisasi+$tblData[$b]['realisasi'];
					endfor;
					$table .='<td>'.number_format($totalrealisasi,0,',','.').'</td></tr>';
					
				$no++;					
			endforeach;
		
		$table .= '</tbody>';
		$table .= "</table>";
		
		$labelThn = ""; $labelTarget = ""; $labelPagu = ""; $labelRealisasi = "";
		foreach($grafikData as $gd):
			for($b=$tahun1; $b<=$tahun2; $b++):
				$labelThn .= $b.",";
				$labelTarget .= $gd[$b]['target'].",";
				$labelPagu .= $gd[$b]['pagu'].",";
				$labelRealisasi .= $gd[$b]['realisasi'].",";
			endfor;
		endforeach;
		
		$grafik = "<script>
					var chart;
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'grafik_es1',
							type : 'column',
							marginTop: 80,
							marginRight: 20
						},
						colors: ['#DB843D', '#3D96AE', '#89A54E', '#00FF40', '#E10000', '#CCCCCC'],
						exporting: {
							buttons: { 
								exportButton: {
									enabled:false
								},
								printButton: {
									enabled:true
								}
						
							}
						},
						title: {
							text: 'ANALISIS DAN EVALUASI KEUANGAN ESELON I',
							style : { 'font-size' : '14px' }
						},
						xAxis: {
							categories: [".rtrim($labelThn,",")."],
						},
						yAxis: {
							title: {
								text: null
							}
						},
						series: [{
									name: 'Target Renstra',
									type: 'column',
									data: [".rtrim($labelTarget,",")."],
								},{
									name: 'Pagu',
									type: 'column',
									data: [".rtrim($labelPagu,",")."],
								},{
									name: 'Realisasi',
									type: 'column',
									data: [".rtrim($labelRealisasi,",")."],
								}]
					});
				</script>";
				
		if($tipe=="get"): 
			return $table; 
		else:
			echo $table;
			echo $grafik;
		endif;
	}
	
	function print_keuanganes1_pdf($renstra,$tahun1,$tahun2,$kode_e1)
	{
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Analisis dan Evaluasi Keuangan Eselon I');
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
		$pdf->AddPage();
		//var_dump($e1);
		 $pdf->Write(0, 'Analisis dan Evaluasi Keuangan Eselon I', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);
	
		$html = $this->get_body_es1_keu($renstra,$tahun1,$tahun2,$kode_e1,"get");
		$pdf->writeHTML($html, true, false, false, false, '');
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('keuanganEselon1.pdf', 'I');
	}
	
	function es2()
	{
		$data['renstra']	= $this->setting_th->get_list();
		$this->load->view('analisis/es2_keuangan',$data);
	}
	
	function get_body_es2_keu($renstra,$tahun1,$tahun2,$kode_e1,$kode_e2,$tipe="html")
	{
		$data		= $this->keuangan->get_es2_keu($renstra,$tahun1,$tahun2,$kode_e2);
		$th_renstra = explode("-",$renstra);
		for($a=$th_renstra[0];$a<=$th_renstra[1];$a++):
			$arrThn[] = array(	"tahun"		=> $a,
								"target"	=> "0",
								"pagu"		=> "0",
								"realisasi"	=> "0"); 
		endfor;
		
		$table  = '<table class="display table table-bordered table-striped" border="1" cellpadding="4" cellspacing="0">';
		$table .= '<thead>
            		<tr>
                		<th width="20%">Kegiatan</th>
                		<th width="15%">Uraian</th>';
				for($b=$tahun1; $b<=$tahun2; $b++):
					$table .= '<th>'.$b.'</th>';
				endfor;
		$table .= '<th>Total</th></tr></thead>';
		$table .= '<tbody>';
			
			$no=1;
			foreach($data as $d):
					
					$arrThn[0]['target'] = $d->target_thn1;
					$arrThn[1]['target'] = $d->target_thn2;
					$arrThn[2]['target'] = $d->target_thn3;
					$arrThn[3]['target'] = $d->target_thn4;
					$arrThn[4]['target'] = $d->target_thn5;
					
					$detail_keu = $this->keuangan->get_detail_keu_es2($tahun1,$tahun2,$d->kode_kegiatan);
					foreach($detail_keu as $dk):
						$dpagu[$dk->tahun]		= $dk->pagu;
						$drealisasi[$dk->tahun] = $dk->realisasi;
					endforeach;
					
					for($c=0;$c<count($arrThn);$c++):
						if(isset($dpagu[$arrThn[$c]['tahun']])): $nilaiPagu = $dpagu[$arrThn[$c]['tahun']]; else: $nilaiPagu = 0; endif;
						if(isset($drealisasi[$arrThn[$c]['tahun']])): $nilaiReal = $drealisasi[$arrThn[$c]['tahun']]; else: $nilaiReal = 0; endif;
						$tblData[$arrThn[$c]['tahun']] = array( "target"	=> $arrThn[$c]['target'],
													  			"pagu"		=> $nilaiPagu,
													  			"realisasi"	=> $nilaiReal); 
					endfor;
					$grafikData[] = $tblData;
					
					$table .= '<tr><td rowspan="3" width="20%">'.$d->nama_kegiatan.'</td>';
					$table .= '<td width="15%">Target Renstra</td>';
						$tTarget = 0;
						for($b=$tahun1; $b<=$tahun2; $b++):
							$table .= '<td>'.number_format($tblData[$b]['target'],0,',','.').'</td>';
							$tTarget = $tTarget+$tblData[$b]['target'];
						endfor;
						$table .= '<td>'.number_format($tTarget,0,',','.').'</td>';
					$table .= '</tr>';
					
					$table .= '<tr><td width="15%">Pagu</td>';
					$totalpagu=0;
					for($b=$tahun1; $b<=$tahun2; $b++):
						$table .='<td>'.number_format($tblData[$b]['pagu'],0,',','.')."</td>";
						$totalpagu = $totalpagu+$tblData[$b]['pagu'];
					endfor;
					$table .='<td>'.number_format($totalpagu,0,',','.').'</td></tr>';
					
					$table .= '<tr><td width="15%">Realisasi</td>';
					$totalrealisasi=0;
					for($b=$tahun1; $b<=$tahun2; $b++):
						$table .='<td>'.number_format($tblData[$b]['realisasi'],0,',','.')."</td>";
						$totalrealisasi = $totalrealisasi+$tblData[$b]['realisasi'];
					endfor;
					$table .='<td>'.number_format($totalrealisasi,0,',','.').'</td></tr>';
					
				$no++;					
			endforeach;
		
		$table .= '</tbody>';
		$table .= "</table>";
		
		$labelThn = ""; $labelTarget = ""; $labelPagu = ""; $labelRealisasi = "";
		foreach($grafikData as $gd):
			for($b=$tahun1; $b<=$tahun2; $b++):
				$labelThn .= $b.",";
				$labelTarget .= $gd[$b]['target'].",";
				$labelPagu .= $gd[$b]['pagu'].",";
				$labelRealisasi .= $gd[$b]['realisasi'].",";
			endfor;
		endforeach;
		
		$grafik = "<script>
					var chart;
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'grafik_es2',
							type : 'column',
							marginTop: 80,
							marginRight: 20
						},
						colors: ['#DB843D', '#3D96AE', '#89A54E', '#00FF40', '#E10000', '#CCCCCC'],
						exporting: {
							buttons: { 
								exportButton: {
									enabled:false
								},
								printButton: {
									enabled:true
								}
						
							}
						},
						title: {
							text: 'ANALISIS DAN EVALUASI KEUANGAN ESELON II',
							style : { 'font-size' : '14px' }
						},
						xAxis: {
							categories: [".rtrim($labelThn,",")."],
						},
						yAxis: {
							title: {
								text: null
							}
						},
						series: [{
									name: 'Target Renstra',
									type: 'column',
									data: [".rtrim($labelTarget,",")."],
								},{
									name: 'Pagu',
									type: 'column',
									data: [".rtrim($labelPagu,",")."],
								},{
									name: 'Realisasi',
									type: 'column',
									data: [".rtrim($labelRealisasi,",")."],
								}]
					});
				</script>";
				
		if($tipe=="get"): return $table; else:  echo $table; echo $grafik; endif;
	}
	
	function print_keuanganes2_pdf($renstra,$tahun1,$tahun2,$kode_e1,$kode_e2)
	{
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Analisis dan Evaluasi Keuangan Eselon II');
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
		$pdf->AddPage();
		//var_dump($e1);
		 $pdf->Write(0, 'Analisis dan Evaluasi Keuangan Eselon II', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);
	
		$html = $this->get_body_es2_keu($renstra,$tahun1,$tahun2,$kode_e1,$kode_e2,"get");
		$pdf->writeHTML($html, true, false, false, false, '');
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('keuanganEselon2.pdf', 'I');
	}
}