<?php
/*
 * Author: Mitesh Patel Date: 18/10/2014 Version: 1.0
 */
class Admins extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->library('form_validation');
		$this->load->library('schedular_auth');
		// $this->session->sess_destroy();
		if ($this->session->userdata('userid')) {
			$this->UID = $this->session->userdata("userid");
			$this->UORGID = $this->session->userdata("userOrganizationID");
			$this->UORGURL = $this->session->userdata("userOrganizationURL");
		}
		$this->load->helper('date');
	}
	function index()
	{
		$this->schedular_auth->_member_area_redirect();
		$data['main_content'] = 'admins/dashboard';
		$this->load->view('page', $data);
		return;
	}
	function recuring()
	{
		$data['main_content'] = 'admins/recuring';
		$this->load->view('page1', $data);
		return;
	}
	function getLinks()
	{
		// get organization booking links and master links
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$dt['bookingLinks'] = $this->admin_model->orgBookingLinks($this->UORGID, $this->UORGURL);
		$dt['masterLinks'] = $this->admin_model->orgMasterLinks($this->UORGID, $this->UORGURL);
		$data['json'] = json_encode(array(
			"status" => "success",
			"message" => "links",
			"data" => $dt
		));
		$this->load->view('json_view', $data);
		return;
	}
	function appointmentInfo()
	{
		//get appointment information through appointment id
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$id = $this->input->post("appId", true);
		if (!isset($id) || !$id) {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "No data found",
				"data" => ""
			));
			$this->load->view('json_view', $data);
			return;
		}
		$this->load->model("appointments/appointment_model");
		$this->load->model("applicant/applicant_model");
		$dt['appInfo'] = $this->appointment_model->loadAppointment($id);
		$startDT = strtotime($dt['appInfo'][0]->app_start);
		$endDT = strtotime($dt['appInfo'][0]->app_end);
		$dt['time'] = round(abs($endDT - $startDT) / 60, 2);
		$dt['appTime'] = date("D, M d, Y, h:i a", $startDT) . " - " . date("h:i a", $endDT);
		$dt['pageInfo'] = $this->applicant_model->getPageInfo($dt['appInfo'][0]->user_id);
		$data['json'] = json_encode(array(
			"status" => "success",
			"message" => "appointmentInfo",
			"data" => $dt
		));
		$this->load->view('json_view', $data);
		return;
	}
	function appointmentTrashInfo()
	{
		// appointment trash information using appId
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$id = $this->input->post("appId", true);
		if (!isset($id) || !$id) {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "No data found",
				"data" => ""
			));
			$this->load->view('json_view', $data);
			return;
		}
		$this->load->model("appointments/appointment_model");
		$this->load->model("applicant/applicant_model");
		$dt['appInfo'] = $this->appointment_model->loadTrashAppointment($id);
		$startDT = strtotime($dt['appInfo'][0]->app_start);
		$endDT = strtotime($dt['appInfo'][0]->app_end);
		$dt['time'] = round(abs($endDT - $startDT) / 60, 2);
		$dt['appTime'] = date("D, M d, Y, h:i a", $startDT) . " - " . date("h:i a", $endDT);
		$dt['pageInfo'] = $this->applicant_model->getPageInfo($dt['appInfo'][0]->user_id);
		$data['json'] = json_encode(array(
			"status" => "success",
			"message" => "appointmentInfo",
			"data" => $dt
		));
		$this->load->view('json_view', $data);
		return;
	}

	function dashboard()
	{
		//dashboard view with some data
		$this->load->model("appointments/appointment_model");
		$this->schedular_auth->_member_area_redirect();
		if ($this->UORGURL != $this->uri->segment(1)) {
			$data['RedirectUrl'] = base_url() . $this->UORGURL . '/admin/dashboard';
			$this->load->view('404_Page_url', $data);
			return;
		}
		$appData = $this->admin_model->getAppTotalData($this->UORGID);
		$data['pageList'] = $this->admin_model->loadResources($this->UORGID);
		$data['app_data'] = $appData;
		$data['appointments'] = $this->appointment_model->appointmentsAsArray($this->UORGID);
		$data['BPages'] = $this->admin_model->bookingPages($this->UORGID);
		$data['MBPages'] = $this->admin_model->masterBookingPages($this->UORGID);
		$data['main_content'] = 'admins/dashboard';
		$this->load->view('page', $data);
	}

	function loadActivities()
	{
		// load activities
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->load->model("appointments/appointment_model");
		$sts = $this->input->post("status", true);
		$source = $this->input->post("source", true);
		$dt['appointments'] = $this->appointment_model->getAppointmentsByFilter($this->UORGID, $sts, $source);
		$dt['main_content'] = 'dashboard_activities';
		$d = $this->load->view('outputPage', $dt, true);
		$this->output->set_output($d);
		return;
	}
	function loadTrash()
	{
		// load trash information
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->load->model("appointments/appointment_model");
		$dt['appointments'] = $this->appointment_model->appointmentsDeleted($this->UORGID);
		$dt['main_content'] = 'trash_activities';
		$d = $this->load->view('outputPage', $dt, true);
		$this->output->set_output($d);
		return;
	}
	function configuration()
	{
		// load configuration details
		$this->schedular_auth->_member_area_redirect();
		$data['org_url'] = $this->UORGURL;
		$data['main_content'] = 'admins/configuration';
		$this->load->view('page', $data);
	}
	function manageCalendars()
	{
		// manage calendars
		$this->schedular_auth->_member_area_redirect();
		$this->load->model('inspection/inspection_model');
		$data['inspections'] = $this->inspection_model->appointmentsTypes($this->UID);
		$data['resources'] = $this->admin_model->loadResources($this->UORGID);
		$data['calendarSelectedId'] = $this->input->post("id", true);
		$data['main_content'] = 'admins/manageCalendars';
		$this->load->view('page', $data);
		return;
	}
	function loadResources()
	{
		// load resources ajax call
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$dt['resources'] = $this->admin_model->loadResources($this->UORGID);
		$data['json'] = json_encode(array(
			"status" => "success",
			"message" => "Resources",
			"data" => $dt
		));
		$this->load->view('json_view', $data);
		return;
	}
	function resignin()
	{
		$str = $this->uri->uri_string();
		redirect($str . "/signin");
		return;
	}
	function loadAppointmentTypes()
	{
		// load appointment types ajax
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$dt['app_types'] = $this->admin_model->appointmentsTypes();
		$data['json'] = json_encode(array(
			"status" => "success",
			"message" => "app_types",
			"data" => $dt
		));
		$this->load->view('json_view', $data);
		return;
	}
	function settings()
	{
		// settings page
		$this->schedular_auth->_member_area_redirect();
		$data['userID'] = $this->UID;
		$data['orgID'] = $this->UORGID;
		$orgInfo = $this->admin_model->getOrgInfo($this->UORGID);
		$userInfo = $this->admin_model->getUserInfo($this->UID);
		$data['orgTitle'] = $orgInfo[0]->org_title;
		$data['userInfo'] = $userInfo;
		$data['orgURL'] = base_url() . $this->UORGURL;
		$data['org_email'] = $orgInfo[0]->org_email;
		$data['org_phone'] = $orgInfo[0]->org_phone;
		$data['main_content'] = 'admins/settings';
		$this->load->view('page', $data);
		return;
	}
	public function loadTimeSlots()
	{
		// load timeslots ajax call
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		try {
			$selected_date = $this->input->post("selected_date", true);
			$day = strtolower(date('l', strtotime($selected_date)));
			$workingPlans = $this->admin_model->getSlots($this->UORGID);

			if (isset($workingPlans) && $workingPlans && isset($day) && $day) {
				$workingPlans = json_decode($workingPlans[0]->value);
				$slotGap = $workingPlans->$day->time_slots;
				$start = $workingPlans->$day->start;
				$end = $workingPlans->$day->end;
				$empty_periods = array(
					array(
						"start" => $start,
						"end" => $end,
						"slots" => $slotGap
					)
				);

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
				$dt['slots'] = $available_hours;
				$data['json'] = json_encode(array(
					"status" => "success",
					"message" => "Slots",
					"data" => $dt
				));
				$this->load->view('json_view', $data);
				return;
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => "There are no slots available for this day. Please choose another day for appointment.",
					"data" => ""
				));
				$this->load->view('json_view', $data);
				return;
			}
		} catch (Exception $exc) {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => array(
					'exceptions' => array(
						exceptionToJavaScript($exc)
					)
				),
				"data" => ""
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	public function loadOrganizationNotWorkingDays()
	{
		//load organization not working days ajax call
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		try {
			$notWorkingDates = $this->admin_model->loadOrganizationNotWorkingDays($this->UORGID);
			if ($notWorkingDates) {
				$dt['notWorkingDays'] = $notWorkingDates;
				$data['json'] = json_encode(array(
					"status" => "success",
					"message" => "notWorkingDays",
					"data" => $dt
				));
				$this->load->view('json_view', $data);
			} else {
				$dt['notWorkingDays'] = $notWorkingDates;
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => "unable to find not working days",
					"data" => ""
				));
				$this->load->view('json_view', $data);
			}
			return;
		} catch (Exception $exc) {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => array(
					'exceptions' => array(
						exceptionToJavaScript($exc)
					)
				),
				"data" => ""
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	public function loadPageNotWorkingDays()
	{
		//load page not working dayas ajax call
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->load->model("applicant/applicant_model");
		$pageId = $this->input->post("pageId", true);
		if (isset($pageId) && $pageId) {
			$notWorkingDates = $this->applicant_model->loadPageNotWorkingDays($pageId);
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
	}
	public function loadPageHolidaysData()
	{
		// load page holidays ajax call
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->load->model("applicant/applicant_model");
		$pageId = $this->input->post("pageId", true);
		if (isset($pageId) && $pageId) {
			$data['org_id'] = $this->UORGID;
			$data['holidays'] = $this->applicant_model->loadHolidaysData($this->UORGID, $pageId);
			$data['json'] = json_encode(array("status" => "success", "message" => "Holidays", "data" => $data));
			$this->load->view('json_view', $data);
			return;
		} else {
			$data['org_id'] = $this->UORGID;
			$data['holidays'] = array();
			$data['json'] = json_encode(array("status" => "success", "message" => "Holidays", "data" => $data));
			$this->load->view('json_view', $data);
			return;
		}
	}
	public function loadUsersNotWorkingDays()
	{
		//load Resource not working days
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		try {
			$appTypeId = $this->input->post("appointmentTypeId", true);
			$notWorkingDates = $this->admin_model->loadUserNotWorkingDays($appTypeId);
			if ($notWorkingDates) {
				$dt['notWorkingDays'] = $notWorkingDates; // array(array("title"=>"Not Working","start"=>"2014-11-07"),array("title"=>"Not Working","start"=>"2014-11-11"));
				$data['json'] = json_encode(array(
					"status" => "success",
					"message" => "notWorkingDays",
					"data" => $dt
				));
				$this->load->view('json_view', $data);
			} else {
				$dt['slots'] = $notWorkingDates;
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => "unable to find not working days",
					"data" => ""
				));
				$this->load->view('json_view', $data);
			}
			return;
		} catch (Exception $exc) {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => array(
					'exceptions' => array(
						exceptionToJavaScript($exc)
					)
				),
				"data" => ""
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function signin()
	{
		// user signin
		if (isset($_POST['signup'])) {
			$str = $this->uri->uri_string();
			$arr = explode("/", $str);
			array_pop($arr);
			$newurl = implode("/", $arr);
			redirect($newurl . "/signup");
			return;
		}
		if ($_POST) {
			$config = array(
				array(
					'field' => 'email',
					'label' => 'E-mail',
					'rules' => 'trim|required|valid_email'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required'
				)
			);

			$this->form_validation->set_rules($config);

			if ($this->form_validation->run() === false) {
				$data['error'] = validation_errors();
				$data['main_content'] = 'admins/signin';
				$this->load->view('page', $data);
				return;
			} else {
				// Data
				$user_email = $this->input->post('email', true);
				$password = $this->input->post('password', true);
				$this->schedular_auth->process_login(array(
					$user_email,
					$password
				));
			}
			return;
		}

		// Redirect
		$this->schedular_auth->_member_signin_redirect();
		$data['main_content'] = 'admins/signin';
		$this->load->view('page', $data);
		return;
	}
	function updateOrganization()
	{
		//update organization details
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		if ($_POST) {
			$orgatinID = $this->input->post('org_id', true);
			if (isset($orgatinID) && $orgatinID) {
				$config1 = array(
					array(
						'field' => 'org_title',
						'label' => 'Organization Title',
						'rules' => 'trim|required'
					),
					array(
						'field' => 'orgEmail',
						'label' => 'Organization Email',
						'rules' => 'trim|valid_email'
					)
				);

				$this->form_validation->set_rules($config1);
				$u_id = 0;
				if ($this->form_validation->run() === false) {
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[] = validation_errors();
					$data['json'] = json_encode(array(
						"status" => "error",
						"message" => $arrV
					));
					$this->load->view('json_view', $data);
					return;
				} else {

					$udata['org_title'] = $this->input->post('org_title', true);
					$udata['org_phone'] = $this->input->post('orgPhoneNumber', true);
					$udata['org_email'] = $this->input->post('orgEmail', true);

					$u_id = $this->admin_model->updateOrg($orgatinID, $udata);
					if ($u_id) {
						$data['json'] = json_encode(array(
							"status" => "success",
							"message" => "Organization Updated Successfully."
						));
						$this->load->view('json_view', $data);
						return;
					}
				}
			}
		}
	}
	function addBookingPage()
	{
		//add booking page
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$config1 = array(
			array(
				'field' => 'bookingPage',
				'label' => 'Booking Page',
				'rules' => 'trim|required|alpha_dash|min_length[4]|max_length[30]'
			)
		);

		$this->form_validation->set_rules($config1);
		$u_id = 0;
		if ($this->form_validation->run() === false) {
			$this->form_validation->set_error_delimiters(' ', ' ');
			$arrV[] = validation_errors();
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => $arrV
			));
			$this->load->view('json_view', $data);
			return;
		} else {
			$pageUrl = $this->input->post("bookingPage", true);
			$isBPageUrlAvailable = $this->admin_model->isAvailableBookingPageUrl($pageUrl);
			if ($isBPageUrlAvailable) {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => "The Booking Page field must contain a unique value."
				));
				$this->load->view('json_view', $data);
				return;
			}
			$this->load->model('inspection/inspection_model');
			$isMPageUrlAvailable = $this->inspection_model->isAvailableMBookingPageUrl($pageUrl);
			if ($isMPageUrlAvailable) {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => "The Booking Page field must contain a unique value."
				));
				$this->load->view('json_view', $data);
				return;
			}
			$ownerName = $this->input->post("owner", true);
			$pageId = $this->input->post("bookingPageId", true);
			$this->load->helper('date');
			$now = time();
			if (isset($pageId) && $pageId) {
				$insertId = $this->admin_model->makeDuplicateEntry($pageId);
				if (isset($insertId) && $insertId) {
					$pData['booking_url'] = $pageUrl;
					$pData['name'] = $pageUrl;
					$pData['firstname'] = $ownerName;
					$pData['createdOn'] = unix_to_human($now, TRUE, 'us');
					$update = $this->admin_model->update($insertId, $pData);
					if ($update) {
						$this->admin_model->copySettings($pageId, $insertId);
						$this->admin_model->copyApplicantNotifications($pageId, $insertId);
						$this->admin_model->copyUserNotifications($pageId, $insertId);
						$this->admin_model->copyHolidays($pageId, $insertId);
						$data['json'] = json_encode(array(
							"status" => "success",
							"message" => "Duplicate Booking Page Created Successfully."
						));
						$this->load->view('json_view', $data);
						return;
					}
				} else {
					$data['json'] = json_encode(array(
						"status" => "error",
						"message" => "Unable to make booking page."
					));
					$this->load->view('json_view', $data);
					return;
				}
			} else {

				$udata['email'] = "";
				$udata['password'] = "";
				$udata['salt'] = "";
				$udata['firstname'] = $ownerName;
				$udata['lastname'] = "";
				$udata['name'] = $pageUrl;
				$udata['booking_url'] = $pageUrl;
				$udata['mobileno'] = "";
				$udata['gender'] = "";
				$udata['isVerifiedBySAdmin'] = 1;
				$udata['isSuperAdmin'] = 0;
				$udata['status'] = 1;
				$udata['createdOn'] = unix_to_human($now, TRUE, 'us');
				$udata['org_id'] = $this->UORGID;
				$u_id = $this->admin_model->createUser($udata);
				if ($u_id) {
					$this->admin_model->setResourceDefaultWorkingPlan($this->UORGID, $u_id);
					$this->load->model('users/user_model');
					$this->user_model->setResourceDefaultHolidays($this->UORGID, $u_id);
					$data['json'] = json_encode(array(
						"status" => "success",
						"message" => "Booking Page Created Successfully."
					));
					$this->load->view('json_view', $data);
					return;
				}
			}
		}
	}
	function loadBookingPageDetails()
	{
		//load booking page details ajax call
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$resourceId = $this->input->post("pageId", true);
		if (isset($resourceId) && $resourceId) {
			if ($this->admin_model->validateOrgUser($resourceId, $this->UORGID)) {
				$link = $this->admin_model->getApplicantLink($resourceId);
				$sts = "Enabled";
				if ($link[0]->status == 0)
					$sts = "Disabled";
				$data['applicantLinkStatus'] = $sts;
				$data['applicantLink'] = base_url() . $this->UORGURL . "/" . $link[0]->booking_url;
				$data['pageInfo'] = $this->admin_model->getUserInfo($resourceId);
				if (isset($data['pageInfo'][0]->logo_url) && $data['pageInfo'][0]->logo_url)
					$data['imagePath'] = base_url() . "uploads/bookingPage/" . $data['pageInfo'][0]->logo_url . "_thumb.jpg";
				else
					$data['imagePath'] = "";
				$data['json'] = json_encode(array(
					"status" => "success",
					"message" => "Booking Page Information",
					"data" => $data
				));
				$this->load->view('json_view', $data);
				return;
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => $this->config->item('unauthorized_access')
				));
				$this->load->view('json_view', $data);
				return;
			}
		} else {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "Unable to get page information"
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function loadUserNotifications()
	{
		//load user notifications ajax call
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$data['userNotifications'] = $this->admin_model->getUserNotification($this->UID);
		$data['json'] = json_encode(array(
			"status" => "success",
			"message" => "User Notifications",
			"data" => $data
		));
		$this->load->view('json_view', $data);
		return;
	}
	function loadMasterBookingPagePages()
	{
		// load master booking pages ajax call
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$resourceId = $this->input->post("pageId", true);
		if (isset($resourceId) && $resourceId) {
			if ($this->admin_model->validateOrgMasterPage($resourceId, $this->UORGID)) {
				$data['url'] = base_url() . $this->UORGURL . "/";
				$data['pageInfo'] = $this->admin_model->getPageInfo($resourceId, $this->UORGID);
				$data['json'] = json_encode(array(
					"status" => "success",
					"message" => "Booking Page Pages",
					"data" => $data
				));
				$this->load->view('json_view', $data);
				return;
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => $this->config->item('unauthorized_access')
				));
				$this->load->view('json_view', $data);
				return;
			}
		} else {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "Unable to get page information"
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function loadApplicantNotifications()
	{
		//load applicant notifications ajax call
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$resourceId = $this->input->post("pageId", true);
		if (isset($resourceId) && $resourceId) {
			if ($this->admin_model->validateOrgUser($resourceId, $this->UORGID)) {
				$data['applicantNotifications'] = $this->admin_model->getApplicantNotification($resourceId);
				$data['json'] = json_encode(array(
					"status" => "success",
					"message" => "Applicant Notifications",
					"data" => $data
				));
				$this->load->view('json_view', $data);
				return;
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => $this->config->item('unauthorized_access')
				));
				$this->load->view('json_view', $data);
				return;
			}
		} else {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "Unable to find notifications",
				"data" => $data
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function loadApplicantLink()
	{
		//load application links
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$resourceId = $this->input->post("pageId", true);
		if (isset($resourceId) && $resourceId) {
			if ($this->admin_model->validateOrgUser($resourceId, $this->UORGID)) {
				$link = $this->admin_model->getApplicantLink($resourceId);
				$sts = "Enabled";
				if ($link[0]->status == 0)
					$sts = "Disabled";
				$data['applicantLinkStatus'] = $sts;
				$data['applicantLink'] = base_url() . $this->UORGURL . "/" . $link[0]->booking_url;
				$data['json'] = json_encode(array(
					"status" => "success",
					"message" => "Applicant Link",
					"data" => $data
				));
				$this->load->view('json_view', $data);
				return;
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => $this->config->item('unauthorized_access')
				));
				$this->load->view('json_view', $data);
				return;
			}
		} else {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "Unable to find notifications",
				"data" => $data
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function saveApplicantStatus()
	{
		//update applicant status
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$resourceId = $this->input->post("pageId", true);
		$updatedsts = $this->input->post("status", true);
		if (isset($resourceId) && $resourceId) {
			if ($this->admin_model->validateOrgUser($resourceId, $this->UORGID)) {
				$udata['status'] = $updatedsts;
				$updateData = $this->admin_model->update($resourceId, $udata);
				if ($updateData) {
					$link = $this->admin_model->getApplicantLink($resourceId);
					$sts = "Enabled";
					if ($link[0]->status == 0)
						$sts = "Disabled";
					$data['applicantLinkStatus'] = $sts;
					$data['applicantLink'] = base_url() . $this->UORGURL . "/" . $link[0]->booking_url;
					$data['json'] = json_encode(array(
						"status" => "success",
						"message" => "Applicant Link Status",
						"data" => $data
					));
					$this->load->view('json_view', $data);
					return;
				} else {
					$data['json'] = json_encode(array(
						"status" => "error",
						"message" => "Unable to save Link Status"
					));
					$this->load->view('json_view', $data);
					return;
				}
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => $this->config->item('unauthorized_access')
				));
				$this->load->view('json_view', $data);
				return;
			}
		} else {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "Unable to find Link Status",
				"data" => $data
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function saveApplicantNotifications()
	{
		// update applicant notification details
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$resourceId = $this->input->post("bookingPageId", true);
		if (isset($resourceId) && $resourceId) {
			$this->load->helper('date');
			$now = time();
			$remVal = $this->input->post('reminderVal');
			if (isset($remVal) && $remVal)
				$remVal = json_encode($remVal);
			else
				$remVal = "";
			$udata['bookingPageId'] = $resourceId;
			$udata['reminderVal'] = $remVal;
			$udata['reminderNote'] = $this->input->post('reminderNote');
			$udata['followupEmailVal'] = $this->input->post('followupEmailVal');
			$udata['followupEmailNote'] = $this->input->post('followupEmailNote');
			$uNoti = $this->admin_model->getApplicantNotification($resourceId);
			if ($uNoti) {
				$u_id = $this->admin_model->updateApplicantNotifications($resourceId, $udata);
			} else {
				$u_id = $this->admin_model->createApplicantNotifications($udata);
			}
			if ($u_id) {
				$data['json'] = json_encode(array(
					"status" => "success",
					"message" => "Customer Notification Saved Successfully."
				));
				$this->load->view('json_view', $data);
				return;
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => "Unable to store information"
				));
				$this->load->view('json_view', $data);
				return;
			}
		} else {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "Unable to find notifications"
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function saveUserNotifications()
	{
		// update user notification details
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$this->load->helper('date');
		$now = time();
		$udata['notify_on_booking'] = $this->input->post('no_on_booking');
		$udata['notify_on_booking_request'] = $this->input->post('no_on_booking_req');
		$udata['notify_on_cancellations'] = $this->input->post('no_on_cancel');
		$udata['cc_on_applicant_reminders'] = $this->input->post('cc_on_cus_rem');
		$udata['cc_on_followup_emails'] = $this->input->post('cc_on_follow_email');
		$uNoti = $this->admin_model->getUserNotification($this->UID);
		if ($uNoti) {
			$u_id = $this->admin_model->updateUserNotifications($this->UID, $udata);
		} else {
			$u_id = $this->admin_model->createUserNotifications($udata);
		}
		if ($u_id) {
			$data['json'] = json_encode(array(
				"status" => "success",
				"message" => "User Notification Saved Successfully."
			));
			$this->load->view('json_view', $data);
			return;
		} else {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "Unable to store information"
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function saveLocation()
	{
		//update page location
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$resourceId = $this->input->post("pageIdLocation", true);
		if (isset($resourceId) && $resourceId) {
			$location = $this->input->post("location", true);
			if (! $location)
				$location = "";
			if ($this->admin_model->validateOrgUser($resourceId, $this->UORGID)) {
				$udata['location'] = $location;
				$u_id = $this->admin_model->update($resourceId, $udata);
				if ($u_id) {
					$data['json'] = json_encode(array(
						"status" => "success",
						"message" => "Information Saved Successfully."
					));
					$this->load->view('json_view', $data);
					return;
				}
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => $this->config->item('unauthorized_access')
				));
				$this->load->view('json_view', $data);
				return;
			}
		} else {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "Unable to save information"
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function saveBookingAuto()
	{
		//update booking page redirection details
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$resourceId = $this->input->post("pageId", true);
		$rUrl = $this->input->post("redirectionUrl", true);
		$rSec = $this->input->post("redirectionSec", true);
		if (isset($resourceId) && $resourceId) {
			$booking = $this->input->post("bookingAuto", true);
			if ($this->admin_model->validateOrgUser($resourceId, $this->UORGID)) {
				$udata['isAutomaticBooking'] = $booking;
				$udata['redirectionSec'] = ($rSec) ? $rSec : '-1';
				$udata['redirectionUrl'] = ($rUrl) ? $rUrl : '';
				$u_id = $this->admin_model->update($resourceId, $udata);
				if ($u_id) {
					$data['json'] = json_encode(array(
						"status" => "success",
						"message" => "Information Saved Successfully."
					));
					$this->load->view('json_view', $data);
					return;
				}
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => $this->config->item('unauthorized_access')
				));
				$this->load->view('json_view', $data);
				return;
			}
		} else {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "Unable to save information"
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function deleteBookingPage()
	{
		//delete booking page
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		if ($_POST) {
			$config1 = array(
				array(
					'field' => 'pageId',
					'label' => 'Booking page ID',
					'rules' => 'trim|required'
				)
			);

			$this->form_validation->set_rules($config1);
			if ($this->form_validation->run() === false) {
				$this->form_validation->set_error_delimiters(' ', ' ');
				$arrV[] = validation_errors();
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => $arrV
				));
				$this->load->view('json_view', $data);
				return;
			} else {
				$ID = $this->input->post('pageId', true);
				$dt['IsDeleted'] = 1;
				$u_id = $this->admin_model->update($ID, $dt);
				if ($u_id) {
					$data['json'] = json_encode(array(
						"status" => "success",
						"message" => "Booking Page Deleted Successfully."
					));
					$this->load->view('json_view', $data);
					return;
				}
			}
		}
	}
	function saveBookingPage()
	{
		//update booking page
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$config1 = array(
			array(
				'field' => 'bookingPageName',
				'label' => 'Booking Page Name',
				'rules' => 'trim|required'
			)
		);

		$this->form_validation->set_rules($config1);
		$u_id = 0;
		if ($this->form_validation->run() === false) {
			$this->form_validation->set_error_delimiters(' ', ' ');
			$arrV[] = validation_errors();
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => $arrV
			));
			$this->load->view('json_view', $data);
			return;
		} else {
			$resourceId = $this->input->post("pageId", true);
			if (isset($resourceId) && $resourceId) {
				$pageName = $this->input->post("bookingPageName", true);
				$email = $this->input->post("pageEmail", true);
				if (! $email)
					$email = "";
				$phone = $this->input->post("pagePhone", true);
				if (! $phone)
					$phone = "";
				$welcome = $this->input->post("pageWelcomeMsg", true);
				if (! $welcome)
					$welcome = "";

				$this->load->helper('date');
				$now = time();
				$this->load->library('typography');
				if ($this->admin_model->validateOrgUser($resourceId, $this->UORGID)) {
					$udata['email'] = $email;
					$udata['firstname'] = $pageName;
					$udata['name'] = $pageName;
					$udata['mobileno'] = $phone;
					$udata['pageInfo'] = $this->typography->auto_typography($welcome);
					$u_id = $this->admin_model->update($resourceId, $udata);
					if ($u_id) {
						$data['json'] = json_encode(array(
							"status" => "success",
							"message" => "Booking Page Information Saved Successfully."
						));
						$this->load->view('json_view', $data);
						return;
					}
				} else {
					$data['json'] = json_encode(array(
						"status" => "error",
						"message" => $this->config->item('unauthorized_access')
					));
					$this->load->view('json_view', $data);
					return;
				}
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => "Unable to save information"
				));
				$this->load->view('json_view', $data);
				return;
			}
		}
	}
	function signup()
	{
		//signup with organization details
		if (isset($_POST['login'])) {
			$str = $this->uri->uri_string();
			$arr = explode("/", $str);
			array_pop($arr);
			$newurl = implode("/", $arr);
			redirect($newurl . "/signin");
			return;
		}
		if (isset($_POST['back'])) {
			$str = $this->uri->uri_string();
			$arr = explode("/", $str);
			array_pop($arr);
			$newurl = implode("/", $arr);
			redirect($newurl . "/signin");
			return;
		}
		if ($_POST) {
			$config = array(
				array(
					'field' => 'org_title',
					'label' => 'Organization Title',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'org_url',
					'label' => 'Organization URL',
					'rules' => 'trim|required|is_unique[organizations.org_url]|alpha_dash|min_length[4]|max_length[30]'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cpassword',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|matches[password]'
				),
				array(
					'field' => 'firstname',
					'label' => 'First Name',
					'rules' => 'trim|required'
				)
			);

			$this->form_validation->set_rules($config);
			$u_id = 0;
			if ($this->form_validation->run() === false) {
				$data['error'] = validation_errors();
				$data['main_content'] = 'admins/signup';
				$this->load->view('page', $data);
				return;
			} else {
				$email = $this->input->post('email', true);
				if ($email && $this->admin_model->validateEmail($email)) {
					$data['error'] = "Email Address Already Exists.";
					$data['main_content'] = 'admins/signup';
					$this->load->view('page', $data);
					return;
				}
				$this->load->helper('date');
				$now = time();
				$data['org_title'] = $this->input->post('org_title', true);
				$data['org_url'] = $this->input->post('org_url', true);
				$data['is_deleted'] = 0;
				$data['createdon'] = unix_to_human($now, TRUE, 'us');
				$data['timezone'] = "+05:30";
				$orgID = $this->admin_model->createOrganization($data);
				$rand_salt = $this->schedular_auth->genRndSalt();
				$encrypt_pass = $this->schedular_auth->encryptUserPwd($this->input->post('password'), $rand_salt);
				$lastN = "";
				if ($this->input->post('lastname', true)) {
					$lastN = $this->input->post('lastname', true);
				}
				if ($orgID) {
					$udata['email'] = $email;
					$udata['password'] = $encrypt_pass;
					$udata['salt'] = $rand_salt;
					$udata['firstname'] = $this->input->post('firstname', true);
					$udata['lastname'] = $this->input->post('lastname', true);
					$udata['name'] = $this->input->post('firstname', true) . " " . $lastN;
					$udata['mobileno'] = $this->input->post('mobileno', true);
					$udata['gender'] = $this->input->post('gender', true);
					$udata['isVerifiedBySAdmin'] = 1;
					$udata['isSuperAdmin'] = 1;
					$udata['status'] = 1;
					$udata['createdOn'] = unix_to_human($now, TRUE, 'us');
					$udata['org_id'] = $orgID;
					$u_id = $this->admin_model->createUser($udata);
				} else {
					$data['error'] = "Unable to Create Your Account. Please Try Again.";
					$data['main_content'] = 'admins/signup';
					$this->load->view('page', $data);
					return;
				}
			}
			if (isset($u_id) && $u_id != 0) {
				$this->admin_model->updateOrg($orgID, array(
					"org_user_id" => $u_id
				));
			}
			try {
				$dt['logo'] = "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
				$dt['user_email'] = $email;
				$this->load->library('email', $this->config->item('email_config'));
				$this->email->from('support@makkinfotech.biz', 'Scheduler');
				$this->email->to($email);
				$this->email->subject('Welcome To Scheduler');
				$msg = $this->load->view('email/scheduler_signup_mail', $dt, TRUE);
				$this->email->message($msg);
				$this->email->send();
			} catch (Exception $e) {
			}


			$data['message'] = "Your Account Created Successfully.Click on Login Button.";
			$data['main_content'] = 'admins/signup';
			$this->load->view('page', $data);
			return;
		}
		$this->schedular_auth->_member_signin_redirect();
		$data['main_content'] = 'admins/signup';
		$this->load->view('page', $data);
		return;
	}
	function logout()
	{
		$this->session->unset_userdata("userid");
		$this->session->unset_userdata("isSuperAdmin");
		$this->session->unset_userdata("userOrganizationID");
		$this->session->unset_userdata("userOrganizationURL");
		$this->session->unset_userdata("logged_in");
		$this->session->unset_userdata("fullname");
		redirect('signin', 'refresh');
	}
	function pendingRequests()
	{
		//display all pending request
		$this->schedular_auth->_member_area_redirect();
		$data['requests'] = $this->admin_model->pendingRequests();
		$data['main_content'] = 'admins/pendingReq';
		$this->load->view('page', $data);
		return;
	}
	function approveRequest()
	{
		//approve any request
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		if ($_POST) {
			$appUID = $this->input->post('approveUserID', true);
			$dt['isVerifiedBySAdmin'] = 1;
			if (isset($appUID) && $appUID) {
				$uEmail = $this->admin_model->userEmailByID($appUID);
				$approve = $this->admin_model->update($appUID, $dt);
				$org = $this->admin_model->getOrgName($appUID);
				if ($approve) {
					$dt['logo'] = "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png"; // base_url()."themes/front/images/logo_64.png";
					$dt['user_email'] = $uEmail;
					$dt['link'] = base_url() . $org;
					$this->load->library('email', $this->config->item('email_config'));
					$this->email->from('support@makkinfotech.biz', 'Schedular');
					$this->email->to($uEmail);
					$this->email->subject('Welcome To Schedular');
					$msg = $this->load->view('email/approveRequest', $dt, TRUE);
					$this->email->message($msg);
					$this->email->send();
					$data['json'] = json_encode(array(
						"status" => "success",
						"message" => "approved"
					));
					$this->load->view('json_view', $data);
					return;
				}
			}
		}
	}
	function changePassword()
	{
		//change password
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		if ($_POST && $this->UID) {
			$config = array(
				array(
					'field' => 'curpassword',
					'label' => 'Current Password',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'npassword',
					'label' => 'New Password',
					'rules' => 'trim|required|min_length[4]|alpha_dash'
				),
				array(
					'field' => 'cpassword',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|min_length[4]|alpha_dash|matches[npassword]'
				)
			);

			$this->form_validation->set_rules($config);
			if ($this->form_validation->run() === false) {
				$this->form_validation->set_error_delimiters('<br />', '');
				$arrV[] = validation_errors();
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => $arrV
				));
				$this->load->view('json_view', $data);
				return;
			} else {
				$userdata = new stdClass();
				$oPass = $this->input->post('curpassword');
				$cPass = $this->input->post('cpassword');
				if (isset($oPass) && ! $this->schedular_auth->validatePass($this->UID, $oPass)) {
					$data['json'] = json_encode(array(
						"status" => "error",
						"message" => "Invalid Current password.",
						"data" => ""
					));
					$this->load->view('json_view', $data);
					return;
				}
				$rand_salt = $this->schedular_auth->genRndSalt();
				$encrypt_pass = $this->schedular_auth->encryptUserPwd($cPass, $rand_salt);
				$userdata->password = $encrypt_pass;
				$userdata->salt = $rand_salt;
				$updatePass = $this->admin_model->update($this->UID, $userdata);
				if ($updatePass) {
					$data['json'] = json_encode(array(
						"status" => "success",
						"message" => "Your Password Updated succesfully.",
						"data" => ""
					));
					$this->load->view('json_view', $data);
					return;
				}
			}
			return;
		}
	}
	function saveWorkingPlans()
	{
		//update resource working plans
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		try {
			$resourceId = $this->input->post('resourceId', true);
			if (isset($resourceId) && $resourceId) {
				$settings = json_decode($this->input->post('settings', true), true);
				if ($settings) {
					$this->admin_model->save_settings($settings, $resourceId);
				}
				$wPlan = $this->admin_model->getWorkingPlans($resourceId);
				$data['slots'] = $wPlan[0]->value;
				$data['json'] = json_encode(array(
					"status" => "success",
					"message" => "Working Plan Saved Successfully",
					"data" => $data
				));
				$this->load->view('json_view', $data);
				return;
			}
		} catch (Exception $exc) {
			echo json_encode(array(
				'exceptions' => array(
					exceptionToJavaScript($exc)
				)
			));
		}
	}
	function saveOrgWorkingPlans()
	{
		//update organization working plans
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		try {
			$settings = json_decode($this->input->post('settings', true), true);
			if ($settings) {
				$this->admin_model->save_org_settings($settings, $this->UORGID);
			}
			$wPlan = $this->admin_model->getOrgWorkingPlans($this->UORGID);
			$data['slots'] = $wPlan[0]->org_working_plans;
			$data['json'] = json_encode(array(
				"status" => "success",
				"message" => "Working Plan Saved Successfully",
				"data" => $data
			));
			$this->load->view('json_view', $data);
			return;
		} catch (Exception $exc) {
			echo json_encode(array(
				'exceptions' => array(
					exceptionToJavaScript($exc)
				)
			));
		}
	}
	function loadOrgWorkingPlans()
	{
		//load organization working plans
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		try {
			$wPlan = $this->admin_model->getOrgWorkingPlans($this->UORGID);
			if ($wPlan) {
				$data['slots'] = $wPlan[0]->org_working_plans;
				$data['json'] = json_encode(array(
					"status" => "success",
					"message" => "",
					"data" => $data
				));
				$this->load->view('json_view', $data);
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => "Unable to find Organization Working Plans",
					"data" => ""
				));
				$this->load->view('json_view', $data);
			}
		} catch (Exception $exc) {
			echo json_encode(array(
				'exceptions' => array(
					exceptionToJavaScript($exc)
				)
			));
		}
	}
	function loadWorkingPlans()
	{
		//load resource working plan
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		$resourceId = $this->input->post("resourceId", true);
		try {
			if (isset($resourceId) && $resourceId) {
				$wPlan = $this->admin_model->getWorkingPlans($resourceId);
				if ($wPlan) {
					$data['slots'] = $wPlan[0]->value;
					$data['json'] = json_encode(array(
						"status" => "success",
						"message" => "",
						"data" => $data
					));
					$this->load->view('json_view', $data);
				} else {
					$data['slots'] = $wPlan[0]->value;
					$data['json'] = json_encode(array(
						"status" => "success",
						"message" => "",
						"data" => $data
					));
					$this->load->view('json_view', $data);
				}
			} else {
				$data['json'] = json_encode(array(
					"status" => "error",
					"message" => "Provide resource id",
					"data" => ""
				));
				$this->load->view('json_view', $data);
				return;
			}
		} catch (Exception $exc) {
			echo json_encode(array(
				'exceptions' => array(
					exceptionToJavaScript($exc)
				)
			));
		}
	}
	function account()
	{
		//user information
		$this->schedular_auth->_member_area_redirect();
		$userInfo = $this->admin_model->getUserInfo($this->UID);
		$data['userInfo'] = $userInfo;
		$data['main_content'] = 'admins/account';
		$this->load->view('page', $data);
		return;
	}

	function sendRescheduleRequest()
	{
		//reschedule appointment request
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		if ($_POST) {
			$appID = $this->input->post('appointmentID', true);
			$reason = ($this->input->post('reschedule_reson', true)) ? $this->input->post('reschedule_reson', true) : "";
			if (isset($appID) && $appID) {
				$dt['rescheduled_reason'] = $reason;
				$dt['rescheduled_code'] = $this->schedular_auth->genRndDgt(10, false);
				$dt['isApproved'] = 0;

				$this->load->model("appointments/appointment_model");
				$rescheduleUpdate = $this->appointment_model->update($appID, $dt);

				if ($rescheduleUpdate) {
					$this->appointment_model->releaseAllocatedApp($appID);
					$appInfo = $this->appointment_model->loadAppointment($appID);
					$adminInfo = $this->admin_model->findAdminName($this->UID);
					$afName = ($adminInfo[0]->firstname) ? $adminInfo[0]->firstname : "";
					$alName = ($adminInfo[0]->lastname) ? $adminInfo[0]->lastname : "";
					$dt['logo'] = "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png"; // base_url()."themes/front/images/logo_64.png";
					$dt['applicant_email'] = $appInfo[0]->applicant_email;
					$dt['applicant_name'] = $appInfo[0]->applicant_name;
					$dt['admin_name'] = $afName . " " . $alName;
					$dt['app_title'] = $appInfo[0]->app_title;
					$dt['rescheduled_reason'] = $appInfo[0]->rescheduled_reason;
					$dt['time'] = $appInfo[0]->app_start . " - " . $appInfo[0]->app_end;
					$link = $this->admin_model->getApplicantLink($appInfo[0]->user_id);
					$dt['scheduleUrl'] = base_url() . $this->UORGURL . "/" . $link[0]->booking_url . "/" . $appInfo[0]->rescheduled_code;

					$this->load->library('email', $this->config->item('email_config'));
					$this->email->from('support@makkinfotech.biz', 'Scheduler');
					$this->email->to($appInfo[0]->applicant_email);
					$this->email->subject('Reschedule request for ' . $appInfo[0]->app_title);
					$msg = $this->load->view('email/rescheduleRequest', $dt, TRUE);
					$this->email->message($msg);
					$this->email->send();
					$data['json'] = json_encode(array(
						"status" => "success",
						"message" => "Rescheduled Success"
					));
					$this->load->view('json_view', $data);
					return;
				} else {
					$data['json'] = json_encode(array(
						"status" => "error",
						"message" => "Unable to reschedule Request"
					));
					$this->load->view('json_view', $data);
					return;
				}
			}
		}
	}
	function getCalInfo()
	{
		//get calendar infomation
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->load->model('applicant/applicant_model');
		$id = $this->input->post("calId", true);
		if (isset($id) && $id) {
			$dt['CalInfo'] = $this->applicant_model->getCalInfo($id, $this->UORGURL);
			$data['json'] = json_encode(array(
				"status" => "success",
				"message" => "Calendar Info",
				"data" => $dt
			));
			$this->load->view('json_view', $data);
			return;
		} else {
			$data['json'] = json_encode(array(
				"status" => "error",
				"message" => "Calendar Info Not found"
			));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function sendRequestNewTime()
	{
		//request for new appointment time schedule
		$isAjax = $this->input->is_ajax_request();
		if (!$isAjax) {
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect();
		if ($_POST) {
			$appID = $this->input->post('appointmentID', true);
			$reason = ($this->input->post('requestNewTime_reson', true)) ? $this->input->post('requestNewTime_reson', true) : "";
			if (isset($appID) && $appID) {
				$dt['rescheduled_reason'] = $reason;
				$dt['rescheduled_code'] = $this->schedular_auth->genRndDgt(10, false);
				$dt['isApproved'] = 0;

				$this->load->model("appointments/appointment_model");
				$rescheduleUpdate = $this->appointment_model->update($appID, $dt);

				if ($rescheduleUpdate) {
					$this->appointment_model->releaseAllocatedApp($appID);
					$appInfo = $this->appointment_model->loadAppointment($appID);
					$adminInfo = $this->admin_model->findAdminName($this->UID);
					$afName = ($adminInfo[0]->firstname) ? $adminInfo[0]->firstname : "";
					$alName = ($adminInfo[0]->lastname) ? $adminInfo[0]->lastname : "";
					$dt['logo'] = "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png"; // base_url()."themes/front/images/logo_64.png";
					$dt['applicant_email'] = $appInfo[0]->applicant_email;
					$dt['applicant_name'] = $appInfo[0]->applicant_name;
					$dt['admin_name'] = $afName . " " . $alName;
					$dt['app_title'] = $appInfo[0]->app_title;
					$dt['rescheduled_reason'] = $appInfo[0]->rescheduled_reason;
					$dt['time'] = $appInfo[0]->app_start . " - " . $appInfo[0]->app_end;
					$link = $this->admin_model->getApplicantLink($appInfo[0]->user_id);
					$dt['scheduleUrl'] = base_url() . $this->UORGURL . "/" . $link[0]->booking_url . "/" . $appInfo[0]->rescheduled_code;

					$this->load->library('email', $this->config->item('email_config'));
					$this->email->from('support@makkinfotech.biz', 'Scheduler');
					$this->email->to($appInfo[0]->applicant_email);
					$this->email->subject('New time request for ' . $appInfo[0]->app_title);
					$msg = $this->load->view('email/requestNewTime', $dt, TRUE);
					$this->email->message($msg);
					$this->email->send();
					$data['json'] = json_encode(array(
						"status" => "success",
						"message" => "Request New Time Success"
					));
					$this->load->view('json_view', $data);
					return;
				} else {
					$data['json'] = json_encode(array(
						"status" => "error",
						"message" => "Unable to request for new time"
					));
					$this->load->view('json_view', $data);
					return;
				}
			}
		}
	}
}
