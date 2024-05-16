<?php
session_start();
require("../config/db_config.php");

// creo le query in base ai valori presenti nella GET
if (isset($_GET['id_u'])) {
    $query = "SELECT anagrafica.id, anagrafica.nome AS 'Nome', anagrafica.cognome AS 'Cognome', oggetti.nome AS 'Oggetto', noleggio_materiali.dataInizio AS 'Data Inizio', noleggio_materiali.dataFine AS 'Data Fine', noleggio_materiali.quantita AS 'Quantità'
                FROM anagrafica, oggetti, noleggio_materiali
                WHERE anagrafica.id = noleggio_materiali.idUtente
                AND anagrafica.id = ?
                AND oggetti.id = noleggio_materiali.idOggetto";
} else {
    $query = "SELECT anagrafica.id, anagrafica.nome AS 'Nome', anagrafica.cognome AS 'Cognome', oggetti.nome AS 'Oggetto', noleggio_materiali.dataInizio AS 'Data Inizio', noleggio_materiali.dataFine AS 'Data Fine', noleggio_materiali.quantita AS 'Quantità'
                FROM anagrafica, oggetti, noleggio_materiali
                WHERE anagrafica.id = noleggio_materiali.idUtente
                AND oggetti.id = noleggio_materiali.idOggetto";
}


$stmt = $conn->prepare($query);

// In base a quello che è stato selezionato nel GET faccio i relativi bind
if (isset($_GET['id_u'])) {
    $stmt->bind_param("i", $_GET['id_u']);
}

$stmt->execute();
$result = $stmt->get_result();
$fields = $result->fetch_fields(); // ottengo i nomi delle colonne
$rows = $result->fetch_all(MYSQLI_ASSOC);
unset($fields[0]);

// carico tutti i risultati che ottengo nella session e setto la variabile 'tabella'
$_SESSION['fields'] = $fields;
$_SESSION['rows'] = $rows;
$_SESSION['tabella'] = 'ok';
$stmt->close();
$conn->close();

header('location: ../pages/TabellaDati.php');