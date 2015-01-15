<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('kontak_action'))
{
	function e2_action($diklat_id)
	{	
		$CI = & get_instance();
		$format = '<a href="'.base_url().'unit_kerja/eselon2/edit/'.$diklat_id.'" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
				  <a href="'.base_url().'unit_kerja/eselon2/hapus/'.$diklat_id.'" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>';
		return $format;
	}
	
	
	function general_modal_action($event,$id1,$id2="",$href=""){	
		//$event javascript
		if ($href==="") $href = "#fmodal";
		$CI = & get_instance();
		$format = '<a href="'.$href.'"  data-toggle="modal" onclick="'.$event.'_edit(\''.$id1."'".($id2!=""?',\''.$id2.'\'':"").')" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
				  <a href="'.$href.'"  data-toggle="modal" onclick="'.$event.'_delete(\''.$id1."'".($id2!=""?',\''.$id2.'\'':"").')"class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-times"></i></a>';
		return $format;
	}
	
	function general_modal_action_edit($event,$id1,$id2="",$href=""){	
		//$event javascript
		// edit only
		if ($href==="") $href = "#fmodal";
		$CI = & get_instance();
		$format = '<a href="'.$href.'"  data-toggle="modal" onclick="'.$event.'_edit(\''.$id1."'".($id2!=""?',\''.$id2.'\'':"").')" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>';
		return $format;
	}
}

?>