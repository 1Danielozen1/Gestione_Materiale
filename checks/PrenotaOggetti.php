<?php
session_start();
require("../config/db_config.php");
$count = 0;

foreach ($_SESSION["oggetti"] as $ogg) {
    $n_prenotati = 0;
    $prenot = 1;
    // prendo l'oggetto che l'utente vuole prenotare
    $stmt = $conn->prepare("SELECT totQuantita, prenotabile
                                FROM oggetti
                                WHERE id = ?");
    $stmt->bind_param("i", $ogg);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // controllo se la quantità presente nel database è inferiore o uguale a quella prenotata
    if ($row["totQuantita"] <= $_SESSION["quantita"][$count]) {
        $n_prenotati = $row["totQuantita"];
        $n_quant = 0;
        $prenot = 0;
    } else {
        $n_prenotati = $_SESSION["quantita"][$count];
        $n_quant =  $row["totQuantita"] - $n_prenotati;

        if ($n_quant <= 0) {
            $prenot = 0;
        }
    }

    $stmt = $conn->prepare("UPDATE oggetti
                                SET oggetti.totQuantita = ?,
                                    oggetti.prenotabile = ?
                                WHERE oggetti.id = ?");
    $stmt->bind_param("iii", $n_quant, $prenot, $ogg);
    $stmt->execute();

    // Inserisco nella tabella "noleggio_materiali" le informazioni dell'oggetto prenotato
    $stmt = $conn->prepare("INSERT INTO noleggio_materiali (idOggetto, idUtente, quantita) VALUES (?,?,?);");
    $stmt->bind_param("iii", $ogg, $_SESSION["id"], $n_prenotati);
    $stmt->execute();
    $count++;
}

$stmt->close();
$conn->close();

$_SESSION["oggetti"] = array();
$_SESSION["quantita"] = array();
header("Location: ../pages/OggettiPrenotati.php");
