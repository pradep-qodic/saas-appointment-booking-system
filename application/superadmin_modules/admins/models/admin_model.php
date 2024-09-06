<?php
/*
Author: Mitesh Patel
Date: 17/7/2014
Version: 1.0
*/

class Admin_model extends CI_Model{
	
	var $table = "users";
	var $tableOrg = "organizations";
	var $tableApp = "appointments";
	var $tableSetting = "settings";
	var $tableuserLeave = "user_leave";
	var $tableinspType = "inspection_type";
	var $tableUserNoti = "user_notification";
	var $tableAppliNoti = "applicant_notifications";
	var $tableBookingPagePages = "master_booking_page_pages";
	
	function __construct(){
		parent::__construct();
	}
	
	function create($data){
        $str = $this->db->insert_string($this->table, $data);

        $query = $this->db->query($str);

        if($query){
            return true;
        }else{
            return false;
        }
    }
	
	function createUserNotifications($data){
        $str = $this->db->insert_string($this->tableUserNoti, $data);

        $query = $this->db->query($str);

        if($query){
            return true;
        }else{
            return false;
        }
    }
	function createApplicantNotifications($data){
        $str = $this->db->insert_string($this->tableAppliNoti, $data);

        $query = $this->db->query($str);

        if($query){
            return true;
        }else{
            return false;
        }
    }
	function read(){
		$query = $this->db->query("SELECT * FROM $this->table");
		return $query->result();
	}
	function loadResources($id){
		$query = $this->db->query("SELECT * FROM $this->table where org_id=? and isDeleted=0 and isSuperAdmin=0",$id);
		return $query->result();
	}
	function getAppTotalData($id){
		$query = $this->db->query("SELECT sum(isApproved=1) as approved,sum(isApproved=0) as rejected,sum(isApproved=-1) as requested FROM $this->tableApp where org_id=? and is_deleted=0",$id);
		return $query->result();
	}
	function getSlots($orgID){
		$query = $this->db->query("SELECT value FROM $this->tableSetting where org_id=? and name='org_working_plans'",$orgID);
		return $query->result();
	}
	function validateBookingPageUrl($url){
		$query = $this->db->query("SELECT org_user_id FROM $this->table where booking_url=?",$url);
        if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	function validateOrgUser($id,$org_id){
		$query = $this->db->query("SELECT org_user_id FROM $this->table where org_user_id=? and org_id=$org_id and isDeleted=0",$id);
        if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	function validateOrgMasterPage($id,$org_id){
		$query = $this->db->query("SELECT inspectionTypeId FROM $this->tableinspType where inspectionTypeId=? and org_id=$org_id",$id);
        if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	function appointmentsTypes(){
		$query = $this->db->query("SELECT * FROM $this->tableinspType");
		return $query->result();
	}
	function loadOrganizationNotWorkingDays($orgid){
		$query = $this->db->query("SELECT org_working_plans FROM $this->tableOrg where org_id=?",$orgid);
		$mainArray=array();
		$userResult=$query->row()->org_working_plans;
		$userResult=(array)json_decode($userResult);
		$len=count($userResult);
		$nullArray=array();
		foreach($userResult as $index=>$val){
			if(count($val)==0){
				array_push($nullArray,$index);
			}
		}
		
		return $nullArray;
	}
	function loadUserNotWorkingDays($appTypeId){
		$query = $this->db->query("SELECT * FROM $this->table where inspectionTypeId=? and IsDeleted=0",$appTypeId);
		$mainArray=array();
		foreach($query->result() as $row)
		{
			$uID=$row->org_user_id;
			$query1 = $this->db->query("SELECT * FROM $this->tableuserLeave where userId=? and 	isDeleted=0",$uID);
			foreach($query1->result() as $row1)
			{
				$dt=explode(" ",$row1->leaveStartDate);
				$dt1=explode(" ",$row1->leaveEndDate);
				$array = array();
				$array['id'] = $row1->userLeaveId;
				$array['title'] = "Not Working"; 
				$array['start'] = $dt[0]; 
				array_push($mainArray,$array);
			}
			
		}
		return $mainArray;
	}
    function pendingRequests(){
		$query = $this->db->query("SELECT * FROM $this->table where isVerifiedBySAdmin=0");
		return $query->result();
	}
    
    function check_email($email){
		$query = $this->db->query("SELECT id FROM $this->table where user_email='".$email."'");
        if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	function validateEmail($email){
		$query = $this->db->query("SELECT org_user_id FROM $this->table where email=? and isSuperAdmin=1 and isDeleted=0",$email);
        if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	function validateOrg($orgName){
		$query = $this->db->query("SELECT org_id FROM $this->tableOrg where org_url='".$orgName."'");
        if($query->num_rows === 1){
			return $query->row()->org_id;
		}else{
			return 0;
		}
	}
	public function save_settings($settings,$id) {
        if (!is_array($settings)) {
            throw new Exception('$settings argument is invalid: '. print_r($settings, TRUE));
        }
        
        foreach($settings as $setting) {
            $this->db->where('name', $setting['name']);
			$this->db->where('user_id', $id);
			$value=$setting['value'];
            if (!$this->db->update($this->tableSetting, array('value' =>$value ))) {
                throw new Exception('Could not save setting (' . $setting['name'] 
                        . ' - ' . $setting['value'] . ')');
            }
        }
        
        return TRUE;
    }
	public function save_org_settings($settings,$id) {
        if (!is_array($settings)) {
            throw new Exception('$settings argument is invalid: '. print_r($settings, TRUE));
        }
        
		foreach($settings as $setting) {
			$this->db->where('org_id', $id);
			$value=$setting['value'];
            if (!$this->db->update($this->tableOrg, array('org_working_plans' =>$value ))) {
                throw new Exception('Could not save setting (' . $setting['name'] 
                        . ' - ' . $setting['value'] . ')');
            }
        }
        
        return TRUE;
    }
	function getOrgInfo($id=0){
		$query = $this->db->query("SELECT * FROM $this->tableOrg where org_id=?",$id);
		return $query->result();
	}
	function createSetting($data){
        $str = $this->db->insert_string($this->tableSetting, $data);

        $query = $this->db->query($str);

        if($query){
            return true;
        }else{
            return false;
        }
    }
	function getWorkingPlans($id){
		$query = $this->db->query("SELECT * FROM $this->tableSetting where user_id=? and name='org_working_plans'",$id);
		if($query->num_rows === 1){
			return $query->result();
		}else{
			$dt['user_id']=$id;
			$dt['name']="org_working_plans";
			$dt['value']='{"monday":null,"tuesday":null,"wednesday":null,"thursday":null,"friday":null,"saturday":null,"sunday":null}';
			$res=$this->createSetting($dt);
			if($res){
				$this->getWorkingPlans($id);
			}
		}
		return;
	}
	function getOrgWorkingPlans($id){
		$query = $this->db->query("SELECT org_working_plans	FROM $this->tableOrg where org_id=?",$id);
		if($query->num_rows === 1){
			$plans=$query->row()->org_working_plans;
			if($plans !=""){
				return $query->result();
			}else{
				$dt['org_working_plans']='{"monday":null,"tuesday":null,"wednesday":null,"thursday":null,"friday":null,"saturday":null,"sunday":null}';
				$res=$this->updateOrg($id,$dt);
				if($res){
					$this->getOrgWorkingPlans($id);
				}
			}
			
		}
	}
	function setResourceDefaultWorkingPlan($id,$uId){
		$query = $this->db->query("SELECT *	FROM $this->tableOrg where org_id=?",$id);
		$orgPlans=$this->getOrgWorkingPlans($id);
		$dt['user_id']=$uId;
		$dt['name']="org_working_plans";
		$dt['value']=$orgPlans[0]->org_working_plans;
		$res=$this->createSetting($dt);
	}
	
	function getUserInfo($id=0){
		$query = $this->db->query("SELECT org_user_id,email,firstname,lastname,name,logo_url,booking_url,pageInfo,location,isSuperAdmin,mobileNo,status,createdbyUserId,userWorkingPlan,org_id,isAutomaticBooking FROM $this->table where org_user_id=?",$id);
		return $query->result();
	}
	function getPageInfo($id,$org_id){
		$query = $this->db->query("SELECT * FROM $this->table where org_id=? and isSuperAdmin=0",$org_id);
		$res=$query->result();
		$main=array();
		if(count($res)>0){
			foreach($res as $i=>$val){
				$query1 = $this->db->query("SELECT * FROM $this->tableBookingPagePages where master_booking_page_id=?",$id);
				$res1=$query1->result();
				$flagCheck=false;
				if(count($res1)>0){
					foreach($res1 as $val1){
						if($val->org_user_id==$val1->user_id){
							$pages=array();
							$pages['pageId']=$val->org_user_id;
							$pages['booking_url']=$val->booking_url;
							$pages['name']=$val->name;
							$pages['checked']=1;
							$flagCheck=true;
							array_push($main,$pages);
						}
					}
				}
				if(!$flagCheck){
					$pages=array();
					$pages['pageId']=$val->org_user_id;
					$pages['booking_url']=$val->booking_url;
					$pages['name']=$val->name;
					$pages['checked']=0;
					array_push($main,$pages);
				}
				$flagCheck=false;
			}
			return $main;
		}else{
			return array();
		}
	}
	function getUserNotification($id){
		$query = $this->db->query("SELECT * FROM $this->tableUserNoti where user_id=?",$id);
		$notifications=array();
		$res=$query->result();
		if(count($res)>0){
			foreach($res as $val){
				$notifications['user_notification_id']=$val->user_notification_id;
				$notifications['user_id']=$val->user_id;
				$notifications['notify_on_booking']=$val->notify_on_booking;
				$notifications['notify_on_booking_request']=$val->notify_on_booking_request;
				$notifications['notify_on_cancellations']=$val->notify_on_cancellations;
				$notifications['cc_on_applicant_reminders']=$val->cc_on_applicant_reminders;
				$notifications['cc_on_followup_emails']=$val->cc_on_followup_emails;
				$n=$this->getUserName($val->user_id);
				$notifications['userName']=$n[0]->name;
			}
			return $notifications;
		}else{
			return array();
		}
	}
	function getApplicantNotification($id){
		$query = $this->db->query("SELECT * FROM $this->tableAppliNoti where bookingPageId=?",$id);
		$notifications=array();
		$res=$query->result();
		if(count($res)>0){
			foreach($res as $val){
				$notifications['app_notification_id']=$val->app_notification_id;
				$notifications['bookingPageId']=$val->bookingPageId;
				$notifications['reminderVal']=json_decode($val->reminderVal);
				$notifications['reminderNote']=$val->reminderNote;
				$notifications['followupEmailVal']=$val->followupEmailVal;
				$notifications['followupEmailNote']=$val->followupEmailNote;
			}
			return $notifications;
		}else{
			return array();
		}
	}
	function getApplicantLink($id){
		$query = $this->db->query("SELECT booking_url,status FROM $this->table where org_user_id=? and IsDeleted=0",$id);
		return $query->result();
	}
	function getUserName($id){
		$query = $this->db->query("SELECT name,firstname FROM $this->table where org_user_id=?",$id);
		return $query->result();
	}
	function getOrgName($id){
		$query = $this->db->query("SELECT org_url FROM $this->tableOrg where org_id=(select org_id from $this->table where org_user_id='".$id."')");
        if($query->num_rows === 1){
			return $query->row()->org_url;
		}else{
			return "";
		}
	}
	function createOrganization($data){
		$this->db->trans_start();
		$this->db->insert($this->tableOrg,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
	function createUser($data){
		$this->db->trans_start();
		$this->db->insert($this->table,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
    function userid_by_email($email){
        //Get ID
        $query = $this->db->query("SELECT id FROM $this->table WHERE user_email = ?", $email);

        if($query->num_rows > 0){
            return $query->row()->id;
        }else{
            return false;
        }
    }  
	function userEmailByID($id){
        //Get ID
        $query = $this->db->query("SELECT email FROM $this->table WHERE org_user_id = ?", $id);

        if($query->num_rows > 0){
            return $query->row()->email;
        }else{
            return false;
        }
    }
	function update($id, $userdata){
		$data = (array)$userdata;
		$where = "org_user_id = $id"; 
		$str = $this->db->update_string($this->table, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	function updateUserNotifications($id, $userdata){
		$data = (array)$userdata;
		$where = "user_id = $id"; 
		$str = $this->db->update_string($this->tableUserNoti, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	function updateApplicantNotifications($id, $userdata){
		$data = (array)$userdata;
		$where = "bookingPageId = $id"; 
		$str = $this->db->update_string($this->tableAppliNoti, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	function updateOrg($id, $userdata){
		$data = (array)$userdata;
		$where = "org_id = $id"; 
		$str = $this->db->update_string($this->tableOrg, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
    function update_by_email($email, $userdata){
        $data = (array)$userdata;
        $where = "user_email ='".$email."'";
        $str = $this->db->update_string($this->table, $data, $where);
        $query = $this->db->query($str);
        return $query;
    }
	
	function delete(){
		
	}
    
	function validate($user_email, $password){
		$query = $this->db->query("SELECT * FROM $this->table WHERE user_email = '$user_email' AND user_pass = '$password'");
		if($query->num_rows === 1){
			return $query->row();
		}else{
			return false;
		}
	}
   
	
		
}

?>