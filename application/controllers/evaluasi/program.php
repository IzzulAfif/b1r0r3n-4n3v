<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Faizal
 @date       : 2014-08-15 00:00
 @revision	 :
*/

class program extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('evaluasi/program_m','',TRUE);
		$this->load->model('/admin/tahun_renstra_model','setting_th');
	}

	function index()
	{
		$data['renstra']	= $this->setting_th->get_list();
		$this->load->view('evaluasi/program_v',$data);
	}
	
	function get_program($tahun_awal, $tahun_akhir)
	{
		echo json_encode($this->program_m->get_program_list($tahun_awal, $tahun_akhir));
	}
	
	function get_kegiatan_pelaksana_program($kode_program,$tipe="html")
	{
		$data = json_encode(array(
		 	'pelaksana'=>$this->program_m->get_pelaksana_program($kode_program),
		 	'kegiatan'=>$this->program_m->get_kegiatan_program($kode_program)
		));
		
		if($tipe=="html"):
			echo $data;
		else:
			return $data;
		endif;
	}
	
	function get_data_serapan($tahun_awal, $tahun_akhir, $kode_program,$kode_e1)
	{
		$dRealisasi	= $this->program_m->get_rata2_capain_kinerja($kode_e1, $tahun_awal, $tahun_akhir);
		$dSerapan	= $this->program_m->get_rata2_serapan_anggaran($kode_program, $tahun_awal, $tahun_akhir);

		if(count($dRealisasi) > $dSerapan):
			for($a=0;$a<count($dRealisasi);$a++):
				$dtTahun[]		= $dRealisasi[$a]->tahun;
				$dtProgram[]	= (int) number_format($dRealisasi[$a]->persen,2,'.','.');
				$dtAnggaran[]	= (!isset($dSerapan[$a]->persen))?"0":(int) number_format($dSerapan[$a]->persen,2,'.','.');
			endfor;
		else:
			for($a=0;$a<count($dSerapan);$a++):
				$dtTahun[]		= $dSerapan[$a]->tahun;
				$dtProgram[]	= (!isset($dRealisasi[$a]->persen))?0:(float) number_format($dRealisasi[$a]->persen,2,'.','.');
				$dtAnggaran[]	= (float) number_format($dSerapan[$a]->persen,2,'.','.');
			endfor;
		endif;
		$jsonData = array('tahun'=>$dtTahun,'program'=>$dtProgram,'anggaran'=>$dtAnggaran);
		echo json_encode($jsonData);
		exit;
	}
	
	function get_tabel_serapan_anggaran($tahun_awal, $tahun_akhir, $kode_program,$tipe="html")
	{
		$table_header = '<thead><tr><th>Uraian</th>';
		$row_pagu = '<tbody><tr><td>1. Pagu (Rp.)</td>';
		$row_realisasi = '<tr><td>2. Realisasi (Rp.)</td>';
		$row_dayaserap = '<tr><td>3. Daya Serap (%)</td>';
		$j = 0; $sum_pagu = 0; $sum_realisasi = 0; $sum_dayaserap = 0;
		$data = $this->program_m->get_realisasi_program($kode_program, $tahun_awal, $tahun_akhir);
		if (sizeof($data)>0) {
			foreach ($data as $dt) {
				$table_header .= "<th>".$dt->tahun."</th>";
				$row_pagu .= '<td>'.$this->template->cek_tipe_numerik($dt->pagu).'</td>'; $sum_pagu += $dt->pagu;
				$row_realisasi .= '<td>'.$this->template->cek_tipe_numerik($dt->realisasi).'</td>'; $sum_realisasi += $dt->realisasi;
				$row_dayaserap .= '<td>'.$this->template->cek_tipe_numerik($dt->persen).'</td>'; 
				$sum_dayaserap += $dt->persen;
				$j++;
				$dRatarata[] = array('tahun'	=> $dt->tahun,
									 'persen'	=> $this->template->cek_tipe_numerik($dt->persen));
			}
		}
		$table_header .= '<th>Rata-rata</th></tr></thead>';
		$row_pagu .= '<td>'.$this->template->cek_tipe_numerik(($sum_pagu/$j)).'</td></tr>';
		$row_realisasi .= '<td>'.$this->template->cek_tipe_numerik(($sum_realisasi/$j)).'</td></tr>';
		$row_dayaserap .= '<td>'.$this->template->cek_tipe_numerik(($sum_dayaserap/$j)).'</td></tr></tbody>';
		
		if($tipe=="html"):
			echo $table_header.$row_pagu.$row_realisasi.$row_dayaserap;
		else:
			return $table_header.$row_pagu.$row_realisasi.$row_dayaserap;
		endif;
	}

	function get_tabel_capaian_kinerja($tahun_awal, $tahun_akhir, $kode_e1,$tipe="html") 
	{
		$totalThn = 0;
		for($a=$tahun_awal; $a<=$tahun_akhir;$a++):
			$totalThn++;
		endfor;
		
		$widhtRowSS = '';
		$widthRowIKU= '';
		$widthRowDt	= "";
		$widthRowDt2= "";
		$widthRowRt	= "";
		
		if($tipe=="get"):
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
		endif;
		
		/*$data = $this->program_m->get_capaian_kinerja($kode_e1, $tahun_awal, $tahun_akhir);
		echo "<pre>";
		print_r($data);
		exit;*/
		
		$thead = '<thead><tr><th rowspan="2" '.$widhtRowSS.'>Sasaran Program</th><th rowspan="2" '.$widthRowIKU.'>Indikator</th><th rowspan="2">Satuan</th>';
		$tbody = '<tbody>';
		$j = 0; $thn = 0; $firstrow = 1; $countrow = 0; $temprow = ''; $sum_program = 0;
		$data = $this->program_m->get_capaian_kinerja($kode_e1, $tahun_awal, $tahun_akhir);
		$ldata = sizeof($data);
		$kd_iku_e1 = '';
		if ($ldata>0) {
			foreach ($data as $dt) {
				if ($dt->kode_iku_e1!=$kd_iku_e1)
					$rowspan[$dt->kode_sp_e1]=(!isset($rowspan[$dt->kode_sp_e1]))?1:$rowspan[$dt->kode_sp_e1]+1;
				$kd_iku_e1 = $dt->kode_iku_e1;
			}
			foreach ($data as $dt) {
				$temprow .= "<td>".(is_numeric($dt->target)?$this->template->cek_tipe_numerik($dt->target):$this->template->cek_tipe_numerik($dt->target))."</td><td>"
					.(is_numeric($dt->realisasi)?$this->template->cek_tipe_numerik($dt->realisasi):$this->template->cek_tipe_numerik($dt->realisasi))."</td><td>"
					.number_format($dt->persen,2,',','.')."</td>"; 
				$sum_program += $dt->persen; $thn++;
				$sum_tahun[$dt->tahun][] = $dt->persen;			
				if (($j+1==$ldata) || $dt->kode_iku_e1!=$data[$j+1]->kode_iku_e1) {
					$temprow = '<td>'.$dt->indikator.'</td><td>'.$dt->satuan.'</td>'.$temprow;
					$temprow .= '<td>'.$this->template->cek_tipe_numerik(($sum_program/$thn)).'</td></tr>';
					$thn = 0; $sum_program = 0;
					if ($firstrow==1) $temprow = '<tr><td rowspan="'.($rowspan[$dt->kode_sp_e1]).'">'.$dt->deskripsi.'</td>'.$temprow;
						else $temprow ='<tr>'.$temprow;
					$tbody .= $temprow;
					$temprow = '';
					$firstrow++;
					$countrow++;
				}
				if (($j+1==$ldata) || ($dt->kode_sp_e1!= $data[$j+1]->kode_sp_e1)) $firstrow = 1;
				$j++;
			}
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
		foreach ($datasum as $k => $val) {
			$thead .= '<th colspan="3" style="text-align:center;'.$widthRowDt.'">'.$k.'</th>';
		 	$temp_thead .= '<th>Target</th><th>Realisasi</th><th>Persen</th>';
		 	$tbody .= '<td></td><td></td><td>'.$this->template->cek_tipe_numerik(($val/$countrow)).'</td>'; 
			$totalRata2 = $totalRata2+($val/$countrow);
		}
		$thead .= '<th rowspan="2">Rata-rata<br>%</th></tr>'.$temp_thead.'</tr></thead>';
		$tbody .= '<td>'.$this->template->cek_tipe_numerik(($totalRata2/count($datasum))).'</td></tr></tbody>';
		
		if($tipe=="html"):
			echo $thead.$tbody;
		else:
			return $thead.$tbody;
			#return $thead;
		endif;
	}
	
	function print_tabel_program($tahun1,$tahun2,$program)
	{
		$dataProgram = json_decode($this->get_kegiatan_pelaksana_program($program,"get"),true);
		$kegiatan	 = $dataProgram['kegiatan'];
		$dataCapaian = $this->get_tabel_capaian_kinerja($tahun1,$tahun2,$dataProgram['pelaksana']['kode_e1'],"get");
		$dataSerapan = $this->get_tabel_serapan_anggaran($tahun1,$tahun2,$program,"get");
		
		$tabelCapaian  = '<table style="width:750px;" border="1" cellpadding="4" cellspacing="0">';
		$tabelCapaian .= $dataCapaian;
		$tabelCapaian .= '</table>';
		
		$tabelSerapan  = '<table style="width:750px;" border="1" cellpadding="4" cellspacing="0">';
		$tabelSerapan .= $dataSerapan;
		$tabelSerapan .= '</table>';
			
		$tabel = '<page format="A4"><table border="0" cellpadding="4" cellspacing="0">';
		$tabel .= '<tr><td valign="top" style="width:120px;"><b>Nama Kegiatan</b></td><td>';
			
			$tabel .= '<ol>';
			foreach($kegiatan as $k):
				$tabel .= '<li>'.$k.'</li>';
			endforeach;
			$tabel .= '</ol>';
			
		$tabel .= '</td></tr>';
		$tabel .= '<tr><td><b>Pelaksana Program</b></td><td><p style="margin-left:30px;">'.$dataProgram['pelaksana']['nama_e1'].'</p></td></tr>';
		$tabel .= '<tr><td colspan="2"><b>Capaian Kinerja</b></td></tr>';
		$tabel .= '<tr><td colspan="2">'.$tabelCapaian.'</td></tr>';
		$tabel .= '<tr><td colspan="2"><b>Serapan Anggaran</b></td></tr>';
		$tabel .= '<tr><td colspan="2">'.$tabelSerapan.'</td></tr>';
		$tabel .= '</table></page>';
			
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', FALSE, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Capaian Program');
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
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage('L');
		//var_dump($e1);
		 $pdf->Write(0, 'Analisis dan Evaluasi Capaian Program ', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);
				
		$pdf->writeHTML($tabel, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('Capaian_program.pdf', 'I');
	}
	
	function print_tabel_program_excel($tahun_awal,$tahun_akhir,$kode_program)
	{
		$pelaksana	= $this->program_m->get_pelaksana_program($kode_program);
		$kegiatan	= $this->program_m->get_kegiatan_program($kode_program);
		$kode_e1	= $pelaksana->kode_e1;
		
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Program');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->mergeCells('A1:R1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'Analisis dan Evaluasi Capaian Program ');
		
		$this->excel->getActiveSheet()->mergeCells('A2:R2');
		
		$this->excel->getActiveSheet()->mergeCells('A3:B3');
		$this->excel->getActiveSheet()->mergeCells('A3:A'.(2+count($kegiatan)));
		$this->excel->getActiveSheet()->setCellValue('A3', 'Nama Kegiatan');
		
		$rowExcel = 3;
		if(count($pelaksana)!=0):
			foreach($kegiatan as $k):
				$this->excel->getActiveSheet()->mergeCells('C'.$rowExcel.':R'.$rowExcel);
				$this->excel->getActiveSheet()->setCellValue('C'.$rowExcel, $k);
				$rowExcel++;				
			endforeach;
		endif;
		
		$this->excel->getActiveSheet()->mergeCells('A'.$rowExcel.':B'.$rowExcel);
		$this->excel->getActiveSheet()->setCellValue('A'.$rowExcel, "Pelaksana Kegiatan");
		$this->excel->getActiveSheet()->mergeCells('C'.$rowExcel.':R'.$rowExcel);
		$this->excel->getActiveSheet()->setCellValue('C'.$rowExcel, $pelaksana->nama_e1);
		
		$rowExcel = $rowExcel+1;
		$this->excel->getActiveSheet()->mergeCells('A'.$rowExcel.':R'.$rowExcel);
		$this->excel->getActiveSheet()->setCellValue('A'.$rowExcel, "Capaian Kinerja");
		$this->excel->getActiveSheet()->mergeCells('A'.($rowExcel+1).':R'.($rowExcel+1));
		$rowExcel = $rowExcel+2;
		
		$j = 0; $thn = 0; $firstrow = 1; $countrow = 0; $temprow = ''; $sum_program = 0;
		$data = $this->program_m->get_capaian_kinerja($kode_e1, $tahun_awal, $tahun_akhir);
		$ldata = sizeof($data);
		$kd_iku_e1 = '';
		if ($ldata>0) {
			foreach ($data as $dt) {
				if ($dt->kode_iku_e1!=$kd_iku_e1)
					$rowspan[$dt->kode_sp_e1]=(!isset($rowspan[$dt->kode_sp_e1]))?1:$rowspan[$dt->kode_sp_e1]+1;
				$kd_iku_e1 = $dt->kode_iku_e1;
			}
			foreach ($data as $dt) {
				$arrData[$dt->kode_iku_e1][] = array('target' 	=> $this->template->cek_tipe_numerik($dt->target),
													'realisasi'	=> $this->template->cek_tipe_numerik($dt->realisasi),
													'persen'	=> $this->template->cek_tipe_numerik($dt->persen));
									
				$sum_program += $dt->persen; $thn++;
				$sum_tahun[$dt->tahun][] = $dt->persen;	
						
				if (($j+1==$ldata) || $dt->kode_iku_e1!=$data[$j+1]->kode_iku_e1) {
					$arrRow[] = array('sasaran'		=> $dt->deskripsi,
									  'sasaran_row'	=> $rowspan[$dt->kode_sp_e1],
									  'indikator'	=> $dt->indikator,
									  'satuan'		=> $dt->satuan,
									  'arr_data'	=> $arrData[$dt->kode_iku_e1],
									  'rata2'		=> $this->template->cek_tipe_numerik(($sum_program/$thn)));
					$thn = 0; $sum_program = 0;
					
					$countrow++;
				}
				
				if (($j+1==$ldata) || ($dt->kode_sp_e1!= $data[$j+1]->kode_sp_e1)) $firstrow = 1;
				$j++;
			}
		}
		$total = 0;
		
		foreach ($sum_tahun as $k => $val):
			$total=0;
			foreach($val as $v):
				$total = $total+$v;
			endforeach;
			$datasum[$k] = $total;
		endforeach;
		
		$this->excel->getActiveSheet()->mergeCells('A'.$rowExcel.':A'.($rowExcel+1));
		$this->excel->getActiveSheet()->setCellValue('A'.$rowExcel, "Sasaran Program");
		
		$this->excel->getActiveSheet()->mergeCells('B'.$rowExcel.':B'.($rowExcel+1));
		$this->excel->getActiveSheet()->setCellValue('B'.$rowExcel, "Indikator");
		
		$this->excel->getActiveSheet()->mergeCells('C'.$rowExcel.':C'.($rowExcel+1));
		$this->excel->getActiveSheet()->setCellValue('C'.$rowExcel, "Satuan");
		
		$totalRata2 = 0;
		$no_abjad = 68;
		foreach ($datasum as $k => $val) {
			
			$this->excel->getActiveSheet()->mergeCells(chr($no_abjad).$rowExcel.':'.chr($no_abjad+2).$rowExcel);
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $k);
			
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).($rowExcel+1), "Target");
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad+1).($rowExcel+1), "Realisasi");
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad+2).($rowExcel+1), "Persen");
			
			$rata2pertahun[$k] = $this->template->cek_tipe_numerik(($val/$countrow));
			$totalRata2 = $totalRata2+($val/$countrow);
			$no_abjad = $no_abjad+3;
		}
			$this->excel->getActiveSheet()->mergeCells(chr($no_abjad).$rowExcel.':'.chr($no_abjad).($rowExcel+1));
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, "Rata-rata %");		
		$rowExcel = $rowExcel+2;
		
		$last_sasaran = "";
		foreach($arrRow as $ar):
			
			if($last_sasaran != $ar['sasaran']):
				if($ar['sasaran_row']!=1):
					$this->excel->getActiveSheet()->mergeCells("A".$rowExcel.':A'.($rowExcel+$ar['sasaran_row']));
				endif;
				$this->excel->getActiveSheet()->setCellValue("A".$rowExcel, $ar['sasaran']);
			endif;
			 
			 	$this->excel->getActiveSheet()->setCellValue("B".$rowExcel, $ar['indikator']);
				$this->excel->getActiveSheet()->setCellValue("C".$rowExcel, $ar['satuan']);
				
			$no_abjad = 68;
			foreach($ar['arr_data'] as $dt):
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $dt['target']);
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad+1).$rowExcel, $dt['realisasi']);
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad+2).$rowExcel, $dt['persen']);
				
				$no_abjad = $no_abjad+3;
			endforeach;
				
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $dt['persen']);
			$rowExcel++;
			#echo $ar['rata2']."<br><Br><br>";
			
			$last_sasaran = $ar['sasaran'];
		endforeach;
		
		$rowExcel=$rowExcel+1;
		$this->excel->getActiveSheet()->mergeCells("A".$rowExcel.':C'.$rowExcel);
		$this->excel->getActiveSheet()->setCellValue("A".$rowExcel, "Rata-rata Capaian Kinerja / Tahun");
			
		if(count($rata2pertahun)!=0):
			$no_abjad = 68;
			foreach($rata2pertahun as $rt2):
				$this->excel->getActiveSheet()->mergeCells(chr($no_abjad).$rowExcel.':'.chr($no_abjad+2).$rowExcel);
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $rt2);
				$no_abjad = $no_abjad+3;
			endforeach;
		endif;
			
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $this->template->cek_tipe_numerik(($totalRata2/count($datasum))));
	
		$rowExcel = $rowExcel+2;
		$this->excel->getActiveSheet()->mergeCells('A'.$rowExcel.':R'.$rowExcel);
		$this->excel->getActiveSheet()->setCellValue('A'.$rowExcel, "Serapan Anggaran");
		$this->excel->getActiveSheet()->mergeCells('A'.($rowExcel+1).':R'.($rowExcel+1));
		$rowExcel = $rowExcel+2;
		
		$this->excel->getActiveSheet()->setCellValue('A'.$rowExcel, "Uraian");
		
		$data = $this->program_m->get_realisasi_program($kode_program, $tahun_awal, $tahun_akhir);
		
		if (sizeof($data)>0):
			$no_abjad = 66;
			foreach ($data as $dt):
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $dt->tahun);
				$no_abjad++;
			endforeach;
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, "Rata-rata");
		endif;
		
		$rowExcel = $rowExcel+1;
		
		$j = 0; $sum_pagu = 0; $sum_realisasi = 0; $sum_dayaserap = 0;
		if (sizeof($data)>0) {
			foreach ($data as $dt) {
				$row_pagu[$j] = $this->template->cek_tipe_numerik($dt->pagu); 
					$sum_pagu += $dt->pagu;
					
				$row_realisasi[$j] = $this->template->cek_tipe_numerik($dt->realisasi);
					$sum_realisasi += $dt->realisasi;
				
				$row_dayaserap[$j] = $this->template->cek_tipe_numerik($dt->persen); 
					$sum_dayaserap += $dt->persen;
					
				$j++;
			}
		}
		
		if (sizeof($row_pagu)>0):
			$this->excel->getActiveSheet()->setCellValue("A".$rowExcel, "1. Pagu (Rp.) ");
			$no_abjad = 66;
			foreach($row_pagu as $dp):
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $dp);
				$no_abjad++;
			endforeach;
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $this->template->cek_tipe_numerik(($sum_pagu/$j)));
		endif;
		$rowExcel = $rowExcel+1;
		
		if(sizeof($row_realisasi)>0):
			$this->excel->getActiveSheet()->setCellValue("A".$rowExcel, "2. Realisasi (Rp.) ");
			$no_abjad = 66;
			foreach($row_realisasi as $rr):
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $rr);
				$no_abjad++;
			endforeach;	
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $this->template->cek_tipe_numerik(($sum_realisasi/$j)));
		endif;
		$rowExcel = $rowExcel+1;
		
		if(sizeof($row_dayaserap)>0):
			$this->excel->getActiveSheet()->setCellValue("A".$rowExcel, "3. Daya Serap (Rp.)");
			
			$no_abjad = 66;
			foreach($row_dayaserap as $rd):
				$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $rd);
				$no_abjad++;
			endforeach;	
			$this->excel->getActiveSheet()->setCellValue(chr($no_abjad).$rowExcel, $this->template->cek_tipe_numerik(($sum_dayaserap/$j)));
		endif;
		
		$filename='analisis_dan_evaluasi_capaian_program.xls'; 
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