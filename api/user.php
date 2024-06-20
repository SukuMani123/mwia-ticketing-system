<?php

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if (isset($_GET['userid']) && $_GET['userid']!="") {
	include("../shared/Model/mwiaMember2024.php");
	include("../shared/Model/mwiaMemberKids2024.php");
	include("../shared/Model/mwiaEventRegister.php");
	include("Dtos/eventUserDto.php");

	$userid = $_GET['userid'];
	$eventId = $option = isset($_GET['eventid']) ? $_GET['eventid'] : "";
	// check if userid is exciting our database if so return with members details else return empty
	$res = getCheckMember($userid,$eventId);
	response($res, 200, 200, "Hello");
	//response(NULL, NULL, 200,"No Record Found");
}else if (isset($_POST['emailid']) && $_POST['emailid']!="" && 
		isset($_POST['password']) && $_POST['password']!="") {
	include("../shared/Model/mwiaMember2024.php");
	include("../shared/Model/mwiaMemberKids2024.php");
	include("../shared/Model/mwiaEventRegister.php");
	include("../shared/Model/adminUser.php");
	include("Dtos/eventUserDto.php");

	// check if userid is exciting our database if so return with members details else return empty
	$res = doLogin();
	response($res, 200, 200, "Hello");
	//response(NULL, NULL, 200,"No Record Found");
}else{
	response(NULL, NULL, 400,"Invalid Request");
}

function generateUniqueId() {
    // Get current timestamp in microseconds
    $timestamp = microtime(true);

    // Generate a unique ID based on the timestamp
    $uniqueId = uniqid($timestamp, true);

    // Optionally, hash the unique ID for added complexity
    $hashedUniqueId = hash('sha256', $uniqueId);

    return $timestamp;
}
function doLogin(){
	$email = $_POST['emailid'];
    $password = $_POST['password'];
    
    $objUser = new adminUser();
    $resultUser = $objUser->selectUser($email,$password);
	return $resultUser;
}
function getCheckMember($emailid,$eventid){
	$eventId = $eventid;
	$objMember = new mwiaMembers2024();
    $resultUser = $objMember->selectUser($emailid);

	$objReturnDto = new EventUserDto();
	// Check if this user already register
	$isRegisteredCurrentEvent = false;

	$currentYear = date("Y");
	$objEventUser = new mwiaEventRegister();
	$resultEventUser = $objEventUser->getUser($emailid,$eventid,$currentYear);
	
	if (!($resultEventUser->id === NULL)){
		$isRegisteredCurrentEvent =true;
	}

	if ($resultUser->id === NULL){
       $objReturnDto->isMember = false;
	   $objReturnDto->paymentReference = "MWIA_".generateUniqueId()."_"."GR24";
    }else{
		// get kids data 
		$objMemberKids = new mwiaMemberKids2024();
		$resultKids = $objMemberKids->getMemberKids($resultUser->memberId);

		$below6 = array_filter(
			$resultKids,
			function ($value) {
				return ($value->childAge <= 6);
			}
		);

		$above6 = array_filter(
			$resultKids,
			function ($value){
				return ($value->childAge >= 6);
			}
		);

        $objReturnDto->isMember = true;
		$objReturnDto->fullName = $resultUser->firstName. " " .$resultUser->lastName ;
		$objReturnDto->email = $resultUser->emailId;
		$objReturnDto->fullAddress = $resultUser->streetName. " - " .$resultUser->houseNumber. ", " .$resultUser->city. " - " .$resultUser->postalCode;
		$objReturnDto->nubmberOfAdult = 2;
		$objReturnDto->nubmberOfKids_age_below6 = count($below6);
		$objReturnDto->nubmberOfKids_age_above6 = count($above6);
		$objReturnDto->paymentReference = $resultUser->memberId."_".generateUniqueId()."_"."GR24";
		$objReturnDto->isRegisteredCurrentEvent = $isRegisteredCurrentEvent;
		$objReturnDto->memberId = $resultUser->memberId;
    }
	return $objReturnDto;
}

function response($response){
	$json_responsee = json_encode($response);
	echo $json_responsee;
}
?>