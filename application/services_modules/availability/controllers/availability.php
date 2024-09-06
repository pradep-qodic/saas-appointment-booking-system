<?php
/*
Author: Mitesh Patel
Date: 12/02/2015
Version: 1.0
*/

class Availability extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('availability_model');
		$this->load->library('form_validation');
		$this->load->library('basic401authentication');
		$this->basic401authentication->require_login();
		$this->userID=$this->session->userdata('userID');
		$this->userOrgId=$this->session->userdata('userOrgId');
    }
	function index(){}
	function newAvailability(){
		$config1 = array(
				array(
						'field' => 'calendarId',
						'label' => 'Calendar Id',
						'rules' => 'trim|required|numeric',
				)
		);
		
		$this->form_validation->set_rules($config1);
		$u_id=0;
		if($this->form_validation->run() === false){
			$this->form_validation->set_error_delimiters(' ', ' ');
			$arr[]=validation_errors();
			if($arr[0]==""){
				$arr=array("Provide Required Fields");
			}
			$data['json'] = json_encode(array("status"=>"error","message"=>$arr,"data"=>""));
			$this->load->view('json_view', $data);
			return;
		}else{
			$this->load->helper('date');
			$now = time();
			$calId=$this->input->post('calendarId',true);
			$settings = $this->input->post ( 'availability', true );
			$saved="";
			if ($settings) {
				$dt['value']=$settings;
				$dt['user_id']=$calId;
				$dt['name']="org_working_plans";
				if($this->availability_model->checkuserAvailability($calId)){
					$saved=$this->availability_model->save_settings ( $settings,$calId );
				}else{
					$saved=$this->availability_model->create ( $dt );
				}
				
			}
			if($saved){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Calendar Availability Created Successfully.","data"=>array("id"=>$saved)));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to create calendar availability."));
				$this->load->view('json_view', $data);
			}
		}
		
				
		return;
	}
	function getAvailability(){
		$config = array(
			array(
				'field' => 'availabilityId',
				'label' => 'availability Id',
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
			$avId=$this->input->post('availabilityId',true);
			if(!$this->availability_model->validateAvailability($avId)){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Availability Not found","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			$wPlan = $this->availability_model->getWorkingPlansByAvaiId ( $avId );
			if($wPlan){
				$dt['availability']=json_decode($wPlan[0]->value);
				$data['json'] = json_encode(array("status"=>"success","message"=>"Availability Details","data"=>$dt));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Availability Not found","data"=>""));
				$this->load->view('json_view', $data);
			}	
		}
		return;
	}
	function getAvailabilitiesByCalendarId(){
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
			$calId=$this->input->post('calendarId',true);
			$wPlan = $this->availability_model->getWorkingPlans ( $calId );
			if($wPlan){
				$dt['availability']=json_decode($wPlan[0]->value);
				$data['json'] = json_encode(array("status"=>"success","message"=>"Availability Details","data"=>$dt));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Availability Not Found","data"=>""));
				$this->load->view('json_view', $data);
			}
		}
		return;
	}
	
	function updateAvailability(){
		$config1 = array(
				array(
						'field' => 'calendarId',
						'label' => 'Calendar Id',
						'rules' => 'trim|required|numeric',
				)
		);
		
		$this->form_validation->set_rules($config1);
		$u_id=0;
		if($this->form_validation->run() === false){
			$this->form_validation->set_error_delimiters(' ', ' ');
			$arr[]=validation_errors();
			if($arr[0]==""){
				$arr=array("Provide Required Fields");
			}
			$data['json'] = json_encode(array("status"=>"error","message"=>$arr,"data"=>""));
			$this->load->view('json_view', $data);
			return;
		}else{
			$this->load->helper('date');
			$now = time();
			$calId=$this->input->post('calendarId',true);
			$settings = $this->input->post ( 'availability', true );
			$saved="";
			if ($settings) {
				$dt['value']=$settings;
				$dt['user_id']=$calId;
				$dt['name']="org_working_plans";
				if($this->availability_model->checkuserAvailability($calId)){
					$saved=$this->availability_model->save_settings ( $settings,$calId );
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"calendar availability not found."));
					$this->load->view('json_view', $data);
					return;
				}
				
			}
			if($saved){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Calendar Availability Updated Successfully.","data"=>""));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update calendar availability."));
				$this->load->view('json_view', $data);
			}
		}		
		return;
	}
	function deleteAvailability(){
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
			$calId=$this->input->post('calendarId',true);
			if(!$this->availability_model->checkuserAvailability($calId)){
				$data['json'] = json_encode(array("status"=>"error","message"=>"Availability Not Found.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			$v='{"monday":null,"tuesday":null,"wednesday":null,"thursday":null,"friday":null,"saturday":null,"sunday":null}';
			$saved=$this->availability_model->save_settings ( $v,$calId );
			if($saved){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Availability Deleted.","data"=>""));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Availability Not Deleted.","data"=>""));
				$this->load->view('json_view', $data);
			}
		}
		return;
	}
}
