<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class NewVPNAPI extends REST_Controller {


    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['index_get']['limit'] = 100; // 100 requests per hour per user/key
    }	

   
   public function sendSignup_post() { 

       	$data = json_decode($this->input->post('data'));         	

        include(APPPATH.'third_party/NewVPNEmails.php');

        date_default_timezone_set('Europe/London');

        $from = "Welcome to VPN";
        $subject = "VPN";
  
        $mail1 = new NewVPNEmails($data->email,$from,$subject,APPPATH.'views/NewVPNSignup.html');      
        $mail1->setData($data);
        $mail1->send_mail_signup();      


        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $data->email
        ], 200);    	
   }

   public function sendDevEmail_post() {
        $data = json_decode($this->input->post('data'));            

        include(APPPATH.'third_party/NewVPNEmails.php');

        date_default_timezone_set('Europe/London');

        $from = "Welcome to VPN";
        $subject = "VPN";
  
        $mail1 = new NewVPNEmails($data->email,$from,$subject,APPPATH.'views/NewVPNdev.html');      
        $mail1->setData($data);
        $mail1->send_mail_dev();      


        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $data->email
        ], 200);    
   }


   public function sendChargeMail_post() {
        $from = $this->input->post('useremail');
        $email = $this->input->post('customeremail');
        $name = $this->input->post('name');
        $desc = $this->input->post('description');
        $number = $this->input->post('phonenumber');
        $user = $this->input->post('username');
        $pass = $this->input->post('password'); 

        include(APPPATH.'third_party/NewVPNEmails.php');

        if ($email=='' || $name=='' || $number=='' || $user=='' || $pass=='' || $from=='' || $desc=='') {
            $this->response([
                'status' => 'Failed',
                'message' => 'Please send all data'
            ], 400);             
        }  

        //$from = 'IPTVsales@viewmore.com';
        $subject = 'New IPTV customer';        

        $mail1 = new NewVPNEmails($email,$from,$subject,APPPATH.'views/chargeMail.html');    
        $mail1->setName($name);
        $mail1->setNumber($number);
        $mail1->setUser($user);
        $mail1->setPass($pass);
        $mail1->setDesc($desc);  
        $body = $mail1->send_mail_charge();      


        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $email
        ], 200);   

   }


}
