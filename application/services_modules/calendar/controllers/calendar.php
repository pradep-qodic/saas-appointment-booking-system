<?php
/*
Author: Mitesh Patel
Date: 04/2/2015
Version: 1.0
*/

class Calendar extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('calendar_model');
		$this->load->library('form_validation');
		$this->load->library('basic401authentication');
		$this->basic401authentication->require_login();
		$this->userID=$this->session->userdata('userID');
		$this->userOrgId=$this->session->userdata('userOrgId');
    }
	function index(){}
	function newCalendar(){
		$config = array(
			array(
				'field' => 'calendarUrl',
				'label' => 'Calendar Url',
				'rules' => 'trim|required|alpha_dash|min_length[4]|max_length[30]',
			),
			array(
				'field' => 'email',
				'label' => 'email',
				'rules' => 'trim|required|valid_email|xss_clean',
			),
			array(
				'field' => 'location',
				'label' => 'location',
				'rules' => 'trim|required|alpha_dash',
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
			$this->load->view('json_viewHeaders', $data);
		}else{
				$calUrl = $this->input->post ( "calendarUrl", true );
				$redSec = $this->input->post ( "redirectionSec", true );
				$redUrl = $this->input->post ( "redirectionUrl", true );
				$name = $this->input->post ( "name", true );
				$mobileNo = $this->input->post ( "mobileNo", true );
				$email = $this->input->post ( "email", true );
				$pageInfo = $this->input->post ( "pageInfo", true );
				$location = $this->input->post ( "location", true );
				
				$reminderNote = $this->input->post ( "reminderNote", true );
				$followupEmailVal = $this->input->post ( "followupEmailVal", true );
				$followupEmailNote = $this->input->post ( "followupEmailNote", true );
				
				$notify_on_booking = $this->input->post ( "notify_on_booking", true );
				$notify_on_booking_request = $this->input->post ( "notify_on_booking_request", true );
				$notify_on_cancellations = $this->input->post ( "notify_on_cancellations", true );
				$cc_on_applicant_reminders = $this->input->post ( "cc_on_applicant_reminders", true );
				$cc_on_followup_emails = $this->input->post ( "cc_on_followup_emails", true );
				
				$isPageUrlAvailable=$this->calendar_model->isAvailableBookingPageUrl($calUrl);
				if($isPageUrlAvailable){
					$data ['json'] = json_encode ( array (
							"status" => "error",
							"message" => "The Calendar Url field must contain a unique value."
					) );
					$this->load->view ( 'json_view', $data );
					return;
				}
				$isMPageUrlAvailable=$this->calendar_model->isAvailableMBookingPageUrl($calUrl);
				if($isMPageUrlAvailable){
					$data ['json'] = json_encode ( array (
							"status" => "error",
							"message" => "The Calendar Url field must contain a unique value."
					) );
					$this->load->view ( 'json_view', $data );
					return;
				}
				
				$this->load->helper ( 'date' );
				$now = time ();
				$cdata ['email'] = $email;
				$cdata ['password'] = "";
				$cdata ['salt'] = "";
				$cdata ['firstname'] = "";
				$cdata ['lastname'] = "";
				$cdata ['pageInfo'] = $pageInfo;
				$cdata ['name'] = $calUrl;
				$cdata ['booking_url'] = $calUrl;
				$cdata ['mobileno'] = $mobileNo;
				$cdata ['gender'] = "";
				$cdata ['isVerifiedBySAdmin'] = 1;
				$cdata ['isSuperAdmin'] = 0;
				$cdata ['status'] = 1;
				$cdata ['createdOn'] = unix_to_human ( $now, TRUE, 'us' );
				$cdata ['org_id'] = $this->userOrgId;
				$cdata ['redirectionSec'] = ($redSec) ? $redSec : '';
				$cdata ['redirectionUrl'] = ($redUrl) ? $redUrl : '';
				
				//Booking
				$cdata ['redirectionUrl'] = $redUrl;
				
				//Location
				$cdata ['location'] = $location;
				
				
				
				$c_id = $this->calendar_model->createCalendar( $cdata );
				if($c_id){
					//Customer Notification
					$notifydata ['reminderNote'] = $reminderNote;
					$notifydata ['followupEmailVal'] = $followupEmailVal;
					$notifydata ['followupEmailNote'] = $followupEmailNote;
					$notifydata ['bookingPageId'] = $c_id;
					
					//User Notification
					$usernotifydata ['notify_on_booking'] = $notify_on_booking;
					$usernotifydata ['notify_on_booking_request'] = $notify_on_booking_request;
					$usernotifydata ['notify_on_cancellations'] = $notify_on_cancellations;
					$usernotifydata ['cc_on_applicant_reminders'] = $cc_on_applicant_reminders;
					$usernotifydata ['cc_on_followup_emails'] = $cc_on_followup_emails;						
					
					$n_id = $this->calendar_model->creatApp_notify( $notifydata );
					$u_id = $this->calendar_model->creatUserNotification( $usernotifydata );
				}
				//Availability
				$resourceId = $this->input->post ( 'resourceId', true );
				if (isset ( $resourceId ) && $resourceId) {
					$settings = json_decode ( $this->input->post ( 'settings', true ), true );
					if ($settings) {
						$this->calendar_model->save_settings ( $settings, $resourceId );
					}
					$wPlan = $this->calendar_model->getWorkingPlans ( $resourceId );
					
					$data ['slots'] = $wPlan [0]->value;
					$data ['json'] = json_encode ( array (
							"status" => "success",
							"message" => "Working Plan Saved Successfully",
							"data" => $data 
					) );
					$this->load->view ( 'json_view', $data );
					return;
				}
				
				if ($c_id) {
					$this->calendar_model->setResourceDefaultWorkingPlan ( $this->userOrgId, $c_id );
					$this->calendar_model->setResourceDefaultHolidays($this->userOrgId, $c_id);
					$data['json'] = json_encode(array("status"=>"success","message"=>"Calendar Created.","data"=>array("calendarId"=>$c_id)));
					$this->load->view('json_viewHeaders', $data);
				}else if ($n_id) {
					$data['json'] = json_encode(array("status"=>"success","message"=>"App Created.","data"=>array("app_notification_id"=>$n_id)));
					$this->load->view('json_viewHeaders', $data);
				}else if ($u_id) {
					$data['json'] = json_encode(array("status"=>"success","message"=>"User notification Data.","data"=>array("user_notification_id"=>$u_id)));
					$this->load->view('json_viewHeaders', $data);
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Calendar Not Created.","data"=>""));
					$this->load->view('json_viewHeaders', $data);
				}
		
		}
		return;
	}
	function getCalendar(){
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
			 $this->load->view('json_viewHeaders', $data);
		}else{
			$cal=$this->calendar_model->calendar_by_id($this->input->post('calendarId'),$this->userOrgId);
			if($cal){
				$dt['calendar']=$cal;
				$data['json'] = json_encode(array("status"=>"success","message"=>"Calendar Details","data"=>$dt));
				$this->load->view('json_viewHeaders', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Calendar Not Found","data"=>""));
				$this->load->view('json_viewHeaders', $data);
			}	
		}
		return;
	}
	function getCalendarsByOrganizationId(){
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
			 $this->load->view('json_viewHeaders', $data);
		}else{
			$cal=$this->calendar_model->calendar_by_orgid($this->input->post('org_id'));
			if($cal){
				$dt['calendars']=$cal;
				$data['json'] = json_encode(array("status"=>"success","message"=>"Calendars Details","data"=>$dt));
				$this->load->view('json_viewHeaders', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Calendars Not Found","data"=>""));
				$this->load->view('json_viewHeaders', $data);
			}	
		}
		return;
	}
	function updateCalendar(){
		$config = array(
			array(
				'field' => 'calendarId',
				'label' => 'Calendar Id',
				'rules' => 'trim|required|numeric',
			),
			array(
				'field' => 'calendarUrl',
				'label' => 'Calendar Url',
				'rules' => 'trim|required|alpha_dash|min_length[4]|max_length[30]',
			),
			array(
				'field' => 'email',
				'label' => 'email',
				'rules' => 'trim|required|valid_email|xss_clean',
			),
			array(
				'field' => 'location',
				'label' => 'location',
				'rules' => 'trim|required|alpha_dash',
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
			 $this->load->view('json_viewHeaders', $data);
		}else{
						
			$calId=$this->input->post('calendarId',true);
			$calUrl = $this->input->post ( "calendarUrl", true );
			$redSec = $this->input->post ( "redirectionSec", true );
			$redUrl = $this->input->post ( "redirectionUrl", true );
			
			$name = $this->input->post ( "name", true );
			$mobileNo = $this->input->post ( "mobileNo", true );
			$email = $this->input->post ( "email", true );
			$pageInfo = $this->input->post ( "pageInfo", true );
							
			$location = $this->input->post ( "location", true );
			
			$reminderNote = $this->input->post ( "reminderNote", true );
			$followupEmailVal = $this->input->post ( "followupEmailVal", true );
			$followupEmailNote = $this->input->post ( "followupEmailNote", true );
			
			
			$notify_on_booking = $this->input->post ( "notify_on_booking", true );
			$notify_on_booking_request = $this->input->post ( "notify_on_booking_request", true );
			$notify_on_cancellations = $this->input->post ( "notify_on_cancellations", true );
			$cc_on_applicant_reminders = $this->input->post ( "cc_on_applicant_reminders", true );
			$cc_on_followup_emails = $this->input->post ( "cc_on_followup_emails", true );			
				
			$isPageUrlAvailable=$this->calendar_model->isAvailableBookingPageUrlForUpdate($calUrl,$calId);
			
			if($isPageUrlAvailable){
				$data ['json'] = json_encode ( array (
						"status" => "error",
						"message" => "The Calendar Url field must contain a unique value."
				) );
				$this->load->view ( 'json_view', $data );
				return;
			}
			$isMPageUrlAvailable=$this->calendar_model->isAvailableMBookingPageUrlForUpdate($calUrl,$calId);
			if($isMPageUrlAvailable){
				$data ['json'] = json_encode ( array (
						"status" => "error",
						"message" => "The Calendar Url field must contain a unique value."
				) );
				$this->load->view ( 'json_view', $data );
				return;
			}
			
			$this->load->helper ( 'date' );
			$now = time ();
			$cdata ['email'] = $email;
			$cdata ['password'] = "";
			$cdata ['salt'] = "";
			$cdata ['firstname'] = "";
			$cdata ['lastname'] = "";
			$cdata ['name'] = $calUrl;
			$cdata ['booking_url'] = $calUrl;
			$cdata ['mobileno'] = $mobileNo;
			$cdata ['gender'] = "";
			$cdata ['pageInfo'] = $pageInfo;
			$cdata ['isVerifiedBySAdmin'] = 1;
			$cdata ['isSuperAdmin'] = 0;
			$cdata ['status'] = 1;
			$cdata ['createdOn'] = unix_to_human ( $now, TRUE, 'us' );
			$cdata ['org_id'] = $this->userOrgId;
			$cdata ['redirectionSec'] = ($redSec) ? $redSec : '';
			$cdata ['redirectionUrl'] = ($redUrl) ? $redUrl : '';
			
			//Booking
			$cdata ['redirectionUrl'] = $redUrl;
			
			//Location
			$cdata ['location'] = $location;
								
			//Customer Notification
			$notifydata ['reminderNote'] = $reminderNote;
			$notifydata ['followupEmailVal'] = $followupEmailVal;
			$notifydata ['followupEmailNote'] = $followupEmailNote;
			
			//User Notification
			$usernotifydata ['notify_on_booking'] = $notify_on_booking;
			$usernotifydata ['notify_on_booking_request'] = $notify_on_booking_request;
			$usernotifydata ['notify_on_cancellations'] = $notify_on_cancellations;
			$usernotifydata ['cc_on_applicant_reminders'] = $cc_on_applicant_reminders;
			$usernotifydata ['cc_on_followup_emails'] = $cc_on_followup_emails;
			
			$updateCal = $this->calendar_model->update($calId,$cdata);
			if($updateCal){
				$updateAppCal = $this->calendar_model->updateApplicantNotifications($calId,$notifydata);
				$updateUserCal = $this->calendar_model->creatUserNotification($usernotifydata);							
				$data['json'] = json_encode(array("status"=>"success","message"=>"Calendar Updated.","data"=>""));
				$this->load->view('json_viewHeaders', $data);
				return;
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Calendar Not Updated.","data"=>""));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
		}	
		return;
	}
	function deleteCalendar(){
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
			 $this->load->view('json_viewHeaders', $data);
		}else{
			$cal_id=$this->input->post('calendarId',true);
			if(isset($cal_id) && $cal_id && !$this->calendar_model->checkCalendarAvailability($cal_id)){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Calendar Not Found.","data"=>""));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
			$data['isDeleted'] = 1;
			$updateCalendar = $this->calendar_model->delete($cal_id,$data);
			if($updateCalendar){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Calendar Deleted.","data"=>""));
				$this->load->view('json_viewHeaders', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Calendar Not Deleted.","data"=>""));
				$this->load->view('json_viewHeaders', $data);
			}
		}
		return;
	}
}
