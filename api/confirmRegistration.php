<?php

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Authorization");
	
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'lib/vendor/autoload.php';

if (isset($_GET['paymentReferenceNumber']) && $_GET['paymentReferenceNumber']!="" &&
	isset($_GET['payerid']) && $_GET['payerid']!="" &&
	isset($_GET['paidstatus']) && $_GET['paidstatus']!=""){
			// here do send email and update order
	include("../shared/Model/mwiaEventEntryFee.php");
	include("../shared/Model/mwiaEventRegister.php");
	include("Dtos/eventUserDto.php");
	include("Dtos/eventRegisterDto.php");
	include('lib/phpqrcode/qrlib.php');
	
	// check if userid is exciting our database if so return with members details else return empty
	$res = doConfirmRegistration();
	response($res, 200, 200, "Hello");
	//response(NULL, NULL, 200,"No Record Found");
}
else{
	response(NULL, NULL, 400,"Invalid Request");
}

function doConfirmRegistration(){
	try {
	
	// Get event price 
	$objEventRegistration = new mwiaEventRegister();
	$resultRegistration = $objEventRegistration->getUserWithReferenceNumber($_GET['paymentReferenceNumber']);

	$paidConfirmedReferenceNumber =  $_GET['payerid'];
	// update the  paidConfirmedReferenceNumber to db.
	//$resultRegistration->emailId = 'benherjose@icloud.com';
	$objEventRegistration->updateEventRegister_paidConfirmedReferenceNumber($_GET['paymentReferenceNumber'],$paidConfirmedReferenceNumber, $_GET['paidstatus']);
	if ($_GET['paidstatus'] == 1 && $resultRegistration->isPaidConfirmed == 0){
		createQRCode($_GET['paymentReferenceNumber'], $resultRegistration->fullName, $resultRegistration->emailId );
	}
	return $resultRegistration;

	} catch (Exception $e) {
		return $e;
	}
}

function createQRCode($codeString, $fullName, $emailId){
	// https://phpqrcode.sourceforge.net/examples/index.php?example=022
	QRcode::png($codeString, 'qrcode/'.$codeString.'.png', QR_ECLEVEL_L, 10);

	sendEmail($codeString,$fullName, $emailId);
}

function sendEmail($codeString, $fullName, $emailId){
	try {
		$mail = new PHPMailer(true);
		// Server settings // mcbw nkrf meqx biiv 
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'mwi.association@gmail.com'; // Your Gmail address
		$mail->Password = 'mcbw nkrf meqx biiv'; // Your Gmail password or App Password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->Port = 465;
	
		// Recipients
		$mail->setFrom('mwi.association@gmail.com', 'MWIA');
		$mail->addAddress($emailId, $fullName); // Add a recipient
		// $mail->addAddress('another-recipient@example.com'); // Add another recipient if needed
		// $mail->addReplyTo('info@example.com', 'Information');
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');
	
		// Attachments (optional)
		 $mail->addAttachment('qrcode/'.$codeString.'.png'); // Add attachments
		 $mail->addAttachment('grill_2024.ics', 'grill_2024'); // Optional name
		
		$mailBody = file_get_contents('confirmEmail.html');
		$mailBody = str_replace("#fullname#",$fullName,$mailBody);
		$mailBody = str_replace("#ordernumber#",$codeString,$mailBody);

		// Content
		$mail->isHTML(true);
		$mail->Subject = 'Your tickets for the event MWIA Grill party 2024';
		$mail->Body = $mailBody;
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}


}

function response($response){
	$json_responsee = json_encode($response);
	echo $json_responsee;
}
?>