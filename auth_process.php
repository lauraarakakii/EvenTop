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

//echo$type;

//Verificação do tipo de formulário
if ($type == "register") {

    $email = filter_input(INPUT_POST, "email");
    $name = filter_input(INPUT_POST, "name");
    $userType = filter_input(INPUT_POST, "userType");
    $password = filter_input(INPUT_POST, "password");
    $confirmPassword = filter_input(INPUT_POST, "confirmpassword");

    //Verificação obrigatórios
    if ($email && $name && $userType && $password) {
        if ($password === $confirmPassword) {
            if ($userDAO->findByEmail($email) === false) {

                $user = new User();

                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->email = $email;
                $user->name = $name;
                $user->userType = $userType;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDAO->create($user, $auth);

                
            } else {
                $message->setMessage("E-mail já cadastrado no sistema.", "error", "back");
            }
        } else {
            $message->setMessage("As senhas não são iguais.", "error", "back");
        }
    } else {
        $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
    }

} else if ($type == "login"){

    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    //Tenta autenticar user
    if($userDAO->authenticateUser($email, $password)){

        $message->setMessage("Seja bem-vindo!", "sucess", "editprofile.php");
        

    }else{
        
        $message->setMessage("Usuário e/ou senha incorreto.", "error", "back");

    }
} else {

    $message->setMessage("Informações inválidas.", "error", "index.php");

}
?>