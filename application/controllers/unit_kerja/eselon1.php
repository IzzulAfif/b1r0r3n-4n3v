<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup JS
 @date       : 2014-08-15 00:00
 @revision	 :
*/

class Eselon1 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/fungsi_eselon1_model','fungsi');
	}
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file
		
		$data['data']		= null;//$this->eselon1->get_all(null); #kirim data ke konten file
		$template['konten']	= $this->load->view('unit_kerja/e1_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadidentitas()
	{
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		//$this->visi->get_all(null);
			$data['data']		= null;//$this->eselon1->get_all(null); #kirim data ke konten file
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('unit_kerja/eselon1_v',$data,true); #load konten template file		
	}
	
	function get_body_identitas($tahun,$kode){
		$params['tahun_renstra'] = 	$tahun;
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
						<a href="#" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>
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
		$data['data'] = null;//$this->fungsi->get_all(null);
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('unit_kerja/fungsi_eselon1_v',$data,true); #load konten template file		
	}
	
	function get_body_fungsi($tahun,$kode){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode;
		$data=$this->fungsi->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->kode_fungsi_e1.'</td>
					<td>'.$d->fungsi_e1.'</td>					
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
	
	function initFormData(){
		$data[0]->tahun_renstra1 = '';
		$data[0]->tahun_renstra2 = '';
		$data[0]->kode_e1 = '';
		$data[0]->kode_kl = '';
		$data[0]->nama_e1 = '';
		$data[0]->singkatan = '';
		$data[0]->tugas_e1 = '';
		return $data;
	}
	
	function add()
	{
		#settingan untuk static template file
		
		$data['url']		= base_url()."unit_kerja/eselon1/save";
		$data['data'] = $this->initFormData();
		$this->load->view('unit_kerja/eselon1_form_v',$data); #load konten template file
		
	}
	
	function edit($tahun_renstra,$kode)
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "form");
		$template			= $this->template->load($setting); #load static template file
		
		$data['data']		= $this->eselon1->get_all(array('kode_e1'=>$kode,'tahun_renstra'=>$tahun_renstra));
		if (!isset($data['data'])){
			$data['data'] = $this->initFormData();
		}else{
			$data['data'][0]->tahun_renstra1 = $this->utility->ourEkstrakString($data['data'][0]->tahun_renstra,'-',0);
			$data['data'][0]->tahun_renstra2 = $this->utility->ourEkstrakString($data['data'][0]->tahun_renstra,'-',1);
		}
		$data['url']		= base_url()."unit_kerja/eselon1/update";
		$this->load->view('unit_kerja/eselon1_form_v',$data); #load konten template file
		
		
	}
	
	function save()
	{
		$tahun	= $this->input->post("tahun_renstra1").'-'.$this->input->post("tahun_renstra2");
		$kode	= $this->input->post("kode");
		$nama	= $this->input->post("nama");
		$singkat= $this->input->post("singkatan");
		$tugas= $this->input->post("tugas");
		
		$varData	= array('tahun_renstra' => $tahun,
							'kode_e1'	=> $kode,
							'nama_e1'	=> $nama,
							'singkatan'	=> $singkat,
							'tugas_e1'	=> $tugas);
		$this->eselon1->save($varData);
		
		$msg = '<div class="alert alert-success" style="text-align:center"> 
					<strong><i class="fa fa-check-square-o"></i> Sukses</strong> Data berhasil ditambahkan.  
					<button id="autoClose" data-dismiss="alert" class="close" type="button">×</button>
				</div>';
				
		$this->session->set_flashdata('msg', $msg);
		redirect("unit_kerja/eselon1","refresh");	
	}
	
	
	
	
	
	function update()
	{
		$id		= $this->input->post("id");
		$kode	= $this->input->post("kode");
		$nama	= $this->input->post("nama");
		$singkat= $this->input->post("singkatan");
		
		$varData	= array('kode_eselon1'	=> $kode,
							'nama_eselon1'	=> $nama,
							'singkatan'	=> $singkat);
		$this->mgeneral->update(array('kode_eselon1'=>$id),$varData,"anev_eselon1");
		
		$msg = '<div class="alert alert-success" style="text-align:center"> 
					<strong><i class="fa fa-check-square-o"></i> Sukses</strong> Data berhasil diubah.  
					<button id="autoClose" data-dismiss="alert" class="close" type="button">×</button>
				</div>';
				
		$this->session->set_flashdata('msg', $msg);
		redirect("unit_kerja/anev_eselon1","refresh");
	}
	
	function hapus($id)
	{
		$this->mgeneral->delete(array('kode_eselon1'=>$id),"anev_eselon1");
		
		$msg = '<div class="alert alert-success" style="text-align:center"> 
					<strong><i class="fa fa-check-square-o"></i> Sukses</strong> Data berhasil dihapus.  
					<button id="autoClose" data-dismiss="alert" class="close" type="button">×</button>
				</div>';
				
		$this->session->set_flashdata('msg', $msg);
		redirect("unit_kerja/anev_eselon1","refresh");
	}
}