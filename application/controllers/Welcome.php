<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	// public function index()
	// {
	// 	$this->load->helper('url');

	// 	$this->load->view('welcome_message');
	// }

	public function curls() {
	    // $username = '';
	    // $password = '';
	    // //exit('slo');
	    // // Alternative JSON version
	    // // $url = 'http://twitter.com/statuses/update.json';
	    // // Set up and execute the curl process
	    // $curl_handle = curl_init();
	    // curl_setopt($curl_handle, CURLOPT_URL, 'http://appy.zone/rest/AppyAPI/sendIPTVaccessReminderMail');
	    // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	    // curl_setopt($curl_handle, CURLOPT_POST, 1);
	    // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
	    // 	'useraddress' => 'krivokapic.bogdan10@gmail.com',
	    // 	'clientaddress' => 'caocao',
	    // 	'appname' => 'Yo app'
	    // ));
	     
	    // // Optional, delete this line if your API is open
	    // curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
	     
	    // $buffer = curl_exec($curl_handle);
	    // curl_close($curl_handle);
	     
	    // $result = json_decode($buffer);	

	    // print_r($result);	
	}

	// public function curledit() {
	//     $username = '';
	//     $password = '';
	     
	//     // Alternative JSON version
	//     // $url = 'http://twitter.com/statuses/update.json';
	//     // Set up and execute the curl process
	//     $curl_handle = curl_init();
	//     curl_setopt($curl_handle, CURLOPT_URL, 'http://appy.zone/rest/AppyAPI/editBuild');
	//     curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	//     curl_setopt($curl_handle, CURLOPT_POST, 1);
	//     curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
	//         'completebuild' => "",
	//         'newbuild' => ""
	//     ));
	     
	//     // Optional, delete this line if your API is open
	//     curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
	     
	//     $buffer = curl_exec($curl_handle);
	//     curl_close($curl_handle);
	     
	//     $result = json_decode($buffer);	

	//     print_r($result);	
	// }

	public function curlmail() {
	    $username = '';
	    $password = '';
	     

	    $curl_handle = curl_init();
	    curl_setopt($curl_handle, CURLOPT_URL, 'http://appy.zone/rest/NewVPNAPI/sendDevEmail');
	    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl_handle, CURLOPT_POST, 1);
	    $data = array('data' => json_encode(array(
	    	'email' => 'krivokapic.bogdan10@gmail.com',
	    	'code1' => "http://165.227.38.2/vpnapi/login/login?u=prcprc",
	    	'code2' => "http://165.227.38.2/vpnapi/login/login?u=prcprc2"
	    )));
	    //curl_setopt($curl_handle, CURLOPT_SAFE_UPLOAD, false);
	    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
	     
	    curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
	     
	    $buffer = curl_exec($curl_handle);
	    curl_close($curl_handle);
	     
	    $result = json_decode($buffer);	

	    print_r($result);	
	}

	public function curl() {
	    // $username = '';
	    // $password = '';
	     

	    // $curl_handle = curl_init();
	    // curl_setopt($curl_handle, CURLOPT_URL, 'http://appy.zone/rest/AppyAPI/sendLowSaldoNewVPN');
	    // curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	    // curl_setopt($curl_handle, CURLOPT_POST, 1);
	    // $data = array(
	    // 	'email' => 'Virtualstreamz@gmail.com',
	    // 	'type' => 'new'
	    // );
	    // //curl_setopt($curl_handle, CURLOPT_SAFE_UPLOAD, false);
	    // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
	     
	    // curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
	     
	    // $buffer = curl_exec($curl_handle);
	    // curl_close($curl_handle);
	     
	    // $result = json_decode($buffer);	

	    // print_r($result);
	}	
}
