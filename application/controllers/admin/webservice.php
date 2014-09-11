<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup
 @date       : 2014-09-02 00:00
 @revision	 :
   
*/

class Webservice extends CI_Controller {
	
	function __construct() {	
		parent::__construct();		
		$this->load->model('/admin/webservice_model','webservice');
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
		echo $this->load->view('admin/webservice',$data,true); #load konten template file		
	}

	function get_tables(){
		$data = $this->webservice->get_datatables(null);
		//echo json_encode($data);
		echo $data;
	}
	

	function init_data()
	{
	
		$data[0]->url = '';
		$data[0]->jenis_data = '';
		$data[0]->tipe_aplikasi = '';
		$data[0]->id = '';
		
		return $data;
	}
	
	function add()
	{
		$data['data']		= $this->init_data();
		
		$this->load->view('admin/tahun_renstra_form_v',$data);
		
	}
	
	function get_from_post()
	{
		
			$url	= $this->input->post("url");
			$id	= $this->input->post("id");
			$data	= array('url'	=> $url);
		
		
		return $data;
	}
	
	function save()	{		
		$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data kementerian berhasil ditambahkan.</p>';
		
		$varData	= $this->get_from_post();
		$this->webservice->save($varData);
		
		echo $msg;
	}
	
	function edit($id)	{		
		$data['data']		= $this->webservice->get_all(array('id'=>$id));
		$this->load->view('admin/webservice_form_v',$data);
		
	}
	
	function update()
	{
		$id	= $this->input->post("id");
		$varData= $this->get_from_post(); 		
			$this->webservice->update($varData,array('id'=>$id));
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data Web Service  berhasil diubah.</p>';
		echo $msg;
	}
	
	function hapus($id)
	{
		$this->webservice->delete(array('id'=>$id));
		$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data Web Service berhasil dihapus.</p>';
		
		echo $msg;
	}
	
	
}