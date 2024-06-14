<?php
require_once ('../shared/Networking/DatabaseConnect.php');

class mwiaMembers2024 {
   
    public $id;
    public $memberId;
    public $emailId;
    public $membershipLevel;
    public $firstName;
    public $lastName;
    public $streetName;
    public $houseNumber;
    public $postalCode;
    public $city;
    public $mobileNumber;
    public $paymentReferenceNumber;
    public $spouseFirstName;
    public $spouseLastName;

    // Constructor to easily create User objects
    public function __construct($data = null) {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->memberId = $data['memberId'] ?? null;
            $this->emailId = $data['emailId'] ?? null;
            $this->membershipLevel = $data['membershipLevel'] ?? null;
            $this->firstName = $data['firstName'] ?? null;
            $this->lastName = $data['lastName'] ?? null;
            $this->streetName = $data['streetName'] ?? null;
            $this->houseNumber = $data['houseNumber'] ?? null;
            $this->postalCode = $data['postalCode'] ?? null;
            $this->city = $data['city'] ?? null;
            $this->mobileNumber = $data['mobileNumber'] ?? null;
            $this->paymentReferenceNumber = $data['paymentReferenceNumber'] ?? null;
            $this->spouseFirstName = $data['spouseFirstName'] ?? null;
            $this->spouseLastName = $data['spouseLastName'] ?? null;
        }
    }

    public function addMember(){
        // Select query example
        $db =  new DatabaseConnect();
        $db->query("Insert into mwia_members_2024 (`memberId`,`emailId`,`membershipLevel`,`firstName`,`lastName`,`streetName`,`houseNumber`,`postalCode`,`city`,`mobileNumber`,`paymentReferenceNumber`,`spouseFirstName`,`spouseLastName`) values (:memberId, :emailId, :membershipLevel, :firstName, :lastName, :streetName, :houseNumber, :postalCode, :city,  :mobileNumber, :paymentReferenceNumber, :spouseFirstName, :spouseLastName)");
        $db->bind(':memberId', $this->memberId);
        $db->bind(':emailId', $this->emailId);
        $db->bind(':membershipLevel', $this->membershipLevel);
        $db->bind(':firstName', $this->firstName);
        $db->bind(':lastName', $this->lastName);
        $db->bind(':streetName', $this->streetName);
        $db->bind(':houseNumber', $this->houseNumber);
        $db->bind(':postalCode', $this->postalCode);
        $db->bind(':city', $this->city);
        $db->bind(':mobileNumber', $this->mobileNumber);
        $db->bind(':paymentReferenceNumber', $this->paymentReferenceNumber);
        $db->bind(':spouseFirstName', $this->spouseFirstName);
        $db->bind(':spouseLastName', $this->spouseLastName);

        $results = $db->execute();
        $lastInsertedId = $db->lastInsertId();

        $db->closeConnection();
        return $lastInsertedId;
    }

    public function selectUser($email){
        // Select query example
        $db =  new DatabaseConnect();
        $db->query("SELECT * FROM mwiaTicketingSystem.mwia_members_2024 WHERE `emailId` = :email");
        $db->bind(':email', $email);
        $results = $db->single();
        
        $users = new mwiaMembers2024($results);

        $db->closeConnection();
        return $users;        
    }

    public function getLastEntry(){
        // Select query example
        $db =  new DatabaseConnect();
        $db->query("SELECT * FROM mwia_members_2024 ORDER BY id DESC LIMIT 1;");
        $result = $db->single();
        $user = new mwiaMembers2024($result);

        $db->closeConnection();
        return $user;
    }
}