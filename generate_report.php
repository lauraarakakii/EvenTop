<?php
require_once("globals.php");
require_once("db.php");
require_once("dao/EventDAO.php");
require_once("dao/RegistrationDAO.php");

$eventId = filter_input(INPUT_GET, "idevents", FILTER_VALIDATE_INT);

if (!$eventId) {
    // Redirecionar ou exibir uma mensagem de erro
    exit("Evento inválido.");
}

$eventDAO = new EventDAO($conn, $BASE_URL);
$registrationDAO = new RegistrationDAO($conn, $BASE_URL);

$event = $eventDAO->findById($eventId);

if (!$event) {
    // Redirecionar ou exibir uma mensagem de erro
    exit("Evento não encontrado.");
}

$registrations = $registrationDAO->getEventRegistrations($eventId);

// Gerar o relatório (exemplo: saída em formato CSV)
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=relatorio_inscritos.csv');

$output = fopen('php://output', 'w');

// Cabeçalho do relatório
fputcsv($output, ['Nome', 'E-mail', 'Status de Pagamento']);

// Dados dos inscritos
foreach ($registrations as $registration) {
    $row = [
        $registration->user_name,
        $registration->user_email,
        $registration->status
    ];
    fputcsv($output, $row);
}

fclose($output);
