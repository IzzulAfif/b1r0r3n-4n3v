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
	
	
	function general_modal_action($event,$id1,$id2=""){	
		//$event javascript
		$CI = & get_instance();
		$format = '<a href="#fModal"  data-toggle="modal" onclick="'.$event.'_edit(\''.$id1."'".($id2!=""?',\''.$id2.'\'':"").')" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
				  <a href="#fModal"  data-toggle="modal" onclick="'.$event.'_delete(\''.$id1."'".($id2!=""?',\''.$id2.'\'':"").')"class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>';
		return $format;
	}
}

?>