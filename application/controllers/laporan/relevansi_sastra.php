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
		//atur lebar kolom utk pdf		
		$widthKl = 100;
		$widthSastra = 120;
		$widthSasProg = 140;
		$widthSasKeg = 180;		
		
		if (($chkKL=="true")&&($chkE1=="false")&&($chkE2=="false")){
			$widthKl = 230;
			$headKL .= '<th class="col-sm-1"
			style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="'.$widthKl.'">Sasaran Kemenhub</th>';	
		}
		if ($chkKL=="true"){	
			if (($chkE1=="false")&&($chkE2=="false"))
				$widthSastra = 230;
			else if ((($chkE1=="true")&&($chkE2=="false"))||(($chkE1=="false")&&($chkE2=="true")))
				$widthSastra = 150;
			$headSastra .= '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="'.$widthSastra.'">Sasaran Strategis</th>';	
		}
		
		$headE1 = '';
		$headE2 = '';
		if ($chkE1=="true"){
			if (($chkKL=="true")&&($chkE2=="false"))
				$widthSasProg = 310;
			else if (($chkKL=="false")&&($chkE2=="false"))
				$widthSasProg = 500;
			else if (($chkKL=="false")&&($chkE2=="true"))
				$widthSasProg = 200;	
			$headE1 = '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="'.$widthSasProg.'">Sasaran Program</th>';	
		}
		if ($chkE2=="true"){
			if (($chkKL=="true")&&($chkE1=="false"))
				$widthSasKeg = 310;
			else if (($chkKL=="false")&&($chkE1=="false"))
				$widthSasKeg = 500;
			else if (($chkKL=="false")&&($chkE1=="true"))
				$widthSasKeg = 250;
			$headE2 = '<th class="col-sm-1" style="vertical-align:middle;text-align:center;width:0.001%" width="30">No.</th><th class="col-sm-1" style="vertical-align:middle;text-align:center;width:20%" width="'.$widthSasKeg.'">Sasaran Kegiatan</th>';	
		}
		
		
		$head .= '<thead><tr>'.$headKL.$headSastra.$headE1.$headE2.'</tr></thead><tbody>';	
					 
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
				
			//	var_dump($data);die;
			$noKL=1;$noSastra=1;$noE1=1;$noE2=1;
			foreach ($data as $d){
				$rs .= 	'<tr class="gradeX">';	
				if ($headKL!=""){ //tampilkan kolom sasaran KL
					if (isset($d->rowspan_skl)){
						$rs .= '<td width="30" '.($d->rowspan_skl>0?'rowspan="'.$d->rowspan_skl.'"':'').'>'.($noKL++).'</td>';
						$rs .= '<td width="'.$widthKl.'" '.($d->rowspan_skl>0?'rowspan="'.$d->rowspan_skl.'"':'').'>'.$d->sasaran_kl.'</td>';
						$noSastra=1;
					}
				}
				if ($headSastra!=""){ //tampilkan kolom sasaran strategis
					if (isset($d->rowspan_sastra)){
						$rs .= '<td width="30" '.($d->rowspan_sastra>0?'rowspan="'.$d->rowspan_sastra.'"':'').'>'.($noSastra++).'</td>';
						$rs .= '<td width="'.$widthSastra.'" '.($d->rowspan_sastra>0?'rowspan="'.$d->rowspan_sastra.'"':'').'>'.$d->sasaran_strategis.'</td>';
						$noE1=1;
					}
				}
				if ($headE1!=""){ //tampilkan kolom sasaran program
					if (isset($d->rowspan_program)){
						$nomorTampil = $noE1++;
						if (isset($d->rowspan_sastra)){
							if ($d->rowspan_sastra==$d->rowspan_program)
								$nomorTampil ='';
						}
						
						$rs .= '<td width="30" '.($d->rowspan_program>0?'rowspan="'.$d->rowspan_program.'"':'').'>'.($nomorTampil++).'</td>';
						$rs .= '<td width="'.$widthSasProg.'" '.($d->rowspan_program>0?'rowspan="'.$d->rowspan_program.'"':'').'>'.$d->sasaran_program.'</td>';
						$noE2=1;
					}
				}
				if ($headE2!=""){ //tampilkan kolom sasaran kegiatan
					$nomorTampil = $noE2++;
					if (isset($d->rowspan_program)){
						if ($d->rowspan_program<=1)
							$nomorTampil ='';
					}
					$rs .= '<td width="30" >'.($nomorTampil).'</td>';
					$rs .= '<td width="'.$widthSasKeg.'" >'.$d->sasaran_kegiatan.'</td>';
				}
				
				$rs .= '</tr>';
				
			}//end foreach
			
		}//end isset data
		
					 
		$foot = '</tbody></table>';			 
		
		$rs .= $foot;
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function print_pdf($periode,$tahun,$chkKL,$chkE1,$chkE2,$e1,$e2)
   {
	    $this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Cascading Sasaran Strategis');
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
		 $pdf->Write(0, 'CASCADING SASARAN STRATEGIS ', '', 0, 'L', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		 $pdf->Write(0, 'Tahun '.$tahun, '', 0, 'L', true, 0, false, false, 0);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		
	
	//   $data['showKl']		= $showKl;
	 //  $data['showE1']		= $showE1;
	  // $data['showE2']		= $showE2;
//	   $data['kementerian'] = $this->mgeneral->getValue("nama_kl",array('kode_kl'=>$kl,'tahun_renstra'=>$tahun),"anev_kl");
	  // $data['ikuKl']	= $this->getindikator_kl($indikator,$tahun,$tahun,"",false);
												//$kel_indikator,$tahun_awal,$tahun_akhir,$kode_e1,$kode_e2=null,$ajaxCall
												//var_dump(($showE1=="true")&&($showE2=="true"));die;
	   //$data['ikuE1']	= $this->getindikator_e1($indikator,$tahun,$tahun,$e1,(($showE1=="true")&&($showE2=="true")?$e2:null),false);
	   //if ($showE2=="true")
		//	$data['ikuE2']	= $this->getindikator_e2($indikator,$tahun,$tahun,$e1,$e2,false,false);
	   $data['relevansi'] = $this->get_sasaran($periode,$tahun,$chkKL,$chkE1,$chkE2,$e1,$e2,false);
		$html = $this->load->view('laporan/print/pdf_relevansi_sastra',$data,true);
	//	$html = $data['ikuE2'];
	
	//	$html = '<table  border="1" cellpadding="4" cellspacing="0"><thead><tr><td width="30">tes</td></tr></table>';
	$html1= ' <table border="0" cellpadding="4" cellspacing="0">    
        <tr style="border:1px #666666 solid;">
            <td style="padding:10px 0 20px 20px;">
            	<table cellspacing="0" cellpadding="4" border="1"><thead><tr><th width="30" style="vertical-align:middle;text-align:center;width:0.001%" class="col-sm-1">No.</th><th width="100" style="vertical-align:middle;text-align:center;width:20%" class="col-sm-1">Sasaran Kemenhub</th><th width="30" style="vertical-align:middle;text-align:center;width:0.001%" class="col-sm-1">No.</th><th width="100" style="vertical-align:middle;text-align:center;width:20%" class="col-sm-1">Sasaran Strategis</th></tr></thead><tbody><tr class="gradeX"><td width="30" rowspan="4">1</td><td width="100" rowspan="4">Meningkatnya keselamatan, keamanan dan pelayanan sarana dan prasarana transportasi sesuai Standar Pelayanan Minimal (SPM)</td><td width="30" rowspan="1">1</td><td width="100" rowspan="1">Meningkatnya keselamatan transportasi</td></tr><tr><td width="30" rowspan="1">2</td><td width="100" rowspan="1">Meningkatnya keamanan transportasi</td></tr><tr><td width="30" rowspan="1">3</td><td width="100" rowspan="1">Meningkatnya pelayanan transportasi</td></tr><tr><td width="30" rowspan="1">4</td><td width="100" rowspan="1">Meningkatnya pemenuhan standar teknis dan standar operasional sarana dan prasarana trasnportasi</td></tr><tr><td width="30" rowspan="1">2</td><td width="100" rowspan="1">Meningkatnya aksesibilitas masyarakat terhadap pelayanan sarana dan prasarana transportasi guna mendorong pengembangan konektivitas antar wilayah</td><td width="30" rowspan="1">1</td><td width="100" rowspan="1">Meningkatnya aksesibiltas masyarakat terhadap pelayanan sarana dan prasarana transportasi guna mendorong konektivitas antar wilayah</td></tr><tr><td width="30" rowspan="2">3</td><td width="100" rowspan="2">Meningkatnya kapasitas sarana dan prasarana transportasi untuk mengurangi backlog dan bottleneck kapasitas infrastruktur transportasi</td><td width="30" rowspan="1">1</td><td width="100" rowspan="1">Meningkatnya manfaat sektor transportasi terhadap pertumbuhan ekonomi</td></tr><tr><td width="30" rowspan="1">2</td><td width="100" rowspan="1">Meningkatnya kapasitas sarana dan prasarana transportasi untuk mengurangi backlog dan bottleneck kapasitas infrastruktur transportasi</td></tr><tr><td width="30" rowspan="1">4</td><td width="100" rowspan="1">Meningkatkan peran Pemda, BUMN, swasta, dan masyarakat dalam penyediaan infrastruktur sektor transportasi sebagai upaya meningkatkan efisiensi dalam penyelenggaraan transportasi</td><td width="30" rowspan="1">1</td><td width="100" rowspan="1">Meningkatkan peran serta Pemda, BUMN dan swasta dalam penyediaan infrastruktur transportasi </td></tr><tr><td width="30" rowspan="3">5</td><td width="100" rowspan="3">Peningkatan kualitas SDM dan Melanjutkan Restrukturisasi Kelembagaan dan Reformasi Regulasi</td><td width="30" rowspan="1">1</td><td width="100" rowspan="1">Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN</td></tr><tr><td width="30" rowspan="1">2</td><td width="100" rowspan="1">Peningkatan kualitas SDM</td></tr><tr><td width="30" rowspan="1">3</td><td width="100" rowspan="1">Melanjutkan reformasi regulasi</td></tr><tr><td width="30" rowspan="2">6</td><td width="100" rowspan="2">Peningkatan kualitas penelitian dan pengembangan di bidang transportasi serta teknologi transportasi yang efisiensi, ramah lingkungan sebagai mengantisipasi perubahan iklim</td><td width="30" rowspan="1">1</td><td width="100" rowspan="1">Menurunnya dampak sektor transportasi terhadap lingkungan</td></tr><tr><td width="30" rowspan="1">2</td><td width="100" rowspan="1">Meningkatkan pengembangan teknologi transportasi yang efisien dan ramah lingkungan sebagai antisipasi terhadap perubahan iklim</td></tr></tbody></table> </td>
        </tr>
    </table>
</page>';
		//var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('CascadingSasasranStrategis.pdf', 'I');
   }
}