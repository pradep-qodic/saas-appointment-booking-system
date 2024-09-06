<?php
/*
Author: Mitesh Patel
Date: 11/02/2014
Version: 1.0
*/

class Appointment_model extends CI_Model{
	
	var $table = "appointments";
	var $tableOrg = "organizations";
	var $inspType= "inspection_type";
	var $tableSetting= "settings";
	var $tableUser= "users";
	var $tableAllocated= "allocated_appointments";
	var $tableHoli= "holidays";
	var $tableuserLeave="user_leave";
	var $tableMasterPagePages="master_booking_page_pages";
	var $userNotify="user_notification";
	var $tableAppNotify	= "applicant_notifications";

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
	function getInspetionTypeName($id){
        $query = $this->db->query("SELECT typeName FROM $this->inspType where inspectionTypeId=?",$id);
        if($query->num_rows === 1){
            return $query->row()->typeName;
        }else{
            return false;
        }
    }
    function findOrgAdminEmail($id){
    	$query = $this->db->query("SELECT email FROM $this->tableUser where org_user_id=? and isSuperAdmin=1",$id);
    	return $query->result();
    }
    function getBookingPageSetting($id){
    	$query = $this->db->query("SELECT isAutomaticBooking FROM users WHERE org_user_id = ?",$id);
    	if($query->num_rows === 1){
    		return $query->row()->isAutomaticBooking;
    	}else{
    		return false;
    	}
    }
    function getAppointmentsByStatus($orgId,$sts){
    	$query = $this->db->query("SELECT * FROM $this->table WHERE isApproved=? and org_id={$orgId} and is_deleted=0",$sts);
    	return $query->result();
    }
    function createAppointment($data){
    	$this->db->trans_start();
    	$this->db->insert($this->table,$data);
    	$insert_id = $this->db->insert_id();
    	$this->db->trans_complete();
    	return  $insert_id;
    }
    function loadUserNotifyData($id){
    	$query = $this->db->query("SELECT * FROM $this->userNotify WHERE user_id=?",$id);
    	return $query->result();
    }
    function getAppointmentsByFilter($orgId,$sts,$source){
    	$result=array();
    	if(isset($sts) && $sts ==-2 || isset($source) && $source=="ALL"){
    		$query = $this->db->query("SELECT * FROM $this->table where org_id={$orgId} and is_deleted=0 order by appointmentCreatedOn desc");
    		$result=$query->result_array();
    	}
    	
    	if(isset($sts) && $sts !=-2){
    		$query = $this->db->query("SELECT * FROM $this->table WHERE isApproved=? and is_deleted=0 order by appointmentCreatedOn desc",$sts);
    		$result=$query->result_array();
    	}
    	if(isset($source) && $source =="ALL_BP"){
    		$src=explode("_",$source);
    		if($src[0]=="BP" && $sts !=-2){
    			$query = $this->db->query("SELECT * FROM $this->table WHERE org_id={$orgId} and isApproved={$sts} and is_deleted=0 order by appointmentCreatedOn desc");
    			$result=$query->result_array();
    		}else if($src[0]=="BP" && $sts ==-2){
    			$query = $this->db->query("SELECT * FROM $this->table WHERE org_id={$orgId} and is_deleted=0 order by appointmentCreatedOn desc");
    			$result=$query->result_array();
    		}
    	}
    	$src=array();
    	if(isset($source) && $source !="ALL" && $source !="ALL_BP" && $source !="ALL_MBP"){
    		$src=explode("_",$source);
    		$id=$src[1];
    		if($src[0]=="BP" && $sts !=-2){
    			$query = $this->db->query("SELECT * FROM $this->table WHERE org_id={$orgId} and user_id=? and isApproved={$sts} and is_deleted=0 order by appointmentCreatedOn desc",$id);
    			$result=$query->result_array();
    		}else if($src[0]=="BP" && $sts ==-2){
    			$query = $this->db->query("SELECT * FROM $this->table WHERE org_id={$orgId} and user_id=? and is_deleted=0 order by appointmentCreatedOn desc",$id);
    			$result=$query->result_array();
    		}else if($src[0]=="MBP" && $sts !=-2){
    			 $query = $this->db->query("SELECT * FROM $this->table app inner join $this->master_booking_page_pages mbpp on mbpp.master_booking_page_id={$id} order by appointmentCreatedOn desc");
    			 $resultNew=$query->result_array();
    			 foreach($resultNew as $res){
    			 	$res1=array();
    			 	$query1 = $this->db->query("SELECT * FROM $this->table WHERE org_id={$orgId} and isApproved={$sts} and user_id={$res['user_id']} and is_deleted=0 order by appointmentCreatedOn desc");
    			 	$res1=$query1->result_array();
    			 	foreach($res1 as $r){
    			 		array_push($result,$r);
    			 	}
    			 	
    			 }
    		}else if($src[0]=="MBP" && $sts ==-2){
    			$query = $this->db->query("SELECT * FROM $this->table app inner join $this->master_booking_page_pages mbpp on mbpp.master_booking_page_id={$id} order by appointmentCreatedOn desc");
    			 $resultNew=$query->result_array();
    			 foreach($resultNew as $res){
    			 	$res1=array();
    			 	$query1 = $this->db->query("SELECT * FROM $this->table WHERE org_id={$orgId} and user_id={$res['user_id']} and is_deleted=0 order by appointmentCreatedOn desc");
    			 	$res1=$query1->result_array();
    			 	foreach($res1 as $r){
    			 		array_push($result,$r);
    			 	}
    			 }
    		}
    	}
   
    	$result = array_map('unserialize', array_unique(array_map('serialize', $result)));
    	return $result;
    }
    function getAppointmentsAll(){
    	$query = $this->db->query("SELECT * FROM $this->table order by appointmentCreatedOn desc");
    	return $query->result();
    }
	function allocateAppointment($data){
        $str = $this->db->insert_string($this->tableAllocated, $data);

        $query = $this->db->query($str);
        if($query){
            return true;
        }else{
            return false;
        }
    }
    function read($id){
        $query = $this->db->query("SELECT * FROM $this->table WHERE org_id=? and is_deleted = 0 order by appointmentCreatedOn desc",$id);
		$mainArray=array();
		foreach($query->result() as $row)
		{
			$array = array();
			$array['id'] = $row->app_id; 
			$array['title'] = $row->app_title; 
			$array['start'] = $row->app_start; 
			if($row->app_end !="0000-00-00 00:00:00")
				$array['end'] = $row->app_end; 
			array_push($mainArray,$array);
		}
		return $mainArray;
    }
    function loadPageApps($orgId,$pageId,$status){
    	if(isset($status) && ($status || $status==0)){
    		$query = $this->db->query("SELECT * FROM $this->table WHERE org_id=? and user_id=$pageId and is_deleted = 0 and isApproved={$status}",$orgId);
    	}else{
    		$query = $this->db->query("SELECT * FROM $this->table WHERE org_id=? and user_id=$pageId and is_deleted = 0",$orgId);
    	}
    	$mainArray=array();
    	if(isset($query) && $query){
    		foreach($query->result() as $row)
    		{
    			$array = array();
    			$array['id'] = $row->app_id;
    			$array['title'] = $row->app_title;
    			$array['start'] = $row->app_start;
    			if($row->app_end !="0000-00-00 00:00:00")
    				$array['end'] = $row->app_end;
    			array_push($mainArray,$array);
    		}
    	}
    	return $mainArray;
    }
    function loadMasterPageApps($orgId,$pageId,$status){
    	$mainArray=array();
    	$query='';
    	if(isset($status) && ($status || $status==0)){
    		$query = $this->db->query("SELECT * FROM $this->table app inner join $this->tableMasterPagePages mbpp on mbpp.master_booking_page_id={$pageId} where is_deleted = 0 and isApproved={$status} order by appointmentCreatedOn desc");
    	}else{
    		$query = $this->db->query("SELECT * FROM $this->table app inner join $this->tableMasterPagePages mbpp on mbpp.master_booking_page_id={$pageId} where is_deleted = 0 order by appointmentCreatedOn desc");
    	}
    	if(isset($query) && $query){
    		$resultNew=$query->result_array();
    		foreach($resultNew as $res){
    			$res1=array();
    			if(isset($status) && ($status || $status==0)){
    				$query1 = $this->db->query("SELECT * FROM $this->table WHERE org_id={$orgId} and user_id={$res['user_id']} and is_deleted=0 and isApproved={$status} order by appointmentCreatedOn desc");
    			}else{
    				$query1 = $this->db->query("SELECT * FROM $this->table WHERE org_id={$orgId} and user_id={$res['user_id']} and is_deleted=0 order by appointmentCreatedOn desc");
    			}
    			if(isset($query1) && $query1){
    				$res1=$query1->result_array();
    				foreach($res1 as $r){
    					$array = array();
    					$array['id'] = $r['app_id'];
    					$array['title'] = $r['app_title'];
    					$array['start'] = $r['app_start'];
    					if($r['app_end'] !="0000-00-00 00:00:00")
    						$array['end'] = $r['app_end'];
    					array_push($mainArray,$array);
    				}
    			}
    			
    		}
    		$mainArray = array_map('unserialize', array_unique(array_map('serialize', $mainArray)));
    	}
    	return $mainArray;
    }
	function appointments($id){
        $query = $this->db->query("SELECT * FROM $this->table WHERE org_id=? and is_deleted = 0 order by appointmentCreatedOn desc",$id);
        return $query->result();
    }
    function appointmentsAsArray($id){
    	$query = $this->db->query("SELECT * FROM $this->table WHERE org_id=? and is_deleted = 0 order by appointmentCreatedOn desc",$id);
    	return $query->result_array();
    }
    function appointmentsDeleted($id){
    	$query = $this->db->query("SELECT * FROM $this->table WHERE org_id=? and is_deleted = 1 order by appointmentCreatedOn desc",$id);
    	return $query->result_array();
    }
    function pageAppointments($oId,$pId){
    	$query = $this->db->query("SELECT * FROM $this->table WHERE org_id=? and user_id=$pId and is_deleted = 0",$oId);
    	return $query->result();
    }
	function appointmentsLog($id){
        $query = $this->db->query("SELECT * FROM $this->table WHERE org_id=? order by app_id desc",$id);
        return $query->result();
    }
	function loadAppointment($id){
        $query = $this->db->query("SELECT app_id,app_title,app_desc,app_start,app_end,app_timezone,applicant_name,applicant_email,applicant_phone,applicant_location,org_id,user_id as calendarId,isAutoBooking,isApproved,rejectReason,rescheduled_appid,rescheduled_reason,rescheduled_code,appointmentCreatedOn,is_deleted,is_viewed FROM $this->table WHERE app_id=? and is_deleted = 0",$id);
        return $query->result();
    }
    function loadAppointmentsByEmail($email){
    	$query = $this->db->query("SELECT app_id,app_title,app_desc,app_start,app_end,app_timezone,applicant_name,applicant_email,applicant_phone,applicant_location,org_id,user_id as calendarId,isAutoBooking,isApproved,rejectReason,rescheduled_appid,rescheduled_reason,rescheduled_code,appointmentCreatedOn,is_deleted,is_viewed FROM $this->table WHERE applicant_email=? and is_deleted = 0",$email);
    	return $query->result();
    }
    function getCalendarIdByAppId($id){
    	$query = $this->db->query("SELECT user_id FROM $this->table WHERE app_id=? and is_deleted = 0",$id);
    	return $query->row()->user_id;
    }
    function loadAppointmentsBycalId($id){
    	$query = $this->db->query("SELECT app_id,app_title,app_desc,app_start,app_end,app_timezone,applicant_name,applicant_email,applicant_phone,applicant_location,org_id,user_id as calendarId,isAutoBooking,isApproved,rejectReason,rescheduled_appid,rescheduled_reason,rescheduled_code,appointmentCreatedOn,is_deleted,is_viewed FROM $this->table WHERE user_id=? and is_deleted = 0",$id);
    	return $query->result();
    }
    
    function loadTrashAppointment($id){
    	$query = $this->db->query("SELECT * FROM $this->table WHERE app_id=? and is_deleted = 1 order by appointmentCreatedOn desc",$id);
    	return $query->result();
    }
	function loadAllocatedAppointment($id){
        $query = $this->db->query("SELECT * FROM $this->tableAllocated WHERE app_id=?",$id);
        return $query->result();
    }
	/* function loadAllocatedSlots($id,$selectedDate){
		$sDate=$selectedDate;
        $query = $this->db->query("SELECT * FROM $this->tableAllocated WHERE allocatedToUserId=?",$id);
        $array['slots'] = array();
		foreach($query->result() as $row)
		{
			$dtNew=new DateTime($row->allocatedDate);
			$dt=explode(" ",$row->allocatedDate);
			if($dt[0]==$sDate && count($dt)>1){
				array_push($array['slots'],$dtNew->format('H:i'));
			}
			
		}
		return $array['slots'];
    } */
    function loadAllocatedSlots($id,$selected_date,$slots,$timezone){
    	$sDate=$selected_date;
    	$query = $this->db->query("SELECT * FROM $this->tableAllocated WHERE allocatedToUserId=?",$id);
    	$available_hours=array();
    	foreach($query->result() as $row)
    	{
    		$dtNew=new DateTime($row->allocatedDate);
    		$dt=explode(" ",$row->allocatedDate);
    		$dtNew1=new DateTime($row->allocatedDateEnd);
    		$dt1=explode(" ",$row->allocatedDateEnd);
    		if($dt[0]==$sDate && count($dt)>1){
    		
	    		$empty_periods =array(array("start"=>$dtNew->format('H:i'),"end"=>$dtNew1->format('H:i'),"slots"=>$slots));
	    		$available_hours = array($dtNew->format('H:i'));
	    		foreach ($empty_periods as $period) {
	    			$start_hour = new DateTime($selected_date . ' ' . $period['start']);
	    			$end_hour = new DateTime($selected_date . ' ' . $period['end']);
	    			$slt=$period['slots'];
	    			$minutes = $start_hour->format('i');
	    			$start_hour->setTime($start_hour->format('H'),$slt);
	    			$current_hour = $start_hour;
	    			$diff = $current_hour->diff($end_hour);
	    			 
	    			while (($diff->h * 60 + $diff->i) >= intval($slt)) {
	    				$available_hours[] = $current_hour->format('H:i');
	    				$current_hour->add(new DateInterval("PT".$slt."M"));
	    				$diff = $current_hour->diff($end_hour);
	    			}
	    		}
	    		 
	    		$curUnix=gmt_to_local(now(),$timezone,false);
	    		//echo date('m/d/Y', strtotime($selected_date))." and ".strtotime('now')." and ".unix_to_human($curUnix);
	    		if (date('m/d/Y', strtotime($selected_date)) == date('m/d/Y')) {
	    			$book_advance_timeout = $slt;
	    			foreach($available_hours as $index => $value) {
	    				$available_hour = strtotime($value);
	    				$current_hour = strtotime('+' . $book_advance_timeout . ' minutes', $curUnix);
	    				if ($available_hour <= $current_hour) {
	    					unset($available_hours[$index]);
	    				}
	    			}
	    		}
	    		$available_hours = array_values($available_hours);
	    		sort($available_hours, SORT_STRING );
	    		$available_hours = array_values($available_hours);
    		
    			//array_push($array['slots'],$dtNew->format('H:i'));
    		} 
    			
    	}
    	return $available_hours;
    }
	function pendingApp($id){
        $query = $this->db->query("SELECT count(app_id) as pendingApp FROM $this->table WHERE is_viewed = 0 and org_id=? and is_deleted = 0",$id);
        return $query->row()->pendingApp;
    }
    
	function appointmentsTypes($id){
        $query = $this->db->query("SELECT * FROM $this->inspType where createdBy=?",$id);
        return $query->result();
    }
	
	function validateAppointment($appID,$org_id){
		$query = $this->db->query("SELECT app_id FROM $this->table where app_id=? and org_id=$org_id and is_deleted = 0",$appID);
        if($query->num_rows === 1){
            return $query->result();
        }else{
            return false;
        }
	}
	function getPageInfo($id){
		$query = $this->db->query("SELECT org_user_id,email,firstname,lastname,name,logo_url,booking_url,pageInfo,location,isSuperAdmin,mobileNo,status,createdbyUserId,userWorkingPlan,org_id,isAutomaticBooking FROM $this->tableUser where org_user_id=?",$id);
		return $query->result();
	}
	function getreminderNote($id){
		$query=$this->db->query("select * from $this->tableAppNotify where bookingPageId=?",$id);
		return $query->result();
	}
	function getUserNotification($id){
		$query = $this->db->query("SELECT * FROM $this->userNotify where user_id=?",$id);
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
	function loadAppointmentWithDeleted($id){
		
		$query = $this->db->query("SELECT * FROM $this->table WHERE app_id=?",$id);
		return $query->result();
	}
	
	function validateAppointments($appIDs,$org_id){
		$notValid=array();
		if(isset($appIDs) && $appIDs && count($appIDs)>0){
			foreach($appIDs as $id){
				$query = $this->db->query("SELECT * FROM $this->table where app_id=? and org_id=$org_id",$id);
				if($query->num_rows === 1){
				}else{
					array_push($notValid,$id);
				}
			}
		}
		if(isset($notValid) && $notValid && count($notValid)>0){
			return false;
		}else{
			return true;
		}
	}
	function getSlots($uId){
		$query = $this->db->query("SELECT value FROM $this->tableSetting where user_id=? and name='org_working_plans'",$uId);
		return $query->result();
	}
	function getAllUsers($orgID,$inspTypeId){
		$query = $this->db->query("SELECT * FROM $this->tableUser where org_id=? and isSuperAdmin='0' and inspectionTypeId='$inspTypeId'",$orgID);
		return $query->result();
	}
	function getUserDetail($id){
		$query = $this->db->query("SELECT * FROM $this->tableUser where org_user_id=?",$id);
		return $query->result();
	}
	function getAllUsersAllocatedSlots($orgID){
		$query = $this->db->query("SELECT app_start FROM $this->tableAllocated where org_id=(select org_id from $this->table where org_id=?)",$orgID);
		return $query->result();
	}
    
    function updateAppointment($id, $edata){        
		$data = (array)$edata;
        $where = "app_id = $id";
        $str = $this->db->update_string($this->table, $data, $where);
        $query = $this->db->query($str);
        return $query;
    }
	function updateAppointments($ids, $data){
        $data = (array)$data;
		if(isset($ids) && $ids && count($ids)>0){
			foreach($ids as $id){
				$where = "app_id = $id";
				$str = $this->db->update_string($this->table, $data, $where);
				$query = $this->db->query($str);
			}
			return $query;
		}else{
			return true;
		}
        
    }
    function releaseAllocatedApp($id){
    	$query=$this->db->query("delete from $this->tableAllocated where app_id=?",$id);
    	if($query){
    		return true;
    	}else{
    		return false;
    	}
    }
    function delete($appid){
        $query=$this->db->query("delete from $this->table where app_id=?",$eId);
        if($query){
            return true;
        }else{
            return false;
        }
    }
	
	//Update 01/07/2016
	function LoadPageAppread($org_id,$pid){
        $query = $this->db->query("SELECT * FROM $this->table WHERE org_id=? and user_id=? and is_deleted = 0 order by appointmentCreatedOn desc",array($org_id,$pid));
		$mainArray=array();
		foreach($query->result() as $row)
		{
			$array = array();
			$array['id'] = $row->app_id; 
			$array['title'] = $row->app_title; 
			$array['start'] = $row->app_start; 
			if($row->app_end !="0000-00-00 00:00:00")
				$array['end'] = $row->app_end; 
			array_push($mainArray,$array);
		}
		return $mainArray;
    }
	function FullloadAppointment($id){
        $query = $this->db->query("SELECT * FROM $this->table WHERE app_id=? and is_deleted = 0",$id);
        return $query->result();
    }
	function loadAppointmentBasicInfo($id){
    	$query = $this->db->query("SELECT app_id,app_title,app_start,app_end,applicant_name,applicant_email FROM $this->table WHERE app_id=? and is_deleted = 0",$id);
    	return $query->result();
    }
	function validateFullAppointment($appID,$org_id){
		$query = $this->db->query("SELECT * FROM $this->table where app_id=? and org_id=$org_id and is_deleted = 0",$appID);
        if($query->num_rows === 1){
            return $query->result();
        }else{
            return false;
        }
	}
	function MasterloadAllocatedSlots($id,$selectedDate){
		$sDate=$selectedDate;
        $query = $this->db->query("SELECT * FROM $this->tableAllocated WHERE allocatedToUserId=?",$id);
        $array['slots'] = array();
		foreach($query->result() as $row)
		{
			$dtNew=new DateTime($row->allocatedDate);
			$dt=explode(" ",$row->allocatedDate);
			if($dt[0]==$sDate && count($dt)>1){
				array_push($array['slots'],$dtNew->format('H:i'));
			}
			
		}
		return $array['slots'];
    }

}

?>