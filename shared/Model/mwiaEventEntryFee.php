<?php
require_once ('../shared/Networking/DatabaseConnect.php');

class mwiaEventEntryFee {
   
    public $id;
    public $eventId;
    public $eventYear;
    public $memberEntryFee;
    public $nonMemberEntryFee;
    public $kidsBelow6EntryFee;
    public $kidsAbove6EntryFee;

    // Constructor to easily create User objects
    public function __construct($data = null) {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->eventId = $data['eventId'] ?? null;
            $this->eventYear = $data['eventYear'] ?? null;
            $this->memberEntryFee = $data['memberEntryFee'] ?? null;
            $this->nonMemberEntryFee = $data['nonMemberEntryFee'] ?? null;
            $this->kidsBelow6EntryFee = $data['kidsBelow6EntryFee'] ?? null;
            $this->kidsAbove6EntryFee = $data['kidsAbove6EntryFee'] ?? null;
        }
    }

    public function getEventPrice($eventId, $eventYear){
        // Select query example
        $db =  new DatabaseConnect();
        $db->query("SELECT * FROM mwia_event_entry_fee WHERE `eventId` = :eventId AND `eventYear` = :eventYear ");
        $db->bind(':eventId', $eventId);
        $db->bind(':eventYear', $eventYear);
        
        $result = $db->single();
        $user = new mwiaEventEntryFee($result);
        $db->closeConnection();

        return $user;
    }
}