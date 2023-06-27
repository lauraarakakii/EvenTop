<?php
require_once("templates/header.php");

require_once("models/user.php");
require_once("dao/UserDAO.php");
require_once("dao/EventDAO.php");

$user = new User();

$userDAO = new UserDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken(true);

$eventDAO = new EventDAO($conn, $BASE_URL);

$idevents = filter_input(INPUT_GET, "idevents");

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
?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1>
                    <?= $event->title ?>
                </h1>
                <p class="page-description">Altere os dados do formulário abaixo:</p>
                <form id="edit-event-form" action="<?= $BASE_URL ?>event_process.php" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="idevents" value="<?= $event->idevents ?>">
                    <div class="form-group">
                        <label for="title">E qual o nome do evento?</label>
                        <input type="text" id="title" name="title" class="form-control"
                            placeholder="Digite o nome do evento" value="<?= $event->title ?>">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="image">Imagem do evento, seja criativo</label>
                        <input type="file" class="form-control-file" name="image" id="image">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="date">Qual será o dia do evento?</label>
                        <input type="date" class="form-control" name="date" id="date" value="<?= $event->date ?>">
                    </div>
                    <div class="form-group">
                        <label for="time">Qual será o horário do evento?</label>
                        <input type="time" class="form-control" name="time" id="time" value="<?= $event->time ?>">
                    </div>
                    <div class="form-group">
                        <label for="location">Qual vai ser o local?</label>
                        <input type="text" class="form-control" name="location" id="location"
                            placeholder="Digite a localização do evento" value="<?= $event->location ?>">
                    </div>
                    <div class="form-group">
                        <label for="categories_idcategories">Qual a categoria do evento?</label>
                        <select class="form-control" name="categories_idcategories" id="categories_idcategories">
                            <option value="">Selecione a categoria</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM categories");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $selected = ($event->categories_idcategories == $row['idcategories']) ? 'selected' : '';
                                echo "<option value='{$row['idcategories']}' $selected>{$row['description']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Preço</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="price" id="price"
                            placeholder="Digite o preço do evento" value="<?= $event->price ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição do evento, capricha, chama a galera!</label>
                        <textarea name="description" id="description" rows="5" class="form-control"
                            placeholder="Faça a descrição do evento" ><?= $event->description ?></textarea>
                    </div>
                    <br>
                    <input type="submit" class="btn card-btn" value="Editar evento">
                </form>
            </div>
            <div class="col-md-3">
                <div class="event-image-container" style="background-image: url('<?= $BASE_URL ?>img/event/<?= $event->images ?>')">

                </div>
            </div>
        </div>
    </div>

</div>


<?php
require_once("templates/footer.php");
?>