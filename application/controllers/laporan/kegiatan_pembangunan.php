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
		$this->load->model('pemrograman/kegiatan_eselon2_model','kegiatan',TRUE);
		$this->load->model('laporan/kegiatan_pembangunan_model','pembangunan',TRUE);
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/pemrograman/sasaran_strategis_model','sastra');
		$this->load->model('/pemrograman/program_eselon1_model','program');
		$this->load->model('/admin/kel_indikator_model','kel_indikator');
		
	}
	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "map");
		$template			= $this->template->load($setting); #load static template file
		
		$data['tahun_renstra']				= $this->tahun_renstra->get_list(null);
		$data['eselon1'] = $this->eselon1->get_list(array("check_locking"=>false));
		$data['kelompok_indikator'] = $this->kel_indikator->get_list(null);
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
		$result	= $this->sastra->get_list(array("tahun"=>$tahun));
		echo json_encode($result);
	}
	
	function get_program($tahun)
	{		
		$result	= $this->program->get_list(array("tahun"=>$tahun));
		echo json_encode($result);
	}
	
	function get_kegiatan($tahun,$program)
	{
		$result	= $this->kegiatan->get_list(array("tahun"=>$tahun,"kode_program"=>$program));
		echo json_encode($result);
	}
	
	function get_list_rincian($tahun,$indikator,$kode_program,$kode_kegiatan,$kdlokasi)
	{
		$params['tahun'] = $tahun;
		$params['indikator'] = $indikator;
		$params['kode_program'] = $kode_program;
		$params['kode_kegiatan'] = $kode_kegiatan;
		$params['kdlokasi'] = $kdlokasi;
		
		$data	= $this->pembangunan->get_detil_belanja($params);
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
					<td>'.$d->satkeg.'</td>';
					//sementara hide dulu coz blm ada data nya
					/*<td align="right">'.$this->utility->cekNumericFmt($d->hargasat).'</td>					
					<td align="right">'.$this->utility->cekNumericFmt($d->jumlah).'</td>					
					
					
				</tr>';*/
				endforeach; 
				/*$rs .= '<tr class="gradeX">
					<td colspan="6" align="right">Total Pagu</td>
					<td align="right">'.$this->utility->cekNumericFmt($totalPagu).'</td>					
					
					
				</tr>';*/
		} else {
			$rs .= '<tr class="gradeX">
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