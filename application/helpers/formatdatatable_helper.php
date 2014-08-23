<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('kontak_action'))
{
	function e2_action($id)
	{	
		$CI = & get_instance();
		$format = '<a href="'.base_url().'unit_kerja/eselon2/edit/'.$id.'" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
				  <a href="'.base_url().'unit_kerja/eselon2/hapus/'.$id.'" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>';
		return $format;
	}
}

?>