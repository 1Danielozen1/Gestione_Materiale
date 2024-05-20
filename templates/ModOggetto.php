<form id="lrd" style="margin-top: 2%; border: 1px solid black; border-radius: 20px;" action="../checks/AggiungiOggetto.php" method="POST">

    <table class="table table-borderless" style="margin-bottom: 0%;" id="tabella">
        <?php

        // prendo tutti gli oggetti presenti nel database
        $stmt = $conn->prepare("SELECT oggetti.nome AS 'Nome', categorie.categoria AS 'Categoria', oggetti.totQuantita AS 'Quantità', oggetti.descrizione AS 'Descrizione', oggetti.prenotabile AS 'Prenotabile'
                                FROM oggetti, categorie
                                WHERE oggetti.categoria = categorie.id");
        $stmt->execute();
        $result = $stmt->get_result();
        $fields = $result->fetch_fields(); // ottengo i nomi delle colonne
        $rows_dati = $result->fetch_all(MYSQLI_ASSOC);

        echo '<thead>
                <tr>';


        foreach ($fields as $field) {
            echo '<th scope="col">' . $field->name . '</th>';
        }
        echo '  </tr>
                </thead>';

        echo '<tbody>';

        $stmt = $conn->prepare("SELECT *
                                FROM categorie");
        $stmt->execute();
        $result = $stmt->get_result();
        $rows_cat = $result->fetch_all(MYSQLI_ASSOC);

        // carico i dati nella tabella
        foreach ($rows_dati as $row) {
            echo '<tr>';
            foreach ($fields as $field) {

                // se il nome della colonna è uguale a Categoria creo una select con i valori presenti nel database
                if ($field->name == 'Categoria') {

                    echo '<td>
                        <select class="form-select" name="' . $field->name . '">';
                    foreach ($rows_cat as $row_cat) {
                        if ($row_cat['categoria'] == $row[$field->name]) {
                            echo '<option value="' . $row_cat['id'] . '" selected>' . $row_cat['categoria'] . '</option>';
                        } else {
                            echo '<option value="' . $row_cat['id'] . '">' . $row_cat['categoria'] . '</option>';
                        }
                    }
                    echo  '</select></td>';

                // se il nome della colonna è uguale a Prenotabile creo una select con i valori presenti nel database
                } elseif ($field->name == 'Prenotabile') {

                    echo '<td>
                    <select class="form-select" name="' . $field->name . '">';
                    if ($row[$field->name] == 1) {
                        echo '<option value="1" selected>Si</option>
                              <option value="0">No</option>';
                    } else {
                        echo '<option value="1">Si</option>
                        <option value="0" selected>No</option>';
                    }
                    echo  '</select></td>';
                } else {

                    echo '<td><input type="text" name = "' . $field->name . '" class = "form-control" style ="text-align: center; max-width: 160px" value = "' . $row[$field->name] . '"></td>';
                }
            }
            echo '</tr>';
        }
        echo '</tbody>';
        ?>
    </table>

</form>

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