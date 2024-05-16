<?php
// Avvia la session e se l'attributo login non è assegnato riporta alla pagina di login
session_start();
if (!isset($_SESSION['login'])) {
    header("location: ./pages/Login.php");
}
require("../config/db_config.php");

// Setta l'header della pagina
$_POST['titolo'] = 'Dati';
$_POST['path'] = '..';
$_SESSION['no_cat'] = 'si';
$_POST['percorso'] = "./TabellaDati.php";
include_once("../templates/Header.php");
include_once("../templates/Navbar.php");
?>

<!-- TABELLA -->
<div id="lrd" style="margin-top: 2%; border: 1px solid black; border-radius: 20px;">
    <table class="table table-borderless table-striped" style="margin-bottom: 0%;">
        <?php
        // Controllo se la variabile tabella è settatta altrimenti la creo e controllo se è stato selezionato un filtro
        if (!isset($_SESSION['tabella'])) {
            header("location: ../checks/MostraPersona.php");
        }

        // Carico tutti i dati nella tabella
        echo '<thead>
                    <tr>';
        $count = 0;
        foreach ($_SESSION['fields'] as $field) {
            // Sistemo la grafica negli angoli in alto
            if ($count == 0) {
                echo '<th scope="col" style = "border-radius: 20px 0px 0px 0px;">' . $field->name . '</th>';
            } else if ($count == count($_SESSION['fields']) - 1) {
                echo '<th scope="col" style = "border-radius: 0px 20px 0px 0px;">' . $field->name . '</th>';
            } else {
                echo '<th scope="col">' . $field->name . '</th>';
            }
            $count++;
        }

        echo '  </tr>
                    </thead>';

        echo '<tbody>';

        $dimensione_totale = (count($_SESSION['rows']) * count($_SESSION['fields'])) - 1;
        $count = 0;

        // carico i dati nella tabella e rendo i nomi e i congnomi dei link per il filtro sulle persone. Controllo anche se è stata selezionata una categoria
        foreach ($_SESSION['rows'] as $row) {
            echo '<tr>';
            foreach ($_SESSION['fields'] as $field) {
                if ($field->name == "Nome" || $field->name == "Cognome") {
                    $riferimento = '<a class = "link-offset-2 link-underline link-underline-opacity-0" id="link_nome" href="../checks/MostraPersona.php?id_u=' . $row['id'] . '">' . $row[$field->name] . '</a>';
                } else {
                    $riferimento = $row[$field->name];
                }

                // Sistemo la grafica negli angoli in basso
                if ($count == $dimensione_totale) {
                    echo '<td style = "border-radius: 0px 0px 20px 0px;">' . $riferimento . '</td>';
                } else if ($count == $dimensione_totale - (count($_SESSION['fields']) - 1)) {
                    echo '<td style = "border-radius: 0px 0px 0px 20px;">' . $riferimento . '</td>';
                } else {
                    echo '<td>' . $riferimento . '</td>';
                }
                $count++;
            }
            echo '</tr>';
        }
        echo '</tbody>';
        //elimino la variabile tabella
        unset($_SESSION['tabella']);
        unset($_SESSION['no_cat']);
        ?>
    </table>
</div>
<!-- FINE TABELLA -->

<!-- Resetto la tabella richiamando la stessa pagina visto che ho eliminato la variabile 'tabella' precedentemente -->
<div id="lrd" style="margin-top: 2%;">
    <a class="btn btn-secondary" href="./TabellaDati.php" role="button">Ripristina</a>
</div>

<script src="../bootstrap/bootstrap-5.3.3//dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>