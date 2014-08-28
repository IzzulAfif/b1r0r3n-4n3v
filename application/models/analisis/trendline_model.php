<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : didin
 @date       : 2014-08-25 13:00
 @fungsi	 : 
 @revision	 :
*/
	
error_reporting(E_ERROR);
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
	
	function eselon1($kode,$sasaran,$indikator,$tahun1,$tahun2)
	{
		$sql = " SELECT tahun,target,realisasi 
				 FROM anev_kinerja_eselon1
				 WHERE kode_e1 = '$kode' AND 
				 kode_sp_e1 = '$sasaran' AND kode_iku_e1 = '$indikator'
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
	
	function convert_data($dataKonten,$tahun1,$tahun2,$thn_target,$target_nilai)
	{	
		if($thn_target > $tahun2):
			$thn_end = $thn_target;
		else:
			$thn_end = $tahun2;
		endif;
		
		$urut = 0;
		for($a=$tahun1;$a<=$thn_end;$a++):
			
			if($a==$thn_target): $simulasi = $this->rumus(json_encode($dataKonten),$thn_target,"realisasi"); else: $simulasi = 0; endif;
			if($dataKonten[$urut]['target']==""): $target = "0"; else: $target=$dataKonten[$urut]['target']; endif;
			if($dataKonten[$urut]['realisasi']==""): $realisasi = "0"; else: $realisasi=$dataKonten[$urut]['realisasi']; endif;
			if($a==$thn_target): 
				$targetline = $simulasi;
				$trendline	= $simulasi;
			else:
				$targetline = $target;
				$trendline	= $realisasi;
			endif;
			
			$dataReturn[] = array('tahun'		=> $a,
								  'target'		=> $target,
								  'realisasi'	=> $realisasi,
								  'simulasi'	=> $simulasi,
								  'trendline'	=> $trendline,
								  'targetline'	=> $targetline);
			$urut++;
		endfor;
		
		return $dataReturn;
	}
	
	function rumus($data,$target,$kode)
	{
		$tahun_target = $target;
		$arrayData = json_decode($data,true);
		
		#persamaan trend linier secara  Least Square method  adalah Y = a + bx,
		
			#perhitungan mencari X dan Y
			$tData	= count($arrayData); #total data
			$x1		= 0;
			$y1		= 0;
			$xy		= 0; #total (nilai x1 dikali nilai y1)
			$x2		= 0; #total nilai x1 kuadrat
			
			for($a=1;$a<=count($arrayData);$a++):
				$x1 = $x1+$a;
				$y1	= $y1+$arrayData[$a-1][$kode]; 
				$xy = $xy+($a*$arrayData[$a-1][$kode]);
				$x2 = $x2+($a*$a);
			endfor;
			
			$nilaiX	= $x1/$tData;
			$nilaiY	= $y1/$tData;
			
			#perhitungan mencari nilai a dan b
			#nilai a di dapat dari rumus = (NilaiY) - b(NilaiX)
			#nilai b di dapat dari rumus = totaldata dikali (xy) - (total x1) dikali (total y1)
			#							   ----------------------------------------------------------------------------------
			#							   totaldata dikali (x2) - (x1 kuadrat)
			
			$nilai_b = (($tData*$xy)-($x1*$y1))/(($tData*$x2)-($x1*$x1));	
			$nilai_a = $nilaiY-($nilai_b*$nilaiX);								
			
			$selisih_thn 	= $tahun_target-$arrayData[count($arrayData)-1]['tahun'];
			$t			 	= count($arrayData)+$selisih_thn;
			$simulasi_nilai = $nilai_a+ ($nilai_b*($t));
			
		/*echo "x1 = ".$x1."<br>";
		echo "y1 = ".$y1."<br>";
		echo "xy = ".$xy."<br>";
		echo "x2 = ".$x2."<br>";
		echo "X  = ".$nilaiX."<br>";
		echo "Y	 = ".$nilaiY."<br>";
		echo "a	 = ".$nilai_a."<br>";
		echo "b	 = ".$nilai_b."<br>";
		echo "simulasi = ".$simulasi_nilai."<Br>";*/
		return $simulasi_nilai;
	}
}

