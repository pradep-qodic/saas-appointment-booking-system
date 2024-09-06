<?php
/*
Author: Mitesh Patel
Date: 21/10/2014
Version: 1.0
*/

class User_model extends CI_Model{
	
	var $table = "users";
	var $tableOrg = "organizations";
	var $tableHoli = "holidays";
	var $tableLeave = "user_leave";
	
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
	function read(){
		$query = $this->db->query("SELECT * FROM $this->table");
		return $query->result();
	}
	function loadUsers($id){
		$query = $this->db->query("SELECT * FROM $this->table where org_id=? and isDeleted=0 and isSuperAdmin=0",$id);
		return $query->result();
	}
	function loadUser($id){
		$query = $this->db->query("SELECT * FROM $this->table where org_user_id=? and isDeleted=0",$id);
		return $query->result();
	}
	function loadUserByEmail($email){
		$query = $this->db->query("SELECT * FROM $this->table where email=? and isDeleted=0",$email);
		return $query->result();
	}
	function loadHolidays($id){
		$query = $this->db->query("SELECT * FROM $this->tableHoli where org_id=? and status=1 and page_id =0 and isDeleted=0",$id);
		return $query->result();
	}
	function loadPageHolidays($id,$pgId){
		$query = $this->db->query("SELECT * FROM $this->tableHoli where org_id=? and page_id=$pgId and isDeleted=0",$id);
		return $query->result();
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
	function loadLeaves($id){
		$query = $this->db->query("SELECT * FROM $this->tableLeave where userId=? and isDeleted=0",$id);
		return $query->result();
	}
	function loadCalLeaves($id){
        $query = $this->db->query("SELECT * FROM $this->tableLeave where userId=? and isDeleted=0",$id);
		$mainArray=array();
		foreach($query->result() as $row)
		{
			$dt=explode(" ",$row->leaveStartDate);
			$dt1=explode(" ",$row->	leaveEndDate);
			$array = array();
			$array['id'] = $row->userLeaveId;
			$array['title'] = $row->leaveTitle; 
			$array['start'] = $dt[0]; 
			if($dt1[0] !="0000-00-00 00:00:00"){
				$array['end'] = $dt1[0];
			}
			array_push($mainArray,$array);
		}
		return $mainArray;
    }
	function loadLeaveInfo($id){
		$query = $this->db->query("SELECT * FROM $this->tableLeave where userLeaveId=? and isDeleted=0",$id);
		return $query->result();
	}
	function loadplanInfo($id){
		$query = $this->db->query("SELECT * FROM $this->tableLeave where userLeaveId=? and isDeleted=0",$id);
		return $query->result();
	}
    function pendingRequests(){
		$query = $this->db->query("SELECT * FROM $this->table where isVerifiedBySAdmin=0");
		return $query->result();
	}
    
    function validateResource($id,$org_id){
		$query = $this->db->query("SELECT * FROM $this->table where org_user_id=? and org_id='".$org_id."' and isDeleted=0 and isSuperAdmin=0",$id);
		
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
	function createLeave($data){
		$this->db->trans_start();
		$this->db->insert($this->tableLeave,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
	function loadHolidaysData($org_id){
        $query = $this->db->query("SELECT * FROM $this->tableHoli WHERE org_id=? and status=1 and page_id =0 and isDeleted=0", $org_id);
		$mainArray=array();
		foreach($query->result() as $row)
		{
			$dt=explode(" ",$row->startdate);
			$dt1=explode(" ",$row->enddate);
			$array = array();
			$array['title'] = $row->title; 
			$array['start'] = $dt[0]; 
			$array['end'] = $dt1[0];
			array_push($mainArray,$array);
		}
		return $mainArray;
    }
	function loadHoliday($hID){
        $query = $this->db->query("SELECT * FROM $this->tableHoli WHERE id = ? and isDeleted=0", $hID);
		$mainArray=array();
		foreach($query->result() as $row)
		{
			$dt=explode(" ",$row->startdate);
			$dt1=explode(" ",$row->enddate);
			$array = array();
			$array['title'] = $row->title; 
			$array['start'] = $dt[0]; 
			$array['end'] = $dt1[0];
			array_push($mainArray,$array);
		}
		return $mainArray;
    }
	function createHoliday($data){
		$this->db->trans_start();
		$this->db->insert($this->tableHoli,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
    function user_by_uid($id){
        $query = $this->db->query("
			SELECT *
			FROM $this->table
			WHERE id = $id
		");
        if($query->num_rows > 0){
            return $query->row();
        }else{
            return false;
        }
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
    function userDetails_by_id($id){
        //Get ID
        $query = $this->db->query("SELECT * FROM $this->table WHERE id = ?", $id);

        if($query->num_rows > 0){
            return $query->row();
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
	function updateLeave($id, $userdata){
		$data = (array)$userdata;
		$where = "userLeaveId = $id"; 
		$str = $this->db->update_string($this->tableLeave, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	function createUserWorkingPlan($id, $Workingdata){
		$data = (array)$Workingdata;
		$where = "org_user_id = $id"; 
		$str = $this->db->update_string($this->table, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	public function save_WorkingPlan($id, $Workingdata) {
        if (!is_array($settings)) {
            throw new Exception('$settings argument is invalid: '. print_r($settings, TRUE));
        }
        
        foreach($settings as $setting) {
            $this->db->where('org_user_id', $id);
			$value=$setting['value'];
            if (!$this->db->update($this->tableSetting, array('value' =>$value ))) {
                throw new Exception('Could not save setting (' . $setting['name'] 
                        . ' - ' . $setting['value'] . ')');
            }
        }
        
        return TRUE;
    }
	function loadUserWorkingPlan($id){
		$query = $this->db->query("SELECT userWorkingPlan FROM $this->table where org_user_id=? and isDeleted=0",$id);
		return $query->result();
	}
	function loadUserWorkingPlanForCalendarDisplay($id){
		$query = $this->db->query("SELECT * FROM $this->table where org_user_id=? and isDeleted=0",$id);
		return $query->result();
	}
	function updateUser($email, $userdata){
		$data = (array)$userdata;
		$where = "email = '$email'"; 
		$str = $this->db->update_string($this->table, $data, $where);
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
	function updateHoliday($id, $userdata){
		$data = (array)$userdata;
		$where = "id = $id"; 
		$str = $this->db->update_string($this->tableHoli, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	function validateHoliday($hId, $org_id){
		$query = $this->db->query("SELECT * FROM $this->tableHoli WHERE id = '$hId' AND org_id = '$org_id'");
		if($query->num_rows === 1){
			return $query->row();
		}else{
			return false;
		}
	}
    function update_by_email($email, $userdata){
        $data = (array)$userdata;
        $where = "user_email ='".$email."'";
        $str = $this->db->update_string($this->table, $data, $where);
        $query = $this->db->query($str);
        return $query;
    }
	
	function deleteUser($id){
		$query = $this->db->query("delete FROM $this->table WHERE org_user_id = ?", $id);
        if($query){
            return true;
        }else{
            return false;
        }
	}
	function deleteHoliday($id){
		$query = $this->db->query("delete FROM $this->tableHoli WHERE id = ?", $id);
        if($query){
            return true;
        }else{
            return false;
        }
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