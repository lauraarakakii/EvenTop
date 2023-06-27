<?php

    class User {
        public $idusers;
        public $name;
        public $email; 
        public $password;
        public $userType;
        public $image;
        public $token;
        public $bio;

        public function getFullName($user) {
            return $user->name;
        }

        public function generateToken(){
            return bin2hex(random_bytes(50));
        }

        public function generatePassword($password){
            return password_hash($password, PASSWORD_DEFAULT);
        }

        public function imageGenerateName(){
            return bin2hex(random_bytes(60)) . ".jpg";
        }
    }

    interface UserDAOInterface {
        public function buildUser($data);
        public function create(User $user, $authUser = false);
        public function update(User $user, $redirect = false);
        public function verifyToken($protected = false);
        public function setTokenToSession($token, $redirect = true);
        public function authenticateUser($email, $password);
        public function findByToken($token);
        public function findByEmail($email);
        public function findById($id);
        public function changePassword(User $user);
        public function destroyToken();


    }

?>