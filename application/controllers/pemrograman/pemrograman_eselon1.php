<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-24 00:00
 @revision	 :
*/

class Pemrograman_eselon1 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/kl_model','kl');
		
		$this->load->model('/pemrograman/program_eselon1_model','program_e1');
		$this->load->model('/pemrograman/sasaran_program_model','sasaran');
		$this->load->model('/pemrograman/iku_eselon1_model','iku');
		$this->load->model('/admin/tahun_renstra_model','setting_th');
	/*	$this->load->model('/pemrograman/tujuan_kl_model','tujuan');
		*/
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		//$setting = null;
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
		$template['konten']	= $this->load->view('pemrograman/pemrograman_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadprogram()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('pemrograman/program_kl_v',$data,true); #load konten template file		
	}
	
	function get_body_program($tahun,$kode){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode;
		$data=$this->program_e1->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->tahun.'</td>
					<td>'.$d->kode_program.'</td>
					<td>'.$d->nama_program.'</td>					
					<td>'.number_format($d->pagu,0,'.','.').'</td>
					<td>'.number_format($d->realisasi,0,'.','.').'</td>
					<td>'.$d->persen.'</td>
				</tr>';
				endforeach; 
				/*<td>
						<a href="#programModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="program_edit(\''.$d->tahun.'\',\''.$d->kode_program.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="program_delete(\''.$d->tahun.'\',\''.$d->kode_program.'\');"><i class="fa fa-times"></i></a>
					</td>*/
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="6" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function loadsasprog()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		echo $this->load->view('pemrograman/sasaran_program_v',$data,true); #load konten template file		
	}
	
	function get_body_sasaran($tahun,$kode){
		$params['tahun_renstra'] = 	$tahun;
		if($kode!=0)$params['kode_e1'] = 	$kode;
		$data=$this->sasaran->get_all($params); 
		$rs = '';
		if (isset($data)){
			$prevUK=""; $no=1;
			foreach($data as $d): 
				if($prevUK!=$d->nama_e1): $namaUK = $d->nama_e1; $no=1; else: $namaUK = ""; endif;
				$prevUK = $d->nama_e1;
				$rs .= '<tr class="gradeX">
					<td>'.$namaUK.'</td>
					<td>'.$no.'</td>
					<td width="25%">'.$d->sastra_deskripsi.'</td>
					<td width="8%">'.$d->kode_sp_e1.'</td>					
					<td>'.$d->deskripsi.'</td>
				</tr>';
				$no++;
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="5" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function loadiku()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('pemrograman/iku_eselon1_v',$data,true); #load konten template file		
	}
	function get_body_iku($tahun,$kode){
		$params['tahun_renstra'] = 	$tahun;
		if($kode!=0)$params['kode_e1'] = 	$kode;
		$data=$this->iku->get_all($params); 
		$rs = '';
		if (isset($data)){
			$prevUK=""; $no=1;
			foreach($data as $d): 
				if($prevUK!=$d->nama_e1): $namaUK = $d->nama_e1; $no=1; else: $namaUK = ""; endif;
				$prevUK = $d->nama_e1;
				$rs .= '<tr class="gradeX">
					<td>'.$namaUK.'</td>
					<td>'.$no.'</td>
					<td>'.$d->sasprog_deskripsi.'</td>
					<td>'.$d->kode_iku_e1.'</td>
					<td>'.$d->deskripsi.'</td>					
					<td>'.$d->satuan.'</td>
				</tr>';
				$no++;
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="6" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function loadpendanaan()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = null;//$this->sasaran->get_all(null);
		echo $this->load->view('pemrograman/pendanaan_kl_v',$data,true); #load konten template file		
	}
	
	
	function get_unit_kerja($kl){
		$data = $this->eselon1->get_all(array("kode_kl"=>$kl));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->nama_e1.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function get_fungsi($tahun,$kl){
		$data = $this->fungsi_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->fungsi_kl.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function get_tugas($tahun,$kl){
		$data = $this->kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->tugas_kl.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	
}