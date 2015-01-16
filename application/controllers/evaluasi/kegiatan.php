<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Faizal
 @date       : 2014-08-15 00:00
 @revision	 :
*/
error_reporting(E_ERROR);
class Kegiatan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('evaluasi/program_m','',TRUE);
		$this->load->model('/admin/tahun_renstra_model','setting_th');
	}

	function index()
	{
		$data['renstra']	= $this->setting_th->get_list();
		$this->load->view('evaluasi/kegiatan_v',$data);
	}
	
	function get_program($tahun_awal, $tahun_akhir)
	{
		echo json_encode($this->program_m->get_program_list($tahun_awal, $tahun_akhir));
	}
	
	function get_kegiatan($program)
	{
		echo json_encode($this->program_m->get_kegiatan_program($program));
	}
	
	function get_output_kegiatan($kode_kegiatan,$tipe="html")
	{
		$output = $this->program_m->get_output_kegiatan($kode_kegiatan);
		$outputList = "<ol>";
		foreach($output as $o):
			$outputList .= "<li>".$o."</li>";
		endforeach;
		$outputList.="</ol>";
		
		$data = json_encode(array(
		 	'pelaksana'=>$this->program_m->get_pelaksana_kegiatan($kode_kegiatan),
		 	'output'=>$outputList
		));
		
		if($tipe=="html"):
			echo $data;
		else:
			return $data;
		endif;
	}
	
	function get_data_serapan($tahun_awal, $tahun_akhir, $kode_kegiatan,$kode_e2)
	{
		$dRealisasi	= $this->program_m->get_rata2_capain_kinerja_e2($kode_e2, $tahun_awal, $tahun_akhir);
		$dSerapan	= $this->program_m->get_rata2_serapan_anggaran_e2($kode_kegiatan, $tahun_awal, $tahun_akhir);
		
		if(count($dRealisasi) > $dSerapan):
			for($a=0;$a<count($dRealisasi);$a++):
				$dtTahun[]		= $dRealisasi[$a]->tahun;
				$dtProgram[]	= (int) $this->template->cek_tipe_numerik($dRealisasi[$a]->persen);
				if($dSerapan[$a]->persen==0): $serapan_persen = "100"; else: $serapan_persen = $dSerapan[$a]->persen; endif;
				$dtAnggaran[]	= (!isset($dSerapan[$a]->persen))?"0":(int) $this->template->cek_tipe_numerik($serapan_persen);
			endfor;
		else:
			for($a=0;$a<count($dSerapan);$a++):
				$dtTahun[]		= $dSerapan[$a]->tahun;
				$dtProgram[]	= (!isset($dRealisasi[$a]->persen))?0:(float) $this->template->cek_tipe_numerik($dRealisasi[$a]->persen);
				if($dSerapan[$a]->persen==0): $serapan_persen = "100"; else: $serapan_persen = $dSerapan[$a]->persen; endif;
				$dtAnggaran[]	= (float) $this->template->cek_tipe_numerik($serapan_persen);
			endfor;
		endif;
		$jsonData = array('tahun'=>$dtTahun,'program'=>$dtProgram,'anggaran'=>$dtAnggaran);
		echo json_encode($jsonData);
		exit;
	}
	
	function get_tabel_serapan_anggaran($tahun_awal, $tahun_akhir, $kode_kegiatan,$tipe='html')
	{
		$j = 0; $sum_pagu = 0; $sum_realisasi = 0; $sum_dayaserap = 0;
		$data = $this->program_m->get_realisasi_kegiatan($kode_kegiatan, $tahun_awal, $tahun_akhir);
		
		if (count($data)>0) {
	
			$table_header = '<thead><tr><th>Uraian</th>';
			$row_pagu = '<tbody><tr><td>1. Pagu (Rp.)</td>';
			$row_realisasi = '<tr><td>2. Realisasi (Rp.)</td>';
			$row_dayaserap = '<tr><td>3. Daya Serap (%)</td>';
		
			foreach ($data as $dt) {
				$table_header .= '<th>'.$dt->tahun.'</th>';
				$row_pagu .= '<td>'.$this->template->cek_tipe_numerik($dt->pagu).'</td>'; $sum_pagu += $dt->pagu;
				$row_realisasi .= '<td>'.$this->template->cek_tipe_numerik($dt->realisasi).'</td>'; $sum_realisasi += $dt->realisasi;
				if($dt->realisasi==0):
					$persen = "100";
				else:
					$persen = ($dt->realisasi/$dt->pagu)*100;
				endif;
				#if($persen==0): $persen = 100; endif;
				$row_dayaserap .= '<td id="agr-'.$dt->tahun.'">'.$this->template->cek_tipe_numerik($persen).'</td>'; $sum_dayaserap += $persen;
				$j++;
				$dRatarata[] = array('tahun'	=> $dt->tahun,
									 'persen'	=> $this->template->cek_tipe_numerik($persen));
			}
		
		$table_header .= '<th>Rata-rata</th></tr><thead>';
		$row_pagu .= '<td>'.$this->template->cek_tipe_numerik(($sum_pagu/$j)).'</td></tr>';
		$row_realisasi .= '<td>'.$this->template->cek_tipe_numerik(($sum_realisasi/$j)).'</td></tr>';
		$row_dayaserap .= '<td>'.$this->template->cek_tipe_numerik(($sum_dayaserap/$j)).'</td></tr></tbody>';
		$dataShow = $table_header.$row_pagu.$row_realisasi.$row_dayaserap;
		
		}else{
			$dataShow = '<tbody><tr><td colspan="3">Tidak ada data</td></tr></tbody>'; 
		}
		
		if($tipe=="html"):
			echo $dataShow;
		else:
			return $dataShow;
		endif;
	}

	function get_tabel_capaian_kinerja($tahun_awal, $tahun_akhir, $kode_e2,$tipe='html') 
	{
		$j = 0; $thn = 0; $firstrow = 1; $countrow = 0; $temprow = ''; $sum_program = 0;
		$data = $this->program_m->get_capaian_kinerja2($kode_e2, $tahun_awal, $tahun_akhir);
		
		$ldata = sizeof($data);
		$kd_ikk = '';
		if (count($data)>0) {
			$thead = '<thead><tr><th rowspan="2">Sasaran Kegiatan</th><th rowspan="2">Indikator</th><th rowspan="2">Satuan</th>';
			$tbody = '<tbody>';
			foreach ($data as $dt) {
				if ($dt->kode_ikk!=$kd_ikk)
					$rowspan[$dt->kode_sk_e2]=(!isset($rowspan[$dt->kode_sk_e2]))?1:$rowspan[$dt->kode_sk_e2]+1;
				$kd_ikk = $dt->kode_ikk;
				$sum_tahun[$dt->tahun][] = (is_numeric($dt->persen)?$dt->persen:0);
			}
			
			foreach ($sum_tahun as $k => $val):
				$lastYear = $k;
			endforeach;
				
			$n = 1;
			foreach ($data as $dt) {
				$temprow .= '<td>'.(is_numeric($dt->target)?$dt->target:"-").'</td><td>'
					.(is_numeric($dt->realisasi)?$dt->realisasi:"-").'</td><td>'
					.(is_numeric($dt->persen)?$this->template->cek_tipe_numerik($dt->persen):"-").'</td>'; 
				
				$sum_program += $dt->persen; $thn++;
				$sum_tahun[$dt->tahun][] = (is_numeric($dt->persen)?$dt->persen:0);			
				if (($j+1==$ldata) || $dt->kode_ikk!=$data[$j+1]->kode_ikk) {
					$temprow = '<td>'.$dt->indikator.'</td><td>'.$dt->satuan.'</td>'.$temprow;
					
					if($dt->tahun < $lastYear):					
						for($c=0;$c<($lastYear-$dt->tahun);$c++):
							$temprow .='<td>-</td><td>-</td><td>-</td>';
						endfor;
					endif;
					
					$temprow .= '<td>'.$this->template->cek_tipe_numerik(($sum_program/$thn)).'</td></tr>';
					$thn = 0; $sum_program = 0;
					if ($firstrow==1) $temprow = '<tr><td rowspan="'.($rowspan[$dt->kode_sk_e2]).'">'.$dt->deskripsi.'</td>'.$temprow;
						else $temprow ='<tr>'.$temprow;
					$tbody .= $temprow;
					$temprow = '';
					$firstrow++;
					$countrow++;
				}
				if (($j+1==$ldata) || ($dt->kode_sk_e2!= $data[$j+1]->kode_sk_e2)) $firstrow = 1;
				$j++;
				$n++;
			}
		
		$tbody .= '<tr><td colspan="3">Rata-rata Capaian Kinerja / Tahun</td>';
		$temp_thead = '<tr>';
		$total = 0;
		
		foreach ($sum_tahun as $k => $val):
			$total=0;
			foreach($val as $v):
				$total = $total+$v;
			endforeach;
			$datasum[$k] = $total;
		endforeach;
		
		$totalRata2 = 0;
		$row = 1;
		foreach ($datasum as $k => $val) {
			$thead .= '<th colspan="3">'.$k.'</th>';
		 	$temp_thead .= '<th>Target</th><th>Realisasi</th><th>Persen</th>';
		 	$tbody .= '<td></td><td></td><td>'.$this->template->cek_tipe_numerik(($val/$countrow)).'</td>'; 
			$totalRata2 = $totalRata2+($val/$countrow);
		if($row==count($datasum)&&$lastYear==$k): 
			$thead .= '<th rowspan="2">Rata-rata<br>%</th></tr>'.$temp_thead.'</tr></thead>';
			$tbody .= '<td>'.$this->template->cek_tipe_numerik(($totalRata2/count($datasum))).'</td></tr></tbody>';
		endif;
			$row++;
		}
			
		}else{
			$thead = "";
			$tbody = '<tbody><tr><td colspan="3">Tidak ada data</td></tr></tbody>';
		}
		
		if($tipe=="html"):
			echo "<table>".$thead.$tbody."</table>";
		else:
			return $thead.$tbody;
		endif;
	}
	
	function print_tabel_kegiatan($tahun1,$tahun2,$kegiatan,$program)
	{
		$dataKegiatan= json_decode($this->get_output_kegiatan($kegiatan,"get"),true);
		$dataCapaian = $this->get_tabel_capaian_kinerja($tahun1,$tahun2,$dataKegiatan['pelaksana']['kode_e2'],"get");
		$dataSerapan = $this->get_tabel_serapan_anggaran($tahun1,$tahun2,$kegiatan,"get");
		
		$tabelCapaian  = '<table style="width:750px;" border="1" cellpadding="4" cellspacing="0">';
		$tabelCapaian .= $dataCapaian;
		$tabelCapaian .= '</table>';
		
		$tabelSerapan  = '<table style="width:750px;" border="1" cellpadding="4" cellspacing="0">';
		$tabelSerapan .= $dataSerapan;
		$tabelSerapan .= '</table>';
		
		$tabel = '<page format="A4"><table border="0" cellpadding="4" cellspacing="0">';
		$tabel .= '<tr><td valign="top" style="width:120px;"><b>Output Kegiatan</b></td><td>';
		$tabel .= $dataKegiatan['output'].'</td></tr>';
		$tabel .= '<tr><td><b>Pelaksana Kegiatan</b></td><td><p style="margin-left:10px;">'.$dataKegiatan['pelaksana']['nama_e2'].'</p></td></tr>';
		$tabel .= '<tr><td colspan="2"><b>Capaian Kinerja</b></td></tr>';
		$tabel .= '<tr><td colspan="2">'.$tabelCapaian.'</td></tr>';
		$tabel .= '<tr><td colspan="2"><b>Serapan Anggaran</b></td></tr>';
		$tabel .= '<tr><td colspan="2">'.$tabelSerapan.'</td></tr>';
		$tabel .= '</table></page>';
			
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', FALSE, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Capaian Kegiatan');
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
		 $pdf->Write(0, 'Analisis dan Evaluasi Kegiatan ', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);
				
		$pdf->writeHTML($tabel, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('kegiatan.pdf', 'I');
	}
	
	function ekspor_tabel_kegiatan($tahun1,$tahun2,$kegiatan,$program)
	{
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Program');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->mergeCells('A1:R1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Analisis dan Evaluasi Kegiatan');
		
		$this->excel->getActiveSheet()->mergeCells('A2:R2');
		
		$output = $this->program_m->get_output_kegiatan($kegiatan);
		
		$this->excel->getActiveSheet()->mergeCells('A3:B3');
		$this->excel->getActiveSheet()->mergeCells('A3:A'.(2+count($output)));
		$this->excel->getActiveSheet()->setCellValue('A3', 'Output Kegiatan');
		
		$noKeg		= 1;
		$rowExcel	= 3;
		foreach($output as $o):
			$this->excel->getActiveSheet()->mergeCells('C'.$rowExcel.':R'.$rowExcel);
			$this->excel->getActiveSheet()->setCellValue('C'.$rowExcel, $noKeg.". ".$o);
			
			$rowExcel++;
			$noKeg++;
		endforeach;
		
		$this->excel->getActiveSheet()->mergeCells('A'.$rowExcel.':R'.$rowExcel);
		$pelaksana = $this->program_m->get_pelaksana_kegiatan($kegiatan);
		
		$rowExcel++;
		$this->excel->getActiveSheet()->mergeCells('A'.$rowExcel.':B'.$rowExcel);
		$this->excel->getActiveSheet()->setCellValue('A'.$rowExcel, 'Pelaksana Kegiatan');
		$this->excel->getActiveSheet()->mergeCells('C'.$rowExcel.':R'.$rowExcel);
		$this->excel->getActiveSheet()->setCellValue('C'.$rowExcel, $pelaksana->nama_e2." (".$pelaksana->kode_e2.")");
		
		$rowExcel++;
		$this->excel->getActiveSheet()->mergeCells('A'.$rowExcel.':R'.$rowExcel);
		$rowExcel++;
		$this->excel->getActiveSheet()->mergeCells('A'.$rowExcel.':R'.$rowExcel);
		$this->excel->getActiveSheet()->setCellValue('A'.$rowExcel, 'Capaian Kinerja');
		$rowExcel++;
		
		$j = 0; $thn = 0; $firstrow = 1; $countrow = 0; $temprow = ''; $sum_program = 0;
		$data = $this->program_m->get_capaian_kinerja2($pelaksana->kode_e2, $tahun1, $tahun2);
			
		if (count($data)>0):
			
			$kd_sk_e2	= "";
			$kd_ikk		= "";
			$arrData	= array();
			$arrIkk		= array();
			$aTahun		= array();	
			$sum_tahun	= array();
			$rt2tahun	= 0;
			
			foreach($data as $d):
				
				if($kd_sk_e2!=$d->kode_sk_e2):
					$arrData[] = array('deskripsi'	=> $d->deskripsi,
									   'kd_sk'		=> $d->kode_sk_e2);
				endif;
				
				$arrIkk[$d->kode_sk_e2][$d->kode_ikk][] = array('tahun'		=> $d->tahun,
												  				'indikator'	=> $d->indikator,
												  				'satuan'	=> $d->satuan,
																'target'	=> $d->target,
																'realisasi'	=> $d->realisasi,
																'persen'	=> $d->persen);
				
				$aTahun[$d->tahun] = $d->tahun; 
				$kd_sk_e2	= $d->kode_sk_e2;
						
			endforeach;
		
			$this->excel->getActiveSheet()->mergeCells('A'.$rowExcel.':A'.($rowExcel+1));
			$this->excel->getActiveSheet()->setCellValue('A'.$rowExcel, 'Sasaran Kegiatan');
			$this->excel->getActiveSheet()->mergeCells('B'.$rowExcel.':B'.($rowExcel+1));
			$this->excel->getActiveSheet()->setCellValue('B'.$rowExcel, 'Indikator');
			$this->excel->getActiveSheet()->mergeCells('C'.$rowExcel.':C'.($rowExcel+1));
			$this->excel->getActiveSheet()->setCellValue('C'.$rowExcel, 'Satuan');
			
			$no_abjad = 68;
			foreach($aTahun as $at):
				$this->excel->getActiveSheet()->mergeCells(chr($no_abjad).$rowExcel.':'.chr($no_abjad+2).$rowExcel);
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $at);
				$no_abjad = $no_abjad+3;
			endforeach;
			
			$this->excel->getActiveSheet()->mergeCells(chr($no_abjad).$rowExcel.':'.chr($no_abjad).($rowExcel+1));
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, "Rata-rata %");
			$rowExcel++;
			
			$no_abjad = 68;
			foreach($aTahun as $at):
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, "Target"); 
				$no_abjad++;
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, "Realisasi"); 
				$no_abjad++;
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, "Persen"); 
				$no_abjad++;
			endforeach;
			$rowExcel++;
			
			$rt2Total	= 0;
			$totalRow	= 0;
			$rt2pertahun= "";
			
			foreach($arrData as $ad):
			
				$this->excel->getActiveSheet()->mergeCells("A".$rowExcel.':A'.($rowExcel+count($arrIkk[$ad['kd_sk']])-1));
				$this->excel->getActiveSheet()->setCellValue("A".$rowExcel, $ad['deskripsi']);
				
				$noBaris	= 0;
				foreach($arrIkk[$ad['kd_sk']] as $ak):
					
					$this->excel->getActiveSheet()->setCellValue("B".$rowExcel, $ak[0]['indikator']);
					$this->excel->getActiveSheet()->setCellValue("C".$rowExcel, $ak[0]['satuan']);
					
					$rt2row = 0;
					$no_abjad = 68;
					for($c=0;$c<count($ak);$c++):
					
						$rt2pertahun[$ak[$c]['tahun']] =$rt2pertahun[$ak[$c]['tahun']]+$ak[$c]['persen'];
						
						$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, (is_numeric($ak[$c]['target'])?$this->template->cek_tipe_numerik($ak[$c]['target']):"0")); 
						$no_abjad++;
						$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, (is_numeric($ak[$c]['realisasi'])?$this->template->cek_tipe_numerik($ak[$c]['realisasi']):"0")); 
						$no_abjad++;
						$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, (is_numeric($ak[$c]['persen'])?$this->template->cek_tipe_numerik($ak[$c]['persen']):"0")); 
						$no_abjad++;
						
						$rt2row = $rt2row+$ak[$c]['persen'];
						
					endfor;
					
					$persenRt2row = ($rt2row/count($ak));
					$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $this->template->cek_tipe_numerik($persenRt2row));
					
					$rt2Total	= $rt2Total+$persenRt2row;
					$totalRow++;
					$noBaris++;
					
					if($noBaris!=count($arrIkk[$ad['kd_sk']])): $rowExcel++; endif;	
				endforeach;
				$rowExcel++;
			endforeach;
			
			$this->excel->getActiveSheet()->mergeCells("A".$rowExcel.':C'.$rowExcel);
			$this->excel->getActiveSheet()->setCellValue("A".$rowExcel,"Rata-rata Capaian Kinerja / Tahun");
			
			$no_abjad = 67;
			foreach($rt2pertahun as $rt):
				$no_abjad = $no_abjad+3;
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel,$this->template->cek_tipe_numerik($rt/$totalRow));
			endforeach;
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad+1).$rowExcel,$this->template->cek_tipe_numerik($rt2Total/$totalRow));
			$rowExcel++;
				
		endif;
		
		$rowExcel++;
		$this->excel->getActiveSheet()->mergeCells('A'.$rowExcel.':R'.$rowExcel);
		$this->excel->getActiveSheet()->setCellValue('A'.$rowExcel, 'Serapan Anggaran');
		$rowExcel++;
		
		$j = 0; $sum_pagu = 0; $sum_realisasi = 0; $sum_dayaserap = 0;
		$data = $this->program_m->get_realisasi_kegiatan($kegiatan, $tahun1, $tahun2);
		if (count($data)>0) {
			
			$this->excel->getActiveSheet()->setCellValue("A".$rowExcel,"Uraian");
			
			$sum_dayaserap = 0;
			$j=0;
			$no_abjad = 66;
			foreach ($data as $dt):
				
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel,$dt->tahun);
				$no_abjad++;
				
				$arrPagu[]	= $this->template->cek_tipe_numerik($dt->pagu);
				$arrReal[]	= $this->template->cek_tipe_numerik($dt->realisasi);
					if($dt->realisasi==0):
						$persen = "100";
					else:
						$persen = ($dt->realisasi/$dt->pagu)*100;
					endif;
				$arrSerap[]	= $persen;
				
				$sum_pagu		+= $dt->pagu;
				$sum_realisasi	+= $dt->realisasi;
				$sum_dayaserap	+= $persen;
				$j++;
			endforeach;
				
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel,"Rata-rata");
				$rowExcel++;
			
			$this->excel->getActiveSheet()->setCellValue("A".$rowExcel,"1. Pagu (Rp.)");
			$no_abjad = 66;
			for($a=0;$a<count($arrPagu);$a++):
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel,$this->template->cek_tipe_numerik($arrPagu[$a]));
				$no_abjad++;
			endfor;
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel,$this->template->cek_tipe_numerik(($sum_pagu/$j)));
			$rowExcel++;
			
			$this->excel->getActiveSheet()->setCellValue("A".$rowExcel,"2. Realisasi (Rp.)");
			$no_abjad = 66;
			for($a=0;$a<count($arrReal);$a++):
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel,$this->template->cek_tipe_numerik($arrReal[$a]));
				$no_abjad++;
			endfor;
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel,$this->template->cek_tipe_numerik(($sum_realisasi/$j)));
			$rowExcel++;
			
			$this->excel->getActiveSheet()->setCellValue("A".$rowExcel,"3. Daya Serap (%)");
			$no_abjad = 66;
			for($a=0;$a<count($arrSerap);$a++):
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel,$this->template->cek_tipe_numerik($arrSerap[$a]));
				$no_abjad++;
			endfor;
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel,$this->template->cek_tipe_numerik(($sum_dayaserap/$j)));
			
		}
		
		$filename='analisis_dan_evaluasi_kegiatan.xls'; 
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