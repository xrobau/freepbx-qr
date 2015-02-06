<?php


$bootstrap_settings['freepbx_auth']=false;
include '/etc/freepbx.conf';
error_reporting(E_ALL);
set_error_handler(null);
set_exception_handler(null);

// Change this.
$asteriskip = "192.168.15.5";

if (isset($_REQUEST['ext'])) {
	$ext = $_REQUEST['ext'];
} else {
	$ext = 300;
}

$user = core_users_get($ext);
$dev = core_devices_get($ext);

$xml =  "<?xml version='1.0' encoding='utf-8'?><AccountConfig version='1'><Account><RegisterServer>$asteriskip</RegisterServer>";
$xml .= "<OutboundServer></OutboundServer><UserID>$ext</UserID><AuthID>$ext</AuthID><AuthPass>".$dev['secret']."</AuthPass>";
$xml .= "<AccountName>$ext</AccountName><DisplayName>".$user['description']."</DisplayName>";
$xml .= '<Dialplan>{x+|*x+|*++}</Dialplan><RandomPort>0</RandomPort><SecOutboundServer></SecOutboundServer><Voicemail>*97</Voicemail></Account></AccountConfig>';

header("Content-Type: image/png");

include 'phpqrcode/phpqrcode.php';

QRcode::png($xml);

