<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-18 17:00
 @revision	 :
*/

class Matriks_pembangunan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/kl_model','kl');
		$this->load->model('/perencanaan/sasaran_kl_model','sasaran_kl');
		$this->load->model('/perencanaan/program_eselon1_model','program_e1');
		$this->load->model('/pemrograman/sasaran_strategis_model','sasaran_strategis');
		$this->load->model('/pemrograman/iku_kl_model','iku_kl');
		$this->load->model('/laporan/matriks_pembangunan_model','matriks');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$setting['header']	= '';
		$setting['sd_right']	= '';
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		$template['konten']	= $this->load->view('laporan/matriks_pembangunan_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function get_detail($tahun_renstra,$rentang_awal,$rentang_akhir,$kl)
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->print_matriks($rentang_awal,$rentang_akhir,$kl);
		$nama_kl = $this->kl->get_nama(array("tahun_renstra"=>$tahun_renstra,'kode_kl'=>$kl));
		$data['periode'] = $rentang_awal.'-'.$rentang_akhir.'<br>'.$nama_kl;
		$template['konten']	= $this->load->view('laporan/matriks_pembangunan_print_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container_popup',$template);
	}
	
	function get_sasaran($tahun,$kl,$range_awal,$range_akhir){
		$dataAll = array();
		$data = $this->sasaran_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		$arrTahun = explode("-",$tahun);		
		//$rangetahun = $arrTahun[1]-$arrTahun[0];
		$rangetahun = $range_akhir-$range_awal;
		$rs ='';// '<form  method="post" id="matriks_form" name="matriks_form" action="'.base_url().'laporan/matriks_pembangunan/save/" >';//role="form"
		$rs .= '<table class="display table table-bordered table-striped">';
		
		$rs .= '
		<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center" width="20%" rowspan="2">Sasaran Kementerian</th>					
					
					<th style="vertical-align:middle;text-align:center" width="40%" rowspan="2">Indikator</th>
					<th style="vertical-align:middle;text-align:center" width="10%" rowspan="2">Satuan</th>
					<th style="vertical-align:middle;text-align:center" width="100px" colspan="'.($rangetahun+1).'">Realisasi Pencapaian</th>
					<th style="vertical-align:middle;text-align:center" width="40%" rowspan="2">#</th>
					<th style="vertical-align:middle;text-align:center" width="100px" rowspan="2">Keterangan</th>
				</tr>';
		$rs .= 	'<tr>';
		$total_row =0;
		$rangetahun_arr = array();
		//for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)
		for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
			$rs .= 	'<th style="vertical-align:middle;text-align:center">'.$colTahun.'</th>';
			$rangetahun_arr[] = $colTahun;
		}	
					
		$rs .= 	'</tr></thead>';	
		$rs .= '<tbody>';		
		$i=0;
		 $j=0;
		
		foreach($data as $d){
			
			$data_indikator = $this->matriks->get_indikator(array("kode_sasaran_kl"=>$d->kode_sasaran_kl,"range_awal"=>$range_awal,"range_akhir"=>$range_akhir));
			$kode_iku = '';
			$data[$i]->rowspan=0;
			if (isset($data_indikator)) {
				foreach($data_indikator as $ss){
					if ($kode_iku != $ss->kode_iku_e1){
						$kode_iku = $ss->kode_iku_e1;
						$data[$i]->indikator[$j]->deskripsi = $ss->deskripsi;
						$data[$i]->indikator[$j]->satuan = $ss->satuan;
						$data[$i]->indikator[$j]->kode_iku_e1 = $ss->kode_iku_e1;
						//for ($x=0;$x<count($rangetahun_arr);$x++){
							$data[$i]->indikator[$j]->realisasi[$ss->tahun] = $ss->realisasi;
						//}
						$data[$i]->rowspan++ ;
						$j++;
					}else{
						$data[$i]->indikator[$j-1]->realisasi[$ss->tahun] = $ss->realisasi;
					}
					//$data[$i]->indikator=$data_indikator;
					//$data[$i]->rowspan += sizeof($data[$i]->indikator);
				/*if (sizeof($data[$i]->indikator)>0){							
					$j=0;
					foreach($data_indikator as $ss){										
						$data[$i]->strategis[$j]->iku = $data_iku;					
						$data[$i]->strategis[$j]->rowspan = sizeof($data_iku);
						$j++;
					}			
				}
				*/
				}
			}
			$i++;
		 }
		 
		 $i=0;
		 foreach($data as $d){			
			$rs .= '<tr>';
			if ($data[$i]->rowspan==0) 
				$rs .= '<td >'.$d->sasaran_kl.'</td>';
			else
				$rs .= '<td rowspan="'.($data[$i]->rowspan).'" >'.$d->sasaran_kl.'</td>';
			//$rs .= '<td >'.$d->sasaran_kl.'</td>';
			
			//$rs .= '</tr>';
			if (isset($data[$i]->indikator)) {	
				if ( sizeof($data[$i]->indikator)>0){				
					$j=0;				
					$textarea_opt = array("rows"=>2,"cols"=>20,'readonly'=>'readonly');
					foreach($data[$i]->indikator as $ss){
						if ($j>0) $rs .= '<tr>';
							
						
						$rs .= '<td    valign="top">'.$ss->deskripsi.'</td>';
						$rs .= '<td    valign="top">'.$ss->satuan.'</td>';
						$textarea_opt['id']="keterangan$total_row";
						$textarea_opt['name']="keterangan$total_row";
						for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
							$realisasi = isset($ss->realisasi[$colTahun])?$ss->realisasi[$colTahun]:'-';
							$value = $colTahun.';'.$d->kode_sasaran_kl.';'.$ss->kode_iku_e1.';'.$realisasi;
							$rs .= 	'<td align="right"><input type="hidden" value="'.$value.'" name="data_'.$colTahun.'_'.$total_row.'" />'.$this->utility->cekNumericFmt($realisasi).'</td>';
						}
						$rs .= '<td    valign="top"><input type="checkbox" onclick="clickIku(\''.$total_row.'\')" name="chk'.$total_row.'" id="chk'.$total_row.'"/></td>';
						$rs .= '<td    valign="top">'.form_textarea($textarea_opt).'</td>';			
						$rs .= '</tr>';
						$j++;
						$total_row++;
					}			
				}
				else { 				
				}
			}else {
				$rs .= '<td >&nbsp;</td>';
				$rs .= '<td >&nbsp;</td>';
				$rs .= '<td >&nbsp;</td>';
				
				for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
					$rs .= '<td >&nbsp;</td>';
				}
				$rs .= '<td >&nbsp;</td>';
				$rs .= '<td >&nbsp;</td>';
				$rs .= '</tr>';
			}
			
			$i++;
		 }
		 $rs .= '</tbody>';		
		 $rs .= '</table>';
		
		 $rs .= '<div class="modal-footer">
                	<div class="pull-right">
                		<!--<button type="button" id="btn-close" class="btn btn-danger" data-dismiss="modal" class="close">Batalkan</button>-->
						<input type="hidden" name="rowcount" value="'.$total_row.'"/>
						<input type="hidden" name="range_awal" value="'.$range_awal.'"/>
						<input type="hidden" name="range_akhir" value="'.$range_akhir.'"/>
                     	<button type="submit" id="btn-save" class="btn btn-info">Simpan</button>
                	</div>
                </div>';
	//	$rs .= '</form>';
		echo $rs;
	}
	
	function print_matriks($range_awal,$range_akhir,$kl){
		$dataAll = array();
		$data = $this->matriks->get_all(array("kode_kl"=>$kl,"range_awal"=>$range_awal,"range_akhir"=>$range_akhir));

		//$rangetahun = $arrTahun[1]-$arrTahun[0];
		$rangetahun = $range_akhir-$range_awal;
		
		$rs = '<table class="display table table-bordere19d table-striped">';
		
		$rs .= '
		<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center" width="20%" rowspan="2">Sasaran Kementerian</th>					
					
					<th style="vertical-align:middle;text-align:center" width="40%" rowspan="2">Indikator</th>
					<th style="vertical-align:middle;text-align:center" width="10%" rowspan="2">Satuan</th>
					<th style="vertical-align:middle;text-align:center" width="100px" colspan="'.($rangetahun+1).'">Realisasi Pencapaian</th>
					
					<th style="vertical-align:middle;text-align:center" width="100px" rowspan="2">Keterangan</th>
				</tr>';
		$rs .= 	'<tr>';
		$total_row =0;
		$rangetahun_arr = array();
		
		for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
			$rs .= 	'<th style="vertical-align:middle;text-align:center">'.$colTahun.'</th>';
			$rangetahun_arr[] = $colTahun;
		}	
					
		$rs .= 	'</tr></thead>';	
		$rs .= '<tbody>';		
		$i=0;
		 $j=0;
		//$dataTampil = array();
		$kode_sasaran_kl = '';
		$kode_iku_e1='';
		//$dataTampil = new stdClass();
		foreach($data as $d){
			
			if ($kode_sasaran_kl!=$d->kode_sasaran_kl){
				$dataTampil[$i]->rowspan =0;
				$kode_sasaran_kl=$d->kode_sasaran_kl;
				$dataTampil[$i]->sasaran_kl = $d->sasaran_kl;
				$dataTampil[$i]->kode_sasaran_kl = $d->kode_sasaran_kl;
				if (($kode_iku_e1!=$d->kode_iku_e1)){
					$kode_iku_e1=$d->kode_iku_e1;
					
					$dataTampil[$i]->indikator[$j]->deskripsi = $d->deskripsi;
					$dataTampil[$i]->indikator[$j]->satuan = $d->satuan;
					$dataTampil[$i]->indikator[$j]->keterangan = $d->keterangan;
					$dataTampil[$i]->indikator[$j]->realisasi[$d->tahun] = $d->realisasi;
					$dataTampil[$i]->rowspan++ ;
					$j++;
				} 
				$i++;
			}else {
			
				if (($kode_iku_e1!=$d->kode_iku_e1)){
					//$j=0;
					$kode_iku_e1=$d->kode_iku_e1;
					
					$dataTampil[$i-1]->indikator[$j]->deskripsi = $d->deskripsi;
					$dataTampil[$i-1]->indikator[$j]->satuan = $d->satuan;
					$dataTampil[$i-1]->indikator[$j]->keterangan = $d->keterangan;
					$dataTampil[$i-1]->indikator[$j]->realisasi[$d->tahun] = $d->realisasi;
					$dataTampil[$i-1]->rowspan++ ;
					$j++;
				}else{
					/*$dataTampil[$i-1]->indikator[$j-1]->deskripsi = $d->deskripsi;
					$dataTampil[$i-1]->indikator[$j-1]->satuan = $d->satuan;
					$dataTampil[$i-1]->indikator[$j-1]->keterangan = $d->keterangan;
					$dataTampil[$i-1]->indikator[$j-1]->realisasi[$d->tahun] = $d->realisasi;*/
					if ($dataTampil[$i-1]->indikator[$j-1]->deskripsi==""){
						$dataTampil[$i-1]->indikator[$j-1]->deskripsi = $d->deskripsi;
						$dataTampil[$i-1]->indikator[$j-1]->satuan = $d->satuan;
					}
					$dataTampil[$i-1]->indikator[$j-1]->realisasi[$d->tahun] = $d->realisasi;
					//$dataTampil[$i-1]->rowspan++ ;
				//	$j++;
				}
			
			}
			
			
		 }
		
		 $i=0;
		 foreach($dataTampil as $d){			
			//var_dump($d->rowspan);
			$rs .= '<tr>';
			if ($d->rowspan==0) 
				$rs .= '<td >'.$d->sasaran_kl.'</td>';
			else
				$rs .= '<td rowspan="'.($d->rowspan).'" >'.$d->sasaran_kl.'</td>';
			//$rs .= '<td >'.$d->sasaran_kl.'</td>';
			
			//$rs .= '</tr>';
			if (isset($d->indikator)) {	
			//	var_dump( sizeof($d->indikator));
				if ( sizeof($d->indikator)>0){				
					$j=0;				
					
					foreach($d->indikator as $ss){
						if ($j>0) $rs .= '<tr>';
							
						
						$rs .= '<td    valign="top">'.$ss->deskripsi.'</td>';
						$rs .= '<td    valign="top">'.$ss->satuan.'</td>';
						
						for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
							$realisasi = isset($ss->realisasi[$colTahun])?$ss->realisasi[$colTahun]:'-';
						
							$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
						}
						
						$rs .= '<td    valign="top">'.$ss->keterangan.'</td>';			
						$rs .= '</tr>';
						$j++;
						
					}			
				}
				else { 				
				}
			}else {
				$rs .= '<td >&nbsp;</td>';
				$rs .= '<td >&nbsp;</td>';
				$rs .= '<td >&nbsp;</td>';
				
				for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
					$rs .= '<td >&nbsp;</td>';
				}
				
				$rs .= '<td >&nbsp;</td>';
				$rs .= '</tr>';
			}
			
			$i++;
		 }
		 $rs .= '</tbody>';		
		 $rs .= '</table>';
		
		
		return $rs;
	}
	
	public function save(){
		$total_row	= $this->input->post("rowcount");
		$range_awal	= $this->input->post("range_awal");
		$range_akhir	= $this->input->post("range_akhir");
		$j=0;
		for ($i=0;$i<$total_row;$i++){
			$chk =  $this->input->post("chk".$i);
			if ($chk){
				for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
					$data = $this->input->post('data_'.$colTahun.'_'.$i);
					
					$varData[$j]['tahun'] = $this->utility->ourEkstrakString($data,';',0);
					$varData[$j]['kode_sasaran_kl'] = $this->utility->ourEkstrakString($data,';',1);
					$varData[$j]['kode_iku_e1'] = $this->utility->ourEkstrakString($data,';',2);
					$varData[$j]['realisasi'] = $this->utility->ourEkstrakString($data,';',3);
					$varData[$j]['keterangan'] = $this->input->post("keterangan".$i);
					$j++;
				}
			}
		}
	//	var_dump($varData);
		$this->matriks->save($varData);
		
		$msg = '<h5><i class="fa fa-check-square-o"></i> <b>Sukses</b></h5>
				<p>Data Matriks Pembangunan berhasil ditambahkan.</p>';
				
		echo $msg;
	}
	
	function get_sasaran_ga_jadi_($tahun,$kl){
		$data = $this->sasaran_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun));
		
		$rs = '<table class="table">';
		$rs .= '<tr>
					<td width="30%">Sasaran</td>
					<td width="40%">Sasaran Strategis</td>
					<td width="30%">Indikator</td>
				</tr>';
		foreach($data as $d){
			$data_strategis = $this->sasaran_strategis->get_renstra(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun,"kode_sasaran_kl"=>$d->kode_sasaran_kl));
			$jml_data_strategis = count($data_strategis);
			
			
			$rs .= '<tr>';
			$rs .= '<td >'.$d->sasaran_kl.'</td>';
			if ($jml_data_strategis>0){
				$rs .= '<td colspan="2">';
				$rs .= '<table class="" style="margin-top:-13px" border="0" width="100%">';
				//$rs .="<ol>";
				foreach($data_strategis as $ss){
					$rs .= '<tr>';
					$rs .= '<td width="50%" valign="top">'.$ss->deskripsi.'</td>';
					$data_iku = $this->iku_kl->get_all(array("kode_kl"=>$kl,"tahun_renstra"=>$tahun,"kode_ss_kl"=>$ss->kode_ss_kl));
					$jml_data_iku = count($data_iku);
					if ($jml_data_iku>0){
						$rs .= '<td width="50%" valign="top">';
						$rs .="<ol style='margin:-2px -15px -10px -30px;'>";
						foreach($data_iku as $iku){
							$rs .= '<li>'.$iku->deskripsi.'</li>';
						}
						$rs .="</ol>";
						$rs .= '</td>';
					}
					else {
						$rs .= '<td width="50%">&nbsp;</td>';
					}
					$rs .= '</tr>';
				}
				//$rs .="</ol>";
				$rs .= '</table>';
				
				
				$rs .= '</td>';
				
			}
			else { 
				$rs .= '<td></td>';
				$rs .= '<td></td>';
			}
			$rs .= '</tr>';
		 }
		 $rs .= '</table>';
		echo $rs;
	}
}