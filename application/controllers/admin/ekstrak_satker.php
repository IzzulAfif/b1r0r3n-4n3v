<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup JS
 @date       : 2014-08-31 00:00
 @revision	 :
*/

class Ekstrak_satker extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('/admin/satker_model','satker');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/admin/webservice_model','webservice');
	}
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "ADMIN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file
		
		$data['data']		= null;//
		$template['konten']	= $this->load->view('admin/ekstrak_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	
	function loadpage($id,$tahun_renstra,$tahun)
	{
		
		$data['data'] = null;//$this->fungsi->get_all(null);
		//$data['tipe_data'] = $this->eperformance->get_list();
		//$data['eselon1']	= $kode;//$this->eselon1->get_list(null);
		$data['tahun']	= $tahun;//$this->eselon1->get_list(null);
		$data['tahun_renstra']	= $tahun_renstra;// // $this->tahun_renstra->get_list(null);
		$data_webservice = $this->webservice->get_all(array("id"=>$id));
		$data['webservice_jenis']	= $data_webservice[0]->jenis_data;
		$data['webservice_url']	= $data_webservice[0]->url;
		echo $this->load->view('admin/satker_v',$data,true); #load konten template file		
	}
	
	
	 
	function getdata_satker($tahun_renstra){
		$params = null;
		//echo $this->satker->get_datatables($params);
		$params['tahun_renstra']=$tahun_renstra;
		$data = $this->satker->get_datatables($params);
		echo $data;
	}
	
	function ekstrak_data($periode){
		$dataTable = null;
		if(isset($_POST["dataTable"])) {
			$dataTable = $_POST["dataTable"];
			foreach($dataTable as $row) {
				$row["tahun_renstra"] =$periode;
				
				$ekstrakData[] = $row;
				
			}//foreach
		}
		
		echo $this->satker->save_ekstrak($ekstrakData);
		
	}
	
	
}