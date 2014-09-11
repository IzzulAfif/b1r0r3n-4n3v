<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-09-02
 @fungsi	 : 
 @revision	 :
*/
	

class Webservice_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['id'])) $where .= " and id='".$params['id']."'";
		}
		$sql = "select * from anev_webservice ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_list() {
		$where = ' where 1=1 ';
		if (isset($params)){
			//if (isset($params['kode_e1'])) $where .= " and kode_e1='".$params['kode_e1']."'";
		}
		$sql = "select distinct tahun_renstra from anev_tahun_renstra ";
		
		
		$result = $this->mgeneral->run_sql($sql);
		
		$list[0] = 'Pilih Tahun Renstra';
		if (isset($result))
			foreach ($result as $i) {
				$list[$i->tahun_renstra] = $i->tahun_renstra;
			}
		return $list;
	}
	
	function save($data){
		$this->mgeneral->save($data,'anev_webservice');
	}
	
	function update($data,$whereData){
		
		$this->mgeneral->update($whereData,$data,'anev_webservice');
	}
	
	function delete($whereData){		
		$this->mgeneral->delete($whereData,'anev_webservice');
	}
	
	
	function get_datatables($params){
		$this->datatables->select('id,tipe_aplikasi,jenis_data,url');
		$this->datatables->from('anev_webservice');
		//$this->datatables->join('anev_tahun_renstra e1', 'e1.kode_e1=e2.kode_e1 and e1.tahun_renstra=e2.tahun_renstra', 'left');
		$this->datatables->add_column('aksi', '$1',"general_modal_action_edit('webservice',id,\"\",'#webservice-modal')");
		$this->datatables->unset_column('id');
		return $this->datatables->generate();
		
	
	}
	

}

