<?php
/*
Author: Mitesh Patel
Date: 18/10/2014
Version: 1.0
*/

class Mastercalendar_model extends CI_Model{
	
	var $table = "inspection_type";
    var $tableUsers = "users";
	var $tableBookingPagePages = "master_booking_page_pages";
	var $tableUserOrg="organizations";
	
	function __construct(){
		parent::__construct();
	}
	
	function createMasterCalendar($data){
		$this->db->trans_start();
		$this->db->insert($this->table,$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
	function masterCalendar_by_id($id,$orgId){
		$query = $this->db->query("SELECT inspectionTypeId as masterCalendarId,org_id,typeName as name,booking_url,status,createdOn,createdBy FROM $this->table WHERE inspectionTypeId = ? and status=1", $id);
		if($query->num_rows > 0){
			$oName=$this->getOrgName($orgId);
			$query->row()->booking_url=base_url1().$oName."/".$query->row()->booking_url;
			return $query->row();
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
	function checkCalendarAvailability($id){
		$query = $this->db->query("SELECT inspectionTypeId FROM $this->table WHERE inspectionTypeId = ? and status=1", $id);
		if($query->num_rows > 0){
			return true;
		}else{
			return false;
		}
	}
	function masterCalendar_by_orgid($id){
		$query = $this->db->query("SELECT inspectionTypeId as masterCalendarId,org_id,typeName as name,booking_url,status,createdOn,createdBy FROM $this->table WHERE org_id = ? and status=1", $id);
		if($query->num_rows > 0){
			foreach($query->result() as $rs){
				$oName=$this->getOrgName($id);
				$rs->booking_url=base_url1().$oName."/".$rs->booking_url;
			}
			return $query->result();
		}else{
			return false;
		}
	}
	function getMasterCalBycalId($calId){
		$query = $this->db->query("SELECT master_booking_page_id as masterCalendarId FROM $this->tableBookingPagePages WHERE user_id = ?", $calId);
		if($query->num_rows > 0){
			return $query->row()->masterCalendarId;
		}else{
			return false;
		}
	}
	function addCalendar($mCalId,$calId){
		$this->db->trans_start();
		$this->db->insert($this->tableBookingPagePages,array("master_booking_page_id"=>$mCalId,"user_id"=>$calId));
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
	function removeCalendar($mCalId,$calId){
		$this->db->where( 'master_booking_page_id', $mCalId );
		$this->db->where( 'user_id', $calId );
	    $this->db->delete( $this->tableBookingPagePages );
	
	    if ( $this->db->affected_rows() == '1' ) {return TRUE;}
	    else {return FALSE;}
	}
	function delete($userid, $userdata){
		$data = (array)$userdata;
		$where = "inspectionTypeId = $userid";
		$str = $this->db->update_string($this->table, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}
	function delete_Cal($id){
		$this->db->where( 'inspectionTypeId', $id );
	    $this->db->delete( $this->table );
	
	    if ( $this->db->affected_rows() == '1' ) {return TRUE;}
	    else {return FALSE;}
	}
		
}

?>