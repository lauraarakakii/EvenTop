<?php
require_once("models/user.php");
require_once("models/message.php");

class UserDAO implements UserDAOInterface
{

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildUser($data)
    {

        $user = new User();

        $user->idusers = $data["idusers"];
        $user->name = $data["name"];
        $user->email = $data["email"];
        $user->password = $data["password"];
        $user->userType = $data["userType"];
        $user->image = $data["image"];
        $user->token = $data["token"];
        $user->bio = $data["bio"];

        return $user;

    }

    public function create(User $user, $authUser = false)
    {

        $stmt = $this->conn->prepare("INSERT INTO users(
                name, email, password, userType, token
              ) VALUES (
                :name, :email, :password, :userType, :token
              )");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":userType", $user->userType);
        $stmt->bindParam(":token", $user->token);

        $stmt->execute();

        // Autenticar usuário, caso auth seja true
        if ($authUser) {
            $this->setTokenToSession($user->token);
        }

    }

    public function update(User $user, $redirect = true)
    {

        $stmt = $this->conn->prepare("UPDATE users SET
                name = :name, 
                email = :email, 
                userType = :userType, 
                image = :image, 
                bio = :bio, 
                token = :token
                WHERE idusers = :idusers
        ");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":userType", $user->userType);
        $stmt->bindParam(":image", $user->image);
        $stmt->bindParam(":bio", $user->bio);
        $stmt->bindParam(":token", $user->token);
        $stmt->bindParam(":idusers", $user->idusers);

        $stmt->execute();

        if ($redirect) {

            // Redireciona para o perfil do usuario
            $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");

        }

    }

    public function verifyToken($protected = false)
    {

        if (!empty($_SESSION["token"])) {

            // Pega o token da session
            $token = $_SESSION["token"];

            $user = $this->findByToken($token);

            if ($user) {
                return $user;
            } else if ($protected) {

                // Redireciona usuário não autenticado
                $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");

            }

        } else if ($protected) {

            // Redireciona usuário não autenticado
            $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");

        }

    }
    public function setTokenToSession($token, $redirect = true)
    {

        // Salvar token na session
        $_SESSION["token"] = $token;

        if ($redirect) {

            // Redireciona para o perfil do usuario
            $this->message->setMessage("Seja bem-vindo!", "success", "editprofile.php");

        }

    }
    public function authenticateUser($email, $password)
    {

        $user = $this->findByEmail($email);

        if ($user) {

            // Checar se as senhas batem
            if (password_verify($password, $user->password)) {

                // Gerar um token e inserir na session
                $token = $user->generateToken();

                $this->setTokenToSession($token, false);

                // Atualizar token no usuário
                $user->token = $token;

                $this->update($user, false);

                return true;

            } else {
                return false;
            }

        } else {

            return false;

        }

    }

    public function findByToken($token)
    {

        if ($token != "") {

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");

            $stmt->bindParam(":token", $token);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;

            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    public function findByEmail($email)
    {

        if ($email != "") {

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");

            $stmt->bindParam(":email", $email);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;

            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    public function findById($idusers)
    {

        if ($idusers != "") {

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE idusers = :idusers");

            $stmt->bindParam(":idusers", $idusers);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;

            } else {
                return false;
            }

        } else {
            return false;
        }
    }


    public function changePassword(User $user)
    {
        $stmt = $this->conn->prepare("UPDATE users SET
            password = :password
            WHERE idusers = :idusers
        ");

        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":idusers", $user->idusers);

        $stmt->execute();

        // Redirecionar e apresentar a mensagem de sucesso
        $this->message->setMessage("Senha alterada com sucesso!", "success", "editprofile.php");
    }

    public function destroyToken() {

        // Remove o token da session
        $_SESSION["token"] = "";
  
        // Redirecionar e apresentar a mensagem de sucesso
        $this->message->setMessage("Você fez o logout com sucesso!", "success", "index.php");
  
      }
}
?>