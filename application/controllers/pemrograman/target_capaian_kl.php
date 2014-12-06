<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Didin
 @date       : 2014-11-26 00:00
 @revision	 :
*/

class Target_capaian_kl extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/kl_model','kl');
		
		$this->load->model('/pemrograman/program_eselon1_model','program_e1');
		$this->load->model('/pemrograman/sasaran_strategis_model','sasaran');
		$this->load->model('/pemrograman/target_capaian_model','target');
		$this->load->model('/pemrograman/iku_kl_model','iku');
		$this->load->model('/admin/tahun_renstra_model','setting_th');
	}	
	
	function add()
	{
		$data['ss']			= $this->iku->get_ss_list();
		$data['renstra']	= $this->setting_th->get_list();
		$data['form_tipe']	= "add";
		$this->load->view('pemrograman/target_capaian_kl_form',$data);
	}
	
	function save()
	{
		$kod_ss_kl	= $this->input->post("sasaran"); 
		$renstra	= $this->input->post("renstra");
		$iku		= $this->input->post("iku");
		$t1			= $this->input->post("target1");
		$t2			= $this->input->post("target2");
		$t3			= $this->input->post("target3");
		$t4			= $this->input->post("target4");
		$t5			= $this->input->post("target5");
		
		$cekData = $this->mgeneral->getWhere(array('kode_iku_kl'=>$iku,"tahun_renstra"=>$renstra),"anev_target_kl");
		if(count($cekData)==0):
			
			$varData = array('tahun_renstra'	=> $renstra,
							 'kode_kl'			=> "22",
							 'kode_ss_kl'		=> $kod_ss_kl,
							 'kode_iku_kl'		=> $iku,
							 'target_thn1'		=> $t1,
							 'target_thn2'		=> $t2,
							 'target_thn3'		=> $t3,
							 'target_thn4'		=> $t4,
							 'target_thn5'		=> $t5);
			$this->mgeneral->save($varData,"anev_target_kl");
			
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Target capaian berhasil ditambahkan.</p>';
		else:
			
			$msg = '<h5><i class="fa fa-warning"></i> <b>Gagal ditambahkan</b></h5>
					<p>Data sudah ada.</p>';
					
		endif;
		
		echo $msg;
	}
	
	function edit($tahun,$iku)
	{
		#$data['data']		= $this->mgeneral->getJoin(array('kode_iku_kl'=>$iku,"tahun_renstra"=>$tahun),"anev_target_kl");
		$params['tahun_renstra']	= $tahun;
		$params['iku']				= $iku;
		$data['data']				= $this->target->get_all($params);
		$data['ss']					= $this->iku->get_ss_list();
		$data['renstra']			= $this->setting_th->get_list();
		$data['form_tipe']			= "edit";
		$this->load->view('pemrograman/target_capaian_kl_form',$data);
	}
	
	function update()
	{
		$kod_ss_kl	= $this->input->post("sasaran"); 
		$iku		= $this->input->post("iku");
		$t1			= $this->input->post("target1");
		$t2			= $this->input->post("target2");
		$t3			= $this->input->post("target3");
		$t4			= $this->input->post("target4");
		$t5			= $this->input->post("target5");
		
		$where	 = array('kode_ss_kl'		=> $kod_ss_kl,
						 'kode_iku_kl'		=> $iku);
		$varData = array('target_thn1'		=> $t1,
						 'target_thn2'		=> $t2,
						 'target_thn3'		=> $t3,
						 'target_thn4'		=> $t4,
						 'target_thn5'		=> $t5);
		$this->mgeneral->update($where,$varData,"anev_target_kl");
		
		$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Target capaian kinerja berhasil diupdate.</p>';
					
		echo $msg;
	}
}