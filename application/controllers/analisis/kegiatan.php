<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-08-24 00:00
 @revision	 : 2014-09-01 --> melanjutkan
*/

class Kegiatan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('analisis/analisis_model','',TRUE);
		$this->load->model('admin/lokasi_model','lokasi',TRUE);
		$this->load->model('analisis/kegiatan_model','kegiatan',TRUE);
	}
	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "ANALISIS");
		$setting['page']	= array('pg_aktif'	=> "map");
		$template			= $this->template->load($setting); #load static template file
		
		$data				= "";
		$template['konten']	= $this->load->view('analisis/kegiatan',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function data()
	{
		$data = null;
		$data['lokasi'] = $this->lokasi->get_list(null);
		$this->load->view('analisis/data_kegiatan',$data);
	}
	
	function get_program($tahun)
	{
		$result	= $this->kegiatan->get_program($tahun);
		echo json_encode($result);
	}
	
	function get_kegiatan($tahun,$program)
	{
		$result	= $this->kegiatan->get_kegiatan($tahun,$program);
		echo json_encode($result);
	}
	
	function get_list_rincian($tahun,$kode_program,$kode_kegiatan,$kdlokasi)
	{
		$params['tahun'] = $tahun;
		$params['kode_program'] = $kode_program;
		$params['kode_kegiatan'] = $kode_kegiatan;
		$params['kdlokasi'] = $kdlokasi;
		
		$data	= $this->kegiatan->get_rincian_paket_pekerjaan($params);
	
		$rs = '';$i=1;
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.($i++).'</td>
					<td>'.$d->nmitem.'</td>
					<td align="right">'.$this->utility->cekNumericFmt($d->volkeg).'</td>					
					<td>'.$d->satkeg.'</td>					
					<td>'.$d->nama_kabkota.'</td>					
					<td>'.$d->nama_status.'</td>					
					
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
		}
		echo $rs;
	}
	
	function map()
	{
		$data = null;
		$this->load->view('analisis/map_kegiatan',$data);
	}
}