<?php
/*
 * Author: Mitesh Patel Date: 18/10/2014 Version: 1.0
 */
class Admins extends MY_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin_model' );
		$this->load->library ( 'form_validation' );
		$this->load->library ( 'schedular_auth' );
		// $this->session->sess_destroy();
		if ($this->session->userdata ( 'superAUserid' )) {
			$this->UID = $this->session->userdata ( "superAUserid" );
		}
		$this->load->helper ( 'date' );
	}
	function index() {
		/*$this->schedular_auth->_member_area_redirect ();
		$data ['main_content'] = 'admins/dashboard';
		$this->load->view ( 'page', $data );
		return;*/
		
	}
	function dashboard() {		
		$this->schedular_auth->_member_area_redirect_superadmin();
		$this->load->model("organizations/organization_model");
		$org=$this->organization_model->getOrganizations();
		$data ['organizations'] = $org;
		$data ['main_content'] = 'admins/dashboard';
		$this->load->view ( 'page', $data ); 
	}
	
	function signin() {
		if (isset ( $_POST ['signup'] )) {
			$str = $this->uri->uri_string();
			$arr = explode ( "/", $str );
			array_pop ( $arr );
			$newurl = implode ( "/", $arr );
			redirect ( $newurl . "/signup" );
			return;
		}
		if ($_POST) {
			$config = array (
					array (
							'field' => 'email',
							'label' => 'E-mail',
							'rules' => 'trim|required|valid_email' 
					),
					array (
							'field' => 'password',
							'label' => 'Password',
							'rules' => 'trim|required' 
					) 
			);
			
			$this->form_validation->set_rules ( $config );
			
			if ($this->form_validation->run () === false) {
				$data ['error'] = validation_errors ();
				$data ['main_content'] = 'admins/signin';
				$this->load->view ( 'page', $data );
				return;
			} else {
				// Data
				$user_email = $this->input->post ( 'email', true );
				$password = $this->input->post ( 'password', true );
				$this->schedular_auth->process_superadmin_login ( array (
						$user_email,
						$password 
				) );
			}
			return;
		}
		
		// Redirect
		$this->schedular_auth->_member_signin_superadmin_redirect ();
		$data ['main_content'] = 'admins/signin';
		$this->load->view ( 'page', $data );
		return;
	}
	
	function signup() {
		if (isset ( $_POST ['login'] )) {
			$str = $this->uri->uri_string ();
			$arr = explode ( "/", $str );
			array_pop ( $arr );
			$newurl = implode ( "/", $arr );
			redirect ( $newurl . "/signin" );
			return;
		}
		if (isset ( $_POST ['back'] )) {
			$str = $this->uri->uri_string ();
			$arr = explode ( "/", $str );
			array_pop ( $arr );
			$newurl = implode ( "/", $arr );
			redirect ( $newurl . "/signin" );
			return;
		}
		if ($_POST) {
			$config = array (
					array (
							'field' => 'org_title',
							'label' => 'Organization Title',
							'rules' => 'trim|required' 
					),
					array (
							'field' => 'org_url',
							'label' => 'Organization URL',
							'rules' => 'trim|required|is_unique[organizations.org_url]|alpha_dash' 
					),
					array (
							'field' => 'email',
							'label' => 'Email',
							'rules' => 'trim|required|valid_email' 
					),
					array (
							'field' => 'password',
							'label' => 'Password',
							'rules' => 'trim|required' 
					),
					array (
							'field' => 'cpassword',
							'label' => 'Confirm Password',
							'rules' => 'trim|required|matches[password]' 
					),
					array (
							'field' => 'firstname',
							'label' => 'First Name',
							'rules' => 'trim|required' 
					) 
			);
			
			$this->form_validation->set_rules ( $config );
			$u_id = 0;
			if ($this->form_validation->run () === false) {
				$data ['error'] = validation_errors ();
				$data ['main_content'] = 'admins/signup';
				$this->load->view ( 'page', $data );
				return;
			} else {
				$email = $this->input->post ( 'email', true );
				if ($email && $this->admin_model->validateEmail ( $email )) {
					$data ['error'] = "Email Address Already Exists.";
					$data ['main_content'] = 'admins/signup';
					$this->load->view ( 'page', $data );
					return;
				}
				$this->load->helper ( 'date' );
				$now = time ();
				$data ['org_title'] = $this->input->post ( 'org_title', true );
				$data ['org_url'] = $this->input->post ( 'org_url', true );
				$data ['is_deleted'] = 0;
				$data ['createdon'] = unix_to_human ( $now, TRUE, 'us' );
				$data ['timezone'] = "+05:30";
				$orgID = $this->admin_model->createOrganization ( $data );
				$rand_salt = $this->schedular_auth->genRndSalt ();
				$encrypt_pass = $this->schedular_auth->encryptUserPwd ( $this->input->post ( 'password' ), $rand_salt );
				$lastN = "";
				if ($this->input->post ( 'lastname', true )) {
					$lastN = $this->input->post ( 'lastname', true );
				}
				if ($orgID) {
					$udata ['email'] = $email;
					$udata ['password'] = $encrypt_pass;
					$udata ['salt'] = $rand_salt;
					$udata ['firstname'] = $this->input->post ( 'firstname', true );
					$udata ['lastname'] = $this->input->post ( 'lastname', true );
					$udata ['name'] = $this->input->post ( 'firstname', true ) . " " . $lastN;
					$udata ['mobileno'] = $this->input->post ( 'mobileno', true );
					$udata ['gender'] = $this->input->post ( 'gender', true );
					$udata ['isVerifiedBySAdmin'] = 1;
					$udata ['isSuperAdmin'] = 1;
					$udata ['status'] = 1;
					$udata ['createdOn'] = unix_to_human ( $now, TRUE, 'us' );
					$udata ['org_id'] = $orgID;
					$u_id = $this->admin_model->createUser ( $udata );
				} else {
					$data ['error'] = "Unable to Create Your Account. Please Try Again.";
					$data ['main_content'] = 'admins/signup';
					$this->load->view ( 'page', $data );
					return;
				}
			}
			if (isset ( $u_id ) && $u_id != 0) {
				$this->admin_model->updateOrg ( $orgID, array (
						"org_user_id" => $u_id 
				) );
			}
			$dt ['logo'] = "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
			$dt ['user_email'] = $email;
			$this->load->library ( 'email', $this->config->item ( 'email_config' ) );
			$this->email->from ( 'support@makkinfotech.biz', 'Scheduler' );
			$this->email->to ( $email );
			$this->email->subject ( 'Welcome To Scheduler' );
			$msg = $this->load->view ( 'email/scheduler_signup_mail', $dt, TRUE );
			$this->email->message ( $msg );
			$this->email->send ();
			
			$data ['message'] = "Your Account Created Successfully.Click on Login Button.";
			$data ['main_content'] = 'admins/signup';
			$this->load->view ( 'page', $data );
			return;
		}
		$this->schedular_auth->_member_signin_redirect ();
		$data ['main_content'] = 'admins/signup';
		$this->load->view ( 'page', $data );
		return;
	}
	function logout() {
		$this->session->unset_userdata("superAUserid");
		$this->session->unset_userdata("superALogged_in");
		$this->session->unset_userdata("superAFullname");
		redirect ( 'signin', 'refresh' );
	}
	
	function changePassword() {
		$this->schedular_auth->_member_area_redirect_superadmin();
		if ($_POST && $this->UID) {
			$config = array (
					array (
							'field' => 'curpassword',
							'label' => 'Current Password',
							'rules' => 'trim|required' 
					),
					array (
							'field' => 'npassword',
							'label' => 'New Password',
							'rules' => 'trim|required|min_length[4]|alpha_dash' 
					),
					array (
							'field' => 'cpassword',
							'label' => 'Confirm Password',
							'rules' => 'trim|required|min_length[4]|alpha_dash|matches[npassword]' 
					) 
			);
			
			$this->form_validation->set_rules ( $config );
			if ($this->form_validation->run () === false) {
				$this->form_validation->set_error_delimiters ( ' ', ' ' );
				$arrV [] = validation_errors ();
				$data ['json'] = json_encode ( array (
						"status" => "error",
						"message" => $arrV 
				) );
				$this->load->view ( 'json_view', $data );
				return;
			} else {
				$userdata = new stdClass ();
				$oPass = $this->input->post ( 'curpassword' );
				$cPass = $this->input->post ( 'cpassword' );
				if (isset ( $oPass ) && ! $this->schedular_auth->validatePass ( $this->UID, $oPass )) {
					$data ['json'] = json_encode ( array (
							"status" => "error",
							"message" => "Invalid Current password.",
							"data" => "" 
					) );
					$this->load->view ( 'json_view', $data );
					return;
				}
				$rand_salt = $this->schedular_auth->genRndSalt ();
				$encrypt_pass = $this->schedular_auth->encryptUserPwd ( $cPass, $rand_salt );
				$userdata->password = $encrypt_pass;
				$userdata->salt = $rand_salt;
				$updatePass = $this->admin_model->update ( $this->UID, $userdata );
				if ($updatePass) {
					$data ['json'] = json_encode ( array (
							"status" => "success",
							"message" => "Your Password Updated succesfully.",
							"data" => "" 
					) );
					$this->load->view ( 'json_view', $data );
					return;
				}
			}
			return;
		}
	}
	function account() {			
		$this->schedular_auth->_member_area_redirect_superadmin();
		$userInfo = $this->admin_model->getUserInfo( $this->UID );
		$data ['userInfo'] = $userInfo;
		$data ['main_content'] = 'admins/account';
		$this->load->view ( 'page', $data );
		return;
	}
	function updateOrganization() {		
        //update organization details
		$orgatinID=$this->input->post ( 'org_id', true );
		$org_name=$this->input->post ( 'org_name', true );
		$org_url=$this->input->post ( 'org_url', true );
		
		if($org_name && $org_url && $orgatinID){
			$udata ['org_title'] = $this->input->post ( 'org_name', true );
			$udata ['org_url'] = $this->input->post ( 'org_url', true );
			$udata ['status'] = $this->input->post ( 'org_status', true );
			$udata ['org_description'] = $this->input->post ( 'org_desc', true );					
			$u_id = $this->admin_model->updateOrg ( $orgatinID, $udata );
			if ($u_id) {
				$data ['json'] = json_encode ( array (
						"status" => "success",
						"message" => "Organization Updated Successfully." 
				) );
				$this->load->view ( 'json_view', $data );
				return;
			}
		}else{
			$data ['json'] = json_encode ( array (
					"status" => "error",
					"message" => "field is required." 
			) );
			$this->load->view ( 'json_view', $data );
			return;
		}	
					
	}
	function deleteOrganizations() {
        //delete booking page
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if ($_POST) {
				$ID = $this->input->post ( 'id', true );
				$dt ['is_deleted'] = 1;
				$u_id = $this->admin_model->updateOrg( $ID, $dt );
				if ($u_id) {
					$data ['json'] = json_encode ( array (
							"status" => "success",
							"message" => "Organizations Deleted Successfully." 
					) );
					$this->load->view ( 'json_view', $data );
					return;
				}
		}					
	}	
	function loadOrganizations(){
        // load trash information
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$this->schedular_auth->_member_area_redirect_superadmin();
		$this->load->model("organizations/organization_model");
		$org=$this->organization_model->getOrganizations();		
		$dt['organizations'] = $org;
		$dt['main_content'] = 'Loaddashboard';
		$d=$this->load->view('outputPage', $dt,true);
		$this->output->set_output($d);
		return;
	}
	

}
