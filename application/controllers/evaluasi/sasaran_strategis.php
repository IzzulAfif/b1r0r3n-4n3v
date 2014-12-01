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
		$pdf->AddPage('L');
		//var_dump($e1);
		 $pdf->Write(0, 'Analisis dan Evaluasi Capaian Kinerja ', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
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
		$pdf->Output('Capaian kinerja.pdf', 'I');
		
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
		$dataAda = (count($data)>0);
		$dataSStemplate = $dataTemplate;
		
		if ($dataAda){
			foreach($data as $d):
				$kode_kl	= $d->kode_kl;
				$iku		= $d->kode_iku_kl;
				$kodeSS		= $d->deskripsi;
				$satuan		= $d->satuan;
				$indikator	= $d->indikator;
				
				$dataSStemplate[$d->tahun]	= array('target'		=> $d->target,
													'realisasi'		=> $d->realisasi,
													'persen'		=> $d->persen);
			endforeach;
		
			$capaian[$kode_kl] =  array('nama_e1'	=> "-",
									'iku'		=> $indikator,
									'satuan'	=> $satuan,
									'data'		=> $dataSStemplate);
		
			$data2=$this->sasaran_strategis_m->get_detail_capaian_kinerja($iku, $tahun_awal, $tahun_akhir, $kode_sasaran_kl);
			$kode_e1 = "";
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
				
				$capaian[$d2->kode_iku_e1] =  array('nama_e1'	=> $nama_e1,
													'iku'		=> $indikator,
													'satuan'	=> $satuan,
													'data'		=> $ikuDataTemplate);
				
				$kode_e1 = $d2->kode_e1;
				
			endforeach;
		}//end jika data ada
		
		$table = "";
			$thead = '<thead>
						<tr>
							<th rowspan="2">Sasaran Strategis</th>
							<th rowspan="2">Indikator Kerja Utama (IKU)</th>
							<th rowspan="2">Satuan</th>';
			$thead2    = "";
			for($a=$tahun_awal; $a<=$tahun_akhir;$a++):
				$thead .= '<th colspan="3">'.$a.'</th>';
				$thead2 .= '<th>Target</th><th>Realisasi</th><th>Persen</th>';
			endfor;
					$thead.= '<th rowspan="2">Rata-rata %</th>
					  	</tr>
						<tr>'.$thead2.'</tr></thead>';
			$table .= $thead;
			
			$table .= '<tbody>';
			if ($dataAda){		
					$totUnitKerja	= 0;
					$curEselon1		= "";
					foreach($capaian as $cp):
						if($cp['nama_e1']!="-"):
							if($curEselon1 != $cp['nama_e1']):
								$totUnitKerja++;
							endif;
							$curEselon1 = $cp['nama_e1'];
						endif;
					endforeach;
					
					$table .='<tr><td rowspan="'.(count($capaian)+$totUnitKerja).'">'.$kodeSS.'</td>';
					
					$curEselon1 = "";
					foreach($capaian as $cp):
						 $kode_detail = str_replace(".","",$cp['iku']);
						if($cp['nama_e1']!="-"):
							
							if($curEselon1 != $cp['nama_e1']):
								/*<a href="#" class="toggler" id="'.
							$kode_detail.'" num_rowspan='.$rowspan[$dt->kode_sp_e1].' target_rowspan='.str_replace(".", "",$dt->kode_ss_kl).'>'
							.$ket.'</td></tr><tr class="detail'.$kode_detail.' detail_toggle ">'.$temprow;*/
							
								$table.='<tr><td colspan="'.(($totalThn*3)+3).'"><b>'.$cp['nama_e1'].'</b></td></tr><tr>';
							else:
								$table.="<tr>";
							endif;
							$curEselon1 = $cp['nama_e1'];
						
						endif;
						
						$table.='<td>'.$cp['iku'].'</td>';
						$table.='<td>'.$cp['satuan'].'</td>';
						
						$rata2Row 		= 0;
						$pembagiRata2Row= 0;
						foreach($cp['data'] as $key => $dt):
						
							$table.='<td>'.$this->template->cek_tipe_numerik($dt['target']).'</td>';
							$table.='<td>'.$this->template->cek_tipe_numerik($dt['realisasi']).'</td>';
							$table.='<td>'.$this->template->cek_tipe_numerik($dt['persen']).'</td>';
							
							if(is_numeric($dt['persen'])):
								$rata2Row		 	= $rata2Row+$dt['persen'];
								$pembagiRata2Row	= $pembagiRata2Row+1;
								
								$rata2PerTahun[$key]['nilai'] = $rata2PerTahun[$key]['nilai']+$dt['persen'];
								$rata2PerTahun[$key]['pembagi'] = $rata2PerTahun[$key]['pembagi']+1;
								
							endif;
							
						endforeach;
						
						$nilaiRata2Row = $rata2Row/$pembagiRata2Row;
						$table.='<td>'.$this->template->cek_tipe_numerik($nilaiRata2Row).'</td></tr>';
						
					endforeach;
					
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
			} // end if jika data ada
			else {
				$table .='<td colspan="'.(4+ (3*($tahun_akhir-$tahun_awal+1))).'">Data tidak ada</td>';
				
			}
			$table .= '</tbody>';
		
		#$table.= "<table>";
		
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
}