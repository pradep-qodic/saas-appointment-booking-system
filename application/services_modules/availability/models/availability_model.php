<?php
/*
Author: Mitesh Patel
Date: 17/10/2014
Version: 1.0
*/

class Availability_model extends CI_Model{
	
	var $table = "settings";
	var $tableOrg = "organizations";
	var $tableHoli = "holidays";
	var $tableUser = "users";
	
	function __construct(){
		parent::__construct();
	}
	
	function create($data){
        $this->db->trans_start();
		$this->db->insert($this->table,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
    }
    function createHoliday($data){
    	$this->db->trans_start();
    	$this->db->insert($this->tableHoli,$data);
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
	function checkuserAvailability($id){
        $query = $this->db->query("SELECT * FROM $this->table where user_id=?",$id);
		if($query->num_rows > 0){
            return $query->row()->setting_id;
        }else{
            return false;
        }
    }
    function validateAvailability($id){
    	$query = $this->db->query("SELECT * FROM $this->table where setting_id=?",$id);
    	if($query->num_rows > 0){
    		return $query->row()->setting_id;
    	}else{
    		return false;
    	}
    }
   
	function read(){
		$query = $this->db->query("SELECT * FROM $this->table");
		return $query->result();
	}
    
	public function save_settings($settings,$id) {
       
	 	$this->db->where('name', "org_working_plans");
		$this->db->where('user_id', $id);
		
        if (!$this->db->update($this->table, array('value' =>$settings ))) {
            throw new Exception('Could not save setting ('. $settings . ')');
        }
        return $this->checkuserAvailability($id);
    }
    function createSetting($data){
    	$str = $this->db->insert_string($this->table, $data);
    
    	$query = $this->db->query($str);
    
    	if($query){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    function getWorkingPlans($id){
    	$query = $this->db->query("SELECT * FROM $this->table where user_id=? and name='org_working_plans'",$id);
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
    function getWorkingPlansByAvaiId($id){
    	$query = $this->db->query("SELECT * FROM $this->table where setting_id=? and name='org_working_plans'",$id);
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
    
   
 
	
	
    function updateHoliday($id, $userdata){
    	$data = (array)$userdata;
    	$where = "id = $id";
    	$str = $this->db->update_string($this->tableHoli, $data, $where);
    	$query = $this->db->query($str);
    	return $query;
    }

		
}

?>