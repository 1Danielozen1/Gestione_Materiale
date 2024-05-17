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
$_POST['percorso'] = "./TabellaDati.php";
include_once("../templates/Header.php");
include_once("../templates/Navbar.php");
?>

<!-- TABELLA  -->
<div id="lrd" style="margin-top: 2%; border: 1px solid black; border-radius: 20px;">
    <table class="table table-borderless table-striped" style="margin-bottom: 0%;" id="tabella">
        <?php
        if (isset($_GET['resetta'])) {
            unset($_SESSION['tabella']);
        }
        // Controllo se la variabile tabella è settatta altrimenti la creo e controllo se è stato selezionato un filtro
        if (!isset($_SESSION['tabella'])) {
            header("location: ../checks/MostraPersona.php");
        }

        echo '<thead>
                <tr>';
        $count = 0;
        foreach ($_SESSION['fields'] as $field) {
            // Sistemo la grafica negli angoli in alto
            if ($count == 0) {
                echo '<th scope="col">' . $field->name . '</th>';
            } else if ($count == count($_SESSION['fields']) - 1) {
                echo '<th scope="col">' . $field->name . '</th>';
            } else {
                echo '<th scope="col">' . $field->name . '</th>';
            }
            $count++;
        }

        echo '  </tr>
                </thead>';

        echo '<tbody>';

        // carico i dati nella tabella e rendo i nomi e i congnomi dei link per il filtro sulle persone. Controllo anche se è stata selezionata una categoria
        foreach ($_SESSION['rows'] as $row) {
            if (isset($_GET['id_cat'])) {
                if ($row['categoria'] == $_GET['id_cat']) {
                    echo '<tr>';
                }
            } else {
                echo '<tr>';
            }
            // carico i dati nella tabella
            foreach ($_SESSION['fields'] as $field) {
                if (isset($_GET['id_cat'])) {
                    if ($row['categoria'] == $_GET['id_cat']) {
                        caricaDati($field, $row);
                    }
                } else {
                    caricaDati($field, $row);
                }
            }
            if (isset($_GET['id_cat'])) {
                if ($row['categoria'] == $_GET['id_cat']) {
                    echo '</tr>';
                }
            } else {
                echo '</tr>';
            }
        }
        echo '</tbody>';

        // Aggiunge l'html della tabella
        function caricaDati($field, $row)
        {
            if ($field->name == "Nome" || $field->name == "Cognome") {
                if (isset($_GET['id_cat'])) {
                    $riferimento = '<a class = "link-offset-2 link-underline link-underline-opacity-0" id="link_nome" href="../checks/MostraPersona.php?id_u=' . $row['id'] . '&id_cat=' . $_GET['id_cat'] . '">' . $row[$field->name] . '</a>';
                } else {
                    $riferimento = '<a class = "link-offset-2 link-underline link-underline-opacity-0" id="link_nome" href="../checks/MostraPersona.php?id_u=' . $row['id'] . '">' . $row[$field->name] . '</a>';
                }
            } else {
                $riferimento = $row[$field->name];
            }
            echo '<td>' . $riferimento . '</td>';
        }
        ?>
    </table>
</div>
<!-- FINE TABELLA -->

<!-- Resetto la tabella richiamando la stessa pagina visto che ho eliminato la variabile 'tabella' precedentemente -->
<div id="lrd" style="margin-top: 2%;">
    <a class="btn btn-secondary" href="./TabellaDati.php?resetta=1" role="button">Ripristina</a>
</div>

<script src="../bootstrap/bootstrap-5.3.3//dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>