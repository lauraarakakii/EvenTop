<?php

require_once("globals.php");
require_once("db.php");
require_once("models/user.php");
require_once("models/message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);
$userDAO = new UserDAO($conn, $BASE_URL);


//Verifica o tipo do formulário
$type = filter_input(INPUT_POST, "type");

//Atualizar usuário
if ($type === "update") {

    // Resgata dados do usuário
    $userData = $userDAO->verifyToken();

    //Receber dados do post
    $name = filter_input(INPUT_POST, "name");
    $email = filter_input(INPUT_POST, "email");
    $userType = filter_input(INPUT_POST, "userType");
    $bio = filter_input(INPUT_POST, "bio");

    //Criar um novo objeto de usuário
    $user = new User();

    $userData->name = $name;
    $userData->email = $email;
    $userData->userType = $userType;
    $userData->bio = $bio;

    //Upload imagem
    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];
    
        // Checagem tipo de image
        if (in_array($image["type"], $imageTypes)) {
    
            $imageFile = false;
    
            // Checar se jpg
            if (in_array($image["type"], $jpgArray)) {
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
            }
            // é png
            else {
                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }
    
            // Verifique se a imagem foi carregada corretamente
            if ($imageFile === false) {
                // A imagem não pôde ser aberta. Lide com o erro aqui.
                $message->setMessage("Erro ao carregar a imagem.", "error", "back");
            }
            else {
                $imageName = $user->imageGenerateName();
    
                imagejpeg($imageFile, "./img/users/" . $imageName, 100);
    
                $userData->image = $imageName;
            }
        }
        else {
            $message->setMessage("Tipo inválido de imagem.", "error", "back");
        }
    }
    

    $userDAO->update($userData);



} elseif ($type == "changepassword") {

    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    $userData = $userDAO->verifyToken();
    $idusers = $userData->idusers;


    if($password === $confirmpassword){
        $user = new User();

        $finalPassword = $user->generatePassword($password);
        $user->password = $finalPassword;
        $user->idusers = $idusers;


        $userDAO->changePassword($user);

    }else {
        $message->setMessage("Senhas divergentes.", "error", "back");
    }


    $userData->name = $name;

} else {
    $message->setMessage("Informações inválidas.", "error", "index.php");
}
?>