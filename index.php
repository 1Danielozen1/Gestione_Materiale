<?php
// Avvia la session e se l'attributo login non è assegnato riporta alla pagina di login
session_start();
if (!isset($_SESSION['login'])) {
    header("location: ./pages/Login.php");
}
require("./config/db_config.php");
// Setta l'header della pagina
$_POST['titolo'] = 'Magazzino';
$_POST['path'] = '.';
$_POST['percorso'] = "./index.php";
include_once("./templates/Header.php");
include_once("./templates/Navbar.php");
?>


<!-- Cards -->
<div class="container text-center" style="margin-top: 10vh;">
    <div class="row" id="cardDIV">
        <?php
        // Prendo gli oggetti dal database e li inserisco in delle cards
        // Se viene selezionata una categoria vengono mostrati solo gli oggetti desisderati
        if (isset($_GET["id_cat"])) {
            $stmt = $conn->prepare("SELECT * FROM oggetti WHERE categoria = ?");
            $stmt->bind_param('s', $_GET['id_cat']);
        } else {
            $stmt = $conn->prepare("SELECT * FROM oggetti");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            if ($row["prenotabile"] != 0 || $_SESSION['ruolo'] != 1) {
                $descrizione = '"' . $row["descrizione"] . '"';
                if ($_SESSION["ruolo"] != 1) {
                    $bottone = "Dettagli";
                } else {
                    $bottone = "Prenota";
                }

                if ($_SESSION['ruolo'] != 1) {
                    $rem = 25;
                } else {
                    $rem = 21;
                }

                // La funzione "onclick" permette di richiamare una funzione javascript quando viene premuto un bottone.
                echo "<div class='col'> 
                <div class='shadow card mx-auto' style='width: 18rem; min-height: " . $rem . "rem; padding: 2%; padding-bottom:0%; margin-bottom:3%;'>
                <img src='" . $_POST['path'] . "/" . $row["immagine"] . "' class='card-img-top' style = 'max-height: 210px;' alt='" . $row["nome"] . "'>
                <div class='card-body'>
                <b class='card-text'>" . $row["nome"] . "</b><br><br>
                <button type='button' value = '" . $row["id"] . "' onclick = 'idElemento(" . $row["id"] . ", " . $row["categoria"] . "," . '"' . "" . $row["nome"] . "" . '"' . "," . $row["totQuantita"] . "," . $row["prenotabile"] . "," . $_SESSION["ruolo"] . "," . htmlspecialchars($descrizione) . ")' id = 'prenotazione' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#mostaOggetti' style='max-width:100px; min-width:90px'>" . $bottone . "</button>";
                if ($_SESSION['ruolo'] != 1) {
                    echo "<br><br>
                    <a href='./pages/Azioni.php?agg=3&ogg_sing=" . $row["id"] . "' class='link-underline link-underline-opacity-0'>
                        <button type='button' class='btn btn-warning' style='max-width:100px; min-width:90px'>Modifica</button>
                    </a>
                    <a href='./pages/Azioni.php?agg=1' class='link-underline link-underline-opacity-0'>
                        <button type='button' class='btn btn-danger' style='max-width:100px; min-width:90px'>Elimina</button>
                    </a>";
                }
                echo "</div>
                </div>
                </div>";
            }
        }
        $stmt->close();
        $conn->close();
        if ($_SESSION['ruolo'] != 1) {
            echo '<div class="col">
                <div class="mx-auto shadow" id="carta">
                    <a href="./pages/Azioni.php?agg=1" class="link-underline link-underline-opacity-0" id="round-button">
                        <button id="round-button"><h1 style="font-size: 50px; margin-bottom:10px;">+</h1></button>
                    </a>
                </div>
            </div>';
        }
        ?>
    </div>
</div>
<!-- Fine Cards -->

<!-- Modal -->
<div class="modal fade" id="mostaOggetti" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="./checks/AggiungiCarrello.php" method="POST" id="info_oggetto">
            </form>
        </div>
    </div>
</div>
<script>
    let valore;
    let valID;
    let pr;
    // Carica gli elementi interessati all'interno del modal
    function idElemento(id, categoria, nome, quantita, prenotabile, ruolo, descrizione) {
        valID = id;
        clearError("modal-header");
        clearError("modal-body");
        clearError("modal-footer");
        // Prendo tutti gli elementi con id = prenotazione
        valore = document.querySelectorAll('#prenotazione');
        // Ciclo sugli elementi per trovare l'elemento che è stato premuto
        valore.forEach(function(val) {
            if (parseInt(val.value) == valID) {

                //Modal header
                document.getElementById("info_oggetto").insertAdjacentHTML("beforeend",
                    '<div class="modal-header"><h1 class="modal-title fs-5" style="color:black;">' + nome + '</h1><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>');

                if (prenotabile == 1) {
                    pr = 'Si';
                } else {
                    pr = 'No';
                }

                let mostra
                if (ruolo == 1) {
                    mostra = '<input type = "number" style = "width:18%;" value="1" min="1" max="' + quantita + '" name = "quant">'
                } else {
                    mostra = '<input type = "number" style = "display: none; width:18%;" value="1" min="1" max="' + quantita + '" name = "quant">'
                }
                //Modal body
                document.getElementById("info_oggetto").insertAdjacentHTML("beforeend",
                    '<div class="modal-body"><t name="descrizione">Descrizione: ' + descrizione + '</t><br><t name="quantita">Quantità: ' + quantita + '</t><br><t name="prenotabile">Prenotabile: ' + pr + '</t><br><div id = "prd_right"><input type = "text" name = "identificativo" style = "display:none;" value = "' + id + '">' + mostra + '');

                if (ruolo == 1) {
                    //Modal footer
                    document.getElementById("info_oggetto").insertAdjacentHTML("beforeend",
                        '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annula</button><button type="submit" class="btn btn-primary">Aggiungi</button></div>');
                }
                document.getElementById("info_oggetto").insertAdjacentHTML("beforeend", '</div></div>');
            }
        });

    }

    function clearError(cls) {
        let elem = document.getElementsByClassName(cls)
        while (elem.length > 0) {
            elem[0].parentNode.removeChild(elem[0])
        }
    }
</script>

<?php
include_once("./templates/Footer.php");
?>
<!-- Fine Modal -->
<script src="./bootstrap/bootstrap-5.3.3//dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>