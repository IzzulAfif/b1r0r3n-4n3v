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
		$setting['page']	= array('pg_aktif'	=> "keuangan");
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
	
	function get_body_kl_keu($renstra,$tahun1,$tahun2)
	{
		$data	=	$this->keuangan->get_kl_keu($renstra,$tahun1,$tahun2);
		
		$table  = '<table class="display table table-bordered table-striped" border="1">';
		$table .= '<thead>
            		<tr>
                		<th width="3%">No</th>
                		<th>Program</th>
                		<th>Uraian</th>
						<th>2010</th>
						<th>2011</th>
						<th>2012</th>
						<th>2013</th>
						<th>2014</th>';
				/*for($a=$tahun1; $a<=$tahun2; $a++):
					$table .= '<th>'.$a.'</th>';
				endfor;*/
		$table .= '<th>Total</th></tr></thead>';
		$table .= '<tbody>';
			
			$no=1;
			foreach($data as $d):
				
					$table .= '<tr><td rowspan="3">'.$no.'</td><td rowspan="3">'.$d->nama_program.'</td>';
					$table .= '<td>Target Renstra</td>';
						$table .= '<td>'.number_format($d->target_thn1,0,',','.').'</td>';
						$table .= '<td>'.number_format($d->target_thn2,0,',','.').'</td>';
						$table .= '<td>'.number_format($d->target_thn3,0,',','.').'</td>';
						$table .= '<td>'.number_format($d->target_thn4,0,',','.').'</td>';
						$table .= '<td>'.number_format($d->target_thn5,0,',','.').'</td>';
						$total = $d->target_thn1+$d->target_thn2+$d->target_thn3+$d->target_thn4+$d->target_thn5;
						$table .= '<td>'.number_format($total,0,',','.').'</td>';
					$table .= '</tr>';
					
					$detail_keu = $this->keuangan->get_detail_keu($tahun1,$tahun2,$d->kode_program);
					
					$table .= '<tr><td>Pagu</td><td>-</td>';
					$totalpagu=0;
					foreach($detail_keu as $dk):
						$table .='<td>'.number_format($dk->pagu,0,',','.')."</td>";
						$totalpagu = $totalpagu+$dk->pagu;
					endforeach;
					$table .='<td>-</td><td>'.number_format($totalpagu,0,',','.').'</td></tr>';
					
					$table .= '<tr><td>Realisasi</td><td>-</td>';
					$totalrealisasi=0;
					foreach($detail_keu as $dk):
						$table .='<td>'.number_format($dk->realisasi,0,',','.')."</td>";
						$totalrealisasi = $totalrealisasi+$dk->realisasi;
					endforeach;
					$table .='<td>-</td><td>'.number_format($totalrealisasi,0,',','.').'</td></tr>';
					
				$no++;					
			endforeach;
		
		$table .= '</tbody>';
		$table .= "</table>";
		echo $table;
	}
}