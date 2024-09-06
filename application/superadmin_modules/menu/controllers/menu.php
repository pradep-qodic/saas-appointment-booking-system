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
		$this->load->model("menu_model");
		$this->load->library('schedular_auth');
		if($this->session->userdata('userid')){
			$this->UID=$this->session->userdata("superAUserid");
		}else{
			$this->UID=0;
		}
	}
	
	function index(){
		$data['isloggedIn']=$this->session->userdata("superALogged_in");
		$data['username']=$this->session->userdata("superAFullname");
		$this->load->view("menu", $data);
		return;
	}
	
	//Limit access
	function _remap(){
		show_404();
	}
}

?>