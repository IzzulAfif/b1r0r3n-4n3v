<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-22 00:00
 @revision	 :
*/

class Relevansi_sastra extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();		
		$this->load->model('/admin/tahun_renstra_model','tahun_renstra');
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('laporan/relevansi_sastra_model','relevansi',TRUE);
	}	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load($setting); #load static template file		
		$data = null;
		$template['konten']	= $this->load->view('laporan/relevansi_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	
	function loadpage(){
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "datatables");
		$template			= $this->template->load_popup($setting); #load static template file		
		$data = null;
		$data['renstra']	= $this->tahun_renstra->get_list(null);
		echo $this->load->view('laporan/relevansi_sastra_v',$data,true); #load konten template file
		
		#load container for template view
		//$this->load->view('template/container_popup',$template);
	}
	
	function get_sasaran($periode,$tahun,$chkKL,$chkE1,$chkE2,$e1,$e2,$ajaxCall=true){
		$rs = '';
		
		
		if ($ajaxCall)
			$head = '<table class="display table table-bordered table-striped" width="100%">';
		else
			$head = '<table  border="1" cellpadding="4" cellspacing="0">';
			
		$headKL = '';	
		$headSastra = '';	
		
		
		if (($chkKL=="true")&&($chkE1=="false")&&($chkE2=="false"))
			$headKL .= '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="100">Sasaran Kemenhub</th>';	
		if ($chkKL=="true")	
			$headSastra .= '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="100">Sasaran Strategis</th>';	
		
		$headE1 = '';
		$headE2 = '';
		if ($chkE1=="true")
			$headE1 = '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="100">Sasaran Program</th>';	
		if ($chkE2=="true")
			$headE2 = '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="100">Sasaran Kegiatan</th>';	
		
		
		$head .= '<thead>
                    	<tr>'.$headKL.$headSastra.$headE1.$headE2.'</tr>
                    </thead>
					 <tbody>';	
					 
		$colKL = '';			 
		$colSastra = '';			 
		$colE1 = '';			 
		$colE2 = '';			 
		$params['tahun_renstra'] = $periode;
		$params['tahun'] = $tahun;
		$params['chkE1'] = $chkE1;
		$params['chkE2'] = $chkE2;
		if (($e1!="0")&&($chkE1=="true")) $params['kode_e1'] = $e1;
		if (($e2!="0")&&($chkE2=="true")) {
			$params['kode_e2'] = $e2;
		}
		if (($chkE1=="false")&&($chkE2=="true")) $params['kode_e1'] = $e1;
		
		$data = $this->relevansi->get_sasaran($params);
		$kode_sasaran_kl = '-1';
		$kode_ss_kl = '-1';
		$kode_sp_e1 = '-1';
		$kode_sk_e2 = '-1';
		if (isset($data)){
			$rs .= $head;
			$i=0;$cur_idx_kl=0;$cur_idx_sastra=0;$cur_idx_e1=0;
			
			foreach ($data as $d){
				if ($headKL!=""){ //tampilkan kolom sasaran KL
					if ($kode_sasaran_kl!=$d->kode_sasaran_kl){
						$kode_sasaran_kl=$d->kode_sasaran_kl;
						$data[$i]->rowspan_skl = 1;
						$cur_idx_kl=$i;
					}					
					else{
						$data[$cur_idx_kl]->rowspan_skl++;
					}
				}
				
				if ($headSastra!=""){ //tampilkan kolom sasaran strategis
					if ($kode_ss_kl!=$d->kode_ss_kl){
						$kode_ss_kl=$d->kode_ss_kl;
						$data[$i]->rowspan_sastra = 1;
						$cur_idx_sastra=$i;
					}					
					else{
						$data[$cur_idx_sastra]->rowspan_sastra++;
					}
				}
				
				if ($headE1!=""){ //tampilkan kolom sasaran program
					if ($kode_sp_e1!=$d->kode_sp_e1){
						$kode_sp_e1=$d->kode_sp_e1;
						$data[$i]->rowspan_program = 1;
						$cur_idx_e1=$i;
					}					
					else{
						$data[$cur_idx_e1]->rowspan_program++;
					}
				}
				$i++;		
			}//end foreach
				$rs .= 	'<tr class="gradeX">';	
			//	var_dump($data);die;
			$noKL=1;$noSastra=1;$noE1=1;$noE2=1;
			foreach ($data as $d){
				if ($headKL!=""){ //tampilkan kolom sasaran KL
					if (isset($d->rowspan_skl)){
						$rs .= '<td width="30" '.($d->rowspan_skl>0?'rowspan="'.$d->rowspan_skl.'"':'').'>'.($noKL++).'</td>';
						$rs .= '<td width="100" '.($d->rowspan_skl>0?'rowspan="'.$d->rowspan_skl.'"':'').'>'.$d->sasaran_kl.'</td>';
						$noSastra=1;
					}
				}
				if ($headSastra!=""){ //tampilkan kolom sasaran strategis
					if (isset($d->rowspan_sastra)){
						$rs .= '<td width="30" '.($d->rowspan_sastra>0?'rowspan="'.$d->rowspan_sastra.'"':'').'>'.($noSastra++).'</td>';
						$rs .= '<td width="100" '.($d->rowspan_sastra>0?'rowspan="'.$d->rowspan_sastra.'"':'').'>'.$d->sasaran_strategis.'</td>';
						$noE1=1;
					}
				}
				if ($headE1!=""){ //tampilkan kolom sasaran program
					if (isset($d->rowspan_program)){
						$rs .= '<td width="30" '.($d->rowspan_program>0?'rowspan="'.$d->rowspan_program.'"':'').'>'.($noE1++).'</td>';
						$rs .= '<td width="100" '.($d->rowspan_program>0?'rowspan="'.$d->rowspan_program.'"':'').'>'.$d->sasaran_program.'</td>';
						$noE2=1;
					}
				}
				if ($headE2!=""){ //tampilkan kolom sasaran kegiatan
					$rs .= '<td width="30" >'.($noE2++).'</td>';
					$rs .= '<td width="100" >'.$d->sasaran_kegiatan.'</td>';
				}
				
				$rs .= '</tr>';
				
			}//end foreach
			
		}//end isset data
		
					 
		$foot = '</tbody></table>';			 
		
		$rs .= $foot;
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
}