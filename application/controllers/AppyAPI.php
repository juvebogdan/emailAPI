<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class AppyAPI extends REST_Controller {

	private $masterkodiLocation = '/var/www/appy.zone/public_html/appy/V5/master/kodi/builds.txt';


    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['index_get']['limit'] = 100; // 100 requests per hour per user/key
    }	

    public function index_post()
    {


        $this->load->helper('url');

        $this->load->helper('file');


        if (file_exists($this->masterkodiLocation)) {
        	$builds = file($this->masterkodiLocation);
			for($i=0; $i<count($builds); $i++) {
				$builds[$i] = trim($builds[$i]);
			}       	
        }

       	array_push($builds, $this->input->post('build'));

		$result = array();
		for($i=0;$i<count($builds); $i++) {
			if(trim($builds[$i])!='') {
				$result[] = trim($builds[$i]);
			}
		}

		if (file_exists($this->masterkodiLocation)) {
			unlink($this->masterkodiLocation);
		}		


		for ($i=0; $i<count($result); $i++) {
			write_file($this->masterkodiLocation, $result[$i] . "\r\n", 'a+');
		}

        $this->response([
            'status' => 'success',
            'message' => 'Build added'
        ], 200);
    }

    public function editBuild_post() {

        $this->load->helper('url');

        $this->load->helper('file');


        if (file_exists($this->masterkodiLocation)) {
            $builds = file($this->masterkodiLocation);
            for($i=0; $i<count($builds); $i++) {
                $builds[$i] = trim($builds[$i]);
            }           
        }

        $index = array_search((string)$this->input->post('completebuild'),$builds);

        $builds[$index] = $this->input->post('newbuild');

        $result = array();
        for($i=0;$i<count($builds); $i++) {
            if(trim($builds[$i])!='') {
                $result[] = trim($builds[$i]);
            }
        }
        if (file_exists($this->masterkodiLocation)) {
            unlink($this->masterkodiLocation);
        }       


        for ($i=0; $i<count($result); $i++) {
            write_file($this->masterkodiLocation, $result[$i] . "\r\n", 'a+');
        }

        $this->response([
            'status' => 'success',
            'message' => 'Build edited'
        ], 200);                

    }

    public function removeBuild_post() {

        $this->load->helper('url');

        $this->load->helper('file');


        if (file_exists($this->masterkodiLocation)) {
            $builds = file($this->masterkodiLocation);
            for($i=0; $i<count($builds); $i++) {
                $builds[$i] = trim($builds[$i]);
            }           
        }

        $index = array_search((string)$this->input->post('completebuild'),$builds);

        if(!$index) {
	        $this->response([
	            'status' => 'success',
	            'message' => 'Build not found'
	        ], 200); 
	        exit();
        }

        $result = array();
        for($i=0;$i<count($builds); $i++) {
            if(trim($builds[$i])!='' && $i!=$index) {
                $result[] = trim($builds[$i]);
            }
        }
        if (file_exists($this->masterkodiLocation)) {
            unlink($this->masterkodiLocation);
        }       


        for ($i=0; $i<count($result); $i++) {
            write_file($this->masterkodiLocation, $result[$i] . "\r\n", 'a+');
        }

        $this->response([
            'status' => 'success',
            'message' => 'Build edited'
        ], 200);                

    }    

    public function sendPinEmail_post() {

        $to = $this->input->post('email');
        $pin = $this->input->post('pin');
        $appname = $this->input->post('appname');

        if ($to=='' || $pin=='' || $appname=='') {
            $this->response([
                'status' => 'Fail',
                'message' => 'please provide email and pin'
            ], 400); 
        }

        include(APPPATH.'third_party/Mailer.php');

        date_default_timezone_set('Europe/London');

        $from = $appname . " Team";
        $subject = "Welcome to " . $appname;

        $mail1 = new Mailer($to,$from,$subject,APPPATH.'views/pinemail.html');
        $mail1->setPin($pin);
        $mail1->setAppname($appname);
        $mail1->send_mail_pin();      


        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $to
        ], 200);         
    }

    public function sendIPTVtrial_post() {

        $to = $this->input->post('customeremail');
        $useremail = $this->input->post('useremail');
        $appname = $this->input->post('appname');

        if ($to=='' || $useremail=='' || $appname=='') {
            $this->response([
                'status' => 'Fail',
                'message' => 'please provide all details'
            ], 400); 
        }

        include(APPPATH.'third_party/Mailer.php');

        date_default_timezone_set('Europe/London');

        $from = $appname . " Team";
        $subject = "Free IPTV trial request";

        $mail1 = new Mailer($to,$from,$subject,APPPATH.'views/iptvtrial.html');
        $mail1->setUserEmail($useremail);
        $mail1->send_mail_trial();      


        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $to
        ], 200);         
    }

    public function sendCREDENTIALS_post() {

        $to = $this->input->post('EmailAddress');
        $name = $this->input->post('Name');
        $number = $this->input->post('Phone');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($to=='' || $name=='' || $number=='' || $username=='' || $password=='') {
            $this->response([
                'status' => 'Fail',
                'message' => 'please provide all details'
            ], 400); 
        }

        include(APPPATH.'third_party/Mailer.php');

        date_default_timezone_set('Europe/London');

        $from = "Team";
        $subject = "New IPTV customer";

        $mail1 = new Mailer($to,$from,$subject,APPPATH.'views/credentialtrial.html');
        $mail1->setCredentialEmail($useremail);
        $mail1->send_mail_trial();      


        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $to
        ], 200);         
    }


    public function sendOther_post() {

        $to = $this->input->post('email');
        $subjectOfMail = $this->input->post('subject');
        $body = $this->input->post('body');
        $appname = $this->input->post('appname');

        if ($to=='' || $subjectOfMail=='' || $appname=='' || $body=='') {
            $this->response([
                'status' => 'Fail',
                'message' => 'please provide all details'
            ], 400); 
        }

        include(APPPATH.'third_party/Mailer.php');

        date_default_timezone_set('Europe/London');

        $from = $appname . " Team";
        $subject = $subjectOfMail;

        $mail1 = new Mailer($to,$from,$subject,APPPATH.'views/iptvtrial.html');
        $mail1->setBody($body);
        $mail1->send_mail_other();      


        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $to
        ], 200);         
    }  

    public function sendLodihubConfirm_post() {

        $to = $this->input->post('email');
        $subjectOfMail = $this->input->post('subject');
        $key = $this->input->post('key');

        if ($to=='' || $subjectOfMail=='' || $key=='') {
            $this->response([
                'status' => 'Fail',
                'message' => 'please provide all details'
            ], 400); 
        }

        include(APPPATH.'third_party/Mailer.php');

        date_default_timezone_set('Europe/London');

        $from = "Kodihub";
        $subject = $subjectOfMail;

        $mail1 = new Mailer($to,$from,$subject,APPPATH.'views/emailApp.html');
        $mail1->setKodihubKey($key);
        $mail1->send_mail_kodihub_confirm();      


        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $to
        ], 200);         
    }          

    public function sendKodihubReset_post() {
        $to = $this->input->post('email');
        $subjectOfMail = $this->input->post('subject');
        $pass = $this->input->post('pass');

        if ($to=='' || $subjectOfMail=='' || $pass=='') {
            $this->response([
                'status' => 'Fail',
                'message' => 'please provide all details'
            ], 400); 
        }

        include(APPPATH.'third_party/Mailer.php');

        date_default_timezone_set('Europe/London');

        $from = "Kodihub";
        $subject = $subjectOfMail;

        $mail1 = new Mailer($to,$from,$subject,APPPATH.'views/resetPass.html');
        $mail1->setKodihubPass($pass);
        $mail1->send_mail_kodihub_reset();      


        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $to
        ], 200);     	
    }

    public function sendLowSaldoNewVPN_post() {

        $to = $this->input->post('email');
        $type = $this->input->post('type');

        if ($to=='' || $type=='') {
            $this->response([
                'status' => 'Fail',
                'message' => 'please provide all details'
            ], 400); 
        }      

        include(APPPATH.'third_party/Mailer.php');

        date_default_timezone_set('Europe/London');

        $from = "VPN credits";
        $subject = "You're almost out of VPN credits";
        if ($type=='new') {
            $mail1 = new Mailer($to,$from,$subject,APPPATH.'views/NewVPNSaldo.html');
            $mail1->send_mail_newvpnsaldo();  
        }    
        else {
            $mail1 = new Mailer($to,$from,$subject,APPPATH.'views/OldVPNSaldo.html');
            $mail1->send_mail_oldvpnsaldo();              
        }

        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $to
        ], 200);         
    }

    public function sendKodihubComplaint_post() {

    	$data = json_decode($this->input->post('keys'));                

        include(APPPATH.'third_party/Mailer.php');

        date_default_timezone_set('Europe/London');

        $subject = "Complaint";
        $to = 'sales@aerialview.tv';
        $from = "Kodihub"; 
        $mail1 = new Mailer($to,$from,$subject,APPPATH.'views/Complaint.html');
        $mail1->setData($data->keys);       
        $mail1->send_mail_kodihub_complaint();  


        $this->response([
            'status' => 'Success',
            'message' => 'Sent mail to ' . $to
        ], 200); 		    	
    } 


    public function sendIPTVaccessMail_post() {

        $useraddress = $this->input->post('useraddress');
        $clientaddress = $this->input->post('clientaddress');
        $expiredate = $this->input->post('expiredate'); 
        $appname = $this->input->post('appname');

        include(APPPATH.'third_party/Mailer.php');

        date_default_timezone_set('Europe/London');  
        
        $subject = "Premium Access Granted";
        $to = $useraddress;
        $from = $clientaddress; 
        $mail1 = new Mailer($to,$from,$subject,APPPATH.'views/iptvaccess.html');
        $mail1->setExpiryDate($expiredate);
        $mail1->setAppname($appname);       
        $mail1->send_mail_iptvaccess(); 

        $this->response([
            'status' => 'Success',
            'message' => 'Sent mail to ' . $useraddress
        ], 200);                 
    }

    public function sendIPTVaccessReminderMail_post() {

        $useraddress = $this->input->post('useraddress');
        $clientaddress = $this->input->post('clientaddress');
        $appname = $this->input->post('appname');

        include(APPPATH.'third_party/Mailer.php');

        date_default_timezone_set('Europe/London');  
        
        $subject = "Your premium access is expiring soon";
        $to = $useraddress;
        $from = $clientaddress; 
        $mail1 = new Mailer($to,$from,$subject,APPPATH.'views/iptvaccess_reminder.html');
        $mail1->setAppname($appname);       
        $mail1->send_mail_iptvaccessreminder(); 

        $this->response([
            'status' => 'Success',
            'message' => 'Sent mail to ' . $useraddress
        ], 200);                 
    }

}
