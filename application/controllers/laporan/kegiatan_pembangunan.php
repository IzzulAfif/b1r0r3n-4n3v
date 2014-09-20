<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup
 @date       : 2014-09-20 00:00
 @revision	 :
*/

class Kegiatan_pembangunan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('analisis/analisis_model','',TRUE);
		$this->load->model('admin/lokasi_model','lokasi',TRUE);
		$this->load->model('admin/tahun_renstra_model','tahun_renstra',TRUE);
		$this->load->model('analisis/kegiatan_model','kegiatan',TRUE);
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/pemrograman/sasaran_strategis_model','sastra');
	}
	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "map");
		$template			= $this->template->load($setting); #load static template file
		
		$data['tahun_renstra']				= $this->tahun_renstra->get_list(null);
		$data['eselon1'] = $this->eselon1->get_list(array("check_locking"=>false));
		$data['kelompok_indikator'] = array();
		$data['lokasi'] = $this->lokasi->get_list(null);
		$template['konten']	= $this->load->view('laporan/kegiatan_pembangunan_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	function get_list_eselon1()
	{
		$params = array("check_locking"=>false);
		echo json_encode($this->eselon1->get_list($params));
	}
	
	function get_list_eselon2($kode_e1)
	{
		$params = array("kode_e1"=>$kode_e1);
		echo json_encode($this->eselon2->get_list($params));
	}
	
	
	function get_sastra($tahun)
	{		
		$result	= $this->sastra->get_list(array("tahun_renstra"=>$tahun));
		echo json_encode($result);
	}
	
	function get_kegiatan($tahun,$program)
	{
		$result	= $this->kegiatan->get_kegiatan($tahun,$program);
		echo json_encode($result);
	}
	
	function get_list_rincian($tahun,$indikator,$kode_e1,$kode_e2,$kdlokasi)
	{
		$params['tahun_renstra'] = $tahun;
		$params['indikator'] = $indikator;
		$params['kode_e1'] = $kode_e1;
		$params['kode_e2'] = $kode_e2;
		$params['kdlokasi'] = $kdlokasi;
		
		$data	= $this->kegiatan->get_detil_belanja($params);
		$totalPagu = 0;
		$rs = '';$i=1;
		if (isset($data)){
			foreach($data as $d): 
				$totalPagu += $d->jumlah;
				$rs .= '<tr class="gradeX">
					<td>'.($i++).'</td>
					<td>'.$d->tahun.'</td>
					<td>'.$d->nmitem.'</td>
					<td align="right">'.$this->utility->cekNumericFmt($d->volkeg).'</td>					
					<td align="right">'.$this->utility->cekNumericFmt($d->hargasat).'</td>					
					<td>'.$d->satkeg.'</td>					
					<td align="right">'.$this->utility->cekNumericFmt($d->jumlah).'</td>					
					
					
				</tr>';
				endforeach; 
				$rs .= '<tr class="gradeX">
					<td colspan="6" align="right">Total Pagu</td>
					<td align="right">'.$this->utility->cekNumericFmt($totalPagu).'</td>					
					
					
				</tr>';
		} else {
			$rs .= '<tr class="gradeX">
				<td>&nbsp;</td>
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