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
	
	function get_kegiatan_pelaksana_program($kode_program)
	{
		 echo json_encode(array(
		 	'pelaksana'=>$this->program_m->get_pelaksana_program($kode_program),
		 	'kegiatan'=>$this->program_m->get_kegiatan_program($kode_program)
		));
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
	
	function get_tabel_serapan_anggaran($tahun_awal, $tahun_akhir, $kode_program)
	{
		$table_header = '<thead><th>Uraian</th>';
		$row_pagu = '<tbody><tr><td>1. Pagu (Rp.)</td>';
		$row_realisasi = '<tr><td>2. Realisasi (Rp.)</td>';
		$row_dayaserap = '<tr><td>3. Daya Serap (%)</td>';
		$j = 0; $sum_pagu = 0; $sum_realisasi = 0; $sum_dayaserap = 0;
		$data = $this->program_m->get_realisasi_program($kode_program, $tahun_awal, $tahun_akhir);
		if (sizeof($data)>0) {
			foreach ($data as $dt) {
				$table_header .= "<th>".$dt->tahun."</th>";
				$row_pagu .= '<td>'.number_format($dt->pagu,2,',','.').'</td>'; $sum_pagu += $dt->pagu;
				$row_realisasi .= '<td>'.number_format($dt->realisasi,2,',','.').'</td>'; $sum_realisasi += $dt->realisasi;
				$row_dayaserap .= '<td id="agr-'.$dt->tahun.'">'.number_format($dt->persen,2,',','.').'</td>'; $sum_dayaserap += $dt->persen;
				$j++;
				$dRatarata[] = array('tahun'	=> $dt->tahun,
									 'persen'	=> number_format($dt->persen,2,'.','.'));
			}
		}
		$table_header .= '<th>Rata-rata</th><thead>';
		$row_pagu .= '<td>'.number_format(($sum_pagu/$j),2,',','.').'</td></tr>';
		$row_realisasi .= '<td>'.number_format(($sum_realisasi/$j),2,',','.').'</td></tr>';
		$row_dayaserap .= '<td>'.number_format(($sum_dayaserap/$j),2,',','.').'</td></tr></tbody>';
		
		echo $table_header.$row_pagu.$row_realisasi.$row_dayaserap;
	}

	function get_tabel_capaian_kinerja($tahun_awal, $tahun_akhir, $kode_e1) 
	{
		$thead = '<thead><th rowspan="2" width="20%">Sasaran Program</th><th rowspan="2" width="20%">Indikator</th><th rowspan=2>Satuan</th>';
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
					$temprow .= '<td>'.number_format(($sum_program/$thn),2,',','.').'</td></tr>';
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
	}
}