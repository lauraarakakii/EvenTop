<?php
require_once("templates/header.php");
require_once("dao/EventDAO.php");

$eventDAO = new EventDAO($conn, $BASE_URL);

//Resgata busca user
$q = filter_input(INPUT_GET, "q");

$events = $eventDAO->findByTitle($q);

?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title" id="search-title">Você está buscando por: <span id="search-result"><?= $q ?></span></h2>
    <p class="section-description">Resultados de busca retornados com base na sua pesquisa.</p>
    <div class="events-container">
        <?php foreach ($events as $event): ?>
            <?php require("templates/event_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($events) === 0): ?>
            <p class="empty-list">Não há eventos para esta busca, <a href="<?= $BASE_URL ?>index.php">voltar</a>.</p>
        <?php endif; ?>
    </div>
</div>

<?php
require_once("templates/footer.php");
?>