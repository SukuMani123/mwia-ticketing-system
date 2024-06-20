<?php

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type, Authorization");
	

if (isset($_GET['eventId']) && $_GET['eventId']!="") {

	include("../shared/Model/mwiaEventEntryFee.php");
	include("../shared/Model/mwiaEventRegister.php");
	include("Dtos/eventUserDto.php");
	include("Dtos/eventRegisterDto.php");
	
	// check if userid is exciting our database if so return with members details else return empty
	$res = getAllRegistration();
	response($res, 200, 200, "");
	//response(NULL, NULL, 200,"No Record Found");
}
else{
	response(NULL, NULL, 400,"Invalid Request");
}

function getAllRegistration(){

	// Get event price 
	$objEventRegistration = new mwiaEventRegister();
	$resultRegistration = $objEventRegistration->getAllRegisteredWithEventId($_GET['eventId']);

    $eventAttendeesDto = new eventAttendeesDto();

    $eventAttendeesDto->eventId = $_GET['eventId'];
    $eventAttendeesDto->nubmberOfAdult = 0;
    $eventAttendeesDto->nubmberOfKids_age_below6 = 0;
    $eventAttendeesDto->nubmberOfKids_age_above6 = 0;
    $eventAttendeesDto->totalCount = 0;
    $eventAttendeesDto->totalWithOutKidsBelow6 = 0;

    foreach($resultRegistration as $value){
        $eventAttendeesDto->nubmberOfAdult += ($value->noAdult == NULL)? 0 : $value->noAdult;
        $eventAttendeesDto->nubmberOfKids_age_below6 += ($value->noKidsBelow6 == NULL)? 0 : $value->noKidsBelow6;
        $eventAttendeesDto->nubmberOfKids_age_above6 += ($value->noKidsAbove6 == NULL)? 0 : $value->noKidsAbove6;

        $eventAttendeesDto->totalCount = ($eventAttendeesDto->nubmberOfAdult + $eventAttendeesDto->nubmberOfKids_age_below6 + $eventAttendeesDto->nubmberOfKids_age_above6);
        $eventAttendeesDto->totalWithOutKidsBelow6 = ($eventAttendeesDto->nubmberOfAdult + $eventAttendeesDto->nubmberOfKids_age_above6);
    }

	return $eventAttendeesDto;
}

function response($response){
	$json_responsee = json_encode($response);
	echo $json_responsee;
}
?>