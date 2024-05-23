<h2 style="color: black; text-align:center; margin-bottom:4vh; margin-top: 10vh; font-weight: bolder;">RIMUOVI OGGETTO</h2>
<div id="lrd" class="table-responsive" style="border: 1px solid black; border-radius: 20px;">
    <table class="table table-borderless table-striped" style="margin-bottom: 0%;" id="tabella">
        <?php

        // prendo tutti gli oggetti presenti nel database
        $stmt = $conn->prepare("SELECT oggetti.id, oggetti.nome AS 'Nome', categorie.categoria AS 'Categoria'
                                FROM oggetti, categorie
                                WHERE oggetti.categoria = categorie.id");
        $stmt->execute();
        $result = $stmt->get_result();
        $fields = $result->fetch_fields(); // ottengo i nomi delle colonne
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        unset($fields[0]);

        echo '<thead>
                <tr>';


        foreach ($fields as $field) {
            echo '<th scope="col">' . $field->name . '</th>';
        }
        echo '<th scope="col">' . " " . '</th>';
        echo '  </tr>
                </thead>';

        echo '<tbody>';

        // carico i dati nella tabella e rendo i nomi e i congnomi dei link per il filtro sulle persone. Controllo anche se è stata selezionata una categoria
        foreach ($rows as $row) {

            echo '<tr>';
            // carico i dati nella tabella
            foreach ($fields as $field) {
                echo '<td>' . $row[$field->name] . '</td>';
            }
            // cambio l'icona del commento
            if (isset($_GET['vals']) && in_array($row['id'], $_GET['vals'])) {
                echo '<td><a class = "link-underline link-underline-opacity-0" href="../checks/Cestino.php?id=' . $row['id'] . '&rimuovi=1" style = "margin-right: 2%">
                        <button type="button" class="btn">
                        <img src="../icons/trash3-fill-empty.svg" alt="Elimina">
                        </button>
                        </a></td>';
            } else {
                echo '<td><a class = "link-underline link-underline-opacity-0" href="../checks/Cestino.php?id=' . $row['id'] . '" style = "margin-right: 2%">
                        <button type="button" class="btn">
                        <img src="../icons/trash3-fill.svg" alt="Elimina">
                        </button>
                        </a></td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        ?>
    </table>
</div>

<?php
// se vals è settata, mostro il bottne di conferma
if (isset($_GET['vals'])) {
    $s = '';
    foreach ($_GET['vals'] as $val) {
        $s = $s . "&vals[]=" . $val;
    }

    echo '<div id="buttonContainer" style = "margin-top: 2%;">
            <a href="../checks/Cestino.php?conf=1' . $s . '">
            <button type="submit" class="btn btn-danger fs-5">Conferma ed elimina</button>
            </a>
            </div>';
}
?>