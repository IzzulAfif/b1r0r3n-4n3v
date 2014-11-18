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
		$this->load->model('/pemrograman/target_capaian_model','target');
		$this->load->model('analisis/keuangan_model','keuangan',TRUE);
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
		$data['page']		= "e1";
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
	
	function loadtarget()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		$data['page']		= "e1";
		echo $this->load->view('pemrograman/target_capaian_e1_v',$data,true); #load konten template file		
	}
	
	function get_body_target($tahun,$sasaran){
		$params['tahun_renstra'] = 	$tahun;
		if($sasaran!="0")$params['sasaran'] = $sasaran;
		
		$data=$this->target->get_e1($params); 
		$rs = '';
		if (isset($data)){
			$no=1;
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td width="3%">'.$no.'</td>
					<td>'.$d->kode_iku_e1.'</td>					
					<td width="20%">'.$d->deskripsi.'</td>
					<td>'.$d->satuan.'</td>					
					<td width="10%">'.$this->cek_tipe_numerik($d->target_thn1).'</td>					
					<td width="10%">'.$this->cek_tipe_numerik($d->target_thn2).'</td>					
					<td width="10%">'.$this->cek_tipe_numerik($d->target_thn3).'</td>					
					<td width="10%">'.$this->cek_tipe_numerik($d->target_thn4).'</td>					
					<td width="10%">'.$this->cek_tipe_numerik($d->target_thn5).'</td>
				</tr>';
				$no++;
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="10" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
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
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		$data['page']		= "e1";
		echo $this->load->view('pemrograman/dana_kl_v',$data,true); #load konten template file		
	}	
	
	function add_keuangan_kl_form()
	{
		$data['renstra']	= $this->setting_th->get_list();
		$data['program']	= $this->keuangan->get_program_e1();
		$this->load->view('pemrograman/keuangan_kl_form',$data); #load konten template file
	}
	
	function save_keuangan_kl()
	{
		$renstra	 = $this->input->post("renstra");
		$program	 = $this->input->post("program");
		$target1	 = $this->input->post("target1");
		$target2	 = $this->input->post("target2");
		$target3	 = $this->input->post("target3");
		$target4	 = $this->input->post("target4");
		$target5	 = $this->input->post("target5");
		$kodee1		 = $this->mgeneral->getValue("kode_e1",array('kode_program'=>$program),"anev_program_eselon1");
		
		$varData = array('tahun_renstra'	=> $renstra,
						 'kode_e1'			=> $kodee1,
						 'kode_program'		=> $program,
						 'target_thn1'		=> $target1,
						 'target_thn2'		=> $target2,
						 'target_thn3'		=> $target3,
						 'target_thn4'		=> $target4,
						 'target_thn5'		=> $target5);
		
		#cek kode sudah ada atau belum
		$cekdata 	= $this->mgeneral->getValue("kode_program",array("kode_program"=>$program,'tahun_renstra'=>$renstra),"anev_pendanaan_program");
		
		if($cekdata==""):
			$this->mgeneral->save($varData,"anev_pendanaan_program");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data berhasil ditambahkan.</p>';
		else:
			$msg = '<h5><i class="fa fa-warning"></i> <b>Gagal ditambahkan</b></h5>
					<p>Data untuk program ini sudah ada.</p>';
		endif;
		
		echo $msg;
	}
	
	function add_target_e1_form()
	{
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		$this->load->view('pemrograman/target_capaian_form',$data); #load konten template file
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
	
	function get_sasprog($tahun_awal, $tahun_akhir,$e1)
	{
		echo json_encode($this->program_e1->get_program_list($tahun_awal, $tahun_akhir,$e1));
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
	
	function cek_tipe_numerik($str)
	{
		if(is_numeric($str)):
			$cekFormat = explode(".",$str);
			if(count($cekFormat)==1): $fangka = "0"; else: $fangka="2"; endif;
			$format = number_format($str,$fangka,',','.');
			return $format;
		else:
			return $str;
		endif;
	}
}