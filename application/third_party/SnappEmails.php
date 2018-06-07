<?php
/*/////Class for sending mails
Constructor takes two arguments $info and $template_path
$info is array in the form of $info = array('key'=>pin,'email'=>Email) where pin is 4 digit pin and email is address for sending pin
$template_path is string that contains path to template for Email
*/
class SnappEmails {
	
	private $to;
	private $template;
	private $template_path;
	private $from;
	private $subject;
	private $token;
	private $username;
	private $password;

	public function __construct($to,$from,$subject,$template_path) 
	{
		$this -> to = $to;
		$this -> from = $from;
		$this -> subject = $subject;
		$this -> template_path = $template_path;
		$this -> template = file_get_contents($this->template_path);
		date_default_timezone_set("Europe/London");
	}	

	public function send_mail_confirm()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_confirm($this->token, $this->username, $this->password);
		$body = $this -> template;

		$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

		//$transport->setLocalDomain('[127.0.0.1]');
		$message = Swift_Message::newInstance();
		$message ->setSubject($this->subject);
		$message ->setFrom("postmaster@appy.zone", $this->from);
		$message ->setTo(array($this->to => 'Snapp'));
		//$message ->setTo(array($this->to => 'Name'));
		//$message ->setBcc('krivokapic.bogdan10@gmail.com');
		//$message ->setBcc('sales@aerialview.tv');		
		$mailer = Swift_Mailer::newInstance($transport);
		//$message ->setBody($body_plain_txt);
		$message ->addPart($body, 'text/html');
		$result = $mailer->send($message);
		return $result;
	}	

	public function send_mail_reset()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_reset($this->password);
		$body = $this -> template;

		$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

		//$transport->setLocalDomain('[127.0.0.1]');
		$message = Swift_Message::newInstance();
		$message ->setSubject($this->subject);
		$message ->setFrom("postmaster@appy.zone", $this->from);
		$message ->setTo(array($this->to => 'Snapp'));
		//$message ->setTo(array($this->to => 'Name'));
		//$message ->setBcc('krivokapic.bogdan10@gmail.com');
		//$message ->setBcc('sales@aerialview.tv');		
		$mailer = Swift_Mailer::newInstance($transport);
		//$message ->setBody($body_plain_txt);
		$message ->addPart($body, 'text/html');
		$result = $mailer->send($message);
		return $result;
	}


	public function format_email_confirm($token,$user,$pass){
		$this -> template = preg_replace('/{LINK}/', $token, $this -> template);
		$this -> template = preg_replace('/{USERNAME}/', $user, $this -> template);
		$this -> template = preg_replace('/{PASSWORD}/', $pass, $this -> template);
		//echo $this->weblink;
	}	

	public function format_email_reset($pass){
		$this -> template = preg_replace('/{PASS}/', $pass, $this -> template);
		//echo $this->weblink;
	}	

	public function setToken($token) {
		$this->token = $token;
	}
	public function setUsername($username) {
		$this->username = $username;
	}
	public function setPassword($password) {
		$this->password = $password;
	}
}





?>