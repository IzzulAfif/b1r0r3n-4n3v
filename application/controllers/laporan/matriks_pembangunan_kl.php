<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-18 17:00
 @revision	 :
*/

class Matriks_pembangunan_kl extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/kl_model','kl');
		$this->load->model('/perencanaan/sasaran_kl_model','sasaran_kl');
		$this->load->model('/perencanaan/program_eselon1_model','program_e1');
		$this->load->model('/pemrograman/sasaran_strategis_model','sasaran_strategis');
		$this->load->model('/pemrograman/iku_kl_model','iku_kl');
		$this->load->model('/laporan/matriks_pembangunan_kl_model','matriks');
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
	
	
	function loadpage(){
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data = null;
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/matriks_pembangunan_kl_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_detail($tahun_renstra,$rentang_awal,$rentang_akhir,$kl)
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->print_matriks($rentang_awal,$rentang_akhir,$kl,true);
		$nama_kl = $this->kl->get_nama(array("tahun_renstra"=>$tahun_renstra,'kode_kl'=>$kl));
		$data['periode'] = $rentang_awal.'-'.$rentang_akhir.'<br>'.$nama_kl;
		$data['renstra'] = $tahun_renstra;
		$data['rentang_awal'] = $rentang_awal;
		$data['rentang_akhir'] = $rentang_akhir;
		$data['kl'] = $kl;
		$template['konten']	= $this->load->view('laporan/matriks_pembangunan_print_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container_popup',$template);
	}
	
	function get_output($tahun,$kl,$range_awal,$range_akhir,$ajaxCall=true,$forExcel=false){
		$data = $this->matriks->get_sasaran_kl(array("tahun_renstra"=>$tahun));
		$arrTahun = explode("-",$tahun);				
		$rangetahun = $range_akhir-$range_awal;
		$rs ='';// '<form  method="post" id="matriks_form" name="matriks_form" action="'.base_url().'laporan/matriks_pembangunan/save/" >';//role="form"
		if ($ajaxCall)
			$rs = '<table class="display table table-bordered table-striped" width="100%">';
		else
			$rs = '<table  border="1" cellpadding="4" cellspacing="0">';
		
		$widthSasaran = 100+((4-$rangetahun)*20);
		$widthIndikator =  100+((4-$rangetahun)*50);
		
		$rs .= '<thead><tr  align="center">
					<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:1%" width="30">No.</th>
					<th style="vertical-align:middle;text-align:center;width:20%" width="'.$widthSasaran.'">Sasaran Kemenhub</th>				
					<th style="vertical-align:middle;text-align:center;;width:1%" width="30" > No.</th>				
					<th style="vertical-align:middle;text-align:center:width:40%"  width="'.$widthIndikator.'">Indikator</th>
					<th style="vertical-align:middle;text-align:center;width:10%"  width="80">Satuan</th>';
		
		$total_row =0;
		$rangetahun_arr = array();
		//for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)
		for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
			$rs .= 	'<th style="vertical-align:middle;text-align:center" width="80">'.$colTahun.'</th>';
			$rangetahun_arr[] = $colTahun;
		}	
					
		$rs .= 	'</tr></thead>';	
		$rs .= '<tbody>';		
		$i=0;
		 $j=0;
		if (isset($data)){
			foreach($data as $d){
				$indikator = $this->matriks->get_indikator(array("kode_sasaran_kl"=>$d->kode_sasaran_kl,"rentang_awal"=>$range_awal,"rentang_akhir"=>$range_akhir));
				if (isset($indikator)){
					$data[$i]->rowspan = 0;
					$j=0;
					$kode_iku_e1 = '-1';
					foreach ($indikator as $iku){
						//if ($kode_iku_e1!=$iku->kode_iku_e1){
						$data[$i]->iku[$j]->deskripsi = $iku->deskripsi;
						$data[$i]->iku[$j]->satuan = $iku->satuan;
						for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
							$data[$i]->iku[$j]->total[$colTahun]=$this->matriks->hitung_total(array("tahun"=>$colTahun,"kode_iku_e1"=>$iku->kode_iku_e1));
						}
						
						$data[$i]->iku[$j]->satuan = $iku->satuan;
						$data[$i]->rowspan++;
						$j++;
					}
					
				}
				else {
					$x=0;
					$data[$i]->rowspan = 1;
					$data[$i]->iku[$x]->deskripsi = '';
					$data[$i]->iku[$x]->satuan = '';
					
				}
				$i++;
			} 
			 
			 $i=1;
			foreach($data as $d){
				
				//continue;
				$rs .= '<tr>';
				$rs .= '<td   width="30"  valign="top" rowspan="'.$d->rowspan.'">'.($i++).'</td>';
				$rs .= '<td   width="'.$widthSasaran.'" valign="top" rowspan="'.$d->rowspan.'">'.$d->deskripsi.'</td>';
				$j=0;				
				foreach ($d->iku as $iku){
					if ($j==0){					
				
					}else {										
						$rs .= '<tr>';					
					}
					
					$rs .= '<td  width="30"  valign="top">'.($j+1).'</td>';
					$rs .= '<td  width="'.$widthIndikator.'"  valign="top">'.$iku->deskripsi.'</td>';
					$rs .= '<td   width="80" valign="top">'.$iku->satuan.'</td>';
					for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
						$vol =0;
							
							if (isset($iku->total[$colTahun]))
								$vol = $iku->total[$colTahun];
							$rs .= '<td width="80" align="right">'.$this->utility->cekNumericFmt($vol).'</td>';				
					}
					$rs .= '</tr>';
					$j++;
				}
				
			}
			$rs .= '</tbody></table>'; 
		}
		else {
			$rs = 'Data Tidak Ditemukan';
		}
		if ($forExcel){
			return $data;
		}
		else {
			if ($ajaxCall)	echo $rs;
			else return $rs;
		}
	}
	
	function get_sasaran($tahun,$kl,$range_awal,$range_akhir){
		$dataAll = array();
		$data = $this->matriks->get_sasaran_kl(array("tahun_renstra"=>$tahun));
		$arrTahun = explode("-",$tahun);				
		$rangetahun = $range_akhir-$range_awal;
		$rs ='';// '<form  method="post" id="matriks_form" name="matriks_form" action="'.base_url().'laporan/matriks_pembangunan/save/" >';//role="form"
		$rs .= '<table class="display table table-bordered table-striped">';
		
		$rs .= '<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center" width="20%" rowspan="2">Sasaran Kemenhub</th>				
					<th style="vertical-align:middle;text-align:center" width="40%" rowspan="2">Indikator</th>
					<th style="vertical-align:middle;text-align:center" width="10%" rowspan="2">Satuan</th>
					<th style="vertical-align:middle;text-align:center" width="100px" colspan="'.($rangetahun+1).'">Realisasi Pencapaian</th>
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
			$kode_iku = '-1';
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
					
				}
			}
			$i++;
		 }
		 
		 $i=0;
		 foreach($data as $d){			
			$rs .= '<tr>';
			if ($data[$i]->rowspan==0) 
				$rs .= '<td >'.$d->deskripsi.'</td>';
			else
				$rs .= '<td rowspan="'.($data[$i]->rowspan).'" >'.$d->deskripsi.'</td>';
			//$rs .= '<td >'.$d->deskripsi.'</td>';
			
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
							$value = $colTahun.';'.$d->kode_ss_kl.';'.$ss->kode_iku_e1.';'.$realisasi;
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
	
	function print_matriks($range_awal,$range_akhir,$kl,$ajaxCall=true){
		$dataAll = array();
		$data = $this->matriks->get_all(array("range_awal"=>$range_awal,"range_akhir"=>$range_akhir));

		//$rangetahun = $arrTahun[1]-$arrTahun[0];
		$rangetahun = $range_akhir-$range_awal;
		if ($ajaxCall)
				$rs = '<table class="display table table-bordered table-striped" width="100%">';
			else
				$rs = '<table  border="1" cellpadding="4" cellspacing="0">';
		//$rs = '<table class="display table table-bordered table-striped">';
		
		$rs .= '<thead><tr  align="center">
					<th style="vertical-align:middle;text-align:center;width:25%" width="100" rowspan="2">Sasaran Strategis</th>										
					<th style="vertical-align:middle;text-align:center;width:30%" width="250" rowspan="2">Indikator</th>
					<th style="vertical-align:middle;text-align:center;width:10%" width="80" rowspan="2">Satuan</th>
					<th style="vertical-align:middle;text-align:center" width="'.(100*($rangetahun+1)).'" colspan="'.($rangetahun+1).'">Realisasi Pencapaian</th>					
					<th style="vertical-align:middle;text-align:center;width:20%" width="100" rowspan="2">Keterangan</th>
				</tr>';
		$rs .= 	'<tr>';
		//
		$total_row =0;
		$rangetahun_arr = array();
		
		for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
			$rs .= 	'<th style="vertical-align:middle;text-align:center"  width="100">'.$colTahun.'</th>';
			$rangetahun_arr[] = $colTahun;
		}	
					
		$rs .= 	'</tr></thead>';	
		$rs .= '<tbody>';		
		$i=0;
		 $j=0;
		//$dataTampil = array();
		$kode_ss_kl = '';
		$kode_iku_e1='';
		//$dataTampil = new stdClass();
		foreach($data as $d){
			
			if ($kode_ss_kl!=$d->kode_ss_kl){
				$dataTampil[$i]->rowspan =0;
				$kode_ss_kl=$d->kode_ss_kl;
				$dataTampil[$i]->sasaran_strategis = $d->sasaran_strategis;
				$dataTampil[$i]->kode_ss_kl = $d->kode_ss_kl;
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
			$rs .= '<tr>';
			if ($d->rowspan<=1) 
				$rs .= '<td width="100" >'.$d->sasaran_strategis.'</td>';
			else
				$rs .= '<td width="100"  rowspan="'.($d->rowspan).'" >'.$d->sasaran_strategis.'</td>';
			
			if (isset($d->indikator)) {	
			
				if ( sizeof($d->indikator)>0){				
					$j=0;				
					
					foreach($d->indikator as $ss){
						if ($j>0) $rs .= '<tr>';
							
						
						$rs .= '<td width="250" valign="top">'.$ss->deskripsi.'</td>';
						$rs .= '<td width="80" valign="top">'.$ss->satuan.'</td>';
						
						for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
							$realisasi = isset($ss->realisasi[$colTahun])?$ss->realisasi[$colTahun]:'-';
						
							$rs .= 	'<td width="100" align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
						}
						
						$rs .= '<td width="100" valign="top">'.$ss->keterangan.'</td>';			
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
		
		
		//if ($ajaxCall)	echo $rs;
		//else 
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
					$varData[$j]['kode_ss_kl'] = $this->utility->ourEkstrakString($data,';',1);
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
	
	
	
	function print_pdf($renstra,$range_awal,$range_akhir)
   {
	    $this->load->library('tcpdf_','pdf');
	//	$this->load->helper('htmlpurifier');
		$pdf = new Tcpdf_('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('MATRIKS CAPAIAN PEMBANGUNAN SEKTOR TRANSPORTASI');
		$pdf->SetHeaderMargin(15);
		$pdf->SetTopMargin(15);
		$pdf->setFooterMargin(5);
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);	
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		
		define('FPDF_FONTPATH',APPPATH."libraries/fpdf/font/");
		
		// add a page
		
		// set font
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage('L');
		//var_dump($e1);
		
		$data['renstra']		= $renstra;
	   $data['tahun']		= $range_awal.'-'.$range_akhir;
		 $pdf->Write(0, 'MATRIKS CAPAIAN PEMBANGUNAN SEKTOR TRANSPORTASI ', '', 0, 'L', true, 0, false, false, 0);
		 $pdf->Write(0, 'Periode '.$data['tahun'], '', 0, 'L', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		
	   $data['matriks'] =  $this->get_output($renstra,-1,$range_awal,$range_akhir,false);//$this->print_matriks($range_awal,$range_akhir,0,false);
	 
	  
		$html = $this->load->view('laporan/print/pdf_matriks',$data,true);
		//$html = html_purify($html);
		//$html = $data['ikuE2'];
	    // var_dump($data['matriks']);die;
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('MatriksPembangunan.pdf', 'I');
   }
   
   function excel($renstra,$range_awal,$range_akhir){
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Matriks Pembangunan');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'MATRIKS CAPAIAN PEMBANGUNAN SEKTOR TRANSPORTASI');
		$this->excel->getActiveSheet()->setCellValue('A2', 'Periode  ');
		$this->excel->getActiveSheet()->setCellValue('B2', $range_awal.'-'.$range_akhir);
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->mergeCells('A3:D3');
		$params = array("tahun_renstra"=>$renstra);
		$posisiRow = 4;
		$columHeader = array("No.","Sasaran Kemenhub","No.","Indikator Kinerja Utama (IKU)","Satuan");		
		 
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow.':D'.$posisiRow)->applyFromArray(
				array(
					'font'    => array('bold'=> true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
					'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
				));
		$rangetahun_arr = array();
		//for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)
		$startCol = 70;
		$this->excel->getActiveSheet()->fromArray($columHeader,NULL,'A'.$posisiRow);
		for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
			//$rs .= 	'<th style="vertical-align:middle;text-align:center" width="80">'.$colTahun.'</th>';
			$rangetahun_arr[] = $colTahun;
		}			
		$this->excel->getActiveSheet()->fromArray($rangetahun_arr,NULL,'F'.$posisiRow);
		$posisiRow++;		
		
		$data  =  $this->get_output($renstra,-1,$range_awal,$range_akhir,false,true);
		if (isset($data)){
			$no = 1;;
			$deskripsi = '';
			foreach($data as $d){
				if ($deskripsi!=$d->deskripsi){
					$deskripsi=$d->deskripsi;
					$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, ($no++));
					$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, $d->deskripsi);
					$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+$d->rowspan-1));
					$this->excel->getActiveSheet()->mergeCells('B'.$posisiRow.':B'.($posisiRow+$d->rowspan-1));
				}
				if (isset($d->iku)){
					$noIku = 1;
					foreach ($d->iku as $iku){
						$this->excel->getActiveSheet()->setCellValue('C'.$posisiRow, ($noIku++));
						$this->excel->getActiveSheet()->setCellValue('D'.$posisiRow, $iku->deskripsi);
						$this->excel->getActiveSheet()->setCellValue('E'.$posisiRow, $iku->satuan);
						$startCol= 70;
						for ($colTahun=$range_awal;$colTahun<=$range_akhir;$colTahun++){	
							$vol =0;								
							if (isset($iku->total[$colTahun]))
								$vol = $iku->total[$colTahun];							
							$this->excel->getActiveSheet()->setCellValue(chr($startCol).$posisiRow, $vol);
							$startCol++;
						}
						$posisiRow++;
					}
				}else {
					$posisiRow++;
				}
				
			}
		}
		
		$this->excel->getActiveSheet()->getStyle('A4:A'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('B4:B'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('C4:C'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('D4:D'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('E4:E'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$this->excel->setActiveSheetIndex(0);	
		$filename='MatriksPembangunanKL'.($range_awal.'-'.$range_akhir).'.xls'; 
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
   }
}