<?php
require_once("templates/header.php");
require_once("models/event.php");
require_once("dao/EventDAO.php");
require_once("dao/ReviewDAO.php");
require_once("dao/RegistrationDAO.php");

$registrationDAO = new RegistrationDAO($conn, $BASE_URL);

$idevents = filter_input(INPUT_GET, "idevents");

$event = null; // Inicialize a variável com um valor padrão

$eventDAO = new EventDAO($conn, $BASE_URL);

$reviewDAO = new ReviewDAO($conn, $BASE_URL);


if (empty($idevents)) {

    $message->setMessage("O evento não foi encontrado.", "error", "index.php");

} else {

    $event = $eventDAO->findById($idevents);

    if (!$event) {
        $message->setMessage("O evento não foi encontrado.", "error", "index.php");
    }
}

//Checar se o evento tem imagem
if ($event->images == "") {
    $event->images = "event_cover.png";
}

//Checar se o evento é do usuário
$userOwnsEvent = false;

if (!empty($userData)) {
    if ($userData->idusers == $event->users_idusers) {
        $userOwnsEvent = true;
    }

    //Resgatar as reviews do evento
    $alreadyReviewed = $reviewDAO->hasAlreadyReviewed($idevents, $userData->idusers);



}

//Resgatar as reviews do evento
$eventReviews = $reviewDAO->getEventsReview($event->idevents);

//Verificar se o usuário já está inscrito no evento
$isRegistered = false;

if (!empty($userData)) {
    $isRegistered = $registrationDAO->isRegistered($event->idevents, $userData->idusers);
}

?>

<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 event-container">
            <h1 class="page-title">
                <?= $event->title ?>
            </h1>
            <p class="event-details">
                <span>Data:
                    <?= date('d/m/Y', strtotime($event->date)) ?>
                </span>
                <span class="pipe"></span>
                <span>Hora:
                    <?= date('H:i', strtotime($event->time)) ?>
                </span>

                <span class="pipe"></span>
                <span>Localização:
                    <?= $event->location ?>
                </span>
                <span class="pipe"></span>
                <span>Preço:
                    <?= $event->price ?>
                </span>
                <span class="pipe"></span>
                <span>Categoria:
                    <?= $event->category_name ?>
                </span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"></i>
                    <?= $event->rating ?>
                </span>
            </p>
            <p>
            <h3><b>Conheça o evento: </b></h3>
            <?= $event->description ?>
            </p>

            <?php if (!empty($userData) && !$userOwnsEvent && !$isRegistered): ?>
                <form action="<?= $BASE_URL ?>registration_process.php" method="POST" id="registration-form">
                    <input type="hidden" name="type" value="create">
                    <input type="hidden" name="events_idevents" value="<?= $event->idevents ?>">
                    <button type="submit" class="card-btn btn" style="margin-top: 33%;">Inscreva-se!</button>
                </form>
            <?php endif; ?>

        </div>
        <div class="col-md-4">
            <div class="event-image-container"
                style="background-image: url('<?= $BASE_URL ?>/img/event/<?= $event->images ?>')"></div>

        </div>
        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 id="reviews-title">Avaliações:</h3>
            <?php if (!empty($userData) && !$userOwnsEvent && !$alreadyReviewed): ?>
                <div class="col-md-12" id="review-form-container">
                    <h4>Envie sua avaliação:</h4>
                    <p class="page-description">Faça a sua avaliação sobre o evento:</p>
                    <form action="<?= $BASE_URL ?>review_process.php" method="POST" id="review-form">
                        <input type="hidden" name="type" value="create">
                        <input type="hidden" name="events_idevents" value="<?= $event->idevents ?>">
                        <div class="form-group">
                            <label for="rating">Nota do Evento:</label>
                            <select name="rating" id="rating" class="form-control">
                                <option value="">Selecione</option>
                                <option value="10">10</option>
                                <option value="9">9</option>
                                <option value="8">8</option>
                                <option value="7">7</option>
                                <option value="6">6</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                                <option value="0">0</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="review">Seu comentário:</label>
                            <textarea name="review" id="review" rows="3" class="form-control"
                                placeholder="O que você achou do evento?"></textarea>
                        </div>
                        <br>
                        <input type="submit" value="Enviar comentário" class="btn card-btn">

                    </form>
                </div>
            <?php endif; ?>
            <!--Comentários-->
            <?php foreach ($eventReviews as $review): ?>
                <?php require("templates/user_review.php"); ?>
            <?php endforeach; ?>
            <?php if (count($eventReviews) === 0): ?>
                <p class="empty-list">Não há comentários sobre esse evento ainda</p>
            <?php endif; ?>

        </div>

    </div>
</div>

<!--sk.eyJ1IjoiYXJha2FraWxhdXJhIiwiYSI6ImNsamVzMW5zdjB1ZWwza3NjcTZnMzh4ZTMifQ.IW5o5ev9vwpINmfae0WR3w-->

<?php
require_once("templates/footer.php");
?>