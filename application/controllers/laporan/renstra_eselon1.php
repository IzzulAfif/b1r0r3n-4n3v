<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-16 00:00
 @revision	 :
*/

class Renstra_eselon1 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/perencanaan/visi_eselon1_model','visi_e1');
		$this->load->model('/perencanaan/misi_eselon1_model','misi_e1');
		$this->load->model('/perencanaan/tujuan_eselon1_model','tujuan_e1');
		$this->load->model('/perencanaan/program_eselon1_model','program_e1');
		$this->load->model('/pemrograman/sasaran_program_model','sasaran_program');
		$this->load->model('/pemrograman/iku_eselon1_model','iku_e1');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
		$this->load->model('/laporan/renstra_e1_model','renstra_e1');
		$this->load->model('/pemrograman/kegiatan_eselon2_model','kegiatan_e2');
		$this->load->model('/pemrograman/pendanaan_program_model','pendanaan');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_all(null);
		$template['konten']	= $this->load->view('laporan/renstra_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function loadprofile()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(null);
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/renstra_eselon1_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_list_eselon1($tahun)
	{
		$params = array("tahun_renstra"=>$tahun,"isNotMandatory"=>true);
		echo json_encode($this->eselon1->get_list($params));
	}
	
	function get_detail($tahun,$e1)
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->get_rencana_detail($tahun,$e1);
		$data['periode'] = $tahun;
		if ($e1=="0")
			$data['unitkerja'] = 'UNIT KERJA ESELON I';
		else
			$data['unitkerja'] = $this->mgeneral->getValue("nama_e1",array('kode_e1'=>$e1),"anev_eselon1");
		$template['konten']	= $this->load->view('laporan/renstra_e1_detail_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container_popup',$template);
	}
	
	function get_pendanaan($tahun,$e1,$purpose="e1")
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->get_pendanaan_detail($tahun,$e1);
		$data['periode'] = $tahun;
		if ($e1=="0")
			$data['unitkerja'] = ($purpose=="e1"?'UNIT KERJA ESELON I':"KEMENTERIAN PERHUBUNGAN");
		else
			$data['unitkerja'] = $this->mgeneral->getValue("nama_e1",array('kode_e1'=>$e1),"anev_eselon1");
		$template['konten']	= $this->load->view('laporan/renstra_e1_pendanaan_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container_popup',$template);
	}
		
	function get_visi($tahun,$e1,$ajaxCall=true){
		$params['tahun_renstra'] = $tahun;
		if ($e1!="0")
			$params['kode_e1'] = $e1;
		$isGrouping = ($e1=="0");
		$namaUnit = '';
		$data = $this->visi_e1->get_all($params);
		$rs = '';
		$i=0;
		if (isset($data)){
			if (($isGrouping)){			
				foreach($data as $d){
					if ($d->nama_e1!=$namaUnit){
						if($i>0) $rs .= '</ol>';
							
						$namaUnit = $d->nama_e1;
						$params['kode_e1'] = $d->kode_e1;
						$rs .='<b>'.$d->nama_e1.'</b>';
						$rs .= '<ol '.(($this->visi_e1->get_jml_visi($params)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
					}
					$rs .= '<li>'.$d->visi_e1.'</li>';
					$i++;
				 }
				 $rs .= '</ol>';
			}
			else {
				$rs .= '<ol '.((count($data)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->visi_e1.'</li>';
				 }
				 $rs .= '</ol>';
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_misi($tahun,$e1,$ajaxCall=true){
		$params['tahun_renstra'] = $tahun;
		if ($e1!="0")
			$params['kode_e1'] = $e1;
		$isGrouping = ($e1=="0");
		$namaUnit = '';
		$data = $this->misi_e1->get_all($params);
		$rs = '';
		$i=0;
		if (isset($data)){
			if (($isGrouping)){			
				foreach($data as $d){
					if ($d->nama_e1!=$namaUnit){
						if($i>0) $rs .= '</ol>';
							
						$namaUnit = $d->nama_e1;
						$params['kode_e1'] = $d->kode_e1;
						$rs .='<b>'.$d->nama_e1.'</b>';
						$rs .= '<ol '.(($this->misi_e1->get_jml_misi($params)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
					}
					$rs .= '<li>'.$d->misi_e1.'</li>';
					$i++;
				 }
				 $rs .= '</ol>';
			}
			else {
				$rs .= '<ol '.((count($data)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->misi_e1.'</li>';
				 }
				 $rs .= '</ol>';
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_tujuan($tahun,$e1,$ajaxCall=true){
		$params['tahun_renstra'] = $tahun;
		if ($e1!="0")
			$params['kode_e1'] = $e1;
		$isGrouping = ($e1=="0");
		$namaUnit = '';	
		$i=0;
		$data = $this->tujuan_e1->get_all($params);
		$rs = '';
		if (isset($data)){
			if (($isGrouping)){			
				foreach($data as $d){
					if ($d->nama_e1!=$namaUnit){
						if($i>0) $rs .= '</ol>';
							
						$namaUnit = $d->nama_e1;
						$params['kode_e1'] = $d->kode_e1;
						$rs .='<b>'.$d->nama_e1.'</b>';
						$rs .= '<ol '.(($this->tujuan_e1->get_jml_tujuan($params)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
					}
					$rs .= '<li>'.$d->tujuan_e1.'</li>';
					$i++;
				 }
				 $rs .= '</ol>';
			}
			else {
				$rs .= '<ol '.((count($data)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->tujuan_e1.'</li>';
				 }
				 $rs .= '</ol>';
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_kegiatan($tahun,$e1,$e2="0",$ajaxCall=true){
		$params['tahun_renstra'] = $tahun;
		//$params['kode_e1'] = $e1;
		if ($e1!="0")
			$params['kode_e1'] = $e1;
		$isGrouping = ($e1=="0");
		$namaUnit = '';
		$i=0;
		$data = $this->kegiatan_e2->get_renstra($params);
		$rs = '';
		$where='';
		if (isset($data)){
			if (($isGrouping)){			
				foreach($data as $d){
					if ($d->nama_e1!=$namaUnit){
						if($i>0) $rs .= '</ol>';
							
						$namaUnit = $d->nama_e1;
						$where = " and kode_e1='".$d->kode_e1."'";
						//if (!isset($params['tahun']))
							$where  .=  " and tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
						
						//unset($params['tahun_renstra']);
						$rs .='<b>'.$d->nama_e1.'</b>';
						$rs .= '<ol '.(($this->kegiatan_e2->get_jml_kegiatan($where)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
					}
					$rs .= '<li>'.$d->nama_kegiatan.'</li>';
					$i++;
				 }
				 $rs .= '</ol>';
			}
			else {
				$rs .= '<ol '.((count($data)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->nama_kegiatan.'</li>';
				 }
				 $rs .= '</ol>';
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_program($tahun,$e1,$ajaxCall=true){
		$params['tahun_renstra'] = $tahun;
		if ($e1!="0")
			$params['kode_e1'] = $e1;
		$isGrouping = ($e1=="0");
		$namaUnit = '';
		$i=0;
		$data = $this->program_e1->get_renstra($params);
		$rs = '';
		$where='';
		if (isset($data)){
			if (($isGrouping)){			
				foreach($data as $d){
					if ($d->nama_e1!=$namaUnit){
						if($i>0) $rs .= '</ol>';
							
						$namaUnit = $d->nama_e1;
						$where = "kode_e1='".$d->kode_e1."'";
						//if (!isset($params['tahun']))
							$where  .=  " and tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
						
						//unset($params['tahun_renstra']);
						$rs .='<b>'.$d->nama_e1.'</b>';
						$rs .= '<ol '.(($this->program_e1->get_jml_program($where)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
					}
					$rs .= '<li>'.$d->nama_program.'</li>';
					$i++;
				 }
				 $rs .= '</ol>';
			}
			else {
				$rs .= '<ol '.((count($data)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->nama_program.'</li>';
				 }
				 $rs .= '</ol>';
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_sasaran($tahun,$e1,$ajaxCall=true){
		$dataAll = array();		
		$rs = '';
		$params['tahun_renstra'] = $tahun;
		if ($e1!="0")
			$params['kode_e1'] = $e1;
		$isGrouping = ($e1=="0");
		
		$data_program = $this->sasaran_program->get_renstra($params);
		if (isset($data_program)){
			if ($ajaxCall)
				$rs = '<table class="display table table-bordered table-striped">';
			else
				$rs = '<table  border="1" cellpadding="4" cellspacing="0">';
			
			$rs .= '
			<thead><tr  align="center">						
						<th style="vertical-align:middle;text-align:center" width="180" >Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center"  width="30">No.</th>
						<th style="vertical-align:middle;text-align:center" width="230" >Indikator Kinerja Utama (IKU)</th>
						<th style="vertical-align:middle;text-align:center" width="80" >Satuan</th>
					</tr>';						
			$rs .= 	'</thead>';	
			$rs .= '<tbody>';		
			$i=0;
			foreach($data_program as $ss){					
					$data_iku = $this->iku_e1->get_renstra(array("tahun_renstra"=>$tahun,"kode_sp_e1"=>$ss->kode_sp_e1));
					$jml_data_iku = count($data_iku);
					$data_program[$i]->rowspan += sizeof($data_iku);
					$data_program[$i]->iku = $data_iku;					
					$data_program[$i]->rowspan = sizeof($data_iku);
					$i++;
			}			
			$i=0;				
			$no=1;
			$namaUnit= "";
			//$rs .= '<tr>';
			foreach($data_program as $ss){
					if (($namaUnit!=$ss->nama_e1)&&($isGrouping)){
						$namaUnit = $ss->nama_e1;
				//		if ($i>0)
						$rs .= '<tr>';
						$rs .= '<td width="520" colspan="4"><b>'.$ss->nama_e1.'</b></td>';
						$rs .= '</tr>';
					///	if ($i==0)
						//	$rs .= '<tr>';
						$no=1;
						//continue;
					}
				//	if ($i==0)
					//	$rs .= '<td  width="180"  rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
				//	else {
						
						$rs .= '<tr>';
						$rs .= '<td  width="180" rowspan="'.$ss->rowspan.'" valign="top">'.$ss->deskripsi.'</td>';
					//}					
					$jml_data_iku = count($ss->iku);
					$x=0;
					if ($jml_data_iku>0){
						foreach($ss->iku as $iku){
							if ($x>0){
								$rs .= '<tr>';
							 
							}
							$rs .= '<td   width="30" valign="top">'.($no).'.</td>';							  
							$rs .= '<td   width="230" valign="top">'.$iku->deskripsi.'</td>';							  
							$rs .= '<td   width="80" valign="top">'.$iku->satuan.'</td>';							  
							$rs .= '</tr>';
							$x++;
							$no++;
						}						
					}
					else {
					
					}					
					$i++;
				}		
			$rs .= '</tbody>';		
			$rs .= '</table>';			
		} 
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_rencana_detail($tahun,$e1){
		$dataAll = array();
		
		$rs = '';
		
			$rs = '<table class="display table table-bordered table-striped">';
			$arrTahun = explode("-",$tahun);
			
			$rangetahun = $arrTahun[1]-$arrTahun[0];
			
		//	$rs = '<table class="table" border="1">';
			$rs .= '
			<thead><tr  align="center">
						
						<th style="vertical-align:middle;text-align:center" width="20%" rowspan="2">Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center"  rowspan="2">No.</th>
						<th style="vertical-align:middle;text-align:center" width="40%" rowspan="2">Indikator Kinerja Utama</th>
						<th style="vertical-align:middle;text-align:center" width="100px" rowspan="2">Satuan</th>
						<th style="vertical-align:middle;text-align:center"   colspan="'.($rangetahun+1).'">Target Pencapaian</th>
					</tr>';
			$rs .= 	'<tr>';
				for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)	
						$rs .= 	'<th style="vertical-align:middle;text-align:center">'.$colTahun.'</th>';
						
			$rs .= 	'		</tr></thead>';	
			$rs .= '<tbody>';		
			$i=0;
			 
			
				
				$data_program = $this->sasaran_program->get_renstra(array("tahun_renstra"=>$tahun,"kode_e1"=>$e1));
				$jml_data_program = count($data_program);
				
				//$data[$i]->rowspan = sizeof($data_program);
				if (isset($data_program)){				
					//$rs .="<ol>";
					$j=0;
					foreach($data_program as $ss){					
						$data_iku = $this->renstra_e1->get_indikator(array("tahun_renstra"=>$tahun,"kode_sp_e1"=>$ss->kode_sp_e1));
						$kode_iku = '';
						$data_program[$j]->rowspan =0;
						if (isset($data_iku)) {
							$x=0;
							foreach($data_iku as $iku){
							//	if ($kode_iku != $iku->kode_iku_e1){
									$kode_iku = $iku->kode_iku_e1;
									$data_program[$j]->iku[$x]->deskripsi = $iku->deskripsi;					
									$data_program[$j]->iku[$x]->satuan = $iku->satuan;					
									//$data_program[$j]->iku[$x]->target[$iku->tahun] = $iku->target;	
									$data_program[$j]->iku[$x]->target1 = $iku->target_thn1;	
									$data_program[$j]->iku[$x]->target2 = $iku->target_thn2;	
									$data_program[$j]->iku[$x]->target3 = $iku->target_thn3;	
									$data_program[$j]->iku[$x]->target4 = $iku->target_thn4;	
									$data_program[$j]->iku[$x]->target5 = $iku->target_thn5;	
								
								
									$data_program[$j]->rowspan++;
									$x++;
								/*}
								else {
									$data_program[$j]->iku[$x-1]->target[$iku->tahun] = $iku->target;	
								}*/
							}
						}
						
						$j++;
					}			
				}
				
			 $i=0;
			 $no=1;
			
				$jml_data_program = sizeof($data_program);
				
				$rs .= '<tr>';				
				if (isset($data_program)){		
					
					
					$j=0;
					
					foreach($data_program as $ss){
						if ($j==0){
							if ($ss->rowspan==0)
								$rs .= '<td     valign="top">'.$ss->deskripsi.'</td>';
							else
								$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
						}
						else {
							$rs .= '<tr>';							
							if ($ss->rowspan==0)								
								$rs .= '<td     valign="top">'.$ss->deskripsi.'</td>';
							else								
								$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
						}
						
						$jml_data_iku = count($data_program[$j]->iku);
						$x=0;
						if ($jml_data_iku>0){
							foreach($data_program[$j]->iku as $iku){
								if ($x==0){
								
								}
								else {
									//
									$rs .= '<tr>';
									
								}
								$rs .= '<td    valign="top">'.$no.'</td>';
								$rs .= '<td    valign="top">'.$iku->deskripsi.'</td>';
								$rs .= '<td   valign="top">'.$iku->satuan.'</td>';
								//for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){	
									//$realisasi = isset($iku->target[$colTahun])?$iku->target[$colTahun]:'-';
									$realisasi = isset($iku->target1)?$iku->target1:'-';
									$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target2)?$iku->target2:'-';
									$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target3)?$iku->target3:'-';
									$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target4)?$iku->target4:'-';
									$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									$realisasi = isset($iku->target5)?$iku->target5:'-';
									$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									
								//}
								$rs .= '</tr>';
								$x++;
								$no++;
							}
							
						}
						else {
						//	$rs .= '<td width="50%">&nbsp;</td>';
						}
						
						$j++;
					}
				
				}
				else { 
					//$rs .= '<td></td>';
					//$rs .= '<td></td>';
				}
				//$rs .= '</tr>';
				
			 $rs .= '</tbody>';		
			 $rs .= '</table>';
		
		// var_dump($data[0]);die;
		return $rs;
	}
	
	function get_pendanaan_detail($tahun,$e1){
		$dataAll = array();
		$params['tahun_renstra']=$tahun;
		if ($e1!="0")
			$params['kode_e1'] = $e1;
		$isGrouping = ($e1=="0");
		$rs = '';
		
			$rs = '<table class="display table table-bordered table-striped">';
			$arrTahun = explode("-",$tahun);
			
			$rangetahun = $arrTahun[1]-$arrTahun[0];
			
		//	$rs = '<table class="table" border="1">';
			$rs .= '
			<thead><tr  align="center">
						
						<th style="vertical-align:middle;text-align:center"  rowspan="2">No.</th>
						<th style="vertical-align:middle;text-align:center" width="20%" rowspan="2">Nama Program</th>
						<th style="vertical-align:middle;text-align:center"   colspan="'.($rangetahun+1).'">Kebutuhan Pendanaan</th>
					</tr>';
			$rs .= 	'<tr>';
				for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)	
						$rs .= 	'<th style="vertical-align:middle;text-align:center">'.$colTahun.'</th>';
						
			$rs .= 	'		</tr></thead>';	
			$rs .= '<tbody>';		
			$i=0;
			 
			
				
				$data_program = $this->pendanaan->get_renstra($params);
				$jml_data_program = count($data_program);
				$unitKerja ="";
				
				
			 $i=0;
			 $no=1;
			
				$jml_data_program = sizeof($data_program);
				
				
				if (isset($data_program)){		
					
					foreach($data_program as $ss){
						if (($unitKerja!=$ss->nama_e1)&&($isGrouping)){
							$unitKerja = $ss->nama_e1;
							$rs .= '<tr>';
							$rs .= '<td colspan="'.($rangetahun+3).'"><b>'.$ss->nama_e1.'</b></td>';
							$rs .= '</tr>';
							
							$no=1;
							//continue;
						}
						
						$rs .= '<tr>';
						
						$rs .= '<td    valign="top">'.$no.'</td>';
						$rs .= '<td    valign="top">'.$ss->nama_program.'</td>';
						
						
							$realisasi = isset($ss->target_thn1)?$ss->target_thn1:'-';
							$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							$realisasi = isset($ss->target_thn2)?$ss->target_thn2:'-';
							$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							$realisasi = isset($ss->target_thn3)?$ss->target_thn3:'-';
							$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							$realisasi = isset($ss->target_thn4)?$ss->target_thn4:'-';
							$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							$realisasi = isset($ss->target_thn5)?$ss->target_thn5:'-';
							$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							
						
						$rs .= '</tr>';

						$no++;
					
					}
				
				}
				else { 
					//$rs .= '<td></td>';
					//$rs .= '<td></td>';
				}
				//$rs .= '</tr>';
				
			 $rs .= '</tbody>';		
			 $rs .= '</table>';
		
		// var_dump($data[0]);die;
		return $rs;
	}
	
	
	public function print_pdf($tahun,$e1){
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Rencana Strategis Unit Kerja Eselon I');
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
		$pdf->AddPage();
		//var_dump($e1);
		 $pdf->Write(0, 'Rencana Strategis '.($e1=="0"?"Unit Kerja Eselon I":$this->mgeneral->getValue("nama_e1",array('tahun_renstra'=>$tahun,'kode_e1'=>$e1),"anev_eselon1")), '', 0, 'L', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		 $data['renstra']		= $tahun;
	//	$data['unitkerja'] = ;
	   $data['tujuan']		= $this->get_tujuan($tahun,$e1,false);
	   $data['misi']		= $this->get_misi($tahun,$e1,false);
	   $data['visi']		= $this->get_visi($tahun,$e1,false);
	   $data['kegiatan']		= $this->get_kegiatan($tahun,$e1,"0",false);
	   $data['sasaran']		= $this->get_sasaran($tahun,$e1,false);
		$html = $this->load->view('laporan/print/pdf_renstra_e1',$data,true);
		//$html = $data['sasaran'];
		//var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);
		
		
	
	
	
		$pdf->Output('RenstraEselonI.pdf', 'I');
	}

}