<form action="../checks/ModificaCategoria.php" method="POST">
    <h2 style="color: black; text-align:center; margin-bottom:4vh; margin-top: 5vh; font-weight: bolder;">MODIFICA CATEGORIA</h2>
    <div id="lrd" class="table-responsive" style=" border: 1px solid black; border-radius: 20px;">
        <table class="table table-borderless" style="margin-bottom: 0%;" id="tabella">
            <?php
            $stmt = $conn->prepare("SELECT id AS 'ID', categoria AS 'Categoria'
                                    FROM categorie");
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
            echo '</tr>
                  </thead>';

            foreach ($rows_dati as $row) {
                echo '<tr>';
                foreach ($fields as $field) {
                    if ($field->name == 'ID') {
                        echo '<td style="display:none;"><input name = "' . $field->name . '[]" value = ' . $row[$field->name] . '></td>';
                    } else {
                        echo '<td><input type="text" class="p-2 form-control" style ="text-align: center; height: 38px; width: 190px;" value="' . $row[$field->name] . '" min="0" name="' . $field->name . '[]" required></td>';
                    }
                }
                echo '</tr>';
            }

            ?>
        </table>
    </div>
    <div id="buttonContainer" style="margin-top: 4vh;">
        <button type="submit" class="btn btn-warning fs-5">Conferma e modifica</button>
    </div>
</form>