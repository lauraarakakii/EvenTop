<?php
    require_once("models/event.php");
    require_once("models/message.php");


    class EventDAO implements EventDAOInterface {
        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url){
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildEvent($data){
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
    
            return $event;
        }
        public function findAll(){}
        public function getLatestEvents(){

            $events = [];

            $stmt = $this->conn->query("SELECT * FROM events ORDER BY idevents DESC");

            $stmt->execute();

            if($stmt->rowCount() > 0){
                $eventsArray = $stmt->fetchAll();

                foreach($eventsArray as $event){
                    $events[] = $this->buildEvent($event);
                }
            }

            return $events;

        }
        public function getEventsByCategory($categories_idcategories){
            $events = [];

            $stmt = $this->conn->prepare("SELECT * FROM events 
                                        WHERE categories_idcategories = :categories_idcategories
                                        ORDER BY idevents DESC");

            $stmt->bindParam(":categories_idcategories", $categories_idcategories);

            $stmt->execute();

            if($stmt->rowCount() > 0){
                $eventsArray = $stmt->fetchAll();

                foreach($eventsArray as $event){
                    $events[] = $this->buildEvent($event);
                }
            }

            return $events;

        }
        public function getEventsByUserId($idevents){}
        public function findById($idevents){}
        public function findByTitle($title){}
        public function create(Event $event){

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
        public function update(Event $event){}
        public function destroy($idevents){}

    }
?>