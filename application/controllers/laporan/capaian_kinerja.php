<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup
 @date       : 2014-09-02 00:00
 @revision	 :
*/

class Capaian_kinerja extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
	}
	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "chart");
		$template			= $this->template->load($setting); #load static template file
		
		$data				= "";
		$template['konten']	= $this->load->view('laporan/capaian_kinerja_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	
	function get_capaian($tahun_awal,$tahun_akhir,$kode,$sasaran){
		$params['tahun_awal'] = 	$tahun_awal;
		$params['tahun_akhir'] = 	$tahun_akhir;
		if ($kode!="0")
			$params['kode_e1'] = 	$kode;
		$data=$this->eselon1->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->kode_e1.'</td>
					<td>'.$d->nama_e1.'</td>					
					<td>'.$d->singkatan.'</td>					
					<td>'.$d->tugas_e1.'</td>					
					<td>
						<a href="#identitasModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="identitasEdit(\''.$d->tahun_renstra.'\',\''.$d->kode_e1.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="identitasDelete(\''.$d->tahun_renstra.'\',\''.$d->kode_e1.'\');"><i class="fa fa-times"></i></a>
					</td>
				</tr>';
				endforeach; 
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
}