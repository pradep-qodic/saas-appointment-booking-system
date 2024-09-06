<?php
/*
Author: Mitesh Patel
Date: 17/7/2014
Version: 1.0
*/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		//$this->load->model("menu_model");
		//$this->load->module("users");
		$this->load->library('schedular_auth');
		if($this->session->userdata('userid')){
			$this->UID=$this->session->userdata("userid");
			$this->UORGID=$this->session->userdata("userOrganizationID");
			$this->UORGURL=$this->session->userdata("userOrganizationURL");
		}else{
			$this->UORGID=0;
		}
	}
	
	function index(){
		$this->load->model('appointments/appointment_model');
		$this->load->model('upload/upload_model');
		$pendingApp=$this->appointment_model->pendingApp($this->UORGID);
		if(isset($pendingApp) && $pendingApp && $pendingApp !=0)
			$data['pendingApp']=$pendingApp;
		$data['isSuperAdmin']=$this->session->userdata("isSuperAdmin");
		$data['isloggedIn']=$this->session->userdata("logged_in");
		$data['username']=$this->session->userdata("fullname");
		$file=$this->upload_model->loadOLogo($this->UORGID);
		if(isset($file) && $file)
			$data['organizationLogoURL']=base_url()."uploads/organization/".$file."_thumb.jpg";
		$data['organizationURL']=$this->session->userdata("userOrganizationURL");
		$this->load->view("menu", $data);
		return;
	}
	function appointmentMenu(){
		$seg=$this->uri->segment_array();
		$this->orgName=$seg[1];
		$this->resourceName=$seg[2];
		if(isset($this->orgName) && $this->orgName){
			$this->load->model('applicant/applicant_model');
			$this->UORGID=$this->applicant_model->validateOrgName($this->orgName);
			$this->UORGUID=$this->applicant_model->findOrgAdminUserID($this->UORGID);
			$this->UORGURL=$this->orgName;
			$master=$this->applicant_model->isMasterPage($this->resourceName);
			$this->resourceId=0;
			if(!$master){
				$this->resourceId=$this->applicant_model->findResourceID($this->resourceName);
			}else{
				$this->masterPageId=$this->applicant_model->findMasterPageID($this->resourceName);
			}
		}
		$this->load->model('upload/upload_model');
		$file=$this->upload_model->loadOLogo($this->UORGID);
		if(isset($file) && $file)
			$data['organizationLogoURL']=base_url()."uploads/organization/".$file."_thumb.jpg";
		$data['organizationURL']=$this->session->userdata("userOrganizationURL");
		$this->load->view("menuAppointmentPage", $data);
		return;
	}
	//Limit access
	function _remap(){
		show_404();
	}
}

?>