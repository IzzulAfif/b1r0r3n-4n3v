<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Didin
 @date       : 2014-08-09 00:00
 @revision	 :
   rombak to tab style by yusup : 2014-08-25
*/

class Anev_kl extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/kl_model','kl');
		$this->load->model('/unit_kerja/fungsi_kl_model','fungsi_kl');
	}
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file
		$data['data'] = null;
	
		$template['konten']	= $this->load->view('unit_kerja/kementerian_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadidentitas()
	{
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		//$this->visi->get_all(null);
			$data['data']		= null;//$this->mgeneral->getAll("anev_kl"); #kirim data ke konten file
		echo $this->load->view('unit_kerja/anev_kl',$data,true); #load konten template file		
	}

	function get_body_identitas($tahun,$kl){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_kl'] = 	$kl;
		$data=$this->kl->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->kode_kl.'</td>
					<td>'.$d->nama_kl.'</td>
					<td>'.$d->singkatan.'</td>
					<td>'.$d->tugas_kl.'</td>
					<td>
						<a href="'.base_url().'unit_kerja/anev_kl/edit/'.$d->kode_kl.'" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
						<a href="'.base_url().'unit_kerja/anev_kl/hapus/'.$d->kode_kl.'" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>
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
	
	function loadfungsi()
	{
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = null;//$this->fungsi_kl->get_all(null);
		echo $this->load->view('unit_kerja/fungsi_kl_v',$data,true); #load konten template file		
	}
	
	function get_body_fungsi($tahun,$kl){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_kl'] = 	$kl;
		$data=$this->fungsi_kl->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->kode_fungsi_kl.'</td>
					<td>'.$d->fungsi_kl.'</td>					
					<td>
						<a href="#" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>
					</td>
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
		}
		echo $rs;
	}
	
	function add()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "form");
		$template			= $this->template->load($setting); #load static template file
		
		$data['data']		= array();
		$data['url']		= base_url()."unit_kerja/anev_kl/save";
		$template['konten']	= $this->load->view('unit_kerja/anev_kl_form',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function save()
	{
		$kode	= $this->input->post("kode");
		$nama	= $this->input->post("nama");
		$singkat= $this->input->post("singkatan");
		
		$varData	= array('kode_kl'	=> $kode,
							'nama_kl'	=> $nama,
							'singkatan'	=> $singkat);
		$this->mgeneral->save($varData,"anev_kl");
		
		$msg = '<div class="alert alert-success" style="text-align:center"> 
					<strong><i class="fa fa-check-square-o"></i> Sukses</strong> Data berhasil ditambahkan.  
					<button id="autoClose" data-dismiss="alert" class="close" type="button">×</button>
				</div>';
				
		$this->session->set_flashdata('msg', $msg);
		redirect("unit_kerja/anev_kl","refresh");	
	}
	
	function edit($id)
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "form");
		$template			= $this->template->load($setting); #load static template file
		
		$data['data']		= $this->mgeneral->getWhere(array('kode_kl'=>$id),"anev_kl");
		$data['url']		= base_url()."unit_kerja/anev_kl/update";
		$template['konten']	= $this->load->view('unit_kerja/anev_kl_form',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function update()
	{
		$id		= $this->input->post("id");
		$kode	= $this->input->post("kode");
		$nama	= $this->input->post("nama");
		$singkat= $this->input->post("singkatan");
		
		$varData	= array('kode_kl'	=> $kode,
							'nama_kl'	=> $nama,
							'singkatan'	=> $singkat);
		$this->mgeneral->update(array('kode_kl'=>$id),$varData,"anev_kl");
		
		$msg = '<div class="alert alert-success" style="text-align:center"> 
					<strong><i class="fa fa-check-square-o"></i> Sukses</strong> Data berhasil diubah.  
					<button id="autoClose" data-dismiss="alert" class="close" type="button">×</button>
				</div>';
				
		$this->session->set_flashdata('msg', $msg);
		redirect("unit_kerja/anev_kl","refresh");
	}
	
	function hapus($id)
	{
		$this->mgeneral->delete(array('kode_kl'=>$id),"anev_kl");
		
		$msg = '<div class="alert alert-success" style="text-align:center"> 
					<strong><i class="fa fa-check-square-o"></i> Sukses</strong> Data berhasil dihapus.  
					<button id="autoClose" data-dismiss="alert" class="close" type="button">×</button>
				</div>';
				
		$this->session->set_flashdata('msg', $msg);
		redirect("unit_kerja/anev_kl","refresh");
	}
}