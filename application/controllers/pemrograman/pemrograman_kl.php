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
		$this->load->model('/pemrograman/target_capaian_model','target');
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
		$data['page']		= "kl";
		echo $this->load->view('pemrograman/program_kl_v',$data,true); #load konten template file		
	}
	
	function get_body_program($tahun,$kode){
		$params['tahun_renstra'] = 	$tahun;
		if($kode!=0)$params['kode_e1'] = 	$kode;
		$data=$this->program_e1->get_all($params); 
		$rs = '';
		if (isset($data)){
			$no=1;
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$no.'</td>
					<td>'.$d->nama_e1.'</td>
					<td>'.$d->kode_program.'</td>
					<td>'.$d->nama_program.'</td>
				</tr>';
				$no++;
				endforeach; 
				/*<td>
						<a href="#programModal" data-toggle="modal"  class="btn btn-info btn-xs" title="Edit" onclick="program_edit(\''.$d->tahun.'\',\''.$d->kode_program.'\');"><i class="fa fa-pencil"></i></a>
						<a href="#" class="btn btn-danger btn-xs" title="Hapus" onclick="program_delete(\''.$d->tahun.'\',\''.$d->kode_program.'\');"><i class="fa fa-times"></i></a>
					</td>*/
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="4" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
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
		if($kl!="-1")$params['kode_kl'] = 	$kl;
		$data=$this->sasaran->get_all($params); 
		$rs = '';
		if (isset($data)){
			$no=1;
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$no.'</td>
					<td>'.$d->kode_ss_kl.'</td>					
					<td>'.$d->deskripsi.'</td>
				</tr>';
				$no++;
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
		if($kl!="-1")$params['kode_kl'] = 	$kl;
		$data=$this->iku->get_all($params); 
		$rs = '';
		if (isset($data)){
			$no=1;
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td>'.$no.'</td>
					<td>'.$d->kode_iku_kl.'</td>
					<td>'.$d->deskripsi.'</td>
					<td>'.$d->satuan.'</td>
				</tr>';
				$no++;
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="3" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function loadtarget()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		echo $this->load->view('pemrograman/target_capaian_kl_v',$data,true); #load konten template file		
	}
	
	function get_body_target($tahun,$sasaran){
		
		$params['tahun_renstra'] = 	$tahun;
		if($sasaran!="0")$params['sasaran'] = $sasaran;
		
		$data=$this->target->get_all($params); 
		$rs = '';
		if (isset($data)){
			$no=1;
			foreach($data as $d): 
				$rs .= '<tr class="gradeX">
					<td width="3%">'.$no.'</td>
					<td>'.$d->kode_iku_kl.'</td>					
					<td width="20%">'.$d->deskripsi.'</td>
					<td>'.$d->satuan.'</td>					
					<td width="10%">'.$this->cek_tipe_numerik($d->target_thn1).'</td>					
					<td width="10%">'.$this->cek_tipe_numerik($d->target_thn2).'</td>					
					<td width="10%">'.$this->cek_tipe_numerik($d->target_thn3).'</td>					
					<td width="10%">'.$this->cek_tipe_numerik($d->target_thn4).'</td>					
					<td width="10%">'.$this->cek_tipe_numerik($d->target_thn5).'</td>
				</tr>';
				$no++;
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
				<td colspan="10" align="center">&nbsp;<i class="fa fa-exclamation-triangle"></i> data tidak ditemukan</td>
			</tr>';
		}
		echo $rs;
	}
	
	function cek_tipe_numerik($str)
	{
		if(is_numeric($str)):
			$cekFormat = explode(".",$str);
			if(count($cekFormat)==1): $fangka = "0"; else: $fangka="2"; endif;
			$format = number_format($str,$fangka,',','.');
			return $format;
		else:
			return $str;
		endif;
	}
	
	function loadpendanaan()
	{
		$setting['sd_left']	= array('cur_menu'	=> "PEMROGRAMAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['renstra']	= $this->setting_th->get_list();
		$data['eselon1'] 	= $this->eselon1->get_list(null);
		$data['page']		= "kl";
		echo $this->load->view('pemrograman/dana_kl_v',$data,true); #load konten template file		
	}
	
	function get_body_pendanaan($tahun,$kode){
		$params['tahun_renstra'] = 	$tahun;
		if($kode!=0)$params['kode_e1'] = 	$kode;
		$data=$this->program_e1->get_pendanaan2($params); 
		$rs = '';
		if (isset($data)){
			$no=1; $total = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total_all = 0;
			foreach($data as $d): 
				$total = $d->target_thn1+$d->target_thn2+$d->target_thn3+$d->target_thn4+$d->target_thn5;
				$rs .= '<tr class="gradeX">
					<td>'.$no.'</td>
					<td>'.$d->nama_program.'</td>
					<td>'.$this->cek_tipe_numerik($d->target_thn1).'</td>
					<td>'.$this->cek_tipe_numerik($d->target_thn2).'</td>
					<td>'.$this->cek_tipe_numerik($d->target_thn3).'</td>
					<td>'.$this->cek_tipe_numerik($d->target_thn4).'</td>
					<td>'.$this->cek_tipe_numerik($d->target_thn5).'</td>
					<td>'.$this->cek_tipe_numerik($total).'</td>
				</tr>';
				$total1 = $total1+$d->target_thn1;
				$total2 = $total2+$d->target_thn2;
				$total3 = $total3+$d->target_thn3;
				$total4 = $total4+$d->target_thn4;
				$total5 = $total5+$d->target_thn5;
				$total_all = $total_all+$total;
				$no++;
				endforeach; 
				$rs .= '<tr class="gradeX">
						<td colspan="2"><center><b>Total</b></center></td>
						<td><b>'.$this->cek_tipe_numerik($total1).'</b></td>
						<td><b>'.$this->cek_tipe_numerik($total2).'</b></td>
						<td><b>'.$this->cek_tipe_numerik($total3).'</b></td>
						<td><b>'.$this->cek_tipe_numerik($total4).'</b></td>
						<td><b>'.$this->cek_tipe_numerik($total5).'</b></td>
						<td><b>'.$this->cek_tipe_numerik($total_all).'</b></td>
					 </tr>
				';
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
	
	function print_program_pdf($tahun,$kode)
   {
	    $this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Program Kementerian Perhubungan');
		$pdf->SetHeaderMargin(15);
		$pdf->SetTopMargin(15);
		$pdf->SetLeftMargin(15);
		$pdf->SetRightMargin(15);
		$pdf->setFooterMargin(5);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);	
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		
		// set font
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage();
		//var_dump($e1);
		 $pdf->Write(0, 'Program Kementerian Perhubungan ', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

	   	$params['tahun_renstra'] = 	$tahun;
		if($kode!=0)$params['kode_e1'] = 	$kode;
		$data['result'] =$this->program_e1->get_all($params);
		
		$html = $this->load->view('pemrograman/print/pdf_program_kl',$data,true);
	//	$html = $data['ikuE2'];
		//var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('ProgramKementerian.pdf', 'I');
		
	
   }
   
   function print_target_pdf($tahun,$sasaran)
   {
	    $this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Target Capaian Kinerja Kementerian Perhubungan');
		$pdf->SetHeaderMargin(15);
		$pdf->SetTopMargin(15);
		$pdf->SetLeftMargin(15);
		$pdf->SetRightMargin(15);
		$pdf->setFooterMargin(5);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);	
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		
		// set font
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage();
		//var_dump($e1);
		 $pdf->Write(0, 'Target Capaian Kinerja Kementerian Perhubungan ', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

	   	$params['tahun_renstra'] = 	$tahun;
		if($sasaran!="0")$params['sasaran'] = $sasaran;
		$data['result']=$this->target->get_all($params); 
		$data['renstra'] = $tahun;
				
		$html = $this->load->view('pemrograman/print/pdf_target_kl',$data,true);
	//	$html = $data['ikuE2'];
		//var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('targetCapaianKinerjaKementerian.pdf', 'I');
		
	
   }
   
   function print_dana_pdf($tahun,$kode)
   {
	    $this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Kebutuhan Pendanaan Kementerian Perhubungan');
		$pdf->SetHeaderMargin(15);
		$pdf->SetTopMargin(15);
		$pdf->SetLeftMargin(15);
		$pdf->SetRightMargin(15);
		$pdf->setFooterMargin(5);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);	
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		
		// set font
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage();
		//var_dump($e1);
		 $pdf->Write(0, 'Kebutuhan Pendanaan Kementerian Perhubungan ', '', 0, 'C', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

	   	$params['tahun_renstra'] = 	$tahun;
		if($kode!=0)$params['kode_e1'] = 	$kode;
		$data['result']=$this->program_e1->get_pendanaan2($params); 
		$data['renstra'] = $tahun;
			
		$html = $this->load->view('pemrograman/print/pdf_dana_kl',$data,true);
	//	$html = $data['ikuE2'];
		//var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('kebutuhanPendanaanKementerian.pdf', 'I');
		
	
   }
}