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
		
		$data['renstra']	= $this->kl->get_renstra();
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
						<a href="#fModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="kl_edit(\''.$d->tahun_renstra.'\',\''.$d->kode_kl.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="kl_delete(\''.$d->tahun_renstra.'\',\''.$d->kode_kl.'\');"><i class="fa fa-times"></i></a>
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
			
		$data['renstra']	= $this->kl->get_renstra();
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
						<a href="#fungsiModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="fungsi_edit(\''.$d->tahun_renstra.'\',\''.$d->kode_fungsi_kl.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="fungsi_delete(\''.$d->tahun_renstra.'\',\''.$d->kode_fungsi_kl.'\');"><i class="fa fa-times"></i></a>
					</td>
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
						<td colspan="3" align="center"><i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
					</tr>';
		}
		echo $rs;
	}
	
	function init_data($tipe)
	{
		if($tipe=="id"):
			$data[0]->tahun_renstra = '';
			$data[0]->kode_kl 		= '';
			$data[0]->nama_kl 		= '';
			$data[0]->singkatan 	= '';
			$data[0]->tugas_kl 		= '';
		else:
			$data[0]->tahun_renstra = '';
			$data[0]->kode_kl 		= '';
			$data[0]->kode_fungsi_kl= '';
			$data[0]->fungsi_kl 	= '';
		endif;
		
		return $data;
	}
	
	function add($tipe)
	{
		$data['data']		= $this->init_data($tipe);
		if($tipe=="id"):
			$this->load->view('unit_kerja/anev_kl_form',$data);
		else:
			$data['renstra']	= $this->kl->get_renstra();
			$this->load->view('unit_kerja/fungsi_kl_form',$data);
		endif;
	}
	
	function get_from_post($tipe)
	{
		if($tipe=="id"):
			$renstra1	= $this->input->post("renstra1");
			$renstra2	= $this->input->post("renstra2");
			$tahun		= $renstra1."-".$renstra2;
			
			$data	= array('tahun_renstra'	=> $tahun,
							'kode_kl'		=> $this->input->post("kode"),
							'nama_kl'		=> $this->input->post("nama"),
							'singkatan'		=> $this->input->post("singkatan"),
							'tugas_kl'		=> $this->input->post("tugas"));
		else:
			$data	= array('tahun_renstra'	=> $this->input->post("tahun"),
							'kode_kl'		=> $this->input->post("kl"),
							'kode_fungsi_kl'=> $this->input->post("kode"),
							'fungsi_kl'		=> $this->input->post("fungsi"));
		endif;
		
		return $data;
	}
	
	function save()
	{
		$tipe		= $this->input->post("tipe");
		$varData	= $this->get_from_post($tipe);
		
		if($tipe=="id"):
			$tabel		= "anev_kl";
			$field_cek	= "kode_kl";
			$label		= "kementerian";
			$kode		= $varData['kode_kl'];
			$tahun		= $varData['tahun_renstra'];
		else:
			$tabel		= "anev_fungsi_kl";
			$field_cek	= "kode_fungsi_kl";
			$label		= "Fungsi";
			$kode		= $varData['kode_fungsi_kl'];
			$tahun		= $varData['tahun_renstra'];
		endif;
		
		#cek kode sudah ada atau belum
		$cekdata 	= $this->mgeneral->getValue($field_cek,array("$field_cek"=>$kode,'tahun_renstra'=>$tahun),$tabel);
		
		if($cekdata==""):
			$this->mgeneral->save($varData,$tabel);
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>'.ucfirst($label).' berhasil ditambahkan.</p>';
		else:
			$msg = '<h5><i class="fa fa-warning"></i> <b>Gagal ditambahkan</b></h5>
					<p>Kode '.$label.' sudah ada.</p>';
		endif;
		
		echo $msg;
	}
	
	function edit($tipe,$tahun,$kode)
	{
		if($tipe=="id"):
			$data['data']		= $this->mgeneral->getWhere(array('kode_kl'=>$kode,'tahun_renstra'=>$tahun),"anev_kl");
			$this->load->view('unit_kerja/anev_kl_form',$data);
		else:
			$data['renstra']			= $this->kl->get_renstra();
			$params['tahun_renstra']	= $tahun;
			$params['kode_fungsi_kl']	= $kode;
			$data['data']				= $this->fungsi_kl->get_all($params); 
			$this->load->view('unit_kerja/fungsi_kl_form',$data);
		endif;
	}
	
	function update()
	{
		$tipe	= $this->input->post("tipe");
		$tahun	= $this->input->post("tahun_old");
		$id		= $this->input->post("id");
		$varData= $this->get_from_post($tipe); 
		
		if($tipe=="id"):
		
			$this->mgeneral->update(array('kode_kl'=>$id,'tahun_renstra'=>$tahun),$varData,"anev_kl");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data kementerian  berhasil diubah.</p>';
		
		else:
			
			$this->mgeneral->update(array('kode_fungsi_kl'=>$id,'tahun_renstra'=>$tahun),$varData,"anev_fungsi_kl");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data fungsi kementerian berhasil diubah.</p>';
					
		endif;
		
		echo $msg;
	}
	
	function hapus($tipe,$tahun,$kode)
	{
		if($tipe=="id"):
		
			$this->mgeneral->delete(array('kode_kl'=>$kode,'tahun_renstra'=>$tahun),"anev_kl");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data kementerian berhasil dihapus.</p>';
		
		else:
			
			$this->mgeneral->delete(array('kode_fungsi_kl'=>$kode,'tahun_renstra'=>$tahun),"anev_fungsi_kl");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Data fungsi kementerian berhasil dihapus.</p>';
					
		endif;
		
		echo $msg;
	}
	
	function get_renstra()
	{
		$result = $this->kl->get_renstra();
		echo json_encode($result);
	}
	
	function get_kementerian($tahun)
	{
		$result = $this->kl->get_kementerian($tahun);
		echo json_encode($result);
	}
}