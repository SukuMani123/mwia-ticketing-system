<?php
/*
 *  CONFIGURE EVERYTHING HERE
 */
require_once("../Networking/DatabaseConnect.php");
require_once("../Model/mwiaMember2024.php");
require_once("../Model/mwiaMemberKids2024.php");

try
{

    if(count($_POST) == 0){
        header("Location: loginError.html");
    }
    $filename = $_POST['filename'];
    
    // Read the JSON file
    $jsonData = file_get_contents($filename);

    // Decode the JSON data into a PHP array
    $data = json_decode($jsonData, true);

    foreach($data as $item) { //foreach element in $arr
        $email = $item['Email address'];
        $objUser = new mwiaMembers2024();
        $resultUser = $objUser->selectUser($email);
        $resultLastUser = $objUser->getLastEntry();

        $responseArray = array('type' => 'danger', 'message' => $item['Payment Reference Number_1']);

        if ($resultUser->id === NULL){
            // Here add new member 
            $responseArray = array('type' => 'danger', 'message' => $resultUser->id );
            if($item['Membership Level'] == "Family"){
                // Here handle family add to database
                $objUser->emailId = $email;
                $objUser->memberId = $resultLastUser->id == NULL ? "MWIA20241001" : "MWIA2024".($resultLastUser->id +1) ;
                $objUser->membershipLevel = $item['Membership Level'];
                $objUser->firstName = $item['First Name__1'];
                $objUser->lastName = $item['Last Name__1'];
                $objUser->streetName = $item['Street Name__1'];

                $objUser->houseNumber = $item['House Number__1'];
                $objUser->postalCode = $item['Postal Code__1'];
                $objUser->city = $item['City/ Town__1'];
                $objUser->mobileNumber = $item['Mobile Number__1'];
                $objUser->paymentReferenceNumber = $item['Payment Reference Number_1'];
                $objUser->spouseFirstName = $item['Spouse First Name'];
                $objUser->spouseLastName = $item['Spouse Last Name'];
                $insertedId = $objUser->addMember();

                if($item['Child1'] != ""){
                    $memberKids = new mwiaMemberKids2024();
                    $memberKids->memberId = $objUser->memberId;
                    $memberKids->childFullName = $item['Child1'];
                    $memberKids->childAge = $item['Age'];
                    $memberKids->addMemberKids();
                }
                if($item['Child2'] != ""){
                    $memberKids = new mwiaMemberKids2024();
                    $memberKids->memberId = $objUser->memberId;
                    $memberKids->childFullName = $item['Child2'];
                    $memberKids->childAge = $item['Age__1'];
                    $memberKids->addMemberKids();
                }
                if($item['Child3'] != ""){
                    $memberKids = new mwiaMemberKids2024();
                    $memberKids->memberId = $objUser->memberId;
                    $memberKids->childFullName = $item['Child3'];
                    $memberKids->childAge = $item['Age__2'];
                    $memberKids->addMemberKids();
                }
                if($item['Child4'] != ""){
                    $memberKids = new mwiaMemberKids2024();
                    $memberKids->memberId = $objUser->memberId;
                    $memberKids->childFullName = $item['Child4'];
                    $memberKids->childAge = $item['Age__3'];
                    $memberKids->addMemberKids();
                }
            }else{
                // Here handle family add to database
                $objUser->emailId = $email;
                $objUser->memberId = $resultLastUser->id == NULL ? "MWIA20241001" : "MWIA2024".($resultLastUser->id +1) ;
                $objUser->membershipLevel = $item['Membership Level'];
                $objUser->firstName = $item['First Name'];
                $objUser->lastName = $item['Last Name'];
                $objUser->streetName = $item['Street Name'];

                $objUser->houseNumber = $item['House Number'];
                $objUser->postalCode = $item['Postal Code'];
                $objUser->city = $item['City/ Town'];
                $objUser->mobileNumber = $item['Mobile Number'];
                $objUser->paymentReferenceNumber = $item['Payment Reference Number'];
                $objUser->spouseFirstName = $item['Spouse First Name'];
                $objUser->spouseLastName = $item['Spouse Last Name'];
                $insertedId = $objUser->addMember();
            }    
        }
        header("Location: registationResult.html");
    }

}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $e);
    header("Location: loginError.html");
}

echo $responseArray['message'];
