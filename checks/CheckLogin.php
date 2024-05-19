<?php
require("../config/db_config.php");
session_start();
session_unset();
session_destroy();

$stmt = $conn->prepare("SELECT email, password, nome, cognome, id, ruolo
                            FROM anagrafica
                            WHERE email = ?
                            AND password = ?");

$stmt->bind_param("ss", $_POST["email"], $password);
$password = criptpsw($_POST['psw']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// controllo se la select ha restituito i valori interessati altrimenti ritorno al login
if (!isset($row['email']) || !isset($row['password'])) {
    echo $row['password'];
    echo $row['email'];
    $stmt->close();
    $conn->close();
    header("Location: ../pages/Login.php?error=1");
} else {
    $stmt->close();
    $conn->close();
    session_start();
    $_SESSION['login'] = 'ok';
    $_SESSION['nome'] = $row['nome'];
    $_SESSION['cognome'] = $row['cognome'];
    $_SESSION['ruolo'] = $row['ruolo'];
    $_SESSION['id'] = $row['id'];

    $_SESSION["oggetti"] = array();
    $_SESSION["quantita"] = array();
    header("Location: ../index.php");
}
