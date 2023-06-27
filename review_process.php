<?php
require_once("globals.php");
require_once("db.php");
require_once("models/review.php");
require_once("models/message.php");
require_once("dao/UserDAO.php");
require_once("dao/EventDAO.php");
require_once("dao/ReviewDAO.php");

$message = new Message($BASE_URL);
$userDAO = new UserDAO($conn, $BASE_URL);
$eventDAO = new EventDAO($conn, $BASE_URL);
$reviewDAO = new ReviewDAO($conn, $BASE_URL);


// Verifica o tipo do formulário
$type = filter_input(INPUT_POST, "type");

// Resgata dados do usuário
$userData = $userDAO->verifyToken();

if ($type === "create") {
    // Recebendo dados do post
    $rating = filter_input(INPUT_POST, "rating");
    $review = filter_input(INPUT_POST, "review");
    $events_idevents = filter_input(INPUT_POST, "events_idevents");

    $reviewObject = new Review();

    // Validando se os campos estão preenchidos
    if (!empty($rating) && !empty($review) && !empty($events_idevents)) {
        $reviewObject->rating = $rating;
        $reviewObject->review = $review;
        $reviewObject->events_idevents = $events_idevents;
        $reviewObject->users_idusers = $userData->idusers;

        $reviewDAO->create($reviewObject);
    } else {
        $message->setMessage("Você precisa inserir a nota e o comentário!", "error", "back");
    }
} else {
    $message->setMessage("Informações inválidas!", "error", "index.php");
}