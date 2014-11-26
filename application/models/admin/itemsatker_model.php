<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 @author     :  Yusup JS
 @date       : 2014-08-31
 @fungsi	 : 
 @revision	 :
*/
	

class Itemsatker_model extends CI_Model
{ 
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all($params){
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and e2.kode_e1='".$params['kode_e1']."'";
			if (isset($params['kode_e2'])) $where .= " and e2.kode_e2='".$params['kode_e2']."'";
			if (isset($params['tahun_renstra'])) $where .= " and e1.tahun_renstra='".$params['tahun_renstra']."'";
		}
		$sql = "select e2.*, e1.nama_e1 from anev_eselon2 e2 inner join anev_eselon1 e1 on e1.kode_e1=e2.kode_e1 and e1.tahun_renstra=e2.tahun_renstra ".$where;
		return $this->mgeneral->run_sql($sql);
	}
	
	function get_list($params) {
		$where = ' where 1=1 ';
		if (isset($params)){
			if (isset($params['kode_e1'])) $where .= " and kode_e1='".$params['kode_e1']."'";
		}
		$sql = "select distinct kode_e2, nama_e2 from anev_eselon2 ".$where;
		
		
		$result = $this->mgeneral->run_sql($sql);
		
		$list[0] = 'Pilih Unit Kerja Eselon II';
		if (isset($result))
			foreach ($result as $i) {
				$list[$i->kode_e2] = $i->nama_e2;
			}
		return $list;
	}
	
	
	function get_datatables($params){
		if (isset($params)){
			if ((isset($params['kode_e1']))&&($params['kode_e1']!="0"))$this->datatables->where("s.kode_e1",$params['kode_e1']);
			if ((isset($params['tahun_renstra']))&&($params['tahun_renstra']!="0"))$this->datatables->where("s.tahun between left('".$params['tahun_renstra']."',4) and right('".$params['tahun_renstra']."',4) ");
			
		}
		
		$this->datatables->select('tahun, kode_satker, kode_e1, kode_program, kode_kegiatan, kdlokasi, kdkabkota, noitem, nmitem, volkeg, satkeg ');
		$this->datatables->from('anev_item_satker s');
		//$this->datatables->join('anev_eselon1 e1', 'e1.kode_e1=s.kode_e1 an, 'left');
	
		return $this->datatables->generate();
		
	
	}
	
	function get_datatables_old($params){
		$sql = 'select 0 as row_number,s.tahun_renstra, s.kode_satker, s.nama_satker, s.lokasi_satker, s.kode_e1 from  anev_satker s left join anev_eselon1 e1 on e1.kode_e1=s.kode_e1 and e1.tahun_renstra=s.tahun_renstra';
		//$this->datatables->add_column('aksi', '$1','e2_action(e2.kode_e2)');
		//return $this->datatables->generate();
	//	$data = $this->mgeneral->run_sql($sql);
	
		//if (isset($_GET['start'])) $start = sanitizeString($_GET['start']);
		//if (isset($_GET['length'])) $length = sanitizeString($_GET['length']);
		//if (isset($_GET['draw'])) $draw = sanitizeString($_GET['draw']);
		$start = isset($_POST['iDisplayStart'])?$_POST['iDisplayStart']:1;
		$length = isset($_POST['iDisplayLength'])?$_POST['iDisplayLength']:10;
		$draw = isset($_POST['sEcho'])?$_POST['sEcho']:1;
		$aOrder =isset($_POST['order'])?$_POST['order']:array();
		 $aCols =isset($_POST['columns'])? $_POST['columns']:1;
		$search =isset($_POST['search'])? $_POST['search']:"";
	//	var_dump($draw);
		$sOrder = "";
		if ( isset( $aOrder ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<count($aOrder) ; $i++ )
			{
				if ( $aCols[intval($aOrder[$i]['column'])]['orderable'] == "true" )
				{
					$sOrder .= $aCols[intval($aOrder[$i]['column'])]['data']." ".($aOrder[$i]['dir']=='asc' ? 'ASC' : 'DESC') .", ";
				}
			}
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}

		/** Paging **/
		$sLimit = "";
		if ( isset( $_GET['start'] ) && $_GET['length'] != '-1' )
		{
			$sLimit = " LIMIT ".intval( $_GET['start'] ).", ". intval( $_GET['length'] );
		}
		 
		/** Filtering **/   
		$sWhere = "";
//		if ( isset($search) && $search['value']!=="" )
		if ( isset($search) && $search!=="" )
		{      
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aCols) ; $i++ )
			{
				if ( isset($aCols[intval($aOrder[$i]['column'])]) && $aCols[intval($aOrder[$i]['column'])]['searchable'] == "true" )
				{
					$sWhere .= $aCols[intval($aOrder[$i]['column'])]['data']." LIKE '%".mysql_real_escape_string( $search )."%' OR ";
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 
		 
		
		$recordsTotal = $this->get_record_count($params);
		 
		
		$this->db->select("0 as row_number,s.tahun_renstra, s.kode_satker, s.nama_satker, s.lokasi_satker, s.kode_e1",false);
		$this->db->from("anev_satker s left join anev_eselon1 e1 on e1.kode_e1=s.kode_e1 and e1.tahun_renstra=s.tahun_renstra",false);
		$this->db->limit($length,$start);
		$data = $this->db->get();
		$Rows = array();
		$recordsFiltered =0;
		foreach ($data->result() as $row){
			$recordsFiltered += 1;
			$Rows[] =$row;
		}
		//var_dump($Rows);
		 
		$returnData = array(
								'draw' =>intval($draw),
								'recordsTotal' => $recordsTotal,
								'recordsFiltered' => $recordsFiltered,
								'data' => $Rows
							 );
		return json_encode($returnData);	
	}
	
	function get_record_count($params){
		$this->db->select("s.tahun_renstra, s.kode_satker, s.nama_satker, s.lokasi_satker, s.kode_e1");
		$this->db->from("anev_satker s left join anev_eselon1 e1 on e1.kode_e1=s.kode_e1 and e1.tahun_renstra=s.tahun_renstra",false);
		
		return $this->db->count_all_results();
	}

}

