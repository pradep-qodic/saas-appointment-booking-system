<?php

class Appointments extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('appointment_model');
		$this->load->library('form_validation');
		$this->load->library('schedular_auth');
		$this->schedular_auth->_member_area_redirect();
		if($this->session->userdata('userid')){
			$this->UID=$this->session->userdata("userid");
			$this->UORGID=$this->session->userdata("userOrganizationID");
			$this->UORGURL=$this->session->userdata("userOrganizationURL");
		}
	}
	function index(){
		$this->load->model('admins/admin_model');
		$pageId=$this->input->post("pageId",true);
		if(isset($pageId) && $pageId || $pageId=="-1"){
			if($pageId=="-1"){
				$data['pendingApp']=$this->appointment_model->pendingApp($this->UORGID);
				$data['appointments']=$this->appointment_model->appointments($this->UORGID);
				$data ['pageList'] = $this->admin_model->loadResources($this->UORGID);
				$data['main_content'] = 'appointmentsPageTable';
				$d=$this->load->view('outputPage', $data,true);
				$this->output->set_output($d);
				return;
			}
			$data['pendingApp']=$this->appointment_model->pendingApp($this->UORGID);
			$data['appointments']=$this->appointment_model->pageAppointments($this->UORGID,$pageId);
			$data ['pageList'] = $this->admin_model->loadResources($this->UORGID);
			$data['main_content'] = 'appointmentsPageTable';
			$d=$this->load->view('outputPage', $data,true);
			$this->output->set_output($d);
		}else{
			$data['pendingApp']=$this->appointment_model->pendingApp($this->UORGID);
			$data['appointments']=$this->appointment_model->appointments($this->UORGID);
			$data ['pageList'] = $this->admin_model->loadResources($this->UORGID);
			$data['main_content'] = 'appointments';
			$this->load->view('page', $data);
		}
		return;
	}
	function appointmentsLog(){
        //appointments log
		$data['appointmentsLog']=$this->appointment_model->appointmentsLog($this->UORGID);
		$data['main_content'] = 'appointmentsLog';
		$this->load->view('page', $data);
		return;
	}
	function getAppInfo(){
        //get appointment information
		$id=$this->input->post('appId',true);
		if(isset($id) && $id){
			$dt['appInfo']=$this->appointment_model->loadAppointmentBasicInfo($id);
			$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Info.","data"=>$dt));
			$this->load->view('json_view', $data);
		}
		return;
	}
	function userAppointmentPage(){
        //load appointment page
		$id=$this->input->post('app_id',true);
		if(isset($id) && $id && $this->appointment_model->validateAppointment($id,$this->UORGID)){
			$appDT=$this->appointment_model->validateAppointment($id,$this->UORGID);
			$this->load->model("applicant/applicant_model");
			if(isset($appDT) && ($appDT[0]->isAutoBooking==1 || $appDT[0]->isApproved==1)){
				$data['isAutoBooking']=true;
				$data['allocatedApp']=$this->appointment_model->loadAllocatedAppointment($appDT[0]->app_id);
				$data['pageInfo']=$this->applicant_model->getPageInfo($appDT[0]->user_id);
			}elseif(isset($appDT) && $appDT[0]->isApproved==0){
				$data['rejected']=true;
				$data['pageInfo']=$this->applicant_model->getPageInfo($appDT[0]->user_id);
			}else{
				$data['loadUserSlots']=$this->_loadUserAvailableSlots($appDT[0]->app_start,$appDT[0]->user_id);
			}
			$data['appInfo']=$this->appointment_model->loadAppointment($id);
			$data['main_content'] = 'appointments/userAppointmentsPage';
			$this->load->view('page',$data);
			return;
		}else{
			$data['unAuthorizedEmail']="Not Valid Appointment.";
			$data['main_content'] = 'appointments/userAppointmentsPage';
			$this->load->view('page',$data);
			return;
		}
	}
	function userAppPage(){
        //load user appointment page
		$id=$this->input->post('app_id',true);
		if(isset($id) && $id && $this->appointment_model->validateAppointment($id,$this->UORGID)){
			$data['appInfo']=$this->appointment_model->loadAppointment($id);
			$data['main_content'] = 'appointments/userAppointmentsPage';
			$opt=$this->load->view('page',$data,true);
			$this->output->set_output($opt);
			return;
		}else{
			$data['unAuthorizedEmail']="Not Valid Appointment.";
			$data['main_content'] = 'appointments/userAppointmentsPage';
			$opt=$this->load->view('page',$data,true);
			$this->output->set_output($opt);
			return;
		}
	}
	function deleteAppointment(){
        // delete appointment
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		try{
			$appID=$this->input->post('appointmentID',true);
			if(isset($appID) && $appID){
				$validateOrgAppointment=$this->appointment_model->validateAppointment($appID,$this->UORGID);
				if(!$validateOrgAppointment){
					$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access'),"data"=>""));
					$this->load->view('json_view', $data);
					return;
				}
				$dt['is_deleted']=1;
				$deleteApp=$this->appointment_model->update($appID,$dt);
				if($deleteApp){
					$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Deleted Successfully.","data"=>""));
					$this->load->view('json_view', $data);
					return;
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to delete appointment.","data"=>""));
					$this->load->view('json_view', $data);
					return;
				}
				
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to delete appointment.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
		} catch(Exception $exc) {
				$data['json'] = json_encode(array("status"=>"error","message"=>array(
					'exceptions' => array(exceptionToJavaScript($exc))
				),"data"=>""));
				$this->load->view('json_view', $data);
				return;
		}
	}
	function markAsReadAppointment(){
        // mark as read appointment
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		try{
			$appRIDs=$this->input->post('appointmentReadIDs',true);
	
			$validateROrgAppointment=$this->appointment_model->validateAppointments($appRIDs,$this->UORGID);
			if(!$validateROrgAppointment){
				$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access'),"data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			
			$dt['is_viewed']=1;
			$isViewedApp=$this->appointment_model->updateAppointments($appRIDs,$dt);
			
			if($isViewedApp){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Changes Saved.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update appointment.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
		} catch(Exception $exc) {
				$data['json'] = json_encode(array("status"=>"error","message"=>array(
					'exceptions' => array(exceptionToJavaScript($exc))
				),"data"=>""));
				$this->load->view('json_view', $data);
				return;
		}
	}
	function markAsReadAppointments(){
        // mark as read multiple appointments
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		try{
			$appRIDs=$this->input->post('appointmentReadIDs',true);
			$appUIDs=$this->input->post('appointmentUnReadIDs',true);
	
			$validateROrgAppointment=$this->appointment_model->validateAppointments($appRIDs,$this->UORGID);
			if(!$validateROrgAppointment){
				$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access'),"data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			$validateUOrgAppointment=$this->appointment_model->validateAppointments($appUIDs,$this->UORGID);
			if(!$validateUOrgAppointment){
				$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access'),"data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			$dt['is_viewed']=1;
			$isViewedApp=$this->appointment_model->updateAppointments($appRIDs,$dt);
			$dt1['is_viewed']=0;
			$isUnViewedApp=$this->appointment_model->updateAppointments($appUIDs,$dt1);
			if($isViewedApp && $isUnViewedApp){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Changes Saved.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update appointment.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
		} catch(Exception $exc) {
				$data['json'] = json_encode(array("status"=>"error","message"=>array(
					'exceptions' => array(exceptionToJavaScript($exc))
				),"data"=>""));
				$this->load->view('json_view', $data);
				return;
		}
	}
	function loadAvailableUsers(){
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		 try{
				$orgID=$this->session->userdata("userOrganizationID");
				$inspTypeId=$this->input->post('inspectionTypeId',true);
				if(isset($inspTypeId) && $inspTypeId){
					$data['inspectionTypeName']=$this->appointment_model->getInspetionTypeName($inspTypeId);
					$data['availableUsers']=$this->appointment_model->getAllUsers($orgID,$inspTypeId);
					$data['json'] = json_encode(array("status"=>"success","message"=>"available users","data"=>$data));
					$this->load->view('json_view', $data);
					return;
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"please select inspection type.","data"=>""));
					$this->load->view('json_view', $data);
					return;
				}
				
			} catch(Exception $exc) {
				$data['json'] = json_encode(array("status"=>"error","message"=>array(
					'exceptions' => array(exceptionToJavaScript($exc))
				),"data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
	}
	public function _loadUserAvailableSlots($selected_date,$userID){
		$sDT = new DateTime($selected_date);
		$sDT->format('H:i');
		$sDate=explode(" ",$selected_date);
		$selected_date=$sDate[0];
		$day=strtolower(date('l',strtotime($selected_date)));
		$workingPlans=$this->appointment_model->getSlots($userID);
		$workingPlans=json_decode($workingPlans[0]->value);
		if(isset($workingPlans) && $workingPlans && isset($day) && $day && isset($workingPlans->$day->time_slots) && $workingPlans->$day->time_slots && isset($workingPlans->$day->start) && $workingPlans->$day->start && isset($workingPlans->$day->end) && $workingPlans->$day->end){
			$slotGap=$workingPlans->$day->time_slots;
			$start=$workingPlans->$day->start;
			$end=$workingPlans->$day->end;
			$empty_periods =array(array("start"=>$start,"end"=>$end,"slots"=>$slotGap));
			$available_hours = array();

			foreach ($empty_periods as $period) {
				$start_hour = new DateTime($selected_date . ' ' . $period['start']);
				$end_hour = new DateTime($selected_date . ' ' . $period['end']);
				$slt=$period['slots'];
				$minutes = $start_hour->format('i');
				$start_hour->setTime($start_hour->format('H'),$slt);
				$current_hour = $start_hour;
				$diff = $current_hour->diff($end_hour);

				while (($diff->h * 60 + $diff->i) >= intval($slt)) {
					$available_hours[] = $current_hour->format('H:i');
					$current_hour->add(new DateInterval("PT".$slt."M"));
					$diff = $current_hour->diff($end_hour);
				}
			}
			if (date('m/d/Y', strtotime($selected_date)) == date('m/d/Y')) {
				$book_advance_timeout = $slt;
				foreach($available_hours as $index => $value) {
					$available_hour = strtotime($value);
					$current_hour = strtotime('+' . $book_advance_timeout . ' minutes', strtotime('now'));
					if ($available_hour <= $current_hour) {
						unset($available_hours[$index]);
					}
				}
			}
			$available_hours = array_values($available_hours);
			sort($available_hours, SORT_STRING );
			$available_hours = array_values($available_hours);
			$loadAllocatedSlots=$this->appointment_model->loadAllocatedSlots($userID,$selected_date);
			$result=array_diff($available_hours,$loadAllocatedSlots);
			$result = array_values($result);
			sort($result, SORT_STRING );
			return $result;
		}else{
			return false;
		}
	}
	public function loadPageAvailableSlots() {
		$id=$this->input->post('app_id',true);
		if(isset($id) && $id){
			$appDT=$this->appointment_model->validateAppointment($id,$this->UORGID);
			if(isset($appDT) && $appDT){
				$this->load->model("applicant/applicant_model");
				$dt['loadAvailableSlots']=$this->_loadUserAvailableSlots($appDT[0]->app_start,$appDT[0]->user_id);
				$dt['allocateToUsetId']=$appDT[0]->user_id;
				$dt['allocatedOn']=$appDT[0]->app_start;
				$dt['appId']=$id;
				$data['json'] = json_encode(array("status"=>"success","message"=>"Available Slots.","data"=>$dt));
				$this->load->view('json_view', $data);
			}else{
				
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to load available slots.","data"=>""));
				$this->load->view('json_view', $data);
			}
			return;
		}else{
			$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to load available slots.","data"=>""));
			$this->load->view('json_view', $data);
			return;
		}
    }
	function allocateAppointment(){
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$appID=$this->input->post('app_id',true);
		$userID=$this->input->post('allocatedUserId',true);
		$allocatedOn=$this->input->post('allocatedOn',true);
		$this->load->helper('date');
		$now = time();
		$this->load->model("applicant/applicant_model");
		if(isset($appID) && $appID && isset($userID) && $userID && isset($allocatedOn) && $allocatedOn){
				$workingPlans=$this->applicant_model->getSlots($userID);
				$arr=explode(" ",$allocatedOn);
				$day=strtolower(date('l',strtotime($arr[0])));
				$slotGap=30;
				if(isset($workingPlans) && $workingPlans && isset($day) && $day){
					$workingPlans=json_decode($workingPlans[0]->value);
					$slotGap=$workingPlans->$day->time_slots;
				}
				$now = time();
				$minutes_to_add = $slotGap;

				$time = new DateTime($allocatedOn);
				$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
				$endTime = $time->format('Y-m-d H:i');
				
				$data['app_id']=$appID;
				$data['allocatedToUserId']=$userID;
				$data['allocatedDate']=$allocatedOn;
				$data['allocatedDateEnd']=$endTime;
				$data['allocatedByUserId']=$this->session->userdata("userid");
				$data['createdOn']=unix_to_human($now, TRUE, 'us');
				$allocate=$this->appointment_model->allocateAppointment($data);
				$appDetails=$this->appointment_model->loadAppointment($appID);
				
				$orgEamil=$this->applicant_model->findOrgAdminEmail($this->UID);
				if($allocate && $appDetails){
						$dt0['isApproved']=1;
						$this->appointment_model->update($appID,$dt0);
						$userDetail=$this->appointment_model->getUserDetail($userID);
						$dt['logo']				= "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
						$dt['user_email']		= $appDetails[0]->applicant_email;
						$dt['scheduleDate']		=$allocatedOn;
						$dt['inspectorName']	=$userDetail[0]->firstname." ".$userDetail[0]->lastname;
						$dt['inspectorEmail']	= $userDetail[0]->email;
						$dt['applicantName']	=$appDetails[0]->applicant_name;
						$dt['applicantEmail']	=$appDetails[0]->applicant_email;
						$dt['AppointmentTitle']	=$appDetails[0]->app_title;
						$dt['adminEmail']		= $orgEamil[0]->email;
						$this->load->library('email', $this->config->item('email_config'));
						$this->email->from('support@makkinfotech.biz', 'Schedular');
						//send email to applicant
						try{
							$this->email->subject($appDetails[0]->app_title.' - Scheduler confirmation');
							$this->email->to($appDetails[0]->applicant_email);
							$msg=$this->load->view('email/bookingConfirmed',$dt,TRUE);
							$this->email->message($msg);
							$this->email->send();
						}catch(Exception $exc){}
						
						$userNotification=$this->applicant_model->loadUserNotifyData($this->UORGID);
						if(isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking) && $userNotification[0]->notify_on_booking==1){
							//send email to Organization Admin
							try{
								$this->email->subject($appDetails[0]->app_title.' has made a booking');
								$this->email->to($orgEamil[0]->email);
								$msg1=$this->load->view('email/madeBooking',$dt,TRUE);
								$this->email->message($msg1);
								$this->email->send();
							}catch(Exception $exc){}
						}
						
						$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Allocated Successfully.","data"=>""));
						$this->load->view('json_view', $data);
						return;
				}
		}else{
			$data['json'] = json_encode(array("status"=>"error","message"=>"unable to allocate appointment","data"=>""));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function loadAppointments(){
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$dt['appointments']=$this->appointment_model->read($this->UORGID);
		$data['json'] = json_encode(array("status"=>"success","message"=>"appointments","data"=>$dt));
		$this->load->view('json_view', $data);
		return;
	}
	function loadPageAppointments(){
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$pageId=$this->input->post("pageId",true);
		if(isset($pageId) && $pageId){
			$dt['appointments']=$this->appointment_model->loadPageApps($this->UORGID,$pageId);
			$data['json'] = json_encode(array("status"=>"success","message"=>"appointments","data"=>$dt));
			$this->load->view('json_view', $data);
		}else{
			$dt['appointments']=array();
			$data['json'] = json_encode(array("status"=>"success","message"=>"appointments","data"=>$dt));
			$this->load->view('json_view', $data);
		}
		
		return;
	}
	function loadAppointmentTypes(){
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$dt['app_types']=$this->appointment_model->appointmentsTypes($this->UID);
		$data['json'] = json_encode(array("status"=>"success","message"=>"app_types","data"=>$dt));
		$this->load->view('json_view', $data);
		return;
	}
	function create(){
        if($_POST){
                $config = array(
                    array(
                        'field' => 'title',
                        'label' => 'Title',
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
                    $data['error'] = validation_errors();
					$data['main_content'] = 'appointments';
					$this->load->view('page', $data);
                }else{     
                    $data['app_title']		= $this->input->post('title',true);
                    $data['app_desc']	    = $this->input->post('desc',true);
                    $data['app_start']		= $this->input->post('start',true);
                    $data['app_end']	    = "";
                    $data['applicant_name']	= $this->input->post('name',true);
					$data['applicant_email']= $this->input->post('email',true);
                    $data['organization_id']= $this->input->post('org_id',true);
					$data['inspectionTypeId']=$this->input->post('insp_type_id',true);
                    $data['is_deleted']	    = 0;
                    $data['is_viewed']	    = 0;
					$data['app_timezone']	= "+05:50";
                    $create = $this->appointment_model->create($data);

                    if($create){
						$data['appointments'] = $this->appointment_model->read();
                        $data['main_content'] = 'appointments';
						$this->load->view('page', $data);
                    }else{
                        $data['error'] = "Appointment Not Created";
                        $data['main_content'] = 'appointments';
						$this->load->view('page', $data);
                    }
                }
                return;
        }
		$data['main_content'] = 'appointments';
		$this->load->view('page', $data);
    }
	function loadsessionAppData(){
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$data["sessionAppointments"]=$this->session->userdata("appointmentData");
		$data['json'] = json_encode(array("status"=>"success","message"=>"Appointments","data"=>$data));
		$this->load->view('json_view', $data);
	}
	function rejectAppointment(){
        // reject any appointment
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
               /*  $config = array(
                    array(
                        'field' => 'reason',
                        'label' => 'Reason',
                        'rules' => 'trim|required',
                    )
                );
                $this->form_validation->set_rules($config);
				$this->load->model("applicant/applicant_model");
                if($this->form_validation->run() === false){
                    $this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
                }else{     */  
					$this->load->model("applicant/applicant_model");

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
					$app_id=$this->input->post('app_id',true);
					if(!isset($app_id) || !$app_id){
						$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to reject appointment.","data"=>""));
						$this->load->view('json_view', $data);
						return;
					}
					
					
                    $reason = $this->appointment_model->update($app_id,$data);
                  
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
						
						$userNotification=$this->applicant_model->loadUserNotifyData($this->UID);
						
						if(isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_cancellations) && $userNotification[0]->notify_on_cancellations==1){
							//send email to Organization Admin
							$orgEamil=$this->applicant_model->findOrgAdminEmail($this->UID);
							try{
								$this->email->subject($appDetails[0]->app_title.' has been canceled');
								$this->email->to($orgEamil[0]->email);
								$msg1=$this->load->view('email/rejectRequest',$dt,TRUE);
								$this->email->message($msg1);
								$this->email->send();
							}catch(Exception $exc){}
						}
						
						$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Rejected.","data"=>""));
						$this->load->view('json_view', $data);
                    }else{
                        $data['json'] = json_encode(array("status"=>"error","message"=>"Unable to reject appointment.","data"=>""));
						$this->load->view('json_view', $data);
                    }
              /*   } */
                return;
        }
	}
	
}
