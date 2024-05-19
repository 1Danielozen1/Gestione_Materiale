<?php
session_start();
require("../config/db_config.php");

if ($_SESSION['ruolo'] == 1) {
    // controllo se il tipo di $_POST["quant"] sia un integer
    $tipo = gettype($_POST["quant"]);
    if ($tipo == "string" && $_POST["quant"] == "") {
        array_push($_SESSION["quantita"], 1);
    } else {
        array_push($_SESSION["quantita"], $_POST["quant"]);
    }

    array_push($_SESSION["oggetti"], $_POST["identificativo"]);

    $cont = 0;
    $temp = 0;
    $oggetti = array();
    $quantita = array();

    // controlla se sono presenti elementi doppi nel carrello, se li trova ne somma le quantità.
    foreach (array_unique($_SESSION["oggetti"]) as $ogg) {
        $temp = 0;
        $cont = 0;
        $stmt = $conn->prepare("SELECT id, totQuantita
                                FROM oggetti
                                WHERE id = ?");

        $stmt->bind_param("i", $ogg);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // sommo le quantità
        foreach ($_SESSION["oggetti"] as $og) {
            if ($ogg == $og) {
                $temp += $_SESSION['quantita'][$cont];
            }
            $cont++;
        }
        // Controllo se la quantità prenotata non superi quella massima prenotabile
        if ($temp >= $row['totQuantita']) {
            $temp = $row['totQuantita'];
        }

        // $row['totQuantita'] != 0 serve solo nel caso qualche genio si mette a smanettare con l'HTML e riesce ad inserire nel carrello un oggetto con 0 elementi prenotati
        if ($temp != 0) {
            array_push($oggetti, $ogg);
            array_push($quantita, $temp);
        }
    }

    // Resetto gli array della session e carico gli array creati precedentemente
    $_SESSION["oggetti"] = array();
    $_SESSION["quantita"] = array();
    $_SESSION["oggetti"] = $oggetti;
    $_SESSION["quantita"] = $quantita;

    $stmt->close();
    $conn->close();
}

header("Location: ../index.php");
