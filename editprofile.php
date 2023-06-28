<?php
require_once("templates/header.php");

require_once("models/user.php");
require_once("dao/UserDAO.php");

$userDAO = new UserDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken(true);

if ($userData->image == "") {
    $userData->image = "user.png";
}



?>
<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="update">
            <div class="row">
                <div class="col-md-4">
                    <h1>
                        <?= $userData->name ?>
                    </h1>
                    <p class="page-description">Altere seus dados no formulário abaixo:</p>
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Digite o seu nome"
                            value="<?= $userData->name ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="text" readonly class="form-control disabled" id="email" name="email"
                            placeholder="Digite o seu email" value="<?= $userData->email ?>">
                    </div>
                    <div class="form-group">
                        <label for="userType">Tipo de usuário:</label>
                        <input type="text" readonly class="form-control" id="userType" name="userType"
                            placeholder="Digite o seu email" value="<?= $userData->userType ?>">
                    </div>
                    <br>
                    <input type="submit" class="btn card-btn" value="Alterar">
                </div>
                <div class="col-md-4">
                    <div id="profile-image-container"
                        style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                    <div class="form-group">
                        <label for="image">Foto:</label>
                        <input type="file" class="form-control-file" name="image">
                    </div>
                    <div class="form-group">
                        <label for="bio">Sobre você:</label>
                        <textarea class="form-control" name="bio" id="bio" rows="5"
                            placeholder="Conte quem você é, os rolês que curte e onde mora..."><?= $userData->bio ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="add-event-button">
                        <a href="<?= $BASE_URL ?>profile.php?idusers=<?= $userData->idusers ?>" class="btn card-btn">
                        <i class="fas fa-user"></i> Visualizar perfil
                        </a>
                    </div>
                    <bR>
                    <div class="add-event-button">
                        <a href="<?= $BASE_URL ?>my_events.php?idusers=<?= $userData->idusers ?>" class="btn card-btn">
                        <i class="fas fa-calendar"></i> Inscrições
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <div class="row" id="change-password-container">
            <div class="col-md-4">
                <h2>Alterar a senha:</h2>
                <p class="page-description">Digite a nova senha e confirme, para alterar a sua senha:</p>
                <form action="<?= $BASE_URL ?>user_process.php" method="POST">
                    <input type="hidden" name="type" value="changepassword">
                    <input type="hidden" name="idusers" value="<?= $userData->idusers ?>">
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Digite a sua nova senha">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword">Confirmação de senha:</label>
                        <input type="password" class="form-control" id="password" name="confirmpassword"
                            placeholder="Confirme a sua nova senha">
                    </div>
                    <br>
                    <input type="submit" class="btn card-btn" value="Alterar senha">
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once("templates/footer.php");
?>