<?php
require_once("models/event.php");
require_once("models/message.php");
require_once("dao/ReviewDAO.php");
require_once("dao/RegistrationDAO.php");


class EventDAO implements EventDAOInterface
{
    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildEvent($data)
    {
        $event = new Event();

        $event->idevents = $data["idevents"];
        $event->title = $data["title"];
        $event->description = $data["description"];
        $event->images = $data["images"];
        $event->date = $data["date"];
        $event->time = $data["time"];
        $event->location = $data["location"];
        $event->price = $data["price"];
        $event->users_idusers = $data["users_idusers"];
        $event->categories_idcategories = $data["categories_idcategories"];

        // Recebe as ratings do evento
        $reviewDAO = new ReviewDAO($this->conn, $this->url);

        $rating = $reviewDAO->getRating($event->idevents);

        $event->rating = $rating;

        if (array_key_exists('category_name', $data)) {
            $event->category_name = $data["category_name"];
        }

        return $event;
    }

    public function getRegistrations($eventId) {

        $sql = "SELECT * FROM registration WHERE events_idevents = :eventId";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":eventId", $eventId);
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    

    public function findAll()
    {
    }
    public function getLatestEvents()
    {

        $events = [];

        $stmt = $this->conn->query("SELECT * FROM events ORDER BY idevents DESC");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $eventsArray = $stmt->fetchAll();

            foreach ($eventsArray as $event) {
                $events[] = $this->buildEvent($event);
            }
        }

        return $events;

    }
    public function getEventsByCategory($categories_idcategories)
    {
        $events = [];

        $stmt = $this->conn->prepare("SELECT * FROM events 
                                        WHERE categories_idcategories = :categories_idcategories
                                        ORDER BY idevents DESC");

        $stmt->bindParam(":categories_idcategories", $categories_idcategories);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $eventsArray = $stmt->fetchAll();

            foreach ($eventsArray as $event) {
                $events[] = $this->buildEvent($event);
            }
        }

        return $events;
    }
    public function getEventsByUserId($users_idusers)
    {

        $events = [];

        $stmt = $this->conn->prepare("SELECT * FROM events 
                                        WHERE users_idusers = :users_idusers");

        $stmt->bindParam(":users_idusers", $users_idusers);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $eventsArray = $stmt->fetchAll();

            foreach ($eventsArray as $event) {
                $events[] = $this->buildEvent($event);
            }
        }

        return $events;
    }

    public function findById($idevents)
    {
        $event = [];

        $stmt = $this->conn->prepare("
            SELECT events.*, categories.description AS category_name 
            FROM events 
            INNER JOIN categories ON events.categories_idcategories = categories.idcategories 
            WHERE events.idevents = :idevents
        ");

        $stmt->bindParam(":idevents", $idevents);

        try {
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $eventData = $stmt->fetch();
                $event = $this->buildEvent($eventData);
                return $event;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    public function findByTitle($title)
    {

        $events = [];

        $stmt = $this->conn->prepare("SELECT * FROM events 
                                        WHERE title LIKE :title");

        $stmt->bindValue(":title", '%'.$title.'%');

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $eventsArray = $stmt->fetchAll();

            foreach ($eventsArray as $event) {
                $events[] = $this->buildEvent($event);
            }
        }

        return $events;
    }
    public function create(Event $event)
    {

        $stmt = $this->conn->prepare("INSERT INTO events (
                title, description, date, time, location, price, images, users_idusers, categories_idcategories
            ) VALUES (
                :title, :description, :date, :time, :location, :price, :images, :users_idusers, :categories_idcategories
            )");

        $stmt->bindParam(":title", $event->title);
        $stmt->bindParam(":description", $event->description);
        $stmt->bindParam(":date", $event->date);
        $stmt->bindParam(":time", $event->time);
        $stmt->bindParam(":location", $event->location);
        $stmt->bindParam(":price", $event->price);
        $stmt->bindParam(":images", $event->images);
        $stmt->bindParam(":users_idusers", $event->users_idusers);
        $stmt->bindParam(":categories_idcategories", $event->categories_idcategories);

        $stmt->execute();

        $this->message->setMessage("Evento adicionado com sucesso!", "success", "index.php");
    }
    public function update(Event $event)
    {
        $stmt = $this->conn->prepare("UPDATE events SET 
            title = :title,
            date = :date,
            time = :time,
            location = :location,
            categories_idcategories = :categories_idcategories,
            price = :price,
            description = :description,
            images = :images
            WHERE idevents = :idevents
        ");

        $stmt->bindParam(":title", $event->title);
        $stmt->bindParam(":date", $event->date);
        $stmt->bindParam(":time", $event->time);
        $stmt->bindParam(":location", $event->location);
        $stmt->bindParam(":categories_idcategories", $event->categories_idcategories);
        $stmt->bindParam(":price", $event->price);
        $stmt->bindParam(":description", $event->description);
        $stmt->bindParam(":images", $event->images);
        $stmt->bindParam(":idevents", $event->idevents);

        $stmt->execute();

        $this->message->setMessage("Evento atualizado com sucesso!", "success", "dashboard.php");
    }
    public function destroy($idevents)
    {
        $stmt = $this->conn->prepare("DELETE FROM events WHERE idevents = :idevents");

        $stmt->bindParam(":idevents", $idevents);

        $stmt->execute();

        $this->message->setMessage("Evento removido com sucesso!", "success", "dashboard.php");
    }

}
?>