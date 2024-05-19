<?php
session_start();
$count = 0;
$oggetti = array();
$quantita = array();

# Elimina tutti gli oggetti con l'ID specificato
foreach ($_SESSION["oggetti"] as $ogg) {
    if ($ogg == $_GET["id"]) {
        unset($_SESSION["oggetti"][$count]);
        unset($_SESSION["quantita"][$count]);
    } else {
        array_push($oggetti, $ogg);
        array_push($quantita, $_SESSION["quantita"][$count]);
    }
    $count++;
}

// Resetto gli array della session e carico gli array creati precedentemente
$_SESSION["oggetti"] = array();
$_SESSION["quantita"] = array();
$_SESSION["oggetti"] = $oggetti;
$_SESSION["quantita"] = $quantita;

header("Location: ../pages/Carrello.php");
