<?php
/*
Author: Mitesh Patel
Date: 01/11/2014
Version: 1.0
*/

class Inspection_model extends CI_Model{

    var $table = "inspection_type";
    var $tableUsers = "users";
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
	function createMasterPagePages($data){
        $str = $this->db->insert_string($this->tableBookingPagePages, $data);

        $query = $this->db->query($str);
        if($query){
            return true;
        }else{
            return false;
        }
    }
	function createMasterCalendar($data){
		$this->db->trans_start();
		$this->db->insert($this->table,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
    function read(){
        $query = $this->db->get($this->table);
		$mainArray=array();
		foreach($query->result() as $row)
		{
			$array = array();
			$array['title'] = $row->app_title; 
			$array['start'] = $row->app_start; 
			if($row->app_end !="0000-00-00 00:00:00")
				$array['end'] = $row->app_end; 
			array_push($mainArray,$array);
		}
		return $mainArray;
    }
    function isAvailableMBookingPageUrl($url){
		$query = $this->db->query("SELECT * FROM $this->table where booking_url=? and status=1",$url);
		if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
    function read_by_id($id){
        $query = $this->db->query("SELECT * FROM $this->table WHERE inspectionTypeId = ?",$id);
        return $query->result();
    }
	function appointmentsTypes($id){
        $query = $this->db->query("SELECT * FROM $this->table where createdBy=?",$id);
        return $query->result();
    }
	function getApplicantLink($id){
		$query = $this->db->query("SELECT booking_url,pageInfo,status FROM $this->table where inspectionTypeId=?",$id);
		return $query->result();
	}
	function getPageInfo($id){
		$query = $this->db->query("SELECT * FROM $this->table where inspectionTypeId=?",$id);
		return $query->result();
	}
	function validateOrgMasterPage($id,$createdBy){
		$query = $this->db->query("SELECT inspectionTypeId FROM $this->table where inspectionTypeId=? and createdBy=$createdBy",$id);
        if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	function findMasterPagePages($id,$uId){
		$query = $this->db->query("SELECT master_booking_page_id FROM $this->tableBookingPagePages where master_booking_page_id=? and user_id=$uId",$id);
        if($query->num_rows === 1){
			return true;
		}else{
			return false;
		}
	}
	function appointmentTypeUsers($id){
        $query = $this->db->query("SELECT * FROM $this->tableUsers where inspectionTypeId=?",$id);
        return $query->result();
    }
    function appointmentTypeMoreUsers($org_id){
        $query = $this->db->query("SELECT * FROM $this->tableUsers where org_id=?",$org_id);
        $mainArray=array();
		foreach($query->result() as $row)
		{
            if($row->inspectionTypeId==0){
                $array = array();
                $array['user_id'] = $row->org_user_id; 
                $array['userName'] = $row->name; 
                array_push($mainArray,$array);
            }
			
		}
		return $mainArray;
    }
    function update($eid, $edata){
        $data = (array)$edata;
        $where = "inspectionTypeId = $eid";
        $str = $this->db->update_string($this->table, $data, $where);
        $query = $this->db->query($str);
        return $query;
    }
    function updateUser($eid, $edata){
        $data = (array)$edata;
        $where = "org_user_id = $eid";
        $str = $this->db->update_string($this->tableUsers, $data, $where);
        $query = $this->db->query($str);
        return $query;
    }
	function updateMasterPagePages($id,$uId, $edata){
        $data = (array)$edata;
        $where = "master_booking_page_id = $id and user_id=$uId";
        $str = $this->db->update_string($this->tableBookingPagePages, $data, $where);
        $query = $this->db->query($str);
        return $query;
    }
	function delete($id){
        $query=$this->db->query("delete from $this->table where inspectionTypeId=?",$id);
        if($query){
            return true;
        }else{
            return false;
        }
    }
    function deleteMasterPagePages($id,$userId){
        $query=$this->db->query("delete from $this->tableBookingPagePages where master_booking_page_id=? and user_id=$userId",$id);
        if($query){
            return true;
        }else{
            return false;
        }
    }
}

?>