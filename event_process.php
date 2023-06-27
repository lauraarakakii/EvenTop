<?php
require_once("globals.php");
require_once("db.php");
require_once("models/event.php");
require_once("models/message.php");
require_once("dao/UserDAO.php");
require_once("dao/EventDAO.php");

$message = new Message($BASE_URL);
$userDAO = new userDAO($conn, $BASE_URL);
$eventDAO = new eventDAO($conn, $BASE_URL);

//Verifica o tipo do formulário
$type = filter_input(INPUT_POST, "type");

// Resgata dados do usuário
$userData = $userDAO->verifyToken();

if ($type === "create") {

    //Recebendo dados do input
    $title = filter_input(INPUT_POST, "title");
    $date = filter_input(INPUT_POST, "date");
    $time = filter_input(INPUT_POST, "time");
    $location = filter_input(INPUT_POST, "location");
    $categories_idcategories = filter_input(INPUT_POST, "categories_idcategories");
    $price = filter_input(INPUT_POST, "price");
    $description = filter_input(INPUT_POST, "description");

    $event = new Event();

    //Validação mínima de dados

    if (!empty($title) && !empty($description) && !empty($categories_idcategories) && !empty($location) && !empty($date)) {

        $event->title = $title;
        $event->date = $date;
        $event->time = $time;
        $event->location = $location;
        $event->categories_idcategories = $categories_idcategories;
        $event->price = $price;
        $event->description = $description;
        $event->users_idusers = $userData->idusers;

        //Upload imagem evento
        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            //Checando tipo da imagem
            if (in_array($image["type"], $imageTypes)) {

                if (in_array($image["type"], $jpgArray)) {
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                $imageName = $event->imageGenerateName();

                imagejpeg($imageFile, "./img/event/" . $imageName);

                $event->images = $imageName;

            } else {

                $message->setMessage("Tipo inválido de imagem.", "error", "back");

            }


        }

        $eventDAO->create($event);

    } else {
        $message->setMessage("Adicione mais informações sobre o seu evento.", "error", "back");
    }

} else if ($type === "delete") {

    //Receber os dados do form
    $idevents = filter_input(INPUT_POST, "idevents");

    $event = $eventDAO->findById($idevents);

    if ($eventData) {

        //verificar se o evento é do usuário
        if ($eventData->users_idusers == $userData->idusers) {

            $eventDAO->destroy($event->idevents);

        } else {
            $message->setMessage("Informações inválidas1.", "error", "index.php");
        }
    } else {
        $message->setMessage("Informações inválidas2.", "error", "index.php");
    }

} else if ($type === "update") {

    // Receber os dados dos inputs
    $title = filter_input(INPUT_POST, "title");
    $date = filter_input(INPUT_POST, "date");
    $time = filter_input(INPUT_POST, "time");
    $location = filter_input(INPUT_POST, "location");
    $categories_idcategories = filter_input(INPUT_POST, "categories_idcategories");
    $price = filter_input(INPUT_POST, "price");
    $description = filter_input(INPUT_POST, "description");
    $idevents = filter_input(INPUT_POST, 'idevents');

    $eventData = $eventDAO->findById($idevents);
    // Verifica se encontrou o evento
    if ($eventData) {

        // Verificar se o evento é do usuário
        if ($eventData->users_idusers == $userData->idusers) {

            // Validação mínima de dados
            if (!empty($title) && !empty($description) && !empty($categories_idcategories) && !empty($location) && !empty($date)) {

                // Edição do evento
                $eventData->title = $title;
                $eventData->date = $date;
                $eventData->time = $time;
                $eventData->location = $location;
                $eventData->categories_idcategories = $categories_idcategories;
                $eventData->price = $price;
                $eventData->description = $description;

                if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
                    $image = $_FILES["image"];
                    $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                    $jpgArray = ["image/jpeg", "image/jpg"];

                    //Checando tipo da imagem
                    if (in_array($image["type"], $imageTypes)) {

                        if (in_array($image["type"], $jpgArray)) {
                            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                        } else {
                            $imageFile = imagecreatefrompng($image["tmp_name"]);
                        }

                        $imageName = $event->imageGenerateName();

                        imagejpeg($imageFile, "./img/event/" . $imageName);

                        $eventData->images = $imageName;

                    } else {

                        $message->setMessage("Tipo inválido de imagem.", "error", "back");

                    }


                }

                $eventDAO->update($eventData);

            } else {

                $message->setMessage("Adicione mais informações sobre o seu evento.", "error", "back");

            }

        } else {

            $message->setMessage("Informações inválidas1.", "error", "index.php");

        }

    } else {

        $message->setMessage("Informações inválidas2.", "error", "index.php");

    }

} else {

    $message->setMessage("Informações inválidas3.", "error", "index.php");

}

?>