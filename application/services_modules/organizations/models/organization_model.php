<?php
/*
Author: Mitesh Patel
Date: 16/10/2014
Version: 1.0
*/

class Organization_model extends CI_Model{
	
	var $table = "organizations";
	
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
	function createOrganization($data){
		$this->db->trans_start();
		$this->db->insert($this->table,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
    function storetoken($data){
        $str = $this->db->insert_string($this->tokenTable, $data);

        $query = $this->db->query($str);

        if($query){
            return true;
        }else{
            return false;
        }

    }
    function getAppID($key){
        $appID=0;
        $query = $this->db->query("SELECT app_id FROM $this->appTable where public_key='".$key."'");
        if($query->num_rows > 0){
            $appID=$query->row()->app_id;
        }
        return $appID;
    }
    function getUID($code){
        $uID=0;
        $query = $this->db->query("SELECT user_id FROM $this->tokenTable where token_code='".$code."'");
        if($query->num_rows > 0){
            $uID=$query->row()->user_id;
        }
        return $uID;
    }
    function getAppIDFromToken($code){
        $appID=0;
        $query = $this->db->query("SELECT app_id FROM $this->tokenTable where token_code='".$code."'");
        if($query->num_rows > 0){
            $appID=$query->row()->app_id;
        }
        return $appID;
    }
    function checkTokenAvailable($id,$appID){
        $tCode="";
        $query = $this->db->query("SELECT token_code FROM $this->tokenTable where user_id=".$id." and app_id=".$appID);
        if($query->num_rows > 0){
            $tCode=$query->row()->token_code;
        }
        return $tCode;
    }
    function checkTokenCode($token){
        $query = $this->db->query("SELECT token_code FROM $this->tokenTable where token_code='".$token."'");
        if($query->num_rows > 0){
            return true;
        }else{
            return false;
        }

    }
	function getOrganizations(){
		$query = $this->db->query("SELECT * FROM $this->table where is_deleted=0");
		return $query->result();
	}
    function getOrganizationByID($oID){
		$query = $this->db->query("SELECT * FROM $this->table where org_id=".$oID);
		return $query->result();
	}
    function getActKey($email){
        $k="";
		$query = $this->db->query("SELECT activation_key FROM $this->table where user_email='".$email."'");
        if($query->num_rows > 0){
			$k=$query->row()->activation_key;
		}else{
			$k="";
		}
        return $k;
	}
    function check_email($email){
		$query = $this->db->query("SELECT id FROM $this->table where user_email='".$email."'");
        if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	
	function user_by_id($id){
		$query = $this->db->query("
			SELECT * 
			FROM $this->table
			WHERE id = $id
		");
		
		$query->row()->role = $this->get_role($id);
		$query->row()->role_name = $this->get_role_name($query->row()->role);
		
		if($query->num_rows > 0){
			return $query->row();
		}else{
			return false;
		}
	}
    
	function update($org_id, $orgdata){
		$data = (array)$orgdata;
		$where = "org_id = $org_id"; 
		$str = $this->db->update_string($this->table, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	function delete($org_id, $orgdata){
		$data = (array)$orgdata;
		$where = "org_id = $org_id"; 
		$str = $this->db->update_string($this->table, $data, $where);
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
	function checkOrgAvailability($orgID){
        $query = $this->db->query("SELECT * FROM $this->table where org_id=? and is_deleted=0",$orgID);
		if($query->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }
		
}

?>