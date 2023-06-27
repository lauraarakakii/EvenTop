<?php
require_once("templates/header.php");

require_once("models/user.php");
require_once("dao/UserDAO.php");

$user = new User();

$userDAO = new UserDAO($conn, $BASE_URL);

$userData = $userDAO->verifyToken(true);
?>
<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-event-container">
        <h1 class="page-title">Adicionar Evento</h1>
        <p class="page-description">Crie o seu evento e convide toda a galera!</p>
        <form action="<?= $BASE_URL ?>event_process.php" id="add-event-form" method="POST"
            enctype="multipart/form-data">
            <input type="hidden" name="type" value="create">
            <div class="form-group">
                <label for="title">E qual o nome do evento?</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Digite o nome do evento">
            </div>
            <br>
            <div class="form-group">
                <label for="image">Imagem do evento, seja criativo</label>
                <input type="file" class="form-control-file" name="image" id="image">
            </div>
            <br>
            <div class="form-group">
                <label for="date">Qual será o dia do evento?</label>
                <input type="date" class="form-control" name="date" id="date">
            </div>
            <div class="form-group">
                <label for="time">Qual será o horário do evento?</label>
                <input type="time" class="form-control" name="time" id="time">
            </div>
            <div class="form-group">
                <label for="location">Qual vai ser o local?</label>
                <input type="text" class="form-control" name="location" id="location"
                    placeholder="Digite a localização do evento">
            </div>
            <div class="form-group">
                <label for="categories_idcategories">Qual a categoria do evento?</label>
                <select class="form-control" name="categories_idcategories" id="categories_idcategories">
                    <option value="">Selecione a categoria</option>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM categories");
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['idcategories']}'>{$row['description']}</option>";
                    }
                    ?>
                </select>
            </div>


            <div class="form-group">
                <label for="price">Preço</label>
                <input type="number" step="0.01" min="0" class="form-control" name="price" id="price"
                    placeholder="Digite o preço do evento">
            </div>
            <div class="form-group">
                <label for="description">Descrição do evento, capricha, chama a galera!</label>
                <textarea name="description" id="description" rows="5" class="form-control"
                    placeholder="Faça a descrição do evento"></textarea>
            </div>
            <br>
            <input type="submit" class="btn card-btn" value="Adicionar Festa">




        </form>
    </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  var mymap = L.map('mapid').setView([0, 0], 2); // Initial coordinates and zoom

  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiYXJha2FraWxhdXJhIiwiYSI6ImNsamVyb2NpYjI1cDEzZm13NTN2dXo0ZjYifQ.7MfHAkgJkxf2jY2UJBOdmA' // Substitua pelo seu token
}).addTo(mymap);

  document.getElementById('location').addEventListener('change', function(event) {
    event.preventDefault();

    var location = document.getElementById('location').value;

    if (location) {
      fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(location)}.json?access_token=pk.eyJ1IjoiYXJha2FraWxhdXJhIiwiYSI6ImNsamVyb2NpYjI1cDEzZm13NTN2dXo0ZjYifQ.7MfHAkgJkxf2jY2UJBOdmA`) // Substitua pelo seu token
        .then(response => response.json())
        .then(data => {
          const [longitude, latitude] = data.features[0].center;

          // Remove any existing marker
          if (mymap.hasLayer(marker)) {
            mymap.removeLayer(marker);
          }

          // Add a new marker to the map at the new location and zoom in
          var marker = L.marker([latitude, longitude]).addTo(mymap);
          mymap.setView([latitude, longitude], 13);
        });
    }
  });
</script>


<?php
require_once("templates/footer.php");
?>