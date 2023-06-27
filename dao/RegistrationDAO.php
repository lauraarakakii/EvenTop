<?php

require_once("models/event.php");
require_once("models/message.php");
require_once("models/registration.php");

class RegistrationDAO implements RegistrationDAOInterface {
    private $conn;
    private $baseURL;

    public function __construct($conn, $baseURL) {
        $this->conn = $conn;
        $this->baseURL = $baseURL;
    }

    public function isRegistered($eventId, $userId) {
        $sql = "SELECT * FROM registrations WHERE events_idevents = :eventId AND users_idusers = :userId";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":eventId", $eventId);
        $stmt->bindParam(":userId", $userId);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function registerUser($events_idevents, $users_idusers) {
        $sql = "INSERT INTO registrations (status, events_idevents, users_idusers) VALUES ('não pago', :events_idevents, :users_idusers)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":events_idevents", $events_idevents);
        $stmt->bindParam(":users_idusers", $users_idusers);

        $stmt->execute();
    }
}

?>
