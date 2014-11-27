<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup JS
 @date       : 2014-08-31 00:00
 @revision	 :
*/

class Ekstrak_lokasi extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('/admin/lokasi_model','lokasi');
		
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
	
	
	function loadpage($id)
	{
		
		$data['data'] = null;//$this->fungsi->get_all(null);
		//$data['tipe_data'] = $this->eperformance->get_list();
		$data = null;
		$data_webservice = $this->webservice->get_all(array("id"=>$id));
		$data['webservice_jenis']	= $data_webservice[0]->jenis_data;
		$data['webservice_url']	= $data_webservice[0]->url;
		echo $this->load->view('admin/lokasi_v',$data,true); #load konten template file		
	}
	
	function getdata_lokasi(){
		//echo $this->satker->get_datatables($params);
		$data = $this->lokasi->get_datatables(null);
		//var_dump($data);
		//echo json_encode($data);
		echo $data;
	}
	
	function ekstrak_data(){
		$dataTable = null;
		if(isset($_POST["dataTable"])) {
			$dataTable = $_POST["dataTable"];
			foreach($dataTable as $row) {
				
				
				$ekstrakData[] = $row;
				
			}//foreach
		}
		
		echo $this->lokasi->save_ekstrak($ekstrakData);
		
	}
}