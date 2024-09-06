<?php
/*
Author: Mitesh Patel
Date: 16/10/2014
Version: 1.0
*/

class Organizations extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('organization_model');
		$this->load->library('form_validation');
    }
	function index(){
		$data['main_content'] = 'signin';
        $this->load->view('page', $data);
		return;
	}
	function getOrganization(){
		if($_POST){
			$config = array(
				array(
					'field' => 'org_id',
					'label' => 'Organization ID',
					'rules' => 'trim|required',
				)
			);

			$this->form_validation->set_rules($config);

			if($this->form_validation->run() === false){
			     $this->form_validation->set_error_delimiters(' ', ' ');
				 $arr[]=validation_errors();
				 $data['json'] = json_encode(array("status"=>"error","message"=>$arr));
				 $this->load->view('json_view', $data);
				 return;
			}else{
				$dt['organizations']=$this->organization_model->getOrganization($this->input->post('org_id'));
				$data['json'] = json_encode(array("status"=>"success","message"=>"Organizations","data"=>$dt));
				$this->load->view('json_view', $data);
				return;
			}
		}
	}
	function createOrganization(){
		$dt['organizations']=$this->organization_model->createOrganization();
		$data['json'] = json_encode(array("status"=>"success","message"=>"Organizations","data"=>$dt));
		$this->load->view('json_view', $data);
		return;
	}
    function signin(){
		if($_POST && isset($_POST['public_key']) && $this->_find_pkey($_POST['public_key'])){
            $config = array(
                array(
                    'field' => 'user_email',
                    'label' => 'E-mail',
                    'rules' => 'trim|required|valid_email',
                ),
                array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'trim|required',
                )
            );

            $this->form_validation->set_rules($config);

            if($this->form_validation->run() === false){
                if($this->_fetch_pkey($_POST['public_key'])==$this->config->item('public_key')){
                    $data['error'] = validation_errors();
                    $data['main_content'] = 'users/signin';
                    $this->load->view('page', $data);
                }else{
                    $this->form_validation->set_error_delimiters(' ', ' ');
                    $arr[]=validation_errors();
                    $data['json'] = json_encode(array("status"=>"error","message"=>$arr));
                    $this->load->view('json_view', $data);
                }
            }else{
                //Data
                $user_email = $this->input->post('user_email', true);
                $password 	= $this->input->post('password', true);
                $userdata 	= $this->user_model->validate($user_email, md5($password));

                //Validation
                if($userdata){
                    if($userdata->status == 0){
                        if($this->_fetch_pkey($_POST['public_key'])==$this->config->item('public_key')){
                            $data['error'] = "Not validated!";
                            $data['main_content'] = 'users/signin';
                            $this->load->view('page', $data);
                        }else{
                            $data['json'] = json_encode(array("status"=>"error","message"=>"Not validated!"));
                            $this->load->view('json_view', $data);
                        }
                    }else{
                        if($this->_fetch_pkey($_POST['public_key'])==$this->config->item('public_key')){
                            $data['userid'] = $userdata->id;
                            $data['logged_in'] = true;
							$data['fullname'] = $userdata->user_fullname;//$this->user_model->getUserFullname($userdata->id);
                            $appID=$this->_get_app_id($_POST['public_key']);
                            $data['access_token']=$this->_generate_access_token($userdata->id,$appID);
                            $this->session->set_userdata($data);
                            $year = time() + 31536000;
                            if(isset($_POST['remember']) && $_POST['remember']) {
                                setcookie('synchdremember_me', $_POST['user_email'],$year);
                            }
                            elseif(!isset($_POST['remember']) || !$_POST['remember']) {
                                if(isset($_COOKIE['synchdremember_me'])) {
                                    $past = time() - 100;
                                    setcookie('synchdremember_me', '', $past);
                                }
                            }
                            $this->_member_signin_redirect();
                        }else{
                            $dt['userid'] = $userdata->id;
                            $dt['logged_in'] = true;
							$dt['fullname'] = $userdata->user_fullname;//$this->user_model->getUserFullname($userdata->id);
                            $appID=$this->_get_app_id($_POST['public_key']);
                            $dt['access_token']=$this->_generate_access_token($userdata->id,$appID);
                            $data['json'] = json_encode(array("status"=>"success","message"=>"","data"=>$dt));
                            $this->load->view('json_view', $data);
                        }
                    }
                }else{
                    if($this->_fetch_pkey($_POST['public_key'])==$this->config->item('public_key')){
                        $data['error'] = "You shall not pass!";
                        $data['main_content'] = 'users/signin';
                        $this->load->view('page', $data);
                    }else{
                        $data['json'] = json_encode(array("status"=>"error","message"=>"You shall not pass!"));
                        $this->load->view('json_view', $data);
                    }
                }
            }

			return;
		}

        $k=$this->config->item('public_key');
        if(isset($k) && $this->_find_pkey($k)){
            //Redirect
            $this->_member_signin_redirect();
            $data['main_content'] = 'users/signin';
            $this->load->view('page', $data);  
        }else{
            $data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
            $this->load->view('json_view', $data);
        }
        return;
    }
	function signup(){
        if(isset($_POST['back'])){
            redirect("users/main");
        }
		if($_POST && isset($_POST['public_key']) && $this->_find_pkey($_POST['public_key'])){
			$config = array(
				array(
					'field' => 'fullname',
					'label' => 'Full name',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'email',
					'label' => 'E-mail',
					'rules' => 'trim|required|valid_email|is_unique[users.user_email]',
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required|min_length[4]|alpha_dash',
				)
			);

			$this->form_validation->set_rules($config);

			if($this->form_validation->run() === false){
			     if($this->_fetch_pkey($_POST['public_key'])==$this->config->item('public_key')){
			         $data['error'] = validation_errors();
                     $data['main_content'] = 'users/signup';
                     $this->load->view('page', $data);
			     }else{
			         $this->form_validation->set_error_delimiters(' ', ' ');
			         $arr[]=validation_errors();
			         $data['json'] = json_encode(array("status"=>"error","message"=>$arr));
                     $this->load->view('json_view', $data);
			     }
			}else{
				$data['user_fullname']		= $this->input->post('fullname',true);
				$data['user_pass']		= md5($this->input->post('password',true));
				$data['user_email']		= $this->input->post('email',true);
				$data['activation_key']	= md5(rand(0,1000).'synchedupfresh');
				$create = $this->user_model->create($data);
				if($create){
                    $id=$this->user_model->userid_by_email($data['user_email']);
                    $fdata['folder_name']	= "Personal";
                    $fdata['user_id']		= $id;
                    $fdata['is_default']	= 1;


                    $this->user_model->create_folder($fdata);
                    $dt['logo']		= "http://synchdup.makkinfotech.biz/themes/front/images/logo_64.png";//base_url()."themes/front/images/logo_64.png";
                    $dt['user_email']		= $data['user_email'];
                    $dt['activation_key']	= base_url()."users/activate/".$data['user_email']."/".$data['activation_key'];
                    $this->load->library('email', $this->config->item('email_config'));
					$this->email->from('support@makkinfotech.biz', 'Synchd Up');
					$this->email->to($data['user_email']);
					$this->email->subject('Welcome To Synchd Up - Activation Link');
                    $msg=$this->load->view('email/usr_activate_link',$dt,TRUE);
					$this->email->message($msg);
					$this->email->send();

                    if($this->_fetch_pkey($_POST['public_key'])==$this->config->item('public_key')){
                        $data['main_content'] = 'users/signup-success';
                        $this->load->view('page', $data);
                    }else{
                        $data['activation_msg']	= "We Sent Confirmation Link to your email. Please check your mail and confirm your account.";
                        $data['json'] = json_encode(array("status"=>"success","message"=>"signup success","data"=>$data));
                        $this->load->view('json_view', $data);
                    }
				}else{
					error_log("User could not be registered.");
				}
			}
			return;
		}
        $k=$this->config->item('public_key');
		if(isset($k) && $this->_find_pkey($k)){
            $this->_member_signin_redirect();
            $data['main_content'] = 'users/signup';
            $this->load->view('page', $data);
        }else{
            $data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
            $this->load->view('json_view', $data);
        }
        return;
	}

    function activate($email="",$key=""){
        $this->load->helper('url');
        $email=$this->uri->segment(3);
        $key=$this->uri->segment(4);
        if(isset($email) && $email !=NULL && $email !=""){
            $chk=$this->user_model->check_email($email);
            if(!$chk){
                $data['act_error']="Invalid Email. Please Check Your Email.";
                $data['main_content'] = 'users/activation';
                $this->load->view('page', $data);
                return;
            }
            $dbKey=$this->user_model->getActKey($email);
            if(isset($dbKey) && $dbKey !=NULL && $dbKey !="" && isset($key) && $key !=NULL && $key !="" && $dbKey==$key){
                $d=array("activation_key"=>'',"status"=>1);
                $rm=$this->user_model->updateKey($email,$d);
                if($rm){
                    $data['activation_success']="Now Your Account is Active. Please login to your account.";
                    $data['main_content'] = 'users/activation';
				    $this->load->view('page', $data);
                }
                
            }else{
                $data['act_error']="Invalid Key.";
                $data['main_content'] = 'users/activation';
                $this->load->view('page', $data);
            }
        }else{
            $data['act_error']="Invalid Email.";
            $data['main_content'] = 'users/activation';
            $this->load->view('page', $data);
        }  
    }
	
	function logout(){
		$this->session->sess_destroy();
		redirect('users/main','refresh');
	}


    function changePassword(){
        $arr=$this->_validate_access_token();
        $apID=$arr['app_id'];
        $uID=$arr['u_id'];
        if($apID==1){
            //Redirect
            $this->_member_area_redirect();
        }
        if(isset($_POST['cancelChangePassword'])){
            redirect("events");
        }
        if($_POST){
            $config = array(
                array(
                    'field' => 'opassword',
                    'label' => 'Old Password',
                    'rules' => 'trim|required|min_length[4]|alpha_dash',
                ),
                array(
                    'field' => 'npassword',
                    'label' => 'New Password',
                    'rules' => 'trim|required|min_length[4]|alpha_dash',
                ),
                array(
                    'field' => 'cpassword',
                    'label' => 'Confirm Password',
                    'rules' => 'trim|required|min_length[4]|alpha_dash|matches[npassword]',
                )
            );

            $this->form_validation->set_rules($config);
            if($this->form_validation->run() === false){
                if($apID==1){
                    $data['error'] = validation_errors();
                    $data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
                    $data['main_content'] = 'users/changePassword';
                    $this->load->view('page', $data);
                }else{
                    $this->form_validation->set_error_delimiters(' ', ' ');
                    $arrV[]=validation_errors();
                    $data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
                    $this->load->view('json_view', $data);
                }

            }else{
                $userdata = new stdClass();
                $oPass=$this->input->post('opassword');
                $cPass=$this->input->post('cpassword');
                if(isset($oPass) && !$this->user_model->validate_oldPass($uID,md5($oPass))){
                    if($apID==1){
                        $data['error'] = "Invalid old password.";
                        $data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
                        $data['main_content'] = 'users/changePassword';
                        $this->load->view('page', $data);
                    }else{
                        $data['json'] = json_encode(array("status"=>"error","message"=>"Invalid old password.","data"=>""));
                        $this->load->view('json_view', $data);
                    }
                    return;
                }

                $userdata->user_pass = md5($cPass);

                $updatePass = $this->user_model->update($uID, $userdata);

                if($updatePass){
                    if($apID==1){
                        $data['message'] = "Your Password Updated succesfully";
                        $data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
                        $data['main_content'] = 'users/changePassword';
                        $this->load->view('page', $data);
                    }else{
                        $data['json'] = json_encode(array("status"=>"success","message"=>"Your Password Updated succesfully.","data"=>""));
                        $this->load->view('json_view', $data);
                    }

                }

            }
            return;
        }
        if($apID==1){
            $data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
            $data['main_content'] = 'users/changePassword';
            $this->load->view('page', $data);
        }
    }
	function account(){
        $arr=$this->_validate_access_token();
        $apID=$arr['app_id'];
        $uID=$arr['u_id'];
        if($apID==1){
            //Redirect
            $this->_member_area_redirect();
        }
        if(isset($_POST['cancelAccount'])){
            redirect("events");
        }
		if($_POST){
            $config = array(
                array(
                    'field' => 'fullname',
                    'label' => 'Full name',
                    'rules' => 'trim|required',
                )
            );

            $this->form_validation->set_rules($config);
            if($this->form_validation->run() === false){
                if($apID==1){
                    $data['error'] = validation_errors();
                    $data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
                    $data['main_content'] = 'users/account';
                    $this->load->view('page', $data);
                }else{
                    $this->form_validation->set_error_delimiters(' ', ' ');
                    $arrV[]=validation_errors();
                    $data['json'] = json_encode(array("status"=>"error","message"=>$arrV));
                    $this->load->view('json_view', $data);
                }

            }else{
                $userdata = new stdClass();
                $userdata->user_fullname 	= $this->input->post('fullname');
                $insert = $this->user_model->update($uID, $userdata);

                if($insert){
                    if($apID==1){
                        $data['message'] = "Updated succesfully";
                        $data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
                        $data['main_content'] = 'users/account';
                        $this->load->view('page', $data);
                    }else{
                        $data['json'] = json_encode(array("status"=>"success","message"=>"Updated successfully.","data"=>""));
                        $this->load->view('json_view', $data);
                    }

                }

            }
            return;
		}
        if($apID==1){
            $data['user'] = $this->user_model->user_by_id($this->session->userdata('userid'));
            $data['main_content'] = 'users/account';
            $this->load->view('page', $data);
        }
	}

    function profile(){
        $arr=$this->_validate_access_token();
        $apID=$arr['app_id'];
        $uID=$arr['u_id'];
        if($_POST && isset($uID) && $uID){
            $dt['user'] = $this->user_model->user_by_uid($uID);
            $data['json'] = json_encode(array("status"=>"success","message"=>"User Profile","data"=>$dt));
            $this->load->view('json_view', $data);
        }else{
            $data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
            $this->load->view('json_view', $data);
        }
        if($apID==1){
            show_404();
        }
    }
	
//Hidden Methods not allowed by url request

	function _member_area(){
		if(!$this->_is_logged_in()){
			redirect('users/main');
		}
	}
	function _member_area_redirect(){
        if(!$this->_is_logged_in()){
            $this->load->helper('url');
            $this->session->set_userdata('last_page', current_url());
			redirect('users/main','refresh');
            return;
		}
	}
    function _generate_access_token($uID,$appID){
        $av=$this->_check_token_availability($uID,$appID);
        if($av){
            return $av;
        }
        $id=$this->session->userdata('userid');
        $key=$this->config->item('private_key');
        $access_token=md5(sha1($id)."MS".sha1($key).rand(0,1000).time().'access_token');
        $access = new stdClass();
        $access->user_id=$uID;
        $access->app_id=$appID;
        $access->token_code=$access_token;
        $access->valid_upto=date("Y-m-d h:i:s A",time() + 24 * 60 * 60);
        $storeToken = $this->user_model->storetoken($access);
        if($storeToken){
            return $access_token;
        }
    }
    function _check_token_availability($uID,$appID){
        $chkToken=$this->user_model->checkTokenAvailable($uID,$appID);
        if($chkToken){
            return $chkToken;
        }else{
            return $chkToken;
        }
    }
    function _check_token_code($token){
        $chkToken=$this->user_model->checkTokenCode($token);
        if($chkToken){
            return true;
        }else{
            echo json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
            exit;
        }
    }
    function _validate_access_token(){

        $sesToken=$this->session->userdata('access_token');
        if(isset($_POST['access_token']) && $this->_check_token_code($_POST['access_token'])){
            return array("app_id"=>$this->_get_App_id_from_token($_POST['access_token']),"u_id"=>$this->_get_u_id_from_token($_POST['access_token']));
        }else if(isset($sesToken) && $sesToken){
            return array("app_id"=>$this->_get_App_id_from_token($sesToken),"u_id"=>$this->_get_u_id_from_token($sesToken));
        }else{
            if((!isset($sesToken) || $sesToken=="") && (!isset($_POST['access_token']))){
                $this->_member_area_redirect();
            }else if(!isset($_POST['access_token']) || $_POST['access_token']==""){
                echo json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
            }else{
                echo json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
            }
            exit;
        }
    }
    function _get_app_id($key){
        $app_id=$this->user_model->getAppID($key);
        if($app_id !=0){
            return $app_id;
        }else{
            return 0;
        }
    }
    function _get_u_id_from_token($code){
        $u_id=$this->user_model->getUID($code);
        if($u_id !=0){
            return $u_id;
        }else{
            return 0;
        }
    }
    function _get_App_id_from_token($code){
        $app_id=$this->user_model->getAppIDFromToken($code);
        if($app_id !=0){
            return $app_id;
        }else{
            return 0;
        }
    }
    function _member_signin_redirect(){
        if($this->_is_logged_in()){
            $rPage=$this->session->userdata('last_page');
            if(isset($rPage) && $rPage !=NULL && $rPage !=""){
                redirect($rPage,'refresh');
            }else{
                $rPage='events';
                redirect($rPage,'refresh');
            } 
        }
    }
	function _is_logged_in(){
		if($this->session->userdata('logged_in')){
			return true;
		}else{
			return false;
		}
	}
    function _find_pkey($k){
		if(isset($k) && $this->user_model->findPublicKey($k)){
			return true;
		}else{
			return false;
		}
	}
    function _fetch_pkey($k){
		if(isset($k) && $this->user_model->findPublicKey($k)){
			return $this->user_model->fetchPublicKey($k);
		}else{
			return false;
		}
	}
	
	function userdata(){
		if($this->_is_logged_in()){
			return $this->user_model->user_by_id($this->session->userdata('userid'));
		}else{
			return false;
		}
	}
	
	function _is_admin(){
		if(@$this->users->userdata()->role === 1){
			return true;
		}else{
			return false;
		}
	}
    function check_usermail($email){
        $ans=$this->user_model->check_email($email);
        if(isset($ans) && $ans){
            return true;
        }else{
            return false;
        }
    }
    function getUserDetailsFromid($id){
        $data=$this->user_model->userDetails_by_id($id);
        if($data){
            return $data;
        }else{
            return false;
        }
    }
	function eventsSync(){
		if($_POST){
            $config = array(
                array(
                    'field' => 'isSyncStarted',
                    'label' => 'Is Sync Started',
                    'rules' => 'trim|required',
                )
            );

            $this->form_validation->set_rules($config);
			$this->load->helper('dateconverter');
            if($this->form_validation->run() === false){
                $this->form_validation->set_error_delimiters(' ', ' ');
				$arr[]=validation_errors();
				$data['json'] = json_encode(array("status"=>"error","message"=>$arr));
				$this->load->view('json_view', $data);
            }else{	
				$d['isSyncStarted']=$this->input->post('isSyncStarted');
				$arr=$this->_validate_access_token();
				$token=$this->input->post('access_token');
				$id=$arr["u_id"];
				if(isset($id) && $id && $this->user_model->isSyncStarted($id) && $d['isSyncStarted'] !=0){
					$data['json'] = json_encode(array("status"=>"error","message"=>"Sync already running","data"=>""));
					$this->load->view('json_view', $data);
				}else if(isset($id) && $id){
					$ans=$this->user_model->update($id,$d);
					if($ans){
						$ev=$this->user_model->getUserEvents($id);
						$events['events']=loadEvents($this->user_model->getUserEvents($id));
						$data['json'] = json_encode(array("status"=>"success","message"=>"done","data"=>$events));
						$this->load->view('json_view', $data);
						
					}else{
						$data['json'] = json_encode(array("status"=>"error","message"=>"Unable to set Sync.","data"=>""));
						$this->load->view('json_view', $data);
					}
				}else{
					$data['json'] = json_encode(array("status"=>"error","message"=>$this->config->item('unauthorized_access')));
					$this->load->view('json_view', $data);
				}
			}
		
        
		}
		
	}

}
