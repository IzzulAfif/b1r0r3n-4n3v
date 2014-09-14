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
		$this->load->model('/unit_kerja/kl_model','kl');
		$this->load->model('/unit_kerja/fungsi_eselon1_model','fungsi');
		$this->load->model('/admin/tahun_renstra_model','setting_th');
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
		$data['tahun_renstra']= $this->setting_th->get_list();
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
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="identitasDelete(\''.$d->tahun_renstra.'\',\''.$d->kode_e1.'\');"><i class="fa fa-times"></i></a>
					</td>
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="5" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
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
		$data['tahun_renstra']= $this->setting_th->get_list();
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
						<a href="#fungsiModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="fungsiEdit(\''.$d->tahun_renstra.'\',\''.$d->kode_fungsi_e1.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="fungsiDelete(\''.$d->tahun_renstra.'\',\''.$d->kode_fungsi_e1.'\');"><i class="fa fa-times"></i></a>
					</td>
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="3" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function initFormData($tipe){
		
		if($tipe=="id"):
		
			$data[0]->tahun_renstra1 = '';
			$data[0]->tahun_renstra2 = '';
			$data[0]->tahun_renstra_old = '';
			$data[0]->kode_e1_old = '';
			$data[0]->kode_e1 = '';
			$data[0]->kode_kl = '';
			$data[0]->nama_e1 = '';
			$data[0]->singkatan = '';
			$data[0]->tugas_e1 = '';
		
		else:
			
			$data[0]->tahun_renstra = '';
			$data[0]->kode_fungsi_e1 = '';
			$data[0]->kode_e1 = '';
			$data[0]->fungsi_e1 = '';
			$data[0]->nama_e1	= '';
			
		endif;
		
		return $data;
	}
	
	function add($tipe)	{
		
		if($tipe=="fungsi"):
			
			$data['data'] = $this->initFormData("fungsi");
			$data['renstra']	= $this->kl->get_renstra();
			$this->load->view('unit_kerja/eselon1_fungsi_v',$data); #load konten template file
			
		else:
				
			$data['data'] = $this->initFormData("id");
			$data['renstra']	= $this->kl->get_renstra();
			$this->load->view('unit_kerja/eselon1_form_v',$data); #load konten template file
		
		endif;
	}
	
	function edit($tipe,$tahun_renstra,$kode)
	{
		if($tipe=="id"):
		
			$data['data']		= $this->eselon1->get_all(array('kode_e1'=>$kode,'tahun_renstra'=>$tahun_renstra));
			if (!isset($data['data'])){
				$data['data'] = $this->initFormData("id");
			}else{
				$data['data'][0]->tahun_renstra1 = $this->utility->ourEkstrakString($data['data'][0]->tahun_renstra,'-',0);
				$data['data'][0]->tahun_renstra2 = $this->utility->ourEkstrakString($data['data'][0]->tahun_renstra,'-',1);
				$data['data'][0]->tahun_renstra_old = $data['data'][0]->tahun_renstra;
				$data['data'][0]->kode_e1_old = $data['data'][0]->kode_e1;
			}
			$data['renstra']	= $this->kl->get_renstra();
			$data['url']		= base_url()."unit_kerja/eselon1/update";
			$data['kementerian'] = $this->kl->get_list(null);
			$this->load->view('unit_kerja/eselon1_form_v',$data); #load konten template file
		
		else:
		
			$data['data']		= $this->fungsi->get_by_id(array('kode_fungsi_e1'=>$kode,'tahun_renstra'=>$tahun_renstra));
			$data['renstra']	= $this->kl->get_renstra();
			$this->load->view('unit_kerja/eselon1_fungsi_v',$data); #load konten template file
			
		endif;
		
	}
	
	//fungsi untuk mengambil nilai" dari form saat tambah/update
	function get_form_value($tipe){
		
		if($tipe=="id"):
		
			$data['tahun_renstra']	= $this->input->post("tahun");
			$data['kode_kl']	= $this->input->post("kl");
			$data['kode_e1']	= $this->input->post("kode");
			$data['nama_e1']	= $this->input->post("nama");
			$data['singkatan']= $this->input->post("singkatan");
			$data['tugas_e1']= $this->input->post("tugas");
		
		else:
			
			$data['tahun_renstra']	= $this->input->post("tahun");
			$data['kode_e1']		= $this->input->post("es1");
			$data['kode_fungsi_e1']	= $this->input->post("kode");
			$data['fungsi_e1']		= $this->input->post("fungsi");
			
		endif;
		
		return $data;
	}
	function save()	{
		$tipe	= $this->input->post("tipe");
		$kode	= $this->input->post("kode");
		$tahun	= $this->input->post("tahun");
		
		if($tipe==""):
			#cek kode sudah ada atau belum
			$cekdata 	= $this->mgeneral->getValue("kode_e1",array("kode_e1"=>$kode,'tahun_renstra'=>$tahun),"anev_eselon1");
			
			if($cekdata==""):
			
				$varData	= $this->get_form_value("id");
				$this->eselon1->save($varData);
			
				$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data Unit Kerja berhasil ditambahkan.</p>';
			else:
				$msg = '<h5><i class="fa fa-warning"></i> <b>Gagal ditambahkan</b></h5>
						<p>Kode Unit Kerja sudah ada.</p>';
			endif;
			
		else:
			#cek kode sudah ada atau belum
			$cekdata 	= $this->mgeneral->getValue("kode_fungsi_e1",array("kode_fungsi_e1"=>$kode,'tahun_renstra'=>$tahun),"anev_fungsi_eselon1");
			
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
	
	
	function update(){		
		
		$tipe	= $this->input->post("tipe");
		
		if($tipe==""):
		
			$varData	= $this->get_form_value("id");
			
			//khusus jika kasus update maka data lama dari primary keynya diambil dari yg _old digunakan utk where di update nya
			$whereData['tahun_renstra']	= $this->input->post("tahun_renstra_old");
			$whereData['kode_e1']	= $this->input->post("kode_e1_old");
			$this->eselon1->update($varData,$whereData);
			
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
						<p>Data unit kerja  berhasil diubah.</p>';
		
		else:
			
			$varData	= $this->get_form_value($tipe);
			
			//khusus jika kasus update maka data lama dari primary keynya diambil dari yg _old digunakan utk where di update nya
			$whereData['tahun_renstra']	= $this->input->post("tahun_renstra_old");
			$whereData['kode_fungsi_e1']= $this->input->post("kode_fungsi_old");
			$this->fungsi->update($varData,$whereData);
			
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
						<p>Fungsi unit kerja  berhasil diubah.</p>';
						
		endif;
		
		echo $msg;
	}
	
	function hapus($tipe,$tahun_renstra,$kode){
		
		if($tipe=="fungsi"):
			
			$whereData['tahun_renstra']	= $tahun_renstra;
			$whereData['kode_fungsi_e1']= $kode;
			$this->fungsi->delete($whereData);
		
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Fungsi unit kerja berhasil dihapus.</p>';
					
		else:
		
			$whereData['tahun_renstra']	= $tahun_renstra;
			$whereData['kode_e1']	= $kode;
			$this->eselon1->delete($whereData);
			
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
						<p>Data unit kerja berhasil dihapus.</p>';
		endif;
							
		echo $msg;
	}
	
	function get_es1($tahun)
	{
		$result = $this->eselon1->get_es1($tahun);
		echo json_encode($result);
	}
}