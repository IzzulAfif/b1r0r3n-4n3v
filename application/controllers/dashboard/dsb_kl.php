<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : didin
 @date       : 2014-11-04 00:00
 @revision	 :
*/

class dsb_kl extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('evaluasi/program_m','',TRUE);
		$this->load->model('/admin/tahun_renstra_model','setting_th');
	}

	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "DASHBOARD");
		$setting['page']	= array('pg_aktif'	=> "chart");
		//$setting = null;
		$template			= $this->template->load($setting); #load static template file		
		$renstra			= $this->program_m->get_renstra_list();
		end($renstra);         // move the internal pointer to the end of the array
		$key = key($renstra);  // fetches the key of the element pointed to by the internal pointer
		$tahun				= explode("-",$key);
		
		$data['programKerja']	= $this->program_m->get_program_list($tahun[0], $tahun[1]);
			
			$no=0;
			foreach($data['programKerja'] as $key => $value):
				
				$totalProgam	= 0;
				if($no!=0):
					$split	= explode(".",$key);
					$kdE1	= $split[0].".".$split[1];
					$dataCh	= $this->get_data_serapan($tahun[0],$tahun[1],$key,$kdE1);
					
					$totalProgam = 0;
					foreach($dataCh['program'] as $d):
						$totalProgam = $totalProgam+$d;
					endforeach;
					$capaianProgram = number_format($totalProgam/count($dataCh['program']),2,".",".");
					
					$totalAnggaran = 0;
					foreach($dataCh['anggaran'] as $a):
						$totalAnggaran = $totalAnggaran+$a;
					endforeach;
					$serapanAnggaran = number_format($totalAnggaran/count($dataCh['anggaran']),2,".",".");
					
					$grafData[] =  array('kode_program'	=> $key,
										 'nama_program'	=> $value,
										 'capaian'		=> $capaianProgram,
										 'serapan'		=> $serapanAnggaran);
				endif;
				
				$no++;
			endforeach;
		
		$data['graphData']		= $grafData;
		$template['konten']		= $this->load->view('dashboard/dashboard_kl',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	
	function get_data_serapan($tahun_awal, $tahun_akhir, $kode_program,$kode_e1)
	{
		$dRealisasi	= $this->program_m->get_rata2_capain_kinerja($kode_e1, $tahun_awal, $tahun_akhir);
		$dSerapan	= $this->program_m->get_rata2_serapan_anggaran($kode_program, $tahun_awal, $tahun_akhir);
		
		if(count($dRealisasi) > $dSerapan):
			for($a=0;$a<count($dRealisasi);$a++):
				$dtTahun[]		= $dRealisasi[$a]->tahun;
				$dtProgram[]	= (float) number_format($dRealisasi[$a]->persen,2,'.','.');
				$dtAnggaran[]	= (!isset($dSerapan[$a]->persen))?"0":(float) number_format($dSerapan[$a]->persen,2,'.','.');
			endfor;
		else:
			for($a=0;$a<count($dSerapan);$a++):
				$dtTahun[]		= $dSerapan[$a]->tahun;
				$dtProgram[]	= (!isset($dRealisasi[$a]->persen))?0:(float) number_format($dRealisasi[$a]->persen,2,'.','.');
				$dtAnggaran[]	= (float) number_format($dSerapan[$a]->persen,2,'.','.');
			endfor;
		endif;
		$jsonData = array('tahun'=>$dtTahun,'program'=>$dtProgram,'anggaran'=>$dtAnggaran);
		return $jsonData;
	}
}