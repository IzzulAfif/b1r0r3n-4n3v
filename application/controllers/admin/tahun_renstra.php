<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup
 @date       : 2014-09-02 00:00
 @revision	 :
   
*/

class Tahun_renstra extends CI_Controller {
	
	function __construct() {	
		parent::__construct();		
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
	}
	
	function index()
	{
		
	}
	
	function loaddata()
	{
		$setting['sd_left']	= array('cur_menu'	=> "ADMIN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		//$this->visi->get_all(null);
		$data = null;
		//$data['renstra']	= $this->kl->get_renstra();
		echo $this->load->view('admin/tahun_renstra',$data,true); #load konten template file		
	}

	function get_tables(){
		$data = $this->tahun_renstra->get_datatables(null);
		//echo json_encode($data);
		echo $data;
	}
	
	function get_body(){
		
		$data=$this->tahun_renstra->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->tahun_renstra.'</td>
					<td>
						<a href="#fModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="kl_edit(\''.$d->tahun_renstra.'\',\''.$d->kode_kl.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="kl_delete(\''.$d->tahun_renstra.'\',\''.$d->kode_kl.'\');"><i class="fa fa-times"></i></a>
					</td>
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
						<td colspan="2" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
					</tr>';
		}
		echo $rs;
	}
		
	function init_data()
	{
	
		$data[0]->tahun_renstra = '';
		$data[0]->tahun_renstra1 = '';
		$data[0]->tahun_renstra2 = '';
		$data[0]->tahun_renstra_old = '';
		
		return $data;
	}
	
	function add()
	{
		$data['data']		= $this->init_data();
		
		$this->load->view('admin/tahun_renstra_form_v',$data);
		
	}
	
	function get_from_post()
	{
		
			$renstra1	= $this->input->post("renstra1");
			$renstra2	= $this->input->post("renstra2");
			$tahun		= $renstra1."-".$renstra2;
			
			$data	= array('tahun_renstra'	=> $tahun);
		
		
		return $data;
	}
	
	function save()	{		
		$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data kementerian berhasil ditambahkan.</p>';
		
		$varData	= $this->get_from_post();
		$this->tahun_renstra->save($varData);
		
		echo $msg;
	}
	
	function edit($tahun)	{		
		$data['data']		= $this->tahun_renstra->get_all(array('tahun_renstra'=>$tahun));
		$this->load->view('admin/tahun_renstra_form_v',$data);
		
	}
	
	function update()
	{
		$tahun	= $this->input->post("tahun_old");
		$varData= $this->get_from_post(); 		
			$this->tahun_renstra->update(array('tahun_renstra'=>$tahun),$varData);
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data kementerian  berhasil diubah.</p>';
		echo $msg;
	}
	
	function hapus($tahun)
	{
		$this->tahun_renstra->delete(array('tahun_renstra'=>$tahun));
		$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data kementerian berhasil dihapus.</p>';
		
		echo $msg;
	}
	
	
}