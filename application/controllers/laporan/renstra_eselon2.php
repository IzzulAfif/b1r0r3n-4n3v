<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-16 00:00
 @revision	 :
*/

class Renstra_eselon2 extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/perencanaan/visi_eselon2_model','visi_e2');
		$this->load->model('/perencanaan/misi_eselon2_model','misi_e2');
		$this->load->model('/perencanaan/tujuan_eselon2_model','tujuan_e2');
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
		$this->load->model('/pemrograman/kegiatan_eselon2_model','kegiatan_e2');
		$this->load->model('/pemrograman/sasaran_kegiatan_model','sasaran_kegiatan');
		$this->load->model('/pemrograman/ikk_model','ikk');
		$this->load->model('/laporan/renstra_e2_model','renstra_e2');
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_all(null);
		$template['konten']	= $this->load->view('laporan/renstra_eselon2_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function get_list_eselon2($kode_e1)
	{
		$params = array("kode_e1"=>$kode_e1);
		echo json_encode($this->eselon2->get_list($params));
	}
	function loadprofile()
	{
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['eselon1'] = $this->eselon1->get_list(null);
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/renstra_eselon2_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_detail($tahun,$e2)
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->get_rencana_detail($tahun,$e2);
		$template['konten']	= $this->load->view('laporan/renstra_e2_detail_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container_popup',$template);
	}
		
	function get_visi($tahun,$e1,$e2){
		$params['tahun_renstra'] = $tahun;
		$params['kode_e1'] = $e1;
		if ($e2!="0")
			$params['kode_e2'] = $e2;
		$isGrouping = ($e2=="0");
		$namaUnit = '';
		$data = $this->visi_e2->get_all($params);
		$rs = '';
		$i=0;
		if (isset($data)){
			if (($isGrouping)){			
				foreach($data as $d){
					if ($d->nama_e2!=$namaUnit){
						if($i>0) $rs .= '</ol>';
							
						$namaUnit = $d->nama_e2;
						$params['kode_e2'] = $d->kode_e2;
						$rs .='<b>'.$d->nama_e2.'</b>';
						$rs .= '<ol '.(($this->visi_e2->get_jml_visi($params)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
					}
					$rs .= '<li>'.$d->visi_e2.'</li>';
					$i++;
				 }
				 $rs .= '</ol>';
			}
			else {
				$rs .= '<ol '.((count($data)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->visi_e2.'</li>';
				 }
				 $rs .= '</ol>';
			}
		}
		echo $rs;
	}
	
	function get_misi($tahun,$e1,$e2){
		$params['tahun_renstra'] = $tahun;
		$params['kode_e1'] = $e1;
		if ($e2!="0")
			$params['kode_e2'] = $e2;
		$isGrouping = ($e2=="0");
		$namaUnit = '';
		$data = $this->misi_e2->get_all($params);
		$rs = '';
		$i=0;
		if (isset($data)){
			if (($isGrouping)){			
				foreach($data as $d){
					if ($d->nama_e2!=$namaUnit){
						if($i>0) $rs .= '</ol>';
							
						$namaUnit = $d->nama_e2;
						$params['kode_e2'] = $d->kode_e2;
						$rs .='<b>'.$d->nama_e2.'</b>';
						$rs .= '<ol '.(($this->misi_e2->get_jml_misi($params)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
					}
					$rs .= '<li>'.$d->misi_e2.'</li>';
					$i++;
				 }
				 $rs .= '</ol>';
			}
			else {
				$rs .= '<ol '.((count($data)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->misi_e2.'</li>';
				 }
				 $rs .= '</ol>';
			}
		}
		echo $rs;
	}
	
	function get_tujuan($tahun,$e1,$e2){
		$params['tahun_renstra'] = $tahun;
		$params['kode_e1'] = $e1;
		if ($e2!="0")
			$params['kode_e2'] = $e2;
		$isGrouping = ($e2=="0");
		$namaUnit = '';
		$data = $this->tujuan_e2->get_all($params);
		$rs = '';
		$i=0;
		if (isset($data)){
			if (($isGrouping)){			
				foreach($data as $d){
					if ($d->nama_e2!=$namaUnit){
						if($i>0) $rs .= '</ol>';
							
						$namaUnit = $d->nama_e2;
						$params['kode_e2'] = $d->kode_e2;
						$rs .='<b>'.$d->nama_e2.'</b>';
						$rs .= '<ol '.(($this->tujuan_e2->get_jml_tujuan($params)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
					}
					$rs .= '<li>'.$d->tujuan_e2.'</li>';
					$i++;
				 }
				 $rs .= '</ol>';
			}
			else {
				$rs .= '<ol '.((count($data)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
				foreach($data as $d){
					$rs .= '<li>'.$d->tujuan_e2.'</li>';
				 }
				 $rs .= '</ol>';
			}
		}
		echo $rs;
	}
	
	function get_kegiatan($tahun,$e1,$e2){
		$params['tahun_renstra'] = $tahun;
		$params['kode_e1'] = $e1;
		if ($e2!="0")
			$params['kode_e2'] = $e2;
		$isGrouping = ($e2=="0");
		$namaUnit = '';
		$i=0;
		$data = $this->kegiatan_e2->get_renstra($params);
		$rs = '';
		$where='';
		if (isset($data)){
			if (($isGrouping)){			
				foreach($data as $d){
					if ($d->nama_e2!=$namaUnit){
						if($i>0) $rs .= '</ol>';
							
						$namaUnit = $d->nama_e2;
						$where = "kode_e2='".$d->kode_e2."'";
						//if (!isset($params['tahun']))
							$where  .=  " and tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4)";
						
						//unset($params['tahun_renstra']);
						$rs .='<b>'.$d->nama_e2.'</b>';
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
		echo $rs;
	}
	
	function get_sasaran($tahun,$e1,$e2){
		$dataAll = array();		
		$rs = '';
		$params['tahun_renstra'] = $tahun;
		$params['kode_e1'] = $e1;
		if ($e2!="0")
			$params['kode_e2'] = $e2;
		$data_kegiatan = $this->sasaran_kegiatan->get_renstra($params);
		if (isset($data_kegiatan)){
			$rs = '<table class="display table table-bordered table-striped">';			
			$rs .= '
			<thead><tr  align="center">						
						<th style="vertical-align:middle;text-align:center" width="30%" >Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center" width="70%" >Indikator</th>			
					</tr>';									
			$rs .= 	'</thead>';	
			$rs .= '<tbody>';		
			$i=0;
			
			foreach($data_kegiatan as $ss){					
					$data_iku = $this->ikk->get_renstra(array("tahun_renstra"=>$tahun,"kode_sk_e2"=>$ss->kode_sk_e2));
					$jml_data_iku = count($data_iku);
					$data_kegiatan[$i]->rowspan += sizeof($data_iku);
					$data_kegiatan[$i]->ikk = $data_iku;					
					$data_kegiatan[$i]->rowspan = sizeof($data_iku);
					$i++;
			}			
			$i=0;							
			$isGrouping = ($e2=="0");
			$namaUnit= "";
			$rs .= '<tr>';
			foreach($data_kegiatan as $ss){
					if (($namaUnit!=$ss->nama_e2)&&($isGrouping)){
						$namaUnit = $ss->nama_e2;
						$rs .= '<td colspan="2"><b>'.$ss->nama_e2.'</b></td>';
						$rs .= '</tr>';
						$rs .= '<tr>';
					//	continue;
					}
					if ($i==0)
						$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
					else {						
						$rs .= '<tr>';
						$rs .= '<td  rowspan="'.$ss->rowspan.'" valign="top">'.$ss->deskripsi.'</td>';
					}
					
					$jml_data_iku = count($ss->ikk);
					$x=0;
					if ($jml_data_iku>0){
						foreach($ss->ikk as $iku){
							if ($x==0){
							  $rs .= '<td   valign="top">'.$iku->deskripsi.'</td>';							  
							  $rs .= '</tr>';
							}
							else {								//
								$rs .= '<tr>';
								$rs .= '<td    valign="top">'.$iku->deskripsi.'</td>';								
								$rs .= '</tr>';
							}
							$x++;
						}						
					}
					else {
					
					}					
					$i++;
				}					
			$rs .= '</tbody>';		
			$rs .= '</table>';			
		} 
		echo $rs;
	}
	
	
	function get_rencana_detail($tahun,$e2){
		$dataAll = array();
		
		$rs = '';
		
			$rs = '<table class="display table table-bordered table-striped">';
			$arrTahun = explode("-",$tahun);
			
			$rangetahun = $arrTahun[1]-$arrTahun[0];
			
		//	$rs = '<table class="table" border="1">';
			$rs .= '
			<thead><tr  align="center">
						
						<th style="vertical-align:middle;text-align:center" width="20%" rowspan="2">Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center" width="40%" rowspan="2">Indikator</th>
						<th style="vertical-align:middle;text-align:center" width="100px" rowspan="2">Satuan</th>
						<th style="vertical-align:middle;text-align:center" width="100px" colspan="'.($rangetahun+1).'">Target Pencapaian</th>
					</tr>';
			$rs .= 	'<tr>';
				for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)	
						$rs .= 	'<th style="vertical-align:middle;text-align:center">'.$colTahun.'</th>';
						
			$rs .= 	'		</tr></thead>';	
			$rs .= '<tbody>';		
			$i=0;
			 
			
				
				$data_kegiatan = $this->sasaran_kegiatan->get_renstra(array("tahun_renstra"=>$tahun,"kode_e2"=>$e2));
				$jml_data_kegiatan = count($data_kegiatan);
				
				//$data[$i]->rowspan = sizeof($data_kegiatan);
				if (isset($data_kegiatan)){				
					//$rs .="<ol>";
					$j=0;
					foreach($data_kegiatan as $ss){					
						$data_iku = $this->renstra_e2->get_indikator(array("tahun_renstra"=>$tahun,"kode_sk_e2"=>$ss->kode_sk_e2));
						$kode_iku = '';
						$data_kegiatan[$j]->rowspan =0;
						if (isset($data_iku)) {
							$x=0;
							foreach($data_iku as $iku){
								if ($kode_iku != $iku->kode_ikk){
									$kode_iku = $iku->kode_ikk;
									$data_kegiatan[$j]->iku[$x]->deskripsi = $iku->deskripsi;					
									$data_kegiatan[$j]->iku[$x]->satuan = $iku->satuan;					
									$data_kegiatan[$j]->iku[$x]->target[$iku->tahun] = $iku->target;	
								
									//$data_kegiatan[$j]->rowspan = sizeof($data_iku);
									$data_kegiatan[$j]->rowspan++;
									$x++;
								}
								else {
									$data_kegiatan[$j]->iku[$x-1]->target[$iku->tahun] = $iku->target;	
								}
							}
						}
						//$jml_data_iku = count($data_iku);
						
						$j++;
					}			
				}
				
			 $i=0;
			
				$jml_data_kegiatan = sizeof($data_kegiatan);
				$colspan_sasaran = 
				$rs .= '<tr>';
				
					
				if (isset($data_kegiatan)){		
					
					
					$j=0;
					
					foreach($data_kegiatan as $ss){
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
						
						$jml_data_iku = count($data_kegiatan[$j]->iku);
						$x=0;
						if ($jml_data_iku>0){
							foreach($data_kegiatan[$j]->iku as $iku){
								if ($x==0){
								  $rs .= '<td   valign="top">'.$iku->deskripsi.'</td>';
								  $rs .= '<td   valign="top">'.$iku->satuan.'</td>';
								  for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){	
										
										$realisasi = isset($iku->target[$colTahun])?$iku->target[$colTahun]:'-';
										$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
								  }		
								  $rs .= '</tr>';
								}
								else {
									//
									$rs .= '<tr>';
									$rs .= '<td    valign="top">'.$iku->deskripsi.'</td>';
									$rs .= '<td   valign="top">'.$iku->satuan.'</td>';
									for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){	
										$realisasi = isset($iku->target[$colTahun])?$iku->target[$colTahun]:'-';
										$rs .= 	'<td align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
									}
									$rs .= '</tr>';
								}
								$x++;
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

}