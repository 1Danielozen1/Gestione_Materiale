<?php
require("../config/db_config.php");
$cont = 0;

foreach ($_POST['ID'] as $id) {
    // controllo se l'oggetto è rimasto invariato o meno
    $stmt = $conn->prepare("SELECT oggetti.nome AS 'Nome', oggetti.categoria AS 'Categoria' , oggetti.totQuantita AS 'Quantità', oggetti.descrizione AS 'Descrizione', oggetti.prenotabile AS 'Prenotabile'
                            FROM oggetti
                            WHERE oggetti.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $fields = $result->fetch_fields(); // ottengo i nomi delle colonne
    $rows_dati = $result->fetch_assoc();
    $trovato = 0;
    foreach ($fields as $field) {
        // se l'oggetto è stato modificato fa l'update una sola volta
        if (($rows_dati[$field->name] != $_POST[$field->name][$cont]) && ($trovato == 0)) {
            $trovato = 1;
            $stmt = $conn->prepare("UPDATE oggetti
                                    SET categoria=?, nome=?, totQuantita=?, descrizione=?, prenotabile=?
                                    WHERE id = $id");
            $stmt->bind_param("isisi", $_POST['Categoria'][$cont], $_POST['Nome'][$cont], $_POST['Quantità'][$cont], $_POST['Descrizione'][$cont], $_POST['Prenotabile'][$cont]);
            $stmt->execute();
        }
    }
    $cont++;
}

$stmt->close();
$conn->close();

header("location: ../pages/Azioni.php?agg=3");
