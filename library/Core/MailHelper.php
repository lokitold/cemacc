<?php
class MailHelper
{
	const SMTP_USERNAME = "eaguirre@innovationssystems.com";
	const SMTP_USERPASSWORD = "";
	const FROM_EMAIL = "eaguirre@innovationssystems.com";
	const FROM_NAME = "PeruRed Notifications";
	const HOST = '10.242.81.156';

	private static $errorMessage;

	/**
	 *
	 * @param string $fromName Name of sender
	 * @param array $to Array of array with keys email an name. i.e: array([0] = array("email"=>"example@domain.com", "name"=>"John Dillinger"), [1] = ....). NULL for empty recipients.
	 * @param array $cc Same as $to
	 * @param array $bcc Same as $to
	 * @param string $subject Subject of message
	 * @param string $body HTML body text
	 * @param array $attachments With the path to files
	 */

	public static function SendMail($fromName, $to, $cc, $bcc, $subject, $body, $attachments = null)
	{
/*
		$tr = new Zend_Mail_Transport_Smtp('10.10.3.84');
		Zend_Mail::setDefaultTransport($tr);
		$mail = new Zend_Mail();
		$mail->setFrom('informes@innovationssystems.com');
		$mail->setBodyHtml('some message - it may be html formatted text');
		$mail->addTo('eaguirre@innovationssystems.com', 'recipient');
		$mail->setSubject('subject tets');
		$mail->send();
*/
		if(is_null($fromName))
			$fromName = self::FROM_NAME;
		if(is_null($subject))
			$subject = "";

		if(is_string($to))
		{
			$to = array(array("email" => $to, "name" => ""));
		}
		elseif (is_null($to))
			$to = array();

		if(is_string($cc))
		{
			$cc = array(array("email" => $cc, "name" => ""));
		}
		elseif (is_null($cc))
			$cc = array();

		if(is_string($bcc))
		{
			$bcc = array(array("email" => $bcc, "name" => ""));
		}
		elseif (is_null($bcc))
			$bcc = array();

		$config = array('port' => 25, 'username' => self::SMTP_USERNAME, 'password' => self::SMTP_USERPASSWORD); //25
		$transp = new Zend_Mail_Transport_Smtp(self::HOST, $config);
		//Zend_Mail::setDefaultTransport($transp);

		$mail = new Zend_Mail("UTF-8");
		$mail->setFrom(self::FROM_EMAIL, $fromName);
		$mail->setBodyHtml($body);
		$mail->setSubject($subject);
		$mail->setDefaultTransport($transp);

		$count = count($to);
		for($i=0; $i < $count; $i++)
			$mail->addTo($to[$i]["email"], $to[$i]["name"]);

		$count = count($cc);
		for($i=0; $i < $count; $i++)
			$mail->addCc($cc[$i]["email"], $cc[$i]["name"]);

		$count = count($bcc);
		for($i=0; $i < $count; $i++)
			$mail->addBcc($bcc[$i]["email"], $bcc[$i]["name"]);

		$result = false;
		try {
			$mail->send();
			$result = true;
		}
		catch(Zend_Mail_Exception $ex)
		{
			$result = false;
			self::$errorMessage = $ex->getMessage();
		}

		$mail = null;
		$transp = null;

		return $result;
	}

	public static function getErrorMessage(){
		return self::$errorMessage;
	}
}
