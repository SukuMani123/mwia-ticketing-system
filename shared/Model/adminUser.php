<?php
require_once ('../shared/Networking/DatabaseConnect.php');

class adminUser {
   
    public $id;
    public $name;
    public $email;

    // Constructor to easily create User objects
    public function __construct($data = null) {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->email = $data['email'] ?? null;
        }
    }

    public function selectUser($email, $password){
        // Select query example
        $db =  new DatabaseConnect();
        $db->query("SELECT * FROM mwiaTicketingSystem.mwiaadmin WHERE email = :id AND password = :pass");
        $db->bind(':id', $email);
        $db->bind(':pass', $password);
        $results = $db->single();
        
        $users = new adminUser($results);

        $db->closeConnection();
        return $users;
    }

}
