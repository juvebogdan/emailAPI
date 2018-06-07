<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class SnappAPI extends REST_Controller {


    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['index_get']['limit'] = 100; // 100 requests per hour per user/key
    }	

   
   public function sendConfirmAccount_post() { 

       	$user = $this->input->post('email');
        $token =  $this->input->post('token');
        $username =  $this->input->post('username');
        $password =  $this->input->post('password');        	

        include(APPPATH.'third_party/SnappEmails.php');

        date_default_timezone_set('Europe/London');

        $from = "Team Snapp";
        $subject = "Snapp Codes Activation";
  
        $mail1 = new SnappEmails($user,$from,$subject,APPPATH.'views/ConfirmAccount.html');      
        $mail1->setToken($token);
        $mail1->setUsername($username);
        $mail1->setPassword($password);
        $mail1->send_mail_confirm();      


        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $user
        ], 200);    	
   }

   public function sendResetPass_post() { 

        $user = $this->input->post('email');   
        $password = $this->input->post('password');         

        include(APPPATH.'third_party/SnappEmails.php');

        date_default_timezone_set('Europe/London');

        $from = "Team Snapp";
        $subject = "Snapp Codes Reset Password Request";
  
        $mail1 = new SnappEmails($user,$from,$subject,APPPATH.'views/snappResetPass.html');   
        $mail1->setPassword($password);   
        $mail1->send_mail_reset();      


        $this->response([
            'status' => 'Success',
            'message' => 'Mail sent to ' . $user
        ], 200);        
   }   


}
