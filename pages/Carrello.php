<?php
// Avvia la session e se l'attributo login non è assegnato riporta alla pagina di login
session_start();
if (!isset($_SESSION['login'])) {
    header("location: ./Login.php");
}
require("../config/db_config.php");

// Setta l'header e la navbar della pagina
$_POST['titolo'] = 'Carrello';
$_POST['path'] = '..';
$_POST['percorso'] = "./Carrello.php";
include_once("../templates/Header.php");
include_once("../templates/Navbar.php");
?>


<h2 class="card-header" style="font-weight: bolder; text-align: center; margin-top: 2%;">OGGETTI NEL CARRELLO</h2>
<?php
$count = 0;
// cilo sugli oggetti inseriti nel carrello
if (count($_SESSION["oggetti"]) > 0) {
    foreach ($_SESSION["oggetti"] as $ogg) {
        $stmt = $conn->prepare("SELECT * FROM oggetti WHERE id = ?");
        $stmt->bind_param('s', $ogg);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (isset($_GET["id_cat"])) {
            // Se viene selezionata una categoria mostra solo gli elementi presenti in quella categoria
            if ($row["categoria"] == $_GET["id_cat"]) {
                elementiCarrelloCard($row, $count);
            }
        } else {
            // mostra gli elementi nel carrello
            elementiCarrelloCard($row, $count);
        }

        $count++;
    }
} else {
    echo '<div class = "center-div">
        <img src="../img/empty-bag.svg" alt="Carrello vuoto"><br><br>
            <h5>IL CARRELLO È VUOTO</h5>
        </div>';
}
$stmt->close();
$conn->close();

// Funzione che crea la card dell'elemento presente nel carrello
function elementiCarrelloCard($row, $count)
{
    echo '<div class="card mb-3" style="max-width: 540px; background-color: white;" id = "prenotati">
        <div class="row g-0">
        <div class="col-md-4">
          <img src="'.$_POST['path'].'/' . $row["immagine"] . '" style = "margin-top: 10%; margin-left: 15%" class="img-fluid rounded-start" alt="' . $row['nome'] . '">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title" style = "font-weight: bolder;">' . $row['nome'] . '</h5>
            <p class="card-text">' . $row["descrizione"] . '</p>
            <p class="card-text"><small class="text-body-secondary">Quantità: ' . $_SESSION['quantita'][$count] . '</small></p>
            <a href= "../checks/RimuoviCarrello.php?id=' . $row["id"] . '">
            <button type="submit" id = "elimina" class="btn btn-danger" data-bs-toggle="modal">Rimuovi</button>
            </a>
          </div>
        </div>
      </div>
      </div>';
}
?>

<?php
// Pulsante di conferma della prenotazione
if (count($_SESSION["oggetti"]) > 0) {
    echo '<div id = "prd" style = "margin-bottom: 3%">
            <a href= "../checks/PrenotaOggetti.php">
            <button type="submit" id = "prenota" class="btn btn-success" data-bs-toggle="modal">Conferma e prenota</button>
            </a>
            </div>';
}
?>

<script src="../bootstrap/bootstrap-5.3.3//dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>