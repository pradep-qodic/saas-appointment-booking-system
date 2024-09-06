<?php
/*
Author: Mitesh Patel
Date: 16/10/2014
Version: 1.0
*/

class Organizations extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('organization_model');
		$this->load->library('form_validation');
		$this->load->library('basic401authentication');
		$this->basic401authentication->require_login();
		$this->userID=$this->session->userdata('userID');
    }
	function index(){}
	function getOrganization(){
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
				$orgID=$this->input->post('org_id');
				if(isset($orgID) && $orgID && !$this->organization_model->checkOrgAvailability($orgID)){
					$data['json'] = json_encode(array("status"=>"error","message"=>"Organization NotFound"));
					$this->load->view('json_view', $data);
					return;
				}
				$organization=$this->organization_model->getOrganizationByID($orgID);
				if($organization){
					$dt['organization']=$organization;
					$data['json'] = json_encode(array("status"=>"success","message"=>"Organization Details","data"=>$dt));
					$this->load->view('json_view', $data);
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Organization NotFound","data"=>""));
					$this->load->view('json_view', $data);
				}
			}
			return;
	}
	function createOrganization(){
		$config = array(
				array(
					'field' => 'title',
					'label' => 'Organization Title',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'org_url',
					'label' => 'Organization URL',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'timezone',
					'label' => 'Timezone',
					'rules' => 'trim|required',
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
				$this->load->helper('date');
				$now = time();
				$data['org_title']			= $this->input->post('title',true);
				$data['org_description']	= $this->input->post('description',true);
				$data['org_email']			= $this->input->post('org_email',true);
				$data['org_phone']			= $this->input->post('org_phone',true);
				$data['org_logo_url']		= $this->input->post('logo_url',true);
				$data['org_user_id']		= $this->userID;
				$data['org_url']			= $this->input->post('org_url',true);
				$data['is_deleted']			= 0;
				$data['org_working_plans']	= $this->input->post('org_working_plans',true);
				$data['createdon']			= unix_to_human($now, TRUE, 'us');
				$data['timezone']			= $this->input->post('timezone',true);
				$orgID = $this->organization_model->createOrganization($data);
				if($orgID>0){
					$data['json'] = json_encode(array("status"=>"success","message"=>"Organization Created.","data"=>array("org_id"=>$orgID)));
					$this->load->view('json_view', $data);
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Organization Not Created.","data"=>""));
					$this->load->view('json_view', $data);
				}
			}
			return;
	}
	function updateOrganization(){
		$config = array(
				array(
					'field' => 'org_id',
					'label' => 'Organization ID',
					'rules' => 'trim|required|numeric',
				),
				array(
					'field' => 'title',
					'label' => 'Organization Title',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'org_url',
					'label' => 'Organization URL',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'timezone',
					'label' => 'Timezone',
					'rules' => 'trim|required',
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
				$this->load->helper('date');
				$now = time();
				$orgID						= $this->input->post('org_id',true);
				$data['org_title']			= $this->input->post('title',true);
				$data['org_description']	= $this->input->post('description',true);
				$data['org_email']			= $this->input->post('org_email',true);
				$data['org_phone']			= $this->input->post('org_phone',true);
				$data['org_logo_url']		= $this->input->post('logo_url',true);
				$data['org_user_id']		= $this->userID;
				$data['org_url']			= $this->input->post('org_url',true);
				$data['org_working_plans']	= $this->input->post('org_working_plans',true);
				$data['is_deleted']			= 0;
				$data['createdon']			= unix_to_human($now, TRUE, 'us');
				$data['timezone']			= $this->input->post('timezone',true);
				$updateOrg = $this->organization_model->update($orgID,$data);
				if($updateOrg){
					$data['json'] = json_encode(array("status"=>"success","message"=>"Organization Information Updated.","data"=>""));
					$this->load->view('json_view', $data);
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Organization Information Not Updated.","data"=>""));
					$this->load->view('json_view', $data);
				}
			}
			return;
	}
	function deleteOrganization(){
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
				$this->load->helper('date');
				$now = time();
				$orgID						= $this->input->post('org_id',true);
				if(isset($orgID) && $orgID && !$this->organization_model->checkOrgAvailability($orgID)){
					$data['json'] = json_encode(array("status"=>"error","message"=>"Organization NotFound"));
					$this->load->view('json_view', $data);
					return;
				}
				$data['is_deleted']			= 1;
				$updateOrg = $this->organization_model->update($orgID,$data);
				if($updateOrg){
					$data['json'] = json_encode(array("status"=>"success","message"=>"Organization Information Deleted.","data"=>""));
					$this->load->view('json_view', $data);
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Organization Information Not Deleted.","data"=>""));
					$this->load->view('json_view', $data);
				}
			}
			return;
	}
	
}
