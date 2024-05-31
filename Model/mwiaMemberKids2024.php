<?php
require_once ('../Networking/DatabaseConnect.php');

class mwiaMemberKids2024 {
   
    public $id;
    public $memberId;
    public $childFullName;
    public $childAge;

    // Constructor to easily create User objects
    public function __construct($data = null) {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->memberId = $data['memberId'] ?? null;
            $this->childFullName = $data['childFullName'] ?? null;
            $this->childAge = $data['childAge'] ?? null;
        }
    }

    public function addMemberKids(){
        // Select query example
        $db =  new DatabaseConnect();
        $db->query("Insert into mwia_members_child_2024 (memberId,childFullName,childAge) values (:memberId, :childFullName, :childAge);");
        $db->bind(':memberId', $this->memberId);
        $db->bind(':childFullName', $this->childFullName);
        $db->bind(':childAge', $this->childAge);
        $results = $db->execute();
        $db->closeConnection();
    }
}