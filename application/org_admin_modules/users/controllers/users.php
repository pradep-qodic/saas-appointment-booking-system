<?php
/*
Author: Mitesh Patel
Date: 21/10/2014
Version: 1.0
*/

class Users extends MY_Controller{
	// Note : Here consider Users to Resources. and resource can be anything (Ex. user,machine,room...)
	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
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
		$orgID=$this->session->userdata("userOrganizationID");
		$data['users']=$this->user_model->loadUsers($this->session->userdata("userOrganizationID"));
		$data['org_id']=$orgID;
	    $data['main_content'] = 'users/resources';
        $this->load->view('page', $data);
		return;
	}
	function user(){
        //get resource information
		$id=$this->input->post('id',true);
		if(isset($id) && $id && $this->user_model->validateResource($id,$this->UORGID)){
			$data['userInfo']=$this->user_model->loadUser($id);
			$data['main_content'] = 'users/resourcePage';
			$this->load->view('page',$data);
			return;
		}else{
			$data['unAuthorizedEmail']="Unable to Find Details.";
			$data['main_content'] = 'users/resourcePage';
			$this->load->view('page',$data);
			return;
		}
	}
	function loadUserData(){
        //load resource data
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$config1 = array(
					array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'trim|required|valid_email',
					)
				);

				$this->form_validation->set_rules($config1);
				$userEmail=$this->input->post('email',true);
				if($this->form_validation->run() === false){
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
				}else{
					$data['userData']=$this->user_model->loadUserByEmail($userEmail);
					$data['json'] = json_encode(array("status"=>"success","message"=>"","data"=>$data));
					$this->load->view('json_view', $data);
				}
				return;
		}
	}
	function resignin(){
		$str=$this->uri->uri_string();
		redirect($str."/signin");
		return;
	}
    
	function createUser(){
        //create resource
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$orgatinID=$this->input->post('org_id',true);
			if(isset($orgatinID) && $orgatinID){
				$config1 = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'trim|required',
					),
					array(
						'field' => 'email',
						'label' => 'Email',
						'rules' => 'trim|required|valid_email',
					)
				);

				$this->form_validation->set_rules($config1);
				$u_id=0;
				if($this->form_validation->run() === false){
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
					return;
				}else{
					$this->load->helper('date');
					$now = time();
					$rand_salt = "";
					$encrypt_pass = "";
					$uEmail=$this->input->post('email',true);
					$udata['email']			= $uEmail;
					$udata['password']		= $encrypt_pass;
					$udata['salt']			= $rand_salt;
					$udata['name']			= $this->input->post('name',true);
					$udata['mobileno']		= $this->input->post('mobileno',true);
					$udata['status']		= $this->input->post('status',true);
					$udata['isVerifiedBySAdmin']=1;
					$udata['inspectionTypeId']=$this->input->post('insp_type_id',true);
					$udata['isSuperAdmin']=0;
					$udata['createdOn']		= unix_to_human($now, TRUE, 'us');
					$udata['org_id']		= $orgatinID;
					$u_id=$this->user_model->createUser($udata);
					if($u_id){
						$data['json'] = json_encode(array("status"=>"success","message"=>"Resource Created Successfully."));
						$this->load->view('json_view', $data);
						return;
					}
				}
			}
		}
	}
	function loadLeaves(){
        //load resource leaves
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$uID=$this->input->post("user_id",true);
		if(isset($uID) && $uID){
			$data['leaves']=$this->user_model->loadCalLeaves($uID);
			$data['json'] = json_encode(array("status"=>"success","message"=>"","data"=>$data));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function loadLeave(){
        //load leave details
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$ID=$this->input->post("leaveId",true);
		if(isset($ID) && $ID){
			$data['leaveInfo']=$this->user_model->loadLeaveInfo($ID);
			$data['json'] = json_encode(array("status"=>"success","message"=>"","data"=>$data));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function createUserLeave(){
        //create resource leave
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
				$config1 = array(
					array(
						'field' => 'leaveTitle',
						'label' => 'Leave Title',
						'rules' => 'trim|required',
					),
					array(
						'field' => 'startDate',
						'label' => 'Leave Start Date',
						'rules' => 'trim|required',
					),
					array(
						'field' => 'endDate',
						'label' => 'Leave End Date',
						'rules' => 'trim|required',
					)
				);

				$this->form_validation->set_rules($config1);
				if($this->form_validation->run() === false){
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
					return;
				}else{
					$this->load->helper('date');
					$now=time();
					$curDate=strtotime(time());
					$stDate=strtotime($this->input->post('startDate',true));
					$endDate=strtotime($this->input->post('endDate',true));
					/*if($stDate<$curDate){
						$data['json'] = json_encode(array("status"=>"error","message"=>"Start date should be grater than to current date."));
						$this->load->view('json_view', $data);
						return;
					}*/
					if($endDate<$stDate){
						$data['json'] = json_encode(array("status"=>"error","message"=>"End date should be grater or equal to start date."));
						$this->load->view('json_view', $data);
						return;
					}
					$ldata['userId']			= $this->input->post('luserID',true);
					$ldata['leaveTitle']		= $this->input->post('leaveTitle',true);
					$ldata['leaveStartDate']	= date("Y-m-d", strtotime($this->input->post('startDate')));
					$ldata['leaveEndDate']		= date("Y-m-d", strtotime($this->input->post('endDate')));
					$ldata['leaveCreatedOn']	= unix_to_human($now, TRUE, 'us');
					$ldata['createdByUserId']	= $this->session->userdata('userid');
					$ldata['isDeleted']			= 0;
					$l_id=$this->user_model->createLeave($ldata);
					if($l_id){
						$data['json'] = json_encode(array("status"=>"success","message"=>"Resource Leave Created Successfully."));
						$this->load->view('json_view', $data);
						return;
					}
				}
		}
	}
	function loadUserWorkingPlans(){
        //load resource working plans
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$uid=$this->input->post('user_id');
		if(isset($uid) && $uid){
			$res=$this->user_model->loadUserWorkingPlanForCalendarDisplay($uid);
			$res=json_decode($res[0]->userWorkingPlan);
			$mainArray=array();
			if($res){
				foreach($res as $index=>$val){
					foreach($val as $index1=>$val1){
						$subArray=array();
						$subArray['title'] = "Working"; 
						$subArray['start'] = $index1." ".$val1->start;
						$subArray['end'] = $index1." ".$val1->end;
						array_push($mainArray,$subArray);
					}
				}
			}
			$data['userWorkingPlans']=$mainArray;
			$data['json'] = json_encode(array("status"=>"success","message"=>"Resource Working Plan","data"=>$data));
			$this->load->view('json_view', $data);
			return;
		}	
	}
	function loadUserWorkingPlan(){
        //load resource working plan by date
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$DT=$this->input->post("planDate",true);
		$uid=$this->input->post('user_id',true);
		if(isset($uid) && $uid && isset($DT) && $DT){
			$workingPlan=array();
			$workingPlanArray=array();
			$res=$this->user_model->loadUserWorkingPlan($uid);
			if($res){
				$workingPlan=json_decode($res);	
				foreach($workingPlan as $key => $value)
				{
					foreach($value as $key1 => $value1)
					{
					  if($key1==$DT){
						$workingPlanArray=array("date"=>$DT,"start"=>$value->$key1->start,"end"=>$value->$key1->end);
					  }
					}
				}
				$data['planInfo']=$workingPlanArray;
				$data['json'] = json_encode(array("status"=>"success","message"=>"","data"=>$data));
				$this->load->view('json_view', $data);
				return;
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to load info.","data"=>""));
				$this->load->view('json_view', $data);
				return;
			}
			
		}else{
			$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to load info.","data"=>""));
			$this->load->view('json_view', $data);
			return;
		}	
	}
	function createUserWorkingPlan(){
        //create resource working plan
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}	
		if($_POST){
				$config1 = array(
					array(
						'field' => 'workingDate',
						'label' => 'Working Date',
						'rules' => 'trim|required',
					),
					array(
						'field' => 'startTime',
						'label' => 'Start Time',
						'rules' => 'trim|required',
					),
					array(
						'field' => 'endTime',
						'label' => 'End Time',
						'rules' => 'trim|required',
					)
				);

				$this->form_validation->set_rules($config1);
				if($this->form_validation->run() === false){
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
					return;
				}else{
					$this->load->helper('date');
					$now=time();
					$uid=$this->input->post('uID',true);
					$workingDate=date("Y-m-d", strtotime($this->input->post('workingDate')));
					$startTime=$this->input->post('startTime');
					$endTime=$this->input->post('endTime');
					$workingPlan=array();
					$res=$this->user_model->loadUserWorkingPlan($uid);
					$res=$res[0]->userWorkingPlan;
					if($res){
						$workingPlan=json_decode($res);
						$isMatch=false;
						if($workingPlan){
							foreach($workingPlan as $key => $value)
							{
								foreach($value as $key1 => $value1)
								{
								  if($key1==$workingDate){
									$value->$key1->start=$startTime;
									$value->$key1->end=$endTime;
									$isMatch=true;
								  }
								}
							}
						}
						if(!$isMatch){
							array_push($workingPlan,array($workingDate=>array("start"=>$startTime,"end"=>$endTime)));
						}
					}else{
						array_push($workingPlan,array($workingDate=>array("start"=>$startTime,"end"=>$endTime)));
					}
					$stTime=strtotime($this->input->post('startTime',true));
					$endTime=strtotime($this->input->post('endTime',true));
					if($endTime<$stTime){
						$data['json'] = json_encode(array("status"=>"error","message"=>"End time should be grater or equal to start time."));
						$this->load->view('json_view', $data);
						return;
					}
					$wdata['userWorkingPlan']	= json_encode($workingPlan);
					$plan=$this->user_model->createUserWorkingPlan($uid,$wdata);
					if($plan){
						$data['json'] = json_encode(array("status"=>"success","message"=>"Resource Working Plan Created Successfully."));
						$this->load->view('json_view', $data);
						return;
					}
				}
		}
	}	
	function deleteUserWorkingPlan(){
        //delete resource working plan
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}	
		$wdate=$this->input->post('workingDate');
		if($_POST && isset($wdate) && $wdate){
			$this->load->helper('date');
			$now=time();
			$uid=$this->input->post('uID',true);
			$workingDate=date("Y-m-d", strtotime($wdate));
			$workingPlan=array();
			$res=$this->user_model->loadUserWorkingPlan($uid);
			$res=$res[0]->userWorkingPlan;
			if($res){
				$workingPlan=json_decode($res);
				$isMatch=false;
				if($workingPlan){
					foreach($workingPlan as $key => $value)
					{
						foreach($value as $key1 => $value1)
						{
						  if($key1==$workingDate){
							unset($value->$key1);
						  }
						}
					}
				}
			}
			$workingPlan=array_filter(json_decode(json_encode($workingPlan), true));
			$wdata['userWorkingPlan']	= json_encode($workingPlan);
			$plan=$this->user_model->createUserWorkingPlan($uid,$wdata);
			if($plan){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Resource Working Plan Deleted Successfully."));
				$this->load->view('json_view', $data);
				return;
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to delete Working Plan"));
				$this->load->view('json_view', $data);
				return;
			}
		}else{
			$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to delete Working Plan"));
			$this->load->view('json_view', $data);
			return;
		}
				
	}
	function updateUserLeave(){
        //update resource leave
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
				$config1 = array(
					array(
						'field' => 'leaveTitle',
						'label' => 'Leave Title',
						'rules' => 'trim|required',
					),
					array(
						'field' => 'startDate',
						'label' => 'Leave Start Date',
						'rules' => 'trim|required',
					),
					array(
						'field' => 'endDate',
						'label' => 'Leave End Date',
						'rules' => 'trim|required',
					)
				);

				$this->form_validation->set_rules($config1);
				if($this->form_validation->run() === false){
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
					return;
				}else{
					$this->load->helper('date');
					$now=time();
					$curDate=strtotime(time());
					$stDate=strtotime($this->input->post('startDate',true));
					$endDate=strtotime($this->input->post('endDate',true));
					/*if($stDate<$curDate){
						$data['json'] = json_encode(array("status"=>"error","message"=>"Start date should be grater than to current date."));
						$this->load->view('json_view', $data);
						return;
					}*/
					if($endDate<$stDate){
						$data['json'] = json_encode(array("status"=>"error","message"=>"End date should be grater or equal to start date."));
						$this->load->view('json_view', $data);
						return;
					}
					$leaveID= $this->input->post('leave_id',true);
					if(isset($leaveID) && $leaveID){
						$ldata['leaveTitle']		= $this->input->post('leaveTitle',true);
						$ldata['leaveStartDate']	= date("Y-m-d", strtotime($this->input->post('startDate')));
						$ldata['leaveEndDate']		= date("Y-m-d", strtotime($this->input->post('endDate')));
						$l_id=$this->user_model->updateLeave($leaveID,$ldata);
						if($l_id){
							$data['json'] = json_encode(array("status"=>"success","message"=>"Resource Leave Updated Successfully."));
							$this->load->view('json_view', $data);
							return;
						}else{
							$data['json'] = json_encode(array("status"=>"success","message"=>"Unable to update record."));
							$this->load->view('json_view', $data);
							return;
						}
					}else{
						$data['json'] = json_encode(array("status"=>"success","message"=>"Unable to update record."));
						$this->load->view('json_view', $data);
						return;
					}
					
				}
		}
	}
	function updateResource(){
        //update resource information
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$config1 = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'trim|required',
					)
				);

				$this->form_validation->set_rules($config1);
				$u_id=0;
				if($this->form_validation->run() === false){
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
					return;
				}else{
					$uEmail=$this->input->post('uemail',true);
					$udata['name']		= $this->input->post('name',true);
					$udata['mobileno']		= $this->input->post('mobileno',true);
					$udata['status']		= $this->input->post('status',true);
					$u_id=$this->user_model->updateUser($uEmail,$udata);
					if($u_id){
						$data['json'] = json_encode(array("status"=>"success","message"=>"Resource Updated Successfully."));
						$this->load->view('json_view', $data);
						return;
					}
				}
		}
	}
	function updateUser(){
        //update resource
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$config1 = array(
					array(
						'field' => 'name',
						'label' => 'Name',
						'rules' => 'trim|required',
					)
				);

				$this->form_validation->set_rules($config1);
				$u_id=0;
				if($this->form_validation->run() === false){
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
					return;
				}else{
					$uEmail=$this->input->post('uemail',true);
					$udata['name']		= $this->input->post('name',true);
					$udata['mobileno']		= $this->input->post('mobileno',true);
					$udata['status']		= $this->input->post('status',true);
					$u_id=$this->user_model->updateUser($uEmail,$udata);
					if($u_id){
						$data['json'] = json_encode(array("status"=>"success","message"=>"User Updated Successfully."));
						$this->load->view('json_view', $data);
						return;
					}
				}
		}
	}
	function deleteUser(){
        //delete resource
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$config1 = array(
					array(
						'field' => 'id',
						'label' => 'User ID',
						'rules' => 'trim|required',
					)
				);

				$this->form_validation->set_rules($config1);
				if($this->form_validation->run() === false){
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
					return;
				}else{
					$ID	= $this->input->post('id',true);
					$dt['IsDeleted']=1;
					$u_id=$this->user_model->update($ID,$dt);
					if($u_id){
						$data['json'] = json_encode(array("status"=>"success","message"=>"Resource Deleted Successfully."));
						$this->load->view('json_view', $data);
						return;
					}
				}
		}
	}
	function deleteLeave(){
        //delete leave
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$config1 = array(
					array(
						'field' => 'id',
						'label' => 'Leave ID',
						'rules' => 'trim|required',
					)
				);

				$this->form_validation->set_rules($config1);
				if($this->form_validation->run() === false){
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
					return;
				}else{
					$ID	= $this->input->post('id',true);
					$dt['isDeleted']=1;
					$u_id=$this->user_model->updateLeave($ID,$dt);
					if($u_id){
						$data['json'] = json_encode(array("status"=>"success","message"=>"Leave Deleted Successfully."));
						$this->load->view('json_view', $data);
						return;
					}else{
						$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to Delete Leave"));
						$this->load->view('json_view', $data);
						return;
					}
				}
		}
	}
    
    function changePassword(){
        $arr=$this->_validate_access_token();
        $apID=$arr['app_id'];
        $uID=$arr['u_id'];
        if($apID==1){
            //Redirect
            $this->_member_area_redirect();
        }
        if(isset($_POST['cancelChangePassword'])){
            redirect("events");
        }
        if($_POST){
            $config = array(
                array(
                    'field' => 'opassword',
                    'label' => 'Old Password',
                    'rules' => 'trim|required|min_length[4]|alpha_dash',
                ),
                array(
                    'field' => 'npassword',
                    'label' => 'New Password',
                    'rules' => 'trim|required|min_length[4]|alpha_dash',
                ),
                array(
                    'field' => 'cpassword',
                    'label' => 'Confirm Password',
                    'rules' => 'trim|required|min_length[4]|alpha_dash|matches[npassword]',
                )
            );

            $this->form_validation->set_rules($config);
            if($this->form_validation->run() === false){
                if($apID==1){
                    $data['error'] = validation_errors();
                    $data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
                    $data['main_content'] = 'users/changePassword';
                    $this->load->view('page', $data);
                }else{
                    $this->form_validation->set_error_delimiters(' ', ' ');
                    $arrV[]=validation_errors();
                    $data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
                    $this->load->view('json_view', $data);
                }

            }else{
                $userdata = new stdClass();
                $oPass=$this->input->post('opassword');
                $cPass=$this->input->post('cpassword');
                if(isset($oPass) && !$this->user_model->validate_oldPass($uID,md5($oPass))){
                    if($apID==1){
                        $data['error'] = "Invalid old password.";
                        $data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
                        $data['main_content'] = 'users/changePassword';
                        $this->load->view('page', $data);
                    }else{
                        $data['json'] = json_encode(array("status"=>"error","message"=>"Invalid old password.","data"=>""));
                        $this->load->view('json_view', $data);
                    }
                    return;
                }

                $userdata->user_pass = md5($cPass);

                $updatePass = $this->user_model->update($uID, $userdata);

                if($updatePass){
                    if($apID==1){
                        $data['message'] = "Your Password Updated succesfully";
                        $data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
                        $data['main_content'] = 'users/changePassword';
                        $this->load->view('page', $data);
                    }else{
                        $data['json'] = json_encode(array("status"=>"success","message"=>"Your Password Updated succesfully.","data"=>""));
                        $this->load->view('json_view', $data);
                    }
                }

            }
            return;
        }
        if($apID==1){
            $data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
            $data['main_content'] = 'users/changePassword';
            $this->load->view('page', $data);
        }
    }
	/* holidays */
	function loadholidaysData(){
        //load holidays data
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$pageId=$this->input->post("pageId",true);
		if(isset($pageId) && $pageId){
			$data['org_id']=$this->UORGID;
			$data['holidays']=$this->user_model->loadHolidaysData($this->UORGID);
			$data['json'] = json_encode(array("status"=>"success","message"=>"","data"=>$data));
			$this->load->view('json_view', $data);
		}else{
			$data['org_id']=$this->UORGID;
			$data['holidays']=array();
			$data['json'] = json_encode(array("status"=>"success","message"=>"","data"=>$data));
			$this->load->view('json_view', $data);
		}
		
		return;
	}
	function loadHolidays(){
        //load holidays
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$data['org_id']=$this->UORGID;
		$data['holidays']=$this->user_model->loadHolidays($this->UORGID);
		$data['json'] = json_encode(array("status"=>"success","message"=>"","data"=>$data));
		$this->load->view('json_view', $data);
		return;
	}
	function loadPageHolidays(){
        //load page holidays
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$data['org_id']=$this->UORGID;
		$pageId=$this->input->post("pageId",true);
		if(isset($pageId) && $pageId){
			$data['holidays']=$this->user_model->loadPageHolidays($this->UORGID,$pageId);
		}else{
			$data['holidays']=$this->user_model->loadHolidays($this->UORGID);
		}
		$data['json'] = json_encode(array("status"=>"success","message"=>"Holidays","data"=>$data));
		$this->load->view('json_view', $data);
		return;
	}
	
	function addHoliday(){
        // add holidays
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$orgatinID=$this->UORGID;
			$pageId=$this->input->post("hpageId",true);
			if(!isset($pageId) || !$pageId){
				$pageId=0;
			}
			
			if(isset($orgatinID) && $orgatinID){
				$config1 = array(
					array(
						'field' => 'title',
						'label' => 'Title',
						'rules' => 'trim|required',
					),
					array(
						'field' => 'startdate',
						'label' => 'Start Date',
						'rules' => 'trim|required',
					),
					array(
						'field' => 'enddate',
						'label' => 'End Date',
						'rules' => 'trim|required',
					)
				);

				$this->form_validation->set_rules($config1);
				$u_id=0;
				if($this->form_validation->run() === false){
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
					return;
				}else{
					$this->load->helper('date');
					$now = time();
					$udata['title']			= $this->input->post('title',true);
					$udata['startdate']		= date('Y-m-d', strtotime($this->input->post('startdate',true)));
					$udata['enddate']		= date('Y-m-d', strtotime($this->input->post('enddate',true)));
					$udata['status']		= 1;
					$udata['createdOn']		= unix_to_human($now, TRUE, 'us');
					$udata['org_id']		= $orgatinID;
					$udata['page_id']		= $pageId;
					$u_id=$this->user_model->createHoliday($udata);
					if($u_id){
						$data['json'] = json_encode(array("status"=>"success","message"=>"Holiday Created Successfully."));
						$this->load->view('json_view', $data);
						return;
					}
				}
			}
		}
	}
	function loadHoliday(){
        //load holiday
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$hID=$this->input->post('hId',true);
		if(isset($hID) && $hID && !$this->user_model->validateHoliday($hID,$this->UORGID)){
			$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
			$this->load->view('json_view', $data);
			return;
		}
		$data['holiday']=$this->user_model->loadHoliday($hID);
		$data['json'] = json_encode(array("status"=>"success","message"=>"Holiday Data.","data"=>$data));
		$this->load->view('json_view', $data);
		return;
	}
	function updateHoliday(){
        //update holiday
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$config1 = array(
					array(
						'field' => 'title',
						'label' => 'Title',
						'rules' => 'trim|required',
					),
					array(
						'field' => 'startdate',
						'label' => 'Start Date',
						'rules' => 'trim|required',
					),
					array(
						'field' => 'enddate',
						'label' => 'End Date',
						'rules' => 'trim|required',
					)
				);

				$this->form_validation->set_rules($config1);
				$u_id=0;
				if($this->form_validation->run() === false){
					$this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
					return;
				}else{
					$hID=$this->input->post('hId',true);
					if(isset($hID) && $hID && !$this->user_model->validateHoliday($hID,$this->UORGID)){
						$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
						$this->load->view('json_view', $data);
						return;
					}
					$this->load->helper('date');
					$now = time();
					$udata['title']			= $this->input->post('title',true);
					$udata['startdate']		= date('Y-m-d', strtotime($this->input->post('startdate',true)));
					$udata['enddate']		= date('Y-m-d', strtotime($this->input->post('enddate',true)));
					$udata['status']		= 1;
					$udata['createdOn']		= unix_to_human($now, TRUE, 'us');
					$udata['org_id']		= $this->UORGID;
					$u_id=$this->user_model->updateHoliday($hID,$udata);
					if($u_id){
						$data['json'] = json_encode(array("status"=>"success","message"=>"Holiday Updated Successfully."));
						$this->load->view('json_view', $data);
						return;
					}
				}
				return;
		}
	}
	function deleteHoliday(){
        //delete holiday
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$hID=$this->input->post('hId',true);
			if(isset($hID) && $hID && !$this->user_model->validateHoliday($hID,$this->UORGID)){
				$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
				$this->load->view('json_view', $data);
				return;
			}
			$dt['isDeleted'] = 1;
			$dHoliday=$this->user_model->updateHoliday($hID,$dt);
			if($dHoliday){
				$data['json'] = json_encode(array("status"=>"success","message"=>"Holiday Deleted Successfully."));
				$this->load->view('json_view', $data);
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to Delete Holiday."));
				$this->load->view('json_view', $data);
			}
			return;
		}
	}
	function manageHolidays(){
        //display holidays
		$orgID=$this->session->userdata("userOrganizationID");
		$data['org_id']=$orgID;
		$data['holidays']=$this->user_model->loadHolidays($this->session->userdata("userOrganizationID"));
	    $data['main_content'] = 'users/holidays';
        $this->load->view('page', $data);
		return;
	}
	
}
