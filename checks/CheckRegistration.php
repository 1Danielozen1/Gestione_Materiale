<?php
require("../config/db_config.php");
session_start();
session_unset();
session_destroy();

$errors = array();
$trovato = 0;

// controllo se il i campi inseriti sono uguali a quelli presenti nel database
$stmt = $conn->prepare("SELECT codFiscale 
                            FROM anagrafica 
                            WHERE codFiscale = ?");
$stmt->bind_param("s", $_POST["codF"]);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['codFiscale'] == $_POST["codF"]) {
    array_push($errors, "c='1'");
    $trovato = 1;
}

$stmt = $conn->prepare("SELECT email 
                            FROM anagrafica 
                            WHERE email = ?");
$stmt->bind_param("s", $_POST["email"]);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['email'] == $_POST["email"]) {
    array_push($errors, "e='1'");
    $trovato = 1;
}

$stmt = $conn->prepare("SELECT cellulare 
                            FROM anagrafica 
                            WHERE cellulare = ?");
$stmt->bind_param("s", $_POST["tel"]);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['cellulare'] == $_POST["tel"]) {
    array_push($errors, "cr='1'");
    $trovato = 1;
}


if ($_POST["tipo"] != 1) {
    $stmt = $conn->prepare("SELECT codice 
                                FROM codici 
                                WHERE id = ?");
    $stmt->bind_param("s", $_POST["tipo"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_assoc();

    foreach ($rows as $row) {
        // controllo il ruolo e il codice inserito
        if ($_POST["tipo"] == 2) {
            if ($row != $_POST["codIS"]) {
                array_push($errors, "cis='1'");
                $trovato = 1;
            }
        } else if ($_POST["tipo"] == 3) {
            if ($row != $_POST["codATA"]) {
                array_push($errors, "cis='1'");
                $trovato = 1;
            }
        }
    }
}
// se sono state trovate delle incongruenze riporta alla pagine di registrazione
if ($trovato == 1) {
    $stmt->close();
    $conn->close();
    header("Location: ../pages/Registration.php?" . $errors[0] . "&" . $errors[1] . "&" . $errors[2] . "&" . $errors[3] . "");
} else {
    // se la password è uguale a quella convermata procede a registrare l'utente
    if ($_POST['psw'] == $_POST['confpsw']) {
        $stmt = $conn->prepare("INSERT INTO anagrafica (ruolo, nome, cognome, codFiscale, indirizzo, comune, dataNascita, luogoNascita, email, cellulare, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("sssssssssss", $ruolo, $nome, $cognome, $codFiscale, $indirizzo, $comune, $dataNascita, $luogoNascita, $email, $cellulare, $password);
        $ruolo = $_POST['tipo'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $codFiscale = $_POST['codF'];
        $indirizzo = $_POST['ind'];
        $comune = $_POST['comune'];
        $dataNascita = $_POST['data'];
        $luogoNascita = $_POST['ldn'];
        $email = $_POST['email'];
        $cellulare = $_POST['tel'];
        $password = criptpsw($_POST['psw']);

        $stmt->execute();

        // prendo i valori che mi interessa aggiungere nella session
        $stmt = $conn->prepare("SELECT nome, cognome, id , ruolo
                                    FROM anagrafica 
                                    WHERE codFiscale = ?");
        $stmt->bind_param("s", $codFiscale);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        //avvio la session e chiudo la connessione al database
        session_start();
        $_SESSION['login'] = 'ok';
        $_SESSION['nome'] = $row['nome'];
        $_SESSION['cognome'] = $row['cognome'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['ruolo'] = $row['ruolo'];
        $_SESSION["oggetti"] = array();
        $_SESSION["quantita"] = array();
        $stmt->close();
        $conn->close();
        header("Location: ../index.php");
    } else {
        $stmt->close();
        $conn->close();
        header("Location: ../pages/Registration.php?notequal=1");
    }
}