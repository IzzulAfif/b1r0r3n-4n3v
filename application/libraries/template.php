<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class template 
{
	
	function load($setting)
	{
		$ci = & get_instance();
		
		$temp['inc_header']		= $ci->load->view('template/inc_header',$setting['inc_header'],true);
		$temp['header']			= $ci->load->view('template/header',$setting['header'],true);
		$temp['sidebar_left']	= $ci->load->view('template/sidebar_left',$setting['sidebar_left'],true);
		$temp['sidebar_right']	= $ci->load->view('template/sidebar_right',$setting['sidebar_right'],true);
		$temp['inc_footer']		= $ci->load->view('template/inc_footer',$setting['inc_footer'],true);
		
		return $temp;
	}
		
}

?>