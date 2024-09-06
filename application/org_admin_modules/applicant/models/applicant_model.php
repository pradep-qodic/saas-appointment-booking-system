<?php
/*
Author: Mitesh Patel
Date: 08/10/2014
Version: 1.0
*/

class Applicant_model extends CI_Model
{

	var $table = "appointments";
	var $tableOrg = "organizations";
	var $inspType = "inspection_type";
	var $tableSetting = "settings";
	var $tableUser = "users";
	var $tableAllocated = "allocated_appointments";
	var $tableHoli = "holidays";
	var $tableuserLeave = "user_leave";
	var $tableMasterPagePages = "master_booking_page_pages";
	var $userNotify = "user_notification";

	function __construct()
	{
		parent::__construct();
	}

	function create($data)
	{
		$str = $this->db->insert_string($this->table, $data);
		$query = $this->db->query($str);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	function createAppointment($data)
	{
		$this->db->trans_start();
		$this->db->insert($this->table, $data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
	function loadHolidaysData($id, $pId)
	{
		$query = $this->db->query("SELECT * FROM $this->tableHoli where page_id=? and org_id=$id and status=1", $pId);
		$mainArray = array();
		foreach ($query->result() as $row) {
			$dt = explode(" ", $row->startdate);
			$dt1 = explode(" ", $row->enddate);
			$array = array();
			$array['title'] = $row->title;
			$array['start'] = date('Y-m-d', strtotime($row->startdate));
			$array['end'] = date('Y-m-d', strtotime($row->enddate));
			array_push($mainArray, $array);
		}
		return $mainArray;
	}
	function isHoliday($sDate, $id, $pId)
	{
		$query = $this->db->query("SELECT * FROM $this->tableHoli where page_id=? and org_id=$id and status=1", $pId);
		$ret = false;
		foreach ($query->result() as $row) {
			$endDate = strtotime(date('Y-m-d', strtotime($row->enddate)));
			$current = strtotime(date('Y-m-d', strtotime($row->startdate)));
			if (($sDate == date('Y-m-d', strtotime($row->startdate))) || ($sDate == date('Y-m-d', strtotime($row->enddate)))) {
				$ret = true;
			}
			while ($current < $endDate) {
				$current = strtotime('+1 day', $current);
				if ($sDate == date('Y-m-d', $current)) {
					$ret = true;
				}
			}
		}
		return $ret;
	}
	function isHolidayMaster($sDate, $id, $mpId)
	{
		$ret = false;
		$query = $this->db->query("SELECT * FROM $this->tableMasterPagePages where master_booking_page_id=?", $mpId);
		if ($query->num_rows > 0) {

			foreach ($query->result() as $row1) {
				$query1 = $this->db->query("SELECT * FROM $this->tableHoli where page_id=? and org_id=$id and status=1", $row1->user_id);
				foreach ($query1->result() as $row) {
					$endDate = strtotime(date('Y-m-d', strtotime($row->enddate)));
					$current = strtotime(date('Y-m-d', strtotime($row->startdate)));
					if (($sDate == date('Y-m-d', strtotime($row->startdate))) || ($sDate == date('Y-m-d', strtotime($row->enddate)))) {
						$ret = true;
					}
					while ($current < $endDate) {
						$current = strtotime('+1 day', $current);
						if ($sDate == date('Y-m-d', $current)) {
							$ret = true;
						}
					}
				}
			}
		}
		return $ret;
	}

	function allocateAppointment($data)
	{
		$str = $this->db->insert_string($this->tableAllocated, $data);

		$query = $this->db->query($str);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	function loadUserNotWorkingDays($id)
	{
		$userArray = array();
		$query1 = $this->db->query("SELECT * FROM $this->tableuserLeave where userId=? and isDeleted=0", $id);
		foreach ($query1->result() as $row1) {
			$dt = explode(" ", $row1->leaveStartDate);
			$dt1 = explode(" ", $row1->leaveEndDate);
			array_push($userArray, $dt[0]);
		}
		array_push($mainArray, $userArray);
		$lastUserArray = array_pop($mainArray);
		$newArray = array();
		if (count($mainArray) > 0) {
			foreach ($mainArray as $main) {
				foreach ($main as $k => $m) {
					array_push($newArray, $m);
				}
			}
		}
		if (is_array($lastUserArray))
			$res = array_unique(array_merge($newArray, $lastUserArray)); //array_diff($newArray,$lastUserArray);

		$finalArray = array();
		if (isset($res) && $res && count($res) > 0) {
			foreach ($res as $r) {
				$array = array();
				$array['title'] = "Not Working";
				$array['start'] = $r;
				array_push($finalArray, $array);
			}
		}
		return $finalArray;
	}
	function loadPageNotWorkingDays($orgid)
	{
		$query = $this->db->query("SELECT value FROM $this->tableSetting where user_id=? and name='org_working_plans'", $orgid);
		$mainArray = array();
		$userResult = $query->row()->value;
		$userResult = (array)json_decode($userResult);
		$len = count($userResult);
		$nullArray = array();
		foreach ($userResult as $index => $val) {
			if (count($val) == 0) {
				array_push($nullArray, $index);
			}
		}

		return $nullArray;
	}
	function read()
	{
		$query = $this->db->get($this->table);
		$mainArray = array();
		foreach ($query->result() as $row) {
			$array = array();
			$array['title'] = $row->app_title;
			$array['start'] = $row->app_start;
			if ($row->app_end != "0000-00-00 00:00:00")
				$array['end'] = $row->app_end;
			array_push($mainArray, $array);
		}
		return $mainArray;
	}
	function appointments($id)
	{
		$query = $this->db->query("SELECT * FROM $this->table WHERE org_id=? and is_deleted = 0", $id);
		return $query->result();
	}
	function loadAppointment($id)
	{
		$query = $this->db->query("SELECT * FROM $this->table WHERE app_id=? and is_deleted = 0", $id);
		return $query->result();
	}
	function loadUserNotifyData($id)
	{
		$query = $this->db->query("SELECT * FROM $this->userNotify WHERE user_id=?", $id);
		return $query->result();
	}
	function getPageIdFromCode($code)
	{
		$query = $this->db->query("SELECT * FROM $this->table where rescheduled_code=?", $code);
		if ($query->num_rows === 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	function loadAllocatedSlots($id, $selectedDate)
	{
		$sDate = $selectedDate;
		$query = $this->db->query("SELECT * FROM $this->tableAllocated WHERE allocatedToUserId=?", $id);
		$array['slots'] = array();
		foreach ($query->result() as $row) {
			$dtNew = new DateTime($row->allocatedDate);
			$dt = explode(" ", $row->allocatedDate);
			if ($dt[0] == $sDate && count($dt) > 1) {
				array_push($array['slots'], $dtNew->format('H:i'));
			}
		}
		return $array['slots'];
	}
	function pendingApp($id)
	{
		$query = $this->db->query("SELECT count(app_id) as pendingApp FROM $this->table WHERE is_viewed = 0 and calendarId=?", $id);
		return $query->row()->pendingApp;
	}
	function read_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM $this->table WHERE created_by = $id");
		return $query->result();
	}
	function getPageInfo($id)
	{
		$query = $this->db->query("SELECT org_user_id,email,name,pageInfo,mobileNo,booking_url,status,location,firstname as owner FROM $this->tableUser WHERE org_user_id = ? and isSuperAdmin=0 ", $id);
		return $query->result();
	}
	function getCalInfo($id, $oUrl)
	{
		$query = $this->db->query("SELECT org_user_id,email,name,pageInfo,mobileNo,booking_url,status,location,firstname as owner FROM $this->tableUser WHERE org_user_id = ? and isSuperAdmin=0 ", $id);
		foreach ($query->result() as $row) {
			$query->row()->booking_url = base_url1() . $oUrl . "/" . $query->row()->booking_url;
		}
		return $query->result();
	}
	function getMasterPageInfo($id)
	{
		$query = $this->db->query("SELECT * FROM $this->inspType WHERE inspectionTypeId = ?", $id);
		return $query->result();
	}
	function getMasterPagePages($id)
	{
		$query = $this->db->query("SELECT * FROM $this->tableMasterPagePages WHERE master_booking_page_id = ?", $id);
		if (count($query->result()) > 0) {
			$main = array();
			foreach ($query->result() as $row) {
				$query1 = $this->db->query("SELECT org_user_id,email,name,booking_url,pageInfo,mobileNo FROM $this->tableUser WHERE org_user_id = ? and isDeleted=0 and isSuperAdmin=0", $row->user_id);
				if ($query1->num_rows > 0)
					array_push($main, $query1->result());
			}
			return $main;
		} else {
			return false;
		}
	}
	function appointmentsTypes($uID)
	{
		$query = $this->db->query("SELECT * FROM $this->inspType where createdBy=?", $uID);
		return $query->result();
	}
	function findOrgAdminUserID($orgID)
	{
		$query = $this->db->query("SELECT org_user_id FROM $this->tableUser where org_id=? and isSuperAdmin=1", $orgID);
		if ($query->num_rows === 1) {
			return $query->row()->org_user_id;
		} else {
			return false;
		}
	}
	function isDisabled($resourceId)
	{
		$query = $this->db->query("SELECT status FROM $this->tableUser where org_user_id=? and isSuperAdmin=0", $resourceId);
		if ($query->num_rows === 1 && $query->row()->status == 0) {
			return true;
		} else {
			return false;
		}
	}
	function isMasterPageDisabled($pageId)
	{
		$query = $this->db->query("SELECT status FROM $this->inspType where inspectionTypeId=?", $pageId);
		if ($query->num_rows === 1 && $query->row()->status == 0) {
			return true;
		} else {
			return false;
		}
	}
	function findResourceID($resource_url)
	{
		$query = $this->db->query("SELECT org_user_id FROM $this->tableUser where booking_url=? and isSuperAdmin=0", $resource_url);
		if ($query->num_rows === 1) {
			return $query->row()->org_user_id;
		} else {
			return false;
		}
	}
	function findMasterPageID($resource_url)
	{
		$query = $this->db->query("SELECT inspectionTypeId FROM $this->inspType where booking_url=?", $resource_url);
		if ($query->num_rows === 1) {
			return $query->row()->inspectionTypeId;
		} else {
			return false;
		}
	}
	function isMasterPage($resource_url)
	{
		$query = $this->db->query("SELECT inspectionTypeId FROM $this->inspType where booking_url=?", $resource_url);
		if ($query->num_rows === 1) {
			return true;
		} else {
			return false;
		}
	}
	function getInspetionTypeName($id)
	{
		$query = $this->db->query("SELECT typeName FROM $this->inspType where inspectionTypeId=?", $id);
		if ($query->num_rows === 1) {
			return $query->row()->typeName;
		} else {
			return false;
		}
	}
	function read_by_id_notSynchd($id)
	{
		$query = $this->db->query("SELECT * FROM $this->table WHERE created_by = $id and isSynchd=0");
		return $query->result();
	}
	function read_by_event_id($id)
	{
		$query = $this->db->query("SELECT * FROM $this->table WHERE id = $id");
		return $query->result();
	}
	function getSlots($id)
	{
		$query = $this->db->query("SELECT value FROM $this->tableSetting where user_id=? and name='org_working_plans'", $id);
		return $query->result();
	}
	function getPagePages($id)
	{
		$query = $this->db->query("SELECT * FROM $this->tableMasterPagePages WHERE master_booking_page_id = ?", $id);
		return $query->result();
	}
	function getAllUsers($orgID, $inspTypeId)
	{
		$query = $this->db->query("SELECT * FROM $this->tableUser where org_id=? and isSuperAdmin='0' and inspectionTypeId='$inspTypeId'", $orgID);
		return $query->result();
	}
	function getUserDetail($id)
	{
		$query = $this->db->query("SELECT * FROM $this->tableUser where org_user_id=?", $id);
		return $query->result();
	}
	function findOrgAdminEmail($id)
	{
		$query = $this->db->query("SELECT email FROM $this->tableUser where org_user_id=? and isSuperAdmin=1", $id);
		return $query->result();
	}
	function getBookingPageSetting($id)
	{
		$query = $this->db->query("SELECT isAutomaticBooking FROM users WHERE org_user_id = ?", $id);
		if ($query->num_rows === 1) {
			return $query->row()->isAutomaticBooking;
		} else {
			return false;
		}
	}
	function validateCode($code)
	{
		$query = $this->db->query("SELECT * FROM $this->table where rescheduled_code=?", $code);
		if ($query->num_rows === 1) {
			return true;
		} else {
			return false;
		}
	}
	function getAllUsersAllocatedSlots($orgID)
	{
		$query = $this->db->query("SELECT app_start FROM $this->tableAllocated where org_id=(select org_id from $this->table where org_id=?)", $orgID);
		return $query->result();
	}
	function validateAppointment($uid, $oid)
	{
		$query = $this->db->query("SELECT * FROM $this->table WHERE app_id = '$uid' AND org_id = '$oid'");
		if ($query->num_rows === 1) {
			return true;
		} else {
			return false;
		}
	}
	function validateOrgName($orgName)
	{
		$query = $this->db->query("SELECT * FROM $this->tableOrg WHERE org_url = ?", $orgName);
		if ($query->num_rows === 1) {
			return $query->row()->org_id;
		} else {
			return false;
		}
	}
	function setDefaultFolder($uid)
	{
		$query = $this->db->query("SELECT * FROM $this->ftable WHERE user_id = '$uid' AND folder_name = 'Personal'");
		if ($query->num_rows === 1) {
			return $query->row()->folder_id;
		} else {
			return false;
		}
	}

	function is_user_event($uid, $eid)
	{
		$query = $this->db->query("SELECT * FROM $this->table WHERE created_by = " . $uid . " and id='" . $eid . "'");
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
	function update($id, $edata)
	{
		$data = (array)$edata;
		$where = "app_id = $id";
		$str = $this->db->update_string($this->table, $data, $where);
		$query = $this->db->query($str);
		return $query;
	}


	function delete_event($eId, $uId)
	{
		$query = $this->db->query("delete from $this->table where id=? and created_by=" . $uId, $eId);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
}
