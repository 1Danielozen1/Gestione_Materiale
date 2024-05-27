<?php
session_start();
require("../config/db_config.php");

// prende le informazioni dell'oggetto che l'utente vuole restituire 
$stmt = $conn->prepare("SELECT *
                        FROM noleggio_materiali
                        WHERE idNoleggio = ?
                            AND idUtente = ?");
$stmt->bind_param("ii", $_GET['noleggio'], $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$row_materiali = $result->fetch_assoc();

// Se l'oggetto esiste procede a inserire la data di consegna all'oggetto prenotato e ripristina la quantità dell'oggetto preso
if (isset($row_materiali) && !isset($row_materiali["dataFine"])) {
    $stmt = $conn->prepare("UPDATE noleggio_materiali
                            SET dataFine = CURDATE()
                            WHERE idNoleggio = ?
                                AND idUtente = ?");
    $stmt->bind_param("ii", $_GET['noleggio'], $_SESSION['id']);
    $stmt->execute();


    $stmt = $conn->prepare("UPDATE oggetti
                            SET oggetti.prenotabile = 1,
                                oggetti.totQuantita = oggetti.totQuantita + ?
                            WHERE oggetti.id = ?");
    $stmt->bind_param("ii", $row_materiali['quantita'], $row_materiali['idOggetto']);
    $stmt->execute();
}

$stmt->close();
$conn->close();


header("Location: ../pages/OggettiPrenotati.php");
?>