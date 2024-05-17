<?php
require("../config/db_config.php");

// Controllo se la quantità è corretta
if ($_POST['quantita'] == 0 || !isset($_POST['quantita']) || $_POST['quantita'] == "") {
    header("location: ../pages/Aggiungi.php?agg=1&error=1");
} else {
    $prenotabile = 1;
}

// controllo se il type dell'immagine è tra quelli consentiti
$type_consentiti = array("image/png", "image/jpeg", "image/jpg", "image/PNG");
$type = $_FILES["immagine"]["type"];
if (!in_array($type, $type_consentiti)) {
    header("location: ../pages/Aggiungi.php?agg=1&error=2");
} else {
    // prendo il nome dell'immagine e la carico nella cartella img
    $nome = $_FILES["immagine"]["name"];
    $path_img = "/img/$nome";
    move_uploaded_file($_FILES["immagine"]["tmp_name"], "../img/$nome");

    $stmt = $conn->prepare("INSERT INTO oggetti (categoria, nome, totQuantita , descrizione, prenotabile, immagine) VALUES (?,?,?,?,?,?)");

    $stmt->bind_param("isssis", $_POST["nome_categoria"], $_POST["nome_oggetto"], $_POST["quantita"], $_POST["descrizione"], $prenotabile, $path_img);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    header("location: ../pages/Aggiungi.php?agg=1");
}