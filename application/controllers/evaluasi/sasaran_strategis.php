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
		echo json_encode($this->sasaran_strategis_m->get_sasaran_list($tahun_renstra));
	}
	
	function get_tabel_capaian_kinerja($tahun_awal, $tahun_akhir, $kode_sasaran_kl) 
	{
		
		$thead = '<thead><th rowspan=2>Sasaran Strategis</th><th rowspan=2>Indikator</th><th rowspan=2>Satuan</th>';
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