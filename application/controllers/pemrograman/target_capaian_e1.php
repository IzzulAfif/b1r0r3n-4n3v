<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Didin
 @date       : 2014-11-26 00:00
 @revision	 :
*/

class Target_capaian_e1 extends CI_Controller {
	
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
	}	
	
	function add()
	{
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		$data['form_tipe']	= "add";
		$this->load->view('pemrograman/target_capaian_form',$data); #load konten template file
	}
	
	function save()
	{
		$renstra	 = $this->input->post("renstra");
		$kd_e1		 = $this->input->post("kode_e1");
		$sasaran	 = $this->input->post("sasaran");
		$iku		 = $this->input->post("iku");
		$target1	 = $this->input->post("target1");
		$target2	 = $this->input->post("target2");
		$target3	 = $this->input->post("target3");
		$target4	 = $this->input->post("target4");
		$target5	 = $this->input->post("target5");
		
		$varData = array('tahun_renstra'	=> $renstra,
						 'kode_e1'			=> $kd_e1,
						 'kode_sp_e1'		=> $sasaran,
						 'kode_iku_e1'		=> $iku,
						 'target_thn1'		=> $target1,
						 'target_thn2'		=> $target2,
						 'target_thn3'		=> $target3,
						 'target_thn4'		=> $target4,
						 'target_thn5'		=> $target5);
		
		#cek kode sudah ada atau belum
		$cekdata 	= $this->mgeneral->getValue("kode_iku_e1",array("kode_iku_e1"=>$iku,'tahun_renstra'=>$renstra),"anev_target_eselon1");
		
		if($cekdata==""):
			$this->mgeneral->save($varData,"anev_target_eselon1");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data berhasil ditambahkan.</p>';
		else:
			$msg = '<h5><i class="fa fa-warning"></i> <b>Gagal ditambahkan</b></h5>
					<p>Data capaian kinerja sudah ada.</p>';
		endif;
		
		echo $msg;
	}
	
	function edit($renstra,$iku)
	{
		$data['data']		= $this->mgeneral->getWhere(array('tahun_renstra'=>$renstra,"kode_iku_e1"=>$iku),"anev_target_eselon1");
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		$data['form_tipe']	= "edit";
		$this->load->view('pemrograman/target_capaian_form',$data); #load konten template file
	}
	
	function update()
	{
		$renstra	= $this->input->post("renstra"); 
		$iku		= $this->input->post("iku");
		$t1			= $this->input->post("target1");
		$t2			= $this->input->post("target2");
		$t3			= $this->input->post("target3");
		$t4			= $this->input->post("target4");
		$t5			= $this->input->post("target5");
		
		$where	 = array('tahun_renstra'	=> $renstra,
						 'kode_iku_e1'		=> $iku);
		$varData = array('target_thn1'		=> $t1,
						 'target_thn2'		=> $t2,
						 'target_thn3'		=> $t3,
						 'target_thn4'		=> $t4,
						 'target_thn5'		=> $t5);
		$this->mgeneral->update($where,$varData,"anev_target_eselon1");
		
		$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Target capaian kinerja berhasil diupdate.</p>';
					
		echo $msg;
	}
}