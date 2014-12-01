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
	}

	function index()
	{
		$data['renstra']	= $this->program_m->get_renstra_list();
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
		$thead = '<thead><tr><th rowspan="2">Sasaran Program</th><th rowspan="2">Indikator</th><th rowspan="2">Satuan</th>';
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
				$temprow .= "<td>".(is_numeric($dt->target)?$dt->target:$dt->target)."</td><td>"
					.(is_numeric($dt->realisasi)?$dt->realisasi:$dt->realisasi)."</td><td>"
					.number_format($dt->persen,2,',','.')."</td>"; 
				$sum_program += $dt->persen; $thn++;
				$sum_tahun[$dt->tahun][] = $dt->persen;			
				if (($j+1==$ldata) || $dt->kode_iku_e1!=$data[$j+1]->kode_iku_e1) {
					$temprow = '<td>'.$dt->indikator.'</td><td>'.$dt->satuan.'</td>'.$temprow;
					$temprow .= '<td>'.$this->template->cek_tipe_numerik(($sum_program/$thn)).'</td></tr>';
					$thn = 0; $sum_program = 0;
					if ($firstrow==1) $temprow = '<tr><td rowspan='.($rowspan[$dt->kode_sp_e1]).'>'.$dt->deskripsi.'</td>'.$temprow;
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
			$thead .= '<th colspan="3">'.$k.'</th>';
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
		 $pdf->Write(0, 'Analisis dan Evaluasi Capaian Program ', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);
				
		$pdf->writeHTML($tabel, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('Capaian_program.pdf', 'I');
	}
}