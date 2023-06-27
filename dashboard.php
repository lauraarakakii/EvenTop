<?php
require_once("templates/header.php");

require_once("models/user.php");
require_once("dao/UserDAO.php");
require_once("dao/EventDAO.php");


$user = new User();
$userDAO = new UserDAO($conn, $BASE_URL);
$eventDAO = new EventDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken(true);

$userEvents = $eventDAO->getEventsByUserId($userData->idusers);


?>

<div id="main-container" class="container-fluid">
    <h2 class="section-title">Dashboard</h2>
    <p class="section-description">Adicione ou atualize as informações dos eventos que você adicionou</p>
    <div class="col-md-12" id="add-event-container">
        <a href="<?= $_BASE_URL ?>newevent.php" class="btn card-btn">
            <i class="fas fa-plus"></i> Adicionar evento
        </a>
    </div>
    <br>
    <div class="col-md-12" id="events-dashboard">
        <table class="table">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Título</th>
                <th scope="col">Nota</th>
                <th scope="col" class="actions-column">Ações</th>
            </thead>
            <tbody>
                <?php foreach ($userEvents as $event): ?>
                    <tr>
                        <td scope="row">
                            <?= $event->idevents ?>
                        </td>
                        <td><a href="<?= $BASE_URL ?>event.php?idevents=<?= $event->idevents ?>"
                                class="table-event-title"><?= $event->title ?></a></td>
                        <td><i class="fas fa-star"></i> <?= $event->rating ?></td>
                        <td class="actions-column">
                            <a href="<?= $BASE_URL ?>editevent.php?idevents=<?= $event->idevents ?>" class="edit-btn">
                                <i class="far fa-edit"> Editar</i>
                            </a>
                            <form action="<?= $BASE_URL ?>event_process.php" method="POST">
                                <input type="hidden" name="type" value="delete">
                                <input type="hidden" name="idevents" value="<?= $event->idevents ?>">
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-times"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?php
require_once("templates/footer.php");
?>