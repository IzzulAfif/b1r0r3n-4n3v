<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Faizal
 @date       : 2014-08-15 00:00
 @revision	 :
*/

class sasaran_strategis extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('evaluasi/sasaran_strategis_m','',TRUE);
		$this->load->model('analisis/analisis_model','',TRUE);
		$this->load->model('/admin/tahun_renstra_model','setting_th');
	}

	function index()
	{
		$data['renstra']	= $this->setting_th->get_list();
		$this->load->view('evaluasi/sasaran_strategis_v',$data);
	}
	
	function get_sasaran($tahun_renstra)
	{
		$params['isNotMandatory'] = "yes";
		echo json_encode($this->sasaran_strategis_m->get_sasaran_list($tahun_renstra,$params));
	}
	
	
	function print_tabel_capaian_kinerja($tahun_awal, $tahun_akhir, $kode_sasaran_kl)
	{
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', FALSE, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Capaian Kinerja');
		$pdf->SetHeaderMargin(15);
		$pdf->SetTopMargin(15);
		$pdf->SetLeftMargin(10);
		$pdf->SetRightMargin(10);
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
		$pdf->SetFont('helvetica', 'B', 14);

		// add a page
		$pdf->AddPage('L');
		//var_dump($e1);
		 $pdf->Write(0, 'Analisis dan Evaluasi Capaian Sasaran Strategis ', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 8);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);
		
		$tabel = '<page format="A4"><table border="1" cellpadding="4" cellspacing="0">';
		$tabel .= $this->get_tabel_capaian_kinerja($tahun_awal, $tahun_akhir, $kode_sasaran_kl,"get");
		$tabel .= '</table></page>';
		#echo htmlentities($tabel);
		#echo $tabel;
		//$html = $data['ikuE2'];
		//var_dump($html);
		$pdf->writeHTML($tabel, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('Capaian sasaran strategis.pdf', 'I');
		
	}
	
	function get_tabel_capaian_kinerja($tahun_awal, $tahun_akhir, $kode_sasaran_kl, $tipe="html") 
	{
		
		$data = $this->sasaran_strategis_m->get_capaian_kinerja($kode_sasaran_kl, $tahun_awal, $tahun_akhir);
		
		$totalThn = 0;
		for($a=$tahun_awal; $a<=$tahun_akhir;$a++):
			$rata2PerTahun[$a] = array('nilai'	=> 0,
									   'pembagi'=> 0);
			$dataTemplate[$a] = array('target'		=> "<center>-</center>",
								   	  'realisasi'	=> "<center>-</center>",
								   	  'persen'		=> "<center>-</center>");
			$totalThn++;
		endfor;
		
		$widhtRowSS = '';
		$widthRowIKU= '';
		$widthRowDt	= "";
		$widthRowDt2= "";
		$widthRowRt	= "";
		
		switch($totalThn):
			case "1";
				$widhtRowSS = 'style="width:145px;"';
				$widthRowIKU= 'style="width:230px;"';
				$widthRowDt	= "width:210px;";
				$widthRowDt2= "width:70px;";
				$widthRowRt	= "width:80px;";
			break;
			case "2";
				$widhtRowSS = 'style="width:115px;"';
				$widthRowIKU= 'style="width:160px;"';
				$widthRowDt	= "width:180px;";
				$widthRowDt2= "width:60px;";
				$widthRowRt	= "width:70px;";
			break;
			case "3";
				$widhtRowSS = 'style="width:90px;"';
				$widthRowIKU= 'style="width:120px;"';
				$widthRowDt	= "width:150px;";
				$widthRowDt2= "width:50px;";
				$widthRowRt	= "width:60px;";
			break;
			case "4";
				$widhtRowSS = 'style="width:75px;"';
				$widthRowIKU= 'style="width:100px;"';
				$widthRowDt	= "width:129px;";
				$widthRowDt2= "width:43px;";
				$widthRowRt	= "width:53px;";
			break;
			case "5";
				$widhtRowSS = 'style="width:45px;"';
				$widthRowIKU= 'style="width:60px;"';
				$widthRowDt	= "width:123px;";
				$widthRowDt2= "width:41px;";
				$widthRowRt	= "width:41px;";
			break;
		endswitch;
		
		$dataAda = (count($data)>0);
		$dataSStemplate = $dataTemplate;
		#echo "<pre>";
		if ($dataAda){
			
			$noCapaian		= 0;
			$kode_iku_kl	= "";
			
			foreach($data as $d):
				#print_r($d);									
				if($kode_iku_kl != $d->kode_iku_kl && $kode_iku_kl!=""):
								
					$capaian[$noCapaian][$kode_kl] =  array('nama_e1'	=> "-",
															'kodeSS' 	=> $kodeSS,
															'iku'		=> $indikator,
															'satuan'	=> $satuan,
															'data'		=> $dataSStemplate);
															
					$data2=$this->sasaran_strategis_m->get_detail_capaian_kinerja($iku, $tahun_awal, $tahun_akhir, $kode_sasaran_kl);
					$kode_e1 = "";
					if(count($data2)!=0):
					foreach($data2 as $d2):
						
						$indikator  = $d2->indikator;
						$satuan		= $d2->satuan;
						$nama_e1	= $d2->singkatan;
						
						if($kode_e1!=$d2->kode_e1):
							$ikuDataTemplate = $dataTemplate;
							
							$ikuDataTemplate[$d2->tahun]	= array('target'		=> $d2->target,
																	'realisasi'		=> $d2->realisasi,
																	'persen'		=> $d2->persen);
							
						else:
							
							$ikuDataTemplate[$d2->tahun]	= array('target'		=> $d2->target,
																	'realisasi'		=> $d2->realisasi,
																	'persen'		=> $d2->persen);
											
						endif;
						
						$capaian[$noCapaian][$d2->kode_iku_e1] =  array('nama_e1'	=> $nama_e1,
																 'iku'		=> $indikator,
																'satuan'	=> $satuan,
																'data'		=> $ikuDataTemplate);
						
						$kode_e1 = $d2->kode_e1;
						
					endforeach;
					endif;
					$noCapaian++;
				
				endif;
				
				$kode_kl	= $d->kode_kl;
				$iku		= $d->kode_iku_kl;
				$kodeSS		= $d->deskripsi;
				$satuan		= $d->satuan;
				$indikator	= $d->indikator;
				
				$dataSStemplate[$d->tahun]	= array('target'		=> $d->target,
													'realisasi'		=> $d->realisasi,
													'persen'		=> $d->persen);
				
				$kode_iku_kl = $d->kode_iku_kl;
			endforeach;
		
		
			if($kode_sasaran_kl!="" || $kode_sasaran_kl!=0):
				
				$capaian[$noCapaian][$kode_kl] =  array('nama_e1'	=> "-",
																'kodeSS' 	=> $kodeSS,
																'iku'		=> $indikator,
																'satuan'	=> $satuan,
																'data'		=> $dataSStemplate);
																
						$data2=$this->sasaran_strategis_m->get_detail_capaian_kinerja($iku, $tahun_awal, $tahun_akhir, $kode_sasaran_kl);
						$kode_e1 = "";
						
						if(count($data2)!=0):
						foreach($data2 as $d2):
							
							$indikator  = $d2->indikator;
							$satuan		= $d2->satuan;
							$nama_e1	= $d2->singkatan;
							
							if($kode_e1!=$d2->kode_e1):
								$ikuDataTemplate = $dataTemplate;
								
								$ikuDataTemplate[$d2->tahun]	= array('target'		=> $d2->target,
																		'realisasi'		=> $d2->realisasi,
																		'persen'		=> $d2->persen);
								
							else:
								
								$ikuDataTemplate[$d2->tahun]	= array('target'		=> $d2->target,
																		'realisasi'		=> $d2->realisasi,
																		'persen'		=> $d2->persen);
												
							endif;
							
							$capaian[$noCapaian][$d2->kode_iku_e1] =  array('nama_e1'	=> $nama_e1,
																	 'iku'		=> $indikator,
																	'satuan'	=> $satuan,
																	'data'		=> $ikuDataTemplate);
							
							$kode_e1 = $d2->kode_e1;
							
						endforeach;
						endif;
			endif;
		}
		#$table = '<table border="1" cellpadding="0" cellspacing="0">';
		$table = '';
		
		$thead = '<thead>
					<tr>
						<th rowspan="2" '.$widhtRowSS.'>Sasaran Strategis</th>
						<th rowspan="2" '.$widthRowIKU.'>Indikator Kerja Utama (IKU)</th>
						<th rowspan="2">Satuan</th>';
		$thead2    = "";
		for($a=$tahun_awal; $a<=$tahun_akhir;$a++):
			$thead .= '<th colspan="3" style="text-align:center;'.$widthRowDt.'"><center>'.$a.'</center></th>';
			$thead2 .= '<th style="text-align:center;'.$widthRowDt2.'">Target</th><th style="text-align:center;'.$widthRowDt2.'">Realisasi</th><th style="text-align:center;'.$widthRowDt2.'">Persen</th>';
		endfor;
				$thead.= '<th rowspan="2" style="'.$widthRowRt.'">Rata-rata %</th>
					</tr>
					<tr>'.$thead2.'</tr></thead>';
		$table .= $thead;
		
		$table .= '<tbody>';
		
		if ($dataAda){
			
			for($dcp=0;$dcp<count($capaian);$dcp++):
				$totUnitKerja	= 0;
				$curEselon1		= "";
				$dtcapaian 		= $capaian[$dcp];
				
				$esArray = array();
				foreach($dtcapaian as $cp):
					if($cp['nama_e1']!="-"):
						if($curEselon1 != $cp['nama_e1']):
							$totUnitKerja++;
							$esArray[$dcp][str_replace(" ","",$cp['nama_e1'])] = 1;
						else:
							$esArray[$dcp][str_replace(" ","",$cp['nama_e1'])]++;
						endif;
						$curEselon1 = $cp['nama_e1'];
					endif;
					if(isset($cp['kodeSS'])): $namaSS = $cp['kodeSS']; endif;
				endforeach;
				
				if($tipe=="html"): $jRow = 1+$totUnitKerja; else: $jRow = count($dtcapaian)+$totUnitKerja; endif;
				$table .='<tr><td rowspan="'.$jRow.'" '.$widhtRowSS.' id="target_rowspan'.$dcp.'">'.$namaSS.'</td>';
				
				$curEselon1 = "";
				foreach($dtcapaian as $cp):
				
					if($cp['nama_e1']!="-"):
							
						if($curEselon1 != $cp['nama_e1']):
						
							if($tipe=="html"):
								$table.='<tr><td colspan="'.(($totalThn*3)+3).'"><a href="#" class="toggler" data-row="'.$dcp.'" data-cat="'.str_replace(" ","",$cp['nama_e1']).$dcp.'" data-rowspan="'.$esArray[$dcp][str_replace(" ","",$cp['nama_e1'])].'"><b>'.$cp['nama_e1'].'</b></a></td></tr><tr class="detail'.str_replace(" ","",$cp['nama_e1']).$dcp.'" style="display:none">';
							else:
								$table.='<tr><td colspan="'.(($totalThn*3)+3).'"><b>'.$cp['nama_e1'].'</b></td></tr><tr>';
							endif;
						else:
							if($tipe=="html"):
								$table.='<tr class="detail'.str_replace(" ","",$cp['nama_e1']).$dcp.'" style="display:none">';
							else:
								$table.='<tr>';
							endif;
						endif;
						$curEselon1 = $cp['nama_e1'];
					
					endif;
					
					$table.='<td '.$widthRowIKU.'>'.$cp['iku'].'</td>';
					$table.='<td>'.$cp['satuan'].'</td>';
					
					$rata2Row 		= 0;
					$pembagiRata2Row= 0;
						
					foreach($cp['data'] as $key => $dt):
						
						$table.='<td style="'.$widthRowDt2.'">'.$this->template->cek_tipe_numerik($dt['target']).'</td>';
						$table.='<td style="'.$widthRowDt2.'">'.$this->template->cek_tipe_numerik($dt['realisasi']).'</td>';
						$table.='<td style="'.$widthRowDt2.'">'.$this->template->cek_tipe_numerik($dt['persen']).'</td>';
						
						if(is_numeric($dt['persen'])):
							$rata2Row		 	= $rata2Row+$dt['persen'];
							$pembagiRata2Row	= $pembagiRata2Row+1;
							
							$rata2PerTahun[$key]['nilai'] = $rata2PerTahun[$key]['nilai']+$dt['persen'];
							$rata2PerTahun[$key]['pembagi'] = $rata2PerTahun[$key]['pembagi']+1;
							
						endif;
						
					endforeach;
					
					$nilaiRata2Row = $rata2Row/$pembagiRata2Row;
					$table.='<td style="'.$widthRowRt.'">'.$this->template->cek_tipe_numerik($nilaiRata2Row).'</td></tr>';
						
				endforeach;
					
			endfor;
		
			$table .='<tr><td colspan="3"><b>Rata-rata Capaian Kinerja / Tahun</b></td>';
					
				$rata2total = 0;
				$rata2totalPembagi=0;
				foreach($rata2PerTahun as $key => $rt2):
					$table .='<td colspan="2"><b>'.$key.'</b></td>';
					if($rt2['pembagi']!=0):
						$nilai = $rt2['nilai']/$rt2['pembagi'];
						$table .='<td><b>'.$this->template->cek_tipe_numerik($nilai).'</b></td>';
						
						$rata2total 		= $rata2total+$nilai;
						$rata2totalPembagi 	= $rata2totalPembagi+1;
					else:
						$table .='<td><b>0</b></td>';
					endif;
				endforeach;
				
				$nilaiRata2Total = $rata2total/$rata2totalPembagi;
				$table .='<td><b>'.$this->template->cek_tipe_numerik($nilaiRata2Total).'</b></td></tr>';
				
		}else {
				$table .='<td colspan="'.(4+ (3*($tahun_akhir-$tahun_awal+1))).'">Data tidak ada</td>';
				
		}
		
		$table.= '</tbody>';
		#$table.= '</table>';
			
		if($tipe=="get"):
			return $table;
		else:
			echo $table;
		endif;
	}
	
	function get_tabel_capaian_kinerja2($tahun_awal, $tahun_akhir, $kode_sasaran_kl) 
	{
		
		$thead = '<thead><th rowspan=2>Sasaran Strategis</th><th rowspan=2>Indikator Kerja Utama (IKU)</th><th rowspan=2>Satuan</th>';
		$tbody = '<tbody>';
		$j = 0; $thn = 0; $firstrow = 1; $countrow = 0; $rowspan = ""; $temprow = '';
		$sum_program = 0; $rowsection = '';
		$data = $this->sasaran_strategis_m->get_capaian_kinerja($kode_sasaran_kl, $tahun_awal, $tahun_akhir);
		
		if(count($data)!=0):
		
			$ldata = sizeof($data);
			$kd_iku_kl = '';
			if ($ldata!=0) {
				foreach ($data as $dt) {
					if ($dt->kode_iku_kl!=$kd_iku_kl)
						$rowspan[$dt->kode_ss_kl] = (!isset($rowspan[$dt->kode_ss_kl]))?1:$rowspan[$dt->kode_ss_kl]+1;
					$kd_iku_kl = $dt->kode_iku_kl;
				}
				//die();
				$sum_tahun = array();
				foreach ($data as $dt) {
					$temprow .= "<td>".(is_numeric($dt->target)?$dt->target:$dt->target)."</td><td>"
						.(is_numeric($dt->realisasi)?$dt->realisasi:$dt->realisasi)."</td><td>"
						.number_format($dt->persen,2,',','.')."</td>"; 
					$sum_program += $dt->persen; $thn++;
					$sum_tahun[$dt->tahun][] = $dt->persen;			
					//if ($j+1<$ldata) {
	
						if (($j+1==$ldata)||$dt->kode_iku_kl!=$data[$j+1]->kode_iku_kl) {
							$temprow = '<td>'.$dt->indikator.'</td><td>'.$dt->satuan.'</td>'.$temprow;
							$temprow .= '<td>'.number_format(($sum_program/$thn),2,',','.').'</td></tr>';
							$thn = 0; $sum_program = 0;
							$detailrow = $this->get_row_detail_capaian_kinerja($tahun_awal, $tahun_akhir, $dt->kode_iku_kl, $dt->kode_ss_kl);
							$rowspan[$dt->kode_ss_kl]+=$detailrow[0];
							if ($firstrow==1) $temprow = $dt->deskripsi.'</td>'.$temprow;
								else $temprow ='<tr>'.$temprow;
							$rowsection .= $temprow.$detailrow[1];
							$temprow = '';
							$firstrow++;
							$countrow++;
						}
					//}
					if (($j+1==$ldata) || ($dt->kode_ss_kl!= $data[$j+1]->kode_ss_kl)) { 
						$firstrow = 1;
						$rowsection = '<tr><td rowspan='.$rowspan[$dt->kode_ss_kl].' id='.str_replace(".", "",$dt->kode_ss_kl).'>'.$rowsection;
						$tbody .= $rowsection;
						$rowsection = '';
	
					}
					//}
					$j++;
				}
			}
			$tbody .= '<tr><td colspan=3>Rata-rata Capaian Kinerja / Tahun</td>';
			$temp_thead = '<tr>';
			$total = 0;
			
			foreach ($sum_tahun as $k => $val):
				$total=0;
				foreach($val as $v):
					$total = $total+$v;
				endforeach;
				$datasum[$k] = $total;
			endforeach;
			
			#print_r($datasum);
			#echo $countrow;
			$totalRata2 = 0;
			foreach ($datasum as $k => $val) {
				
				$thead .= "<th colspan=3>".$k."</th>";
				$temp_thead .= '<th>Target</th><th>Realisasi</th><th>Persen</th>';
				$tbody .= '<td></td><td></td><td>'.number_format(($val/$countrow),2,',','.').'</td>'; 
				$totalRata2 = $totalRata2+($val/$countrow);
			}
			$thead .= "<th rowspan=2>Rata-rata<br>%</th></tr>".$temp_thead.'</tr></thead>';
			$tbody .= '<td>'.number_format(($totalRata2/count($datasum)),2,',','.').'</td></tr></tbody>';
			echo $thead.$tbody;
		endif;
	}

	private function get_row_detail_capaian_kinerja($tahun_awal, $tahun_akhir, $kode_iku_kl, $kode_ss_kl){
		$j = 0; $thn = 0; $firstrow = 1; $countrow = 0; $rowspan = array(); $colspan = array(); $temprow = ''; $tablerow = '';
		$data = $this->sasaran_strategis_m->get_detail_capaian_kinerja($kode_iku_kl, $tahun_awal, $tahun_akhir, $kode_ss_kl);
		$ldata = sizeof($data);
		$temptahun = ''; $kd_iku_e1='';
		foreach ($data as $dt) {
			if ($dt->kode_iku_e1!=$kd_iku_e1 || $dt->tahun!=$temptahun)
				$colspan[$dt->kode_iku_e1]=(!isset($colspan[$dt->kode_iku_e1]))?3:$colspan[$dt->kode_iku_e1]+3;
			$temptahun = $dt->tahun;
			if ($dt->kode_iku_e1!=$kd_iku_e1)
				$rowspan[$dt->kode_sp_e1]=(!isset($rowspan[$dt->kode_sp_e1]))?1:$rowspan[$dt->kode_sp_e1]+1;
			$kd_iku_e1 = $dt->kode_iku_e1;
		}
		$sum_program = 0;
		foreach ($data as $dt) {
			$temprow .= "<td>".(is_numeric($dt->target)?$dt->target:$dt->target)."</td><td>"
				.(is_numeric($dt->realisasi)?$dt->realisasi:$dt->realisasi)."</td><td>"
				.number_format($dt->persen,2,',','.')."</td>"; 
			$sum_program += $dt->persen; $thn++;
			//if ($j+1<$ldata) {
				if (($j+1==$ldata) || $dt->kode_iku_e1!=$data[$j+1]->kode_iku_e1) {
					$temprow = '<td>'.$dt->indikator.'</td><td>'.$dt->satuan.'</td>'.$temprow;
					$temprow .= '<td>'.number_format(($sum_program/$thn),2,',','.').'</td></tr>';
					$thn = 0; $sum_program = 0;
					if ($firstrow==1) {
						$ket = '';
						switch ($dt->kode_e1) {
						    case "022.01": $ket = "Sekretaris Jendral"; 
						    	break;
						    case "022.02": $ket = "Inspektorat Jenderal"; 
						    	break;
						    case "022.03": $ket = "Transportasi Darat"; 
						    	break;
						    case "022.04": $ket = "Transportasi Laut"; 
						    	break;
						    case "022.05": $ket = "Transportasi Udara"; 
						    	break;
						    case "022.08": $ket = "Transportasi KA"; 
						    	break;
						    case "022.11": $ket = "Penelitian dan Pengembangan"; 
						    	break;
						    case "022.12": $ket = "Pengembangan SDM"; 
						    	break;
						}
						$kode_detail = str_replace(".", "",$dt->kode_iku_e1 );
						$temprow = '<tr><td colspan='.($colspan[$dt->kode_iku_e1]+4).'><a href="#" class="toggler" id="'.
							$kode_detail.'" num_rowspan='.$rowspan[$dt->kode_sp_e1].' target_rowspan='.str_replace(".", "",$dt->kode_ss_kl).'>'
							.$ket.'</td></tr><tr class="detail'.$kode_detail.' detail_toggle ">'.$temprow;
						$countrow++;
					} else 
						$temprow ='<tr class="detail'.$kode_detail.' detail_toggle">'.$temprow;
					$tablerow .= $temprow;
					$temprow = '';
					$firstrow++;
					//$countrow++;
				}
			//}
			if (($j+1==$ldata) || ($dt->kode_sp_e1!= $data[$j+1]->kode_sp_e1)) $firstrow = 1;
			$j++;
		}
		//die(var_dump(array($countrow, $tablerow)));
		return array($countrow, $tablerow);
	}
	
	
	function excel($tahun_awal, $tahun_akhir, $kode_sasaran_kl){
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('ANEV CAPAIAN KINERJA');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'ANALISIS DAN EVALUASI CAPAIAN KINERJA');
		$this->excel->getActiveSheet()->setCellValue('A2', 'Periode  ');
		$this->excel->getActiveSheet()->setCellValue('B2', $tahun_awal." s.d ".$tahun_akhir);
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->mergeCells('A3:D3');
		$params = array("tahun_awal"=>$tahun_awal,"tahun_akhir"=>$tahun_akhir);
		$posisiRow = 4;
		
		$data = $this->sasaran_strategis_m->get_capaian_kinerja($kode_sasaran_kl, $tahun_awal, $tahun_akhir);
		
		$totalThn = 0;
		for($a=$tahun_awal; $a<=$tahun_akhir;$a++):
			$rata2PerTahun[$a] = array('nilai'	=> 0,
									   'pembagi'=> 0);
			$dataTemplate[$a] = array('target'		=> "-",
								   	  'realisasi'	=> "-",
								   	  'persen'		=> "-");
			$totalThn++;
		endfor;
		
		 
	 
		$dataAda = (count($data)>0);
		$dataSStemplate = $dataTemplate;
		#echo "<pre>";
		if ($dataAda){
			
			$noCapaian		= 0;
			$kode_iku_kl	= "";
			
			foreach($data as $d):
				#print_r($d);									
				if($kode_iku_kl != $d->kode_iku_kl && $kode_iku_kl!=""):
								
					$capaian[$noCapaian][$kode_kl] =  array('nama_e1'	=> "-",
															'kodeSS' 	=> $kodeSS,
															'iku'		=> $indikator,
															'satuan'	=> $satuan,
															'data'		=> $dataSStemplate);
															
					$data2=$this->sasaran_strategis_m->get_detail_capaian_kinerja($iku, $tahun_awal, $tahun_akhir, $kode_sasaran_kl);
					$kode_e1 = "";
					if(count($data2)!=0):
					foreach($data2 as $d2):
						
						$indikator  = $d2->indikator;
						$satuan		= $d2->satuan;
						$nama_e1	= $d2->singkatan;
						
						if($kode_e1!=$d2->kode_e1):
							$ikuDataTemplate = $dataTemplate;
							
							$ikuDataTemplate[$d2->tahun]	= array('target'		=> $d2->target,
																	'realisasi'		=> $d2->realisasi,
																	'persen'		=> $d2->persen);
							
						else:
							
							$ikuDataTemplate[$d2->tahun]	= array('target'		=> $d2->target,
																	'realisasi'		=> $d2->realisasi,
																	'persen'		=> $d2->persen);
											
						endif;
						
						$capaian[$noCapaian][$d2->kode_iku_e1] =  array('nama_e1'	=> $nama_e1,
																 'iku'		=> $indikator,
																'satuan'	=> $satuan,
																'data'		=> $ikuDataTemplate);
						
						$kode_e1 = $d2->kode_e1;
						
					endforeach;
					endif;
					$noCapaian++;
				
				endif;
				
				$kode_kl	= $d->kode_kl;
				$iku		= $d->kode_iku_kl;
				$kodeSS		= $d->deskripsi;
				$satuan		= $d->satuan;
				$indikator	= $d->indikator;
				
				$dataSStemplate[$d->tahun]	= array('target'		=> $d->target,
													'realisasi'		=> $d->realisasi,
													'persen'		=> $d->persen);
				
				$kode_iku_kl = $d->kode_iku_kl;
			endforeach;
		
		
			if($kode_sasaran_kl!="" || $kode_sasaran_kl!=0):
			
			$capaian[$noCapaian][$kode_kl] =  array('nama_e1'	=> "-",
															'kodeSS' 	=> $kodeSS,
															'iku'		=> $indikator,
															'satuan'	=> $satuan,
															'data'		=> $dataSStemplate);
															
					$data2=$this->sasaran_strategis_m->get_detail_capaian_kinerja($iku, $tahun_awal, $tahun_akhir, $kode_sasaran_kl);
					$kode_e1 = "";
					
					if(count($data2)!=0):
					foreach($data2 as $d2):
						
						$indikator  = $d2->indikator;
						$satuan		= $d2->satuan;
						$nama_e1	= $d2->singkatan;
						
						if($kode_e1!=$d2->kode_e1):
							$ikuDataTemplate = $dataTemplate;
							
							$ikuDataTemplate[$d2->tahun]	= array('target'		=> $d2->target,
																	'realisasi'		=> $d2->realisasi,
																	'persen'		=> $d2->persen);
							
						else:
							
							$ikuDataTemplate[$d2->tahun]	= array('target'		=> $d2->target,
																	'realisasi'		=> $d2->realisasi,
																	'persen'		=> $d2->persen);
											
						endif;
						
						$capaian[$noCapaian][$d2->kode_iku_e1] =  array('nama_e1'	=> $nama_e1,
																 'iku'		=> $indikator,
																'satuan'	=> $satuan,
																'data'		=> $ikuDataTemplate);
						
						$kode_e1 = $d2->kode_e1;
						
					endforeach;
					endif;
			endif;
		}
		$posisiRow++;
		 $table='';
				
		//$sasaran =  $this->get_tabel_capaian_kinerja($tahun_awal, $tahun_akhir, $kode_sasaran_kl,"get");
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow.':'.chr((ord('B')+(($totalThn*3)+2))).($posisiRow+1))->applyFromArray(
				array(
					'font'    => array('bold'=> true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
					'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
				));
		
		
		 $this->excel->getActiveSheet()->mergeCells("A".$posisiRow.":A".($posisiRow+1));
		 $this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Sasaran Strategis');
		 $this->excel->getActiveSheet()->mergeCells("B".$posisiRow.":B".($posisiRow+1));
		 $this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, 'Indikator Kerja Utama (IKU)');
		
		 $this->excel->getActiveSheet()->mergeCells("C".$posisiRow.":C".($posisiRow+1));
		 $this->excel->getActiveSheet()->setCellValue('C'.$posisiRow, 'Satuan');
		
		$startColTahun = ord("D");
		for($a=$tahun_awal; $a<=$tahun_akhir;$a++):
			
			$this->excel->getActiveSheet()->mergeCells(chr($startColTahun).$posisiRow.":".chr($startColTahun+2).($posisiRow));
			$this->excel->getActiveSheet()->setCellValue( chr($startColTahun).$posisiRow, $a);
			$this->excel->getActiveSheet()->setCellValue(chr($startColTahun).($posisiRow+1), 'Target');
			$this->excel->getActiveSheet()->setCellValue(chr($startColTahun+1).($posisiRow+1), 'Realisasi');
			$this->excel->getActiveSheet()->setCellValue(chr($startColTahun+2).($posisiRow+1), 'Persen');
			$startColTahun+=3;
			
		endfor;
		 $this->excel->getActiveSheet()->mergeCells(chr($startColTahun).$posisiRow.":".chr($startColTahun).($posisiRow+1));
		 $this->excel->getActiveSheet()->setCellValue(chr($startColTahun).$posisiRow, 'Rata-rata %');
				
		$endColTahun = $startColTahun + ($tahun_akhir-$tahun_awal);
		
		$posisiRow+=2;
		
		
		if ($dataAda){
			
			for($dcp=0;$dcp<count($capaian);$dcp++):
				$totUnitKerja	= 0;
				$curEselon1		= "";
				$dtcapaian 		= $capaian[$dcp];
				
				$esArray = array();
				foreach($dtcapaian as $cp):
					if($cp['nama_e1']!="-"):
						if($curEselon1 != $cp['nama_e1']):
							$totUnitKerja++;
							$esArray[$dcp][str_replace(" ","",$cp['nama_e1'])] = 1;
						else:
							$esArray[$dcp][str_replace(" ","",$cp['nama_e1'])]++;
						endif;
						$curEselon1 = $cp['nama_e1'];
					endif;
					if(isset($cp['kodeSS'])): $namaSS = $cp['kodeSS']; endif;
				endforeach;
				
				 $jRow = count($dtcapaian)+$totUnitKerja;
				
				 $this->excel->getActiveSheet()->mergeCells("A".$posisiRow.":A".($posisiRow+$jRow-1));
				 $this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, $namaSS);
		 
				$curEselon1 = "";
				foreach($dtcapaian as $cp):
				
					if($cp['nama_e1']!="-"):
							
						if($curEselon1 != $cp['nama_e1']):							
							$this->excel->getActiveSheet()->mergeCells("B".$posisiRow.":".chr((ord('B')+(($totalThn*3)+2))).$posisiRow);
							$this->excel->getActiveSheet()->getStyle('B'.$posisiRow)->getFont()->setBold(true);
							$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, $cp['nama_e1']);
							$posisiRow++;
						else:
							  
						endif;
						$curEselon1 = $cp['nama_e1'];
					
					endif;
					
					$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, $cp['iku']);
					$this->excel->getActiveSheet()->getStyle('C'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excel->getActiveSheet()->setCellValue('C'.$posisiRow, $cp['satuan']);
					
					$rata2Row 		= 0;
					$pembagiRata2Row= 0;
					$startColTahun = ord("D");	
					foreach($cp['data'] as $key => $dt):
						$this->excel->getActiveSheet()->getStyle(chr($startColTahun).$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet()->getStyle(chr($startColTahun+1).$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet()->getStyle(chr($startColTahun+2).$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet()->getStyle(chr($startColTahun).$posisiRow)->getNumberFormat()->setFormatCode('#,##0.00');
						$this->excel->getActiveSheet()->getStyle(chr($startColTahun+1).$posisiRow)->getNumberFormat()->setFormatCode('#,##0.00');
						$this->excel->getActiveSheet()->getStyle(chr($startColTahun+2).$posisiRow)->getNumberFormat()->setFormatCode('#,##0.00');
						$this->excel->getActiveSheet()->setCellValue(chr($startColTahun).$posisiRow,  $dt['target']);
						$this->excel->getActiveSheet()->setCellValue(chr($startColTahun+1).$posisiRow, $dt['realisasi']);
						$this->excel->getActiveSheet()->setCellValue(chr($startColTahun+2).$posisiRow, $dt['persen']);
						$startColTahun+=3;
						if(is_numeric($dt['persen'])):
							$rata2Row		 	= $rata2Row+$dt['persen'];
							$pembagiRata2Row	= $pembagiRata2Row+1;
							
							$rata2PerTahun[$key]['nilai'] = $rata2PerTahun[$key]['nilai']+$dt['persen'];
							$rata2PerTahun[$key]['pembagi'] = $rata2PerTahun[$key]['pembagi']+1;
						 
						endif;
						
					endforeach;
					
					$nilaiRata2Row = $rata2Row/$pembagiRata2Row;
					$this->excel->getActiveSheet()->getStyle(chr($startColTahun).$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excel->getActiveSheet()->getStyle(chr($startColTahun).$posisiRow)->getNumberFormat()->setFormatCode('#,##0.00');
					$this->excel->getActiveSheet()->setCellValue(chr($startColTahun).$posisiRow, $nilaiRata2Row);	
					$posisiRow++;		
				endforeach;
				$posisiRow++;	
			endfor;
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow.':'.chr((ord('B')+(($totalThn*3)+2))).($posisiRow))->applyFromArray(
				array(
					'font'    => array('bold'=> true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
					'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),'bottom'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),'left'=> array('style' => PHPExcel_Style_Border::BORDER_THIN),'right'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
				));
				
				$this->excel->getActiveSheet()->mergeCells("A".$posisiRow.":C".$posisiRow);
				//$this->excel->getActiveSheet()->getStyle('B'.$posisiRow)->getFont()->setBold(true);
				$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Rata-rata Capaian Kinerja / Tahun');
					
				$rata2total = 0;
				$rata2totalPembagi=0;
				$startColTahun = ord("D");	
				foreach($rata2PerTahun as $key => $rt2):
					$this->excel->getActiveSheet()->mergeCells(chr($startColTahun).$posisiRow.":".(chr($startColTahun+1)).$posisiRow);
					$this->excel->getActiveSheet()->setCellValue(chr($startColTahun).$posisiRow, $key);
					if($rt2['pembagi']!=0):
						$nilai = $rt2['nilai']/$rt2['pembagi'];
						$this->excel->getActiveSheet()->getStyle(chr($startColTahun+2).$posisiRow)->getNumberFormat()->setFormatCode('#,##0.00');
						$this->excel->getActiveSheet()->setCellValue(chr($startColTahun+2).$posisiRow, $nilai);
						$rata2total 		= $rata2total+$nilai;
						$rata2totalPembagi 	= $rata2totalPembagi+1;
					else:
						$this->excel->getActiveSheet()->getStyle(chr($startColTahun+2).$posisiRow)->getNumberFormat()->setFormatCode('#,##0.00');
						$this->excel->getActiveSheet()->setCellValue(chr($startColTahun+2).$posisiRow,0);
						
					endif;
					$startColTahun +=3;
				endforeach;
				
				$nilaiRata2Total = $rata2total/$rata2totalPembagi;
				$this->excel->getActiveSheet()->getStyle(chr($startColTahun).$posisiRow)->getNumberFormat()->setFormatCode('#,##0.00');
					$this->excel->getActiveSheet()->setCellValue(chr($startColTahun).$posisiRow, $nilaiRata2Total);
				
		}else {
				$this->excel->getActiveSheet()->mergeCells("A".$posisiRow.":".chr((ord('A')+(($totalThn*3)+3))).$posisiRow);
				$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
				$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Data tidak ada');
				 
		}
		
		
	
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		//$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(100);
		$this->excel->getActiveSheet()->getStyle('A4:A'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('B4:B'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('C4:C'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('D4:D'.$posisiRow)->getAlignment()->setWrapText(true); 
		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		
		
		
		$this->excel->setActiveSheetIndex(0);	
		$filename='CapaianKinerja'.$tahun_awal.'_'.$tahun_akhir.'.xls'; 
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