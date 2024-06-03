<?php

header("Content-Type:application/json");

if (isset($_POST['eventId']) && $_POST['eventId']!="" && 
	isset($_POST['eventYear']) && $_POST['eventYear']!="" && 
	isset($_POST['emailId']) && $_POST['emailId']!="" && 
	isset($_POST['noAdult']) && $_POST['noAdult']!="" && 
	isset($_POST['noKidsBelow6']) && $_POST['noKidsBelow6']!="" &&
	isset($_POST['noKidsAbove6']) && $_POST['noKidsAbove6']!="" &&
	isset($_POST['fullName']) && $_POST['fullName']!="") {

	include("../Model/mwiaMember2024.php");
	include("../Model/Dtos/eventUserDto.php");

	
	
	// check if userid is exciting our database if so return with members details else return empty
	$res = doRegistration();
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

function doRegistration(){
	$objMember = new mwiaMembers2024();
    $resultUser = $objMember->selectUser($emailid);

	$objReturnDto = new EventUserDto();

	if ($resultUser->id === NULL){
       $objReturnDto->isMember = false;
	   $objReturnDto->paymentReference = "MWIA_".generateUniqueId()."_"."GR24";
    }else{
        $objReturnDto->isMember = true;
		$objReturnDto->fullName = $resultUser->firstName. " " .$resultUser->lastName ;
		$objReturnDto->email = $resultUser->emailId;
		$objReturnDto->nubmberOfAdult = 2;
		$objReturnDto->nubmberOfKids_Aage_below6 = 1;
		$objReturnDto->nubmberOfKids_Aage_above6 = 0;
		$objReturnDto->paymentReference = $resultUser->memberId."_".generateUniqueId()."_"."GR24";
    }
	return $objReturnDto;
}

function response($response){
	$json_responsee = json_encode($response);
	echo $json_responsee;
}
?>