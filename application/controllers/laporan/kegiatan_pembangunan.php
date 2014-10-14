<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     : Yusup
 @date       : 2014-09-20 00:00
 @revision	 :
*/

class Kegiatan_pembangunan extends CI_Controller {
	
	function __construct() 
	{	
		parent::__construct();
		$this->load->model('analisis/analisis_model','',TRUE);
		$this->load->model('admin/lokasi_model','lokasi',TRUE);
		$this->load->model('admin/tahun_renstra_model','tahun_renstra',TRUE);
		$this->load->model('pemrograman/kegiatan_eselon2_model','kegiatan',TRUE);
		$this->load->model('laporan/kegiatan_pembangunan_model','pembangunan',TRUE);
		$this->load->model('/unit_kerja/eselon1_model','eselon1');
		$this->load->model('/unit_kerja/eselon2_model','eselon2');
		$this->load->model('/pemrograman/sasaran_strategis_model','sastra');
		$this->load->model('/pemrograman/program_eselon1_model','program');
		$this->load->model('/admin/kel_indikator_model','kel_indikator');
		
	}
	
	function index()
	{
		#settingan untuk static template file
		$setting['sd_left']	= array('cur_menu'	=> "LAPORAN");
		$setting['page']	= array('pg_aktif'	=> "map");
		$template			= $this->template->load($setting); #load static template file
		
		$data['tahun_renstra']				= $this->tahun_renstra->get_list(null);
		$data['eselon1'] = $this->eselon1->get_list(array("check_locking"=>false));
		$data['kelompok_indikator'] = $this->kel_indikator->get_list(null);
		$data['lokasi'] = $this->lokasi->get_list(null);
		$template['konten']	= $this->load->view('laporan/kegiatan_pembangunan_v',$data,true); #load konten template file
		
		#load container for template view
		$this->load->view('template/container',$template);
	}
	function get_list_eselon1()
	{
		$params = array("check_locking"=>false);
		echo json_encode($this->eselon1->get_list($params));
	}
	
	function get_list_eselon2($kode_e1)
	{
		$params = array("kode_e1"=>$kode_e1);
		echo json_encode($this->eselon2->get_list($params));
	}
	
	
	function get_sastra($tahun)
	{		
		$result	= $this->sastra->get_list(array("tahun"=>$tahun));
		echo json_encode($result);
	}
	
	function get_program($tahun)
	{		
		$result	= $this->program->get_list(array("tahun"=>$tahun));
		echo json_encode($result);
	}
	
	function get_kegiatan($tahun,$program)
	{
		$result	= $this->kegiatan->get_list(array("tahun"=>$tahun,"kode_program"=>$program));
		echo json_encode($result);
	}
	
	function get_list_rincian($tahun,$indikator,$kode_program,$kode_kegiatan,$kdlokasi,$ajaxCall=true)
	{
		$params['tahun'] = $tahun;
		$params['indikator'] = $indikator;
		$params['kode_program'] = $kode_program;
		$params['kode_kegiatan'] = $kode_kegiatan;
		$params['kdlokasi'] = $kdlokasi;
		
		$data	= $this->pembangunan->get_detil_belanja($params);
		if ($ajaxCall)
				$head = '<table class="display table table-bordered table-striped" width="100%">';
			else
				$head = '<table  border="1" cellpadding="4" cellspacing="0">';
					
		$head .= '<thead>
                    	<tr>
                    		<th class="col-sm-1" style="vertical-align:middle;text-align:center;" width="30">No.</th>
                            <th class="col-sm-1" style="vertical-align:middle;text-align:center;" width="80">Tahun</th>
                            <th style="vertical-align:middle;text-align:center" width="270">Item Pekerjaan</th>
                            <th class="col-sm-1" style="vertical-align:middle;text-align:center;" width="80">Volume</th>
                            <th class="col-sm-1" style="vertical-align:middle;text-align:center;" width="80">Satuan</th>
                        </tr>
                    </thead>
					 <tbody>';
					 
		$foot =	'</tbody>
    	        </table>';
		$totalPagu = 0;
		$rs = $head;$i=1;
		if (isset($data)){
			//$rs .= $head;
			foreach($data as $d): 
				$totalPagu += $d->jumlah;
				$rs .= '<tr class="gradeX">
					<td width="30">'.($i++).'</td>
					<td width="80">'.$d->tahun.'</td>
					<td width="270">'.$d->nmitem.'</td>
					<td width="80" align="right">'.$this->utility->cekNumericFmt($d->volkeg).'</td>					
					<td width="80">'.$d->satkeg.'</td>'
					//sementara hide dulu coz blm ada data nya
					/*<td align="right">'.$this->utility->cekNumericFmt($d->hargasat).'</td>					
					<td align="right">'.$this->utility->cekNumericFmt($d->jumlah).'</td>					
					
					*/
					.'</tr>';
				endforeach; 
		} else {
			$rs .= '<tr class="gradeX">
					<td colspan="5" width="540">Data tidak ditemukan</td>
					</tr>';
		}
		$rs .= $foot;
		if ($ajaxCall)	echo $rs;
		else return $rs;
	}
	
	function print_pdf($renstra,$tahun,$indikator,$kode_program,$kode_kegiatan,$kdlokasi)
   {
	    $this->load->library('tcpdf_','pdf');
		$pdf = new Tcpdf_('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetTitle('Rincian Kegiatan Pembangunan Menurut Indikator');
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
		 $pdf->Write(0, 'Rincian Kegiatan Pembangunan Menurut Indikator', '', 0, 'L', true, 0, false, false, 0);
		 
		 $pdf->SetFont('helvetica', 'B', 10);
		
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetFont('helvetica', '', 8);

		$data['renstra']		= $renstra;
	   $data['tahun']		= $tahun;
	   $data['indikator']		= $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$indikator),"anev_kel_indikator");
	   $data['program']		= $this->mgeneral->getValue("nama_program",array('kode_program'=>$kode_program,'tahun'=>$tahun),"anev_program_eselon1");
	   $data['kegiatan']		= $this->mgeneral->getValue("nama_kegiatan",array('kode_kegiatan'=>$kode_kegiatan,'tahun'=>$tahun),"anev_kegiatan_eselon2");
	   $data['lokasi']		= $this->mgeneral->getValue("lokasi",array('kdlokasi'=>$kdlokasi),"anev_lokasi");
	   //$data['indikator']		= $this->mgeneral->getValue("deskripsi",array('kode_ss_kl'=>$indikator,'tahun_renstra'=>$indikator),"anev_kel_indikator");
	   
	   $data['itempekerjaan'] = $this->get_list_rincian($tahun,$indikator,$kode_program,$kode_kegiatan,$kdlokasi,false);
	   
		$html = $this->load->view('laporan/print/pdf_pembangunan',$data,true);
	//	$html = $data['ikuE2'];
	//	var_dump($html);
		$pdf->writeHTML($html, true, false, false, false, '');
		//var_dump('tes');	
	
		$pdf->SetFont('helvetica', 'B', 10);	
		$pdf->Output('RincianKegiatanPembangunan.pdf', 'I');
   }
	
	function map()
	{
		$data = null;
		$this->load->view('analisis/map_kegiatan',$data);
	}
}