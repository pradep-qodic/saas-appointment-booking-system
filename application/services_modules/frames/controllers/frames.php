<?php

class Frames extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('frames_model');
		$this->load->library('form_validation');
		$this->load->library('basic401authentication');
		$this->userID=0;
		$this->userOrgId=0;
		$this->authToken="";
		if($this->session->userdata('userID')){
			$this->userID=$this->session->userdata('userID');
			$this->userOrgId=$this->session->userdata('userOrgId');
		}
		$d=$this->basic401authentication->require_login();
		if(isset($d) && $d){
			$this->userID=$d['userID'];
			$this->userOrgId=$d['userOrgId'];
			$this->authToken=$d['authToken'];
		}
		
		$this->load->helper('date');
		$this->load->model('appointments/appointment_model');
		
	}
	//function index(){}
	function loadAppointmentFrame($calId=''){
		/* $isAjax=$this->input->is_ajax_request();
			if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		} */		
		if(isset($calId) && $calId && $this->frames_model->validateCalendarId($calId,$this->userOrgId)){
			$appData=$this->frames_model->validateCalendarId($calId,$this->userOrgId);
			
			$isDisabled=$this->frames_model->isDisabled($calId);
			
			if($isDisabled){
				$data['pageDisabled']=true;
			}
			$data['pageId']=$calId;
			$file=$this->frames_model->loadBPageLogo($calId);
			if(isset($file) && $file)
				$data['PageLogo']=base_url1()."uploads/bookingPage/".$file."_thumb.jpg";	
		
			$data['authToken']=$this->authToken;
			$data['displayTimezone']=true;
			$data['pageInfo']=$this->frames_model->getPageInfo($calId);			
			$this->load->view('includes/sarvices_header', $data);
			$this->load->view('frames/appdashboardNew', $data);
			$this->load->view('includes/footer', $data);
			return;
		}else{
			$this->load->view('notFound');
		}
		return;
	}
	function loadMasterBookingPagePages(){
		$masterBPageId=$this->input->post("mCalId",true);
		if(isset($masterBPageId) && $masterBPageId){
			$bPages=$this->frames_model->getMasterPagePages($masterBPageId);
			$dt['bookingPages']=$bPages;
			$data['json'] = json_encode(array("status"=>"success","message"=>"Master Booking Pages","data"=>$dt));
			$this->load->view('json_viewHeaders', $data);
		}else{
			$data['json'] = json_encode(array("status"=>"success","message"=>"Master Booking Pages","data"=>array()));
			$this->load->view('json_viewHeaders', $data);
		}
		
	}
	function loadAdministrativeCalendar($calName=''){
		if(isset($calName) && $calName){
			$showAppointments=$this->input->get("showAppointments",true);
			$showAvailability=$this->input->get("showAvailability",true);
			$showUnavailability=$this->input->get("showUnavailability",true);
			$allowAppointmentEdit=$this->input->get("allowAppointmentEdit",true);
			$allowCancel=$this->input->get("allowCancel",true);
			$allowSetUnavailability=$this->input->get("allowSetUnavailability",true);
			$cData=$this->frames_model->validateCalendar($calName,$this->userOrgId);
			$cMData=$this->frames_model->validateMasterCalendar($calName,$this->userOrgId);
			$bPages=$this->frames_model->getAllBookingPages($this->userOrgId);
			if(isset($cData) && $cData){
				$data['showAppointments']=$showAppointments;
				$data['showAvailability']=$showAvailability;
				$data['showUnavailability']=$showUnavailability;
				$data['allowAppointmentEdit']=$allowAppointmentEdit;
				$data['allowCancel']=$allowCancel;
				$data['allowSetUnavailability']=$allowSetUnavailability;
				$data['bookingPages']=$bPages;
				$data['calId']=$cData[0]->org_user_id;
				$data['authToken']=$this->authToken;
				$data['main_content'] = 'frames/administrativeCal';
				$this->load->view('servicePage', $data);
			}elseif(isset($cMData) && $cMData){
				$data['showAppointments']=$showAppointments;
				$data['showAvailability']=$showAvailability;
				$data['showUnavailability']=$showUnavailability;
				$data['allowAppointmentEdit']=$allowAppointmentEdit;
				$data['allowCancel']=$allowCancel;
				$data['allowSetUnavailability']=$allowSetUnavailability;
				$data['bookingPages']=$bPages;
				$data['MasterCalId']=$cMData[0]->inspectionTypeId;
				$data['authToken']=$this->authToken;
				$data['main_content'] = 'frames/administrativeMasterCal';
				$this->load->view('servicePage', $data);
			}else{
				$this->load->view('notFound');
			}
		}else{
			$this->load->view('notFound');
		}
		return;
	}	
	function loadPageAppointments($status=''){
		$status=strtoupper($status);
		if($status=='CANCEL'){
			$status='0';
		}elseif($status=='CONFIRM'){
			$status='1';
		}elseif($status=='PENDING'){
			$status='3';
		}
		$pageId=$this->input->post("pageId",true);
		if(isset($pageId) && $pageId){
			$dt['appointments']=$this->appointment_model->loadPageApps($this->userOrgId,$pageId,$status);
			$data['json'] = json_encode(array("status"=>"success","message"=>"appointments","data"=>$dt));
			$this->load->view('json_viewHeaders', $data);
		}else{
			$dt['appointments']=array();
			$data['json'] = json_encode(array("status"=>"success","message"=>"appointments","data"=>$dt));
			$this->load->view('json_viewHeaders', $data);
		}
	
		return;
	}
	function loadMasterPageAppointments($status=''){
		$status=strtoupper($status);
		if($status=='CANCEL'){
			$status='0';
		}elseif($status=='CONFIRM'){
			$status='1';
		}elseif($status=='PENDING'){
			$status='3';
		}
		$pageId=$this->input->post("pageId",true);
		if(isset($pageId) && $pageId){
			$dt['appointments']=$this->appointment_model->loadMasterPageApps($this->userOrgId,$pageId,$status);
			$data['json'] = json_encode(array("status"=>"success","message"=>"appointments","data"=>$dt));
			$this->load->view('json_viewHeaders', $data);
		}else{
			$dt['appointments']=array();
			$data['json'] = json_encode(array("status"=>"success","message"=>"appointments","data"=>$dt));
			$this->load->view('json_viewHeaders', $data);
		}
	
		return;
	}
	function getAppointmentInfo(){
		$id=$this->input->post("appId",true);
		if(isset($id) && $id){
			$dt['appInfo']=$this->appointment_model->loadAppointment($id);
			$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Info","data"=>$dt));
			$this->load->view('json_viewHeaders', $data);
		}else{
			$dt['appInfo']=array();
			$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Info","data"=>$dt));
			$this->load->view('json_viewHeaders', $data);
		}
		return;
	}
	function loadAvailableUsers(){
		/* $isAjax=$this->input->is_ajax_request();
		if(!$isAjax || !isset($this->userID)){
			$this->load->view('notFoundForFrames');
			return;
		} */
		 try{
				$orgID=$this->session->userdata("userOrganizationID");
				$inspTypeId=$this->input->post('inspectionTypeId',true);
				if(isset($inspTypeId) && $inspTypeId){
					$data['inspectionTypeName']=$this->appointment_model->getInspetionTypeName($inspTypeId);
					$data['availableUsers']=$this->appointment_model->getAllUsers($orgID,$inspTypeId);
					$data['json'] = json_encode(array("status"=>"success","message"=>"available users","data"=>$data));
					$this->load->view('json_viewHeaders', $data);
					return;
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"please select inspection type.","data"=>$data));
					$this->load->view('json_viewHeaders', $data);
					return;
				}
				
			} catch(Exception $exc) {
				$data['json'] = json_encode(array("status"=>"error","message"=>array(
					'exceptions' => array(exceptionToJavaScript($exc))
				),"data"=>""));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
	}
	public function loadUserAvailableSlots() {
		/* $isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		} */
        try {
			$orgID=$this->session->userdata("userOrganizationID");
            $selected_date=$this->input->post("selected_date",true);
			$sDT = new DateTime($selected_date);
			$sDT->format('H:i');
			$userID=$this->input->post("user_id",true);
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
				$data['userAvailableSlots']=$result;
				$data['json'] = json_encode(array("status"=>"success","message"=>"","data"=>$data));
				$this->load->view('json_viewHeaders', $data);
				return;
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"There are no slots available for this day.","data"=>""));
				$this->load->view('json_viewHeaders', $data);
				return;
			}   
        } catch(Exception $exc) {
			$data['json'] = json_encode(array("status"=>"error","message"=>array(
                'exceptions' => array(exceptionToJavaScript($exc))
            ),"data"=>""));
			$this->load->view('json_viewHeaders', $data);
			return;
        }
    }
	function allocateAppointment(){
		/* $isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		} */
		$appID=$this->input->post('app_id',true);
		$userID=$this->input->post('allocatedUserId',true);
		$allocatedOn=$this->input->post('allocatedOn',true);
		$now = now();
		if(isset($appID) && $appID && isset($userID) && $userID && isset($allocatedOn) && $allocatedOn){
				$data['app_id']=$appID;
				$data['allocatedToUserId']=$userID;
				$data['allocatedDate']=$allocatedOn;
				$data['allocatedByUserId']=$this->userOrgId;
				$data['createdOn']=unix_to_human($now, TRUE, 'us');
				$allocate=$this->appointment_model->allocateAppointment($data);
				$appDetails=$this->appointment_model->loadAppointment($appID);
				if($allocate && $appDetails){
						$userDetail=$this->appointment_model->getUserDetail($userID);
						$dt['logo']				="http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
						$dt['user_email']		=$appDetails[0]->applicant_email;
						$dt['scheduleDate']		=$appDetails[0]->app_start;
						$dt['inspectorName']	=$userDetail[0]->firstname." ".$userDetail[0]->lastname;
						$dt['inspectorEmail']	=$userDetail[0]->email;
						$dt['applicantName']	=$userDetail[0]->firstname." ".$userDetail[0]->lastname;
						$dt['applicantEmail']	=$userDetail[0]->email;
						$dt['AppointmentTitle']	=$appDetails[0]->app_title;
						$this->load->library('email', $this->config->item('email_config'));
						$this->email->from('support@makkinfotech.biz', 'Scheduler');
						$this->email->subject('Appointment Request');
						//send email to applicant
						try{
							$this->email->to($appDetails[0]->applicant_email);
							$msg=$this->load->view('email/bookingConfirmed',$dt,TRUE);
							$this->email->message($msg);
							$this->email->send();
						}catch(Exception $exc){}
						
						//send email to inspectorEmail
						try{
							$this->email->to($userDetail[0]->email);
							$msg1=$this->load->view('email/madeBooking',$dt,TRUE);
							$this->email->message($msg1);
							$this->email->send();
						}catch(Exception $exc){}
						$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Allocated Successfully.","data"=>""));
						$this->load->view('json_viewHeaders', $data);
						return;
				}
		}else{
			$data['json'] = json_encode(array("status"=>"error","message"=>"unable to allocate appointment","data"=>""));
			$this->load->view('json_viewHeaders', $data);
			return;
		}
	}
	function loadAppointments(){
		/* $isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		} */
		$dt['appointments']=$this->appointment_model->read($this->userOrgId);
		$data['json'] = json_encode(array("status"=>"success","message"=>"appointments","data"=>$dt));
		$this->load->view('json_viewHeaders', $data);
		return;
	}
	function loadAppointmentTypes(){
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		}
		$dt['app_types']=$this->frames_model->appointmentsTypes($this->userOrgId);
		$data['json'] = json_encode(array("status"=>"success","message"=>"app_types","data"=>$dt));
		$this->load->view('json_viewHeaders', $data);
		return;
	}	
	function setTimeZone(){
		/* $isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		} */
		/* $d=$this->basic401authentication->require_login();
		$this->userID=$d['userID'];
		$this->userOrgId=$d['userOrgId']; */
		$timezoneInput=$this->input->post("timezone",true);
		if(isset($timezoneInput) && $timezoneInput){
			$data["timezone"]=$timezoneInput;
			$data["timezoneText"]=$this->input->post("timezoneText",true);
			$data['json'] = json_encode(array("status"=>"success","message"=>"","data"=>$data));
			$this->load->view('json_viewHeaders', $data);
		}else{
			$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to set timezone","data"=>""));
			$this->load->view('json_viewHeaders', $data);
		}
		return;
	}
	function loadsessionAppData(){
		/* $isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		} */
		$data["sessionAppointments"]=$this->session->userdata("appointmentData");
		$data['json'] = json_encode(array("status"=>"success","message"=>"","data"=>$data));
		$this->load->view('json_viewHeaders', $data);
	}
	function loadholidaysData(){
		/* $isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		} */
		
		/* $d=$this->basic401authentication->require_login();
		$this->userID=$d['userID'];
		$this->userOrgId=$d['userOrgId']; */
		$id=$this->input->post("pageId",true);
		if(isset($id) && $id){
			$data['org_id']=$this->userOrgId;
			$data['holidays']=$this->frames_model->loadHolidaysData($this->userOrgId,$id);
			$data['json'] = json_encode(array("status"=>"success","message"=>"Holidays","data"=>$data));
			$this->load->view('json_viewHeaders', $data);
		}else{
			$data['json'] = json_encode(array("status"=>"success","message"=>"Holidays","data"=>""));
			$this->load->view('json_viewHeaders', $data);
		}
		
		return;
	}
	function loadMasterholidaysData(){
		/* $isAjax=$this->input->is_ajax_request();
			if(!$isAjax){
		$this->load->view('notFoundForFrames');
		return;
		} */
	
		/* $d=$this->basic401authentication->require_login();
			$this->userID=$d['userID'];
		$this->userOrgId=$d['userOrgId']; */
		$data['org_id']=$this->userOrgId;
		$data['holidays']=$this->frames_model->loadMasterHolidaysData($this->userOrgId);
		$data['json'] = json_encode(array("status"=>"success","message"=>"Holidays","data"=>$data));
		$this->load->view('json_viewHeaders', $data);
	
		return;
	}
	function _loadUserWorkingPlan($DT,$uid){
		
		if(isset($uid) && $uid && isset($DT) && $DT){
			$workingPlan=array();
			$workingPlanArray=array();
			$res=$this->frames_model->loadUserWorkingPlan($uid);
			$res=$res[0]->userWorkingPlan;
			if($res){
				$workingPlan=json_decode($res);
				foreach($workingPlan as $key => $value)
				{
					foreach($value as $key1 => $value1)
					{
					  if($key1==$DT){
						$workingPlanArray=array("wDate"=>$DT,"start"=>$value->$key1->start,"end"=>$value->$key1->end);
					  }
					}
				}
				return $workingPlanArray;
			}else{
				return false;
			}
			
		}else{
			return false;
		}	
	}
	public function loadTimeSlots() {
		/* $isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		} */
        try {
        	/* $d=$this->basic401authentication->require_login();
        	$this->userID=$d['userID'];
        	$this->userOrgId=$d['userOrgId']; */
			if(isset($this->resourceId) && $this->resourceId){
				$bPageId=$this->resourceId;
			}else{
				$bPageId=$this->input->post('pageId',true);
			}
			if(!$bPageId){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to get time slots.","data"=>""));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
			$selected_date=$this->input->post("selected_date",true);
			$timezone=$this->input->post("timezone",true);
			$availableDate=date("D, M d, Y",strtotime($selected_date));
			$isHoliDy=$this->frames_model->isHoliday($selected_date,$this->userOrgId,$bPageId);
			if($isHoliDy){
				$dt['slots']=array();
				$dt['availability']="";
				$dt['selectedDate']="";
				$data['json'] = json_encode(array("status"=>"error","message"=>"There are no slots available for this day. Please choose another day for appointment.","data"=>$dt));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
			$day=strtolower(date('l',strtotime($selected_date)));
			$workingPlans=$this->frames_model->getSlots($bPageId);
			if(isset($workingPlans) && $workingPlans && isset($day) && $day){
				$workingPlans=json_decode($workingPlans[0]->value);
				if(!$workingPlans->$day){
					$dt['slots']=array();
					$dt['availability']="";
					$dt['selectedDate']="";
					$data['json'] = json_encode(array("status"=>"error","message"=>"There are no slots available for this day. Please choose another day for appointment.","data"=>$dt));
					$this->load->view('json_viewHeaders', $data);
					return;
				}
				$slotGap=$workingPlans->$day->time_slots;
				$start=$workingPlans->$day->start;
				$end=$workingPlans->$day->end;
				$empty_periods =array(array("start"=>$start,"end"=>$end,"slots"=>$slotGap));
				
				$uWorkPlan=$this->_loadUserWorkingPlan($selected_date,$bPageId);
			
				if($uWorkPlan){
					$start=$uWorkPlan['start'];
					$end=$uWorkPlan['end'];
					$empty_periods =array(array("start"=>$start,"end"=>$end,"slots"=>$slotGap));
				}
				
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
				
				$curUnix=gmt_to_local(now(),$timezone,false);
				//echo date('m/d/Y', strtotime($selected_date))." and ".strtotime('now')." and ".unix_to_human($curUnix);
				if (date('m/d/Y', strtotime($selected_date)) == date('m/d/Y')) {
					$book_advance_timeout = $slt;
					foreach($available_hours as $index => $value) {
						$available_hour = strtotime($value);
						$current_hour = strtotime('+' . $book_advance_timeout . ' minutes', $curUnix);
						if ($available_hour <= $current_hour) {
							unset($available_hours[$index]);
						}
					}
				}
				
				$loadAllocatedSlots=$this->appointment_model->loadAllocatedSlots($bPageId,$selected_date,$slotGap,$timezone);
				
				if($available_hours){
					$available_hours = array_values($available_hours);
					sort($available_hours, SORT_STRING );
					$available_hours = array_values($available_hours);
					
					$result=array_diff($available_hours,$loadAllocatedSlots);
					$result = array_values($result);
					sort($result, SORT_STRING );
				}else{
					$result=array();
				}
				
				$dt['slots']=$result;
				$dt['availability']=$availableDate;
				$dt['selectedDate']=$selected_date;
				$data['json'] = json_encode(array("status"=>"success","message"=>"Slots","data"=>$dt));
				$this->load->view('json_viewHeaders', $data);
				return;
			}else{
				$dt['slots']=array();
				$dt['availability']="";
				$dt['selectedDate']="";
				$data['json'] = json_encode(array("status"=>"error","message"=>"There are no slots available for this day. Please choose another day for appointment.","data"=>$dt));
				$this->load->view('json_viewHeaders', $data);
				return;
			}   
        } catch(Exception $exc) {
			$data['json'] = json_encode(array("status"=>"error","message"=>array(
                'exceptions' => $exc
            ),"data"=>""));
			$this->load->view('json_viewHeaders', $data);
			return;
        }
    }
	public function loadUsersNotWorkingDays() {
		/* $isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		} */
        try {
	        	/* $d=$this->basic401authentication->require_login();
	        	$this->userID=$d['userID'];
	        	$this->userOrgId=$d['userOrgId']; */
				$appTypeId=$this->input->post("pageId",true);
				$notWorkingDates=$this->frames_model->loadUserNotWorkingDays($appTypeId);
				if(is_array($notWorkingDates)){
					$dt['notWorkingDays']=$notWorkingDates;//array(array("title"=>"Not Working","start"=>"2014-11-07"),array("title"=>"Not Working","start"=>"2014-11-11"));
					$data['json'] = json_encode(array("status"=>"success","message"=>"notWorkingDays","data"=>$dt));
					$this->load->view('json_viewHeaders', $data);
				}else{
					$dt['notWorkingDays']=$notWorkingDates;
					$data['json'] = json_encode(array("status"=>"error","message"=>"unable to find not working days","data"=>""));
					$this->load->view('json_viewHeaders', $data);
				}
				return;
			
        } catch(Exception $exc) {
			$data['json'] = json_encode(array("status"=>"error","message"=>array(
                'exceptions' => array(exceptionToJavaScript($exc))
            ),"data"=>""));
			$this->load->view('json_viewHeaders', $data);
			return;
        }
    }
	public function loadPageNotWorkingDays() {
		/* $isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		} */
        try {
	        	/* $d=$this->basic401authentication->require_login();
	        	$this->userID=$d['userID'];
	        	$this->userOrgId=$d['userOrgId']; */
				if(!isset($this->resourceId) || !$this->resourceId){
					$this->resourceId=$this->input->post("pageId",true);
				}
				if($this->resourceId){
					$notWorkingDates=$this->frames_model->loadPageNotWorkingDays($this->resourceId);
					if($notWorkingDates){
						$dt['notWorkingDays']=$notWorkingDates;
						$data['json'] = json_encode(array("status"=>"success","message"=>"notWorkingDays","data"=>$dt));
						$this->load->view('json_viewHeaders', $data);
					}else{
						$dt['notWorkingDays']=$notWorkingDates;
						$data['json'] = json_encode(array("status"=>"error","message"=>"unable to find not working days","data"=>""));
						$this->load->view('json_viewHeaders', $data);
					}
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"unable to find not working days","data"=>""));
					$this->load->view('json_viewHeaders', $data);
				}
				return;
			
        } catch(Exception $exc) {
			$data['json'] = json_encode(array("status"=>"error","message"=>array(
                'exceptions' => array(exceptionToJavaScript($exc))
            ),"data"=>""));
			$this->load->view('json_viewHeaders', $data);
			return;
        }
    }
	function createAppointment(){
		/* $isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFoundForFrames');
			return;
		} */
		/* $d=$this->basic401authentication->require_login();
		$this->userID=$d['userID'];
		$this->userOrgId=$d['userOrgId']; */
        if($_POST){
                $config = array(
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
                    $this->form_validation->set_error_delimiters('<br />', '');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_viewHeaders', $data);
                }else{ 
                	$appId=$this->input->post("appId",true);
                	$sendNotif=$this->input->post("sendNotif",true);
                	if(isset($this->resourceId) && $this->resourceId){
                		$this->resourceId=$this->resourceId;
                	}else{
                		$this->resourceId=$this->input->post("pageId",true);
                	}
                	if(!$this->resourceId){
                		$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to create appointment.","data"=>""));
                		$this->load->view('json_viewHeaders', $data);
                		return;
                	}
                	$st=$this->input->post('start',true);
                	$orgEmail=$this->frames_model->findOrgAdminEmail($this->userID);
                	$arr=explode(" ",$st);
                	if(count($arr)<2){
                		$data['json'] = json_encode(array("status"=>"error","message"=>array("Please select a time.")));
                		$this->load->view('json_viewHeaders', $data);
                		return;
                	}
                	$workingPlans=$this->frames_model->getSlots($this->resourceId);
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
                	 
                	$isAuto=$this->frames_model->getBookingPageSetting($this->resourceId);
                	if(isset($isAuto) && $isAuto==1){
                		$data['isAutoBooking'] = 1;
                		$data['isApproved']	   = 1;
                	}else{
                		$data['isAutoBooking'] = 0;
                	}
                	if(isset($appId) && $appId){
                		
                		$data['app_title']		= $this->input->post('title',true);
                		$data['app_desc']	    = $this->input->post('desc',true);
                		$data['app_start']		= $st;
                		$data['app_end']	    = $endTime;
                		$data['applicant_name']	= $this->input->post('name',true);
                		$data['applicant_email']= $this->input->post('email',true);
                		$data['org_id']			= $this->userOrgId;
                		$data['user_id']		= $this->resourceId;
                		$data['is_deleted']	    = 0;
                		$data['is_viewed']	    = 0;
                		$data['isApproved']		= 2;
                		$data['rescheduled_appid']= $appId;
                		$data['applicant_phone']= $this->input->post('phone',true);
                		$data['applicant_location']= $this->input->post('location',true);
                		$data['app_timezone']	= $this->input->post("timezone",true);
                		$data['appointmentCreatedOn']	= unix_to_human($now, TRUE, 'us');
                		$create_id = $this->frames_model->createAppointment($data);
                		
                		$this->load->library('email', $this->config->item('email_config'));
                		$appDetails=$this->appointment_model->loadAppointment($create_id);
                		$userDetail=$this->appointment_model->getUserDetail($this->resourceId);
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
                				if(isset($sendNotif) && $sendNotif=='1'){
                					$this->email->subject($appDetails[0]->app_title.' - Scheduler confirmation');
                					$this->email->to($appDetails[0]->applicant_email);
                					$msg=$this->load->view('email/bookingConfirmed',$dt0,TRUE);
                					$this->email->message($msg);
                					$this->email->send();
                				}
                				
                			}catch(Exception $exc){}
                			$userNotification=$this->frames_model->loadUserNotifyData($this->resourceId);
                			if(isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking) && $userNotification[0]->notify_on_booking==1){
                				//send email to Organization Admin
                				try{
                					$this->email->subject($appDetails[0]->app_title.' has made a booking');
                					$this->email->to($orgEmail[0]->email);
                					$msg1=$this->load->view('email/rescheduledConfirmed',$dt0,TRUE);
                					$this->email->message($msg1);
                					$this->email->send();
                				}catch(Exception $exc){}
                			}
                			$resTime=($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
                			$resUrl=($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
                			$dt1['app_id']=$create_id;
                			$dt1['allocatedToUserId']=$this->resourceId;
                			$dt1['allocatedDate']=$st;
                			$dt1['allocatedDateEnd']=$endTime;
                			$dt1['allocatedByUserId']=$this->userID;
                			$dt1['createdOn']=unix_to_human($now, TRUE, 'us');
                			$allocate=$this->appointment_model->allocateAppointment($dt1);
                			$data['json'] = json_encode(array("status"=>"success","message"=>"Your Appointment Scheduled Successfully..","data"=>array("redirectionTime"=>$resTime,"redirectionUrl"=>$resUrl,"appointmentId"=>$create_id)));
                			$this->load->view('json_viewHeaders', $data);
                		}elseif($create_id && $isAuto==0){
                			//send email to applicant
                			try{
                				if(isset($sendNotif) && $sendNotif=='1'){
	                				$this->email->subject("Your booking request has been submitted");
	                				$this->email->to($appDetails[0]->applicant_email);
	                				$msg1=$this->load->view('email/madeBookingRequest',$dt0,TRUE);
	                				$this->email->message($msg1);
	                				$this->email->send();
                				}
                			}catch(Exception $exc){}
                			$userNotification=$this->frames_model->loadUserNotifyData($this->resourceId);
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
                			$resTime=($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
                			$resUrl=($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
                			$data['json'] = json_encode(array("status"=>"success","message"=>"Your request has been submitted successfully.","data"=>array("redirectionTime"=>$resTime,"redirectionUrl"=>$resUrl,"appointmentId"=>$create_id)));
                			$this->load->view('json_viewHeaders', $data);
                		}else{
                			$data['json'] = json_encode(array("status"=>"error","message"=>"Appointment Not Created.","data"=>""));
                			$this->load->view('json_viewHeaders', $data);
                		}
                	}else{
                		
                		$data['app_title']		= $this->input->post('title',true);
                		$data['app_desc']	    = $this->input->post('desc',true);
                		$data['app_start']		= $st;
                		$data['app_end']	    = $endTime;
                		$data['applicant_name']	= $this->input->post('name',true);
                		$data['applicant_email']= $this->input->post('email',true);
                		$data['org_id']			= $this->userOrgId;
                		$data['user_id']		= $this->resourceId;
                		$data['is_deleted']	    = 0;
                		$data['is_viewed']	    = 0;
                		$data['app_timezone']	= $this->input->post("timezone",true);
                		$data['applicant_phone']= $this->input->post('phone',true);
                		$data['applicant_location']= $this->input->post('location',true);
                		$data['appointmentCreatedOn']	= unix_to_human($now, TRUE, 'us');
                		$create_id = $this->frames_model->createAppointment($data);
                		
                		$this->load->library('email', $this->config->item('email_config'));
                		$appDetails=$this->appointment_model->loadAppointment($create_id);
                		$userDetail=$this->appointment_model->getUserDetail($this->resourceId);
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
                			$userNotification=$this->frames_model->loadUserNotifyData($this->resourceId);
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
                			$resTime=($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
                			$resUrl=($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
                			$dt1['app_id']=$create_id;
                			$dt1['allocatedToUserId']=$this->resourceId;
                			$dt1['allocatedDate']=$st;
                			$dt1['allocatedDateEnd']=$endTime;
                			$dt1['allocatedByUserId']=$this->userID;
                			$dt1['createdOn']=unix_to_human($now, TRUE, 'us');
                			$allocate=$this->appointment_model->allocateAppointment($dt1);
                			$data['json'] = json_encode(array("status"=>"success","message"=>"Your Appointment Scheduled Successfully..","data"=>array("redirectionTime"=>$resTime,"redirectionUrl"=>$resUrl,"appointmentId"=>$create_id)));
                			$this->load->view('json_viewHeaders', $data);
                		}elseif($create_id && $isAuto==0){
                			//send email to applicant
                			try{
                				$this->email->subject("Your booking request has been submitted");
                				$this->email->to($appDetails[0]->applicant_email);
                				$msg1=$this->load->view('email/madeBookingRequest',$dt0,TRUE);
                				$this->email->message($msg1);
                				$this->email->send();
                			}catch(Exception $exc){}
                			$userNotification=$this->frames_model->loadUserNotifyData($this->resourceId);
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
                			$resTime=($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
                			$resUrl=($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
                			$data['json'] = json_encode(array("status"=>"success","message"=>"Your request has been submitted successfully.","data"=>array("redirectionTime"=>$resTime,"redirectionUrl"=>$resUrl,"appointmentId"=>$create_id)));
                			$this->load->view('json_viewHeaders', $data);
                		}else{
                			$data['json'] = json_encode(array("status"=>"error","message"=>"Appointment Not Created.","data"=>""));
                			$this->load->view('json_viewHeaders', $data);
                		}
                			
                	}
                }
                return;
        }
    }
	function addHoliday(){
		if($_POST){
			/* $pageId=$this->input->post("hpageId",true);
			if(!isset($pageId) || !$pageId){
				$pageId=0;
			} */
			$pageId=0;
			$sDate=date('Y-m-d', strtotime($this->input->post('date',true)));
			if($this->frames_model->validateAvailability($pageId,$this->userOrgId,$sDate)){
				$data['json'] = json_encode(array("status"=>"success","message"=>" Already set as holiday."));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
			$this->load->helper('date');
			$now = time();
			$udata['title']			= ($this->input->post('title',true))?$this->input->post('title',true):'';
			$udata['startdate']		= $sDate;
			$udata['enddate']		= date('Y-m-d', strtotime($this->input->post('date',true)));
			$udata['status']		= 1;
			$udata['createdOn']		= unix_to_human($now, TRUE, 'us');
			$udata['org_id']		= $this->userOrgId;
			$udata['page_id']		= $pageId;
			$u_id=$this->frames_model->createHoliday($udata);
			if($u_id){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Holiday Created Successfully."));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
		}
	}
	function markUnavailable(){
		if($_POST){
			$pageId=$this->input->post("hpageId",true);
			if(!isset($pageId) || !$pageId){
				$pageId=0;
			}
			$sDate=date('Y-m-d', strtotime($this->input->post('date',true)));
			if($this->frames_model->validateAvailability($pageId,$this->userOrgId,$sDate)){
				$data['json'] = json_encode(array("status"=>"success","message"=>" Already Mark Unavailable."));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
			$this->load->helper('date');
			$now = time();
			$udata['title']			= ($this->input->post('title',true))?$this->input->post('title',true):'';
			$udata['startdate']		= $sDate;
			$udata['enddate']		= date('Y-m-d', strtotime($this->input->post('date',true)));
			$udata['status']		= 1;
			$udata['createdOn']		= unix_to_human($now, TRUE, 'us');
			$udata['org_id']		= $this->userOrgId;
			$udata['page_id']		= $pageId;
			$u_id=$this->frames_model->createHoliday($udata);
			if($u_id){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Mark Unavailable Successfully."));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
		}
	}
	function markAvailable(){
		if($_POST){
			$hID=$this->input->post('hId',true);
			if(isset($hID) && $hID && !$this->frames_model->validateHoliday($hID,$this->userOrgId)){
				$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
			$dt['isDeleted'] = 1;
			$dHoliday=$this->frames_model->updateHoliday($hID,$dt);
			if($dHoliday){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Mark As Available Successfully."));
				$this->load->view('json_viewHeaders', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to Delete."));
				$this->load->view('json_viewHeaders', $data);
			}
			return;
		}
	}
	
	function removeHoliday(){
		if($_POST){
			$hID=$this->input->post('hId',true);
			if(isset($hID) && $hID && !$this->frames_model->validateHoliday($hID,$this->userOrgId)){
				$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
			$dt['isDeleted'] = 1;
			$dHoliday=$this->frames_model->updateHoliday($hID,$dt);
			if($dHoliday){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Holiday Deleted Successfully."));
				$this->load->view('json_viewHeaders', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to Delete Holiday."));
				$this->load->view('json_viewHeaders', $data);
			}
			return;
		}	
	}
	function _rejectAppointment($app_id,$sentEmail,$resTime,$resUrl){
			$data['isApproved']=0;
			if(!isset($app_id) || !$app_id){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to reject appointment.","data"=>""));
				$this->load->view('json_viewHeaders', $data);
				return;
			}
					
			$reason = $this->frames_model->update($app_id,$data);
	
			$appDetails=$this->frames_model->loadAppointmentWithDeleted($app_id);
				
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
	
				$userNotification=$this->frames_model->loadUserNotifyData($this->userID);
	
				if(isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_cancellations) && $userNotification[0]->notify_on_cancellations==1){
					//send email to Organization Admin
					$orgEamil=$this->frames_model->findOrgAdminEmail($this->userID);
					try{
						$this->email->subject($appDetails[0]->app_title.' has been canceled');
						$this->email->to($orgEamil[0]->email);
						$msg1=$this->load->view('email/rejectRequest',$dt,TRUE);
						$this->email->message($msg1);
						$this->email->send();
					}catch(Exception $exc){}
				}
	
				$data['json'] = json_encode(array("status"=>"success","message"=>"Updated successfully.","data"=>array("redirectionTime"=>$resTime,"redirectionUrl"=>$resUrl,"appointmentId"=>$app_id)));
				$this->load->view('json_viewHeaders', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to reject appointment.","data"=>""));
				$this->load->view('json_viewHeaders', $data);
			}
			return;
	}
	function cancelAppointment(){
		$userDetail=$this->frames_model->getUserDetail($this->input->post("pageId",true));
		$resTime=($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
		$resUrl=($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
		$app_id=$this->input->post("appId",true);
		$sentEmail=$this->input->post("sendNotif",true);
		$this->_rejectAppointment($app_id, $sentEmail, $resTime, $resUrl);
		
	}
	function updateAppointment(){
		if($_POST){
			$config = array(
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
				$this->form_validation->set_error_delimiters('<br />', '');
				$arrV[]=validation_errors();
				$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
				$this->load->view('json_viewHeaders', $data);
			}else{
				$appId=$this->input->post("appId",true);
				
				$sendNotif=$this->input->post("sendNotif",true);
				$appStatus=$this->input->post("appStatus",true);
				if(isset($this->resourceId) && $this->resourceId){
					$this->resourceId=$this->resourceId;
				}else{
					$this->resourceId=$this->input->post("pageId",true);
				}
				if(isset($appId) && $appId){
					$st=$this->input->post('start',true);
					$orgEmail=$this->frames_model->findOrgAdminEmail($this->userID);
					$arr=explode(" ",$st);
					if(count($arr)<2){
						$data['json'] = json_encode(array("status"=>"error","message"=>array("Please select a time.")));
						$this->load->view('json_viewHeaders', $data);
						return;
					}
					$slotGap='00:30';
					/*$workingPlans=$this->frames_model->getSlots($this->resourceId);
					$day=strtolower(date('l',strtotime($arr[0])));
					 if(isset($workingPlans) && $workingPlans && isset($day) && $day){
						$workingPlans=json_decode($workingPlans[0]->value);
						$slotGap=$workingPlans->$day->time_slots;
					} */
					$slotGap=$this->input->post("duration",true);
					$sltVal=explode(":",$slotGap);
					$now = now();
					$hours_to_add = $sltVal[0];
					$minutes_to_add = $sltVal[1];
					
					$time = new DateTime($st);
					$time->add(new DateInterval('PT' . $hours_to_add . 'H'));
					$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
					$endTime = $time->format('Y-m-d H:i');
					
					
					$isAuto=$this->frames_model->getBookingPageSetting($this->resourceId);
					if(isset($isAuto) && $isAuto==1){
						$data['isAutoBooking'] = 1;
						$data['isApproved']	   = 1;
					}else{
						$data['isAutoBooking'] = 0;
					}
					
					$data['app_title']		= $this->input->post('title',true);
					$data['app_desc']	    = $this->input->post('desc',true);
					$data['app_start']		= $st;
					$data['app_end']	    = $endTime;
					$data['applicant_name']	= $this->input->post('name',true);
					$data['applicant_email']= $this->input->post('email',true);
					$data['org_id']			= $this->userOrgId;
					$data['user_id']		= $this->resourceId;
					$data['is_deleted']	    = 0;
					$data['is_viewed']	    = 0;
					$data['isApproved']		= $appStatus;
					$data['applicant_phone']= $this->input->post('phone',true);
					$data['applicant_location']= $this->input->post('location',true);
					$data['app_timezone']	= $this->input->post("timezone",true);
					$data['appointmentCreatedOn']	= unix_to_human($now, TRUE, 'us');
					$create_id = $this->frames_model->updateAppointment($appId,$data);
				
					$this->load->library('email', $this->config->item('email_config'));
					$appDetails=$this->frames_model->loadAppointment($appId);
					$userDetail=$this->frames_model->getUserDetail($this->resourceId);
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
				
					$resTime=($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
					$resUrl=($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
					
					if($appStatus ==1){
						$dt1['allocatedDate']=$st;
						$dt1['allocatedDateEnd']=$endTime;
						$allocate=$this->frames_model->updateAllocatedApp($appId,$dt1);
					}
					if($create_id && $appStatus==1){
						//send email to applicant
						try{
							if(isset($sendNotif) && $sendNotif=='1'){
								$this->email->subject($appDetails[0]->app_title.' - Scheduler confirmation');
								$this->email->to($appDetails[0]->applicant_email);
								$msg=$this->load->view('email/bookingConfirmed',$dt0,TRUE);
								$this->email->message($msg);
								$this->email->send();
							}
				
						}catch(Exception $exc){}
						$userNotification=$this->frames_model->loadUserNotifyData($this->resourceId);
						if(isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking) && $userNotification[0]->notify_on_booking==1){
							//send email to Organization Admin
							try{
								$this->email->subject($appDetails[0]->app_title.' has made a booking');
								$this->email->to($orgEmail[0]->email);
								$msg1=$this->load->view('email/rescheduledConfirmed',$dt0,TRUE);
								$this->email->message($msg1);
								$this->email->send();
							}catch(Exception $exc){}
						}
						
						$dt1['app_id']=$appId;
						$dt1['allocatedToUserId']=$this->resourceId;
						$dt1['allocatedDate']=$st;
						$dt1['allocatedDateEnd']=$endTime;
						$dt1['allocatedByUserId']=$this->userID;
						$dt1['createdOn']=unix_to_human($now, TRUE, 'us');
						$allocate=$this->appointment_model->allocateAppointment($dt1);
						$data['json'] = json_encode(array("status"=>"success","message"=>"Updated successfully.","data"=>array("redirectionTime"=>$resTime,"redirectionUrl"=>$resUrl,"appointmentId"=>$create_id)));
						$this->load->view('json_viewHeaders', $data);
					}elseif($create_id && $appStatus==3){
						//send email to applicant
						if(isset($sendNotif) && $sendNotif=='1'){
							try{
								$this->email->subject("Your booking request has been submitted");
								$this->email->to($appDetails[0]->applicant_email);
								$msg1=$this->load->view('email/madeBookingRequest',$dt0,TRUE);
								$this->email->message($msg1);
								$this->email->send();
							}catch(Exception $exc){}
						}
						$userNotification=$this->frames_model->loadUserNotifyData($this->resourceId);
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
			
						$data['json'] = json_encode(array("status"=>"success","message"=>"Updated successfully.","data"=>array("redirectionTime"=>$resTime,"redirectionUrl"=>$resUrl,"appointmentId"=>$create_id)));
						$this->load->view('json_viewHeaders', $data);
					}elseif($create_id && $appStatus==0){
						$this->_rejectAppointment($appId, $sendNotif,$resTime,$resUrl);
					}
					return;
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_viewHeaders', $data);
				}
				return;
			}
		}
	}
	
	//UpDate 01/07/2016
	
	function getCalInfo(){
        //get calendar infomation
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}		
		$id=$this->input->post("calId",true);
		if(isset($id) && $id){
			$dt['CalInfo']=$this->frames_model->getCalInfo($id,$this->userOrgId);
			$data ['json'] = json_encode ( array (
					"status" => "success",
					"message" => "Calendar Info",
					"data"=>$dt
			) );
			$this->load->view ( 'json_view', $data );
			return;
		}else{
			$data ['json'] = json_encode ( array (
					"status" => "error",
					"message" => "Calendar Info Not found"
			) );
			$this->load->view ( 'json_view', $data );
			return;
		}
		
	}
	function pageLoad(){		
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}		
		$pageId=$this->input->post("pageId",true);
		$dt['appointments']=$this->appointment_model->LoadPageAppread($this->userOrgId,$pageId);
		$data['json'] = json_encode(array("status"=>"success","message"=>"appointments","data"=>$dt));
		$this->load->view('json_viewHeaders', $data);
		return;		
	}
	function loadTrash(){
        // load trash information
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$this->load->model("appointments/appointment_model");
		$dt['appointments']=$this->appointment_model->appointmentsDeleted($this->userOrgId);
		$dt['main_content'] = 'trash_activities';
		$d=$this->load->view('outputPage', $dt,true);
		$this->output->set_output($d);
		return;
	}
	function appointmentInfo(){
        //get appointment information through appointment id
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$id=$this->input->post("appId", true);
		if(!isset($id) || !$id){
			$data ['json'] = json_encode ( array (
					"status" => "error",
					"message" => "No data found",
					"data" => ""
			) );
			$this->load->view ( 'json_view', $data );
			return;
		}
		$this->load->model("appointments/appointment_model");		
		$dt['appInfo']=$this->appointment_model->FullloadAppointment($id);
		$startDT=strtotime($dt['appInfo'][0]->app_start);
		$endDT=strtotime($dt['appInfo'][0]->app_end);		
		$dt['time']=round(abs($endDT - $startDT) / 60,2);
		$dt['appTime']=date("D, M d, Y, h:i a",$startDT)." - ".date("h:i a",$endDT);		
		$dt['pageInfo']=$this->frames_model->getFullPageInfo($dt['appInfo'][0]->user_id,$this->userOrgId);
		$data ['json'] = json_encode ( array (
				"status" => "success",
				"message" => "appointmentInfo",
				"data" => $dt
		) );
		$this->load->view ( 'json_view', $data );
		return;
	}
	function getLinks(){
        // get organization booking links and master links
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$org_url=$this->frames_model->GetIdByOrgName($this->userOrgId);		
		$dt['bookingLinks']=$this->frames_model->orgBookingLinks($this->userOrgId,$org_url[0]->org_url);
		$dt['masterLinks']=$this->frames_model->orgMasterLinks($this->userOrgId,$org_url[0]->org_url);
		$data ['json'] = json_encode ( array (
				"status" => "success",
				"message" => "links",
				"data" => $dt
		) );
		$this->load->view ( 'json_view', $data );
		return;
	}
	function getAppInfo(){
        //get appointment information
		$id=$this->input->post('appId',true);
		if(isset($id) && $id){
			$this->load->model("appointments/appointment_model");
			$dt['appInfo']=$this->appointment_model->loadAppointmentBasicInfo($id);
			$data['json'] = json_encode(array("status"=>"success","message"=>"Appointment Info.","data"=>$dt));
			$this->load->view('json_view', $data);
		}
		return;
	}
	public function loadPageAvailableSlots() {
		$id=$this->input->post('app_id',true);
		if(isset($id) && $id){
			$this->load->model("appointments/appointment_model");
			$appDT=$this->appointment_model->validateFullAppointment($id,$this->userOrgId);
			if(isset($appDT) && $appDT){								
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
			$loadAllocatedSlots=$this->appointment_model->MasterloadAllocatedSlots($userID,$selected_date);			
			$result=array_diff($available_hours,$loadAllocatedSlots);
			$result = array_values($result);
			sort($result, SORT_STRING );
			return $result;
		}else{
			return false;
		}
	}
	function rejectMasterpageAppointment(){        
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){               
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
			$reason = $this->frames_model->update($app_id,$data);
		  
			$appDetails=$this->frames_model->loadAppointmentWithDeleted($app_id);			
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
				
				$userNotification=$this->frames_model->loadUserNotifyData($this->userID);				
				if(isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_cancellations) && $userNotification[0]->notify_on_cancellations==1){
					//send email to Organization Admin
					$orgEamil=$this->frames_model->findOrgAdminEmail($this->userID);
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
                return;
        }
	}
	function loadActivities(){
        // load activities
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$this->load->model("appointments/appointment_model");
		$sts=$this->input->post("status",true);
		$source=$this->input->post("source",true);
		$dt['appointments']=$this->appointment_model->getAppointmentsByFilter($this->userOrgId,$sts,$source);
		$dt['main_content'] = 'dashboard_activities';
		$d=$this->load->view('outputPage', $dt,true);
		$this->output->set_output($d);
		return;
	
	}
	function sendRescheduleRequest(){
        //reschedule appointment request
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}		
		if ($_POST) {
			$appID = $this->input->post ( 'appointmentID', true );
			$reason = ($this->input->post ( 'reschedule_reson', true )) ? $this->input->post ( 'reschedule_reson', true ):"";
			if (isset ( $appID ) && $appID) {
				$dt ['rescheduled_reason'] = $reason;
				$dt ['rescheduled_code'] =  md5(rand(5,15).'schedular');
				$dt ['isApproved']=0;
				
				$this->load->model("appointments/appointment_model");
				$rescheduleUpdate = $this->appointment_model->updateAppointment( $appID, $dt );			
				if ($rescheduleUpdate) {
					$this->appointment_model->releaseAllocatedApp($appID);
					$appInfo=$this->appointment_model->FullloadAppointment( $appID );
					$adminInfo=$this->frames_model->findAdminName($this->userID);					
					$afName=($adminInfo[0]->firstname) ? $adminInfo[0]->firstname : "";
					$alName=($adminInfo[0]->lastname) ? $adminInfo[0]->lastname : "";
					$dt ['logo'] = "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png"; // base_url()."themes/front/images/logo_64.png";
					$dt ['applicant_email'] = $appInfo[0]->applicant_email;
					$dt ['applicant_name'] = $appInfo[0]->applicant_name;
					$dt ['admin_name'] = $afName." ".$alName;
					$dt ['app_title'] = $appInfo[0]->app_title;
					$dt ['rescheduled_reason'] = $appInfo[0]->rescheduled_reason;
					$dt ['time'] = $appInfo[0]->app_start." - ".$appInfo[0]->app_end;
					$link = $this->frames_model->getPageInfo( $appInfo[0]->user_id );
					$org_url=$this->frames_model->GetIdByOrgName($this->userOrgId);
					$dt ['scheduleUrl'] = base_url () .$org_url[0]->org_url. "/" . $link [0]->booking_url."/".$appInfo[0]->rescheduled_code;
					
					$this->load->library ( 'email', $this->config->item ( 'email_config' ) );
					$this->email->from ( 'support@makkinfotech.biz', 'Scheduler' );
					$this->email->to ( $appInfo[0]->applicant_email );
					$this->email->subject ( 'Reschedule request for '.$appInfo[0]->app_title );
					$msg = $this->load->view ( 'email/rescheduleRequest', $dt, TRUE );
					$this->email->message ( $msg );
					$this->email->send ();
					$data ['json'] = json_encode ( array (
							"status" => "success",
							"message" => "Rescheduled Success"
					) );
					$this->load->view ( 'json_view', $data );
					return;
				}else{
					$data ['json'] = json_encode ( array (
							"status" => "error",
							"message" => "Unable to reschedule Request"
					) );
					$this->load->view ( 'json_view', $data );
					return;
				}
			}
		}
	}
	function sendRequestNewTime(){
        //request for new appointment time schedule
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}		
		if ($_POST) {
			$appID = $this->input->post ( 'appointmentID', true );
			$reason = ($this->input->post ( 'requestNewTime_reson', true )) ? $this->input->post ( 'requestNewTime_reson', true ):"";
			if (isset ( $appID ) && $appID) {
				$dt ['rescheduled_reason'] = $reason;
				$dt ['rescheduled_code'] = md5(rand(5,15).'schedular');
				$dt ['isApproved']=0;
	
				$this->load->model("appointments/appointment_model");
				$rescheduleUpdate = $this->appointment_model->updateAppointment( $appID, $dt );				
				if ($rescheduleUpdate) {
					$this->appointment_model->releaseAllocatedApp($appID);
					$appInfo=$this->appointment_model->FullloadAppointment( $appID );					
					$adminInfo=$this->frames_model->findAdminName($this->userID);					
					$afName=($adminInfo[0]->firstname) ? $adminInfo[0]->firstname : "";
					$alName=($adminInfo[0]->lastname) ? $adminInfo[0]->lastname : "";
					$dt ['logo'] = "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png"; // base_url()."themes/front/images/logo_64.png";
					$dt ['applicant_email'] = $appInfo[0]->applicant_email;
					$dt ['applicant_name'] = $appInfo[0]->applicant_name;
					$dt ['admin_name'] = $afName." ".$alName;
					$dt ['app_title'] = $appInfo[0]->app_title;
					$dt ['rescheduled_reason'] = $appInfo[0]->rescheduled_reason;
					$dt ['time'] = $appInfo[0]->app_start." - ".$appInfo[0]->app_end;					
					$link = $this->frames_model->getPageInfo( $appInfo[0]->user_id );					
					$org_url=$this->frames_model->GetIdByOrgName($this->userOrgId);
					$dt ['scheduleUrl'] = base_url () .$org_url[0]->org_url . "/" . $link [0]->booking_url."/".$appInfo[0]->rescheduled_code;					
					$this->load->library ( 'email', $this->config->item ( 'email_config' ) );
					$this->email->from ( 'support@makkinfotech.biz', 'Scheduler' );
					$this->email->to ( $appInfo[0]->applicant_email );
					$this->email->subject ( 'New time request for '.$appInfo[0]->app_title );
					$msg = $this->load->view ( 'email/requestNewTime', $dt, TRUE );
					$this->email->message ( $msg );
					$this->email->send ();
					$data ['json'] = json_encode ( array (
							"status" => "success",
							"message" => "Request New Time Success"
					) );
					$this->load->view ( 'json_view', $data );
					return;
				}else{
					$data ['json'] = json_encode ( array (
							"status" => "error",
							"message" => "Unable to request for new time"
					) );
					$this->load->view ( 'json_view', $data );
					return;
				}
			}
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
				$validateOrgAppointment=$this->appointment_model->validateAppointment($appID,$this->userOrgId);
				if(!$validateOrgAppointment){
					$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access'),"data"=>""));
					$this->load->view('json_view', $data);
					return;
				}
				$dt['is_deleted']=1;
				$deleteApp=$this->appointment_model->updateAppointment($appID,$dt);
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
	function appointmentTrashInfo(){
        // appointment trash information using appId
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$id=$this->input->post("appId", true);
		if(!isset($id) || !$id){
			$data ['json'] = json_encode ( array (
					"status" => "error",
					"message" => "No data found",
					"data" => ""
			) );
			$this->load->view ( 'json_view', $data );
			return;
		}
		$this->load->model("appointments/appointment_model");		
		$dt['appInfo']=$this->appointment_model->loadTrashAppointment($id);
		$startDT=strtotime($dt['appInfo'][0]->app_start);
		$endDT=strtotime($dt['appInfo'][0]->app_end);
		$dt['time']=round(abs($endDT - $startDT) / 60,2);
		$dt['appTime']=date("D, M d, Y, h:i a",$startDT)." - ".date("h:i a",$endDT);
		$dt['pageInfo']=$this->frames_model->getFullPageInfo($dt['appInfo'][0]->user_id,$this->userOrgId);		
		$data ['json'] = json_encode ( array (
				"status" => "success",
				"message" => "appointmentInfo",
				"data" => $dt
		) );
		$this->load->view ( 'json_view', $data );
		return;
	}
	function loadMasterAppointmentFrame(){		
		$this->load->model("appointments/appointment_model");
		$appData = $this->frames_model->getAppTotalData ( $this->userOrgId );
		$data ['pageList'] = $this->frames_model->loadResources($this->userOrgId);
		$data ['app_data'] = $appData;
		$data ['appointments']=$this->appointment_model->appointmentsAsArray($this->userOrgId);
		$data ['BPages']=$this->frames_model->bookingPages($this->userOrgId);
		$data ['MBPages']=$this->frames_model->masterBookingPages($this->userOrgId);	
		$this->load->view('includes/sarvices_header', $data);
		$this->load->view('frames/dashboard', $data);
		$this->load->view('includes/footer', $data);			
		return;
	}
}