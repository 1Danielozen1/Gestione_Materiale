<?php
require("../config/db_config.php");
$cont = 0;

// modifico la categoria
foreach ($_POST['ID'] as $id) {
    // controllo se la categoria è rimasta invariato o meno
    $stmt = $conn->prepare("SELECT categoria AS 'Categoria'
                            FROM categorie
                            WHERE categorie.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows_dati = $result->fetch_assoc();

    // se la categoria è modificata faccio l'update
    if ($rows_dati['Categoria'] != $_POST['Categoria'][$cont]) {
        $stmt = $conn->prepare("UPDATE categorie
                                SET categoria=?
                                WHERE id = $id");
        $stmt->bind_param("s", $_POST['Categoria'][$cont]);
        $stmt->execute();
    }
    $cont++;
}

$stmt->close();
$conn->close();

header("location: ../pages/Azioni.php?agg=4");
?>