<?php
/*
Author: Mitesh Patel
Date: 08/10/2014
Version: 1.0
*/

class Appointment_model extends CI_Model{

    var $table = "appointments";
	var $inspType= "inspection_type";
	var $tableSetting= "settings";
	var $tableUser= "users";
	var $tableAllocated= "allocated_appointments";
	var $master_booking_page_pages="master_booking_page_pages";
	var $tableUserNotif		= "user_notification";

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
    function getAppointmentsByStatus($orgId,$sts){
    	$query = $this->db->query("SELECT * FROM $this->table WHERE isApproved=? and org_id={$orgId} and is_deleted=0",$sts);
    	return $query->result();
    }
    function findOrgAdminEmail($id){
    	$query = $this->db->query("SELECT email FROM $this->tableUser where org_user_id=? and isSuperAdmin=1",$id);
    	return $query->result();
    }
    function getPageInfo($id){
    	$query = $this->db->query("SELECT org_user_id,email,firstname,lastname,name,logo_url,booking_url,pageInfo,location,isSuperAdmin,mobileNo,status,createdbyUserId,userWorkingPlan,org_id,isAutomaticBooking FROM $this->tableUser where org_user_id=?",$id);
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
    function loadPageApps($orgId,$pageId){
    	$query = $this->db->query("SELECT * FROM $this->table WHERE org_id=? and user_id=$pageId and is_deleted = 0",$orgId);
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
        $query = $this->db->query("SELECT * FROM $this->table WHERE app_id=? and is_deleted = 0",$id);
        return $query->result();
    }
    function loadAppointmentBasicInfo($id){
    	$query = $this->db->query("SELECT app_id,app_title,app_start,app_end,applicant_name,applicant_email FROM $this->table WHERE app_id=? and is_deleted = 0",$id);
    	return $query->result();
    }
    function loadAppointmentWithDeleted($id){
    	$query = $this->db->query("SELECT * FROM $this->table WHERE app_id=?",$id);
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
	function loadAllocatedSlots($id,$selectedDate){
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
	function pendingApp($id){
        $query = $this->db->query("SELECT count(app_id) as pendingApp FROM $this->table WHERE is_viewed = 0 and org_id=? and is_deleted = 0",$id);
        return $query->row()->pendingApp;
    }
    
	function appointmentsTypes($id){
        $query = $this->db->query("SELECT * FROM $this->inspType where createdBy=?",$id);
        return $query->result();
    }
	
	function validateAppointment($appID,$org_id){
		$query = $this->db->query("SELECT app_id,user_id,app_start,isAutoBooking,isApproved FROM $this->table where app_id=? and org_id=$org_id and is_deleted = 0",$appID);
        if($query->num_rows === 1){
            return $query->result();
        }else{
            return false;
        }
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
    
    function update($id, $edata){
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

}

?>