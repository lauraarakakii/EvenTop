<?php
    require_once("models/User.php");

    class UserDAO implements UserDAOInterface {

        private $conn;
        private $url;

        public function __construct(PDO $conn, $url){
            $this->conn = $conn;
            $this->url = $url;
        }

        public function buildUser($data){

            $user = new User();

            $user->idusers = $data["idusers"];
            $user->name = $data["name"];
            $user->email = $data["email"];
            $user->password = $data["password"];
            $user->type = $data["type"];
            $user->image = $data["image"];
            $user->token = $data["token"];
            $user->bio = $data["bio"];

            return $user;

        }
        public function create(User $user, $authUser = false){

        }
        public function update(User $user, $authUser = false){

        }
        public function verifyToken($protected = false){

        }
        public function setTokenToSession($token, $redirect = true){

        }
        public function authenticateUser($email, $password){

        }
        public function findByToken($token){

        }
        public function findByEmail($email){

        }
        public function findById($id){

        }
        public function changePassword(User $user){

        }
    }
?>