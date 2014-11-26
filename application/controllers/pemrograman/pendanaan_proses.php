<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Didin
 @date       : 2014-11-26 00:00
 @revision	 :
*/

class Pendanaan_proses extends CI_Controller {
	
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
		$data['program']	= $this->keuangan->get_program_e1();
		$data['form_tipe']	= "add";
		$this->load->view('pemrograman/keuangan_kl_form',$data); #load konten template file
	}
	
	function save()
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
	
	function edit($renstra,$program)
	{
		$data['data']		= $this->mgeneral->getWhere(array('kode_program'=>$program,"tahun_renstra"=>$renstra),"anev_pendanaan_program");
		$data['renstra']	= $this->setting_th->get_list();
		$data['program']	= $this->keuangan->get_program_e1();
		$data['form_tipe']	= "edit";
		$this->load->view('pemrograman/keuangan_kl_form',$data); #load konten template file
	}
	
	function update()
	{
		$renstra	= $this->input->post("renstra"); 
		$program	= $this->input->post("program");
		$t1			= $this->input->post("target1");
		$t2			= $this->input->post("target2");
		$t3			= $this->input->post("target3");
		$t4			= $this->input->post("target4");
		$t5			= $this->input->post("target5");
		
		$where	 = array('kode_program'		=> $program,
						 'tahun_renstra'	=> $renstra);
		$varData = array('target_thn1'		=> $t1,
						 'target_thn2'		=> $t2,
						 'target_thn3'		=> $t3,
						 'target_thn4'		=> $t4,
						 'target_thn5'		=> $t5);
		/*echo "<pre>";
		print_r($where);
		print_r($varData);*/
		$this->mgeneral->update($where,$varData,"anev_pendanaan_program");
		
		$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data Kebutuhan Pendanaan berhasil diupdate.</p>';
					
		echo $msg;
	}
}