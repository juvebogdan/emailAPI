<?php
/*/////Class for sending mails
Constructor takes two arguments $info and $template_path
$info is array in the form of $info = array('key'=>pin,'email'=>Email) where pin is 4 digit pin and email is address for sending pin
$template_path is string that contains path to template for Email
*/
class NewVPNEmails {
	
	private $to;
	private $template;
	private $template_path;
	private $from;
	private $subject;
	private $data;

	private $user;
	private $pass;
	private $name;
	private $number;
	private $desc;

	public function __construct($to,$from,$subject,$template_path) 
	{
		$this -> to = $to;
		$this -> from = $from;
		$this -> subject = $subject;
		$this -> template_path = $template_path;
		$this -> template = file_get_contents($this->template_path);
		date_default_timezone_set("Europe/London");
	}	

	public function send_mail_signup()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_signup($this->data);
		$body = $this -> template;

		$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

		//$transport->setLocalDomain('[127.0.0.1]');
		$message = Swift_Message::newInstance();
		$message ->setSubject($this->subject);
		$message ->setFrom("postmaster@appy.zone", $this->from);
		$message ->setTo(array($this->to => 'Name'));
		//$message ->setTo(array($this->to => 'Name'));
		//$message ->setBcc('krivokapic.bogdan10@gmail.com');
		//$message ->setBcc('sales@aerialview.tv');		
		$mailer = Swift_Mailer::newInstance($transport);
		//$message ->setBody($body_plain_txt);
		$message ->addPart($body, 'text/html');
		$result = $mailer->send($message);
		return $result;
	}	

	public function send_mail_dev()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_dev($this->data);
		$body = $this -> template;

		$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

		//$transport->setLocalDomain('[127.0.0.1]');
		$message = Swift_Message::newInstance();
		$message ->setSubject($this->subject);
		$message ->setFrom("postmaster@appy.zone", $this->from);
		$message ->setTo(array($this->to => 'Name'));
		//$message ->setTo(array($this->to => 'Name'));
		//$message ->setBcc('krivokapic.bogdan10@gmail.com');
		//$message ->setBcc('sales@aerialview.tv');		
		$mailer = Swift_Mailer::newInstance($transport);
		//$message ->setBody($body_plain_txt);
		$message ->addPart($body, 'text/html');
		$result = $mailer->send($message);
		return $result;
	}				

	public function send_mail_charge()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_charge($this->to,$this->name,$this->number,$this->user,$this->pass,$this->desc);
		$body = $this -> template;

		$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

		//$transport->setLocalDomain('[127.0.0.1]');
		$message = Swift_Message::newInstance();
		$message ->setSubject($this->subject);
		$message ->setFrom("postmaster@appy.zone", $this->from);
		$message ->setTo(array($this->to => 'Name'));
		//$message ->setTo(array($this->to => 'Name'));
		//$message ->setBcc('krivokapic.bogdan10@gmail.com');
		//$message ->setBcc('sales@aerialview.tv');		
		$mailer = Swift_Mailer::newInstance($transport);
		//$message ->setBody($body_plain_txt);
		$message ->addPart($body, 'text/html');
		$result = $mailer->send($message);
		return $result;
	}

	public function format_email_signup($data){
	
		$this -> template = preg_replace('/{EMAIL}/', $data->email, $this -> template);
		$this -> template = preg_replace('/{LINK}/', $data->link, $this -> template);
		//echo $this->weblink;
	}

	public function format_email_dev($data) {
		$this -> template = preg_replace('/{EMAIL}/', $data->email, $this -> template);
		$this -> template = preg_replace('/{CODE1}/', $data->code1, $this -> template);
		$this -> template = preg_replace('/{CODE2}/', $data->code2, $this -> template);		
	}

	public function format_email_charge($email,$name,$number,$user,$pass,$desc) {
		//$this -> template = preg_replace('/{USEREMAIL}/', $email, $this -> template);
		$this -> template = preg_replace('/{NAME}/', $name, $this -> template);
		$this -> template = preg_replace('/{NUMBER}/', $number, $this -> template);
		$this -> template = preg_replace('/{USERNAME}/', $user, $this -> template);
		$this -> template = preg_replace('/{PASSWORD}/', $pass, $this -> template);
		$this -> template = preg_replace('/{DESCRIPTION}/', $desc, $this -> template);		
	}		

	public function setData($data) {
		$this->data = $data;
	}

	public function setName($name) {
		$this->name = $name;
	}
	public function setNumber($number) {
		$this->number = $number;
	}
	public function setUser($user) {
		$this->user = $user;
	}
	public function setPass($pass) {
		$this->pass = $pass;
	}
	public function setDesc($desc) {
		$this->desc = $desc;
	}	
}





?>