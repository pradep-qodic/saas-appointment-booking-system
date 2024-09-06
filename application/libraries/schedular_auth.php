<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Schedular_auth
{
    function __construct()
    {
       $this->ci=& get_instance();
    }
	
	function process_login($login_array_input = NULL){
            if(!isset($login_array_input) OR count($login_array_input) != 2)
                return false;
            //set its variable
            $username = $login_array_input[0];
            $password = $login_array_input[1];
            // select data from database to check user exist or not?
            $query = $this->ci->db->query("SELECT * FROM `users` WHERE `email`= '".$username."' and status=1 and isSuperAdmin=1 LIMIT 1");
            if ($query->num_rows() > 0)
            {
				
                $row = $query->row();
                $user_id = $row->org_user_id;
                $user_pass = $row->password;
				$user_salt = $row->salt;
                if($this->encryptUserPwd( $password,$user_salt) === $user_pass){
					if($row->isVerifiedBySAdmin==0){
						$data['error'] = "Not Verified!";
						$data['main_content'] = 'admins/signin';
						$this->ci->load->view('page', $data);
						return;
					}else{
						$data['userid'] = $user_id;
						$data['isSuperAdmin'] = $row->isSuperAdmin;
						$data['userOrganizationID'] = $row->org_id;
						$data['userOrganizationURL'] = $this->getUserOrganizationURL($row->org_id);
						$data['logged_in'] = true;
						$data['fullname'] = $row->name;
						$this->ci->session->set_userdata($data);
						$year = time() + 31536000;
						$pReminder=$this->ci->input->post('remember',true);
					
						if(isset($pReminder) && $pReminder) {
							$this->ci->input->set_cookie('schedularremember_me', $this->ci->input->post('email',true),$year);
						}
						elseif(!isset($pReminder) || !$pReminder) {
							$ck=$this->ci->input->cookie('schedularremember_me');
							if(isset($ck) && $ck) {
								$past = time() - 100;
								$this->ci->input->set_cookie('schedularremember_me', '', $past);
							}
						}
						$this->_member_signin_redirect();
					}
                    return true;
                }else{
					$data['error'] = "Invalid Email or Password.";
					$data['main_content'] = 'admins/signin';
					$this->ci->load->view('page', $data);
				}
                return false;
            }else{
            	$data['error'] = "Unable to find your account.";
            	$data['main_content'] = 'admins/signin';
            	$this->ci->load->view('page', $data);
            }
            return false;
	}
	function process_superadmin_login($login_array_input = NULL){
		if(!isset($login_array_input) OR count($login_array_input) != 2)
			return false;
		//set its variable
		$username = $login_array_input[0];
		$password = $login_array_input[1];
		// select data from database to check user exist or not?
		$query = $this->ci->db->query("SELECT * FROM `users` WHERE `email`= '".$username."' and status=1 and isSuperAdmin=1 LIMIT 1");
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$user_id = $row->org_user_id;
			$user_pass = $row->password;
			$user_salt = $row->salt;
			if($this->encryptUserPwd( $password,$user_salt) === $user_pass){
				if($row->isVerifiedBySAdmin==0){
					$data['error'] = "Not Verified!";
					$data['main_content'] = 'admins/signin';
					$this->ci->load->view('page', $data);
					return;
				}else{
					$data['superAUserid'] = $user_id;
					$data['superALogged_in'] = true;
					$data['superAFullname'] = $row->firstname." ".$row->lastname;
					$this->ci->session->set_userdata($data);
					$year = time() + 31536000;
					$pReminder=$this->ci->input->post('remember',true);
					
					if(isset($pReminder) && $pReminder) {
						$this->ci->input->set_cookie('schedularSAdminremember_me', $this->ci->input->post('email',true),$year);
					}
					elseif(!isset($pReminder) || !$pReminder) {
						$ck=$this->ci->input->cookie('schedularSAdminremember_me');
						if(isset($ck) && $ck) {
							$past = time() - 100;
							$this->ci->input->set_cookie('schedularSAdminremember_me', '', $past);
						}
					}
					$this->_member_signin_superadmin_redirect();
				}
				return true;
			}else{
				$data['error'] = "Invalid Email or Password.";
				$data['main_content'] = 'admins/signin';
				$this->ci->load->view('page', $data);
			}
			return false;
		}else{
			$data['error'] = "Unable to find your account.";
			$data['main_content'] = 'admins/signin';
			$this->ci->load->view('page', $data);
		}
		return false;
	}
	function process_service_login($login_array_input = NULL){
            if(!isset($login_array_input) OR count($login_array_input) != 2)
                return false;
            //set its variable
            $username = $login_array_input[0];
            $password = $login_array_input[1];
            // select data from database to check user exist or not?
            $query = $this->ci->db->query("SELECT * FROM `users` WHERE `email`= '".$username."' and status=1 and isSuperAdmin=1 LIMIT 1");
            if ($query->num_rows() > 0)
            {
                $row = $query->row();
                $user_id   = $row->org_user_id;
                $user_pass = $row->password;
				$user_salt = $row->salt;
                if($this->encryptUserPwd(trim($password),$user_salt) === $user_pass){ 
                    return true;
                }
                return false;
            }
            return false;
	}
	function check_logged(){
		return ($this->ci->session->userdata('logged_user'))?TRUE:FALSE;
	}
	

	function logged_id(){
		return ($this->ci->check_logged())?$this->ci->session->userdata('logged_user'):'';
	}
	
	// Generate Random Digit
    function genRndDgt($length = 8, $specialCharacters = true) {
        $digits = '';	
        $chars = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";

        if($specialCharacters === true)
                $chars .= "!?=/&+,.";


        for($i = 0; $i < $length; $i++) {
                $x = mt_rand(0, strlen($chars) -1);
                $digits .= $chars[$x]; 
        }
        return $digits;
    }
   
	function validatePass($uid,$pass){
		$query = $this->ci->db->query("SELECT * FROM `users` WHERE `org_user_id`= '".$uid."' LIMIT 1");
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$user_pass = $row->password;
			$user_salt = $row->salt;
			if($this->encryptUserPwd( $pass,$user_salt) === $user_pass){ 
				return true;
			}
			return false;
		}
		return false;
	}
    // Generate Random Salt for Password encryption
    function genRndSalt() {
            return $this->genRndDgt(8, true);
    }

    // Encrypt User Password
    function encryptUserPwd($pwd, $salt) {
            return sha1(md5($pwd) . $salt);
    }
	//check if loggedin and redirect
	function _member_signin_redirect(){
        if($this->_is_logged_in()){
            $rPage=$this->ci->session->userdata('last_page');
            if(isset($rPage) && $rPage !=NULL && $rPage !=""){
                redirect($rPage,'refresh');
            }else{
                $rPage=base_url1().$this->ci->session->userdata('userOrganizationURL').'/admin/dashboard';
                redirect($rPage,'refresh');
            } 
        }
    }
    
    //check if loggedin and redirect superadmin
    function _member_signin_superadmin_redirect(){
    	if($this->_is_logged_in_superadmin()){
    		$rPage=$this->ci->session->userdata('Alast_page');
    		if(isset($rPage) && $rPage !=NULL && $rPage !=""){
    			redirect($rPage,'refresh');
    		}else{
    			$rPage=base_url1().'dashboard';
    			redirect($rPage,'refresh');
    		}
    	}
    }
	function _member_area(){
		if(!$this->_is_logged_in()){
			redirect('');
		}
	}
	function _member_area_redirect(){
        if(!$this->_is_logged_in()){
            $this->ci->load->helper('url');
            $this->ci->session->set_userdata('last_page', current_url());
			redirect('signin','refresh');
            return;
		}
	}
	function _member_area_redirect_superadmin(){
		if(!$this->_is_logged_in_superadmin()){
			$this->ci->load->helper('url');
			$this->ci->session->set_userdata('Alast_page', current_url());
			redirect('signin','refresh');
			return;
		}
	}
	function _is_logged_in(){
		if(null !== $this->ci->session->userdata('logged_in') && $this->ci->session->userdata('logged_in')){
			return true;
		}else{
			return false;
		}
	}
	function _is_logged_in_superadmin(){
		if(null !== $this->ci->session->userdata('superALogged_in') && $this->ci->session->userdata('superALogged_in')){
			return true;
		}else{
			return false;
		}
	}
	function getUserOrganizationURL($id){
		$query = $this->ci->db->query("SELECT * FROM `organizations` WHERE `org_id`= '".$id."' LIMIT 1");
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->org_url;
		}
	}
	function makeBaseURL($url=""){
		$str=$this->ci->uri->uri_string();
		$arr=explode("/",$str);
		array_pop($arr);
		$newurl=implode("/",$arr);
		return $newurl."/".$url;
	}
}
