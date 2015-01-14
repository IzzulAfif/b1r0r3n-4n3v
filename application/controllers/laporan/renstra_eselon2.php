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
		$this->load->model('/pemrograman/pendanaan_kegiatan_model','pendanaan');
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
	
	function get_list_eselon2($tahun,$kode_e1)
	{
		$params = array("tahun_renstra"=>$tahun,"kode_e1"=>$kode_e1,"isNotMandatory"=>true);
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
	
	function get_list_eselon1($tahun)
	{
		$params = array("tahun_renstra"=>$tahun);
		echo json_encode($this->eselon1->get_list($params));
	}
	
	function get_detail($tahun,$e1,$e2)
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->get_rencana_detail($tahun,$e1,$e2,true);
		$data['periode'] = $tahun;
		$data['e1'] = $e1;
		$data['e2'] = $e2;
		if ($e2=="0")
			$data['unitkerja'] = 'UNIT KERJA ESELON II';
		else
			$data['unitkerja'] = strtoupper($this->mgeneral->getValue("nama_e2",array('kode_e2'=>$e2),"anev_eselon2"));
		$data['e1_nama'] =  strtoupper($this->mgeneral->getValue("nama_e1",array('kode_e1'=>$e1),"anev_eselon1"));	
		$template['konten']	= $this->load->view('laporan/renstra_e2_detail_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container_popup',$template);
	}
	
function get_pendanaan($tahun,$e1,$e2)
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data['data'] = $this->get_pendanaan_detail($tahun,$e1,$e2);
		$data['periode'] = $tahun;
		$data['e1'] = $e1;
		$data['e2'] = $e2;
		if ($e2=="0")
			$data['unitkerja'] = 'UNIT KERJA ESELON II';
		else
			$data['unitkerja'] =  strtoupper($this->mgeneral->getValue("nama_e2",array('kode_e2'=>$e2),"anev_eselon2"));
		$data['e1_nama'] =  strtoupper($this->mgeneral->getValue("nama_e1",array('kode_e1'=>$e1),"anev_eselon1"));
		$template['konten']	= $this->load->view('laporan/renstra_e2_pendanaan_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container_popup',$template);
	}	
	function get_visi($tahun,$e1,$e2,$ajaxCall=true){
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
				if ($ajaxCall){
					foreach($data as $d){
						if ($d->nama_e2!=$namaUnit){
							if($i>0) $rs .= '</ol>';
								
							$namaUnit = $d->nama_e2;
							unset($params['kode_e1']);
							$params['kode_e2'] = $d->kode_e2;
							$rs .='<b>'.$d->nama_e2.'</b>';
							$rs .= '<ol '.(($this->visi_e2->get_jml_visi($params)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
						}
						$rs .= '<li>'.($d->visi_e2==""?"-":$d->visi_e2).'</li>';
						$i++;
					 }
					 $rs .= '</ol>';
				}
				else {
					$rs .= '<table  border="0" cellpadding="2" cellspacing="0">';
					foreach($data as $d){
						if ($d->nama_e2!=$namaUnit){
							$i=1;
							$namaUnit = $d->nama_e2;
							unset($params['kode_e1']);
							$params['kode_e2'] = $d->kode_e2;
							$jmldata = $this->visi_e2->get_jml_visi($params);
							$showNumber = ($jmldata>1);
						    $rs .= '<tr><td colpan="3" width="525">'.$d->nama_e2.'</td></tr>';
						}
						if ($showNumber)
							$rs .= '<tr><td width="10">&nbsp;</td><td width="15" align="right">'.($i).'.</td><td width="500">'.$d->visi_e2.'</td></tr>';
						else
							$rs .= '<tr><td width="10">&nbsp;</td><td colspan="2" width="515">'.$d->visi_e2.'</td></tr>';
						$i++;
					}
					$rs .= '</table>';
				}
			}
			else {
				if ($ajaxCall){
					$rs .= '<ol '.((count($data)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
					foreach($data as $d){
						$rs .= '<li>'.$d->visi_e2.'</li>';
					 }
					 $rs .= '</ol>';
				}
				else {
					$i=1;
					$showNumber = (count($data)>1);
					$rs .= '<table  border="0" cellpadding="2" cellspacing="0">';
					foreach($data as $d){					
						if ($showNumber)
							$rs .= '<tr><td width="10">&nbsp;</td><td width="15" align="right">'.($i).'.</td><td width="500">'.$d->visi_e2.'</td></tr>';
						else
							$rs .= '<tr><td width="10">&nbsp;</td><td colspan="2" width="515">'.$d->visi_e2.'</td></tr>';
						$i++;
					}
					$rs .= '</table>';
				}
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_misi($tahun,$e1,$e2,$ajaxCall=true){
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
				if ($ajaxCall){
					foreach($data as $d){
						if ($d->nama_e2!=$namaUnit){
							if($i>0) $rs .= '</ol>';
							unset($params['kode_e1']);	
							$namaUnit = $d->nama_e2;
							$params['kode_e2'] = $d->kode_e2;
							$rs .='<b>'.$d->nama_e2.'</b>';
							$rs .= '<ol '.(($this->misi_e2->get_jml_misi($params)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
						}
						$rs .= '<li>'.($d->misi_e2==""?"-":$d->misi_e2).'</li>';
						$i++;
					 }
					 $rs .= '</ol>';
				}
				else
				{
					$rs .= '<table  border="0" cellpadding="2" cellspacing="0">';
					foreach($data as $d){
						if ($d->nama_e2!=$namaUnit){
							$i=1;
							$namaUnit = $d->nama_e2;
							unset($params['kode_e1']);
							$params['kode_e2'] = $d->kode_e2;
							$jmldata = $this->misi_e2->get_jml_misi($params);
							$showNumber = ($jmldata>1);
						    $rs .= '<tr><td colpan="3" width="525">'.$d->nama_e2.'</td></tr>';
						}
						if ($showNumber)
							$rs .= '<tr><td width="10">&nbsp;</td><td width="15" align="right">'.($i).'.</td><td width="500">'.$d->misi_e2.'</td></tr>';
						else
							$rs .= '<tr><td width="10">&nbsp;</td><td colspan="2" width="515">'.$d->misi_e2.'</td></tr>';
						$i++;
					}
					$rs .= '</table>';
				}
			}
			else {
				if ($ajaxCall){
					$rs .= '<ol '.((count($data)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
					foreach($data as $d){
						$rs .= '<li>'.$d->misi_e2.'</li>';
					 }
					 $rs .= '</ol>';
				}
				else {
					$i=1;
					$showNumber = (count($data)>1);
					$rs .= '<table  border="0" cellpadding="2" cellspacing="0">';
					foreach($data as $d){					
						if ($showNumber)
							$rs .= '<tr><td width="10">&nbsp;</td><td width="15" align="right">'.($i).'.</td><td width="500">'.$d->misi_e2.'</td></tr>';
						else
							$rs .= '<tr><td width="10">&nbsp;</td><td colspan="2" width="515">'.$d->misi_e2.'</td></tr>';
						$i++;
					}
					$rs .= '</table>';
				}
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_tujuan($tahun,$e1,$e2,$ajaxCall=true){
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
				if ($ajaxCall){
					foreach($data as $d){
						if ($d->nama_e2!=$namaUnit){
							if($i>0) $rs .= '</ol>';
							unset($params['kode_e1']);	
							$namaUnit = $d->nama_e2;
							$params['kode_e2'] = $d->kode_e2;
							$rs .='<b>'.$d->nama_e2.'</b>';
							$rs .= '<ol '.(($this->tujuan_e2->get_jml_tujuan($params)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
						}
						$rs .= '<li>'.($d->tujuan_e2==""?"-":$d->tujuan_e2).'</li>';
						$i++;
					 }
					 $rs .= '</ol>';
				}
				else {//PDF
					$rs .= '<table  border="0" cellpadding="2" cellspacing="0">';
					foreach($data as $d){
						if ($d->nama_e2!=$namaUnit){
							$i=1;
							$namaUnit = $d->nama_e2;
							unset($params['kode_e1']);
							$params['kode_e2'] = $d->kode_e2;
							$jmldata = $this->tujuan_e2->get_jml_tujuan($params);
							$showNumber = ($jmldata>1);
						    $rs .= '<tr><td colpan="3" width="525">'.$d->nama_e2.'</td></tr>';
						}
						if ($showNumber)
							$rs .= '<tr><td width="10">&nbsp;</td><td width="15" align="right">'.($i).'.</td><td width="500">'.$d->tujuan_e2.'</td></tr>';
						else
							$rs .= '<tr><td width="10">&nbsp;</td><td colspan="2" width="515">'.$d->tujuan_e2.'</td></tr>';
						$i++;
					}
					$rs .= '</table>';
				}
			}
			else {
				if ($ajaxCall){
					$rs .= '<ol '.((count($data)<2)?'style="list-style:none;margin-left:-15px;"':'').'>';
					foreach($data as $d){
						$rs .= '<li>'.$d->tujuan_e2.'</li>';
					 }
					 $rs .= '</ol>';
				}
				else {//PDF
					$i=1;
					$showNumber = (count($data)>1);
					$rs .= '<table  border="0" cellpadding="2" cellspacing="0">';
					foreach($data as $d){					
						if ($showNumber)
							$rs .= '<tr><td width="10">&nbsp;</td><td width="15" align="right">'.($i).'.</td><td width="500">'.$d->tujuan_e2.'</td></tr>';
						else
							$rs .= '<tr><td width="10">&nbsp;</td><td colspan="2" width="515">'.$d->tujuan_e2.'</td></tr>';
						$i++;
					}
					$rs .= '</table>';
				}
			}
		}
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_kegiatan($tahun,$e1,$e2,$ajaxCall=true){
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
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function get_sasaran($tahun,$e1,$e2,$ajaxCall=true,$forExcel=false){
		$dataAll = array();		
		$rs = '';
		$params['tahun_renstra'] = $tahun;
		$params['kode_e1'] = $e1;
		if ($e2!="0")
			$params['kode_e2'] = $e2;
		$data_kegiatan = $this->sasaran_kegiatan->get_renstra($params);
		if (isset($data_kegiatan)){
			if ($ajaxCall)
				$rs = '<table class="display table table-bordered table-striped">';
			else
				$rs = '<table  border="1" cellpadding="4" cellspacing="0">';		
			$rs .= '
			<thead><tr  align="center">						
						<th style="vertical-align:middle;text-align:center" width="180" >Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center;width:1%"  width="30">No.</th>
						<th style="vertical-align:middle;text-align:center" width="230" >Indikator Kinerja Kegiatan (IKK)</th>
						<th style="vertical-align:middle;text-align:center" width="80" >Satuan</th>
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
						//var_dump($data_iku);die;
					if (!isset($data_iku)){
						$ikk = new stdClass();
						$ikk->deskripsi = '';
						$ikk->satuan = '';
						$data_kegiatan[$i]->rowspan++;
						$data_kegiatan[$i]->ikk = array($ikk);
						//var_dump($data_kegiatan[$i]->ikk);die;
					}
					$i++;
			}			
			$i=0;							
			$isGrouping = ($e2=="0");
			$namaUnit= "-1";
			//$rs .= '<tr>';
			$no=1;
			foreach($data_kegiatan as $ss){
					if (($namaUnit!=$ss->nama_e2)&&($isGrouping)){
						$namaUnit = $ss->nama_e2;
						$rs .= '<tr>';
						$rs .= '<td width="520" colspan="4"><b>'.$ss->nama_e2.'</b></td>';
						$rs .= '</tr>';
						$no=1;
					//	continue;
					}
					/*if ($i==0)
						$rs .= '<td    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
					else {						
						$rs .= '<tr>';
						$rs .= '<td  rowspan="'.$ss->rowspan.'" valign="top">'.$ss->deskripsi.'</td>';
					}*/
					$rs .= '<tr>';
					$rs .= '<td  width="180" rowspan="'.$ss->rowspan.'" valign="top">'.$ss->deskripsi.'</td>';
					
					$jml_data_iku = count($ss->ikk);
					$x=0;
					if ($jml_data_iku>0){
						foreach($ss->ikk as $iku){
							if ($x>0){
								$rs .= '<tr>';
							  
							}
							$rs .= '<td   width="30" valign="top">'.($no).'.</td>';							  
							$rs .= '<td   width="230" valign="top">'.$iku->deskripsi.'</td>';							  
							$rs .= '<td   width="80" valign="top">'.$iku->satuan.'</td>';									
							$rs .= '</tr>';
							$no++;
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
		if ($forExcel) {
			return	 $data_kegiatan;
		}
		else {
			if ($ajaxCall)	echo $rs;
			else return $rs;
		}
	}
	
	
	function get_rencana_detail($tahun,$e1,$e2,$ajaxCall=true,$forExcel=false){
		$dataAll = array();
		
		$rs = '';
		$params['tahun_renstra'] = $tahun;
		$params['kode_e1'] = $e1;
		if ($e2!="0")
			$params['kode_e2'] = $e2;
			
			if ($ajaxCall)
				$rs = '<table class="display table table-bordered table-striped" width="100%">';
			else
				$rs = '<table  border="1" cellpadding="2" cellspacing="0">';
			$arrTahun = explode("-",$tahun);
			
			$rangetahun = $arrTahun[1]-$arrTahun[0];
			$setValignMiddle = '';$rowspan =2;
			if (!$ajaxCall)
				$setValignMiddle =  '<span style="font-size:5px;">'.str_repeat('&nbsp;<br/>', $rowspan-1).'</span>';
		//	$rs = '<table class="table" border="1">';
			$rs .= '<thead><tr  align="center" valign="middle">						
						<th style="vertical-align:middle;text-align:center;width:20%"  valign="middle" width="100" rowspan="2">'.$setValignMiddle.'Sasaran Strategis</th>
						<th style="vertical-align:middle;text-align:center;width:1%" width="30" rowspan="2" >'.$setValignMiddle.'No.</th>
						<th style="vertical-align:middle;text-align:center;width:50%" width="150" rowspan="2">'.$setValignMiddle.'Indikator Kinerja Kegiatan (IKK)</th>
						<th style="vertical-align:middle;text-align:center;width:10%" width="80" rowspan="2">'.$setValignMiddle.'Satuan</th>
						<th style="vertical-align:middle;text-align:center" width="'.(85*($rangetahun+1)).'" colspan="'.($rangetahun+1).'">Target Pencapaian</th>
					</tr>';
			$rs .= 	'<tr>';
				for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)	
						$rs .= 	'<th style="vertical-align:middle;text-align:center" width="85">'.$colTahun.'</th>';
						
			$rs .= 	'		</tr></thead>';	
			$rs .= '<tbody>';		
			$i=0;
			 
			
				
				$data_kegiatan = $this->sasaran_kegiatan->get_renstra($params);
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
								//if ($kode_iku != $iku->kode_ikk){
									$kode_iku = $iku->kode_ikk;
									$data_kegiatan[$j]->iku[$x]->deskripsi = $iku->deskripsi;					
									$data_kegiatan[$j]->iku[$x]->satuan = $iku->satuan;					
									//$data_kegiatan[$j]->iku[$x]->target[$iku->tahun] = $iku->target;	
									$data_kegiatan[$j]->iku[$x]->target1 = $iku->target_thn1;	
									$data_kegiatan[$j]->iku[$x]->target2 = $iku->target_thn2;	
									$data_kegiatan[$j]->iku[$x]->target3 = $iku->target_thn3;	
									$data_kegiatan[$j]->iku[$x]->target4 = $iku->target_thn4;	
									$data_kegiatan[$j]->iku[$x]->target5 = $iku->target_thn5;	
								
									$data_kegiatan[$j]->rowspan++;
									$x++;
								/*}
								else {
									$data_kegiatan[$j]->iku[$x-1]->target[$iku->tahun] = $iku->target;	
								}*/
							}
						}
						else {
							$x=0;
							$data_kegiatan[$j]->iku[$x]->deskripsi = '';
							$data_kegiatan[$j]->iku[$x]->satuan = '';
							//$data_kegiatan[$j]->iku[$x]->target[$iku->tahun] = $iku->target;	
							$data_kegiatan[$j]->iku[$x]->target1 = '';
							$data_kegiatan[$j]->iku[$x]->target2 = '';
							$data_kegiatan[$j]->iku[$x]->target3 = '';
							$data_kegiatan[$j]->iku[$x]->target4 = '';
							$data_kegiatan[$j]->iku[$x]->target5 = '';
						}
						//$jml_data_iku = count($data_iku);
						
						$j++;
					}			
				}
				
			 $i=0;$no=1;			
				$jml_data_kegiatan = sizeof($data_kegiatan);
				
				
				if (isset($data_kegiatan)){	
					$rs .= '<tr>';					
					$j=0;					
					foreach($data_kegiatan as $ss){
						if ($j==0){
							if ($ss->rowspan==0)
								$rs .= '<td  width="100"    valign="top">'.$ss->deskripsi.'</td>';
							else
								$rs .= '<td width="100"    rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
						}
						else {
							$rs .= '<tr>';							
							if ($ss->rowspan==0)								
								$rs .= '<td   width="100"   valign="top">'.$ss->deskripsi.'</td>';
							else								
								$rs .= '<td  width="100"   rowspan="'.$ss->rowspan.'"  valign="top">'.$ss->deskripsi.'</td>';
						}
						
						$jml_data_iku = count($data_kegiatan[$j]->iku);
						$x=0;
						if ($jml_data_iku>0){
							foreach($data_kegiatan[$j]->iku as $iku){
								if ($x==0){
								  
								}
								else {
									//
									$rs .= '<tr>';
									
								}
									$rs .= '<td  width="30"  align="center" valign="top">'.$no.'</td>';
									$rs .= '<td width="150"   valign="top">'.$iku->deskripsi.'</td>';
								  $rs .= '<td  width="80" valign="top">'.$iku->satuan.'</td>';
								//  for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){	
										//$realisasi = isset($iku->target[$colTahun])?$iku->target[$colTahun]:'-';
										$realisasi = isset($iku->target1)?$iku->target1:'-';
										$rs .= 	'<td width="85" align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
										$realisasi = isset($iku->target2)?$iku->target2:'-';
										$rs .= 	'<td width="85" align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
										$realisasi = isset($iku->target3)?$iku->target3:'-';
										$rs .= 	'<td width="85" align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
										$realisasi = isset($iku->target4)?$iku->target4:'-';
										$rs .= 	'<td width="85" align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
										$realisasi = isset($iku->target5)?$iku->target5:'-';
										$rs .= 	'<td width="85" align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
										
								//  }		
								  $rs .= '</tr>';
								$x++;$no++;
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
		if ($forExcel) {
			return	 $data_kegiatan;
		}
		else {
			return $rs;
		}
	}
	
	function get_pendanaan_detail($tahun,$e1,$e2,$ajaxCall=true,$forExcel=false){
		$dataAll = array();
		$params['tahun_renstra']=$tahun;
		$params['kode_e1'] = $e1;
		if ($e2!="0")
			$params['kode_e2'] = $e2;
		$isGrouping = false;//($e2=="0");
		$rs = '';
		
			if ($ajaxCall)
				$rs = '<table class="display table table-bordered table-striped" width="100%">';
			else
				$rs = '<table  border="1" cellpadding="2" cellspacing="0">';
			$arrTahun = explode("-",$tahun);
			
			$rangetahun = $arrTahun[1]-$arrTahun[0];
			$setValignMiddle = '';$rowspan =2;
			if (!$ajaxCall)
				$setValignMiddle =  '<span style="font-size:5px;">'.str_repeat('&nbsp;<br/>', $rowspan-1).'</span>';
		//	$rs = '<table class="table" border="1">';
			$rs .= '<thead><tr  align="center">						
						<th style="vertical-align:middle;text-align:center;width:1%" width="30" rowspan="2">'.$setValignMiddle.'NO.</th>
						<th style="vertical-align:middle;text-align:center;width:30%" width="200" rowspan="2">'.$setValignMiddle.'NAMA KEGIATAN</th>
						<th style="vertical-align:middle;text-align:center" width="'.(90*($rangetahun+1)).'"  colspan="'.($rangetahun+1).'">ALOKASI PENDANAAN</th>
						<th style="vertical-align:middle;text-align:center;width:15%" width="100" rowspan="2">'.$setValignMiddle.'TOTAL</th>
					</tr>';
			$rs .= 	'<tr>';
				for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++)	
					$rs .= 	'<th style="vertical-align:middle;text-align:center"  width="90">'.$colTahun.'</th>';
						
			$rs .= 	'</tr></thead>';	
			$rs .= '<tbody>';		
			$i=0;
			 
			
				
				$data_program = $this->pendanaan->get_renstra($params);
				$jml_data_program = count($data_program);
				$unitKerja ="";
				
				
			 $i=0;
			 $no=1;
			
				$jml_data_program = sizeof($data_program);
				
				
				if (isset($data_program)){		
					$total1=0;$total2=0;$total3=0;$total4=0;$total5=0;
					foreach($data_program as $ss){
						if (($unitKerja!=$ss->nama_e2)&&($isGrouping)){
							$unitKerja = $ss->nama_e2;
							$rs .= '<tr>';
							$rs .= '<td colspan="'.($rangetahun+3).'"><b>'.$ss->nama_e2.'</b></td>';
							$rs .= '</tr>';
							
							$no=1;
							//continue;
						}
						
						$rs .= '<tr>';
						
						$rs .= '<td width="30"   align="center">'.$no.'</td>';
						$rs .= '<td  width="200"   valign="top">'.$ss->nama_kegiatan.'</td>';
						
						
							$total = 0;
							$realisasi = isset($ss->target_thn1)?$ss->target_thn1:'-';
							$total += isset($ss->target_thn1)?$ss->target_thn1:0;
							$total1 += isset($ss->target_thn1)?$ss->target_thn1:0;
							$rs .= 	'<td width="90" align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							
							$realisasi = isset($ss->target_thn2)?$ss->target_thn2:'-';
							$total += isset($ss->target_thn2)?$ss->target_thn2:0;
							$total2 += isset($ss->target_thn2)?$ss->target_thn2:0;
							$rs .= 	'<td width="90" align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							
							$realisasi = isset($ss->target_thn3)?$ss->target_thn3:'-';
							$total += isset($ss->target_thn3)?$ss->target_thn3:0;
							$total3 += isset($ss->target_thn3)?$ss->target_thn3:0;
							$rs .= 	'<td width="90" align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							
							$realisasi = isset($ss->target_thn4)?$ss->target_thn4:'-';
							$total += isset($ss->target_thn4)?$ss->target_thn4:0;
							$total4 += isset($ss->target_thn4)?$ss->target_thn4:0;
							$rs .= 	'<td width="90" align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							
							$realisasi = isset($ss->target_thn5)?$ss->target_thn5:'-';
							$total += isset($ss->target_thn5)?$ss->target_thn5:0;
							$total5 += isset($ss->target_thn5)?$ss->target_thn5:0;
							$rs .= 	'<td width="90" align="right">'.$this->utility->cekNumericFmt($realisasi).'</td>';
							
							$rs .= 	'<td width="100" align="right">'.$this->utility->cekNumericFmt($total).'</td>';
							
						
						$rs .= '</tr>';

						$no++;
					
					}
					$rs .= '<tr>';
					$rs .= '<td  colspan="2" align="center" width="230"><b>TOTAL</b></td>';
					$rs .= 	'<td width="90" align="right"><b>'.$this->utility->cekNumericFmt($total1).'</b></td>';
					$rs .= 	'<td width="90" align="right"><b>'.$this->utility->cekNumericFmt($total2).'</b></td>';
					$rs .= 	'<td width="90" align="right"><b>'.$this->utility->cekNumericFmt($total3).'</b></td>';
					$rs .= 	'<td width="90" align="right"><b>'.$this->utility->cekNumericFmt($total4).'</b></td>';
					$rs .= 	'<td width="90" align="right"><b>'.$this->utility->cekNumericFmt($total5).'</b></td>';
					$rs .= 	'<td width="100" align="right"><b>'.$this->utility->cekNumericFmt($total1+$total2+$total3+$total4+$total5).'</b></td>';
					$rs .= '</tr>';
				
				}
				else { 
					//$rs .= '<td></td>';
					//$rs .= '<td></td>';
				}
				//$rs .= '</tr>';
				
			 $rs .= '</tbody>';		
			 $rs .= '</table>';
		
		// var_dump($data[0]);die;
		if ($forExcel) {
			return	 $data_program;
		}
		else {
			return $rs;
		}
	}

	public function print_pdf($tahun,$e1,$e2){
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Rencana Strategis Unit Kerja Eselon II');
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
		 $pdf->Write(0, 'RENCANA STRATEGIS '.($e2=="0"?"UNIT KERJA ESELON II":strtoupper($this->mgeneral->getValue("nama_e2",array('tahun_renstra'=>$tahun,'kode_e2'=>$e2),"anev_eselon2"))), '', 0, 'L', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		 $data['renstra']		= $tahun;
		$data['e1_nama'] = strtoupper($this->mgeneral->getValue("nama_e1",array('tahun_renstra'=>$tahun,'kode_e1'=>$e1),"anev_eselon1"));
	   $data['tujuan']		= $this->get_tujuan($tahun,$e1,$e2,false);
	   $data['misi']		= $this->get_misi($tahun,$e1,$e2,false);
	   $data['visi']		= $this->get_visi($tahun,$e1,$e2,false);	  
	   $data['sasaran']		= $this->get_sasaran($tahun,$e1,$e2,false);
		$html = $this->load->view('laporan/print/pdf_renstra_e2',$data,true);
		//$html = $data['sasaran'];
		//var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);
		
		
	
	
	
		$pdf->Output('RenstraEselonII.pdf', 'I');
	}

	public function target_print_pdf($tahun,$e1,$e2){
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Rencana Strategis Eselon II');
		$pdf->SetHeaderMargin(15);
		$pdf->SetLeftMargin(10);
		$pdf->SetRightMargin(10);
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
			//$e1='';
		// set font
		$pdf->SetFont('helvetica', 'B', 12);

		// add a page
		$pdf->AddPage('L');
	
		 $pdf->Write(0, 'TARGET CAPAIAN KINERJA '.($e2=="0"?"UNIT KERJA ESELON II":strtoupper($this->mgeneral->getValue("nama_e2",array('tahun_renstra'=>$tahun,'kode_e2'=>$e2),"anev_eselon2"))), '', 0, 'L', true, 0, false, false, 0);
		 $pdf->Write(0, strtoupper($this->mgeneral->getValue("nama_e1",array('tahun_renstra'=>$tahun,'kode_e1'=>$e1),"anev_eselon1")), '', 0, 'L', true, 0, false, false, 0);
		 $pdf->Write(0, 'TAHUN '.$tahun, '', 0, 'L', true, 0, false, false, 0);
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		$data['target'] =  $this->get_rencana_detail($tahun,$e1,$e2,false);
		$html = $this->load->view('laporan/print/pdf_renstra_target_e2',$data,true);
		
		
		
		
		
	//	var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');		
		
		
		
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('TargetCapaianEselonII.pdf', 'I');
	}
	
	public function dana_print_pdf($tahun,$e1,$e2){
		$this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Alokasi Pendanaan Eselon II');
		$pdf->SetHeaderMargin(15);
		$pdf->SetLeftMargin(10);
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
		
		$pdf->Write(0, 'KEBUTUHAN PENDANAAN '.($e2=="0"?"UNIT KERJA ESELON II":strtoupper($this->mgeneral->getValue("nama_e2",array('tahun_renstra'=>$tahun,'kode_e2'=>$e2),"anev_eselon2"))), '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(0, strtoupper($this->mgeneral->getValue("nama_e1",array('tahun_renstra'=>$tahun,'kode_e1'=>$e1),"anev_eselon1")), '', 0, 'L', true, 0, false, false, 0);
		 $pdf->Write(0, 'TAHUN '.$tahun, '', 0, 'L', true, 0, false, false, 0);
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		$data['dana'] =  $this->get_pendanaan_detail($tahun,$e1,$e2,false);
		$html = $this->load->view('laporan/print/pdf_renstra_dana_e2',$data,true);
	//	$html = $data['sasaran'];
		$pdf->writeHTML($html, true, false, false, false, '');		
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('AlokasiDanaEselonII.pdf', 'I');
	}
	
	public function excel($tahun,$e1,$e2){
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Renstra Eselon I');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'RENCANA STRATEGIS '.($e2=="0"?"UNIT KERJA ESELON II":strtoupper($this->mgeneral->getValue("nama_e2",array('tahun_renstra'=>$tahun,'kode_e2'=>$e2),"anev_eselon2"))));
		$this->excel->getActiveSheet()->setCellValue('A2', 'Periode Renstra ');
		$this->excel->getActiveSheet()->setCellValue('B2', $tahun);
		$this->excel->getActiveSheet()->mergeCells('B2:D2');
		$this->excel->getActiveSheet()->mergeCells('A3:D3');
		$params = array("tahun_renstra"=>$tahun);
		$posisiRow = 4;
		$params['tahun_renstra']=$tahun;
		$params['kode_e1'] = $e1;
		if ($e2!="0")
			$params['kode_e2'] = $e2;
		$visi=$this->visi_e2->get_all($params);
		$visi_arr = null;		
		if (isset($visi)){
			foreach ($visi as $u){
				$visi_arr[] = array($u->visi_e2);
			}
		}
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Visi');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		if (count($visi_arr)>0){
			$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+count($visi_arr)-1));
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->fromArray($visi_arr,NULL,'B'.$posisiRow);		
			for ($i=0;$i<count($visi_arr);$i++)
				$this->excel->getActiveSheet()->mergeCells('B'.($posisiRow+$i).':D'.($posisiRow+$i));
			$posisiRow += count($visi_arr);
		}else $posisiRow++;
		
		
		$misi = $this->misi_e2->get_all($params);
		$misi_arr = null;		
		if (isset($misi)){
			foreach ($misi as $u){
				$misi_arr[] = array($u->misi_e2);
			}
		}
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Misi');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		if (count($misi_arr)>0){
			$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+count($misi_arr)-1));
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->fromArray($misi_arr,NULL,'B'.$posisiRow);
			for ($i=0;$i<count($misi_arr);$i++)
				$this->excel->getActiveSheet()->mergeCells('B'.($posisiRow+$i).':D'.($posisiRow+$i));
			
			$posisiRow += count($misi_arr);				
		}else $posisiRow++;
		
		$tujuan = $this->tujuan_e2->get_all($params);
		$tujuan_arr = null;		
		if (isset($tujuan)){
			foreach ($tujuan as $u){
				$tujuan_arr[] = array($u->tujuan_e2);
			}
		}
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Tujuan');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		if (count($tujuan_arr)>0){
			$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+count($tujuan_arr)-1));
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->fromArray($tujuan_arr,NULL,'B'.$posisiRow);			
			for ($i=0;$i<count($tujuan_arr);$i++)
				$this->excel->getActiveSheet()->mergeCells('B'.($posisiRow+$i).':D'.($posisiRow+$i));
			$posisiRow += count($tujuan_arr);		
		}else $posisiRow++;
		
		/////SASARAN STRATEGIS DAN IKU HERE...
		//jeda 1 row
		$posisiRow++;
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Sasaran Strategis dan IKK');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':D'.$posisiRow);
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$posisiRow++;
		$columHeader = array("Sasaran Strategis","No.","Indikator Kinerja Kegiatan (IKK)","Satuan");		
		$sasaran = $this->get_sasaran($tahun,$e1,$e2,false,true);
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow.':D'.$posisiRow)->applyFromArray(
				array(
					'font'    => array('bold'=> true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
					'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
				));
		
		$this->excel->getActiveSheet()->fromArray($columHeader,NULL,'A'.$posisiRow);
		$posisiRow++;
		$no=1;
		$isGrouping = ($e2=="0");
		$namaUnit= "-1";
		if (isset($sasaran)){
			foreach($sasaran as $s){ 
				if (($namaUnit!=$s->nama_e2)&&($isGrouping)){
					$namaUnit = $s->nama_e2;
					$data[] = array($s->nama_e2,'','','');	
					$no=1;
						//	continue;
				}
				foreach($s->ikk as $iku){
					
					$data[] = array($s->deskripsi,$no++,$iku->deskripsi,$iku->satuan);
				}
			}
			if (count($data)>0){
				$this->excel->getActiveSheet()->fromArray($data,NULL,'A'.$posisiRow);	
				$posisiRow += count($data);
			}else $posisiRow++;
		}//end isset
		/////END    SASARAN STRATEGIS DAN IKU HERE...
		
		//jeda 1 row
		$posisiRow++;
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Target Capaian Kinerja');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, 'Klik Disini');
		$this->excel->getActiveSheet()->mergeCells('B'.$posisiRow.':D'.$posisiRow);
		$this->excel->getActiveSheet()->getCell('B'.$posisiRow)->getHyperlink()->setUrl("sheet://'Target Capaian Kinerja'!A1");
		$posisiRow++;		
		
		/*$program = $this->kegiatan_e2->get_renstra($params);
		$program_arr = null;		
		if (isset($program)){
			foreach ($program as $u){
				$program_arr[] = array($u->nama_kegiatan);
			}
		}
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Program');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		if (count($program_arr)>0){
			$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+count($program_arr)-1));
			$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excel->getActiveSheet()->fromArray($program_arr,NULL,'B'.$posisiRow);
			for ($i=0;$i<count($program_arr);$i++)
				$this->excel->getActiveSheet()->mergeCells('B'.($posisiRow+$i).':D'.($posisiRow+$i));
			$posisiRow += count($program_arr);
		}else $posisiRow++;
		*/
		//jeda 1 row
		$posisiRow++;
		$this->excel->getActiveSheet()->setCellValue('A'.$posisiRow, 'Kebutuhan Pendanaan');
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow)->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('B'.$posisiRow, 'Klik Disini');
		$this->excel->getActiveSheet()->mergeCells('B'.$posisiRow.':D'.$posisiRow);
		$this->excel->getActiveSheet()->getCell('B'.$posisiRow)->getHyperlink()->setUrl("sheet://'Kebutuhan Pendanaan'!A1");
		$posisiRow++;
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		//$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(100);
		$this->excel->getActiveSheet()->getStyle('A4:A'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('B4:B'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('C4:C'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('D4:D'.$posisiRow)->getAlignment()->setWrapText(true); 
		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(4);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(80);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		
		
		$arrTahun = explode("-",$tahun);		
		$rangetahun = $arrTahun[1]-$arrTahun[0];
		for ($colTahun=$arrTahun[0];$colTahun<=$arrTahun[1];$colTahun++){
			$columRentang[] = $colTahun;
		}
		//buat sheet TARGET CAPAIAN KINERJA-------
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet()->setTitle('Target Capaian Kinerja');
		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:E1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'TARGET CAPAIAN KINERJA '.($e2=="0"?"UNIT KERJA ESELON II":strtoupper($this->mgeneral->getValue("nama_e2",array('tahun_renstra'=>$tahun,'kode_e2'=>$e2),"anev_eselon2"))));
		$this->excel->getActiveSheet()->setCellValue('A2', 'TAHUN');
		$this->excel->getActiveSheet()->setCellValue('B2', $tahun);
		$this->excel->getActiveSheet()->mergeCells('B2:E2');
		$this->excel->getActiveSheet()->mergeCells('A3:F3');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(4);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(80);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$posisiRow = 5;
		$columHeader = array("Sasaran Strategis","No.","Indikator Kinerja Kegiatan (IKK)","Satuan","Target Pencapaian");				
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow.':D'.($posisiRow+1))->applyFromArray(
				array(
					'font'    => array('bold'=> true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
					'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
				));
		
		$this->excel->getActiveSheet()->fromArray($columHeader,NULL,'A'.$posisiRow);
		$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+1));
		$this->excel->getActiveSheet()->mergeCells('B'.$posisiRow.':B'.($posisiRow+1));
		$this->excel->getActiveSheet()->mergeCells('C'.$posisiRow.':C'.($posisiRow+1));
		$this->excel->getActiveSheet()->mergeCells('D'.$posisiRow.':D'.($posisiRow+1));
		//$this->excel->getActiveSheet()->mergeCells('E'.$posisiRow.':D'.($posisiRow+1));
		$posisiRow++;		
		$this->excel->getActiveSheet()->fromArray($columRentang,NULL,'E'.$posisiRow);
		$posisiRow++;
		$target = $this->get_rencana_detail($tahun,$e1,$e2,false,true);
		$no=1;
		if (isset($target)){
		
			foreach($target as $s){ 
				foreach($s->iku as $iku){
					$dataTarget[] = array($s->deskripsi,$no++,$iku->deskripsi,$iku->satuan,$iku->target1,$iku->target2,$iku->target3,$iku->target4,$iku->target5);
				}
			}
			if (count($dataTarget)>0){
				$this->excel->getActiveSheet()->fromArray($dataTarget,NULL,'A'.$posisiRow);	
				$posisiRow += count($dataTarget);
			}else $posisiRow++;
		}
		
		$this->excel->getActiveSheet()->getStyle('A4:A'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('B4:B'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('C4:C'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('D4:D'.$posisiRow)->getAlignment()->setWrapText(true); 
		//---------------------end  target capaian kinerja
		
		//buat sheet kEBUTUHANN PENDANAAN
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(2);
		$this->excel->getActiveSheet()->setTitle('Kebutuhan Pendanaan');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:E1');
		$this->excel->getActiveSheet()->setCellValue('A1', 'KEBUTUHAN PENDANAAN '.($e2=="0"?"UNIT KERJA ESELON II":strtoupper($this->mgeneral->getValue("nama_e2",array('tahun_renstra'=>$tahun,'kode_e2'=>$e2),"anev_eselon2"))));
		$this->excel->getActiveSheet()->setCellValue('A2', 'TAHUN');
		$this->excel->getActiveSheet()->setCellValue('B2', $tahun);
		$this->excel->getActiveSheet()->mergeCells('A3:F3');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$posisiRow = 5;
		$columHeader = array("No.","Nama Kegiatan","Alokasi Pendanaan","Total");		
		$this->excel->getActiveSheet()->getStyle('A'.$posisiRow.':D'.($posisiRow+1))->applyFromArray(
				array(
					'font'    => array('bold'=> true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
					'borders' => array('top'=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					'fill' => array('type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,'rotation'   => 90,'startcolor' => array('argb' => 'FFA0A0A0'),'endcolor'   => array('argb' => 'FFFFFFFF'))
				));
		
		$this->excel->getActiveSheet()->fromArray($columHeader,NULL,'A'.$posisiRow);
		$this->excel->getActiveSheet()->mergeCells('A'.$posisiRow.':A'.($posisiRow+1));
		$this->excel->getActiveSheet()->mergeCells('B'.$posisiRow.':B'.($posisiRow+1));
		$this->excel->getActiveSheet()->mergeCells('C'.$posisiRow.':G'.($posisiRow));
		$this->excel->getActiveSheet()->mergeCells('H'.$posisiRow.':H'.($posisiRow+1));
		$this->excel->getActiveSheet()->setCellValue('H'.$posisiRow, 'Total');
		//$this->excel->getActiveSheet()->mergeCells('E'.$posisiRow.':D'.($posisiRow+1));
		$posisiRow++;		
		$this->excel->getActiveSheet()->fromArray($columRentang,NULL,'C'.$posisiRow);
		$posisiRow++;
		$pendanaan = $this->get_pendanaan_detail($tahun,$e1,$e2,false,true);
		$no=1;		
		if (isset($pendanaan)){
			$total1=0;$total2=0;$total3=0;$total4=0;$total5=0;
			foreach($pendanaan as $ss){ 
				$total = 0;
				$realisasi1 = isset($ss->target_thn1)?$ss->target_thn1:'-';
				$total += isset($ss->target_thn1)?$ss->target_thn1:0;
				$total1 += isset($ss->target_thn1)?$ss->target_thn1:0;
				$realisasi2 = isset($ss->target_thn2)?$ss->target_thn2:'-';
				$total += isset($ss->target_thn2)?$ss->target_thn2:0;
				$total2 += isset($ss->target_thn2)?$ss->target_thn2:0;
				$realisasi3 = isset($ss->target_thn3)?$ss->target_thn3:'-';
				$total += isset($ss->target_thn3)?$ss->target_thn3:0;
				$total3 += isset($ss->target_thn3)?$ss->target_thn3:0;
				$realisasi4 = isset($ss->target_thn4)?$ss->target_thn4:'-';
				$total += isset($ss->target_thn4)?$ss->target_thn4:0;
				$total4 += isset($ss->target_thn4)?$ss->target_thn4:0;
				$realisasi5 = isset($ss->target_thn5)?$ss->target_thn5:'-';
				$total += isset($ss->target_thn5)?$ss->target_thn5:0;
				$total5 += isset($ss->target_thn5)?$ss->target_thn5:0;
				$dataPendanaan[] = array($no++,$ss->nama_kegiatan,$realisasi1,$realisasi2,$realisasi3,$realisasi4,$realisasi5, $this->utility->cekNumericFmt($total));
			
			}
			if (count($dataPendanaan)>0){
				$this->excel->getActiveSheet()->fromArray($dataPendanaan,NULL,'A'.$posisiRow);	
				$posisiRow += count($dataPendanaan);
			}else $posisiRow++;
		}	
		$this->excel->getActiveSheet()->getStyle('A4:A'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('B4:B'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('C4:C'.$posisiRow)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('D4:D'.$posisiRow)->getAlignment()->setWrapText(true); 
		//---------------------end  kEBUTUHANN PENDANAAN
		
		
		
		$this->excel->setActiveSheetIndex(0);	
		$filename='RenstraEselonII'.$tahun.'.xls'; 
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