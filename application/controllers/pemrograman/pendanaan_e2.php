<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Didin
 @date       : 2014-11-26 00:00
 @revision	 :
*/

class Pendanaan_e2 extends CI_Controller {
	
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
		$this->load->model('/pemrograman/target_capaian_model','target');
	}	
	
	function add()
	{
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		$data['form_tipe']	= "add";
		$this->load->view('pemrograman/keuangan_e2_form',$data); #load konten template file
	}
	
	function save()
	{
		$renstra	 = $this->input->post("renstra");
		$kd_e1		 = $this->input->post("kode_e1");
		$kd_e2		 = $this->input->post("kode_e2");
		$sasaran	 = $this->input->post("sasaran");
		$ikk		 = $this->input->post("ikk");
		$target1	 = $this->input->post("target1");
		$target2	 = $this->input->post("target2");
		$target3	 = $this->input->post("target3");
		$target4	 = $this->input->post("target4");
		$target5	 = $this->input->post("target5");
		
		$kode_sk_e2	 = $this->mgeneral->getValue("kode_sk_e2",array('kode_ikk'=>$ikk),"anev_ikk");
		
		$varData = array('tahun_renstra'	=> $renstra,
						 'kode_e2'			=> $kd_e2,
						 'kode_sk_e2'		=> $kode_sk_e2,
						 'kode_ikk'			=> $ikk,
						 'target_thn1'		=> $target1,
						 'target_thn2'		=> $target2,
						 'target_thn3'		=> $target3,
						 'target_thn4'		=> $target4,
						 'target_thn5'		=> $target5);
		
		#cek kode sudah ada atau belum
		$cekdata 	= $this->mgeneral->getValue("kode_ikk",array("kode_ikk"=>$ikk,'tahun_renstra'=>$renstra),"anev_target_eselon2");
		
		if($cekdata==""):
			$this->mgeneral->save($varData,"anev_target_eselon2");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data berhasil ditambahkan.</p>';
		else:
			$msg = '<h5><i class="fa fa-warning"></i> <b>Gagal ditambahkan</b></h5>
					<p>Data capaian kinerja sudah ada.</p>';
		endif;
		
		echo $msg;
	}
	
	function edit($renstra,$ikk)
	{
		$data['data']		= $this->mgeneral->getWhere(array('tahun_renstra'=>$renstra,"kode_ikk"=>$ikk),"anev_target_eselon2");
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		$data['form_tipe']	= "edit";
		$this->load->view('pemrograman/keuangan_e2_form',$data); #load konten template file
	}
	
	function update()
	{
		$renstra	= $this->input->post("renstra"); 
		$ikk		= $this->input->post("ikk");
		
		$t1			= $this->input->post("target1");
		$t2			= $this->input->post("target2");
		$t3			= $this->input->post("target3");
		$t4			= $this->input->post("target4");
		$t5			= $this->input->post("target5");
		
		$where	 = array('tahun_renstra'	=> $renstra,
						 'kode_ikk'			=> $ikk);
		$varData = array('target_thn1'		=> $t1,
						 'target_thn2'		=> $t2,
						 'target_thn3'		=> $t3,
						 'target_thn4'		=> $t4,
						 'target_thn5'		=> $t5);
		$this->mgeneral->update($where,$varData,"anev_target_eselon2");
		
		$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Target capaian kinerja berhasil diupdate.</p>';
					
		echo $msg;
	}
}