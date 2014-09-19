<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-22 00:00
 @revision	 :
*/

class Pemrograman_kl extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/kl_model','kl');
		
		$this->load->model('/pemrograman/program_eselon1_model','program_e1');
		$this->load->model('/pemrograman/sasaran_strategis_model','sasaran');
		$this->load->model('/pemrograman/iku_kl_model','iku');
		$this->load->model('/admin/tahun_renstra_model','setting_th');
	/*	$this->load->model('/pemrograman/tujuan_kl_model','tujuan');
		*/
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		//$setting = null;
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
		$template['konten']	= $this->load->view('pemrograman/pemrograman_kl_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadprogram()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		echo $this->load->view('pemrograman/program_kl_v',$data,true); #load konten template file		
	}
	
	function get_body_program($tahun,$kode){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_e1'] = 	$kode;
		$data=$this->program_e1->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->kode_program.'</td>
					<td>'.$d->nama_program.'</td>
				</tr>';
				endforeach; 
				/*<td>
						<a href="#programModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="program_edit(\''.$d->tahun.'\',\''.$d->kode_program.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="program_delete(\''.$d->tahun.'\',\''.$d->kode_program.'\');"><i class="fa fa-times"></i></a>
					</td>*/
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="6" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function loadsastra()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		echo $this->load->view('pemrograman/sasaran_strategis_v',$data,true); #load konten template file		
	}
	function get_body_sastra($tahun,$kl){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_kl'] = 	$kl;
		$data=$this->sasaran->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->sasaran_kl.'</td>
					<td>'.$d->kode_ss_kl.'</td>					
					<td>'.$d->deskripsi.'</td>
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="3" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function loadiku()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		echo $this->load->view('pemrograman/iku_kl_v',$data,true); #load konten template file		
	}
	function get_body_iku($tahun,$kl){
		$params['tahun_renstra'] = 	$tahun;
		$params['kode_kl'] = 	$kl;
		$data=$this->iku->get_all($params); 
		$rs = '';
		if (isset($data)){
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$d->sastra_deskripsi.'</td>
					<td>'.$d->kode_iku_kl.'</td>
					<td>'.$d->deskripsi.'</td>
				</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="3" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function loadpendanaan()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = null;//$this->sasaran->get_all(null);
		echo $this->load->view('pemrograman/pendanaan_kl_v',$data,true); #load konten template file		
	}
	
	
	function get_unit_kerja($kl){
		$data = $this->eselon1->get_all(array("kode_kl"=>$kl));
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
		$data = $this->fungsi_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->fungsi_kl.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function get_tugas($tahun,$kl){
		$data = $this->kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		$rs = '';
		if (isset($data)){
			$rs = '<ol '.((count($data)<=1)?'style="list-style:none;margin-left:-15px;"':'').'>';
			foreach($data as $d){
				$rs .= '<li>'.$d->tugas_kl.'</li>';
			 }
			 $rs .= '</ol>';
		}
		echo $rs;
	}
	
	function init_data($tipe)
	{
		if($tipe=="program"):
			$data[0]->tahun			= '';
			$data[0]->kode_e1 		= '';
			$data[0]->nama_e1 		= '';
			$data[0]->kode_program 	= '';
			$data[0]->nama_program 	= '';
			$data[0]->pagu 			= '';
			$data[0]->realisasi 	= '';
			$data[0]->persen	 	= '';
		elseif($tipe=="misi"):
			$data[0]->tahun_renstra = '';
			$data[0]->kode_kl 		= '';
			$data[0]->nama_kl 		= '';
			$data[0]->kode_misi_kl 	= '';
			$data[0]->misi_kl 		= '';
		elseif($tipe=="tujuan"):
			$data[0]->tahun_renstra = '';
			$data[0]->kode_kl 		= '';
			$data[0]->nama_kl 		= '';
			$data[0]->kode_tujuan_kl= '';
			$data[0]->tujuan_kl 	= '';
		else:
			$data[0]->tahun_renstra = '';
			$data[0]->kode_kl 		= '';
			$data[0]->kode_sasaran_kl= '';
			$data[0]->sasaran_kl 	= '';
		endif;
		
		return $data;
	}
	
	function add($tipe)
	{
		$data['data']		= $this->init_data($tipe);
		if($tipe=="program"):
			$data['eselon1'] 	= $this->eselon1->get_all(null);
			$this->load->view('pemrograman/program_e1_form',$data);
		elseif($tipe=="misi"):
			$data['renstra']	= $this->setting_th->get_list();
			$this->load->view('perencanaan/misi_kl_form',$data);
		elseif($tipe=="tujuan"):
			$data['renstra']	= $this->setting_th->get_list();
			$this->load->view('perencanaan/tujuan_kl_form',$data);
		else:
			$data['renstra']	= $this->setting_th->get_list();
			$this->load->view('perencanaan/sasaran_kl_form',$data);
		endif;
	}
	
	function get_from_post($tipe)
	{
		if($tipe=="program"):
			$data	= array('tahun'			=> $this->input->post("tahun"),
							'kode_e1'		=> $this->input->post("e1"),
							'kode_program'	=> $this->input->post("kode"),
							'nama_program'	=> $this->input->post("nama"),
							'pagu'			=> $this->input->post("pagu"),
							'realisasi'		=> $this->input->post("realisasi"),
							'persen'		=> $this->input->post("persen"),);
		elseif($tipe=="misi"):
			$data	= array('tahun_renstra'	=> $this->input->post("tahun"),
							'kode_kl'		=> $this->input->post("kl"),
							'kode_misi_kl'	=> $this->input->post("kode"),
							'misi_kl'		=> $this->input->post("misi"));
		elseif($tipe=="tujuan"):
			$data	= array('tahun_renstra'	=> $this->input->post("tahun"),
							'kode_kl'		=> $this->input->post("kl"),
							'kode_tujuan_kl'=> $this->input->post("kode"),
							'tujuan_kl'		=> $this->input->post("tujuan"));
		else:
			$data	= array('tahun_renstra'	=> $this->input->post("tahun"),
							'kode_kl'		=> $this->input->post("kl"),
							'kode_sasaran_kl'=> $this->input->post("kode"),
							'sasaran_kl'	=> $this->input->post("sasaran"));
		endif;
		
		return $data;
	}
	
	function save()
	{
		$tipe		= $this->input->post("tipe");
		$tahun		= $this->input->post("tahun");
		$kode		= $this->input->post("kode");
		
		if($tipe=="program"): 
			$tabel		= "anev_program_eselon1";	
			$field_cek	= "kode_program";
		elseif($tipe=="misi"): 
			$tabel		= "anev_misi_kl";
			$field_cek	= "kode_program";
		elseif($tipe=="tujuan"): 
			$tabel		= "anev_tujuan_kl";
			$field_cek	= "kode_program";
		else:
			$tabel		= "anev_sasaran_kl";
			$field_cek	= "kode_program";
		endif;
		
		#cek kode sudah ada atau belum
		$cekdata 	= $this->mgeneral->getValue($field_cek,array("$field_cek"=>$kode,'tahun'=>$tahun),$tabel);
		
		if($cekdata==""):
			$varData	= $this->get_from_post($tipe);
			$this->mgeneral->save($varData,$tabel);
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>'.ucfirst($tipe).' berhasil ditambahkan.</p>';
		else:
			$msg = '<h5><i class="fa fa-warning"></i> <b>Gagal ditambahkan</b></h5>
					<p>Kode '.$tipe.' sudah ada.</p>';
		endif;
		
		echo $msg;
	}
	
	function edit($tipe,$tahun,$kode)
	{
		if($tipe=="program"):
			$data['eselon1'] 			= $this->eselon1->get_all(null);
			$params['kode_program']		= $kode;
			$params['tahun']			= $tahun; 
			$data['data']				= $this->program_e1->get_where($params);
			$this->load->view('pemrograman/program_e1_form',$data);
		elseif($tipe=="misi"):
			$data['renstra']			= $this->setting_th->get_list();
			$params['kode_misi_kl']		= $kode;
			$params['tahun_renstra']	= $tahun; 
			$data['data']				= $this->misi->get_where($params);
			$this->load->view('perencanaan/misi_kl_form',$data);
		elseif($tipe=="tujuan"):
			$data['renstra']			= $this->setting_th->get_list();
			$params['kode_tujuan_kl']	= $kode;
			$params['tahun_renstra']	= $tahun; 
			$data['data']				= $this->tujuan->get_where($params);
			$this->load->view('perencanaan/tujuan_kl_form',$data);
		else:
			$data['renstra']			= $this->setting_th->get_list();
			$params['tahun_renstra']	= $tahun;
			$params['kode_sasaran_kl']	= $kode;
			$data['data']				= $this->sasaran->get_where($params); 
			$this->load->view('perencanaan/sasaran_kl_form',$data);
		endif;
	}
	
	function update()
	{
		$tipe	= $this->input->post("tipe");
		$tahun	= $this->input->post("tahun_old");
		$id		= $this->input->post("id");
		$varData= $this->get_from_post($tipe); 
		
		if($tipe=="program"):
			$this->mgeneral->update(array('kode_program'=>$id,'tahun'=>$tahun),$varData,"anev_program_eselon1");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Program  berhasil diubah.</p>';
		elseif($tipe=="misi"):
			$this->mgeneral->update(array('kode_misi_kl'=>$id,'tahun_renstra'=>$tahun),$varData,"anev_misi_kl");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Misi kementerian  berhasil diubah.</p>';
		elseif($tipe=="tujuan"):
			$this->mgeneral->update(array('kode_tujuan_kl'=>$id,'tahun_renstra'=>$tahun),$varData,"anev_tujuan_kl");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Tujuan kementerian  berhasil diubah.</p>';
		else:
			$this->mgeneral->update(array('kode_sasaran_kl'=>$id,'tahun_renstra'=>$tahun),$varData,"anev_sasaran_kl");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Sasaran kementerian berhasil diubah.</p>';		
		endif;
		
		echo $msg;
	}
	
	function hapus($tipe,$tahun,$kode)
	{
		if($tipe=="program"):
			$this->mgeneral->delete(array('kode_program'=>$kode,'tahun'=>$tahun),"anev_program_eselon1");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Program berhasil dihapus.</p>';
		elseif($tipe=="misi"):
			$this->mgeneral->delete(array('kode_misi_kl'=>$kode,'tahun_renstra'=>$tahun),"anev_misi_kl");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Misi kementerian berhasil dihapus.</p>';
		elseif($tipe=="tujuan"):
			$this->mgeneral->delete(array('kode_tujuan_kl'=>$kode,'tahun_renstra'=>$tahun),"anev_tujuan_kl");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Tujuan kementerian berhasil dihapus.</p>';
		else:
			
			$this->mgeneral->delete(array('kode_sasaran_kl'=>$kode,'tahun_renstra'=>$tahun),"anev_sasaran_kl");
			$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
					<p>Sasaran kementerian berhasil dihapus.</p>';
					
		endif;
		
		echo $msg;
	}
}