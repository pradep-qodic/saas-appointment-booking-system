<?php
/*
Author: Mitesh Patel
Date: 12/02/2015
Version: 1.0
*/

class Appointments extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('appointment_model');
		$this->load->library('form_validation');
		$this->load->library('basic401authentication');
		$this->basic401authentication->require_login();
		$this->userID=$this->session->userdata('userID');
		$this->userOrgId=$this->session->userdata('userOrgId');
    }
	function index(){}
	function newAppointment(){
		$config = array(
					array(
						'field' => 'calendarId',
						'label' => 'calendar Id',
						'rules' => 'trim|required',
					),
                    array(
                        'field' => 'title',
                        'label' => 'Subject',
                        'rules' => 'trim|required',
                    ),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email',
                    ),
                    array(
                        'field' => 'start',
                        'label' => 'Start Date',
                        'rules' => 'trim|required',
                    )
                );
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() === false){
                    $this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
                }else{ 
                	$this->load->helper('date');
                	$now = time();
                	$calId=$this->input->post("calendarId",true);
                	
                	$st=$this->input->post('start',true);
                	
                	$orgEmail=$this->appointment_model->findOrgAdminEmail($this->userID);
                	 
                	$arr=explode(" ",$st);
                	if(count($arr)<2){
                		$data['json'] = json_encode(array("status"=>"error","message"=>array("Please provide a time.")));
                		$this->load->view('json_view', $data);
                		return;
                	}
                	$workingPlans=$this->appointment_model->getSlots($calId);
                	$day=strtolower(date('l',strtotime($arr[0])));
                	$slotGap=30;
                	if(isset($workingPlans) && $workingPlans && isset($day) && $day){
                		$workingPlans=json_decode($workingPlans[0]->value);
                		$slotGap=$workingPlans->$day->time_slots;
                	}
                	$now = now();
                	$minutes_to_add = $slotGap;
                	
                	$time = new DateTime($st);
                	$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                	$endTime = $time->format('Y-m-d H:i');
                	 
                	$isAuto=$this->appointment_model->getBookingPageSetting($calId);
                	if(isset($isAuto) && $isAuto==1){
                		$data['isAutoBooking'] = 1;
                		$data['isApproved']	   = 1;
                	}else{
                		$data['isAutoBooking'] = 0;
                	}
                	
                		$data['app_title']		= $this->input->post('title',true);
                		$data['app_desc']	    = $this->input->post('desc',true)?$this->input->post('desc',true):"";
                		$data['app_start']		= $st;
                		$data['app_end']	    = $endTime;
                		$data['applicant_name']	= $this->input->post('name',true)?$this->input->post('name',true):"";
                		$data['applicant_email']= $this->input->post('email',true);
                		$data['org_id']			= $this->userOrgId;
                		$data['user_id']		= $calId;
                		$data['is_deleted']	    = 0;
                		$data['is_viewed']	    = 0;
                		$data['app_timezone']	= "UP45";//$this->input->post("timezone",true)?trim($this->input->post("timezone",true)):"UP45";
                		$data['appointmentCreatedOn']	= unix_to_human($now, TRUE, 'us');
                		$create_id = $this->appointment_model->createAppointment($data);
                		
                		$this->load->library('email', $this->config->item('email_config'));
                		$appDetails=$this->appointment_model->loadAppointment($create_id);
                		$userDetail=$this->appointment_model->getUserDetail($calId);
                		$dt0['logo']			= "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
                		$dt0['user_email']		= $appDetails[0]->applicant_email;
                		$dt0['scheduleDate']	= $st;
                		$dt0['inspectorName']	= $userDetail[0]->firstname." ".$userDetail[0]->lastname;
                		$dt0['inspectorEmail']	= $userDetail[0]->email;
                		$dt0['applicantName']	= $appDetails[0]->applicant_name;
                		$dt0['applicantEmail']	= $appDetails[0]->applicant_email;
                		$dt0['adminEmail']		= $orgEmail[0]->email;
                		$dt0['bookingPage']		= $userDetail[0]->booking_url;
                		$dt0['AppointmentTitle']= $appDetails[0]->app_title;
                		$this->email->from('support@makkinfotech.biz', 'Scheduler');
                		
                		if($create_id && $isAuto==1){
                			//send email to applicant
                			try{
                				$this->email->subject($appDetails[0]->app_title.' - Scheduler confirmation');
                				$this->email->to($appDetails[0]->applicant_email);
                				$msg=$this->load->view('email/bookingConfirmed',$dt0,TRUE);
                				$this->email->message($msg);
                				$this->email->send();
                			}catch(Exception $exc){}
                			$userNotification=$this->appointment_model->loadUserNotifyData($this->userOrgId);
                			if(isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking) && $userNotification[0]->notify_on_booking==1){
                				//send email to Organization Admin
                				try{
                					$this->email->subject($appDetails[0]->app_title.' has made a booking');
                					$this->email->to($orgEmail[0]->email);
                					$msg1=$this->load->view('email/madeBooking',$dt0,TRUE);
                					$this->email->message($msg1);
                					$this->email->send();
                				}catch(Exception $exc){}
                			}
                		
                			$dt1['app_id']=$create_id;
                			$dt1['allocatedToUserId']=$calId;
                			$dt1['allocatedDate']=$st;
                			$dt1['allocatedDateEnd']=$endTime;
                			$dt1['allocatedByUserId']=$this->userID;
                			$dt1['createdOn']=unix_to_human($now, TRUE, 'us');
                			$allocate=$this->appointment_model->allocateAppointment($dt1);
                			$data['json'] = json_encode(array("status"=>"success","message"=>"Your Appointment Scheduled Successfully..","data"=>""));
                			$this->load->view('json_view', $data);
                		}elseif($create_id && $isAuto==0){
                			//send email to applicant
                			try{
                				$this->email->subject("Your booking request has been submitted");
                				$this->email->to($appDetails[0]->applicant_email);
                				$msg1=$this->load->view('email/madeBookingRequest',$dt0,TRUE);
                				$this->email->message($msg1);
                				$this->email->send();
                			}catch(Exception $exc){}
                			$userNotification=$this->appointment_model->loadUserNotifyData($this->userOrgId);
                			if(isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking_request) && $userNotification[0]->notify_on_booking_request==1){
                				//send email to Organization Admin
                				try{
                					$this->email->subject('Booking request from '.$appDetails[0]->applicant_name);
                					$this->email->to($orgEamil[0]->email);
                					$msg=$this->load->view('email/bookingRequest',$dt0,TRUE);
                					$this->email->message($msg);
                					$this->email->send();
                				}catch(Exception $exc){}
                			}
                			$data['json'] = json_encode(array("status"=>"success","message"=>"Your request has been submitted successfully.","data"=>""));
                			$this->load->view('json_view', $data);
                		}else{
                			$data['json'] = json_encode(array("status"=>"error","message"=>"Appointment Not Created.","data"=>""));
                			$this->load->view('json_view', $data);
                		}
                			
                }
                return;
       
	}
	function getAppointment(){
		$config = array(
			array(
				'field' => 'appointmentId',
				'label' => 'Appointment Id',
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
			$app=$this->appointment_model->loadAppointment($this->input->post('appointmentId'));
			if($app){
				$dt['appointment']=$app;
				$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Details","data"=>$dt));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Appointment Not Found","data"=>""));
				$this->load->view('json_view', $data);
			}	
		}
		return;
	}
	
	function getAppointmentsByRequesterEmail(){
		$config = array(
			array(
				'field' => 'requesterEmail',
				'label' => 'Requester Email',
				'rules' => 'trim|required|valid_email',
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
			$app=$this->appointment_model->loadAppointmentsByEmail($this->input->post('requesterEmail'));
			if($app){
				$dt['appointment']=$app;
				$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Details","data"=>$dt));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Appointment Not Found","data"=>""));
				$this->load->view('json_view', $data);
			}	
		}
		return;
	}
	function getAppointmentsByCalendarId(){
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
			$app=$this->appointment_model->loadAppointmentsBycalId($this->input->post('calendarId'));
			if($app){
				$dt['appointment']=$app;
				$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Details","data"=>$dt));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Appointment Not Found","data"=>""));
				$this->load->view('json_view', $data);
			}
		}
		return;
	}
	function updateAppointment(){
		$config = array(
					array(
						'field' => 'appointmentId',
						'label' => 'Appointment Id',
						'rules' => 'trim|required',
					)
                );
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() === false){
                    $this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
                }else{ 
                	$this->load->helper('date');
                	$now = time();
                	
                	$appId=$this->input->post("appointmentId",true);
                	
                	$st=$this->input->post('start',true);
                	
                	$orgEmail=$this->appointment_model->findOrgAdminEmail($this->userID);
                	
                	if(isset($st) && $st){
                		$arr=explode(" ",$st);
                		if(count($arr)<2){
                			$data['json'] = json_encode(array("status"=>"error","message"=>array("Please provide a time.")));
                			$this->load->view('json_view', $data);
                			return;
                		}
                		$day=strtolower(date('l',strtotime($arr[0])));
                	}
                	$calId=$this->appointment_model->getCalendarIdByAppId($appId);
                	$workingPlans=$this->appointment_model->getSlots($calId);
                	
                	$slotGap=30;
                	if(isset($workingPlans) && $workingPlans && isset($day) && $day){
                		$workingPlans=json_decode($workingPlans[0]->value);
                		$slotGap=$workingPlans->$day->time_slots;
                	}
                	$now = now();
                	$minutes_to_add = $slotGap;
                	
                	$time = new DateTime($st);
                	$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                	$endTime = $time->format('Y-m-d H:i');
                	$title=$this->input->post('title',true);
          			$desc=$this->input->post('desc',true);
          			$name=$this->input->post('name',true);
          			$email=$this->input->post('email',true);
          				if(isset($title) && $title)
                			$data['app_title']		= $title;
          				if(isset($title) && $title)
                			$data['app_desc']	    = $desc;
                		if(isset($st) && $st)
                			$data['app_start']		= $st;
                		if(isset($endTime) && $endTime)
                			$data['app_end']	    = $endTime;
                		if(isset($name) && $name)
                			$data['applicant_name']	= $name;
                		if(isset($email) && $email)
                			$data['applicant_email']= $email;
                		
                		$data['org_id']			= $this->userOrgId;
                		$data['user_id']		= $calId;
                		
                		$updated = $this->appointment_model->updateAppointment($appId,$data);
                		
                		if($updated){
                			$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Updated Successfully.","data"=>""));
                			$this->load->view('json_view', $data);
                		}else{
                			$data['json'] = json_encode(array("status"=>"error","message"=>"Appointment Not Updated.","data"=>""));
                			$this->load->view('json_view', $data);
                		}
                			
                }
                return;
	}
	function declineAppointment(){
		$config = array(
			array(
				'field' => 'appointmentId',
				'label' => 'Appointment Id',
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
			$appId=$this->input->post('appointmentId',true);
			if(isset($appId) && $appId && !$this->appointment_model->validateAppointment($appId,$this->userOrgId)){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Appointment Not Found.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			$data['is_deleted'] = 1;
			$updateApp = $this->appointment_model->updateAppointment($appId,$data);
			if($updateApp){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Deleted.","data"=>""));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Appointment Not Deleted.","data"=>""));
				$this->load->view('json_view', $data);
			}
		}
		return;
	}
	function cancelAppointment(){
		$config = array(
				array(
						'field' => 'appointmentId',
						'label' => 'Appointment Id',
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
			$sentEmail= $this->input->post('isEmailSent',true);
			$isDeleted=$this->input->post('is_deleted',true);
			if(isset($isDeleted) && $isDeleted=="true"){
				$isDeleted=1;
			}else{
				$isDeleted=0;
			}
			if(isset($sentEmail) && $sentEmail=="true"){
				$sentEmail=true;
			}else{
				$sentEmail=false;
			}
			$data['rejectReason']=$this->input->post('reason',true);
			$data['isApproved']=0;
			$data['is_deleted']=$isDeleted;
			$app_id=$this->input->post('appointmentId',true);
			if(isset($app_id) && $app_id && !$this->appointment_model->validateAppointment($app_id,$this->userOrgId)){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Appointment Not Found.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			$reason = $this->appointment_model->updateAppointment($app_id,$data);
				
			$appDetails=$this->appointment_model->loadAppointmentWithDeleted($app_id);
	
			if($appDetails){
				$dt['logo']		= "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
				$dt['user_email']		= $appDetails[0]->applicant_email;
				$dt['reason']=$this->input->post('reason',true);
				$dt['AppointmentTitle']= $appDetails[0]->app_title;
				$dt['appDate']= $appDetails[0]->app_start;
					
				$this->load->library('email', $this->config->item('email_config'));
				$this->email->from('support@makkinfotech.biz', 'Scheduler');
					
				//send email to applicant
				if(isset($sentEmail) && $sentEmail){
					try{
						$this->email->subject($appDetails[0]->app_title.' - has been canceled');
						$this->email->to($appDetails[0]->applicant_email);
						$msg=$this->load->view('email/rejectRequest',$dt,TRUE);
						$this->email->message($msg);
						$this->email->send();
					}catch(Exception $exc){}
				}
					
				$userNotification=$this->appointment_model->loadUserNotifyData($this->userID);
					
				if(isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_cancellations) && $userNotification[0]->notify_on_cancellations==1){
					//send email to Organization Admin
					$orgEamil=$this->appointment_model->findOrgAdminEmail($this->userID);
					try{
						$this->email->subject($appDetails[0]->app_title.' has been canceled');
						$this->email->to($orgEamil[0]->email);
						$msg1=$this->load->view('email/rejectRequest',$dt,TRUE);
						$this->email->message($msg1);
						$this->email->send();
					}catch(Exception $exc){}
				}
					
				$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment canceled.","data"=>""));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to cancel appointment.","data"=>""));
				$this->load->view('json_view', $data);
			}
		}
		return;
	}
	
	function sendAppointmentReminder(){
		$config = array(
				array(
					'field' => 'appointmentId',
					'label' => 'Appointment Id',
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
			$app_id=$this->input->post('appointmentId',true);
			if(isset($app_id) && $app_id && !$this->appointment_model->validateAppointment($app_id,$this->userOrgId)){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Appointment Not Found.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			$app=$this->appointment_model->loadAppointment($app_id);
			$app=$app[0];
			
			$pageDetails=$this->appointment_model->getPageInfo($app->calendarId);
			$rNote=$this->appointment_model->getreminderNote($app->calendarId);
			$pageName="";
			if(isset($pageDetails) && $pageDetails && isset($pageDetails[0]->booking_url))$pageName=$pageDetails[0]->booking_url;
			
			$dt['logo']				= "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
			$dt['user_email']		= $app->applicant_email;
			$dt['appTitle']			= $app->app_title;
			$dt['bookingDate']		= $app->app_start;
			$dt['bookingPage']		= $pageName;
			$dt['reminderNote']		= $rNote;

			try{
				$this->load->library('email', $this->config->item('email_config'));
				$this->email->from('support@makkinfotech.biz', 'Scheduler');
				$this->email->to($app->applicant_email);
				$this->email->subject($app->app_title.' - Booking Reminder');
				$msg=$this->load->view('email/bookingReminder',$dt,TRUE);
				$this->email->message($msg);
				$this->email->send();
			}catch (Exception $e){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to send email.","data"=>""));
				$this->load->view('json_view', $data);
			}
			
			try{
				// send mail to cc email
				$ccEmail=$this->appointment_model->findOrgAdminEmail($app->calendarId);
				$ccAppReminders=$this->appointment_model->getUserNotification($app->calendarId);
				if(isset($ccAppReminders) && $ccAppReminders && $ccAppReminders[0]->cc_on_applicant_reminders==1){
					$this->load->library('email', $this->config->item('email_config'));
					$this->email->from('support@makkinfotech.biz', 'Scheduler');
					$this->email->to($ccEmail);
					$this->email->subject($app->app_title.' - Booking Reminder');
					$msg=$this->load->view('email/bookingReminder',$dt,TRUE);
					$this->email->message($msg);
					$this->email->send();
				}
			}catch (Exception $e){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to send email.","data"=>""));
				$this->load->view('json_view', $data);
			}
			$data['json'] = json_encode(array("status"=>"success","message"=>"Reminder Email sent successfully.","data"=>""));
			$this->load->view('json_view', $data);
		}
		return;
	}
	
}
