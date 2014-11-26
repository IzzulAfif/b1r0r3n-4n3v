<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *INVISI
*/

class login_log_model extends CI_Model
{	
	/**
	* constructor
	*/
	public function __construct()
    {
        parent::__construct();
		//$this->CI =& get_instance();
    }
	
	// purpose : 1=buat grid, 2=buat pdf, 3=buat excel
	public function get_datatables($params=null){
		$page = isset($_GET['iDisplayStart']) ? intval($_GET['iDisplayStart']) : 1;  
		$limit = isset($_GET['iDisplayLength']) ? intval($_GET['iDisplayLength']) : 10;  			
		$sortIdx = isset($_GET['iSortCol_0'])?intval($_GET['iSortCol_0']) :0;
		// switch ($sortIdx){
			// case 1 : $sort = 'tbl_eselon2.nama_e2';
			// default : $sort = 'tbl_eselon2.kode_e2';
		// }
		
		$order = isset($_GET['sSortDir_0']) ? strval($_GET['sSortDir_0']) : 'asc';  
		$count = $this->getrecord_count($params);
		$response = new stdClass();
		$response->total = $count;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'login_time';  
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
		
		
		if ($count>0){
			// if($fileawal != '' && $fileawal != '-1' && $fileawal != null) {
				// $this->db->where("date(login_time) between '$fileawal' and '$fileakhir'");
			// } 
			// if($file1 != '' && $file1 != '-1' && $file1 != null) {
				// $this->db->like("user_info",$file1);
			// } 
			
			// if($file2 != '' && $file2 != '-1' && $file2 != null) {
				// $this->db->like("user_info",$file2);
			// }  
			//$this->db->order_by($sort." ".$order );
			$this->db->limit($limit,$page);
			$this->db->select("l.*",false);
			$this->db->from('anev_login_log l');			
			$this->db->order_by("l.login_time desc");
			$query = $this->db->get();
			
			$i=0;
			 $no =0;//$lastNo;
			foreach ($query->result() as $row)
			{
				$no++;
				$response->rows[$i]['no']= $no;
				$response->rows[$i]['login_time']=strftime("%d-%m-%Y %H:%M:%S",strtotime($row->login_time));
				$response->rows[$i]['ip']=$row->ip;
				$response->rows[$i]['user_info']=$row->user_info;
				
				
				$xlog = explode(';', $row->user_info);
				$response->rows[$i]['log_id_user']=str_replace("id=","",$xlog[0]);
				$response->rows[$i]['log_user_name']=str_replace("name=","",$xlog[1]);
				$response->rows[$i]['log_e1']=str_replace("e1=","",$xlog[2]);
				$response->rows[$i]['log_e2']=str_replace("e2=","",$xlog[3]);
				
				$response->rows[$i]['log_e1'] = ($response->rows[$i]['log_e1']=='-1'?'-':$response->rows[$i]['log_e1']);
				$response->rows[$i]['log_e2'] = ($response->rows[$i]['log_e2']=='-1'?'-':$response->rows[$i]['log_e2']);
			
				$i++;
			} 
			
		//	$response->lastNo = $no;
			// $query->free_result();
		}else {
				$response->rows[$count]['no']= '';
				$response->rows[$count]['log_id_user']='';
				$response->rows[$count]['log_user_name']='';
				$response->rows[$count]['log_e1']='';
				$response->rows[$count]['log_e2']='';
				$response->rows[$count]['login_time']='';
				$response->rows[$count]['user_info']='';
				$response->rows[$count]['ip']='';
		}
		
		return $response;
	
	}
	
	public function getrecord_count($params=null){		
		// if($fileawal != '' && $fileawal != '-1' && $fileawal != null) {
				// $this->db->where("date(login_time) between '$fileawal' and '$fileakhir'");
			// } 
			// if($file1 != '' && $file1 != '-1' && $file1 != null) {
				// $this->db->like("user_info",$file1);
			// } 
			
			// if($file2 != '' && $file2 != '-1' && $file2 != null) {
				// $this->db->like("user_info",$file2);
			// } 
		$query=$this->db->from('anev_login_log');
		return $this->db->count_all_results();
		$this->db->free_result();
	}
	
	public function insertLoginLog($data){
	
		$data['ip'] = $this->input->ip_address();
		$this->db->set('login_time',date('Y-m-d H:i:s'));
		$this->db->set('ip',$data['ip']);
		$this->db->set('user_info','id='.$data['user_id'].';name='.$data['user_name'].';e1='.$data['unit_kerja_e1'].';e2='.$data['unit_kerja_e2']);
			
		$result = $this->db->insert('anev_login_log');
		$errNo   = $this->db->_error_number();
	    $errMess = $this->db->_error_message();
		$error = $errMess;
		//var_dump($errMess);die;
	    log_message("error", "Problem Inserting to : ".$errMess." (".$errNo.")"); 
		//return
		if($result) {
			return TRUE;
		}else {
			return FALSE;
		}
	}	
	
}
?>
