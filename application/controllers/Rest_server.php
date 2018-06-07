<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rest_server extends CI_Controller {

	private $masterkodiLocation = '/var/www/appy.zone/public_html/appy/V5/master/kodi/builds.txt';

    public function index()
    {
        $this->load->helper('url');

        $this->load->helper('file');

        if (file_exists($this->masterkodiLocation)) {
        	$builds = file($this->masterkodiLocation);
			for($i=0; $i<count($builds); $i++) {
				$builds[$i] = trim($builds[$i]);
			}       	
        }

       	array_push($builds, 'image URL;title;Zip file URL(shortlink);size in bytes;genre');

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

        echo "ok";
    }
}
