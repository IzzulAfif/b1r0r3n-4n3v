<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-24 00:00
 @revision	 :
*/

class Pemrograman_eselon2 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/unit_kerja/kl_model','kl');
		
		$this->load->model('/pemrograman/kegiatan_eselon2_model','kegiatan');
		$this->load->model('/pemrograman/sasaran_kegiatan_model','sasaran');
		$this->load->model('/pemrograman/ikk_model','iku');
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
		$template['konten']	= $this->load->view('pemrograman/pemrograman_eselon2_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadkegiatan()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('pemrograman/kegiatan_eselon2_v',$data,true); #load konten template file		
	}
	
	function get_body_kegiatan($tahun,$kode_e1,$kode_e2){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode_e1;
		if($kode_e2!=0)$params['kode_e2'] = 	$kode_e2;
		$data=$this->kegiatan->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->nama_e2.'</td>
					<td>'.$d->nama_program.'</td>
					<td>'.$d->kode_kegiatan.'</td>
					<td>'.$d->nama_kegiatan.'</td>
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="6" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
		
	function loadsaskeg()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('pemrograman/sasaran_kegiatan_v',$data,true); #load konten template file		
	}
	
	function get_body_sasaran($tahun,$kode_e1,$kode_e2){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode_e1;
		if($kode_e2!=0)$params['kode_e2'] = 	$kode_e2;
		$data=$this->sasaran->get_all($params); 
		$rs = '';
		if (isset($data)){
			$prevUk=""; $no=1;
			foreach($data as $d):
				if($prevUk!=$d->nama_e2): $namaUK = $d->nama_e2; $no=1; else: $namaUK = ""; endif; 
				$prevUk = $d->nama_e2; 
				$rs .= '<tr class="gradeX">
					<td>'.$namaUK.'</td>
					<td>'.$no.'</td>
					<td>'.$d->kode_sk_e2.'</td>					
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
	
	
	function loadikk()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		echo $this->load->view('pemrograman/ikk_v',$data,true); #load konten template file		
	}
	
	function get_body_ikk($tahun,$kode_e1,$kode_e2){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode_e1;
		if($kode_e2!=0)$params['kode_e2'] = 	$kode_e2;
		$data=$this->iku->get_all($params); 
		$rs = '';
		if (isset($data)){
			$prevUk=""; $no=1;
			foreach($data as $d): 
				if($prevUk!=$d->nama_e2): $namaUK = $d->nama_e2; $no=1; else: $namaUK = ""; endif; 
				$prevUk = $d->nama_e2;
				$rs .= '<tr class="gradeX">
					<td>'.$namaUK.'</td>
					<td>'.$no.'</td>
					<td>'.$d->kode_ikk.'</td>
					<td>'.$d->deskripsi.'</td>
					<td>'.$d->satuan.'</td>
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
	
	function loadpendanaan()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = null;//$this->sasaran->get_all(null);
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('pemrograman/pendanaan_kl_v',$data,true); #load konten template file		
	}
	
	
	function get_list_eselon2($kode_e1)
	{
		$params = array("kode_e1"=>$kode_e1);
		echo json_encode($this->eselon2->get_list($params));
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