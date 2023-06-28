<?php
require_once("templates/header.php");
require_once("dao/EventDAO.php");

$eventDAO = new EventDAO($conn, $BASE_URL);

$partyEvents = $eventDAO->getEventsByCategory("1");

$pubEvents = $eventDAO->getEventsByCategory("2");

$showEvents = $eventDAO->getEventsByCategory("3");

$liveEvents = $eventDAO->getEventsByCategory("4");

$theatreEvents = $eventDAO->getEventsByCategory("5");

$courseEvents = $eventDAO->getEventsByCategory("6");

$fairEvents = $eventDAO->getEventsByCategory("7");

?>
<div id="main-container" class="container-fluid">
    <div id="base-menu">
        <div id="category-menu">
            <ul>
                <li><a href="#party-events">Festas</a></li>
                <li><a href="#pub-events">Bares</a></li>
                <li><a href="#show-events">Shows</a></li>
                <li><a href="#live-events">Música ao vivo</a></li>
                <li><a href="#theatre-events">Teatros</a></li>
                <li><a href="#course-events">Cursos</a></li>
                <li><a href="#fair-events">Feiras</a></li>
            </ul>
        </div>
    </div>

    <h2 id="party-events" class="section-title">Festas</h2>
    <p class="section-description">Veja as melhores festas</p>
    <div class="events-container">
        <?php foreach ($partyEvents as $event): ?>
            <?php require("templates/event_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($partyEvents) === 0): ?>
            <p class="empty-list">Ainda não há eventos cadastrados</p>
        <?php endif; ?>
    </div>

    <h2 id="pub-events" class="section-title">Bares</h2>
    <p class="section-description">Veja os melhores bares</p>
    <div class="events-container">
        <?php foreach ($pubEvents as $event): ?>
            <?php require("templates/event_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($pubEvents) === 0): ?>
            <p class="empty-list">Ainda não há eventos cadastrados</p>
        <?php endif; ?>
    </div>

    <h2 id="show-events" class="section-title">Shows</h2>
    <p class="section-description">Veja os melhores shows</p>
    <div class="events-container">
        <?php foreach ($showEvents as $event): ?>
            <?php require("templates/event_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($showEvents) === 0): ?>
            <p class="empty-list">Ainda não há eventos cadastrados</p>
        <?php endif; ?>
    </div>

    <h2 id="live-events" class="section-title">Música ao vivo</h2>
    <p class="section-description">Veja os melhores eventos de música ao vivo</p>
    <div class="events-container">
        <?php foreach ($liveEvents as $event): ?>
            <?php require("templates/event_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($liveEvents) === 0): ?>
            <p class="empty-list">Ainda não há eventos cadastrados</p>
        <?php endif; ?>
    </div>

    <h2 id="theatre-events" class="section-title">Teatros</h2>
    <p class="section-description">Veja os melhores teatros</p>
    <div class="events-container">
        <?php foreach ($theatreEvents as $event): ?>
            <?php require("templates/event_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($theatreEvents) === 0): ?>
            <p class="empty-list">Ainda não há eventos cadastrados</p>
        <?php endif; ?>
    </div>

    <h2 id="course-events" class="section-title">Cursos</h2>
    <p class="section-description">Veja as melhores cursos</p>
    <div class="events-container">
        <?php foreach ($courseEvents as $event): ?>
            <?php require("templates/event_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($courseEvents) === 0): ?>
            <p class="empty-list">Ainda não há eventos cadastrados</p>
        <?php endif; ?>
    </div>

    <h2 id="fair-events" class="section-title">Feiras</h2>
    <p class="section-description">Veja as melhores feiras</p>
    <div class="events-container">
        <?php foreach ($fairEvents as $event): ?>
            <?php require("templates/event_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($fairEvents) === 0): ?>
            <p class="empty-list">Ainda não há eventos cadastrados</p>
        <?php endif; ?>
    </div>
</div>

<?php
require_once("templates/footer.php");
?>
