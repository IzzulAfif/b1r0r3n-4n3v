<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup JS
 @date       : 2014-08-31 00:00
 @revision	 :
*/

class Ekstrak_output extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('/admin/output_model','output_model');
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
	
	
	function loadpage($id)
	{
		
		$data['data'] = null;//$this->fungsi->get_all(null);
		$data_webservice = $this->webservice->get_all(array("id"=>$id));
		$data['webservice_jenis']	= $data_webservice[0]->jenis_data;
		$data['webservice_url']	= $data_webservice[0]->url;
		echo $this->load->view('admin/output_v',$data,true); #load konten template file		
	}
	
	
	 
	function getdata_output(){
		$params = null;
		//echo $this->output->get_datatables($params);
	//	$params['tahun_renstra']=$tahun_renstra;
		$data = $this->output_model->get_datatables($params);
		echo $data;
	}
	
	function ekstrak_data(){
		$dataTable = null;
		if(isset($_POST["dataTable"])) {
			$dataTable = $_POST["dataTable"];
			$old_kdgiat = '';
			$kdgiat = '';
			foreach($dataTable as $row) {
			    if ($old_kdgiat!=$row['KDGIAT']){
					$kdgiat = $this->mgeneral->getValue('kode_kegiatan', "right(kode_kegiatan,4)='".$row['KDGIAT']."'", "anev_kegiatan_eselon2"); 
					$old_kdgiat=$row['KDGIAT'];
				}
				if ($kdgiat!="")
					$row['KDGIAT']=$kdgiat;
				$ekstrakData[] = $row;
				
			}//foreach
		}
		
		echo $this->output_model->save_ekstrak($ekstrakData);
		
	}
	
	
}