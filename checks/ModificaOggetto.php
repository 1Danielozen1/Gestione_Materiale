<?php
require("../config/db_config.php");
$cont = 0;

// modifico gli oggetti
foreach ($_POST['ID'] as $id) {
    $stmt = $conn->prepare("UPDATE oggetti
                            SET categoria=?, nome=?, totQuantita=?, descrizione=?, prenotabile=?
                            WHERE id = $id");
    $stmt->bind_param("isisi", $_POST['Categoria'][$cont], $_POST['Nome'][$cont], $_POST['Quantità'][$cont], $_POST['Descrizione'][$cont], $_POST['Prenotabile'][$cont]);
    $stmt->execute();
    $cont++;
}

$stmt->close();
$conn->close();

header("location: ../pages/Azioni.php?agg=3");
