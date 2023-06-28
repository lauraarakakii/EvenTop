<?php
// Importe os arquivos necessários
require_once("globals.php");
require_once("db.php");
require_once("dao/RegistrationDAO.php");
require_once("dao/EventDAO.php");
require_once("dao/UserDAO.php");
require_once("models/message.php");


// Crie instâncias das classes DAO
$registrationDAO = new RegistrationDAO($conn, $BASE_URL);
$eventDAO = new EventDAO($conn, $BASE_URL);
$userDAO = new UserDAO($conn, $BASE_URL);
$message = new Message($BASE_URL);

//Verifica o tipo do formulário
$type = filter_input(INPUT_POST, "type");
$userData = $userDAO->verifyToken();

// Verifique se o tipo de requisição é para criar uma nova inscrição
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["type"]) && $_POST["type"] === "create") {
    // Verifique se o usuário está logado
    if (!$userData) {
        $message->setMessage("Faça login para continuar.", "error", "authentication.php");
    }

    // Obtenha os dados do formulário
    $events_idevents = filter_input(INPUT_POST, "events_idevents", FILTER_VALIDATE_INT);
    $userId = $userData->idusers;

    // Verifique se o evento e o usuário existem
    $event = $eventDAO->findById($events_idevents);

    if (!$event) {
        $message->setMessage("Informações inválidas1.", "error", "index.php");
    }

    // Verifique se o usuário já está inscrito nesse evento
    $isRegistered = $registrationDAO->isRegistered($events_idevents, $userId);
    if ($isRegistered) {
        $message->setMessage("Você já está inscrito nesse evento!", "error", "event.php?idevents=" . $events_idevents);
    }

    // Crie a inscrição
    $registrationDAO->registerUser($events_idevents, $userId);

    // Redirecione para a página do evento ou exiba uma mensagem de sucesso
    $message->setMessage("Inscrição realizada com sucesso!", "success", 
    "event.php?idevents=" . $events_idevents);

}
/*
// Verifique se o tipo de requisição é para excluir uma inscrição
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["type"]) && $_POST["type"] === "delete") {
    // Verifique se o usuário está logado
    $userData = $userDAO->verifyToken();
    if (!$userData) {
        // Redirecione para a página de login ou exiba uma mensagem de erro
        header("Location: login.php");
        exit();
    }

    // Obtenha os dados do formulário
    $eventId = filter_input(INPUT_POST, "eventId", FILTER_VALIDATE_INT);
    $userId = $userData->idusers;

    // Verifique se o evento e o usuário existem
    $event = $eventDAO->findById($eventId);
    if (!$event) {
        // Evento não encontrado, redirecione para a página de eventos ou exiba uma mensagem de erro
        header("Location: events.php");
        exit();
    }

    // Verifique se o usuário está inscrito nesse evento
    $isRegistered = $registrationDAO->isRegistered($eventId, $userId);
    if (!$isRegistered) {
        // O usuário não está inscrito, redirecione para a página do evento ou exiba uma mensagem de erro
        header("Location: event.php?idevents=" . $eventId);
        exit();
    }

    // Exclua a inscrição
    $registrationDAO->deleteRegistration($eventId, $userId);

    // Redirecione para a página do evento ou exiba uma mensagem de sucesso
    header("Location: event.php?idevents=" . $eventId);
    exit();
}

// Caso nenhuma ação válida tenha sido executada, redirecione para a página inicial ou exiba uma mensagem de erro
header("Location: index.php");
exit();

*/
?>