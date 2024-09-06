<?php
/*
Author: Mitesh Patel
Date: 01/11/2014
Version: 1.0
*/

class Reminder_model extends CI_Model{
	var $table				= "applicant_notifications";
    var $tableAllocatedApps = "allocated_appointments";
    var $tableUsers			= "users";
	var $tableApp 			= "appointments";
	var $tableUserNotif		= "user_notification";
    

    function __construct(){
        parent::__construct();
    }

    function getAllNotifications(){
		$query = $this->db->query("SELECT * FROM $this->table");
		return $query->result();
	}
	function getPageAppointment($id){
		$query = $this->db->query("SELECT * FROM $this->tableApp where user_id=?",$id);
		return $query->result();
	}
	function findOrgAdminEmail($id){
		$query = $this->db->query("SELECT email FROM $this->tableUsers where org_user_id=? and isSuperAdmin=1",$id);
		return $query->result();
	}
	function releaseAllocatedSlots(){
		$query = $this->db->query("SELECT app_id,app_timezone FROM $this->tableApp");
		foreach($query->result() as $app){
			$timezone=$app->app_timezone;
			$id=$app->app_id;
			$curTime=current_local($timezone);
			$query1=$this->db->query("select * from $this->tableAllocatedApps where app_id=?",$id);
			if($query1->num_rows === 1){
				$res=$query1->result();
				$allocDate=unix_to_human(human_to_unix($res[0]->allocatedDateEnd));
				if($allocDate<$curTime){
					$query2=$this->db->query("delete from $this->tableAllocatedApps where app_id=?",$id);
					if($query2 && $this->db->affected_rows()==1){
						$this->db->query("update $this->tableApp set is_deleted=1 where app_id=?",$id);
					}
				}
			}
		}
    }
    function getUserNotification($id){
    	$query = $this->db->query("SELECT * FROM $this->tableUserNotif where user_id=?",$id);
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
	function getPageInfo($id){
		$query = $this->db->query("SELECT org_user_id,email,firstname,lastname,name,logo_url,booking_url,pageInfo,location,isSuperAdmin,mobileNo,status,createdbyUserId,userWorkingPlan,org_id,isAutomaticBooking FROM $this->tableUsers where org_user_id=?",$id);
		return $query->result();
	}
	
	
}

?>