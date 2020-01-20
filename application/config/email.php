<?php
$config['protocol'] = 'smtp';
// $config['mailpath'] = '/usr/sbin/sendmail';
$config['charset'] = 'iso-8859-1';
$config['wordwrap'] = TRUE;
$config['smtp_host']='ssl://smtp.googlemail.com';
$config['smtp_user']='acropolisgroups@gmail.com';
$config['smtp_pass']='AITR0827';
$config['smtp_port']=465;
$config['mailtype']='html';

// smtp_timeout	5	None	SMTP Timeout (in seconds).
// smtp_keepalive	FALSE	TRUE or FALSE (boolean)	Enable persistent SMTP connections.
// smtp_crypto	No Default	tls or ssl	SMTP Encryption
// wrapchars	76	 	Character count to wrap at.
// mailtype	text	text or html	Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don’t have any relative links or relative image paths otherwise they will not work.
// validate	FALSE	TRUE or FALSE (boolean)	Whether to validate the email address.
// priority	3	1, 2, 3, 4, 5	Email Priority. 1 = highest. 5 = lowest. 3 = normal.
// crlf	\n	“\r\n” or “\n” or “\r”	Newline character. (Use “\r\n” to comply with RFC 822).
?>
