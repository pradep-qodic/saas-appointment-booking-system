<?php
/*
Author: Mitesh Patel
Date: 04/2/2015
Version: 1.0
*/

class Mastercalendar extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('masterCalendar_model');
		$this->load->library('form_validation');
		$this->load->library('basic401authentication');
		$this->basic401authentication->require_login();
		$this->userID=$this->session->userdata('userID');
		$this->userOrgId=$this->session->userdata('userOrgId');
    }
	function index(){}
	function newMasterCalendar(){
		$config = array(
			array(
                        'field' => 'masterCalendarUrl',
                        'label' => 'Master Calendar Url',
                        'rules' => 'trim|required|alpha_dash|min_length[4]|max_length[30]|is_unique[inspection_type.booking_url]|is_unique[users.booking_url]',
                    )
		);

		$this->form_validation->set_rules($config);

		if($this->form_validation->run() === false){
			 $this->form_validation->set_error_delimiters(' ', ' ');
			 $arr[]=validation_errors();
			 if($arr[0]==""){
				$arr=array("Provide Required Fields");
			 }
			 $data['json'] = json_encode(array("status"=>"error","message"=>$arr,"data"=>""));
			 $this->load->view('json_view', $data);
		}else{
				$calUrl = $this->input->post ( "masterCalendarUrl", true );
				$bookingPageLabel = $this->input->post ( "bookingPageLabel", true );
				$logo_url = $this->input->post ( "logo_url", true );
				$message = $this->input->post ( "pageInfo", true );
				$email = $this->input->post ( "email", true );
				$phone = $this->input->post ( "phone", true );
											
				$this->load->helper('date');
				$now = time();
                $data['typeName']		= $calUrl;
				$data['booking_url']	= $calUrl;
				$data['bookingPageLabel']= $bookingPageLabel;
				$data['logo_url']		= $logo_url;
				$data['pageInfo']		= $message;
				$data['email']			= $email;
				$data['phone']			= $phone;
				$data['org_id']			= $this->userOrgId;
                $data['createdOn']	    = unix_to_human($now, TRUE, 'us');
				$data['status']	    	= 1;
                $data['createdBy']		= $this->userID;
                    
                $create_id = $this->masterCalendar_model->createMasterCalendar($data);
				
				if ($create_id) {
					$data['json'] = json_encode(array("status"=>"success","message"=>"Master Calendar Created.","data"=>array("masterCalendarId"=>$create_id)));
					$this->load->view('json_view', $data);
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Master Calendar Not Created.","data"=>""));
					$this->load->view('json_view', $data);
				}
		}
		return;
	}
	function getMasterCalendar(){
		$config = array(
			array(
				'field' => 'masterCalendarId',
				'label' => 'Master Calendar Id',
				'rules' => 'trim|required|numeric',
			)
		);

		$this->form_validation->set_rules($config);

		if($this->form_validation->run() === false){
			 $this->form_validation->set_error_delimiters(' ', ' ');
			 $arr[]=validation_errors();
			 if($arr[0]==""){
				$arr=array("Provide Required Fields");
			 }
			 $data['json'] = json_encode(array("status"=>"error","message"=>$arr,"data"=>""));
			 $this->load->view('json_view', $data);
		}else{
			$cal=$this->masterCalendar_model->masterCalendar_by_id($this->input->post('masterCalendarId'),$this->userOrgId);
			if($cal){
				$dt['masterCalendar']=$cal;
				$data['json'] = json_encode(array("status"=>"success","message"=>"Master Calendar Details","data"=>$dt));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Master Calendar Not Found","data"=>""));
				$this->load->view('json_view', $data);
			}	
		}
		return;
	}
	function getMasterCalendarsByOrganizationId(){
		$config = array(
			array(
				'field' => 'org_id',
				'label' => 'Organization ID',
				'rules' => 'trim|required|numeric',
			)
		);

		$this->form_validation->set_rules($config);

		if($this->form_validation->run() === false){
			 $this->form_validation->set_error_delimiters(' ', ' ');
			 $arr[]=validation_errors();
			 if($arr[0]==""){
				$arr=array("Provide Required Fields");
			 }
			 $data['json'] = json_encode(array("status"=>"error","message"=>$arr,"data"=>""));
			 $this->load->view('json_view', $data);
		}else{
			$cal=$this->masterCalendar_model->masterCalendar_by_orgid($this->input->post('org_id'));
			if($cal){
				$dt['masterCalendars']=$cal;
				$data['json'] = json_encode(array("status"=>"success","message"=>"Master Calendars Details","data"=>$dt));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Master Calendars Not Found","data"=>""));
				$this->load->view('json_view', $data);
			}	
		}
		return;
	}
	function updateMasterCalendar(){
		$config = array(
			array(
				'field' => 'org_user_id',
				'label' => 'Organization UserID',
				'rules' => 'trim|required|numeric',
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required|min_length[6]|max_length[12]',
			),
			array(
				'field' => 'firstname',
				'label' => 'Firstname',
				'rules' => 'trim|required|alpha_numeric',
			),
			array(
				'field' => 'org_id',
				'label' => 'Organization ID',
				'rules' => 'trim|required|numeric',
			)
			
		);

		$this->form_validation->set_rules($config);

		if($this->form_validation->run() === false){
			 $this->form_validation->set_error_delimiters(' ', ' ');
			 $arr[]=validation_errors();
			 if($arr[0]==""){
				$arr=array("Provide Required Fields");
			 }
			 $data['json'] = json_encode(array("status"=>"error","message"=>$arr,"data"=>""));
			 $this->load->view('json_view', $data);
		}else{
			$orgID=$this->input->post('org_id',true);
			if(isset($orgID) && $orgID && !$this->user_model->checkOrgAvailability($orgID)){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Organization NotFound"));
				$this->load->view('json_view', $data);
				return;
			}
			
			$user_id=$this->input->post('org_user_id',true);
			$rand_salt = $this->user_model->getUserSalt($user_id);
			$encrypt_pass = $this->schedular_auth->encryptUserPwd( $this->input->post('password'),$rand_salt);
			$data['password']		= $encrypt_pass;
			$data['salt']			= $rand_salt;
			$data['firstname']		= $this->input->post('firstname',true);
			$data['lastname']		= $this->input->post('lastname',true);
			$data['isSuperAdmin']	= $this->input->post('isSuperAdmin',true);
			$data['mobileNo']		= $this->input->post('mobileno',true);
			$data['gender']			= $this->input->post('gender',true);
			$data['org_id']			= $this->input->post('org_id',true);
			$data['email']			= $this->input->post('email',true);
			$data['name']			= $this->input->post('name',true);
			$data['pageInfo']		= $this->input->post('pageInfo',true);
			$data['logo_url']		= $this->input->post('logo_url',true);
			$updateUser = $this->user_model->update($user_id,$data);
			if($updateUser){
				$data['json'] = json_encode(array("status"=>"success","message"=>"User Updated.","data"=>""));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"User Not Updated.","data"=>""));
				$this->load->view('json_view', $data);
			}
		}
		return;
	}
	function getMasterCalendarByCalendarId(){
		$config = array(
				array(
						'field' => 'calendarId',
						'label' => 'Calendar Id',
						'rules' => 'trim|required|numeric',
				)
		);
		
		$this->form_validation->set_rules($config);
		
		if($this->form_validation->run() === false){
			$this->form_validation->set_error_delimiters(' ', ' ');
			$arr[]=validation_errors();
			if($arr[0]==""){
				$arr=array("Provide Required Fields");
			}
			$data['json'] = json_encode(array("status"=>"error","message"=>$arr,"data"=>""));
			$this->load->view('json_view', $data);
		}else{
			$cal_id=$this->input->post('calendarId',true);
			$this->load->model("calendar/calendar_model");
			if(isset($cal_id) && $cal_id && !$this->calendar_model->checkCalendarAvailability($cal_id)){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Calendar Not Found.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
		
			$mCal = $this->masterCalendar_model->getMasterCalBycalId($cal_id);
			if($mCal){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Master Calendar .","data"=>array("masterCalendarId"=>$mCal)));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Master Calendar Not Found.","data"=>""));
				$this->load->view('json_view', $data);
			}
		}
		return;
	}
	function addCalendar(){
		$config = array(
				array(
						'field' => 'masterCalendarId',
						'label' => 'Master Calendar Id',
						'rules' => 'trim|required|numeric',
				),
				array(
						'field' => 'calendarId',
						'label' => 'Calendar Id',
						'rules' => 'trim|required|numeric',
				)
		);
		
		$this->form_validation->set_rules($config);
		
		if($this->form_validation->run() === false){
			$this->form_validation->set_error_delimiters(' ', ' ');
			$arr[]=validation_errors();
			if($arr[0]==""){
				$arr=array("Provide Required Fields");
			}
			$data['json'] = json_encode(array("status"=>"error","message"=>$arr,"data"=>""));
			$this->load->view('json_view', $data);
		}else{
			$cal_id=$this->input->post('calendarId',true);
			
			$Mcal_id=$this->input->post('masterCalendarId',true);
			if(isset($Mcal_id) && $Mcal_id && !$this->masterCalendar_model->checkCalendarAvailability($Mcal_id)){
				$data['json'] = json_encode(array("status"=>"error","message"=>" Master Calendar Not Found.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			$this->load->model("calendar/calendar_model");
			if(isset($cal_id) && $cal_id && !$this->calendar_model->checkCalendarAvailability($cal_id)){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Calendar Not Found.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			
			$addedCalendar = $this->masterCalendar_model->addCalendar($Mcal_id,$cal_id);
			if($addedCalendar){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Calendar Added Successfully.","data"=>""));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Calendar Not Added.","data"=>""));
				$this->load->view('json_view', $data);
			}
		}
		return;
	}
	
	function removeCalendar(){
		$config = array(
				array(
						'field' => 'masterCalendarId',
						'label' => 'Master Calendar Id',
						'rules' => 'trim|required|numeric',
				),
				array(
						'field' => 'calendarId',
						'label' => 'Calendar Id',
						'rules' => 'trim|required|numeric',
				)
		);
	
		$this->form_validation->set_rules($config);
	
		if($this->form_validation->run() === false){
			$this->form_validation->set_error_delimiters(' ', ' ');
			$arr[]=validation_errors();
			if($arr[0]==""){
				$arr=array("Provide Required Fields");
			}
			$data['json'] = json_encode(array("status"=>"error","message"=>$arr,"data"=>""));
			$this->load->view('json_view', $data);
		}else{
			$cal_id=$this->input->post('calendarId',true);
				
			$Mcal_id=$this->input->post('masterCalendarId',true);
			if(isset($Mcal_id) && $Mcal_id && !$this->masterCalendar_model->checkCalendarAvailability($Mcal_id)){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Master Calendar Not Found.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			$this->load->model("calendar/calendar_model");
			if(isset($cal_id) && $cal_id && !$this->calendar_model->checkCalendarAvailability($cal_id)){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Calendar Not Found.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
				
			$removedCalendar = $this->masterCalendar_model->removeCalendar($Mcal_id,$cal_id);
			if($removedCalendar){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Calendar Removed Successfully.","data"=>""));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"No data found for remove.","data"=>""));
				$this->load->view('json_view', $data);
			}
		}
		return;
	}
	
	function deleteMasterCalendar(){
		$config = array(
			array(
				'field' => 'masterCalendarId',
				'label' => 'Master Calendar Id',
				'rules' => 'trim|required|numeric',
			)
		);

		$this->form_validation->set_rules($config);

		if($this->form_validation->run() === false){
			 $this->form_validation->set_error_delimiters(' ', ' ');
			 $arr[]=validation_errors();
			 if($arr[0]==""){
				$arr=array("Provide Required Fields");
			 }
			 $data['json'] = json_encode(array("status"=>"error","message"=>$arr,"data"=>""));
			 $this->load->view('json_view', $data);
		}else{
			$cal_id=$this->input->post('masterCalendarId',true);
			if(isset($cal_id) && $cal_id && !$this->masterCalendar_model->checkCalendarAvailability($cal_id)){
				$data['json'] = json_encode(array("status"=>"error","message"=>" Master Calendar Not Found.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
		
			$updateCalendar = $this->masterCalendar_model->delete_Cal($cal_id);
			if($updateCalendar){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Master Calendar Deleted.","data"=>""));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Master Calendar Not Deleted.","data"=>""));
				$this->load->view('json_view', $data);
			}
		}
		return;
	}
}
