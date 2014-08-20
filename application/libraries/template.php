<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 @author     : Didin
 @date       : 2014-08-09 00:00
 @revision	 :
	YJS 2014-08-18 --> tambah load for new window popupp
	YJS 2014-02-20 --> tambah handle isset function load
*/
class template 
{
	
	function load($setting)
	{
		$ci = & get_instance();
		
		$temp['inc_header']		= $ci->load->view('template/inc_header',$setting['page'],true);
		$temp['header']			= $ci->load->view('template/header',isset($setting['header'])?$setting['header']:'',true);
		$temp['sidebar_left']	= $ci->load->view('template/sidebar_left',$setting['sd_left'],true);
		$temp['sidebar_right']	= $ci->load->view('template/sidebar_right',isset($setting['sd_right'])?$setting['sd_right']:'',true);
		$temp['inc_footer']		= $ci->load->view('template/inc_footer',$setting['page'],true);
		
		return $temp;
	}
	
	function load_popup($setting)
	{
		$ci = & get_instance();
		
		$temp['inc_header']		= $ci->load->view('template/inc_header',$setting['page'],true);		
		$temp['inc_footer']		= $ci->load->view('template/inc_footer',$setting['page'],true);
		
		return $temp;
	}
		
}

?>