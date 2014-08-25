<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : didin
 @date       : 2014-08-25 13:00
 @fungsi	 : 
 @revision	 :
*/
	

class trendline_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function kl($kode,$sasaran,$indikator,$tahun1,$tahun2)
	{
		$sql = " SELECT tahun,target,realisasi 
				 FROM anev_kinerja_kl
				 WHERE kode_kl = '$kode' AND 
				 kode_ss_kl = '$sasaran' AND kode_iku_kl = '$indikator'
				 AND tahun >= '$tahun1' AND tahun <= '$tahun2'
				 ORDER BY tahun ASC";
		$data= $this->mgeneral->run_sql($sql);
		
		#convert object jadi array data
		foreach($data as $d):
			$arrayData[$d->tahun]	= array('target'=>$d->target,'realisasi'=>$d->realisasi);
		endforeach;
		
		#urutkan array data berdasarkan range tahun
		for($a=$tahun1;$a<=$tahun2;$a++): 
			if(array_key_exists("$a",$arrayData)):
				
				$target 	= $arrayData[$a]['target'];
				$realisasi	= $arrayData[$a]['realisasi'];
				if($target!=""):
					$target		= $arrayData[$a]['target'];
				else:
					$target 	= "0";
				endif;
				
				if($realisasi!=""):
					$realisasi	= $arrayData[$a]['realisasi'];
				else:
					$realisasi 	= "0";
				endif;
				
			else:
				$target 	= "0";
				$realisasi	= "0";
			endif;
			
			$dataGrafik[] = array('tahun'		=> $a,
								  'target'		=> $target,
								  'realisasi'	=> $realisasi);
		endfor;
		
		return $dataGrafik;
	}
}

