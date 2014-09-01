<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-15 00:00
 @revision	 :
*/

class Eselon2 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/fungsi_eselon2_model','fungsi');
	}	
	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file
		
		#$sql = "select e2.*, e1.nama_e1 from anev_eselon2 e2 inner join anev_eselon1 e1 on e1.kode_e1=e2.kode_e1 ";
		#$data['data']		= $this->eselon2->get_all("");//$this->mgeneral->run_sql($sql); #kirim data ke konten file
		
		$data[]				= null;
		$template['konten']	= $this->load->view('unit_kerja/e2_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadidentitas()
	{
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		//$this->visi->get_all(null);
		$data['data']		= null;//$this->eselon2->get_all(null); #kirim data ke konten file
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('unit_kerja/eselon2_v',$data,true); #load konten template file		
	}
	
	function get_body_identitas($tahun,$kode,$kode_e2){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode;
		if ($kode_e2!="0")
			$params['kode_e2'] = 	$kode_e2;
		$data=$this->eselon2->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->kode_e2.'</td>
					<td>'.$d->nama_e2.'</td>					
					<td>'.$d->singkatan.'</td>					
					<td>'.$d->tugas_e2.'</td>					
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
		$data['data'] =null; //$this->fungsi->get_all(null);
		$data['eselon1'] = $this->eselon1->get_list(null);
		echo $this->load->view('unit_kerja/fungsi_eselon2_v',$data,true); #load konten template file		
	}
	function get_body_fungsi($tahun,$kode,$kode_e2){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode;
		if ($kode_e2!="0")
			$params['kode_e2'] = 	$kode_e2;
		$data=$this->fungsi->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->kode_fungsi_e2.'</td>
					<td>'.$d->fungsi_e2.'</td>					
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
	
	function load_data_e2()
	{
		$this->load->library('datatables');
		$this->datatables->select('e1.nama_e1,e2.kode_e2,e2.nama_e2,e2.singkatan,e2.tugas_e2');
		$this->datatables->from('anev_eselon2 e2');
		$this->datatables->join('anev_eselon1 e1', 'e1.kode_e1=e2.kode_e1 and e1.tahun_renstra=e2.tahun_renstra', 'left');
		$this->datatables->add_column('aksi', '$1','e2_action(e2.kode_e2)');
		echo $this->datatables->generate();
		exit;
	}
	
	function get_list_eselon2($kode_e1)
	{
		$params = array("kode_e1"=>$kode_e1);
		echo json_encode($this->eselon2->get_list($params));
	}
	
	function add()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "form");
		$template			= $this->template->load($setting); #load static template file
		
		$data['url']		= base_url()."unit_kerja/eselon2/save";
		$template['konten']	= $this->load->view('unit_kerja/eselon2_form',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function save()
	{
		$kode	= $this->input->post("kode");
		$nama	= $this->input->post("nama");
		$singkat= $this->input->post("singkatan");
		
		$varData	= array('kode_eselon2'	=> $kode,
							'nama_eselon2'	=> $nama,
							'singkatan'	=> $singkat);
		$this->mgeneral->save($varData,"anev_eselon2");
		
		$msg = '<div class="alert alert-success" style="text-align:center"> 
					<strong><i class="fa fa-check-square-o"></i> Sukses</strong> Data berhasil ditambahkan.  
					<button id="autoClose" data-dismiss="alert" class="close" type="button">×</button>
				</div>';
				
		$this->session->set_flashdata('msg', $msg);
		redirect("unit_kerja/eselon2","refresh");	
	}
	
	function edit($id)
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "UNIT_KERJA");
		$setting['page']	= array('pg_aktif'	=> "form");
		$template			= $this->template->load($setting); #load static template file
		
		$data['data']		= $this->mgeneral->getWhere(array('kode_eselon2'=>$id),"anev_eselon2");
		$data['url']		= base_url()."unit_kerja/anev_eselon2/update";
		$template['konten']	= $this->load->view('unit_kerja/anev_eselon2_form',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function update()
	{
		$id		= $this->input->post("id");
		$kode	= $this->input->post("kode");
		$nama	= $this->input->post("nama");
		$singkat= $this->input->post("singkatan");
		
		$varData	= array('kode_eselon2'	=> $kode,
							'nama_eselon2'	=> $nama,
							'singkatan'	=> $singkat);
		$this->mgeneral->update(array('kode_eselon2'=>$id),$varData,"anev_eselon2");
		
		$msg = '<div class="alert alert-success" style="text-align:center"> 
					<strong><i class="fa fa-check-square-o"></i> Sukses</strong> Data berhasil diubah.  
					<button id="autoClose" data-dismiss="alert" class="close" type="button">×</button>
				</div>';
				
		$this->session->set_flashdata('msg', $msg);
		redirect("unit_kerja/anev_eselon2","refresh");
	}
	
	function hapus($id)
	{
		$this->mgeneral->delete(array('kode_eselon2'=>$id),"anev_eselon2");
		
		$msg = '<div class="alert alert-success" style="text-align:center"> 
					<strong><i class="fa fa-check-square-o"></i> Sukses</strong> Data berhasil dihapus.  
					<button id="autoClose" data-dismiss="alert" class="close" type="button">×</button>
				</div>';
				
		$this->session->set_flashdata('msg', $msg);
		redirect("unit_kerja/anev_eselon2","refresh");
	}
}