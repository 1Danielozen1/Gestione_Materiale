<form action="../checks/ModificaOggetto.php" method="POST">
    <h2 style="color: black; text-align:center; margin-bottom:4vh; margin-top: 5vh; font-weight: bolder;">MODIFICA OGGETTO</h2>
    <div id="lrd" class="table-responsive" style=" border: 1px solid black; border-radius: 20px;">
        <table class="table table-borderless" style="margin-bottom: 0%;" id="tabella">
            <?php

            // prendo tutti gli oggetti presenti nel database
            $stmt = $conn->prepare("SELECT oggetti.id AS 'ID', oggetti.nome AS 'Nome', categorie.categoria AS 'Categoria', oggetti.totQuantita AS 'Quantità', oggetti.descrizione AS 'Descrizione', oggetti.prenotabile AS 'Prenotabile'
                                FROM oggetti, categorie
                                WHERE oggetti.categoria = categorie.id
                                ORDER BY oggetti.id");
            $stmt->execute();
            $result = $stmt->get_result();
            $fields = $result->fetch_fields(); // ottengo i nomi delle colonne
            $rows_dati = $result->fetch_all(MYSQLI_ASSOC);

            echo '<thead>
                <tr>';

            // Stampo le tabelle tranne quella con l'ID
            foreach ($fields as $field) {
                if ($field->name != 'ID') {
                    echo '<th scope="col">' . $field->name . '</th>';
                }
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
                        <select class="form-select" style="width: 180px" name="' . $field->name . '[]">';
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
                    <select class="form-select" name="' . $field->name . '[]">';
                        if ($row[$field->name] == 1) {
                            echo '<option value="1" selected>Si</option>
                              <option value="0">No</option>';
                        } else {
                            echo '<option value="1">Si</option>
                        <option value="0" selected>No</option>';
                        }
                        echo  '</select></td>';

                        // inserisco una colonna invisibile con l'ID
                    } elseif ($field->name == 'ID') {

                        echo '<td style="display:none;"><input name = "' . $field->name . '[]" value = ' . $row[$field->name] . '></td>';

                        // Inserisco la quantià con un tipo di input diverso
                    } elseif ($field->name == 'Quantità') {

                        echo '<td><input type="number" class="p-2 form-control" style ="text-align: center; height: 38px; width: 160px;" value="' . $row[$field->name] . '" min="0" name="' . $field->name . '[]" required></td>';
                        
                        // Inserisco tutti gli altri campi con textarea
                    } else {

                        echo '<td><textarea name = "' . $field->name . '[]" class = "form-control" style ="text-align: center; max-height: 250px; height: 38px; width: 160px;">' . $row[$field->name] . '</textarea></td>';
                    }
                }
                echo '</tr>';
            }
            echo '</tbody>';
            ?>
        </table>
    </div>
    <div id="buttonContainer" style="margin-top: 4vh;">
        <button type="submit" class="btn btn-warning fs-5">Conferma e modifica</button>
    </div>
</form>