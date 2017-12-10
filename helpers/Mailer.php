<?php

class Mailer {

	private $fromMail = '';
	private $fromName = '';
	private $replyTo = '';

	public function __construct(){
		$this->fromMail = 'test@meesho.com';
		$this->fromName = 'Meesho';
		$this->replyTo = '';
	}

	public function plain_mail($mail_to, $subject, $message) {
		
	    $header = "From: ".$this->fromName." <".$this->fromMail.">\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Reply-To: ".$this->replyTo."\r\n";
        $header .= "Content-type: text/html\r\n";
                
        if(mail($mail_to, $subject, $message, $header)) {
           return true;
        }
        return false;
	}

	public function mail_attachment($mail_to, $subject, $message, $file_path) {
	
	    $file_size = filesize($file_path);
	    $file_name = current( explode( '.', end( explode('/', $file_path ) ) ) );
	    $handle = fopen($file_path, "r");
	    $content = fread($handle, $file_size);
	    fclose($handle);
	    $content = chunk_split(base64_encode($content));
	    
	    $uid = md5(uniqid(time()));
	    
	    $header = "From: ".$this->fromName." <".$this->fromMail.">\r\n";
	    $header .= "Reply-To: ".$this->replyTo."\r\n";
	    $header .= "MIME-Version: 1.0\r\n";
	    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
	    $header .= "This is a multi-part message in MIME format.\r\n";
	    $header .= "--".$uid."\r\n";
	    $header .= "Content-Type: application/octet-stream; name=\"".$file_name."\"\r\n";
	    $header .= "Content-Transfer-Encoding: base64\r\n";
	    $header .= "Content-Disposition: attachment; filename=\"".$file_name."\"\r\n\r\n";
	    $header .= $content."\r\n\r\n";
	    $header .= "--".$uid."--";
	    
	    if (mail($mail_to, $subject, $message, $header)) {
	        return true;
	    }
	    return false;
	}
}

?>