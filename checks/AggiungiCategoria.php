<?php
require("../config/db_config.php");

$stmt = $conn->prepare("SELECT categoria 
                        FROM categorie
                        WHERE categoria LIKE ?");

$stmt->bind_param("s", $_POST["nome_categoria"]);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Controllo se la categoria esiste già
if (isset($row)) {
    $stmt->close();
    $conn->close();
    header("location: ../pages/Aggiungi.php?agg=2&error=1");
} else {
    $stmt = $conn->prepare("INSERT INTO categorie (categoria) VALUES (?)");

    $stmt->bind_param("s", $_POST["nome_categoria"]);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    header("location: ../pages/Aggiungi.php?agg=2&success=1");
}
