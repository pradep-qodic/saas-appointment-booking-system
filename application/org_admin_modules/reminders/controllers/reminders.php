 <?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH .'third_party/aws/aws-autoloader.php';
use Aws\Sns\SnsClient;
use Aws\Common\Credentials\Credentials;
class Reminders extends MY_Controller{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('reminder_model');
		$this->load->helper('date');
    }
 
    public function index()
    {
            //reminders for all notifications
			$allNotifications=$this->reminder_model->getAllNotifications();
			if($allNotifications){
				foreach($allNotifications as $i=>$notify){
					$pageId=$notify->bookingPageId;
					$pageReminders=$notify->reminderVal;
					$reminderNote=$notify->reminderNote;
					$reminderFollowupNote="";
					if(isset($notify->followupEmailNote) && $notify->followupEmailNote)
						$reminderFollowupNote=$notify->followupEmailNote;
						
					$reminderFollowupVal=$notify->followupEmailVal;
					$pageReminders=json_decode($pageReminders);
					$reminder1="";
					$reminder2="";
					$reminder3="";
					foreach($pageReminders as $i=>$remind){
						$i=$i+1;
						if($i==1)
							$reminder1=$remind;
						if($i==2)
							$reminder2=$remind;
						if($i==3)
							$reminder3=$remind;
					}
                    //get page appointments
					$pageAppointments=$this->reminder_model->getPageAppointment($pageId);
					$this->load->helper('date');
					foreach($pageAppointments as $app){
						$appdate=$app->app_start;
						if(isset($reminder1) && $reminder1){
							$this->_manageReminder($app,$reminder1,$reminderNote);
						}
						if(isset($reminder2) && $reminder2){
							$this->_manageReminder($app,$reminder2,$reminderNote);
						}
						if(isset($reminder3) && $reminder3){
							$this->_manageReminder($app,$reminder3,$reminderNote);
						}
						if(isset($reminderFollowupVal) && $reminderFollowupVal){
							$this->_manageFollowupReminders($app,$reminderFollowupVal,$reminderFollowupNote);
						}
					}
					
				}
			}
		$this->_releaseOutdatedAppsSlots();
		echo "Processing...";
    }
	/* 
		This function send appointment reminders
	*/
	function _manageReminder($app,$reminder,$rNote){
		$this->load->helper('timezoneformater');
		$reminderArray=array();
		$this->load->helper('date');
		$appdate=$app->app_start;
		$appTimeZone=$app->app_timezone;
		$reminderArray=explode("_",$reminder);
		$reminder=$reminderArray[0];
		$reminder_back=isset($reminderArray[1])?$reminderArray[1]:null;
		$currentTime = current_local($appTimeZone);
		$reminderTime="";
		if(isset($reminder_back) && $reminder_back=="min"){
			$time = new DateTime($appdate);
			$time->sub(new DateInterval('PT' . $reminder . 'M'));
			$reminderTime = $time->format('Y-m-d H:i');
			$reminderTime=unix_to_human(human_to_unix($reminderTime));
		}
		if(isset($reminder_back) && $reminder_back=="hour"){
			$time = new DateTime($appdate);
			$time->sub(new DateInterval('PT' . $reminder . 'H'));
			$reminderTime = $time->format('Y-m-d H:i');
			$reminderTime=unix_to_human(human_to_unix($reminderTime));
		}
		if(isset($reminder_back) && $reminder_back=="day"){
			$time = new DateTime($appdate);
			$time->sub(new DateInterval('P' . $reminder . 'D'));
			$reminderTime = $time->format('Y-m-d H:i');
			$reminderTime=unix_to_human(human_to_unix($reminderTime));
		}

		$pageDetails=$this->reminder_model->getPageInfo($app->user_id);
		$pageName="";
		if(isset($pageDetails) && $pageDetails && isset($pageDetails[0]->booking_url))$pageName=$pageDetails[0]->booking_url;
		if(isset($reminderTime) && $currentTime==$reminderTime){
			$dt['logo']				= "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
			$dt['user_email']		= $app->applicant_email;
			$dt['appTitle']			= $app->app_title;
			$dt['bookingDate']		= $appdate;
			$dt['bookingPage']		= $pageName;
			$dt['reminderNote']		= $rNote;
			
			$this->load->library('email', $this->config->item('email_config'));
			$this->email->from('support@makkinfotech.biz', 'Scheduler');
			$this->email->to($app->applicant_email);
			$this->email->subject($app->app_title.' - Booking Reminder');
			$msg=$this->load->view('email/bookingReminder',$dt,TRUE);
			$this->email->message($msg);
			$this->email->send();
			
			// send mail to cc email
			$ccEmail=$this->reminder_model->findOrgAdminEmail($app->user_id);
			$ccAppReminders=$this->reminder_model->getUserNotification($app->user_id);
			if(isset($ccAppReminders) && $ccAppReminders && $ccAppReminders[0]->cc_on_applicant_reminders==1){
				$this->load->library('email', $this->config->item('email_config'));
				$this->email->from('support@makkinfotech.biz', 'Scheduler');
				$this->email->to($ccEmail);
				$this->email->subject($app->app_title.' - Booking Reminder');
				$msg=$this->load->view('email/bookingReminder',$dt,TRUE);
				$this->email->message($msg);
				$this->email->send();
			}
			
		}
	}
	/* 
		This function send followup reminders
	*/
	function _manageFollowupReminders($app,$reminder,$rNote){
		$appdate=$app->app_end;
		$appTimeZone=$app->app_timezone;
		$reminderArray=explode("_",$reminder);
		$reminder=$reminderArray[0];
		$reminder_back=isset($reminderArray[1])?$reminderArray[1]:null;
		$currentTime = current_local($appTimeZone);
		$reminderTime="";
		
		if(isset($reminder_back) && $reminder_back=="min"){
			$time = new DateTime($appdate);
			$time->add(new DateInterval('PT' . $reminder . 'M'));
			$reminderTime = $time->format('Y-m-d H:i');
			$reminderTime=unix_to_human(human_to_unix($reminderTime));
		}
		if(isset($reminder_back) && $reminder_back=="hour"){
			$time = new DateTime($appdate);
			$time->add(new DateInterval('PT' . $reminder . 'H'));
			$reminderTime = $time->format('Y-m-d H:i');
			$reminderTime=unix_to_human(human_to_unix($reminderTime));
		}
		if(isset($reminder_back) && $reminder_back=="day"){
			$time = new DateTime($appdate);
			$time->add(new DateInterval('P' . $reminder . 'D'));
			$reminderTime = $time->format('Y-m-d H:i');
			$reminderTime=unix_to_human(human_to_unix($reminderTime));
		}
		$pageDetails=$this->reminder_model->getPageInfo($app->user_id);
		$pageName="";
		if(isset($pageDetails) && $pageDetails && isset($pageDetails[0]->booking_url))$pageName=$pageDetails[0]->booking_url;
		if(isset($reminderTime) && $currentTime==$reminderTime){
			$dt['logo']				= "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
			$dt['user_email']		= $app->applicant_email;
			$dt['appTitle']			= $app->app_title;
			$dt['bookingDate']		= $appdate;
			$dt['bookingPage']		= $pageName;
			$dt['reminderNote']		= $rNote;
			
			$this->load->library('email', $this->config->item('email_config'));
			$this->email->from('support@makkinfotech.biz', 'Scheduler');
			$this->email->to($app->applicant_email);
			$this->email->subject('Following up on your booking');
			$msg=$this->load->view('email/bookingFollowupReminder',$dt,TRUE);
			$this->email->message($msg);
			$this->email->send();
			
			// send mail to cc email
			$ccEmail=$this->reminder_model->findOrgAdminEmail($app->user_id);
			$ccFollowup=$this->reminder_model->getUserNotification($app->user_id);
			if(isset($ccFollowup) && $ccFollowup && $ccFollowup[0]->cc_on_followup_emails==1){
				$this->load->library('email', $this->config->item('email_config'));
				$this->email->from('support@makkinfotech.biz', 'Scheduler');
				$this->email->to($ccEmail);
				$this->email->subject($app->app_title.' - Booking Reminder');
				$msg=$this->load->view('email/bookingReminder',$dt,TRUE);
				$this->email->message($msg);
				$this->email->send();
			}
		}
	}
	/* 
		function removes all outdated appointment slots from appointments allocated table 
		and also make it deleted record in appointments table.
	*/
	function _releaseOutdatedAppsSlots(){
		$this->reminder_model->releaseAllocatedSlots();
	}
	
	function notification(){
		$accessKey=$this->config->item('aws_access_key');
		$accessSecretKey=$this->config->item('aws_secret_access_key');
		
		/* $credentials = new Credentials($accessKey, $accessSecretKey);
		
		// Instantiate the S3 client with your AWS credentials
		$s3Client = S3Client::factory(array(
				'credentials' => $credentials
		)); */
		
		try{
			
			$credentials = new Credentials($accessKey, $accessSecretKey);
			// Instantiate the Sns client with your AWS credentials
			$SnsClient = SnsClient::factory(array(
					'credentials' => $credentials,
					'region' => 'us-west-2'
			));
			
			// create topic 
			/*$result = $SnsClient->createTopic(array(
					// Name is required
					'Name' => 'MS',
			));*/
			$topicARN='arn:aws:sns:us-west-2:661605139368:MS';//$result['TopicArn'];
			
			//subscribe to topic
			/*$result1 = $SnsClient->subscribe(array(
					// TopicArn is required
					'TopicArn' => $topicARN,
					// Protocol is required
					'Protocol' => 'email',
					'Endpoint' => 'mspmakk@gmail.com',
			));
			*/
			// publish to topic
			$dt ['logo'] = "http://schedular.makkinfotech.biz/themes/front/images/logo_64.png";
			$dt ['user_email'] = "mspmakk@gmail.com";
			$dt ['scheduleDate'] = "2015-4-1";
			$dt ['AppointmentTitle'] = "Checking";
			$msg = $this->load->view ( 'email/bookingConfirmed', $dt, TRUE );
			$result2 = $SnsClient->publish(array(
					'TopicArn' => $topicARN,
					// Message is required
					'Message' => $msg,
					'Subject' => 'API Check'
			));
			
			print_r($result2);
		}catch(SNSException $e) {
		    // Amazon SNS returned an error
		    echo 'SNS returned the error "' . $e->getMessage() . '" and code ' . $e->getCode();
		}catch(APIException $e) {
		    // Problem with the API
		    echo 'There was an unknown problem with the API, returned code ' . $e->getCode();
		}
		
	}
}
