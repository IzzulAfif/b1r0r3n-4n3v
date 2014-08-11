<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('quote_data'))
{
    function quote_data($id,$level,$no)
    {
		if($no==""): $no="0"; endif;
		$ci = & get_instance();
		if($level=="2"):
			
			$data = '<div id="quoteData'.$no.''.$id.'" title="Klik untuk melihat qoute"><blockquote><a href="#" onClick="quoteData('.$id.','.$no.');"><i class="fa fa-quote-left"></i> quote</a> ...</blockquote></div>';
			
		else:
		
			$quote_data = $ci->mgeneral->getWhere(array('id_post'=>$id),"t_post");
			$data = '<blockquote>';
				if($quote_data[0]->id_quote!="" || $quote_data[0]->id_quote!=0):
					$data .= quote_data($quote_data[0]->id_quote,"2",$no);
				endif;
						$data .='<span class="original">diposting oleh - '.$ci->mgeneral->getValue("nama_lengkap",array('id_user'=>$quote_data[0]->id_user),"t_user").' - pada '.tgl_nama($quote_data[0]->date).' :</span>
						<i class="fa fa-quote-left"></i> '.$quote_data[0]->nama_post.'
					</blockquote>';
		
		endif;
		
		return $data;
	}
}

if( ! function_exists('color_level'))
{
    function color_level($level)
    {
		switch($level):
			case "1"; $level="yellow"; break;
			case "2"; $level="blue"; break;
			case "3"; $level="green"; break;
			case "4"; $level="red"; break;
			case "5"; $level="black"; break;
		endswitch;
		return $level;
	}
}

if( ! function_exists('tgl_nama'))
{
	function tgl_nama($datetime,$tipe)
	{
		$dateF	= explode(" ",$datetime);
		$data	= $dateF[0];
		
		date_default_timezone_set('Asia/Jakarta');
		$day = date('l', strtotime($data));
		
		list($t,$b,$h) = split('[-]', $data);
		switch($b)
		{
			case"01"; $bln="Jan"; break;
			case"02"; $bln="Feb"; break;
			case"03"; $bln="Mar"; break;
			case"04"; $bln="Ap"; break;
			case"05"; $bln="Mei"; break;
			case"06"; $bln="Jun"; break;
			case"07"; $bln="Jul"; break;
			case"08"; $bln="Agu"; break;
			case"09"; $bln="Sep"; break;
			case"10"; $bln="Okt"; break;
			case"11"; $bln="Nov"; break;
			case"12"; $bln="Des"; break;
		}
		
		if($tipe=="sort"):
			$tglIndo="$h $bln @".substr($dateF[1],0,5);
		else:	
			$tglIndo="$h $bln ".substr($t,-2)." @ ".substr($dateF[1],0,5);
		endif;
		return $tglIndo;
	}
}

if( ! function_exists('relative_time'))
{
    function relative_time($datetime)
    {
		$datetimeAsli = $datetime;
		date_default_timezone_set('Asia/Jakarta');
        if(!$datetime)
        {
            return "no data";
        }

        if(!is_numeric($datetime))
        {
            $val = explode(" ",$datetime);
            $date = explode("-",$val[0]);
            $time = explode(":",$val[1]);
            $datetime = mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
        }

        $difference = time() - $datetime;
        $periods = array("detik", "menit", "jam", "hari", "minggu", "bulan", "tahun", "dekade");
        $lengths = array("60","60","24","7","4.35","12","10");

        if ($difference > 0)
        {
            $ending = '';#ago
        }
        else
        {
            $difference = -$difference;
            $ending = '';#to go
        }
        for($j = 0; $difference >= $lengths[$j]; $j++)
        {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);

        if($difference != 1)
        {
            $period = strtolower($periods[$j].'');
        } else {
            $period = strtolower($periods[$j]);
        }
		
		if($period=="detik" || $period=="menit" || $period=="jam" ||  $period=="hari"):
	        return "$difference $period $ending";
    	else:
			return tgl_nama($datetimeAsli,"sort");
		endif;
	}


}