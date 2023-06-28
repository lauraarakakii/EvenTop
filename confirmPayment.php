<?php

require_once("globals.php");
require_once("db.php");
require_once("models/message.php");
require_once("dao/UserDAO.php");
require_once("dao/RegistrationDAO.php");

$message = new Message($BASE_URL);
$userDAO = new UserDAO($conn, $BASE_URL);
$registrationDAO = new RegistrationDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken(true);


// Resgata dados do usuário
$userData = $userDAO->verifyToken();
$userId = $userData->idusers;

// Recebe o ID do evento via POST
$eventId = filter_input(INPUT_POST, "events_idevents");

// Verifica se o usuário está logado
if(!$userId) {
    $message->setMessage("Você precisa estar logado para realizar esta ação!", "error", "back");
}

// Verifica se o usuário está inscrito no evento
if(!$registrationDAO->isRegistered($eventId, $userId)) {
    $message->setMessage("Você não está inscrito neste evento!", "error", "back");
}

// Verifica se o pagamento ainda não foi realizado
if($registrationDAO->isPaid($eventId, $userId)) {
    $message->setMessage("Você já confirmou o pagamento para este evento!", "error", "back");
}

// Atualiza o status do pagamento para 'pago'
$registrationDAO->confirmPayment($eventId, $userId);
$message->setMessage("Pagamento confirmado com sucesso!", "success", "back");

?>
