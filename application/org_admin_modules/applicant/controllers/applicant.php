<?php

class Applicant extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('applicant_model');
		$this->load->model('appointments/appointment_model');
		$this->load->library('form_validation');
		$this->load->library('schedular_auth');
		$this->load->helper('date');

		$seg = $this->uri->segment_array();
		$this->orgName = $seg[1];
		$this->resourceName = $seg[2];

		if (isset($this->orgName) && $this->orgName) {
			$this->UORGID = $this->applicant_model->validateOrgName($this->orgName);
			$this->UORGUID = $this->applicant_model->findOrgAdminUserID($this->UORGID);
			$this->UORGURL = $this->orgName;
			$master = $this->applicant_model->isMasterPage($this->resourceName);
			$this->resourceId = 0;
			if (!$master) {
				$this->resourceId = $this->applicant_model->findResourceID($this->resourceName);
			} else {
				$this->masterPageId = $this->applicant_model->findMasterPageID($this->resourceName);
			}
		}
	}
	function index()
	{
		//applicant main page
		$seg = $this->uri->total_segments();
		$rescheduleCode = $this->uri->segment($seg);
		$this->load->model("upload/upload_model");
		if (isset($rescheduleCode) && $rescheduleCode && $this->applicant_model->validateCode($rescheduleCode)) {
			$pageInfo = $this->applicant_model->getPageIdFromCode($rescheduleCode);
			$pId = $pageInfo[0]->user_id;
			$timezone = $pageInfo[0]->app_timezone;
			$data['displayTimezone'] = false;
			$isDisabled = $this->applicant_model->isDisabled($pId);
			if ($isDisabled) {
				$data['pageDisabled'] = true;
			}
			$data['pageId'] = $pId;
			$file = $this->upload_model->loadBPageLogo($pId);
			if (isset($file) && $file)
				$data['PageLogo'] = base_url() . "uploads/bookingPage/" . $file . "_thumb.jpg";

			$data['timezone'] = $timezone;
			$data['name'] = $pageInfo[0]->applicant_name;
			$data['email'] = $pageInfo[0]->applicant_email;
			$data['desc'] = $pageInfo[0]->app_desc;
			$data['appId'] = $pageInfo[0]->app_id;
			$data['title'] = $pageInfo[0]->app_title;
			$data['phone'] = $pageInfo[0]->phone;
			$data['location'] = $pageInfo[0]->location;

			$data['pageInfo'] = $this->applicant_model->getPageInfo($pId);
			$data['main_content'] = 'applicant/appdashboardNew';
			$this->load->view('page1', $data);
			return;
		}
		$pgId = $this->input->post("pageId", true);
		if ($this->resourceId || (isset($pgId) && $pgId)) {
			if (isset($pgId) && $pgId) {
				$this->resourceId = $pgId;
				$data['changeResource'] = true;
				$dt = $this->applicant_model->getMasterPageInfo($this->masterPageId);
				$data['lableBooking'] = $dt[0]->bookingPageLabel;
				$data['backUrl'] = $dt[0]->booking_url;
			}
			$isDisabled = $this->applicant_model->isDisabled($this->resourceId);
			if ($isDisabled) {
				$data['pageDisabled'] = true;
			}
			$data['pageId'] = $this->resourceId;
			$file = $this->upload_model->loadBPageLogo($this->resourceId);
			if (isset($file) && $file)
				$data['PageLogo'] = base_url() . "uploads/bookingPage/" . $file . "_thumb.jpg";

			$data['displayTimezone'] = true;
			$data['pageInfo'] = $this->applicant_model->getPageInfo($this->resourceId);
			$data['location'] = $data['pageInfo'][0]->location;
			$data['main_content'] = 'applicant/appdashboardNew';
		} else {
			$isMPageDisabled = $this->applicant_model->isMasterPageDisabled($this->masterPageId);
			if ($isMPageDisabled) {
				$data['pageDisabled'] = true;
			}
			$file = $this->upload_model->loadMBPageLogo($this->masterPageId);
			if (isset($file) && $file)
				$data['PageLogo'] = base_url() . "uploads/masterBookingPage/" . $file . "_thumb.jpg";

			$data['mPageId'] = $this->masterPageId;
			$data['displayTimezone'] = true;
			$data['pageInfo'] = $this->applicant_model->getMasterPageInfo($this->masterPageId);
			$data['masterPagePages'] = $this->applicant_model->getMasterPagePages($this->masterPageId);
			$data['main_content'] = 'applicant/appdashboardMasterNew';
		}
		$this->load->view('page1', $data);
		return;
	}

	function loadAvailableUsers()
	{
		//load available users by organization and inspection type
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		try {
			$orgID = $this->session->userdata("userOrganizationID");
			$inspTypeId = $this->input->post('inspectionTypeId', true);
			if (isset($inspTypeId) && $inspTypeId) {
				$data['inspectionTypeName'] = $this->appointment_model->getInspetionTypeName($inspTypeId);
				$data['availableUsers'] = $this->appointment_model->getAllUsers($orgID, $inspTypeId);
				$data['json'] = json_encode(array("status" => "success", "message" => "available users", "data" => $data));
				$this->load->view('json_view', $data);
				return;
			} else {
				$data['json'] = json_encode(array("status" => "error", "message" => "please select inspection type.", "data" => $data));
				$this->load->view('json_view', $data);
				return;
			}
		} catch (Exception $exc) {
			$data['json'] = json_encode(array("status" => "error", "message" => array(
				'exceptions' => array(exceptionToJavaScript($exc))
			), "data" => ""));
			$this->load->view('json_view', $data);
			return;
		}
	}
	public function loadUserAvailableSlots()
	{
		//load user available time slots
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		try {
			$orgID = $this->session->userdata("userOrganizationID");
			$selected_date = $this->input->post("selected_date", true);
			$sDT = new DateTime($selected_date);
			$sDT->format('H:i');
			$userID = $this->input->post("user_id", true);
			$sDate = explode(" ", $selected_date);
			$selected_date = $sDate[0];

			$day = strtolower(date('l', strtotime($selected_date)));
			$workingPlans = $this->appointment_model->getSlots($userID);
			$workingPlans = json_decode($workingPlans[0]->value);
			if (isset($workingPlans) && $workingPlans && isset($day) && $day && isset($workingPlans->$day->time_slots) && $workingPlans->$day->time_slots && isset($workingPlans->$day->start) && $workingPlans->$day->start && isset($workingPlans->$day->end) && $workingPlans->$day->end) {
				$slotGap = $workingPlans->$day->time_slots;
				$start = $workingPlans->$day->start;
				$end = $workingPlans->$day->end;
				$empty_periods = array(array("start" => $start, "end" => $end, "slots" => $slotGap));

				$available_hours = array();

				foreach ($empty_periods as $period) {
					$start_hour = new DateTime($selected_date . ' ' . $period['start']);
					$end_hour = new DateTime($selected_date . ' ' . $period['end']);
					$slt = $period['slots'];
					$minutes = $start_hour->format('i');
					$start_hour->setTime($start_hour->format('H'), $slt);
					$current_hour = $start_hour;
					$diff = $current_hour->diff($end_hour);

					while (($diff->h * 60 + $diff->i) >= intval($slt)) {
						$available_hours[] = $current_hour->format('H:i');
						$current_hour->add(new DateInterval("PT" . $slt . "M"));
						$diff = $current_hour->diff($end_hour);
					}
				}
				if (date('m/d/Y', strtotime($selected_date)) == date('m/d/Y')) {
					$book_advance_timeout = $slt;
					foreach ($available_hours as $index => $value) {
						$available_hour = strtotime($value);
						$current_hour = strtotime('+' . $book_advance_timeout . ' minutes', strtotime('now'));
						if ($available_hour <= $current_hour) {
							unset($available_hours[$index]);
						}
					}
				}
				$available_hours = array_values($available_hours);
				sort($available_hours, SORT_STRING);
				$available_hours = array_values($available_hours);
				$loadAllocatedSlots = $this->appointment_model->loadAllocatedSlots($userID, $selected_date);
				$result = array_diff($available_hours, $loadAllocatedSlots);
				$result = array_values($result);
				sort($result, SORT_STRING);
				$data['userAvailableSlots'] = $result;
				$data['json'] = json_encode(array("status" => "success", "message" => "", "data" => $data));
				$this->load->view('json_view', $data);
				return;
			} else {
				$data['json'] = json_encode(array("status" => "error", "message" => "There are no slots available for this day.", "data" => ""));
				$this->load->view('json_view', $data);
				return;
			}
		} catch (Exception $exc) {
			$data['json'] = json_encode(array("status" => "error", "message" => array(
				'exceptions' => array(exceptionToJavaScript($exc))
			), "data" => ""));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function allocateAppointment()
	{
		//allocate appointment to perticular user
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$appID = $this->input->post('app_id', true);
		$userID = $this->input->post('allocatedUserId', true);
		$allocatedOn = $this->input->post('allocatedOn', true);
		$now = now();
		if (isset($appID) && $appID && isset($userID) && $userID && isset($allocatedOn) && $allocatedOn) {
			$data['app_id'] = $appID;
			$data['allocatedToUserId'] = $userID;
			$data['allocatedDate'] = $allocatedOn;
			$data['allocatedByUserId'] = $this->UORGUID;
			$data['createdOn'] = unix_to_human($now, TRUE, 'us');
			$allocate = $this->appointment_model->allocateAppointment($data);
			$appDetails = $this->appointment_model->loadAppointment($appID);
			if ($allocate && $appDetails) {
				$userDetail = $this->appointment_model->getUserDetail($userID);
				$dt['logo']				= "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
				$dt['user_email']		= $appDetails[0]->applicant_email;
				$dt['scheduleDate']		= $appDetails[0]->app_start;
				$dt['inspectorName']	= $userDetail[0]->firstname . " " . $userDetail[0]->lastname;
				$dt['inspectorEmail']	= $userDetail[0]->email;
				$dt['applicantName']	= $userDetail[0]->firstname . " " . $userDetail[0]->lastname;
				$dt['applicantEmail']	= $userDetail[0]->email;
				$dt['AppointmentTitle']	= $appDetails[0]->app_title;
				$this->load->library('email', $this->config->item('email_config'));
				$this->email->from('support@makkinfotech.biz', 'Scheduler');
				$this->email->subject('Appointment Request');
				//send email to applicant
				try {
					$this->email->to($appDetails[0]->applicant_email);
					$msg = $this->load->view('email/approveRequest', $dt, TRUE);
					$this->email->message($msg);
					$this->email->send();
				} catch (Exception $exc) {
				}

				//send email to inspectorEmail
				try {
					$this->email->to($userDetail[0]->email);
					$msg1 = $this->load->view('email/approveRequestToInspector', $dt, TRUE);
					$this->email->message($msg1);
					$this->email->send();
				} catch (Exception $exc) {
				}
				$data['json'] = json_encode(array("status" => "success", "message" => "Appointment Allocated Successfully.", "data" => ""));
				$this->load->view('json_view', $data);
				return;
			}
		} else {
			$data['json'] = json_encode(array("status" => "error", "message" => "unable to allocate appointment", "data" => ""));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function loadAppointments()
	{
		//load organization user's all appointments
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$dt['appointments'] = $this->appointment_model->read($this->UORGID);
		$data['json'] = json_encode(array("status" => "success", "message" => "appointments", "data" => $dt));
		$this->load->view('json_view', $data);
		return;
	}
	function loadAppointmentTypes()
	{
		//load organization user's all appointment types
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$dt['app_types'] = $this->applicant_model->appointmentsTypes($this->UORGUID);
		$data['json'] = json_encode(array("status" => "success", "message" => "app_types", "data" => $dt));
		$this->load->view('json_view', $data);
		return;
	}
	function setTimeZone()
	{
		//set timezone
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$timezoneInput = $this->input->post("timezone", true);
		if (isset($timezoneInput) && $timezoneInput) {
			$data["timezone"] = $timezoneInput;
			$data["timezoneText"] = $this->input->post("timezoneText", true);;
			$data['json'] = json_encode(array("status" => "success", "message" => "", "data" => $data));
			$this->load->view('json_view', $data);
		} else {
			$data['json'] = json_encode(array("status" => "error", "message" => "Unable to set timezone", "data" => ""));
			$this->load->view('json_view', $data);
		}
		return;
	}
	function loadsessionAppData()
	{
		//load appointment data from session
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$data["sessionAppointments"] = $this->session->userdata("appointmentData");
		$data['json'] = json_encode(array("status" => "success", "message" => "", "data" => $data));
		$this->load->view('json_view', $data);
	}
	function loadholidaysData()
	{
		// load organization resource holidays
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$data['org_id'] = $this->UORGID;
		$data['holidays'] = $this->applicant_model->loadHolidaysData($this->UORGID, $this->resourceId);
		$data['json'] = json_encode(array("status" => "success", "message" => "Holidays", "data" => $data));
		$this->load->view('json_view', $data);
		return;
	}

	function _loadUserWorkingPlan($DT, $uid)
	{
		//load working plan
		$this->load->model("users/user_model");
		if (isset($uid) && $uid && isset($DT) && $DT) {
			$workingPlan = array();
			$workingPlanArray = array();
			$res = $this->user_model->loadUserWorkingPlan($uid);
			if ($res) {
				$res = $res[0]->userWorkingPlan;
				$workingPlan = json_decode($res);
				$workingPlan = (array)$workingPlan;
				foreach ($workingPlan as $key => $value) {
					$value = (array)$value;
					foreach ($value as $key1 => $value1) {
						if ($key1 == $DT) {
							$workingPlanArray = array("wDate" => $DT, "start" => $value->$key1->start, "end" => $value->$key1->end);
						}
					}
				}
				return $workingPlanArray;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function loadTimeSlotsMaster()
	{
		//load timeslots for master page
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		try {
			$mbPageId = $this->input->post('mPageId', true);
			if (!$mbPageId) {
				$data['json'] = json_encode(array("status" => "error", "message" => "Unable to get time slots.", "data" => ""));
				$this->load->view('json_view', $data);
				return;
			}
			$selected_date = $this->input->post("selected_date", true);
			$timezone = $this->input->post("timezone", true);
			$availableDate = date("D, M d, Y", strtotime($selected_date));
			$isHoliDy = $this->applicant_model->isHolidayMaster($selected_date, $this->UORGID, $mbPageId);
			if (isset($isHoliDy) && $isHoliDy) {
				$dt['slots'] = array();
				$dt['availability'] = "";
				$dt['selectedDate'] = "";
				$data['json'] = json_encode(array("status" => "error", "message" => "There are no slots available for this day. Please choose another day for appointment.", "data" => $dt));
				$this->load->view('json_view', $data);
				return;
			}
			$day = strtolower(date('l', strtotime($selected_date)));
			$bPagePages = $this->applicant_model->getPagePages($mbPageId);

			$resultMain = array();
			$slotGap = 30;
			if (isset($bPagePages) && $bPagePages) {
				foreach ($bPagePages as $pages) {
					$workingPlans = $this->applicant_model->getSlots($pages->user_id);
					if (isset($workingPlans) && $workingPlans && isset($day) && $day) {
						$workingPlans = json_decode($workingPlans[0]->value);
						if (!$workingPlans->$day) {
							/* $dt['slots']=array();
							$dt['availability']="";
							$dt['selectedDate']="";
							$data['json'] = json_encode(array("status"=>"error","message"=>"There are no slots available for this day. Please choose another day for appointment.","data"=>$dt));
							$this->load->view('json_view', $data);
							return; */
							continue;
						}
						$slotGap = $workingPlans->$day->time_slots;
						$start = $workingPlans->$day->start;
						$end = $workingPlans->$day->end;
						$empty_periods = array(array("start" => $start, "end" => $end, "slots" => $slotGap));

						$uWorkPlan = $this->_loadUserWorkingPlan($selected_date, $pages->user_id);

						if ($uWorkPlan) {
							$start = $uWorkPlan['start'];
							$end = $uWorkPlan['end'];
							$empty_periods = array(array("start" => $start, "end" => $end, "slots" => $slotGap));
						}

						$available_hours = array();
						foreach ($empty_periods as $period) {
							$start_hour = new DateTime($selected_date . ' ' . $period['start']);
							$end_hour = new DateTime($selected_date . ' ' . $period['end']);
							$slt = $period['slots'];
							$minutes = $start_hour->format('i');
							$start_hour->setTime($start_hour->format('H'), $slt);
							$current_hour = $start_hour;
							$diff = $current_hour->diff($end_hour);

							while (($diff->h * 60 + $diff->i) >= intval($slt)) {
								$available_hours[] = $current_hour->format('H:i');
								$current_hour->add(new DateInterval("PT" . $slt . "M"));
								$diff = $current_hour->diff($end_hour);
							}
						}

						$curUnix = gmt_to_local(now(), $timezone, false);
						//echo date('m/d/Y', strtotime($selected_date))." and ".strtotime('now')." and ".unix_to_human($curUnix);
						if (date('m/d/Y', strtotime($selected_date)) == date('m/d/Y')) {
							$book_advance_timeout = $slt;
							foreach ($available_hours as $index => $value) {
								$available_hour = strtotime($value);
								$current_hour = strtotime('+' . $book_advance_timeout . ' minutes', $curUnix);
								if ($available_hour <= $current_hour) {
									unset($available_hours[$index]);
								}
							}
						}
						$available_hours = array_values($available_hours);
						sort($available_hours, SORT_STRING);
						$available_hours = array_values($available_hours);
						$loadAllocatedSlots = $this->appointment_model->loadAllocatedSlots($pages->user_id, $selected_date);
						$result = array_diff($available_hours, $loadAllocatedSlots);
						$result = array_values($result);
						sort($result, SORT_STRING);
						$resultMain = array_merge($resultMain, $result);
					}
				}
				//$resultMain = array_values($resultMain);
				$resultMain = array_unique($resultMain);
				sort($resultMain, SORT_STRING);
				$dt['slots'] = array_values($resultMain);
				$dt['slotsGap'] = $slotGap;
				$dt['availability'] = $availableDate;
				$dt['selectedDate'] = $selected_date;
				$data['json'] = json_encode(array("status" => "success", "message" => "Slots", "data" => $dt));
				$this->load->view('json_view', $data);
				return;
			} else {
				$dt['slots'] = array();
				$dt['availability'] = "";
				$dt['slotsGap'] = "";
				$dt['selectedDate'] = "";
				$data['json'] = json_encode(array("status" => "error", "message" => "There are no slots available for this day. Please choose another day for appointment.", "data" => $dt));
				$this->load->view('json_view', $data);
				return;
			}
		} catch (Exception $exc) {
			$data['json'] = json_encode(array("status" => "error", "message" => array(
				'exceptions' => array(exceptionToJavaScript($exc))
			), "data" => ""));
			$this->load->view('json_view', $data);
			return;
		}
	}
	public function loadTimeSlots()
	{
		//load timeslots for page
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		try {
			if (isset($this->resourceId) && $this->resourceId) {
				$bPageId = $this->resourceId;
			} else {
				$bPageId = $this->input->post('pageId', true);
			}
			if (!$bPageId) {
				$data['json'] = json_encode(array("status" => "error", "message" => "Unable to get time slots.", "data" => ""));
				$this->load->view('json_view', $data);
				return;
			}
			$selected_date = $this->input->post("selected_date", true);
			$timezone = $this->input->post("timezone", true);
			$availableDate = date("D, M d, Y", strtotime($selected_date));
			$isHoliDy = $this->applicant_model->isHoliday($selected_date, $this->UORGID, $bPageId);
			if ($isHoliDy) {
				$dt['slots'] = array();
				$dt['availability'] = "";
				$dt['selectedDate'] = "";
				$data['json'] = json_encode(array("status" => "error", "message" => "There are no slots available for this day. Please choose another day for appointment.", "data" => $dt));
				$this->load->view('json_view', $data);
				return;
			}
			$day = strtolower(date('l', strtotime($selected_date)));
			$workingPlans = $this->applicant_model->getSlots($bPageId);
			if (isset($workingPlans) && $workingPlans && isset($day) && $day) {
				$workingPlans = json_decode($workingPlans[0]->value);
				if (!$workingPlans->$day) {
					$dt['slots'] = array();
					$dt['availability'] = "";
					$dt['selectedDate'] = "";
					$data['json'] = json_encode(array("status" => "error", "message" => "There are no slots available for this day. Please choose another day for appointment.", "data" => $dt));
					$this->load->view('json_view', $data);
					return;
				}
				$slotGap = $workingPlans->$day->time_slots;
				$start = $workingPlans->$day->start;
				$end = $workingPlans->$day->end;
				$empty_periods = array(array("start" => $start, "end" => $end, "slots" => $slotGap));

				$uWorkPlan = $this->_loadUserWorkingPlan($selected_date, $bPageId);

				if ($uWorkPlan) {
					$start = $uWorkPlan['start'];
					$end = $uWorkPlan['end'];
					$empty_periods = array(array("start" => $start, "end" => $end, "slots" => $slotGap));
				}

				$available_hours = array();
				foreach ($empty_periods as $period) {
					$start_hour = new DateTime($selected_date . ' ' . $period['start']);
					$end_hour = new DateTime($selected_date . ' ' . $period['end']);
					$slt = $period['slots'];
					$minutes = $start_hour->format('i');
					$start_hour->setTime($start_hour->format('H'), $slt);
					$current_hour = $start_hour;
					$diff = $current_hour->diff($end_hour);

					while (($diff->h * 60 + $diff->i) >= intval($slt)) {
						$available_hours[] = $current_hour->format('H:i');
						$current_hour->add(new DateInterval("PT" . $slt . "M"));
						$diff = $current_hour->diff($end_hour);
					}
				}

				$curUnix = gmt_to_local(now(), $timezone, false);
				//echo date('m/d/Y', strtotime($selected_date))." and ".strtotime('now')." and ".unix_to_human($curUnix);
				if (date('m/d/Y', strtotime($selected_date)) == date('m/d/Y')) {
					$book_advance_timeout = $slt;
					foreach ($available_hours as $index => $value) {
						$available_hour = strtotime($value);
						$current_hour = strtotime('+' . $book_advance_timeout . ' minutes', $curUnix);
						if ($available_hour <= $current_hour) {
							unset($available_hours[$index]);
						}
					}
				}
				$available_hours = array_values($available_hours);
				sort($available_hours, SORT_STRING);
				$available_hours = array_values($available_hours);
				$loadAllocatedSlots = $this->appointment_model->loadAllocatedSlots($bPageId, $selected_date);
				$result = array_diff($available_hours, $loadAllocatedSlots);
				$result = array_values($result);
				sort($result, SORT_STRING);
				$dt['slots'] = $result;
				$dt['slotsGap'] = $slotGap;
				$dt['availability'] = $availableDate;
				$dt['selectedDate'] = $selected_date;
				$data['json'] = json_encode(array("status" => "success", "message" => "Slots", "data" => $dt));
				$this->load->view('json_view', $data);
				return;
			} else {
				$dt['slots'] = array();
				$dt['availability'] = "";
				$dt['slotsGap'] = "";
				$dt['selectedDate'] = "";
				$data['json'] = json_encode(array("status" => "error", "message" => "There are no slots available for this day. Please choose another day for appointment.", "data" => $dt));
				$this->load->view('json_view', $data);
				return;
			}
		} catch (Exception $exc) {
			$data['json'] = json_encode(array("status" => "error", "message" => array(
				'exceptions' => array(exceptionToJavaScript($exc))
			), "data" => ""));
			$this->load->view('json_view', $data);
			return;
		}
	}
	public function loadUsersNotWorkingDays()
	{
		//load user not working days
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		try {
			$appTypeId = $this->input->post("pageId", true);
			$notWorkingDates = $this->applicant_model->loadUserNotWorkingDays($appTypeId);
			if (is_array($notWorkingDates)) {
				$dt['notWorkingDays'] = $notWorkingDates; //array(array("title"=>"Not Working","start"=>"2014-11-07"),array("title"=>"Not Working","start"=>"2014-11-11"));
				$data['json'] = json_encode(array("status" => "success", "message" => "notWorkingDays", "data" => $dt));
				$this->load->view('json_view', $data);
			} else {
				$dt['notWorkingDays'] = $notWorkingDates;
				$data['json'] = json_encode(array("status" => "error", "message" => "unable to find not working days", "data" => ""));
				$this->load->view('json_view', $data);
			}
			return;
		} catch (Exception $exc) {
			$data['json'] = json_encode(array("status" => "error", "message" => array(
				'exceptions' => array(exceptionToJavaScript($exc))
			), "data" => ""));
			$this->load->view('json_view', $data);
			return;
		}
	}
	public function loadPageNotWorkingDays()
	{
		//load resource not working days
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		try {
			if (!isset($this->resourceId) || !$this->resourceId) {
				$this->resourceId = $this->input->post("pageId", true);
			}
			if ($this->resourceId) {
				$notWorkingDates = $this->applicant_model->loadPageNotWorkingDays($this->resourceId);
				if ($notWorkingDates) {
					$dt['notWorkingDays'] = $notWorkingDates;
					$data['json'] = json_encode(array("status" => "success", "message" => "notWorkingDays", "data" => $dt));
					$this->load->view('json_view', $data);
				} else {
					$dt['notWorkingDays'] = $notWorkingDates;
					$data['json'] = json_encode(array("status" => "error", "message" => "unable to find not working days", "data" => ""));
					$this->load->view('json_view', $data);
				}
			} else {
				$data['json'] = json_encode(array("status" => "error", "message" => "unable to find not working days", "data" => ""));
				$this->load->view('json_view', $data);
			}
			return;
		} catch (Exception $exc) {
			$data['json'] = json_encode(array("status" => "error", "message" => array(
				'exceptions' => array(exceptionToJavaScript($exc))
			), "data" => ""));
			$this->load->view('json_view', $data);
			return;
		}
	}

	function createAppointment()
	{
		//create appointment
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		if ($_POST) {
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
				),
				array(
					'field' => 'phone',
					'label' => 'Phone Number',
					'rules' => 'trim|required',
				)
			);
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() === false) {
				$this->form_validation->set_error_delimiters('<br />', '');
				$arrV[] = validation_errors();
				$data['json'] = json_encode(array("status" => "error", "message" => $arrV));
				$this->load->view('json_view', $data);
			} else {
				$appId = $this->input->post("appId", true);
				if (isset($this->resourceId) && $this->resourceId) {
					$this->resourceId = $this->resourceId;
				} else {
					$this->resourceId = $this->input->post("pageId", true);
				}
				if (!$this->resourceId) {
					$data['json'] = json_encode(array("status" => "error", "message" => "Unable to create appointment.", "data" => ""));
					$this->load->view('json_view', $data);
					return;
				}
				$st = $this->input->post('start', true);
				$orgEmail = $this->applicant_model->findOrgAdminEmail($this->UORGUID);

				$arr = explode(" ", $st);
				if (count($arr) < 2) {
					$data['json'] = json_encode(array("status" => "error", "message" => array("Please select a time.")));
					$this->load->view('json_view', $data);
					return;
				}
				$workingPlans = $this->applicant_model->getSlots($this->resourceId);
				$day = strtolower(date('l', strtotime($arr[0])));
				$slotGap = 30;
				if (isset($workingPlans) && $workingPlans && isset($day) && $day) {
					$workingPlans = json_decode($workingPlans[0]->value);
					$slotGap = $workingPlans->$day->time_slots;
				}
				$now = now();
				$minutes_to_add = $slotGap;

				$time = new DateTime($st);
				$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
				$endTime = $time->format('Y-m-d H:i');

				$isAuto = $this->applicant_model->getBookingPageSetting($this->resourceId);
				if (isset($isAuto) && $isAuto == 1) {
					$data['isAutoBooking'] = 1;
					$data['isApproved']	   = 1;
				} else {
					$data['isAutoBooking'] = 0;
				}
				if (isset($appId) && $appId) {

					$data['app_title']		= $this->input->post('title', true);
					$data['app_desc']	    = $this->input->post('desc', true);
					$data['app_start']		= $st;
					$data['app_end']	    = $endTime;
					$data['applicant_name']	= $this->input->post('name', true);
					$data['applicant_email'] = $this->input->post('email', true);
					$data['org_id']			= $this->UORGID;
					$data['user_id']		= $this->resourceId;
					$data['is_deleted']	    = 0;
					$data['is_viewed']	    = 0;
					$data['isApproved']		= 2;
					$data['applicant_phone'] = $this->input->post('phone', true);
					$data['applicant_location'] = $this->input->post('location', true);
					$data['rescheduled_appid'] = $appId;
					$data['app_timezone']	= $this->input->post("timezone", true);
					$data['appointmentCreatedOn']	= unix_to_human($now, TRUE, 'us');
					$create_id = $this->applicant_model->createAppointment($data);

					$this->load->library('email', $this->config->item('email_config'));
					$appDetails = $this->appointment_model->loadAppointment($create_id);
					$userDetail = $this->appointment_model->getUserDetail($this->resourceId);
					$dt0['logo']			= "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
					$dt0['user_email']		= $appDetails[0]->applicant_email;
					$dt0['scheduleDate']	= $st;
					$dt0['inspectorName']	= $userDetail[0]->firstname . " " . $userDetail[0]->lastname;
					$dt0['inspectorEmail']	= $userDetail[0]->email;
					$dt0['applicantName']	= $appDetails[0]->applicant_name;
					$dt0['applicantEmail']	= $appDetails[0]->applicant_email;
					$dt0['adminEmail']		= $orgEmail[0]->email;
					$dt0['bookingPage']		= $userDetail[0]->booking_url;
					$dt0['AppointmentTitle'] = $appDetails[0]->app_title;
					$this->email->from('support@makkinfotech.biz', 'Scheduler');

					if ($create_id && $isAuto == 1) {
						//send email to applicant
						try {
							$this->email->subject($appDetails[0]->app_title . ' - Scheduler confirmation');
							$this->email->to($appDetails[0]->applicant_email);
							$msg = $this->load->view('email/bookingConfirmed', $dt0, TRUE);
							$this->email->message($msg);
							$this->email->send();
						} catch (Exception $exc) {
						}
						$userNotification = $this->applicant_model->loadUserNotifyData($this->UORGID);
						if (isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking) && $userNotification[0]->notify_on_booking == 1) {
							//send email to Organization Admin
							try {
								$this->email->subject($appDetails[0]->app_title . ' has made a booking');
								$this->email->to($orgEmail[0]->email);
								$msg1 = $this->load->view('email/rescheduledConfirmed', $dt0, TRUE);
								$this->email->message($msg1);
								$this->email->send();
							} catch (Exception $exc) {
							}
						}
						$resTime = ($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
						$resUrl = ($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
						$dt1['app_id'] = $create_id;
						$dt1['allocatedToUserId'] = $this->resourceId;
						$dt1['allocatedDate'] = $st;
						$dt1['allocatedDateEnd'] = $endTime;
						$dt1['allocatedByUserId'] = $this->UORGUID;
						$dt1['createdOn'] = unix_to_human($now, TRUE, 'us');
						$allocate = $this->appointment_model->allocateAppointment($dt1);
						$data['json'] = json_encode(array("status" => "success", "message" => "Your Appointment Scheduled Successfully..", "data" => array("redirectionTime" => $resTime, "redirectionUrl" => $resUrl, "appointmentId" => $create_id)));
						$this->load->view('json_view', $data);
					} elseif ($create_id && $isAuto == 0) {
						//send email to applicant
						try {
							$this->email->subject("Your booking request has been submitted");
							$this->email->to($appDetails[0]->applicant_email);
							$msg1 = $this->load->view('email/madeBookingRequest', $dt0, TRUE);
							$this->email->message($msg1);
							$this->email->send();
						} catch (Exception $exc) {
						}
						$userNotification = $this->applicant_model->loadUserNotifyData($this->UORGID);
						if (isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking_request) && $userNotification[0]->notify_on_booking_request == 1) {
							//send email to Organization Admin
							try {
								$this->email->subject('Booking request from ' . $appDetails[0]->applicant_name);
								$this->email->to($orgEamil[0]->email);
								$msg = $this->load->view('email/bookingRequest', $dt0, TRUE);
								$this->email->message($msg);
								$this->email->send();
							} catch (Exception $exc) {
							}
						}
						$resTime = ($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
						$resUrl = ($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
						$data['json'] = json_encode(array("status" => "success", "message" => "Your request has been submitted successfully.", "data" => array("redirectionTime" => $resTime, "redirectionUrl" => $resUrl, "appointmentId" => $create_id)));
						$this->load->view('json_view', $data);
					} else {
						$data['json'] = json_encode(array("status" => "error", "message" => "Appointment Not Created.", "data" => ""));
						$this->load->view('json_view', $data);
					}
				} else {

					$data['app_title']		= $this->input->post('title', true);
					$data['app_desc']	    = $this->input->post('desc', true);
					$data['app_start']		= $st;
					$data['app_end']	    = $endTime;
					$data['applicant_name']	= $this->input->post('name', true);
					$data['applicant_email'] = $this->input->post('email', true);
					$data['applicant_phone'] = $this->input->post('phone', true);
					$data['applicant_location'] = $this->input->post('location', true);
					$data['org_id']			= $this->UORGID;
					$data['user_id']		= $this->resourceId;
					$data['is_deleted']	    = 0;
					$data['is_viewed']	    = 0;
					$data['app_timezone']	= $this->input->post("timezone", true);
					$data['appointmentCreatedOn']	= unix_to_human($now, TRUE, 'us');
					$create_id = $this->applicant_model->createAppointment($data);

					$this->load->library('email', $this->config->item('email_config'));
					$appDetails = $this->appointment_model->loadAppointment($create_id);
					$userDetail = $this->appointment_model->getUserDetail($this->resourceId);
					$dt0['logo']			= "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
					$dt0['user_email']		= $appDetails[0]->applicant_email;
					$dt0['scheduleDate']	= $st;
					$dt0['inspectorName']	= $userDetail[0]->firstname . " " . $userDetail[0]->lastname;
					$dt0['inspectorEmail']	= $userDetail[0]->email;
					$dt0['applicantName']	= $appDetails[0]->applicant_name;
					$dt0['applicantEmail']	= $appDetails[0]->applicant_email;
					$dt0['adminEmail']		= $orgEmail[0]->email;
					$dt0['bookingPage']		= $userDetail[0]->booking_url;
					$dt0['AppointmentTitle'] = $appDetails[0]->app_title;
					$this->email->from('support@makkinfotech.biz', 'Scheduler');

					if ($create_id && $isAuto == 1) {
						//send email to applicant
						try {
							$this->email->subject($appDetails[0]->app_title . ' - Scheduler confirmation');
							$this->email->to($appDetails[0]->applicant_email);
							$msg = $this->load->view('email/bookingConfirmed', $dt0, TRUE);
							$this->email->message($msg);
							$this->email->send();
						} catch (Exception $exc) {
						}
						$userNotification = $this->applicant_model->loadUserNotifyData($this->UORGID);
						if (isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking) && $userNotification[0]->notify_on_booking == 1) {
							//send email to Organization Admin
							try {
								$this->email->subject($appDetails[0]->app_title . ' has made a booking');
								$this->email->to($orgEmail[0]->email);
								$msg1 = $this->load->view('email/madeBooking', $dt0, TRUE);
								$this->email->message($msg1);
								$this->email->send();
							} catch (Exception $exc) {
							}
						}

						$resTime = ($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
						$resUrl = ($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
						$dt1['app_id'] = $create_id;
						$dt1['allocatedToUserId'] = $this->resourceId;
						$dt1['allocatedDate'] = $st;
						$dt1['allocatedDateEnd'] = $endTime;
						$dt1['allocatedByUserId'] = $this->UORGUID;
						$dt1['createdOn'] = unix_to_human($now, TRUE, 'us');
						$allocate = $this->appointment_model->allocateAppointment($dt1);
						$data['json'] = json_encode(array("status" => "success", "message" => "Your Appointment Scheduled Successfully..", "data" => array("redirectionTime" => $resTime, "redirectionUrl" => $resUrl, "appointmentId" => $create_id)));
						$this->load->view('json_view', $data);
					} elseif ($create_id && $isAuto == 0) {
						//send email to applicant
						try {
							$this->email->subject("Your booking request has been submitted");
							$this->email->to($appDetails[0]->applicant_email);
							$msg1 = $this->load->view('email/madeBookingRequest', $dt0, TRUE);
							$this->email->message($msg1);
							$this->email->send();
						} catch (Exception $exc) {
						}
						$userNotification = $this->applicant_model->loadUserNotifyData($this->UORGID);
						if (isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking_request) && $userNotification[0]->notify_on_booking_request == 1) {
							//send email to Organization Admin
							try {
								$this->email->subject('Booking request from ' . $appDetails[0]->applicant_name);
								$this->email->to($orgEamil[0]->email);
								$msg = $this->load->view('email/bookingRequest', $dt0, TRUE);
								$this->email->message($msg);
								$this->email->send();
							} catch (Exception $exc) {
							}
						}
						$resTime = ($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
						$resUrl = ($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
						$data['json'] = json_encode(array("status" => "success", "message" => "Your request has been submitted successfully.", "data" => array("redirectionTime" => $resTime, "redirectionUrl" => $resUrl, "appointmentId" => $create_id)));
						$this->load->view('json_view', $data);
					} else {
						$data['json'] = json_encode(array("status" => "error", "message" => "Appointment Not Created.", "data" => ""));
						$this->load->view('json_view', $data);
					}
				}
			}
			return;
		}
	}
	public function _checkSlotAvailability($mPId, $oId, $timeSlot, $selected_date)
	{
		try {
			$query = $this->db->query("SELECT * FROM master_booking_page_pages where master_booking_page_id=?", $mPId);
			if ($query->num_rows > 0) {

				foreach ($query->result() as $row1) {
					$bPageId = $row1->user_id;
					if (!$bPageId) {
						return false;
					}
					//$selected_date=$this->input->post("selected_date",true);
					$timezone = $this->input->post("timezone", true);
					$availableDate = date("D, M d, Y", strtotime($selected_date));
					$day = strtolower(date('l', strtotime($selected_date)));
					$workingPlans = $this->applicant_model->getSlots($bPageId);
					if (isset($workingPlans) && $workingPlans && isset($day) && $day) {
						$workingPlans = json_decode($workingPlans[0]->value);
						if (!$workingPlans->$day) {
							return false;
						}
						$slotGap = $workingPlans->$day->time_slots;
						$start = $workingPlans->$day->start;
						$end = $workingPlans->$day->end;
						$empty_periods = array(array("start" => $start, "end" => $end, "slots" => $slotGap));

						$uWorkPlan = $this->_loadUserWorkingPlan($selected_date, $bPageId);

						if ($uWorkPlan) {
							$start = $uWorkPlan['start'];
							$end = $uWorkPlan['end'];
							$empty_periods = array(array("start" => $start, "end" => $end, "slots" => $slotGap));
						}

						$available_hours = array();
						foreach ($empty_periods as $period) {
							$start_hour = new DateTime($selected_date . ' ' . $period['start']);
							$end_hour = new DateTime($selected_date . ' ' . $period['end']);
							$slt = $period['slots'];
							$minutes = $start_hour->format('i');
							$start_hour->setTime($start_hour->format('H'), $slt);
							$current_hour = $start_hour;
							$diff = $current_hour->diff($end_hour);

							while (($diff->h * 60 + $diff->i) >= intval($slt)) {
								$available_hours[] = $current_hour->format('H:i');
								$current_hour->add(new DateInterval("PT" . $slt . "M"));
								$diff = $current_hour->diff($end_hour);
							}
						}

						$curUnix = gmt_to_local(now(), $timezone, false);
						//echo date('m/d/Y', strtotime($selected_date))." and ".strtotime('now')." and ".unix_to_human($curUnix);
						if (date('m/d/Y', strtotime($selected_date)) == date('m/d/Y')) {
							$book_advance_timeout = $slt;
							foreach ($available_hours as $index => $value) {
								$available_hour = strtotime($value);
								$current_hour = strtotime('+' . $book_advance_timeout . ' minutes', $curUnix);
								if ($available_hour <= $current_hour) {
									unset($available_hours[$index]);
								}
							}
						}
						$available_hours = array_values($available_hours);
						sort($available_hours, SORT_STRING);
						$available_hours = array_values($available_hours);
						$loadAllocatedSlots = $this->appointment_model->loadAllocatedSlots($bPageId, $selected_date);
						$result = array_diff($available_hours, $loadAllocatedSlots);
						$result = array_values($result);
						sort($result, SORT_STRING);
						foreach ($result as $r) {
							if ($r == $timeSlot) {
								return $bPageId;
							}
						}
					} else {
						return false;
					}
				}
			}
		} catch (Exception $exc) {
			return false;
		}
	}
	function createAppointmentMaster()
	{
		//create appointment from master booking page
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		if ($_POST) {
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
				),
				array(
					'field' => 'phone',
					'label' => 'Phone Number',
					'rules' => 'trim|required',
				)
			);
			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() === false) {
				$this->form_validation->set_error_delimiters('<br />', '');
				$arrV[] = validation_errors();
				$data['json'] = json_encode(array("status" => "error", "message" => $arrV));
				$this->load->view('json_view', $data);
			} else {
				$appId = $this->input->post("appId", true);
				$masterPId = $this->input->post("mPageId", true);
				$st = $this->input->post('start', true);
				$arr = explode(" ", $st);
				if (count($arr) < 2) {
					$data['json'] = json_encode(array("status" => "error", "message" => array("Please select a time.")));
					$this->load->view('json_view', $data);
					return;
				}
				if (isset($masterPId) && $masterPId) {
					$this->resourceId = $this->_checkSlotAvailability($masterPId, $this->UORGUID, $arr[1], $arr[0]);
				} else {
					$data['json'] = json_encode(array("status" => "error", "message" => "Unable to create appointment.", "data" => ""));
					$this->load->view('json_view', $data);
					return;
				}

				if (!$this->resourceId) {
					$data['json'] = json_encode(array("status" => "error", "message" => "Unable to create appointment.", "data" => ""));
					$this->load->view('json_view', $data);
					return;
				}

				$orgEmail = $this->applicant_model->findOrgAdminEmail($this->UORGUID);

				$workingPlans = $this->applicant_model->getSlots($this->resourceId);
				$day = strtolower(date('l', strtotime($arr[0])));
				$slotGap = 30;
				if (isset($workingPlans) && $workingPlans && isset($day) && $day) {
					$workingPlans = json_decode($workingPlans[0]->value);
					$slotGap = $workingPlans->$day->time_slots;
				}
				$now = now();
				$minutes_to_add = $slotGap;

				$time = new DateTime($st);
				$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
				$endTime = $time->format('Y-m-d H:i');

				$isAuto = $this->applicant_model->getBookingPageSetting($this->resourceId);
				if (isset($isAuto) && $isAuto == 1) {
					$data['isAutoBooking'] = 1;
					$data['isApproved']	   = 1;
				} else {
					$data['isAutoBooking'] = 0;
				}
				if (isset($appId) && $appId) {

					$data['app_title']		= $this->input->post('title', true);
					$data['app_desc']	    = $this->input->post('desc', true);
					$data['app_start']		= $st;
					$data['app_end']	    = $endTime;
					$data['applicant_name']	= $this->input->post('name', true);
					$data['applicant_email'] = $this->input->post('email', true);
					$data['org_id']			= $this->UORGID;
					$data['user_id']		= $this->resourceId;
					$data['is_deleted']	    = 0;
					$data['is_viewed']	    = 0;
					$data['isApproved']		= 2;
					$data['applicant_phone'] = $this->input->post('phone', true);
					$data['applicant_location'] = $this->input->post('location', true);
					$data['rescheduled_appid'] = $appId;
					$data['app_timezone']	= $this->input->post("timezone", true);
					$data['appointmentCreatedOn']	= unix_to_human($now, TRUE, 'us');
					$create_id = $this->applicant_model->createAppointment($data);

					$this->load->library('email', $this->config->item('email_config'));
					$appDetails = $this->appointment_model->loadAppointment($create_id);
					$userDetail = $this->appointment_model->getUserDetail($this->resourceId);
					$dt0['logo']			= "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
					$dt0['user_email']		= $appDetails[0]->applicant_email;
					$dt0['scheduleDate']	= $st;
					$dt0['inspectorName']	= $userDetail[0]->firstname . " " . $userDetail[0]->lastname;
					$dt0['inspectorEmail']	= $userDetail[0]->email;
					$dt0['applicantName']	= $appDetails[0]->applicant_name;
					$dt0['applicantEmail']	= $appDetails[0]->applicant_email;
					$dt0['adminEmail']		= $orgEmail[0]->email;
					$dt0['bookingPage']		= $userDetail[0]->booking_url;
					$dt0['AppointmentTitle'] = $appDetails[0]->app_title;
					$this->email->from('support@makkinfotech.biz', 'Scheduler');

					if ($create_id && $isAuto == 1) {
						//send email to applicant
						try {
							$this->email->subject($appDetails[0]->app_title . ' - Scheduler confirmation');
							$this->email->to($appDetails[0]->applicant_email);
							$msg = $this->load->view('email/bookingConfirmed', $dt0, TRUE);
							$this->email->message($msg);
							$this->email->send();
						} catch (Exception $exc) {
						}
						$userNotification = $this->applicant_model->loadUserNotifyData($this->UORGID);
						if (isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking) && $userNotification[0]->notify_on_booking == 1) {
							//send email to Organization Admin
							try {
								$this->email->subject($appDetails[0]->app_title . ' has made a booking');
								$this->email->to($orgEmail[0]->email);
								$msg1 = $this->load->view('email/rescheduledConfirmed', $dt0, TRUE);
								$this->email->message($msg1);
								$this->email->send();
							} catch (Exception $exc) {
							}
						}
						$resTime = ($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
						$resUrl = ($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
						$dt1['app_id'] = $create_id;
						$dt1['allocatedToUserId'] = $this->resourceId;
						$dt1['allocatedDate'] = $st;
						$dt1['allocatedDateEnd'] = $endTime;
						$dt1['allocatedByUserId'] = $this->UORGUID;
						$dt1['createdOn'] = unix_to_human($now, TRUE, 'us');
						$allocate = $this->appointment_model->allocateAppointment($dt1);
						$data['json'] = json_encode(array("status" => "success", "message" => "Your Appointment Scheduled Successfully..", "data" => array("redirectionTime" => $resTime, "redirectionUrl" => $resUrl, "appointmentId" => $create_id)));
						$this->load->view('json_view', $data);
					} elseif ($create_id && $isAuto == 0) {
						//send email to applicant
						try {
							$this->email->subject("Your booking request has been submitted");
							$this->email->to($appDetails[0]->applicant_email);
							$msg1 = $this->load->view('email/madeBookingRequest', $dt0, TRUE);
							$this->email->message($msg1);
							$this->email->send();
						} catch (Exception $exc) {
						}
						$userNotification = $this->applicant_model->loadUserNotifyData($this->UORGID);
						if (isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking_request) && $userNotification[0]->notify_on_booking_request == 1) {
							//send email to Organization Admin
							try {
								$this->email->subject('Booking request from ' . $appDetails[0]->applicant_name);
								$this->email->to($orgEamil[0]->email);
								$msg = $this->load->view('email/bookingRequest', $dt0, TRUE);
								$this->email->message($msg);
								$this->email->send();
							} catch (Exception $exc) {
							}
						}
						$resTime = ($userDetail[0]->redirectionSec != '-1') ? $userDetail[0]->redirectionSec : '';
						$resUrl = ($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
						$data['json'] = json_encode(array("status" => "success", "message" => "Your request has been submitted successfully.", "data" => array("redirectionTime" => $resTime, "redirectionUrl" => $resUrl, "appointmentId" => $create_id)));
						$this->load->view('json_view', $data);
					} else {
						$data['json'] = json_encode(array("status" => "error", "message" => "Appointment Not Created.", "data" => ""));
						$this->load->view('json_view', $data);
					}
				} else {

					$data['app_title']		= $this->input->post('title', true);
					$data['app_desc']	    = $this->input->post('desc', true);
					$data['app_start']		= $st;
					$data['app_end']	    = $endTime;
					$data['applicant_name']	= $this->input->post('name', true);
					$data['applicant_email'] = $this->input->post('email', true);
					$data['applicant_phone'] = $this->input->post('phone', true);
					$data['applicant_location'] = $this->input->post('location', true);
					$data['org_id']			= $this->UORGID;
					$data['user_id']		= $this->resourceId;
					$data['is_deleted']	    = 0;
					$data['is_viewed']	    = 0;
					$data['app_timezone']	= $this->input->post("timezone", true);
					$data['appointmentCreatedOn']	= unix_to_human($now, TRUE, 'us');
					$create_id = $this->applicant_model->createAppointment($data);

					$this->load->library('email', $this->config->item('email_config'));
					$appDetails = $this->appointment_model->loadAppointment($create_id);
					$userDetail = $this->appointment_model->getUserDetail($this->resourceId);
					$dt0['logo']			= "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
					$dt0['user_email']		= $appDetails[0]->applicant_email;
					$dt0['scheduleDate']	= $st;
					$dt0['inspectorName']	= $userDetail[0]->firstname . " " . $userDetail[0]->lastname;
					$dt0['inspectorEmail']	= $userDetail[0]->email;
					$dt0['applicantName']	= $appDetails[0]->applicant_name;
					$dt0['applicantEmail']	= $appDetails[0]->applicant_email;
					$dt0['adminEmail']		= $orgEmail[0]->email;
					$dt0['bookingPage']		= $userDetail[0]->booking_url;
					$dt0['AppointmentTitle'] = $appDetails[0]->app_title;
					$this->email->from('support@makkinfotech.biz', 'Scheduler');

					if ($create_id && $isAuto == 1) {
						//send email to applicant
						try {
							$this->email->subject($appDetails[0]->app_title . ' - Scheduler confirmation');
							$this->email->to($appDetails[0]->applicant_email);
							$msg = $this->load->view('email/bookingConfirmed', $dt0, TRUE);
							$this->email->message($msg);
							$this->email->send();
						} catch (Exception $exc) {
						}
						$userNotification = $this->applicant_model->loadUserNotifyData($this->UORGID);
						if (isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking) && $userNotification[0]->notify_on_booking == 1) {
							//send email to Organization Admin
							try {
								$this->email->subject($appDetails[0]->app_title . ' has made a booking');
								$this->email->to($orgEmail[0]->email);
								$msg1 = $this->load->view('email/madeBooking', $dt0, TRUE);
								$this->email->message($msg1);
								$this->email->send();
							} catch (Exception $exc) {
							}
						}

						$resTime = ($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
						$resUrl = ($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
						$dt1['app_id'] = $create_id;
						$dt1['allocatedToUserId'] = $this->resourceId;
						$dt1['allocatedDate'] = $st;
						$dt1['allocatedDateEnd'] = $endTime;
						$dt1['allocatedByUserId'] = $this->UORGUID;
						$dt1['createdOn'] = unix_to_human($now, TRUE, 'us');
						$allocate = $this->appointment_model->allocateAppointment($dt1);
						$data['json'] = json_encode(array("status" => "success", "message" => "Your Appointment Scheduled Successfully..", "data" => array("redirectionTime" => $resTime, "redirectionUrl" => $resUrl, "appointmentId" => $create_id)));
						$this->load->view('json_view', $data);
					} elseif ($create_id && $isAuto == 0) {
						//send email to applicant
						try {
							$this->email->subject("Your booking request has been submitted");
							$this->email->to($appDetails[0]->applicant_email);
							$msg1 = $this->load->view('email/madeBookingRequest', $dt0, TRUE);
							$this->email->message($msg1);
							$this->email->send();
						} catch (Exception $exc) {
						}
						$userNotification = $this->applicant_model->loadUserNotifyData($this->UORGID);
						if (isset($userNotification) && $userNotification && isset($userNotification[0]->notify_on_booking_request) && $userNotification[0]->notify_on_booking_request == 1) {
							//send email to Organization Admin
							try {
								$this->email->subject('Booking request from ' . $appDetails[0]->applicant_name);
								$this->email->to($orgEamil[0]->email);
								$msg = $this->load->view('email/bookingRequest', $dt0, TRUE);
								$this->email->message($msg);
								$this->email->send();
							} catch (Exception $exc) {
							}
						}
						$resTime = ($userDetail[0]->redirectionSec) ? $userDetail[0]->redirectionSec : '';
						$resUrl = ($userDetail[0]->redirectionUrl) ? $userDetail[0]->redirectionUrl : '';
						$data['json'] = json_encode(array("status" => "success", "message" => "Your request has been submitted successfully.", "data" => array("redirectionTime" => $resTime, "redirectionUrl" => $resUrl, "appointmentId" => $create_id)));
						$this->load->view('json_view', $data);
					} else {
						$data['json'] = json_encode(array("status" => "error", "message" => "Appointment Not Created.", "data" => ""));
						$this->load->view('json_view', $data);
					}
				}
			}
			return;
		}
	}
	function updateAppointment()
	{
		//update appointment details
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		if ($_POST) {
			$st = $this->input->post('app_start', true);
			$arr = explode("T", $st);
			if (count($arr) < 2) {
				$data['json'] = json_encode(array("status" => "error", "message" => array("Select any slot.")));
				$this->load->view('json_view', $data);
				return;
			}
			$workingPlans = $this->applicant_model->getSlots($this->UORGID);
			$day = strtolower(date('l', strtotime($arr[0])));
			$slotGap = 30;
			if (isset($workingPlans) && $workingPlans && isset($day) && $day) {
				$workingPlans = json_decode($workingPlans[0]->value);
				$slotGap = $workingPlans->$day->time_slots;
			}
			$now = time();
			$minutes_to_add = $slotGap;

			$time = new DateTime($st);
			$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
			$endTime = $time->format('Y-m-d H:i');
			$appId					= $this->input->post('app_id', true);
			$data['app_title']		= $this->input->post('app_title', true);
			$data['app_start']		= $st;
			$data['app_end']	    = $endTime;
			$update = $this->applicant_model->update($appId, $data);
			$dArr = new stdClass();
			$dArr->id = $appId;
			$dArr->title = $this->input->post('app_title', true);
			$dArr->start = $st;
			$dArr->end = $endTime;
			$newArrData = array($dArr);
			if (isset($this->session->userdata['appointmentData']) && $this->session->userdata['appointmentData']) {
				$sessVal = $this->session->userdata['appointmentData'];
				foreach ($sessVal as $i => $val) {
					if ($val->id == $appId) {
						$val->id = $appId;
						$val->title = $this->input->post('app_title', true);
						$val->start = $st;
						$val->end = $endTime;
					}
				}
				$merged = $sessVal;
			}
			$this->session->set_userdata('appointmentData', $merged);

			if ($update) {
				$data['json'] = json_encode(array("status" => "success", "message" => "Appointment Updated Successfully.", "data" => ""));
				$this->load->view('json_view', $data);
			} else {
				$data['json'] = json_encode(array("status" => "error", "message" => "Appointment Not Updated.", "data" => ""));
				$this->load->view('json_view', $data);
			}
		}
		return;
	}
	function getTime()
	{
		$dtTime = $this->input->post("dateVal", true);
		$gap = $this->input->post("timeGap", true);
		$time = new DateTime($dtTime);
		$time->add(new DateInterval('PT' . $gap . 'M'));
		$finalTime = $time->format('Y-m-d H:i');
		$dt = date("D, M d, Y, h:i a", strtotime($dtTime)) . " - " . date("h:i a", strtotime($finalTime));
		$data['json'] = json_encode(array("status" => "success", "message" => "selected date time", "data" => $dt));
		$this->load->view('json_view', $data);
	}
}
