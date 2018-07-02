<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class MainAPI extends REST_Controller {

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
        $this->load->model('mainmodel');
        //setovanje i prikupljanje podataka
        $user = $rand = substr(md5(microtime()),rand(0,26),8);//$this->input->post('username');
        $pass = $rand = substr(md5(microtime()),rand(0,26),8);//$this->input->post('password');
        $type = $this->input->post('type');
        $client = $this->input->post('client');
        $email=$this->input->post('email');
        $tipplacanja=$this->input->post('paytype');
        $odgovor=$this->mainmodel->getinfo($client);
        date_default_timezone_set('Europe/Berlin');
        $time = strtotime(date('Y-m-d H:i:s'));
        $ind = 1;
        //
        //provjera ima li usera
        $numuser=$this->mainmodel->checkclient($client);
        if($numuser!=1)
        {
            $this->response(['status' => 'Unsuccess','message' => 'No user found'], 200);
        }
        //provjera koji je tip i setovanje trial i broja kredita
        if($type=='trial' && (date('l')!='Saturday' || date('l')!='Sunday'))
        {
            $num=0;
            $trial=1;
            $final = date("Y-m-d H:i:s", strtotime("+1 days", $time));
            $pay=0;
        }
        else if($type=='week')
        {
            $num=1;
            $trial=0;
            $final = date("Y-m-d H:i:s", strtotime("+2 days", $time));
            $pay=1.99;
        }
        else if($type=='month1')
        {
            $num=3;
            $trial=0;
            $final = date("Y-m-d H:i:s", strtotime("+1 month", $time));
            $pay=9.99;
        }
        else if($type=='month3')
        {
            $num=9;
            $trial=0;
            $final = date("Y-m-d H:i:s", strtotime("+3 month", $time));
            $pay=19.99;
        }
        else if($type=='month6')
        {
            $num=15;
            $trial=0;
            $final = date("Y-m-d H:i:s", strtotime("+6 month", $time));
            $pay=49.99;
        }
        else if($type=='month12')
        {
            $num=30;
            $trial=0;
            $final = date("Y-m-d H:i:s", strtotime("+12 month", $time));
            $pay=69.99;
        }
        else
        {
            $ind = 0;
            $this->response(['status' => 'Unsuccess','message' => 'Invalid request'], 200);
        }
        if ($ind == 1) {
                    //
        //Ukoliko ima kredita
        if($odgovor[0]['iptvcredits']-$num>=0)
         {
            //Zove APi da ga upise u main bazu
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, 'http://54.36.168.8/API.php');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            $data = array(
                'username' => $user,
                'password' => $pass,
                'date' => $final,
                'trial' => $trial
            );
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data); 
            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle);
            $result = json_decode($buffer); 
            //
            //Umanjuje stanje na racunu   
            $this->mainmodel->updateclient($client,$num);
            //
            //upisuje u stats tabelu u appy bazi
            $this->mainmodel->statsinsert($client,$num,$tipplacanja,$user,date("Y-m-d H:i:s"),$pay);
            //
            //Salje mail ako je prije imao vise od 30 kredita  a posle korekcije manje
            if($odgovor[0]['iptvcredits']-$num<30 && $odgovor[0]>=30)
            {
                $username = 'appy';
                $password = 'fisstops';
                 

                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, 'http://appy.zone/rest/AppyAPI/sendCreditsTopUpReminder');
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_POST, 1);
                $data = array(
                    'clientaddress' => $odgovor[0]['email'],
                );
                //curl_setopt($curl_handle, CURLOPT_SAFE_UPLOAD, false);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
                 
                curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
                 
                $buffer = curl_exec($curl_handle);
                curl_close($curl_handle);
                 
                $result = json_decode($buffer); 

                //print_r($result);
            }
            //
            //mail na email clienta
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, 'http://appy.zone/rest/AppyAPI/sendIPTVNewAccessMail');
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_POST, 1);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
                    'useraddress' => $email,
                    'clientaddress' => $odgovor[0]['email'],
                    'appname' => $odgovor[0]['Appname'],
                    'expiredate' => $final
                ));
                $username = 'appy';
                $password = 'fisstops';
                curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
                $buffer = curl_exec($curl_handle);
                curl_close($curl_handle);
                $result = json_decode($buffer);  
            //
            //Update-uje u bazu korisnika appy-a za toga usera DeviceIdTabelu sa podacima user pass i exp date
            $con = mysqli_connect($odgovor[0]['ipaddress'],$odgovor[0]['dbusername'],$odgovor[0]['dbpassword'],$odgovor[0]['dbname']);
            $query=sprintf('update DeviceIDTable set Username="%s",Password="%s",AccessDuration="%s" where Email="%s"',$user,$pass,$final,$email);
            mysqli_query($con,$query);
            mysqli_close($con);
            //
            //Odgovor da je sve ok
            $this->response(['status' => 'Success','message'=> "User created"], 200);
         }
        else
        {
            //Odgovor da nema kredita
            $this->response(['status' => 'Unsuccess','message' => 'Not enough credits'], 200);
        }
        }
    }

   

}
