<?php

header("Content-Type:application/json");


if (isset($_GET['userid']) && $_GET['userid']!="") {
	include("Model/mwiaMember2024.php");
	include("Model/mwiaMemberKids2024.php");
	include("Model/Dtos/eventUserDto.php");

	$userid = $_GET['userid'];
	
	// check if userid is exciting our database if so return with members details else return empty
	$res = getCheckMember($userid);
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

function getCheckMember($emailid){
	$objMember = new mwiaMembers2024();
    $resultUser = $objMember->selectUser($emailid);

	$objReturnDto = new EventUserDto();

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
		$objReturnDto->nubmberOfAdult = 2;
		$objReturnDto->nubmberOfKids_age_below6 = count($below6);
		$objReturnDto->nubmberOfKids_age_above6 = count($above6);
		$objReturnDto->paymentReference = $resultUser->memberId."_".generateUniqueId()."_"."GR24";
    }
	return $objReturnDto;
}

function response($response){
	$json_responsee = json_encode($response);
	echo $json_responsee;
}
?>