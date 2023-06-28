<?php
require_once("templates/header.php");
require_once("dao/EventDAO.php");

$eventDAO = new EventDAO($conn, $BASE_URL);

$latestEvents = $eventDAO->getLatestEvents();

?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title">Eventos novos</h2>
    <p class="section-description">Fique de olho nos novos eventos adicionados no EvenTop</p>
    <div class="events-container">
        <?php foreach ($latestEvents as $event): ?>
            <?php require("templates/event_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($latestEvents) === 0): ?>
            <p class="empty-list">Ainda não há eventos cadastrados</p>
        <?php endif; ?>
    </div>
</div>

<?php
require_once("templates/footer.php");
?>