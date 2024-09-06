<?php
/*
Author: Mitesh Patel
Date: 18/10/2014
Version: 1.0
*/

class Calendar_model extends CI_Model{
	
	var $tableUserOrg = "organizations";
	var $tableUser = "users";
	var $tableSetting= "settings";
	var $tableHoli = "holidays";
	var $inspType = "inspection_type";
	var $tableApp_notify = "applicant_notifications";
	var $user_notification = "user_notification";
	
	function __construct(){
		parent::__construct();
	}
	
	function create($data){
        $str = $this->db->insert_string($this->tableUser, $data);

        $query = $this->db->query($str);

        if($query){
            return true;
        }else{
            return false;
        }
    }
	function createCalendar($data){
		$this->db->trans_start();
		$this->db->insert($this->tableUser,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
	
	function read(){
		$query = $this->db->query("SELECT * FROM $this->tableUser");
		return $query->result();
	}
	function getOrgWorkingPlans($id){
		$query = $this->db->query("SELECT org_working_plans	FROM $this->tableUserOrg where org_id=?",$id);
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
	function isAvailableBookingPageUrl($url){
		$query = $this->db->query("SELECT org_user_id FROM $this->tableUser where booking_url=? and isDeleted=0",$url);
		if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	function isAvailableMBookingPageUrl($url){
		$query = $this->db->query("SELECT * FROM $this->inspType where booking_url=? and status=1",$url);
		if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	function isAvailableBookingPageUrlForUpdate($url,$calId){
		$query = $this->db->query("SELECT org_user_id FROM $this->tableUser where booking_url=? and org_user_id !={$calId} and isDeleted=0",$url);
		if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	function isAvailableMBookingPageUrlForUpdate($url,$calId){
		$query = $this->db->query("SELECT * FROM $this->inspType where booking_url=? and inspectionTypeId !={$calId} and status=1",$url);
		if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
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
	function setResourceDefaultWorkingPlan($id,$uId){
		$query = $this->db->query("SELECT *	FROM $this->tableUserOrg where org_id=?",$id);
		$orgPlans=$this->getOrgWorkingPlans($id);
		$dt['user_id']=$uId;
		$dt['name']="org_working_plans";
		$dt['value']=$orgPlans[0]->org_working_plans;
		$res=$this->createSetting($dt);
	}
	function loadHolidays($id){
		$query = $this->db->query("SELECT * FROM $this->tableHoli where org_id=? and status=1 and page_id =0",$id);
		return $query->result();
	}
	function createHoliday($data){
		$this->db->trans_start();
		$this->db->insert($this->tableHoli,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
	function setResourceDefaultHolidays($id,$uId){
		$orgHolidays=$this->loadHolidays($id);
		$this->load->helper('date');
		$now = time();
		foreach($orgHolidays as $holi){
			$dt['page_id']=$uId;
			$dt['org_id']=$id;
			$dt['title']=$holi->title;
			$dt['startdate']=$holi->startdate;
			$dt['enddate']=$holi->enddate;
			$dt['createdOn']=unix_to_human($now, TRUE, 'us');
			$res=$this->createHoliday($dt);
		}
	}
    function calendar_by_id($id,$orgId){
        $query = $this->db->query("SELECT org_user_id as calendarId,name,booking_url FROM $this->tableUser WHERE org_user_id = ? and isSuperAdmin=0 and isDeleted=0", $id);
        if($query->num_rows > 0){
        	$oName=$this->getOrgName($orgId);
        	$query->row()->booking_url=base_url1().$oName."/".$query->row()->booking_url;
            return $query->row();
        }else{
            return false;
        }
    }
	function calendar_by_orgid($id){
        $query = $this->db->query("SELECT org_user_id as calendarId,name,booking_url FROM $this->tableUser WHERE org_id = ?", $id);
        if($query->num_rows > 0){
            return $query->result();
        }else{
            return false;
        }
    }
    function getOrgName($id){
    	$query = $this->db->query("SELECT org_url FROM $this->tableUserOrg WHERE org_id = ?", $id);
    	if($query->num_rows > 0){
    		return $query->row()->org_url;
    	}else{
    		return '';
    	}
    }
	function getUserSalt($id){
        $query = $this->db->query("SELECT salt FROM $this->tableUser WHERE org_user_id = ?", $id);
        if($query->num_rows > 0){
            return $query->row()->salt;
        }else{
            return false;
        }
    }
	function user_by_email($email){
        $query = $this->db->query("SELECT * FROM $this->tableUser WHERE email = ?", $email);
        if($query->num_rows > 0){
            return $query->result();
        }else{
            return false;
        }
    }
	function checkCalendarAvailability($id){
        $query = $this->db->query("SELECT org_user_id FROM $this->tableUser WHERE org_user_id = ? and isDeleted=0", $id);
        if($query->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }
	function update($userid, $userdata){
		$data = (array)$userdata;
		$where = "org_user_id = $userid"; 
		$str = $this->db->update_string($this->tableUser, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	function delete($userid, $userdata){
		$data = (array)$userdata;
		$where = "org_user_id = $userid"; 
		$str = $this->db->update_string($this->tableUser, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
    function update_by_email($email, $userdata){
        $data = (array)$userdata;
        $where = "email ='".$email."'";
        $str = $this->db->update_string($this->tableUser, $data, $where);
        $query = $this->db->query($str);
        return $query;
    }
	function creatApp_notify($data){
		$this->db->trans_start();
		$this->db->insert($this->tableApp_notify,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
	function creatUserNotification($data){
		$this->db->trans_start();
		$this->db->insert($this->user_notification,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
	function updateUserNotifications($id, $userdata){
		$data = (array)$userdata;
		$where = "user_id = $id"; 
		$str = $this->db->update_string($this->user_notification, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	function updateApplicantNotifications($id, $userdata){
		$data = (array)$userdata;
		$where = "bookingPageId = $id"; 
		$str = $this->db->update_string($this->tableApp_notify, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	
		
}

?>