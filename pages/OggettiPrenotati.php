<?php
// Avvia la session e se l'attributo login non è assegnato riporta alla pagina di login
session_start();
if (!isset($_SESSION['login'])) {
    header("location: ./pages/Login.php");
}
require("../config/db_config.php");

// Setta l'header della pagina
$_POST['titolo'] = 'Oggetti Prenotati';
$_POST['path'] = '..';
$_POST['percorso'] = "./OggettiPrenotati.php";
include_once("../templates/Header.php");
include_once("../templates/Navbar.php");


// Ottengo tutti gli oggetti prenotati da un determinato utente
$stmt = $conn->prepare("SELECT oggetti.nome, oggetti.categoria, noleggio_materiali.*, oggetti.immagine
                            FROM noleggio_materiali, oggetti
                            WHERE idUtente = ?
                                AND noleggio_materiali.idOggetto = oggetti.id");
$stmt->bind_param("s", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_all(MYSQLI_ASSOC);

echo '<h2 class="card-header"style = "font-weight: bolder; text-align: center; margin-top: 2%;">OGGETTI PRENOTATI</h2>';

// Controllo se l'utente ha degli oggetti prenotati
// Controllo se gli elementi prenotati non sono già stati restituiti
if (count($rows) > 0) {
    foreach ($rows as $row) {
        if (!isset($row["dataFine"])) {
            if (isset($_GET["id_cat"])) {
                if ($_GET['id_cat'] == $row["categoria"]) {
                    elementiPrenotatiCard($row);
                    $presente = 1;
                }
            } else {
                elementiPrenotatiCard($row);
                $presente = 1;
            }
        } else {
            $cont = 1;
        }
    }
} else {
    $no_row = 1;
}

// Se uno di questi valori è settato scrive che non sono presenti elementi prenotati
if ((isset($cont) && (!isset($presente))) || isset($no_row)) {
    echo '<div class="center-div">
            <img src="../img/empty-bag.svg" alt="Carrello vuoto"><br><br>
                <h5>NESSUN OGGETTO PRENOTATO</h5>
            </div>';
}

$stmt->close();
$conn->close();

// Funzione che crea la card degli elementi prenotati dall'utente
function elementiPrenotatiCard($row)
{
    echo '<div class="card mb-3" style="max-width: 540px; background-color: white;" id = "prenotati">
    <div class="row g-0">
    <div class="col-md-4">
      <img src="' . $_POST['path'] . '/' . $row["immagine"] . '" style = "margin-top: 10%; margin-left: 15%" class="img-fluid rounded-start" alt="' . $row['nome'] . '">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title" style = "font-weight: bolder;">' . $row['nome'] . '</h5>
        <t>Noleggiato il ' . $row['dataInizio'] . '</t><br>
        <p class="card-text"><small class="text-body-secondary">Quantità: ' . $row['quantita'] . '</small></p>
        <a href= "../checks/RestituisciOggetto.php?&noleggio=' . $row["idNoleggio"] . '">
        <button type="button" class="btn btn-warning btn-outline-secondary" style="margin-top: 2%; color:black;">Restitutisci</button>
        </a>
      </div>
    </div>
  </div>
  </div>';
}
?>

<script src="../bootstrap/bootstrap-5.3.3//dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>