<?php
class Pdf
{
	function cetak($html,$filename)
	{
		$ci = & get_instance();
		$ci->load->library('html2pdf/html2pdf');
		
	   	$html2pdf = new HTML2PDF('P','A4','en',true,'UTF-8',array(0, 0, 0, 0)); 
	   	$ci->html2pdf->WriteHTML($html);
   	   	
		return $ci->html2pdf->Output($filename);
	   
	}
}
?>
