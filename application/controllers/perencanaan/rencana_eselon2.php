<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-22 00:00
 @revision	 :
*/

class Rencana_eselon2 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/unit_kerja/kl_model','kl');
		
		$this->load->model('/perencanaan/visi_eselon2_model','visi');
		$this->load->model('/perencanaan/misi_eselon2_model','misi');
		$this->load->model('/perencanaan/tujuan_eselon2_model','tujuan');
		$this->load->model('/perencanaan/sasaran_eselon2_model','sasaran');
		$this->load->model('/admin/tahun_renstra_model','setting_th');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "PERENCANAAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		//$setting = null;
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
		$template['konten']	= $this->load->view('perencanaan/rencana_eselon2_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadvisi()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PERENCANAAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		echo $this->load->view('perencanaan/visi_eselon2_v',$data,true); #load konten template file		
	}
	
	function get_body_visi($tahun,$kode_e1,$kode_e2){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode_e1;
		if($kode_e2!=0)$params['kode_e2'] = 	$kode_e2;
		$data=$this->visi->get_all($params); 
		$rs = '';
		if (isset($data)){
			$prevUk = ""; $no=1;
			foreach($data as $d):
				if($prevUk!=$d->nama_e2): $namaUK = $d->nama_e2; $no=1; else: $namaUK = ""; endif; 
				$prevUk = $d->nama_e2;
				$rs .= '<tr class="gradeX">
					<td>'.$namaUK.'</td>
					<td>'.$d->kode_visi_e2.'</td>
					<td>'.$d->visi_e2.'</td>
					<td>
						<a href="#visiModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="visi_edit(\''.$d->tahun_renstra.'\',\''.$d->kode_visi_e2.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="visi_delete(\''.$d->tahun_renstra.'\',\''.$d->kode_visi_e2.'\');"><i class="fa fa-times"></i></a>
					</td>
				</tr>';
				$no++;
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="5" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function loadmisi()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PERENCANAAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		echo $this->load->view('perencanaan/misi_eselon2_v',$data,true); #load konten template file		
	}
	
	function get_body_misi($tahun,$kode_e1,$kode_e2){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode_e1;
		if($kode_e2!=0)$params['kode_e2'] = 	$kode_e2;
		$data=$this->misi->get_all($params); 
		$rs = '';
		if (isset($data)){
			$prevUk=""; $no=1;
			foreach($data as $d):
				if($prevUk!=$d->nama_e2): $namaUK = $d->nama_e2; $no=1; else: $namaUK = ""; endif; 
				$prevUk = $d->nama_e2; 
				$rs .= '<tr class="gradeX">
					<td>'.$namaUK.'</td>
					<td>'.$no.'</td>
					<td>'.$d->kode_misi_e2.'</td>
					<td>'.$d->misi_e2.'</td>					
					<td>
						<a href="#misiModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="misi_edit(\''.$d->tahun_renstra.'\',\''.$d->kode_misi_e2.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="misi_delete(\''.$d->tahun_renstra.'\',\''.$d->kode_misi_e2.'\');"><i class="fa fa-times"></i></a>
					</td>
				</tr>';
				$no++;
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="5" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function loadtujuan()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PERENCANAAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		echo $this->load->view('perencanaan/tujuan_eselon2_v',$data,true); #load konten template file		
	}
	function get_body_tujuan($tahun,$kode_e1,$kode_e2){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode_e1;
		if($kode_e2!=0)$params['kode_e2'] = 	$kode_e2;
		$data=$this->tujuan->get_all($params); 
		$rs = '';
		if (isset($data)){
			$prevUk=""; $no=1;
			foreach($data as $d): 
				if($prevUk!=$d->nama_e2): $namaUK = $d->nama_e2; $no=1; else: $namaUK = ""; endif; 
				$prevUk = $d->nama_e2;
				$rs .= '<tr class="gradeX">
					<td>'.$namaUK.'</td>
					<td>'.$no.'</td>
					<td>'.$d->kode_tujuan_e2.'</td>
					<td>'.$d->tujuan_e2.'</td>					
					<td>
						<a href="#tujuanModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="tujuan_edit(\''.$d->tahun_renstra.'\',\''.$d->kode_tujuan_e2.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="tujuan_delete(\''.$d->tahun_renstra.'\',\''.$d->kode_tujuan_e2.'\');"><i class="fa fa-times"></i></a>
					</td>
				</tr>';
				$no++;
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="5" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function loadsasaran()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PERENCANAAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		echo $this->load->view('perencanaan/sasaran_eselon2_v',$data,true); #load konten template file		
	}
	
	function get_body_sasaran($tahun,$kode_e1,$kode_e2){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode_e1;
		$params['kode_e2'] = 	$kode_e2;
		$data=$this->sasaran->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->kode_sasaran_e2.'</td>
					<td>'.$d->sasaran_e2.'</td>					
					<td>
						<a href="#sasaranModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="sasaran_edit(\''.$d->tahun_renstra.'\',\''.$d->kode_sasaran_e2.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="sasaran_delete(\''.$d->tahun_renstra.'\',\''.$d->kode_sasaran_e2.'\');"><i class="fa fa-times"></i></a>
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
	
	function get_list_eselon2($kode_e1)
	{
		$params = array("kode_e1"=>$kode_e1);
		echo json_encode($this->eselon2->get_list($params));
	}
	
	function get_unit_kerja($kl){
		$data = $this->eselon2->get_all(array("kode_eselon2"=>$kl));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->nama_e1.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function get_fungsi($tahun,$kl){
		$data = $this->fungsi_eselon2->get_all(array("kode_eselon2"=>$kl,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->fungsi_eselon2.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function get_tugas($tahun,$kl){
		$data = $this->kl->get_all(array("kode_eselon2"=>$kl,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->tugas_eselon2.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function init_data($tipe)
	{
		if($tipe=="visi"):
			$data[0]->tahun_renstra = '';
			$data[0]->kode_e1 		= '';
			$data[0]->nama_e1 		= '';
			$data[0]->kode_e2 		= '';
			$data[0]->nama_e2 		= '';
			$data[0]->kode_visi_e2 	= '';
			$data[0]->visi_e2 		= '';
		elseif($tipe=="misi"):
			$data[0]->tahun_renstra = '';
			$data[0]->kode_e1 		= '';
			$data[0]->nama_e1 		= '';
			$data[0]->kode_e2 		= '';
			$data[0]->nama_e2 		= '';
			$data[0]->kode_misi_e2 	= '';
			$data[0]->misi_e2 		= '';
		elseif($tipe=="tujuan"):
			$data[0]->tahun_renstra = '';
			$data[0]->kode_e1 		= '';
			$data[0]->nama_e1 		= '';
			$data[0]->kode_e2 		= '';
			$data[0]->nama_e2 		= '';
			$data[0]->kode_tujuan_e2= '';
			$data[0]->tujuan_e2 	= '';
		else:
			$data[0]->tahun_renstra = '';
			$data[0]->kode_e1 		= '';
			$data[0]->kode_e2 		= '';
			$data[0]->nama_e2 		= '';
			$data[0]->kode_sasaran_e2= '';
			$data[0]->sasaran_e2 	= '';
		endif;
		
		return $data;
	}
	
	function add($tipe)
	{
		$data['data']		= $this->init_data($tipe);
		if($tipe=="visi"):
			$data['renstra']	= $this->setting_th->get_list();
			$this->load->view('perencanaan/visi_eselon2_form',$data);
		elseif($tipe=="misi"):
			$data['renstra']	= $this->setting_th->get_list();
			$this->load->view('perencanaan/misi_eselon2_form',$data);
		elseif($tipe=="tujuan"):
			$data['renstra']	= $this->setting_th->get_list();
			$this->load->view('perencanaan/tujuan_eselon2_form',$data);
		else:
			$data['renstra']	= $this->setting_th->get_list();
			$this->load->view('perencanaan/sasaran_eselon2_form',$data);
		endif;
	}
	
	function get_from_post($tipe)
	{
		if($tipe=="visi"):
			$data	= array('tahun_renstra'	=> $this->input->post("tahun"),
							'kode_e2'		=> $this->input->post("e2"),
							'kode_visi_e2'	=> $this->input->post("kode"),
							'visi_e2'		=> $this->input->post("visi"));
		elseif($tipe=="misi"):
			$data	= array('tahun_renstra'	=> $this->input->post("tahun"),
							'kode_e2'		=> $this->input->post("e2"),
							'kode_misi_e2'	=> $this->input->post("kode"),
							'misi_e2'		=> $this->input->post("misi"));
		elseif($tipe=="tujuan"):
			$data	= array('tahun_renstra'	=> $this->input->post("tahun"),
							'kode_e2'		=> $this->input->post("e2"),
							'kode_tujuan_e2'=> $this->input->post("kode"),
							'tujuan_e2'		=> $this->input->post("tujuan"));
		else:
			$data	= array('tahun_renstra'	=> $this->input->post("tahun"),
							'kode_e2'		=> $this->input->post("e2"),
							'kode_sasaran_e2'=> $this->input->post("kode"),
							'sasaran_e2'	=> $this->input->post("sasaran"));
		endif;
		
		return $data;
	}
	
	function save()
	{
		$tipe		= $this->input->post("tipe");
		$kode		= $this->input->post("kode");
		$tahun		= $this->input->post("tahun");
		
		if($tipe=="visi"): 
			$tabel		= "anev_visi_eselon2";
			$field_cek	= "kode_visi_e2";
		elseif($tipe=="misi"): 
			$tabel		= "anev_misi_eselon2";
			$field_cek	= "kode_misi_e2";
		elseif($tipe=="tujuan"): 
			$tabel		= "anev_tujuan_eselon2";
			$field_cek	= "kode_tujuan_e2";
		else:
			$tabel		= "anev_sasaran_eselon2";
			$field_cek	= "kode_sasaran_e2";
		endif;
		
		#cek kode sudah ada atau belum
		$cekdata 	= $this->mgeneral->getValue($field_cek,array("$field_cek"=>$kode,'tahun_renstra'=>$tahun),$tabel);
		
		if($cekdata==""):
			$varData	= $this->get_from_post($tipe);
			$this->mgeneral->save($varData,$tabel);
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>'.ucfirst($tipe).' Eselon 2 berhasil ditambahkan.</p>';
		else:
			$msg = '<h5><i class="fa fa-warning"></i> <b>Gagal ditambahkan</b></h5>
					<p>Kode '.$tipe.' sudah ada.</p>';
		endif;
		
		echo $msg;
	}
	
	function edit($tipe,$tahun,$kode)
	{
		if($tipe=="visi"):
			$data['renstra']			= $this->setting_th->get_list();
			$params['kode_visi_e2']		= $kode;
			$params['tahun_renstra']	= $tahun; 
			$data['data']				= $this->visi->get_where($params);
			$this->load->view('perencanaan/visi_eselon2_form',$data);
		elseif($tipe=="misi"):
			$data['renstra']			= $this->setting_th->get_list();
			$params['kode_misi_e2']		= $kode;
			$params['tahun_renstra']	= $tahun; 
			$data['data']				= $this->misi->get_where($params);
			$this->load->view('perencanaan/misi_eselon2_form',$data);
		elseif($tipe=="tujuan"):
			$data['renstra']			= $this->setting_th->get_list();
			$params['kode_tujuan_e2']	= $kode;
			$params['tahun_renstra']	= $tahun; 
			$data['data']				= $this->tujuan->get_where($params);
			$this->load->view('perencanaan/tujuan_eselon2_form',$data);
		else:
			$data['renstra']			= $this->setting_th->get_list();
			$params['tahun_renstra']	= $tahun;
			$params['kode_sasaran_e2']	= $kode;
			$data['data']				= $this->sasaran->get_where($params); 
			$this->load->view('perencanaan/sasaran_eselon2_form',$data);
		endif;
	}
	
	function update()
	{
		$tipe	= $this->input->post("tipe");
		$tahun	= $this->input->post("tahun_old");
		$id		= $this->input->post("id");
		$varData= $this->get_from_post($tipe); 
		
		if($tipe=="visi"):
			$this->mgeneral->update(array('kode_visi_e2'=>$id,'tahun_renstra'=>$tahun),$varData,"anev_visi_eselon2");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Visi Eselon 2  berhasil diubah.</p>';
		elseif($tipe=="misi"):
			$this->mgeneral->update(array('kode_misi_e2'=>$id,'tahun_renstra'=>$tahun),$varData,"anev_misi_eselon2");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Misi Eselon 2 berhasil diubah.</p>';
		elseif($tipe=="tujuan"):
			$this->mgeneral->update(array('kode_tujuan_e2'=>$id,'tahun_renstra'=>$tahun),$varData,"anev_tujuan_eselon2");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Tujuan Eselon 2 berhasil diubah.</p>';
		else:
			$this->mgeneral->update(array('kode_sasaran_e2'=>$id,'tahun_renstra'=>$tahun),$varData,"anev_sasaran_eselon2");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Sasaran Eselon 2 berhasil diubah.</p>';		
		endif;
		
		echo $msg;
	}
	
	function hapus($tipe,$tahun,$kode)
	{
		if($tipe=="visi"):
			$this->mgeneral->delete(array('kode_visi_e2'=>$kode,'tahun_renstra'=>$tahun),"anev_visi_eselon2");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Visi eselon 2 berhasil dihapus.</p>';
		elseif($tipe=="misi"):
			$this->mgeneral->delete(array('kode_misi_e2'=>$kode,'tahun_renstra'=>$tahun),"anev_misi_eselon2");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Misi eselon 2 berhasil dihapus.</p>';
		elseif($tipe=="tujuan"):
			$this->mgeneral->delete(array('kode_tujuan_e2'=>$kode,'tahun_renstra'=>$tahun),"anev_tujuan_eselon2");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Tujuan eselon 2 berhasil dihapus.</p>';
		else:
			
			$this->mgeneral->delete(array('kode_sasaran_e2'=>$kode,'tahun_renstra'=>$tahun),"anev_sasaran_eselon2");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Sasaran eselon 2 berhasil dihapus.</p>';
					
		endif;
		
		echo $msg;
	}
}