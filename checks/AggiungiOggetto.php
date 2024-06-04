<?php
require("../config/db_config.php");

// Controllo se la quantità è corretta
if ($_POST['quantita'] == 0 || !isset($_POST['quantita']) || $_POST['quantita'] == "") {
    header("location: ../pages/Azioni.php?agg=1&error=1");
} else {
    $prenotabile = 1;
}

$stmt = $conn->prepare("SELECT nome 
                        FROM oggetti 
                        WHERE nome LIKE ?");

$stmt->bind_param("s", $_POST["nome_oggetto"]);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Controllo se l'oggetto esiste già
if (isset($row)) {
    $stmt->close();
    $conn->close();
    header("location: ../pages/Azioni.php?agg=1&error=3");
} else {
    // controllo se il type dell'immagine è tra quelli consentiti
    $type_consentiti = array("image/png", "image/jpeg", "image/jpg", "image/PNG");
    $type = $_FILES["immagine"]["type"];
    if (!in_array($type, $type_consentiti)) {
        $stmt->close();
        $conn->close();
        header("location: ../pages/Azioni.php?agg=1&error=2");
    } else {
        $stmt = $conn->prepare("SELECT MAX(id) AS 'idMax'
                                FROM oggetti");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // estensione file
        $array_est = explode("/", $_FILES["immagine"]["type"]);
        $est = $array_est[count($array_est) - 1];

        // nome file con estensione
        $_FILES["immagine"]["name"] = $row['idMax'] + 1;
        $nome = $_FILES["immagine"]["name"] . "." . $est;

        // percorso file
        $path_img = "/img/$nome";

        // Salvo il file nella cartella img
        move_uploaded_file($_FILES["immagine"]["tmp_name"], "../img/$nome");

        $stmt = $conn->prepare("INSERT INTO oggetti (categoria, nome, totQuantita , descrizione, prenotabile, immagine) VALUES (?,?,?,?,?,?)");

        $stmt->bind_param("isssis", $_POST["nome_categoria"], $_POST["nome_oggetto"], $_POST["quantita"], $_POST["descrizione"], $prenotabile, $path_img);
        $stmt->execute();

        $stmt->close();
        $conn->close();
        header("location: ../index.php");
    }
}
