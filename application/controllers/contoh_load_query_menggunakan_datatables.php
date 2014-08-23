<?php

class load extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->db	= $this->load->database('live', TRUE); #Untuk connect ke DB Live
        $this->load->library("ex_template");
        $this->load->model("mtemplate", "", true);
        $this->load->library('datatables');
        $this->lang->load('aero', $this->session->userdata['language']);
        $this->load->helper('formatdatatable');
    }

    function page($file) {
        $data['template'] = $this->ex_template->load($file);
        $this->load->view("page_exam/" . $file, $data);
    }

    function ppob_favorit() {
        $this->datatables->select('a.ppob_favorit_id,a.ppob_kategori,a.ppob_group, a.ppob_produk_nama, a.ppob_pelanggan, a.ppob_nama_pelanggan');
        $this->datatables->from('ppob_favorit a');
        $this->datatables->where('a.agent_id = \'' . $this->session->userdata['id'] . '\'', NULL, FALSE);
        $this->datatables->add_column('aksi', '<a title="Edit" href="' . base_url() . 'ppob/edit_ppob_favorit/$1' . '"><i class="splashy-document_letter_edit"></i></a><a title="Hapus" href="#" onclick="del(\'$1\')"><i class="splashy-document_letter_remove"></i></a>', 'encode(a.ppob_favorit_id)');
        $this->datatables->unset_column('a.ppob_favorit_id');
        echo $this->datatables->generate();
        exit;
    }

    function service_log() {
        $this->datatables->set_database("service", TRUE);
        $this->datatables->select('log_id,a.date, b.b2b_nama, a.app, a.action, a.IP');
        $this->datatables->from('access_log a');
        $this->datatables->join('b2b b', 'b.b2b_kode_akses = a.access_code', 'left');
        if ($this->session->userdata['level_id'] == '1'):
            $this->datatables->where('b.b2b_agent_id = "' . $this->session->userdata['id'] . '"');
        endif;
        $this->datatables->add_column('aksi', '<button data-toggle="dropdown" class="btn btn-warning btn-small" onclick="detail_log(\'$1\');">Detail</button>', 'encode(log_id)');
        $this->datatables->unset_column('log_id');
        echo $this->datatables->generate();
        exit;
    }

    function b2b_service_log() {

        $this->datatables->set_database("service", TRUE);
        $this->datatables->select('log_id,a.date, b.b2b_nama, a.IP, a.app, a.action');
        $this->datatables->from('access_log a');
        $this->datatables->join('b2b b', 'b.b2b_kode_akses = a.access_code', 'left');
        $this->datatables->where('b.b2b_id = \'' . $this->session->userdata['b2b_id'] . '\'', NULL, FALSE);
        $this->datatables->add_column('aksi', '<button data-toggle="dropdown" class="btn btn-warning btn-small" onclick="detail_log(\'$1\');">Detail</button>', 'encode(log_id)');
        $this->datatables->unset_column('log_id');
        echo $this->datatables->generate();
        exit;
    }

    function agent_deposit() {

        // $this->datatables->select('a.transfer_savedate,a.transfer_amount,b.agent_username,c.account_holder,c.account_number,c.bank_name,d.b2b_account_name,d.b2b_account_number,d.b3b_bank_name');
        $this->datatables->select('a.transfer_id,a.transfer_savedate,b.agent_username,a.transfer_amount,c.account_holder,c.bank_name,c.account_number,d.b2b_account_name,d.b2b_bank_name,d.b2b_account_number,a.transfer_date,a.transfer_approval,a.transfer_status,b.agent_id');
        $this->datatables->edit_column('c.account_holder', '$1 ($2/ $3)', 'c.account_holder, c.bank_name, c.account_number');
        $this->datatables->edit_column('d.b2b_account_name', '$1 ($2 /$3)', 'd.b2b_account_name, d.b2b_bank_name, d.b2b_account_number');
        $this->datatables->edit_column('b.agent_username', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent" onclick="detail_agent($2);">$1</a>', 'b.agent_username, b.agent_id');
        $this->datatables->from('transfer a');
        $this->datatables->join('agent b', 'a.agent_id = b.agent_id', 'INNER');
        $this->datatables->join('agent_bank_account c', 'a.agent_bank_account_id = c.agent_bank_account_id', 'INNER');
        $this->datatables->join('b2b_bank_account d', 'a.b2b_bank_account_id = d.b2b_bank_account_id', 'INNER');
        //$this->datatables->where('( b.user_level_id != 2 AND b.user_level_id != 3)',NULL,FALSE);

        $this->datatables->edit_column('a.transfer_status', '$1', 'format_agent_deposit_status(a.transfer_id, a.transfer_status)');
        $this->datatables->edit_column('a.transfer_amount', '$1', 'format_number(a.transfer_amount)');
        $this->datatables->edit_column('a.transfer_approval', '$1', 'format_aprroval(a.transfer_approval)');

        $this->datatables->unset_column('a.transfer_id');
        $this->datatables->unset_column('c.bank_name');
        $this->datatables->unset_column('c.account_number');
        $this->datatables->unset_column('d.b2b_bank_name');
        $this->datatables->unset_column('d.b2b_account_number');
        $this->datatables->unset_column('b.agent_id');
        echo $this->datatables->generate();
        exit;
    }

    function check_approve_manual($status) {
        if ($status == 'approve_manual') {
            return 'approve';
        }
    }

    function issue_train() {
        $id = $this->session->userdata['id'];

        $cabang_agency = $this->session->userdata['cabang_agency'];

        $this->datatables->set_database("default", TRUE);
        $this->datatables
                ->select("train_data.train_data_id, 
					  train_data.train_data_date, 
					  train_data.train_data_from,
					  train_data.train_data_to,
					  train_data.train_data_departure_bookcode,
					  train_data.train_data_return_bookcode,
					  train_data.train_data_jenis_asuransi")
                ->edit_column('train_data.train_data_departure_bookcode', '$1', 'format_train_book_code(train_data.train_data_departure_bookcode, train_data.train_data_return_bookcode,train_data.train_data_jenis_asuransi)')
                ->select("train_data.train_data_type,
					  train_data.train_data_adult,
					  train_data.train_data_child,
					  train_data.train_data_infant,
					  train_data.train_data_status,
					  agent.agent_id,
					  agent.agent_username")
                ->from('train_data')
                ->join('agent', 'train_data.agent_id = agent.agent_id', 'INNER');

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->add_column('agentusername', '$1', 'agent.agent_username');
        }
        if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
            $this->datatables->add_column('agentusername', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent2" onclick="detail_agent2($2);">$1</a>', 'agent.agent_username, agent.agent_id');
        }
        $this->datatables->add_column('status', '<div class="$1">$1</div>', 'train_data.train_data_status');
        $this->datatables->add_column('action', '$1', 'format_action_issue_train(train_data.train_data_id)');
        
        if ($this->session->userdata['level_id'] == "5") {
            $this->datatables->where('( agent.user_level_id IN (\'7\',\'6\') )', NULL, FALSE);
            $this->datatables->where('agent.cabang_agency', $cabang_agency);
        }

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->where('agent.corporate_agency = ' . $this->session->userdata['corporate_agency'] . ' and train_data.train_data_status = \'issue\' AND train_data.train_data_transaction = \'kai\'', NULL, FALSE);
        } else {
            if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
                $this->datatables->where('train_data.train_data_status = \'issue\' AND train_data.train_data_transaction = \'kai\'', NULL, FALSE);
            } else {
                $this->datatables->where('train_data.agent_id = ' . $id . ' and train_data.train_data_status = \'issue\' AND train_data.train_data_transaction = \'kai\'', NULL, FALSE);
            }
        }

        $this->datatables->unset_column('train_data.train_data_id');
        $this->datatables->unset_column('train_data.train_data_return_bookcode');
        $this->datatables->unset_column('train_data.train_data_status');
        $this->datatables->unset_column('agent.agent_id');
        $this->datatables->unset_column('agent.agent_username');
        $this->datatables->unset_column('train_data.train_data_jenis_asuransi');
        echo $this->datatables->generate();
        exit;
    }

    function issue_railink() {
        $id = $this->session->userdata['id'];
        
        $cabang_agency = $this->session->userdata['cabang_agency'];

        $this->datatables->set_database("default", TRUE);
        $this->datatables
                ->select("train_data.train_data_id, 
					  train_data.train_data_date, 
					  train_data.train_data_from,
					  train_data.train_data_to,
					  train_data.train_data_departure_bookcode,
					  train_data.train_data_return_bookcode,
					  train_data.train_data_jenis_asuransi")
                ->edit_column('train_data.train_data_departure_bookcode', '$1', 'format_train_book_code(train_data.train_data_departure_bookcode, train_data.train_data_return_bookcode,train_data.train_data_jenis_asuransi)')
                ->select("train_data.train_data_type,
					  train_data.train_data_adult,
					  train_data.train_data_child,
					  train_data.train_data_infant,
					  train_data.train_data_status,
					  agent.agent_id,
					  agent.agent_username")
                ->from('train_data')
                ->join('agent', 'train_data.agent_id = agent.agent_id', 'INNER');

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->add_column('agentusername', '$1', 'agent.agent_username');
        }
        if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
            $this->datatables->add_column('agentusername', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent2" onclick="detail_agent2($2);">$1</a>', 'agent.agent_username, agent.agent_id');
        }
        $this->datatables->add_column('status', '<div class="$1">$1</div>', 'train_data.train_data_status');
        $this->datatables->add_column('action', '$1', 'format_action_issue_railink(train_data.train_data_id)');
        
        if ($this->session->userdata['level_id'] == "5") {
            $this->datatables->where('( agent.user_level_id IN (\'7\',\'6\') )', NULL, FALSE);
            $this->datatables->where('agent.cabang_agency', $cabang_agency);
        }

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->where('agent.corporate_agency = ' . $this->session->userdata['corporate_agency'] . ' and train_data.train_data_status = \'issue\' AND train_data.train_data_transaction = \'railink\'', NULL, FALSE);
        } else {
            if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
                $this->datatables->where('train_data.train_data_status = \'issue\' AND train_data.train_data_transaction = \'railink\'', NULL, FALSE);
            } else {
                $this->datatables->where('train_data.agent_id = ' . $id . ' and train_data.train_data_status = \'issue\' AND train_data.train_data_transaction = \'railink\'', NULL, FALSE);
            }
        }
        $this->datatables->unset_column('train_data.train_data_id');
        $this->datatables->unset_column('train_data.train_data_return_bookcode');
        $this->datatables->unset_column('train_data.train_data_status');
        $this->datatables->unset_column('agent.agent_id');
        $this->datatables->unset_column('agent.agent_username');
        $this->datatables->unset_column('train_data.train_data_jenis_asuransi');
        echo $this->datatables->generate();
        exit;
    }

    function book_train() {
        $id = $this->session->userdata['id'];

        $cabang_agency = $this->session->userdata['cabang_agency'];

        $this->datatables->set_database("default", TRUE);
        $this->datatables
                ->select("train_data.train_data_id, 
					  train_data.train_data_date, 
					  train_data.train_data_from,
					  train_data.train_data_to,
					  train_data.train_data_departure_bookcode,
					  train_data.train_data_return_bookcode")
                ->edit_column('train_data.train_data_departure_bookcode', '$1', 'format_train_book_code(train_data.train_data_departure_bookcode, train_data.train_data_return_bookcode)')
                ->select("train_data.train_data_type,
					  train_data.train_data_adult,
					  train_data.train_data_child,
					  train_data.train_data_infant,
					  train_data.train_data_status,
					  agent.agent_id,
					  agent.agent_username")
                ->from('train_data')
                ->join('agent', 'train_data.agent_id = agent.agent_id', 'INNER');

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->add_column('agentusername', '$1', 'agent.agent_username');
        }
        if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
            $this->datatables->add_column('agentusername', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent" onclick="detail_agent($2);">$1</a>', 'agent.agent_username, agent.agent_id');
        }
        $this->datatables->add_column('status', '<div class="$1">$1</div>', 'train_data.train_data_status');
        $this->datatables->add_column('action', '$1', 'format_action_book_train(train_data.train_data_id)');
        
        if ($this->session->userdata['level_id'] == "5") {
            $this->datatables->where('( agent.user_level_id IN (\'7\',\'6\') )', NULL, FALSE);
            $this->datatables->where('agent.cabang_agency', $cabang_agency);
        }

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->where('agent.corporate_agency = ' . $this->session->userdata['corporate_agency'] . ' and train_data.train_data_status = \'issue\' AND train_data.train_data_transaction = \'kai\'', NULL, FALSE);
        } else {
            if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
                $this->datatables->where('train_data.train_data_status IN(\'hold\', \'pending\', \'expire\') AND train_data.train_data_transaction = \'kai\'', NULL, FALSE);
            } else {
                $this->datatables->where('train_data.agent_id = ' . $id . ' and train_data.train_data_status IN (\'hold\', \'pending\') AND train_data.train_data_transaction = \'kai\'', NULL, FALSE);
            }
        }

        $this->datatables->unset_column('train_data.train_data_id');
        $this->datatables->unset_column('train_data.train_data_return_bookcode');
        $this->datatables->unset_column('train_data.train_data_status');
        $this->datatables->unset_column('agent.agent_id');
        $this->datatables->unset_column('agent.agent_username');
        echo $this->datatables->generate();
        exit;
    }

	function railink_report($status)
	{
		$this->datatables->set_database("default", TRUE);
        $this->datatables
                ->select("train_data_id,train_data_date,train_data_type,train_data_from,train_data_to,train_data_departure_bookcode,
						  train_data_return_bookcode,train_data_adult,train_data_child,train_data_infant")
                ->from('train_data');
		
		if($status=="issue"):
			$this->datatables->where('train_data_transaction = \'railink\' AND train_data_status = \'issue\'', NULL, FALSE);
		else:
			$this->datatables->where('train_data_transaction = \'railink\' AND train_data_status != \'issue\'', NULL, FALSE);
		endif;
		
		$this->datatables->unset_column('train_data_id');
        $this->datatables->add_column('action', '$1', 'format_action_book_railink(train_data_id,"report")');
		echo $this->datatables->generate();
        exit;
	}
	
    function book_railink() {
        $id = $this->session->userdata['id'];
        
        $cabang_agency = $this->session->userdata['cabang_agency'];

        $this->datatables->set_database("default", TRUE);
        $this->datatables
                ->select("train_data.train_data_id, 
					  train_data.train_data_date, 
					  train_data.train_data_from,
					  train_data.train_data_to,
					  train_data.train_data_departure_bookcode,
					  train_data.train_data_return_bookcode")
                ->edit_column('train_data.train_data_departure_bookcode', '$1', 'format_train_book_code(train_data.train_data_departure_bookcode, train_data.train_data_return_bookcode)')
                ->select("train_data.train_data_type,
					  train_data.train_data_adult,
					  train_data.train_data_child,
					  train_data.train_data_infant,
					  train_data.train_data_status,
					  agent.agent_id,
					  agent.agent_username")
                ->from('train_data')
                ->join('agent', 'train_data.agent_id = agent.agent_id', 'INNER');



        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->add_column('agentusername', '$1', 'agent.agent_username');
        }
        if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
            $this->datatables->add_column('agentusername', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent" onclick="detail_agent($2);">$1</a>', 'agent.agent_username, agent.agent_id');
        }
        $this->datatables->add_column('status', '<div class="$1">$1</div>', 'train_data.train_data_status');
        $this->datatables->add_column('action', '$1', 'format_action_book_railink(train_data.train_data_id)');
        
        if ($this->session->userdata['level_id'] == "5") {
            $this->datatables->where('( agent.user_level_id IN (\'7\',\'6\') )', NULL, FALSE);
            $this->datatables->where('agent.cabang_agency', $cabang_agency);
        }

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->where('agent.corporate_agency = ' . $this->session->userdata['corporate_agency'] . ' AND train_data.train_data_status = \'issue\' AND train_data.train_data_transaction = \'railink\'', NULL, FALSE);
        } else {
            if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
                $this->datatables->where('train_data.train_data_status IN(\'hold\', \'pending\', \'expire\') AND train_data.train_data_transaction = \'railink\'', NULL, FALSE);
            } else {
                $this->datatables->where('train_data.agent_id = ' . $id . ' and train_data.train_data_status IN( \'hold\', \'pending\') AND train_data.train_data_transaction = \'railink\'', NULL, FALSE);
            }
        }

        $this->datatables->unset_column('train_data.train_data_id');
        $this->datatables->unset_column('train_data.train_data_return_bookcode');
        $this->datatables->unset_column('train_data.train_data_status');
        $this->datatables->unset_column('agent.agent_id');
        $this->datatables->unset_column('agent.agent_username');
        echo $this->datatables->generate();
        exit;
    }

    function get_b2b_customer() {
        $this->datatables->set_database("default", TRUE);
        $this->datatables
                ->select("b2b_user_costumer.id_b2b_user_costumer,
					  b2b_user_costumer.b2b_costumer_joining_date,
					  b2b_user_costumer.costumer_name,
					  b2b_user_costumer.costumer_email,
					  b2b_user_costumer.costumer_phone,
					  b2b_user_costumer.costumer_address,
					  b2b_user_costumer.costumer_gender,
					  b2b_user_costumer.costumer_aktif")
                ->from('b2b_user_costumer');
        $this->datatables->where('b2b_user_costumer.b2b_id = ' . $this->session->userdata['b2b_id'], NULL, FALSE);
        $this->datatables->edit_column('b2b_user_costumer.costumer_aktif', '<div class="$1">$1</div>', 'b2b_user_costumer.costumer_aktif');
        $this->datatables->add_column('action', '$1', 'format_action_customer(b2b_user_costumer.id_b2b_user_costumer, b2b_user_costumer.costumer_aktif)');
        $this->datatables->unset_column('b2b_user_costumer.id_b2b_user_costumer');
        echo $this->datatables->generate();
        exit;
    }

    function detail_agent() {
        $id = $_POST['id'];
        //$id		= $this->mconverter->decode($id);
        $this->db->select('agent_id, agent_username, agent_name, agent_phone, agent_mobilephone, agent_email, agent_registration_date, agent_last_deposit');
        $query = $this->db->get_where('agent', array('agent_id' => $id));
        $data = $query->result_array();

        foreach ($data as $item) {
            foreach ($item as $col => $value) {
                $output[$col] = $value;
            }
        }

        echo json_encode($output);
    }

    function ts_book($status) {
        if ($status == 'ticketed') {
            $date = 'flight_data_issued_date';
        } else {
            $date = 'flight_data_book_date';
        }
        $cabang_agency = $this->session->userdata['cabang_agency'];
        $this->datatables
                ->select("flight_data_id,
				" . $date . ",
				flight_data_rute,
				customer_name,
				b.agent_username,
				depart_airlines_id,
				return_airlines_id,
				flight_data_from,
				flight_data_to,
				depart_book_code,
				return_book_code,
				depart_expired_date,
				return_expired_date,
				flight_data_status,
				app,
				b.agent_id,
				c.airlines_img depart_airlines,
				d.airlines_img return_airlines,
				flight_data_jenis_asuransi")
                ->from("flight_data a")
                ->join('agent b', 'a.agent_id=b.agent_id')
                ->join('airlines c', 'c.airlines_id=a.depart_airlines_id')
                ->join('airlines d', 'd.airlines_id=a.return_airlines_id', 'LEFT');

        if ($this->session->userdata['level_id'] == "5") {
            $this->datatables->where('( b.user_level_id IN (\'7\',\'6\') )', NULL, FALSE);
            $this->datatables->where('b.cabang_agency', $cabang_agency);
        }

        if ($status == 'cancel') {
            $this->datatables->where('( flight_data_status IN (\'cancel\',\'ctl\',\'ctl segment\',\'refund\') )', NULL, FALSE);
        } else {
            $this->datatables->where('flight_data_status', $status);
        }

        $this->datatables->edit_column('b.agent_username', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent" onclick="detail_agent($2);">$1</a>', 'b.agent_username, b.agent_id');
        if ($status == 'ticketed') {
            $this->datatables->edit_column('depart_book_code', '<center><b>$1</b> &nbsp;&nbsp; <b>$2</b>&nbsp;&nbsp; <b>$3</b></center>', 'depart_book_code, return_book_code, notif_asuransi(flight_data_jenis_asuransi)');
        } else {
            $this->datatables->edit_column('depart_book_code', '<center><b>$1</b> &nbsp;&nbsp; <b>$2</b></center>', 'depart_book_code, return_book_code');
        }
        $this->datatables->edit_column('depart_airlines_id', '$1', 'format_maskapai(c.airlines_img depart_airlines, d.airlines_img return_airlines)');
        //$this->datatables->edit_column('depart_expired_date',
        //								'<font color="#FF0000">[</span>$1</span>]</font>',
        //								'depart_expired_date');
        ##$this->datatables->edit_column('flight_data_jenis_asuransi','$1','notif_asuransi(flight_data_jenis_asuransi)');

        $this->datatables->add_column('batas_waktu', '$1', 'format_ts_book_bataswaktu(flight_data_id, depart_expired_date, return_expired_date, flight_data_status)');
        $this->datatables->add_column('status', '$1', 'format_ts_book_status(flight_data_status)');
        $this->datatables->add_column('action', '$1', 'format_action_book_cancel(flight_data_status,flight_data_id,b.agent_id)');
        $this->datatables->add_column('data_countdown', '$1', 'format_data_countdown(depart_expired_date, return_expired_date)');

        $this->datatables->unset_column('flight_data_id');
        $this->datatables->unset_column('return_book_code');
        $this->datatables->unset_column('depart_expired_date');
        $this->datatables->unset_column('return_expired_date');
        $this->datatables->unset_column('flight_data_status');
        $this->datatables->unset_column('return_airlines_id');
        $this->datatables->unset_column('b.agent_id');
        $this->datatables->unset_column('c.airlines_img depart_airlines');
        $this->datatables->unset_column('d.airlines_img return_airlines');
        $this->datatables->unset_column('flight_data_jenis_asuransi');

        echo $this->datatables->generate();
        exit;
    }

    function ts_agent($status) {
        $this->datatables
                ->select("*")
                ->from("agent");

        if (!empty($status)) {
            $this->datatables->where('agent_status', $status);
        }

        echo $this->datatables->generate();
        exit;
    }

    function mutasi_transfer() {
        // $this->datatables
        // ->select('a.bank_mutation_id, b.b2b_account_name, b.b2b_bank_name, b.b2b_account_number, 
        // a.bank_mutation_date, a.bank_mutation_datebank, a.bank_mutation_amount, a.bank_mutation_type, a.bank_mutation_text, a.bank_mutation_status')
        // ->from('bank_mutation a')
        // ->join('b2b_bank_account b','a.b2b_bank_account_id = b.b2b_bank_account_id','INNER');
        // $this->datatables->edit_column('b.b2b_bank_name','$1 / $2','b.b2b_bank_name, b.b2b_account_number');
        // $this->datatables->edit_column('a.bank_mutation_status','$1','format_bank_mutation_status(a.bank_mutation_id, a.bank_mutation_status)');
        // $this->datatables->unset_column('b.b2b_account_number');
        // echo $this->datatables->generate();
        // exit;
        // $this->db->select('(SELECT nilai', FALSE); 
        // $query = $this->db->get('bank_account_statements');
        // print_r($query->result());exit;
        $this->datatables->set_database("aero1", TRUE);
        $this->datatables
                ->select('a.id, b.account_name, b.name, b.account_number, a.timestamp, a.tanggal, a.nilai, a.jenis, a.keterangan, a.status')
                ->from('bank_account_statements a')
                ->join('bank_accounts b', 'a.id_bank = b.id', 'INNER');

        $this->datatables->edit_column('b.name', '$1 / $2', 'b.name, b.account_number');
        $this->datatables->edit_column('a.status', '$1', 'format_bank_mutation_status(a.id, a.status)');
        $this->datatables->unset_column('b.account_number');
        echo $this->datatables->generate();
        exit;
    }

    function direct_debit() {
        $this->datatables
                ->select('a.tanggal, a.orderNo, b.agent_username, b.agent_id, a.kode_bank, a.ccy, a.amount, a.trans_type, a.status')
                ->from('klikpay_data a')
                ->join('agent b', 'a.agent_id = b.agent_id', 'INNER');

        $this->datatables->edit_column('b.agent_id', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent" onclick="detail_agent($2);">$1</a>', 'b.agent_username, b.agent_id');
        $this->datatables->edit_column('a.status', '$1', 'format_direct_debit_status(a.status)');

        $this->datatables->unset_column('b.agent_username');
        echo $this->datatables->generate();
        exit;
    }

    function agent($status) {
        #tambahan kodisi buat cabang (creat by: alaunal kauniyyah)
        
        $cabang_agency = $this->session->userdata['cabang_agency'];
        $id_user_level = "1";
        if ($cabang_agency) {
            $this->datatables
                    ->select('agent_id, agent_registration_date, agent_name, agent_username, agent_email, agent_phone,agent_mobilephone, agent_last_deposit, member_type, agent_actived_by')
                    ->from('agent')
                    ->where('agent_status', $status)
                    ->where('cabang_agency', $cabang_agency);
        } else {
            $this->datatables
                    ->select('agent_id, agent_registration_date, agent_name, agent_username, agent_email, agent_phone,agent_mobilephone, agent_last_deposit, member_type, agent_actived_by')
                    ->from('agent')
                    ->where('agent_status', $status)
                    ->where('user_level_id', $id_user_level);
        }


        if ($status == 'free_trial' || $status == 'expire_trial') {
            $this->datatables->add_column('action', '$1', 'format_action_trial(agent_id)');
        } else {
            $this->datatables->add_column('action', '$1', 'format_action_trial(agent_id)');
            if ($cabang_agency) {
                $this->datatables->edit_column('agent_actived_by', '$1', 'format_aprroval_cabang(agent_actived_by)');
            }else{
                $this->datatables->edit_column('agent_actived_by', '$1', 'format_aprroval(agent_actived_by)');
            }
        }
        echo $this->datatables->generate();
        exit;
    }

    function form_agent() {
        $id = $this->mconverter->decode($_POST['id']);
        $data_agent = $this->mgeneral->getWhere(array('agent_id' => $id), 'agent');
        foreach ($data_agent as $agent) {
            $data['agent']['id'] = $agent->agent_id;
            $data['agent']['name'] = $agent->agent_name;
            $data['agent']['email'] = $agent->agent_email;
            $data['agent']['phone'] = $agent->agent_phone;
            $data['agent']['mphone'] = $agent->agent_mobilephone;
            $data['agent']['pinbb'] = $agent->agent_pinbb;
            $data['agent']['address'] = $agent->agent_address;
            $data['agent']['city'] = $agent->agent_city;
            $data['agent']['provinsi'] = $agent->agent_provinsi;
            $data['agent']['postalcode'] = $agent->agent_postalcode;
            $data['agent']['referal'] = $agent->agent_referal;
            $data['agent']['fax'] = $agent->agent_fax_no;
            $data['agent']['occupation'] = $agent->agent_occupation;
            $data['agent']['workaddress'] = $agent->agent_work_address;
            $data['agent']['gender'] = $agent->agent_gender;
            $data['agent']['membertype'] = $agent->agent_member_type;
            $data['agent']['status'] = $agent->agent_status;
        }

        $form = $this->load->view('staff/agent_form_edit', $data, true);
        $json['form'] = $form;
        echo json_encode($json);
        exit;
    }

    // function acc_agent($status)
    // {	
    // $this->datatables
    // ->select('agent_id, agent_name, agent_username, agent_email, agent_phone, agent_mobilephone, agent_pinbb, agent_last_deposit, agent_status, member_type')
    // ->from('agent')
    // ->where('agent_status',$status);
    // if($status=='free_trial' || $status=='expire_trial')
    // $this->datatables->add_column('action','$1','format_action_trial(agent_id)');
    // else
    // $this->datatables->add_column('action','$1','acc_format_action_agent(agent_id,agent_status)');
    // echo $this->datatables->generate();
    // exit;
    // }
    // /*
    // edited : Hasan Mudras
    // date   : 2013-02-05   	
    // fungsi : mendapatkan form agent untuk edit agent
    // return : JSON
    // */
    // function acc_form_agent()
    // {	
    // $id		= $this->mconverter->decode($_POST['id']);
    // $data_agent	= $this->mgeneral->getWhere(array('agent_id'=>$id),'agent');
    // foreach($data_agent as $agent) {
    // $data['agent']['id']			= $agent->agent_id;
    // $data['agent']['name']			= $agent->agent_name;
    // $data['agent']['email']			= $agent->agent_email;
    // $data['agent']['phone']			= $agent->agent_phone;
    // $data['agent']['mphone']		= $agent->agent_mobilephone;
    // $data['agent']['pinbb']			= $agent->agent_pinbb;
    // $data['agent']['address']		= $agent->agent_address;
    // $data['agent']['city']			= $agent->agent_city;
    // $data['agent']['provinsi']		= $agent->agent_provinsi;
    // $data['agent']['postalcode']	= $agent->agent_postalcode;
    // $data['agent']['referal']		= $agent->agent_referal;
    // $data['agent']['fax']			= $agent->agent_fax_no;
    // $data['agent']['occupation']	= $agent->agent_occupation;
    // $data['agent']['workaddress']	= $agent->agent_work_address;
    // $data['agent']['gender']		= $agent->agent_gender;
    // $data['agent']['membertype']	= $agent->agent_member_type;
    // $data['agent']['status']		= $agent->agent_status;
    // }
    // $form = $this->load->view('staff/acc_agent_form_edit', $data, true);
    // $json['form'] = $form;
    // echo json_encode($json);
    // exit;
    // }
    // /*
    // edited : Hasan Mudras
    // date   : 2013-02-05   	
    // fungsi : mendapatkan form agent untuk edit agent
    // return : JSON
    // */
    // function mutasi_bank($bank){
    // $this->datatables
    // ->select('a.bank_mutation_date,a.bank_mutation_datebank,a.bank_mutation_amount,a.payment_for,b.b2b_account_number,b.b2b_account_name,b.b2b_bank_type')
    // ->from("bank_mutation a")
    // ->join('b2b_bank_account b','a.b2b_bank_account_id=b.b2b_bank_account_id');
    // $this->datatables->where('UPPER(b.b2b_bank_name)',$bank);
    // echo $this->datatables->generate();
    // exit;
    // }

    function acc_agent_deposit() {
        $this->datatables->select('agent_last_deposit, agent_registration_date, agent_name, agent_username, agent_email, agent_mobilephone')
                ->from('agent');
        $this->datatables->edit_column('agent_last_deposit', '$1', 'format_number(agent_last_deposit)');
        echo $this->datatables->generate();
        exit;
    }

    function running_text() {
        $this->datatables
                ->select('running_text_id, running_text_createtime, running_text_message, running_text_startdate, running_text_enddate')
                ->from('running_text');

        $this->datatables->add_column('action', '$1', 'format_action_running_text(running_text_id)');

        $this->datatables->unset_column('running_text_id');
        echo $this->datatables->generate();
        exit;
    }

    function book_hotel() {
        //$id = $this->session->userdata['id'];

        $this->datatables->select("a.id_hotel_data,a.tanggal_booking,a.itinerary_id,a.nama_hotel,a.tipe_kamar,a.jumlah_kamar,a.tanggal_cekin,a.tanggal_cekout,b.agent_username,a.status");
        $this->datatables->edit_column('a.status', '$1', 'format_status_book_hotel(a.status)');
        $this->datatables->from('hotel_data a');
        if ($this->session->userdata['grouplevel_id'] != "4"):
            $this->datatables->where('b.agent_id', $this->session->userdata['id']);
        endif;
        $this->datatables->join('agent b', 'a.agent_id = b.agent_id', 'INNER');
        $this->datatables->add_column('action', '$1', 'format_action_book_hotel(a.id_hotel_data)');
        $this->datatables->unset_column('a.id_hotel_data');

        if ($this->session->userdata['grouplevel_id'] != "4"):
            $this->datatables->unset_column('b.agent_username');
        endif;

        echo $this->datatables->generate();
        exit;
    }

    function order_tour($status) {

        $this->datatables->select("a.pemesanan_tanggal,a.tourpaket_name,a.pemesanan_harga_awal_total,a.pemesan_fullname,a.pemesan_arrival_date,a.tour_order_id,a.status_pemesanan");
        $this->datatables->select("b.agent_username");
        $this->datatables->edit_column('a.status_pemesanan', '$1', 'format_status_tour_status(a.status_pemesanan)');
        $this->datatables->from('tour_order a');
        $this->datatables->join('agent b', 'a.agent_id = b.agent_id', 'INNER');

        if ($status == 'agent' or $status == '') {
            $id = $this->session->userdata['id'];
            $this->datatables->where("a.agent_id = '$id'");
        } else if ($status != 'agent') {
            if ($status == 'tsorder') {
                $this->datatables->where("a.status_pemesanan = '0' or a.status_pemesanan = '5'");
            } else if ($status == 'tsconfirm') {
                $this->datatables->where("a.status_pemesanan = '1'");
            } else {
                $this->datatables->where("a.status_pemesanan = '2' or a.status_pemesanan = '3' or a.status_pemesanan = '4'");
            }
        }

        $this->datatables->add_column('action', '$1', 'format_action_tour_order(a.tour_order_id)');

        $this->datatables->unset_column('a.tour_order_id');

        echo $this->datatables->generate();
        exit;
    }

    function order_tour_travel($status) {

        $travel_id = $this->session->userdata['tour_travel_id'];
        $this->datatables->select("a.pemesanan_tanggal,a.tourpaket_name,a.pemesanan_harga_awal_total,a.pemesanan_currency,a.pemesan_fullname,a.pemesan_arrival_date,a.tour_order_id,a.status_pemesanan");
        $this->datatables->edit_column('a.status_pemesanan', '$1', 'format_status_tour_status(a.status_pemesanan)');
        $this->datatables->edit_column('a.pemesanan_harga_awal_total', '$1', 'format_action_number_tour(a.pemesanan_currency,a.pemesanan_harga_awal_total)');
        $this->datatables->from('tour_order a');
        $this->datatables->join('agent b', 'a.agent_id = b.agent_id', 'INNER');

        if ($status == 'tsorder' or $status == '') {
            $this->datatables->where("a.status_pemesanan = '0' AND tourlist_travel= '$travel_id'");
        } else {
            $this->datatables->where("a.status_pemesanan = '3' AND tourlist_travel= '$travel_id'");
        }

        $this->datatables->add_column('action', '$1', 'format_action_tour_order_travel(a.tour_order_id)');

        $this->datatables->unset_column('a.tour_order_id');
        $this->datatables->unset_column('a.pemesanan_currency');
        echo $this->datatables->generate();
        exit;
    }

    function tour_type($proses) {
        $this->datatables->set_database("service", TRUE);
        $this->datatables->select("a.tourtipe_name,a.tourtipe_id");
        $this->datatables->edit_column('a.tourtipe_id', '$1', 'format_action_master_tour(a.tourtipe_id,' . $proses . ')');
        $this->datatables->from('tour_tipe a');
        echo $this->datatables->generate();
        exit;
    }

    function tour_type_travel($proses) {
        $this->datatables->set_database("service", TRUE);
        $this->datatables->select("a.tourtipe_name,a.tourtipe_id");
        $this->datatables->edit_column('a.tourtipe_id', '$1', 'format_action_master_tour_travel(a.tourtipe_id,' . $proses . ')');
        $this->datatables->from('tour_tipe a');
        echo $this->datatables->generate();
        exit;
    }

    function tour_category_travel($proses) {
        $this->datatables->set_database("service", TRUE);
        $this->datatables->select("a.tourkategori_name,a.tourkategori_id");
        $this->datatables->edit_column('a.tourkategori_id', '$1', 'format_action_master_tour_travel(a.tourkategori_id,' . $proses . ')');
        $this->datatables->from('tour_kategori a');
        echo $this->datatables->generate();
        exit;
    }

    function tour_category($proses) {
        $this->datatables->set_database("service", TRUE);
        $this->datatables->select("a.tourkategori_name,a.tourkategori_id");
        $this->datatables->edit_column('a.tourkategori_id', '$1', 'format_action_master_tour(a.tourkategori_id,' . $proses . ')');
        $this->datatables->from('tour_kategori a');
        echo $this->datatables->generate();
        exit;
    }

    function tour_country($proses) {
        $this->datatables->set_database("service", TRUE);
        $this->datatables->select("a.nama_negara,a.kode_negara");
        $this->datatables->edit_column('a.kode_negara', '$1', 'format_action_master_tour(a.kode_negara,' . $proses . ')');
        $this->datatables->from('tour_negara a');
        echo $this->datatables->generate();
        exit;
    }

    function tour_city($proses) {
        $this->datatables->set_database("service", TRUE);
        $this->datatables->select("b.nama_negara,a.nama_kota,a.kode_kota");
        $this->datatables->edit_column('a.kode_kota', '$1', 'format_action_master_tour(a.kode_kota,' . $proses . ')');
        $this->datatables->from('tour_kota a');
        $this->datatables->join('tour_negara b', 'a.kode_negara = b.kode_negara', 'INNER');

        echo $this->datatables->generate();
        exit;
    }

    function tour_travel_data($proses) {
        $this->datatables->set_database("service", TRUE);
        $this->datatables->select("a.tourtravel_name,a.tourtravel_alamat,a.tourtravel_phone,a.tourtravel_email,a.tourtravel_id");
        $this->datatables->edit_column('a.tourtravel_id', '$1', 'format_action_master_tour(a.tourtravel_id,' . $proses . ')');
        $this->datatables->from('tour_travel a');
        echo $this->datatables->generate();
        exit;
    }

    function tour_travel_laporan($id_agent_tour) {
        $this->datatables->select("a.payment_date,a.payment_amount,a.payment_type,a.payment_message");
        $this->datatables->select("b.tour_agent_deposite_IDR,b.tour_agent_deposite_USD");
        $this->datatables->edit_column('a.payment_amount', '$1', 'format_action_number_laporan_travel(a.payment_message,a.payment_amount)');
        $this->datatables->edit_column('b.tour_agent_deposite_IDR', '$1', 'format_action_number_tour("IDR",b.tour_agent_deposite_IDR)');
        $this->datatables->edit_column('b.tour_agent_deposite_USD', '$1', 'format_action_number_tour("USD",b.tour_agent_deposite_USD)');
        $this->datatables->edit_column('a.payment_message', '$1', 'format_action_message_laporan_travel(a.payment_message)');
        $this->datatables->from('payment_history a');
        $this->datatables->join('tour_agent b', 'a.agent_id = b.tour_agent_code', 'INNER');
        $this->datatables->where("b.tour_agent_code = '$id_agent_tour'");
        echo $this->datatables->generate();
        exit;
    }

    /* function book_hotel()
      {
      //$id = $this->session->userdata['id'];

      $this->datatables->select("a.id_hotel_book_histori,
      a.tanggal_booking,
      a.nama_hotel,
      a.jumlah_kamar,
      a.tipe_kamar,
      a.tanggal_cekin,
      a.jumlah_malam,
      a.margin,
      a.status
      ");
      //		->edit_column('a.status', '$1', 'format_status_book_hotel(a.status)');
      //	->select("b.agent_username");
      $this->datatables->from('hotel_book_histori a');
      //	->join('agent b', 'a.agent_id = b.agent_id', 'INNER');
      //	$this->datatables->add_column('action','$1','format_action_book_hotel(a.id_hotel_book_histori)');

      //	$this->datatables->unset_column('a.id_hotel_book_histori');

      echo $this->datatables->generate();
      exit;
      } */
    /*
      author : Hasan Mudras
      date   : 2013-04-10
      fungsi : mendapatkan transaksi deposit untuk accounting datatable
      return : JSON
     */

    function acc_deposit_adding() {
        // $this->datatables->select('a.transfer_savedate,a.transfer_amount,b.agent_username,c.account_holder,c.account_number,c.bank_name,d.b2b_account_name,d.b2b_account_number,d.b3b_bank_name');
        $this->datatables->select('a.transfer_id,a.transfer_savedate,b.agent_username,a.transfer_amount,c.account_holder,c.bank_name,c.account_number,d.b2b_account_name,d.b2b_bank_name,d.b2b_account_number,a.transfer_date,a.transfer_approval,a.transfer_status,b.agent_id');
        $this->datatables->edit_column('c.account_holder', '$1 ($2/ $3)', 'c.account_holder, c.bank_name, c.account_number');
        $this->datatables->edit_column('d.b2b_account_name', '$1 ($2 /$3)', 'd.b2b_account_name, d.b2b_bank_name, d.b2b_account_number');
        $this->datatables->edit_column('b.agent_username', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent" onclick="detail_agent($2);">$1</a>', 'b.agent_username, b.agent_id');
        $this->datatables->from('transfer a');
        $this->datatables->join('agent b', 'a.agent_id = b.agent_id', 'INNER');
        $this->datatables->join('agent_bank_account c', 'a.agent_bank_account_id = c.agent_bank_account_id', 'INNER');
        $this->datatables->join('b2b_bank_account d', 'a.b2b_bank_account_id = d.b2b_bank_account_id', 'INNER');
        $this->datatables->where('a.transfer_status = "approve" OR a.transfer_status = "approve_manual"', NULL, FALSE);

        $this->datatables->edit_column('a.transfer_status', '$1', 'format_agent_deposit_status(a.transfer_id, a.transfer_status)');
        $this->datatables->edit_column('a.transfer_amount', '$1', 'format_number(a.transfer_amount)');

        $this->datatables->unset_column('a.transfer_id');
        $this->datatables->unset_column('c.bank_name');
        $this->datatables->unset_column('c.account_number');
        $this->datatables->unset_column('d.b2b_bank_name');
        $this->datatables->unset_column('d.b2b_account_number');
        $this->datatables->unset_column('a.transfer_status');
        $this->datatables->unset_column('b.agent_id');
        echo $this->datatables->generate();
        exit;
    }

    function data_ppob() {

        if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
            $this->datatables->select('a.ppob_id,a.ppob_status,a.ppob_date,a.refid,b.agent_id,b.agent_username,a.ppob_produk,a.ppob_produk_detail,a.ppob_kode,a.ppob_pelanggan,a.refpayment,a.deposit_return');
            $this->datatables->from('ppob a');
            $this->datatables->join('agent b', 'a.agent_id = b.agent_id', 'INNER');
            $this->datatables->edit_column('b.agent_username', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent" onclick="detail_agent($2);">$1</a>', 'b.agent_username, b.agent_id');
            $this->datatables->unset_column('b.agent_id');
        } else {
            $id = $this->session->userdata['id'];
            $this->datatables->select('a.ppob_id,a.ppob_status,a.ppob_date,a.refid,a.ppob_produk,a.ppob_produk_detail,a.ppob_kode,a.ppob_pelanggan,a.refpayment');
            $this->datatables->from('ppob a');
            $this->datatables->where("a.agent_id = '$id'");
        }
        $this->datatables->add_column('a.ppob_status', '$1', 'ppob_status(a.ppob_status,a.deposit_return)');
        #$this->datatables->add_column('a.ppob_status', '<div class="$1">$1</div>','a.ppob_status');
        $this->datatables->add_column('aksi', '$1', 'ppob_action(a.ppob_id,a.ppob_status,a.refpayment)');
        $this->datatables->unset_column('a.ppob_id');
        $this->datatables->unset_column('a.ppob_status');
        $this->datatables->unset_column('a.deposit_return');
        $this->datatables->unset_column('a.refpayment');
        echo $this->datatables->generate();
        exit;
    }

    function b2b2c_user() {
        $this->datatables->select('a.b2b_id,a.b2b_joining_date, a.b2b_name,a.b2b_email,a.b2b_phone_number,a.b2b_domain_name,a.b2b_status');
        $this->datatables->from('b2b a');
        $this->datatables->edit_column('a.b2b_status', '<div class="$1"><a data-toggle="modal" data-backdrop="static" href="#id_change_status" onclick="change_status(\'$1\',\'$2\')">$1</a></div>', 'a.b2b_status,encode(a.b2b_id)');
        $this->datatables->unset_column('a.b2b_id');
        echo $this->datatables->generate();
        exit;
    }

    function issue_bus() {

        $id = $this->session->userdata['id'];

        $this->datatables->set_database("default", TRUE);
        $this->datatables
                ->select("bus_data.bus_data_id, 
					  bus_data.bus_data_book_date, 
					  bus_data.bus_data_from,
					  bus_data.bus_data_to,
					  bus_data.bus_data_departure_refnumber,
					  bus_data.bus_data_arrival_refnumber")
                ->edit_column('bus_data.bus_data_departure_refnumber', '$1', 'format_bus_reffnumber(bus_data.bus_data_departure_refnumber, bus_data.bus_data_arrival_refnumber)')
                ->select("bus_data.bus_data_roundtrip,
					  bus_data.bus_data_psgr,
					  bus_data.bus_data_status,
					  agent.agent_id,
					  agent.agent_username")
                ->from('bus_data')
                ->join('agent', 'bus_data.agent_id = agent.agent_id', 'INNER');

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->add_column('agentusername', '$1', 'agent.agent_username');
        }
        if ($this->session->userdata['level_id'] == '8' || $this->session->userdata['level_id'] == '9') {
            $this->datatables->add_column('agentusername', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent2" onclick="detail_agent2($2);">$1</a>', 'agent.agent_username, agent.agent_id');
        }
        $this->datatables->add_column('status', '<div class="$1">$1</div>', 'bus_data.bus_data_status');
        $this->datatables->add_column('action', '$1', 'format_action_issue_bus(bus_data.bus_data_id)');

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->where('agent.corporate_agency = ' . $this->session->userdata['corporate_agency'] . ' and bus_data.bus_data_status = \'issue\'', NULL, FALSE);
        } else {
            if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
                $this->datatables->where('bus_data.bus_data_status = \'issue\'', NULL, FALSE);
            } else {
                $this->datatables->where('bus_data.agent_id = ' . $id . ' and bus_data.bus_data_status = \'issue\'', NULL, FALSE);
            }
        }
        $this->datatables->unset_column('bus_data.bus_data_id');
        $this->datatables->unset_column('bus_data.bus_data_arrival_refnumber');
        $this->datatables->unset_column('bus_data.bus_data_status');
        $this->datatables->unset_column('agent.agent_id');
        $this->datatables->unset_column('agent.agent_username');
        echo $this->datatables->generate();
        exit;
    }

    function issue_shuttle() {
        $id = $this->session->userdata['id'];
        
        $cabang_agency = $this->session->userdata['cabang_agency'];

        $this->datatables->set_database("default", TRUE);
        $this->datatables
                ->select("shuttle_data.shuttle_data_id, 
					  shuttle_data.shuttle_data_book_date, 
					  shuttle_data.shuttle_data_from,
					  shuttle_data.shuttle_data_from_pool,
					  shuttle_data.shuttle_data_to,
					  shuttle_data.shuttle_data_to_pool,
					  shuttle_data.shuttle_data_departure_bookcode,
					  shuttle_data.shuttle_data_arrival_bookcode")
                ->edit_column('shuttle_data.shuttle_data_departure_bookcode', '$1', 'format_shuttle_book_code(shuttle_data.shuttle_data_departure_bookcode, shuttle_data.shuttle_data_arrival_bookcode)')
                ->select("shuttle_data.shuttle_data_roundtrip,
					  shuttle_data.shuttle_data_psgr,
					  shuttle_data.shuttle_data_status,
					  agent.agent_id,
					  agent.agent_username")
                ->from('shuttle_data')
                ->join('agent', 'shuttle_data.agent_id = agent.agent_id', 'INNER');

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->add_column('agentusername', '$1', 'agent.agent_username');
        }
        if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
            $this->datatables->add_column('agentusername', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent2" onclick="detail_agent2($2);">$1</a>', 'agent.agent_username, agent.agent_id');
        }
        $this->datatables->add_column('status', '<div class="$1">$1</div>', 'shuttle_data.shuttle_data_status');
        $this->datatables->add_column('action', '$1', 'format_action_issue_shuttle(shuttle_data.shuttle_data_id)');
        
        if ($this->session->userdata['level_id'] == "5") {
            $this->datatables->where('( agent.user_level_id IN (\'7\',\'6\') )', NULL, FALSE);
            $this->datatables->where('agent.cabang_agency', $cabang_agency);
        }

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->where('agent.corporate_agency = ' . $this->session->userdata['corporate_agency'] . ' and shuttle_data.shuttle_data_status = \'issue\'', NULL, FALSE);
        } else {
            if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
                $this->datatables->where('shuttle_data.shuttle_data_status = \'issue\'', NULL, FALSE);
            } else {
                $this->datatables->where('shuttle_data.agent_id = ' . $id . ' and shuttle_data.shuttle_data_status = \'issue\'', NULL, FALSE);
            }
        }
        $this->datatables->unset_column('shuttle_data.shuttle_data_id');
        $this->datatables->unset_column('shuttle_data.shuttle_data_arrival_bookcode');
        $this->datatables->unset_column('shuttle_data.shuttle_data_status');
        $this->datatables->unset_column('agent.agent_id');
        $this->datatables->unset_column('agent.agent_username');
        echo $this->datatables->generate();
        exit;
    }

    function book_shuttle() {
        $id = $this->session->userdata['id'];
        
        $cabang_agency = $this->session->userdata['cabang_agency'];
        
        $this->datatables->set_database("default", TRUE);
        $this->datatables
                ->select("shuttle_data.shuttle_data_id, 
					  shuttle_data.shuttle_data_book_date, 
					  shuttle_data.shuttle_data_from,
					  shuttle_data.shuttle_data_from_pool,
					  shuttle_data.shuttle_data_to,
					  shuttle_data.shuttle_data_to_pool,
					  shuttle_data.shuttle_data_departure_bookcode,
					  shuttle_data.shuttle_data_arrival_bookcode")
                ->edit_column('shuttle_data.shuttle_data_departure_bookcode', '$1', 'format_shuttle_book_code(shuttle_data.shuttle_data_departure_bookcode, shuttle_data.shuttle_data_arrival_bookcode)')
                ->select("shuttle_data.shuttle_data_roundtrip,
					  shuttle_data.shuttle_data_psgr,
					  shuttle_data.shuttle_data_status,
					  agent.agent_id,
					  agent.agent_username")
                ->from('shuttle_data')
                ->join('agent', 'shuttle_data.agent_id = agent.agent_id', 'INNER');

        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->add_column('agentusername', '$1', 'agent.agent_username');
        }
        if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
            $this->datatables->add_column('agentusername', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent" onclick="detail_agent($2);">$1</a>', 'agent.agent_username, agent.agent_id');
        }
        $this->datatables->add_column('status', '<div class="$1">$1</div>', 'shuttle_data.shuttle_data_status');
        $this->datatables->add_column('action', '$1', 'format_action_book_shuttle(shuttle_data.shuttle_data_id)');

        if ($this->session->userdata['level_id'] == "5") {
            $this->datatables->where('( agent.user_level_id IN (\'7\',\'6\') )', NULL, FALSE);
            $this->datatables->where('agent.cabang_agency', $cabang_agency);
        }
        
        if ($this->session->userdata['corporate_agency'] != '' && $this->session->userdata['corporate_agency'] != '0') {
            $this->datatables->where('agent.corporate_agency = ' . $this->session->userdata['corporate_agency'] . ' and shuttle_data.shuttle_data_status IN(\'book\',\'expire\')', NULL, FALSE);
        } else {
            if ($this->session->userdata['level_id'] == '8' or $this->session->userdata['level_id'] == '9') {
                $this->datatables->where('shuttle_data.shuttle_data_status IN(\'book\',\'expire\')', NULL, FALSE);
            } else {
                $this->datatables->where('shuttle_data.agent_id = ' . $id . ' and shuttle_data.shuttle_data_status IN(\'book\',\'expire\')', NULL, FALSE);
            }
        }
        $this->datatables->unset_column('shuttle_data.shuttle_data_id');
        $this->datatables->unset_column('shuttle_data.shuttle_data_arrival_bookcode');
        $this->datatables->unset_column('shuttle_data.shuttle_data_status');
        $this->datatables->unset_column('agent.agent_id');
        $this->datatables->unset_column('agent.agent_username');
        echo $this->datatables->generate();
        exit;
    }

    function ot_member() {
        $id = $this->session->userdata['id'];
        $this->datatables->set_database("ota", TRUE);
        $this->datatables
                ->select("a.member_registration_date,
					  a.member_first_name, 
					  a.member_last_name, 
					  a.member_no_hp,
					  a.member_email,
					  a.member_username,
					  a.member_status")
                ->edit_column('a.member_first_name', '$1 $2', 'a.member_first_name,a.member_last_name')
                ->edit_column('a.member_status', '<div class="$1">$1</div>', 'a.member_status')
                ->from('OTA_member a')
                ->join('OTA_akun b', 'a.akun_id = b.akun_id', 'INNER')
                ->where('b.agent_id = ' . $id, NULL, FALSE)
                ->unset_column('a.member_last_name');
        echo $this->datatables->generate();
        exit;
    }

    function data_asuransi() {
        $this->datatables->select('tgl,transaction_type,agent_username,depBook,retBook,jumlah_penumpang,agent_id,book_id');
        $this->datatables->from('view_data_asuransi');
        $this->datatables->edit_column('agent_username', '<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent" onclick="detail_agent($2);">$1</a>', 'agent_username, agent_id');
        $this->datatables->edit_column('agent_id', '$1', 'asuransi_status(transaction_type,book_id)');
        $this->datatables->edit_column('book_id', '$1', 'asuransi_action(transaction_type,book_id)');
        #$this->datatables->unset_column('agent_id');
        #$this->datatables->unset_column('book_id');
        /* 		$this->datatables->join('agent b','a.agent_id = b.agent_id','INNER');
          $this->datatables->edit_column('b.agent_username','<a data-toggle="modal" data-backdrop="static" href="#box-detail-agent" onclick="detail_agent($2);">$1</a>','b.agent_username, b.agent_id');
          $this->datatables->unset_column('b.agent_id');

          $this->datatables->add_column('a.ppob_status', '$1','ppob_status(a.ppob_status,a.deposit_return)');
          #$this->datatables->add_column('a.ppob_status', '<div class="$1">$1</div>','a.ppob_status');

          $this->datatables->unset_column('a.ppob_id');
          $this->datatables->unset_column('a.ppob_status');
          $this->datatables->unset_column('a.deposit_return');
          $this->datatables->unset_column('a.refpayment'); */
        echo $this->datatables->generate();
        exit;
    }

    function travelguide() {
        $id = $this->session->userdata['id'];
        $this->datatables->set_database("ota", TRUE);
        $this->datatables->select('a.travelguide_id,a.travelguide_create_date,a.travelguide_title,a.travelguide_status');
        $this->datatables->from('OTA_travelguide a');
        $this->datatables->join('OTA_akun b', 'a.akun_id = b.akun_id', 'INNER');
        $this->datatables->where('b.agent_id = ' . $id, NULL, FALSE);
        #$this->datatables->edit_column('travelguide_img','<div><img src="'.base_url().'static/img/onlinetravel/travelguide/$1" style="width:80px;height:80px;" /></div>','travelguide_img');
        #$this->datatables->add_column('aksi','<a cls="btn btn-info btn-mini" title="Edit" href="'.base_url().'onlinetravel/ot_travelguide_edit/$1'.'"><i class="splashy-document_letter_edit"></i></a><a title="Hapus" href="#" onclick="del(\'$1\')"><i class="splashy-document_letter_remove"></i></a>','encode(a.travelguide_id)');
        $this->datatables->add_column('aksi', '$1', 'form_action_travelguide(a.travelguide_id)');
        $this->datatables->unset_column('a.travelguide_id');
        echo $this->datatables->generate();
        exit;
    }

    function newsinfo() {

        $id = $this->session->userdata['id'];

        $this->datatables->set_database("ota", true);
        $this->datatables->select('a.article_id, a.article_create_date, a.article_title,a.article_status');
        $this->datatables->from('tbl_article a');
        $this->datatables->join('OTA_akun b', 'a.akun_id = b.akun_id', 'INNER');
        $this->datatables->where('b.agent_id = ' . $id, NULL, FALSE);
        $this->datatables->add_column('aksi', '$1', 'form_action_newsinfo(a.article_id)');
        $this->datatables->unset_column('a.article_id');
        echo $this->datatables->generate();
        exit();
    }

    function aeropay_data() {
        $this->datatables->set_database("service", TRUE);
        $this->datatables
                ->select('a.aeropay_transaction_date, a.client, a.transaction_code, a.confirmed_payment_type, a.amount, a.message, a.aeropay_transaction_status')
                ->from('aeropay_transaction a');

        $this->datatables->add_column('aksi', '$1', 'form_action_aeropay(a.client,a.transaction_code)');
        //#$this->datatables->edit_column('a.client','$1','format_client_aeropay(a.client)');
        $this->datatables->edit_column('a.confirmed_payment_type', '$1', 'format_confirmed_payment_type(a.confirmed_payment_type)');
        $this->datatables->edit_column('a.aeropay_transaction_status', '$1', 'format_direct_debit_status(a.aeropay_transaction_status)');

        //$this->datatables->unset_column('b.agent_username');
        echo $this->datatables->generate();
        exit;
    }

    function railink_daily() {
        $this->datatables->set_database("default", TRUE);
        $this->datatables
                ->select("train_data_id,train_data_date,train_data_type,train_data_from,train_data_to,train_data_departure_bookcode,train_data_return_bookcode,train_data_adult,train_data_child,train_data_status,app")
                ->from('train_data')
                ->where('train_data_transaction = "railink"');
        $this->datatables->add_column('train_data_status', '<div class="$1">$1</div>', 'train_data_status');

        $this->datatables->unset_column('train_data_id');
        $this->datatables->unset_column('train_data_status');
        echo $this->datatables->generate();
        exit;
    }

    function ApproveMutasi() {
        $this->datatables->set_database("aero1", TRUE);
        $this->datatables
                ->select('a.id, b.account_name, b.name, b.account_number, a.timestamp, a.tanggal, a.nilai, a.jenis, a.keterangan, a.status')
                ->from('bank_account_statements a')
                ->join('bank_accounts b', 'a.id_bank = b.id', 'INNER');

        $this->datatables->edit_column('b.name', '$1 / $2', 'b.name, b.account_number');
        $this->datatables->edit_column('a.status', '$1', 'format_bank_mutation_status(a.id, a.status)');
        $this->datatables->unset_column('b.account_number');
        echo $this->datatables->generate();
        exit;
    }

    function agent_corporate() {
        #query get data cprporate
        #tambahan kodisi buat cabang (creat by: alaunal kauniyyah)
        
        $cabang_agency = $this->session->userdata['cabang_agency'];
        if ($cabang_agency) {
            $this->datatables
                    ->select('corporate_id, corporate_agency, corporate_joining_date, corporate_name, corporate_address, corporate_owner, corporate_phone_number, corporate_email')
                    ->from('corporate')
                    ->where('cabang_agency', $cabang_agency);
        } else {
            $this->datatables->select('corporate_id, corporate_agency, corporate_joining_date, corporate_name, corporate_address, corporate_owner, corporate_phone_number, corporate_email');
            $this->datatables->from('corporate');
        }



        $this->datatables->add_column('Status', '$1', 'form_aksi_corporate(corporate_id)');
        $this->datatables->add_column('Action', '$1', 'view_detail_corporate(corporate_id)');
        $this->datatables->unset_column('corporate_id');
        echo $this->datatables->generate();
        exit();
    }
	
	function flight_book($status) {
		
        if ($status == 'ticketed'): $date = 'flight_data_issued_date'; else: $date = 'flight_data_book_date'; endif;
	
        $this->datatables
                ->select("flight_data_id, " . $date . ", flight_data_rute, customer_name, depart_airlines_id, return_airlines_id, flight_data_from, flight_data_to, depart_book_code, return_book_code, depart_expired_date, return_expired_date, flight_data_status, c.airlines_img2 depart_airlines, d.airlines_img2 return_airlines, flight_data_jenis_asuransi")
                ->from("flight_data a")
                ->join('airlines c', 'c.airlines_id=a.depart_airlines_id')
                ->join('airlines d', 'd.airlines_id=a.return_airlines_id', 'LEFT');
		
		switch($this->session->userdata['grouplevel_id']):
			case "1":
				$this->datatables->where('agent_id',$this->session->userdata['id']);
			break;
			case "2":
				$this->datatables->where('corporate_agency',$this->session->userdata['corporate_agency']);
			break;
		endswitch;
		
        if ($status == 'cancel'):
            $this->datatables->where('( flight_data_status IN (\'cancel\',\'ctl\',\'ctl segment\',\'refund\') )', NULL, FALSE);
        else:
            if($status!=""): $this->datatables->where('flight_data_status', $status); endif;
        endif;
		
        if ($status == 'ticketed'):
            $this->datatables->edit_column('depart_book_code', '<center><b>$1</b> &nbsp;&nbsp; <b>$2</b>&nbsp;&nbsp; <b>$3</b></center>', 'depart_book_code, return_book_code, notif_asuransi(flight_data_jenis_asuransi)');
        else:
            $this->datatables->edit_column('depart_book_code', '<center><b>$1</b> &nbsp;&nbsp; <b>$2</b></center>', 'depart_book_code, return_book_code');
        endif;
		
        $this->datatables->edit_column('depart_airlines_id', '$1', 'format_maskapai(c.airlines_img2 depart_airlines, d.airlines_img2 return_airlines)');
        $this->datatables->add_column('batas_waktu', '$1', 'format_ts_book_bataswaktu(flight_data_id, depart_expired_date, return_expired_date, flight_data_status)');
        $this->datatables->add_column('status', '$1', 'format_ts_book_status(flight_data_status)');
        $this->datatables->add_column('action', '$1', 'format_action_book_cancel(flight_data_status,flight_data_id,b.agent_id)');
        $this->datatables->add_column('data_countdown', '$1', 'format_data_countdown(depart_expired_date, return_expired_date)');

        $this->datatables->unset_column('flight_data_id');
        $this->datatables->unset_column('return_book_code');
        $this->datatables->unset_column('depart_expired_date');
        $this->datatables->unset_column('return_expired_date');
        $this->datatables->unset_column('flight_data_status');
        $this->datatables->unset_column('return_airlines_id');
        $this->datatables->unset_column('c.airlines_img2 depart_airlines');
        $this->datatables->unset_column('d.airlines_img2 return_airlines');
        $this->datatables->unset_column('flight_data_jenis_asuransi');

        echo $this->datatables->generate();
        exit;
    }
	
    // ------------------------------------------------------------------------
    function ot_carousel() {
        $this->datatables->set_database("ota", true);
        $this->datatables
                ->select('a.OTA_carousel_id, a.OTA_carousel_img, a.OTA_carousel_title, a.OTA_carousel_desc')
                ->from('OTA_carousel a')
                ->join('OTA_akun b', 'a.OTA_akun_id = b.akun_id', 'INNER')
                ->where('b.agent_id', $this->session->userdata['id']);
        $this->datatables->add_column('aksi', '$1', 'form_carousel(a.OTA_carousel_id)');
        $this->datatables->unset_column('a.OTA_carousel_id');
        echo $this->datatables->generate();
        exit();
    }
}

?>