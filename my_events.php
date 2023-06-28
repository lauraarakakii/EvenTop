<?php
require_once("templates/header.php");

require_once("models/user.php");
require_once("dao/UserDAO.php");
require_once("dao/EventDAO.php");


$user = new User();
$userDAO = new UserDAO($conn, $BASE_URL);
$eventDAO = new EventDAO($conn, $BASE_URL);


$idusers = filter_input(INPUT_GET, "idusers");

$userRegistrations = $userDAO->getUserRegistrations($idusers);

if (empty($idusers)) {

    if (!empty($userData)) {
        $idusers = $userData->idusers;
    } else {
        $message->setMessage("O usuário não foi encontrado.", "error", "index.php");
    }

} else {

    $userData = $userDAO->findById($idusers);

    if (!$userData) {
        $message->setMessage("O usuário não foi encontrado.", "error", "index.php");
    }

}

if ($userData->image == "") {
    $userData->image = "user.png";
}

//Eventos que o usuário adicionou
$userEvents = $eventDAO->getEventsByUserId($idusers);
?>

<div id="main-container" class="container-fluid">
                <div class="subscribe-events">
                    <h3>Eventos em que está inscrito:</h3>
                    <?php foreach ($userRegistrations as $event): ?>
                        <?php require("templates/payment_card.php"); ?>
                    <?php endforeach; ?>

                    <?php if (count($userEvents) === 0 && count($userRegistrations) === 0): ?>
                        <p class="empty-list">O usuário ainda não enviou nenhum evento e não está inscrito em nenhum evento
                        </p>
                    <?php endif; ?>
                </div>


            </div>

        </div>
    </div>
</div>

<?php
require_once("templates/footer.php");
?>