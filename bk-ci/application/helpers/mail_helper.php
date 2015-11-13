<?php
function send_html_mail($to_email, $subject, $content_html) {
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: admin xoso.com <chuyenht@binhhoang.com> '."\r\n".
			//'CC: hainh <hainh@binhhoang.com>, ducdm <ducdm@binhhoang.com>'."\r\n".
			'BCC: '."\r\n";
	$send = @mail($to_email,$subject,$content_html,$headers);
	return $send;
}
