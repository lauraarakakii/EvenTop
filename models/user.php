<?php

    class User {
        public $idusers;
        public $name;
        public $email; 
        public $password;
        public $type;
        public $image;
        public $token;
        public $bio;
    }

    interface UserDAOInterface {
        public function buildUser($data);
        public function create(User $user, $authUser = false);
        public function update(User $user, $authUser = false);
        public function verifyToken($protected = false);
        public function setTokenToSession($token, $redirect = true);
        public function authenticateUser($email, $password);
        public function findByToken($token);
        public function findByEmail($email);
        public function findById($id);
        public function changePassword(User $user);

    }

?>