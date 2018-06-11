<?php
/*/////Class for sending mails
Constructor takes two arguments $info and $template_path
$info is array in the form of $info = array('key'=>pin,'email'=>Email) where pin is 4 digit pin and email is address for sending pin
$template_path is string that contains path to template for Email
*/
class Mailer {
	
	private $to;
	private $template;
	private $template_path;
	private $from;
	private $subject;
	private $weblink;
	private $pin;
	private $appname;
	private $useremail;
	private $body;
	private $kodihubkey;
	private $pass;
	private $keys;
	private $expirydate;

	public function __construct($to,$from,$subject,$template_path) 
	{
		$this -> to = $to;
		$this -> from = $from;
		$this -> subject = $subject;
		$this -> template_path = $template_path;
		$this -> template = file_get_contents($this->template_path);
		date_default_timezone_set("Europe/London");
	}
	public function send_mail_pin()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_pin($this->pin,$this->appname);
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

	public function send_mail_trial()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_trial($this->useremail);
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

	public function send_mail_kodihub_confirm()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_kodihubconfirm($this->kodihubkey);
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

	public function send_mail_other()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 

		$body = $this -> body;

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
		//$message ->setBody($body);
		$message ->addPart($body, 'text/html');
		$result = $mailer->send($message);
		return $result;
	}

	public function send_mail_kodihub_reset()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_kodihubreset($this->pass);
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

	public function send_mail_newvpnsaldo() {
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
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

	public function send_mail_oldvpnsaldo() {
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
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

	public function send_mail_kodihub_complaint() {
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_kodihubcomplaint($this->keys);
		$body = $this -> template;

		$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

		//$transport->setLocalDomain('[127.0.0.1]');
		$message = Swift_Message::newInstance();
		$message ->setSubject($this->subject);
		$message ->setFrom("postmaster@appy.zone", $this->from);
		$message ->setTo(array($this->to => 'Name'));
		//$message ->setTo(array($this->to => 'Name'));
		$message ->setBcc('krivokapic.bogdan10@gmail.com');
		if (isset($_FILES['file'])) {
			$message->attach(Swift_Attachment::fromPath($_FILES['file']['tmp_name'])->setFilename('Doc'));
		}	
		$mailer = Swift_Mailer::newInstance($transport);
		//$message ->setBody($body_plain_txt);
		$message ->addPart($body, 'text/html');
		$result = $mailer->send($message);
		return $result;		
	}

	public function send_mail_iptvaccess()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_iptvaccess($this->appname, $this->expirydate);
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

	public function send_mail_iptvaccessreminder()
	{
		include_once '/var/www/html/mailer/swiftmailer/lib/swift_required.php'; 
		$this -> format_email_iptvaccessreminder($this->appname);
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


	public function format_email_pin($pin,$appname){
	
		$this -> template = preg_replace('/{PIN}/', $pin, $this -> template);
		$this -> template = preg_replace('/{APPNAME}/', $appname, $this -> template);
		//echo $this->weblink;
	}

	public function format_email_trial($email){
	
		$this -> template = preg_replace('/{USEREMAIL}/', $email, $this -> template);
	}

	public function format_email_kodihubconfirm($key){
	
		$this -> template = preg_replace('/{KEY}/', $key, $this -> template);
	}	

	public function format_email_kodihubreset($pass){
	
		$this -> template = preg_replace('/{PASS}/', $pass, $this -> template);
	}

	public function format_email_kodihubcomplaint($data) {
		$this -> template = preg_replace('/{KEY1}/', $data->key1, $this -> template);
		$this -> template = preg_replace('/{KEY2}/', $data->key2, $this -> template);
		$this -> template = preg_replace('/{KEY3}/', $data->key3, $this -> template);
		$this -> template = preg_replace('/{KEY4}/', $data->key4, $this -> template);
		$this -> template = preg_replace('/{KEY5}/', $data->key5, $this -> template);
		$this -> template = preg_replace('/{KEY6}/', $data->key6, $this -> template);
		$this -> template = preg_replace('/{KEY7}/', $data->key7, $this -> template);
		$this -> template = preg_replace('/{KEY8}/', $data->key8, $this -> template);
		$this -> template = preg_replace('/{KEY9}/', $data->key9, $this -> template);
		$this -> template = preg_replace('/{KEY10}/', $data->key10, $this -> template);
		$this -> template = preg_replace('/{KEY11}/', $data->key11, $this -> template);
		$this -> template = preg_replace('/{KEY12}/', $data->key12, $this -> template);
		$this -> template = preg_replace('/{KEY13}/', $data->key13, $this -> template);
		$this -> template = preg_replace('/{KEY14}/', $data->key14, $this -> template);		
	}

	public function format_email_iptvaccess($appname, $expirydate){
	
		$this -> template = preg_replace('/{APPNAME}/', $appname, $this -> template);
		$this -> template = preg_replace('/{EXPIRYDATE}/', $expirydate, $this -> template);
	}

	public function format_email_iptvaccessreminder($appname){
	
		$this -> template = preg_replace('/{APPNAME}/', $appname, $this -> template);
	}					

	public function setPin($pin) {
		$this->pin = $pin;
	}

	public function setAppname($appname) {
		$this->appname = $appname;
	}	

	public function setUserEmail($email) {
		$this->useremail = $email;
	}

	public function setBody($body) {
		$this->body = $body;
	}

	public function setKodihubKey($key) {
		$this->kodihubkey = $key;
	}				
	
	public function setKodihubPass($pass) {
		$this->pass = $pass;
	}	

	public function setData($data) {
		$this->keys = $data;
	}

	public function setExpiryDate($expdate) {
		$this->expirydate = $expdate;
	}	
}





?>