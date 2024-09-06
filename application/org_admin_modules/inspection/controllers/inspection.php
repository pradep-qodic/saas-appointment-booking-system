<?php

class Inspection extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('inspection_model');
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
		$data['inspections']=$this->inspection_model->appointmentsTypes($this->UID);
		$data['main_content'] = 'inspectionTypes';
		$this->load->view('page', $data);
	}
	function loadInspTypes(){
        //load inspection types
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$id=$this->input->post('id',true);
			if(isset($id) && $id){
				$data['inspectionType']=$this->inspection_model->read_by_id($id);
				$data['json'] = json_encode(array("status"=>"success","message"=>"Information Loaded Successfully.","data"=>$data));
				$this->load->view('json_view', $data);
				return;
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to load data."));
				$this->load->view('json_view', $data);
				return;
			}
		}
	}
	function loadMasterBookingPages(){
        //load users master booking pages
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$data['masterBPages']=$this->inspection_model->appointmentsTypes($this->UID);
		$data['json'] = json_encode(array("status"=>"success","message"=>"Master Booking Pages.","data"=>$data));
		$this->load->view('json_view', $data);
		return;
	}
    function loadAppointmentTypeUsers(){
        //load appointment type users by user
    	$isAjax=$this->input->is_ajax_request();
    	if(!$isAjax){
    		$this->load->view('notFound');
    		return;
    	}
		if($_POST){
			$id=$this->input->post('id',true);
			if(isset($id) && $id){
				$data['appTypeUsers']=$this->inspection_model->appointmentTypeUsers($id);
				$data['json'] = json_encode(array("status"=>"success","message"=>"Information Loaded Successfully.","data"=>$data));
				$this->load->view('json_view', $data);
				return;
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to load data."));
				$this->load->view('json_view', $data);
				return;
			}
		}
	}
    function loadMoreAppointmentTypeUsers(){
        //load more appointment type users by organization
    	$isAjax=$this->input->is_ajax_request();
    	if(!$isAjax){
    		$this->load->view('notFound');
    		return;
    	}
		$org_id=$this->UORGID;
		$data['appTypeUsers']=$this->inspection_model->appointmentTypeMoreUsers($org_id);
		$data['json'] = json_encode(array("status"=>"success","message"=>"Information Loaded Successfully.","data"=>$data));
		$this->load->view('json_view', $data);
		return;
	}
    function addAppointmentTypeUsers(){
        //update appointment type user
    	$isAjax=$this->input->is_ajax_request();
    	if(!$isAjax){
    		$this->load->view('notFound');
    		return;
    	}
		if($_POST){
			$id=$this->input->post('inspectionTypeId',true);
            $uid=$this->input->post('user_id',true);
			if(isset($id) && $id && isset($uid) && $uid){
				$dt['inspectionTypeId']= $id;
				$u_id=$this->inspection_model->updateUser($uid,$dt);
				if($u_id){
					$data['json'] = json_encode(array("status"=>"success","message"=>"Information Updated Successfully."));
					$this->load->view('json_view', $data);
					return;
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update record."));
					$this->load->view('json_view', $data);
					return;
				}
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update record."));
				$this->load->view('json_view', $data);
				return;
			}
		}
	}
    function deleteAppointmentTypeUsers(){
        //delete user
    	$isAjax=$this->input->is_ajax_request();
    	if(!$isAjax){
    		$this->load->view('notFound');
    		return;
    	}	
		if($_POST){
			//$id=$this->input->post('inspectionTypeId',true);
            $uid=$this->input->post('user_id',true);
			if(isset($uid) && $uid){
				$dt['inspectionTypeId']= 0;
				$u_id=$this->inspection_model->updateUser($uid,$dt);
				if($u_id){
					$data['json'] = json_encode(array("status"=>"success","message"=>"Information Updated Successfully."));
					$this->load->view('json_view', $data);
					return;
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update record."));
					$this->load->view('json_view', $data);
					return;
				}
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update record."));
				$this->load->view('json_view', $data);
				return;
			}
		}
	}
	function create(){
        //create inspection type
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
        if($_POST){
                $config = array(
                    array(
                        'field' => 'inspectionType',
                        'label' => 'Master Calendar Name',
                        'rules' => 'trim|required',
                    )
                );
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() === false){
                    $this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
                }else{            
					$this->load->helper('date');
					$resources=$this->input->post('resourceIds',true);
					$now = time();
                    $data['typeName']		= $this->input->post('inspectionType',true);
                    $data['createdOn']	    = unix_to_human($now, TRUE, 'us');
					$data['org_id']			= $this->UORGID;
                    $data['createdBy']		= $this->UID;
                    
                    $create_id = $this->inspection_model->createMasterCalendar($data);
                    if($create_id){
						if(isset($resources) && $resources){
							foreach($resources as $resource){
								$dt1['inspectionTypeId']= $create_id;
								$this->inspection_model->updateUser($resource,$dt1);
							}
						}
						$data['json'] = json_encode(array("status"=>"success","message"=>"Master Calendar Created Successfully.","data"=>""));
						$this->load->view('json_view', $data);
                    }else{
                        $data['json'] = json_encode(array("status"=>"error","message"=>"Master Calendar Not Created.","data"=>$data));
						$this->load->view('json_view', $data);
                    }
                }
                return;
        }
    }
	function addMasterBookingPage(){
        //add master booking page
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		 if($_POST){
                $config = array(
                    array(
                        'field' => 'masterBookingPage',
                        'label' => 'Master Booking Page',
                        'rules' => 'trim|required|alpha_dash|min_length[4]|max_length[30]',
                    )
                );
                $this->form_validation->set_rules($config);
                if($this->form_validation->run() === false){
                    $this->form_validation->set_error_delimiters(' ', ' ');
					$arrV[]=validation_errors();
					$data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
					$this->load->view('json_view', $data);
                }else{ 
                	$pageUrl=$this->input->post('masterBookingPage',true);
                	$isMPageUrlAvailable=$this->inspection_model->isAvailableMBookingPageUrl($pageUrl);
                	if($isMPageUrlAvailable){
                		$data ['json'] = json_encode ( array (
                				"status" => "error",
                				"message" => "The Master Booking Page field must contain a unique value."
                		) );
                		$this->load->view ( 'json_view', $data );
                		return;
                	}
                	$this->load->model('admins/admin_model');
                	$isBPageUrlAvailable=$this->admin_model->isAvailableBookingPageUrl($pageUrl);
                	if($isBPageUrlAvailable){
                		$data ['json'] = json_encode ( array (
                				"status" => "error",
                				"message" => "The Booking Page field must contain a unique value."
                		) );
                		$this->load->view ( 'json_view', $data );
                		return;
                	}         
					$this->load->helper('date');
					$now = time();
                    $data['typeName']		= $pageUrl;
					$data['booking_url']	= $pageUrl;
					$data['org_id']			= $this->UORGID;
                    $data['createdOn']	    = unix_to_human($now, TRUE, 'us');
					$data['status']	    	= 1;
                    $data['createdBy']		= $this->UID;
                    
                    $create_id = $this->inspection_model->createMasterCalendar($data);
                    if($create_id){
						$data['json'] = json_encode(array("status"=>"success","message"=>"Master Booking Page Created Successfully.","data"=>""));
						$this->load->view('json_view', $data);
                    }else{
                        $data['json'] = json_encode(array("status"=>"error","message"=>"Master Booking Page Not Created.","data"=>$data));
						$this->load->view('json_view', $data);
                    }
                }
                return;
        }
	}
	function loadMasterBookingPageDetails(){
        //load master booking page details
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$masterPageId=$this->input->post("pageId",true);
		if(isset($masterPageId) && $masterPageId){
			if($this->inspection_model->validateOrgMasterPage($masterPageId,$this->UID)){
				$link=$this->inspection_model->getApplicantLink($masterPageId);
				$sts="Enabled";
				if($link[0]->status==0)$sts="Disabled";
				$data['applicantLinkStatus']=$sts;
				$data['applicantLink']=base_url().$this->UORGURL."/".$link[0]->booking_url;
				$data['pageInfo']=$this->inspection_model->getPageInfo($masterPageId);
				if(isset($data['pageInfo'][0]->logo_url) && $data['pageInfo'][0]->logo_url)
					$data['imagePath']=base_url()."uploads/masterBookingPage/".$data['pageInfo'][0]->logo_url."_thumb.jpg";
				else
					$data['imagePath']="";
				$data['json'] = json_encode(array("status"=>"success","message"=>"Master Booking Page Information","data"=>$data));
				$this->load->view('json_view', $data);
				return;
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
				$this->load->view('json_view', $data);
				return;
			}
		}else{
			$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to get page information"));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function saveMasterApplicantStatus(){
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		$masterPageId=$this->input->post("pageId",true);
		$updatedsts=$this->input->post("status",true);
		if(isset($masterPageId) && $masterPageId){
			if($this->inspection_model->validateOrgMasterPage($masterPageId,$this->UID)){
				$udata['status']=$updatedsts;
				$updateData=$this->inspection_model->update($masterPageId,$udata);
				if($updateData){
					$link=$this->inspection_model->getApplicantLink($masterPageId);
					$sts="Enabled";
					if($link[0]->status==0)$sts="Disabled";
					$data['applicantLinkStatus']=$sts;
					$data['applicantLink']=base_url().$this->UORGURL."/".$link[0]->booking_url;
					$data['json'] = json_encode(array("status"=>"success","message"=>"Master Applicant Link Status","data"=>$data));
					$this->load->view('json_view', $data);
					return;
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to save Link Status"));
					$this->load->view('json_view', $data);
					return;
				}
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
				$this->load->view('json_view', $data);
				return;
			}
		}else{
			$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to find notifications","data"=>$data));
			$this->load->view('json_view', $data);
			return;
		}
	}
	function update(){
        //update inspection type details
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$id=$this->input->post('inspectionTypeId',true);
			$resources=$this->input->post('resourceIds',true);
			$typeName=$this->input->post('inspectionType',true);
			if(isset($id) && $id){
				if(!isset($typeName) || !$typeName){
					$data['json'] = json_encode(array("status"=>"error","message"=>"Master Calendar Name is Required."));
					$this->load->view('json_view', $data);
					return;
				}
				$dt['typeName']= $typeName;
				$typeUpdate=$this->inspection_model->update($id,$dt);
				if($typeUpdate){
					if(isset($resources) && $resources){
						foreach($resources as $resource){
							$dt1['inspectionTypeId']= $id;
							$this->inspection_model->updateUser($resource,$dt1);
						}
					}
					$data['json'] = json_encode(array("status"=>"success","message"=>"Information Updated Successfully."));
					$this->load->view('json_view', $data);
					return;
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update record."));
					$this->load->view('json_view', $data);
					return;
				}
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update record."));
				$this->load->view('json_view', $data);
				return;
			}
		}
	}
	function saveMasterBookingPageSetup(){
        //update master booking page setup
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$id=$this->input->post('pageId',true);
			$pLabel=$this->input->post('pagelabel',true);
			if(!$pLabel)$pLabel="";
			$pInstruction=$this->input->post('pageInstruction',true);
			if(!$pInstruction)$pInstruction="";
			$checkedPages=$this->input->post('checkedIds',true);
			$uncheckedPages=$this->input->post('unCheckedIds',true);
			if(isset($id) && $id){
				$dt['bookingPageLabel']	= $pLabel;
				$dt['instruction']		= $pInstruction;
				$typeUpdate=$this->inspection_model->update($id,$dt);
				if($typeUpdate){
					if(isset($checkedPages) && $checkedPages){
						foreach($checkedPages as $checkedPage){
							$isAvailable=$this->inspection_model->findMasterPagePages($id,$checkedPage);
							if(!$isAvailable){
								$dt1['master_booking_page_id']= $id;
								$dt1['user_id']= $checkedPage;
								$this->inspection_model->createMasterPagePages($dt1);
							}else{
								$dt2['master_booking_page_id']= $id;
								$this->inspection_model->updateMasterPagePages($id,$checkedPage,$dt2);
							}
							
						}
					}
					if(isset($uncheckedPages) && $uncheckedPages){
						foreach($uncheckedPages as $uncheckedPage){
							$isAvailable=$this->inspection_model->findMasterPagePages($id,$uncheckedPage);
							if($isAvailable){
								$this->inspection_model->deleteMasterPagePages($id,$uncheckedPage);
							}
						}
					}
					$data['json'] = json_encode(array("status"=>"success","message"=>"Information Updated Successfully."));
					$this->load->view('json_view', $data);
					return;
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update record."));
					$this->load->view('json_view', $data);
					return;
				}
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update record."));
				$this->load->view('json_view', $data);
				return;
			}
		}
	}
	function saveMasterBookingPage(){
        //update master booking page details
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$id=$this->input->post('masterPageId',true);
			$typeName=$this->input->post('masterBookingPageName',true);
			$pageInfo=$this->input->post('masterPageWelcomeMsg',true);
			if(!$pageInfo)$pageInfo="";
			$email=$this->input->post('masterPageEmail',true);
			if(!$email)$email="";
			$phone=$this->input->post('masterPagePhone',true);
			if(!$phone)$phone="";
			$this->load->library('typography');
			if(isset($id) && $id){
				if(!isset($typeName) || !$typeName){
					$data['json'] = json_encode(array("status"=>"error","message"=>"Master Booking Page Name is Required."));
					$this->load->view('json_view', $data);
					return;
				}
				$dt['typeName']	= $typeName;
				$dt['pageInfo']	= $this->typography->auto_typography($pageInfo);
				$dt['email']	= $email;
				$dt['phone']	= $phone;
				$typeUpdate=$this->inspection_model->update($id,$dt);
				if($typeUpdate){
					$data['json'] = json_encode(array("status"=>"success","message"=>"Information Updated Successfully."));
					$this->load->view('json_view', $data);
					return;
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update record."));
					$this->load->view('json_view', $data);
					return;
				}
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to update record."));
				$this->load->view('json_view', $data);
				return;
			}
		}
	}
	function delete(){
        //delete inspection type
		$isAjax=$this->input->is_ajax_request();
		if(!$isAjax){
			$this->load->view('notFound');
			return;
		}
		if($_POST){
			$id=$this->input->post('pageId',true);
			if(isset($id) && $id){
				$u_id=$this->inspection_model->delete($id);
				if($u_id){
					$data['json'] = json_encode(array("status"=>"success","message"=>"Information Deleted Successfully."));
					$this->load->view('json_view', $data);
					return;
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to delete record."));
					$this->load->view('json_view', $data);
					return;
				}
			}else{
				$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to delete record."));
				$this->load->view('json_view', $data);
				return;
			}
		}
	}
}
