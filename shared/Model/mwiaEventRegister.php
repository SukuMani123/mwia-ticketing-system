<?php
require_once ('../shared/Networking/DatabaseConnect.php');

class mwiaEventRegister {
   
    public $id;
    public $eventId;
    public $eventYear;
    public $memberId;
    public $emailId;
    public $fullName;
    public $address;
    public $mobileNumber;
    public $paymentReferenceNumber;
    public $noAdult;
    public $noKidsBelow6;
    public $noKidsAbove6;
    public $totalAmount;
    public $registeredDate;
    public $isPaidConfirmed;
    public $paidConfirmedReferenceNumber;
    public $tcAccept;

    // Constructor to easily create User objects
    public function __construct($data = null) {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->eventId = $data['eventId'] ?? null;
            $this->eventYear = $data['eventYear'] ?? null;
            $this->memberId = $data['memberId'] ?? null;
            $this->emailId = $data['emailId'] ?? null;
            $this->fullName = $data['fullName'] ?? null;
            $this->address = $data['address'] ?? null;
            $this->mobileNumber = $data['mobileNumber'] ?? null;
            $this->paymentReferenceNumber = $data['paymentReferenceNumber'] ?? null;
            $this->noAdult = $data['noAdult'] ?? null;
            $this->noKidsBelow6 = $data['noKidsBelow6'] ?? null;
            $this->noKidsAbove6 = $data['noKidsAbove6'] ?? null;
            $this->totalAmount = $data['totalAmount'] ?? null;
            $this->registeredDate = $data['registeredDate'] ?? null;
            $this->isPaidConfirmed = $data['isPaidConfirmed'] ?? null;
            $this->paidConfirmedReferenceNumber = $data['paidConfirmedReferenceNumber'] ?? null;
            $this->tcAccept = $data['tcAccept'] ?? null;

        }
    }

    public function addEventRegister(){
        // Select query example
        $db =  new DatabaseConnect();
        $db->query("Insert into mwia_event_register (`eventId`,`eventYear`,`memberId`,`emailId`,`fullName`,`address`,`mobileNumber`,`paymentReferenceNumber`,`noAdult`,`noKidsBelow6`,`noKidsAbove6`,`totalAmount`,`isPaidConfirmed`,`paidConfirmedReferenceNumber`, `tcAccept`)  values (:eventId, :eventYear, :memberId, :emailId, :fullName, :address, :mobileNumber, :paymentReferenceNumber, :noAdult, :noKidsBelow6,  :noKidsAbove6, :totalAmount, :isPaidConfirmed,:paidConfirmedReferenceNumber,:tcAccept)");
        $db->bind(':eventId', $this->eventId);
        $db->bind(':eventYear', $this->eventYear);
        $db->bind(':memberId', $this->memberId);
        $db->bind(':emailId', $this->emailId);
        $db->bind(':fullName', $this->fullName);
        $db->bind(':address', $this->address);
        $db->bind(':mobileNumber', $this->mobileNumber);
        $db->bind(':paymentReferenceNumber', $this->paymentReferenceNumber);
        $db->bind(':noAdult', $this->noAdult);
        $db->bind(':noKidsBelow6', $this->noKidsBelow6);
        $db->bind(':noKidsAbove6', $this->noKidsAbove6);
        $db->bind(':totalAmount', $this->totalAmount);
        //$db->bind(':registeredDate', $this->registeredDate);
        $db->bind(':isPaidConfirmed', $this->isPaidConfirmed);
        $db->bind(':paidConfirmedReferenceNumber', $this->paidConfirmedReferenceNumber);
        $db->bind(':tcAccept', $this->tcAccept);
        $results = $db->execute();
        $lastInsertedId = $db->lastInsertId();

        $db->closeConnection();
        return $lastInsertedId;
    }

    public function getUser($email,$eventId, $eventYear){
        // Select query example
        $db =  new DatabaseConnect();
        $db->query("SELECT * FROM mwiaTicketingSystem.mwia_event_register WHERE `emailId` = :email AND `eventId` = :eventId AND `eventYear` = :eventYear");
        $db->bind(':email', $email);
        $db->bind(':eventId', $eventId);
        $db->bind(':eventYear', $eventYear);
        $results = $db->single();
        
        $users = new mwiaEventRegister($results);

        $db->closeConnection();
        return $users;        
    }
}