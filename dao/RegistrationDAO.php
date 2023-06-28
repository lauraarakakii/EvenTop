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
    

    public function getEventRegistrations($eventId) {
        $sql = "SELECT registrations.*, users.name AS user_name, users.email AS user_email FROM registrations
                INNER JOIN users ON registrations.users_idusers = users.idusers
                WHERE registrations.events_idevents = :eventId";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":eventId", $eventId);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function isPaid($eventId, $userId) {
        $sql = "SELECT * FROM registrations WHERE events_idevents = :eventId AND users_idusers = :userId AND status = 'pago'";

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

    public function confirmPayment($eventId, $userId) {
        $sql = "UPDATE registrations SET status = 'pago' WHERE events_idevents = :eventId AND users_idusers = :userId";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":eventId", $eventId);
        $stmt->bindParam(":userId", $userId);

        $stmt->execute();
    }

    public function getPaymentStatus($userId, $eventId) {
        $sql = "SELECT status FROM registrations WHERE users_idusers = :userId AND events_idevents = :eventId";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":eventId", $eventId);
    
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_OBJ);
    
        return $result ? $result->status : null;
    }
}

?>