<footer id="footer">
    <div id="social-container">
        <ul>
            <li>
                <a href="#"><i class="fab fa-facebook-square"></i></a>
            </li>
            <li>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </li>
            <li>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </li>
        </ul>
    </div>
    <div id="footer-links-container">
        <ul>
            <li>
                <a href="<?= $BASE_URL ?>newevent.php">Adicionar Evento</a>
            </li>
            <li>
                <a href="<?= $BASE_URL ?>my_events.php?idusers=<?= $userData->idusers ?>">Meus Eventos</a>
            </li>
            <li>
                <a href="<?= $BASE_URL ?>authetication.php">Entrar / Cadastrar</a>
            </li>
        </ul>
    </div>
    <p>&copy; 2023 Laura Arakaki</p>
</footer>
<!--Bootstrap JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.js"
    integrity="sha512-jxHTIcyuk3K/8tFI4UWP/2XfMAnBUL/GCcY0ah39DQfnsG8+YgtAJsOE8fznN+jWqwgLazJMEpmyE9HW1Mmc+A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
    integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>