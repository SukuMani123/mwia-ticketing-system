<?php

header("Content-Type:application/json");

if (isset($_POST['eventId']) && $_POST['eventId']!="" && 
	isset($_POST['emailId']) && $_POST['emailId']!="" &&
	isset($_POST['fullName']) && $_POST['fullName']!="" &&
	isset($_POST['address']) && $_POST['address']!="" && 
	isset($_POST['mobileNumber']) && $_POST['mobileNumber']!="" && 
	isset($_POST['paymentReferenceNumber']) && $_POST['paymentReferenceNumber']!="" &&
	isset($_POST['noAdult']) && $_POST['noAdult']!="" && 
	isset($_POST['noKidsBelow6']) && $_POST['noKidsBelow6']!="" &&
	isset($_POST['noKidsAbove6']) && $_POST['noKidsAbove6']!="" ) {

	include("../shared/Model/mwiaEventEntryFee.php");
	include("../shared/Model/mwiaEventRegister.php");
	include("Dtos/eventUserDto.php");
	include("Dtos/eventRegisterDto.php");

	
	// check if userid is exciting our database if so return with members details else return empty
	$res = doRegistration();
	response($res, 200, 200, "Hello");
	//response(NULL, NULL, 200,"No Record Found");
}else{
	response(NULL, NULL, 400,"Invalid Request");
}

function doRegistration(){

	$currentYear = date("Y");
	// Get event price 
	$objEventEntryFee = new mwiaEventEntryFee();
	$resultUser = $objEventEntryFee->getEventPrice($_POST['eventId'],$currentYear);

	$isMember = (isset($_POST['memberId']) && $_POST['memberId']!="") ? true : false;

	$noAdult = (int)$_POST['noAdult'];
	$noKidsAbove6 = (int)$_POST['noKidsAbove6'];
	$noKidsBelow6 = (int)$_POST['noKidsBelow6'];

	$objEventRegister = new mwiaEventRegister();
	$objEventRegister->eventId  = $_POST['eventId'];
	$objEventRegister->eventYear  = $currentYear;
	$objEventRegister->memberId  = (isset($_POST['memberId']) && $_POST['memberId']!="") ? $_POST['memberId'] : null ;
	$objEventRegister->emailId  = $_POST['emailId'];
	$objEventRegister->fullName  = $_POST['fullName'];
	$objEventRegister->address  = $_POST['address'];

	$objEventRegister->mobileNumber  = $_POST['mobileNumber'];
	$objEventRegister->paymentReferenceNumber  = $_POST['paymentReferenceNumber'];
	$objEventRegister->noAdult  = $_POST['noAdult'];
	$objEventRegister->noKidsBelow6  = $_POST['noKidsBelow6'];
	$objEventRegister->noKidsAbove6  = $_POST['noKidsAbove6'];

	$totalAmount = ($noAdult * $resultUser->nonMemberEntryFee);
	
	if ( $isMember ) {
		$totalAmount = ($noAdult * $resultUser->memberEntryFee);
	}
	$totalAmount = $totalAmount + ($noKidsAbove6 * $resultUser->kidsAbove6EntryFee);
	$totalAmount =  $totalAmount + ($noKidsBelow6 * $resultUser->kidsBelow6EntryFee);

	$objEventRegister->totalAmount  = $totalAmount;
	
	$objEventRegister->isPaidConfirmed  = false;
	$objEventRegister->paidConfirmedReferenceNumber  = "";

	$objEventRegister->tcAccept  = true;
	$objEventRegister->addEventRegister();


	$objEventRegisterDto = new eventRegisterDto();
	$objEventRegisterDto->emailId = $_POST['emailId'];
	$objEventRegisterDto->nubmberOfAdult = $_POST['noAdult'];
	$objEventRegisterDto->nubmberOfKids_age_below6 = $_POST['noKidsBelow6'];
	$objEventRegisterDto->nubmberOfKids_age_above6 = $_POST['noKidsAbove6'];
	$objEventRegisterDto->totalAmount = $totalAmount;
	$objEventRegisterDto->paymentReference = $_POST['paymentReferenceNumber'];

	return $objEventRegisterDto;

}

function response($response){
	$json_responsee = json_encode($response);
	echo $json_responsee;
}
?>