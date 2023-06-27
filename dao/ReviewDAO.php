<?php

require_once("models/review.php");
require_once("models/message.php");
require_once("dao/UserDAO.php");
require_once("dao/EventDAO.php"); // Inclua o arquivo EventDAO.php

class ReviewDAO implements ReviewDAOInterface
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

    public function buildReview($data)
    {
        $reviewObject = new Review();

        $reviewObject->idreviews = $data["idreviews"];
        $reviewObject->rating = $data["rating"];
        $reviewObject->review = $data["review"];
        $reviewObject->events_idevents = $data["events_idevents"];
        $reviewObject->users_idusers = $data["users_idusers"];

        return $reviewObject;
    }

    public function create(Review $review)
    {
        // Prepare the SQL statement for inserting the review data
        $stmt = $this->conn->prepare("INSERT INTO reviews (
                rating, review, events_idevents, users_idusers
            ) VALUES (
                :rating, :review, :events_idevents, :users_idusers
            )");

        // Bind the review data to the SQL statement
        $stmt->bindParam(":rating", $review->rating);
        $stmt->bindParam(":review", $review->review);
        $stmt->bindParam(":events_idevents", $review->events_idevents);
        $stmt->bindParam(":users_idusers", $review->users_idusers);

        // Execute the SQL statement
        $stmt->execute();

        // Set a success message
        $this->message->setMessage("Comentário adicionado com sucesso!", "success", "index.php");

    }



    public function getEventsReview($idreviews)
    {

        $reviews = [];

        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE events_idevents = :events_idevents");

        $stmt->bindParam(":events_idevents", $idreviews);


        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $reviewsData = $stmt->fetchAll();

            $userDAO = new UserDAO($this->conn, $this->url);

            foreach ($reviewsData as $review) {

                $reviewObject = $this->buildReview($review);

                //chamar dados do usuario
                $user = $userDAO->findById($reviewObject->users_idusers);

                $reviewObject->user = $user;

                $reviews[] = $reviewObject;

            }

        } 

        return $reviews;
    }

    public function hasAlreadyReviewed($idevents, $users_idusers)
    {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE events_idevents = :events_idevents AND users_idusers = :users_idusers");
    
        $stmt->bindParam(":events_idevents", $idevents);
        $stmt->bindParam(":users_idusers", $users_idusers);
    
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getRating($idreviews)
    {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE events_idevents = :events_idevents");
    
        $stmt->bindParam(":events_idevents", $idreviews);
    
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $rating = 0;
            
            $reviews = $stmt->fetchAll();
    
            foreach ($reviews as $review) {
                $rating += $review["rating"];
            }
    
            $rating = $rating / count($reviews);
    
        } else {
            $rating = "Não Avaliado";
        }
    
        return $rating;
    }
    
    
    
}

?>