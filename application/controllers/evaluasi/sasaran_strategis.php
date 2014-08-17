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
	}

	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "EVALUASI");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file
		
		$data['renstra']	= $this->sasaran_strategis_m->get_renstra_list();;#kirim data ke konten file
		$template['konten']	= $this->load->view('evaluasi/sasaran_strategis_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function get_sasaran($tahun_renstra)
	{
		echo json_encode($this->sasaran_strategis_m->get_sasaran_list($tahun_renstra));
	}
	
	function get_tabel_capaian_kinerja($tahun_awal, $tahun_akhir, $kode_sasaran_kl) 
	{
		$thead = '<thead><th rowspan=2>Sasaran Program</th><th rowspan=2>Indikator</th><th rowspan=2>Satuan</th>';
		$tbody = '<tbody>';
		$j = 0; $thn = 0; $firstrow = 1;
		$data = $this->sasaran_strategis_m->get_capaian_kinerja($kode_sasaran_kl, $tahun_awal, $tahun_akhir);
		$ldata = sizeof($data);
		$kd_iku_e1 = '';
		foreach ($data as $dt) {
			if ($dt->kode_iku_kl!=$kd_iku_e1)
				$rowspan[$dt->kode_ss_kl]+=1;
			$kd_iku_e1 = $dt->kode_iku_kl;
		}

		foreach ($data as $dt) {
			$temprow .= "<td>".$dt->target."</td><td>".$dt->realisasi."</td><td>".$dt->persen."</td>"; $sum_program += $dt->persen; $thn++;
			$sum_tahun[$dt->tahun] = $dt->persen;			
			if ($j+1<=$ldata) {

				if ($dt->kode_iku_kl!=$data[$j+1]->kode_iku_kl) {
					$temprow = '<td>'.$dt->indikator.'</td><td>'.$dt->satuan.'</td>'.$temprow;
					$temprow .= '<td>'.($sum_program/$thn).'</td><td></td></tr>';
					$thn = 0;
					if ($firstrow==1) $temprow = '<tr><td rowspan='.($rowspan[$dt->kode_ss_kl]).'>'.$dt->deskripsi.'</td>'.$temprow;
						else $temprow ='<tr>'.$temprow;
					$tbody .= $temprow;
					$temprow = '';
					$firstrow++;
				}
				if ($dt->kode_ss_kl!= $data[$j+1]->kode_ss_kl) $firstrow = 1;
			}
			$j++;
		}
		$tbody .= '<tr><td colspan=3>Rata-rata Capaian Kinerja / Tahun</td>';
		$temp_thead = '<tr>';
		$total = 0;
		foreach ($sum_tahun as $k => $val) {
			$thead .= "<th colspan=3>".$k."</th>";
		 	$temp_thead .= '<th>Target</th><th>Realisasi</th><th>Persen</th>';
		 	$tbody .= '<td></td><td></td><td>'.($val/$j).'</td>'; $total +=$val/$j;
		}
		$thead .= "<th rowspan=2>Rata-rata<br>%</th><th rowspan=2></th></th></tr>".$temp_thead.'</tr></thead>';
		$tbody .= '<td>'.$total/(sizeof($sum_tahun)).'</td><td></td></tr></tbody>';
		echo $thead.$tbody;
	}
}