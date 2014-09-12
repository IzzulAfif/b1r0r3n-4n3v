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
		$this->load->model('/unit_kerja/kl_model','kl');
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
						<a href="#identitasModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="identitasEdit(\''.$d->tahun_renstra.'\',\''.$d->kode_e2.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="identitasDelete(\''.$d->tahun_renstra.'\',\''.$d->kode_e2.'\');"><i class="fa fa-times"></i></a>
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
						<a href="#fungsiModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="fungsiEdit(\''.$d->tahun_renstra.'\',\''.$d->kode_fungsi_e2.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="fungsiDelete(\''.$d->tahun_renstra.'\',\''.$d->kode_fungsi_e2.'\');"><i class="fa fa-times"></i></a>
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
	
	function initFormData($tipe){
		
		if($tipe=="id"):
		
			$data[0]->tahun_renstra = '';
			$data[0]->kode_e1 		= '';
			$data[0]->nama_e1 		= '';
			$data[0]->kode_e2 		= '';
			$data[0]->nama_e2 		= '';
			$data[0]->singkatan 	= '';
			$data[0]->tugas_e2 		= '';
		
		else:
			
			$data[0]->tahun_renstra 	= '';
			$data[0]->kode_e1 			= '';
			$data[0]->nama_e1			= '';
			$data[0]->kode_e2 			= '';
			$data[0]->nama_e2 			= '';
			$data[0]->kode_fungsi_e2 	= '';
			$data[0]->fungsi_e2			= '';
			
		endif;
		
		return $data;
	}
	
	function add($tipe)	{
		
		if($tipe=="fungsi"):
			
			$data['data'] 		= $this->initFormData("fungsi");
			$data['renstra']	= $this->kl->get_renstra();
			$this->load->view('unit_kerja/eselon2_fungsi_v',$data); #load konten template file
			
		else:
				
			$data['data'] 		= $this->initFormData("id");
			$data['renstra']	= $this->kl->get_renstra();
			$this->load->view('unit_kerja/eselon2_form_v',$data); #load konten template file
		
		endif;
	}
	
	//fungsi untuk mengambil nilai" dari form saat tambah/update
	function get_form_value($tipe){
		
		if($tipe=="id"):
		
			$data['tahun_renstra']	= $this->input->post("tahun");
			$data['kode_e1']		= $this->input->post("es1");
			$data['kode_e2']		= $this->input->post("kode");
			$data['nama_e2']		= $this->input->post("nama");
			$data['singkatan']		= $this->input->post("singkatan");
			$data['tugas_e2']		= $this->input->post("tugas");
		
		else:
			
			$data['tahun_renstra']	= $this->input->post("tahun");
			$data['kode_e2']		= $this->input->post("es2");
			$data['kode_fungsi_e2']	= $this->input->post("kode");
			$data['fungsi_e2']		= $this->input->post("fungsi");
			
		endif;
		
		return $data;
	}
	
	function save()	{
		$tipe	= $this->input->post("tipe");
		$kode	= $this->input->post("kode");
		$tahun	= $this->input->post("tahun");
		
		if($tipe==""):
			
			#cek kode sudah ada atau belum
			$cekdata 	= $this->mgeneral->getValue("kode_e2",array("kode_e2"=>$kode,'tahun_renstra'=>$tahun),"anev_eselon2");
			
			if($cekdata==""):	
				$varData	= $this->get_form_value("id");
				$this->eselon2->save($varData);
			
				$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
						<p>Data Unit Kerja berhasil ditambahkan.</p>';
			else:
				$msg = '<h5><i class="fa fa-warning"></i> <b>Gagal ditambahkan</b></h5>
						<p>Kode Unit Kerja sudah ada.</p>';
			endif;
					
		else:
			#cek kode sudah ada atau belum
			$cekdata 	= $this->mgeneral->getValue("kode_fungsi_e2",array("kode_fungsi_e2"=>$kode,'tahun_renstra'=>$tahun),"anev_fungsi_eselon2");
			
			if($cekdata==""):
				$varData	= $this->get_form_value($tipe);
				$this->fungsi->save($varData);
			
				$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
						<p>Fungsi Unit Kerja berhasil ditambahkan.</p>';
			else:
				$msg = '<h5><i class="fa fa-warning"></i> <b>Gagal ditambahkan</b></h5>
						<p>Kode Fungsi Unit Kerja sudah ada.</p>';
			endif;
								
		endif;
				
		echo $msg;
	}
	
	function edit($tipe,$tahun_renstra,$kode)
	{
		if($tipe=="id"):
		
			$data['data']		= $this->eselon2->get_all(array('kode_e2'=>$kode,'tahun_renstra'=>$tahun_renstra));
			$data['renstra']	= $this->kl->get_renstra();
			$this->load->view('unit_kerja/eselon2_form_v',$data); #load konten template file
		
		else:
		
			$data['data']		= $this->fungsi->get_by_id(array('kode_fungsi_e2'=>$kode,'tahun_renstra'=>$tahun_renstra));
			$data['renstra']	= $this->kl->get_renstra();
			$this->load->view('unit_kerja/eselon2_fungsi_v',$data); #load konten template file
			
		endif;
		
	}
	
	function update(){		
		
		$tipe	= $this->input->post("tipe");
		
		if($tipe==""):
		
			$varData	= $this->get_form_value("id");
			
			//khusus jika kasus update maka data lama dari primary keynya diambil dari yg _old digunakan utk where di update nya
			$whereData['tahun_renstra']	= $this->input->post("tahun_renstra_old");
			$whereData['kode_e2']		= $this->input->post("kode_e2_old");
			$this->eselon2->update($varData,$whereData);
			
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
						<p>Data unit kerja  berhasil diubah.</p>';
		
		else:
			
			$varData	= $this->get_form_value($tipe);
			
			//khusus jika kasus update maka data lama dari primary keynya diambil dari yg _old digunakan utk where di update nya
			$whereData['tahun_renstra']	= $this->input->post("tahun_renstra_old");
			$whereData['kode_fungsi_e2']= $this->input->post("kode_fungsi_old");
			$this->fungsi->update($varData,$whereData);
			
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
						<p>Fungsi unit kerja  berhasil diubah.</p>';
						
		endif;
		
		echo $msg;
	}
	
	function hapus($tipe,$tahun_renstra,$kode){
		
		if($tipe=="fungsi"):
			
			$whereData['tahun_renstra']	= $tahun_renstra;
			$whereData['kode_fungsi_e2']= $kode;
			$this->fungsi->delete($whereData);
		
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Fungsi unit kerja berhasil dihapus.</p>';
					
		else:
		
			$whereData['tahun_renstra']	= $tahun_renstra;
			$whereData['kode_e2']		= $kode;
			$this->eselon2->delete($whereData);
			
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
						<p>Data unit kerja berhasil dihapus.</p>';
		endif;
							
		echo $msg;
	}
}